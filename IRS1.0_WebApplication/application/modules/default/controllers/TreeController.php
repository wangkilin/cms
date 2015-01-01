<?php
/**
 * $Rev: 2622 $
 * $LastChangedDate: 2010-06-21 17:37:27 +0800 (Mon, 21 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: TreeController.php 2622 2010-06-21 09:37:27Z junzhang $
 */

/**
 *
 */
class TreeController extends Zend_Controller_Action
{
    const OPERATION_FAIL = 'NOK';

    /**
     * Mapping on API methods
     *
     * @var array
     */
    private $_apiMaps = array(
        'Query' => 'Tree.GetByLabelPart',
        'Count' => 'Tree.Count',
        'GetAll' => 'Tree.GetByCustomer'
    );

    /**
     * Whether or nor the current role Is SUPER_ADMIN
     *
     * @var boolean
     */
    private $_isSuperAdmin = false;

    /**
     * While rendering the tree node, record the rendered NodeId
     *
     * @var array
     */
    private static $_renderedNodeIds = array();

    /**
     * Initialization
     *
     * @return void
     */
    public function init()
    {
        // disable layout for ajax
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->view->layout()->disableLayout();
        }

        $request = $this->getRequest();
        $customerAccountId = $request->getParam('CustomerAccountId');

        if (SwIRS_Web_Request::isSuperAdmin($request)) {
            $this->_isSuperAdmin = true;
            $this->_apiMaps = array(
                'Query' => 'Tree.GetTemplatesByLabelPart',
                'Count' => 'Tree.CountTemplates',
                'GetAll' => 'Tree.GetTemplates'
            );
        }
    }

    /**
     * index, always forward to list action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->getHelper('viewRenderer')->setNoRender();
        $this->_forward('list');
    }

    /**
     * Create tree/tree template
     * For SUPER_ADMIN, can only create tree template in Restricted SolutionType
     * For SUPER_ADMIN(sudo on a specific customer), same with the following CUSTOMER ACCESSES
     * For CUSTOMER, can create tree while is Restricted, must selection the Solution(Template) first
     *                               while Full, the Solutions in Restricted SolutionType
     *               not support on Static SolutionType, it's managed in NumberGroups page
     *
     * --------------      //Actual Creation
     * <request>
     * 'CustomerAccountId' //numberic      [build-in]
     * 'CustomerUserId'    //numberic      [build-in]
     * 'Label'             //string
     * 'ParentTreeId'      //numberic      [optional]
     * 'NodeTypes'         //struct        [optional]
     * 'SolutionId'        //numberic      [optional]
     * <view-assign>
     * 'TreeLabel'         //string
     * 'CustomerAccountId' //numberic
     * 'CustomerUserId'    //numberic
     * 'Pagination'        //struct
     *     'CurrentPage'   //numberic      [struct-key]
     *     'ItemsPerPage'  //numberic      [struct-key]
     *
     * --------------      //Modal Window
     * <request>
     * 'CustomerAccountId' //numberic      [build-in]
     * <view-assign>
     * 'IsSuperAdmin'      //boolean       [build-in]
     * 'TreeLists'         //array(struct)
     *
     * @return void
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $customerAccountId = $request->getParam('CustomerAccountId');

        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $params = array(
                'Label' => $request->getParam('Label'),
                'IsTemplate' => $this->_isSuperAdmin,
                'CustomerAccountId' => $customerAccountId,
                'CustomerUserId' => $request->getParam('CustomerUserId'),
                'ParentTreeId' => $request->getParam('ParentTreeId'),
                'NodeConstraints' => Zend_Json::encode($request->getParam('NodeTypes', array())),
                'SolutionId' => $request->getParam('SolutionId')
            );

            $treeId = Streamwide_Web_Model::call('Tree.Create', $params);
            Streamwide_Web_Log::debug("Tree $treeId is created");

            $pagination = array(
                'CurrentPage' => $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE),
                'ItemsPerPage' => $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE)
            );

            $this->view->assign(array(
                'TreeLabel' => $params['Label'],
                'CustomerUserId' => $params['CustomerUserId'],
                'CustomerAccountId' => $params['CustomerAccountId'],
                'Pagination' => $pagination,
            ));

            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            $requestParams = array($customerAccountId);

            if ($this->_isSuperAdmin) {
                $requestParams[0] = null;
            }

            Streamwide_Web_Log::debug('create tree with params ' . implode(' ', $requestParams));

            $treeLists = Streamwide_Web_Model::call($this->_apiMaps['GetAll'], $requestParams);
            $solutions = Streamwide_Web_Model::call('Solution.GetAll', array());
            $nodeTypes = SwIRS_Web_Node_Abstract::getNodeTypes();

            $this->view->assign(array(
                'IsSuperAdmin' => $this->_isSuperAdmin,
                'TreeLists' => $treeLists,
                'Solutions' => $solutions,
                'NodeTypes' => $nodeTypes,
            ));
        }
    }

    /**
     * List trees/tree templates
     * For SUPER_ADMIN, list all of tree templates
     * For SUPER_ADMIN(sudo on a specific customer) and CUSTOMER, list all trees
     *
     * --------------      //Search|List
     * <request>
     * 'CustomerAccountId' //numberic      [build-in]
     * 'LabelPart'         //string        [optional]
     * 'CurrentPage'       //numberic      [optional]
     * 'ItemsPerPage'      //numberic      [optional]
     * <view-assign>
     * 'IsSuperAdmin'      //boolean       [build-in]
     * 'TreeLists'         //array(struct)
     * 'Pagination'        //struct
     *
     * @return void
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $customerAccountId = $request->getParam('CustomerAccountId');

        $currentPage = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $itemsPerPage = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
        $itemsTotal = 0;

        $labelPart = trim($request->getParam('LabelPart', ''));

        //search function
        if (strlen($labelPart)) {
            $requestParams = array($labelPart, $customerAccountId, $currentPage, $itemsPerPage);
            if ($this->_isSuperAdmin) {
                unset($requestParams[1]);
            }
            Streamwide_Web_Log::debug('query tree with params ' . implode(' ', $requestParams));

            $treeLists = Streamwide_Web_Model::call($this->_apiMaps['Query'], array_values($requestParams));
            $itemsTotal = count($treeLists);
        } else {
            $requestParams = array($customerAccountId, $currentPage, $itemsPerPage);
            $requestCountParams = array($customerAccountId);

            if ($this->_isSuperAdmin) {
                $requestParams[0] = $requestCountParams[0] = null;
            }
            Streamwide_Web_Log::debug('list tree with params ' . implode(' ', $requestParams));
            Streamwide_Web_Log::debug(var_export($this->_apiMaps, true));

            $treeLists = Streamwide_Web_Model::call($this->_apiMaps['GetAll'], $requestParams);
            $itemsTotal = Streamwide_Web_Model::call($this->_apiMaps['Count'], $requestCountParams);
        }

        $this->view->assign(array(
            'IsSuperAdmin' => $this->_isSuperAdmin,
            'TreeLists'    => $treeLists,
            'Pagination'   => array(
                'CurrentPage' => $currentPage,
                'ItemsPerPage' => $itemsPerPage,
                'ItemsTotal'   => $itemsTotal,
            ),
        ));

        if ($request->isXmlHttpRequest()) {
            $this->getHelper('viewRenderer')->direct('list-items');
        }
    }

    /**
     * Update tree/tree template
     * It's not allowed switching the SolutionId
     *
     * --------------      //Actual Updating
     * <request>
     * 'TreeId'            //numberic
     * 'Label'             //string        [optional]
     * 'RootNodeId'        //numberic      [optional]
     * 'NodeTypes'         //struct        [optional]
     * <view-assign>
     * 'TreeInfo'          //struct
     *
     * --------------      //Modal Window
     * <request>
     * 'TreeId'            //numberic
     * <view-assign>
     * 'TreeInfo'          //array(struct)
     * 'Statuses'          //array(struct)
     *
     * @return void
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $treeId = $request->getParam('TreeId');

        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $rootNodeId = $request->getParam('');
            $nodeTypes = $request->getParam('NodeTypes', array());

            $params = array(
                'TreeId' => $treeId
            );
            if ($label = $request->getParam('Label')) {
                $params['Label'] = $label;
            }
            if ($rootNodeId = $request->getParam('RootNodeId')) {
                $params['RootNodeId'] = $rootNodeId;
            }
            if ( $nodeTypes = $request->getParam('NodeTypes', array()) ) {
                $params['NodeConstraints'] = Zend_Json::encode($nodeTypes);
            }

            Streamwide_Web_Model::call('Tree.Update', $params);
            $treeInfo = Streamwide_Web_Model::call('Tree.GetById', $treeId);

            $this->view->assign(array(
                 'TreeInfo' => $treeInfo,
            ));

        	   $this->getHelper('ViewRenderer')->direct('update-ack');

        } else {
            $treeInfo = Streamwide_Web_Model::call('Tree.GetById', array($treeId));
        	   $statuses = Streamwide_Web_Model::call('Tree.GetStatuses', array());
            $this->view->assign(array(
                'TreeInfo' => $treeInfo,
                'Statuses' => $statuses
            ));
        }
    }

    /**
     * Delete tree(s)/tree template(s)
     *
     * --------------      //Actual Deleting
     * <request>
     * 'Act'               //string
     * 'TreeId'            //struct        $TreeId => $TreeLabel
     * <view-assign>
     * 'TreeIds'           //struct        $TreeId => $TreeLabel
     * 'Result'            //struct        $TreeId => OK|NOK
     * 'CustomerAccountId' //numberic
     * 'CustomerUserId'    //numberic
     * 'Pagination'        //struct
     *     'CurrentPage'   //numberic      [struct-key]
     *     'ItemsPerPage'  //numberic      [struct-key]
     *
     * --------------      //Modal Window
     * <request>
     * 'TreeId'            //struct        $TreeId => $TreeLabel
     * <view-assign>
     * 'TreeIds'           //struct        $TreeId => $TreeLabel
     *
     * @return void
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $treeId = $request->getParam('TreeId', array());
        $act = $request->getParam('Act');
        if ('delete' == $act) {
            $result = array();

            try {
                foreach($treeId as $id => $label) {
                    $result[$id] = Streamwide_Web_Model::call('Tree.Delete', array($id));
                }
            } catch(Exception $e) {
                Streamwide_Web_Log::debug('Delete TreeId = ' . $id  . ' is fail with the message: ' . $e->getMessage());
                $result[$id] = self::OPERATION_FAIL;
            }

            $pagination = array(
                'CurrentPage' => $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE),
                'ItemsPerPage' => $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE)
            );

            $this->view->assign(array(
                'TreeIds' => $treeId,
                'Result' => $result,
                'CustomerUserId' => $request->getParam('CustomerUserId'),
                'CustomerAccountId' => $request->getParam('CustomerAccountId'),
                'Pagination' => $pagination,
            ));

            $this->gethelper('ViewRenderer')->direct('delete-ack');
        } else {
            $this->view->assign(array(
                'TreeIds' => $treeId
            ));
        }
    }

    /**
     * Clone a tree with TreeId, only accept the AJAX access
     *
     * --------------      //Actual Copy
     * <request>
     * 'TreeId'            //numberic
     * <view-assign>
     * 'Result'            //numberic      $newTreeId
     * 'CustomerAccountId' //numberic
     * 'CustomerUserId'    //numberic
     * 'Pagination'        //struct
     *     'CurrentPage'   //numberic      [struct-key]
     *     'ItemsPerPage'  //numberic      [struct-key]
     *
     * --------------      //Modal Window
     * <request>
     * <view-assign>
     *
     * @return void
     */
    public function copyAction()
    {
        $request = $this->getRequest();
        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $treeId = $request->getParam('TreeId');
            $newTreeId = Streamwide_Web_Model::call('Tree.Copy', array($treeId));
            $pagination = array(
                'CurrentPage' => $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE),
                'ItemsPerPage' => $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE)
            );

            $this->view->assign(array(
                'Result' => $newTreeId,
                'CustomerUserId' => $request->getParam('CustomerUserId'),
                'CustomerAccountId' => $request->getParam('CustomerAccountId'),
                'Pagination' => $pagination,
            ));
            $this->gethelper('ViewRenderer')->direct('copy-ack');
        }
    }

    /**
     * Rendering the routing tree building tool
     *
     * --------------      //Actual Page
     * <request>
     * 'TreeId'            //numberic
     * <view-assign>
     * 'NodeTypes'         //struct        $id => $label
     * 'CurrentTreeId'     //numberic
     * 'CurrentTreeInfo'   //struct
     * 'RootTreeInfo'      //struct
     * 'SubTreeLists'      //array(struct)
     * 'TreeNodes'         //struct        $nodeId => $nodeInfo
     *
     * @return void
     */
    public function builderAction()
    {
        // set another layout for builder
        $this->getHelper('Layout')->setLayout('tree');
        $request = $this->getRequest();
        $treeId = $request->getParam('TreeId');
        $nodeId = $request->getParam('NodeId');

        if ($request->getParam('IsBuilding')) {
            if (is_null($nodeId) || in_array($nodeId, self::$_renderedNodeIds)) {
                Streamwide_Web_Log::debug('Rendering Stoped because NextNodeId is null or rendered.');
                $this->getHelper('ViewRenderer')->setNoRender();
            } else {
                Streamwide_Web_Log::debug('Rendering Tree Node on NodeId: ' . $nodeId);
                $this->view->assign(array(
                    'CurrentNodeId' => $nodeId,
                    'RenderedNodeIds' => self::$_renderedNodeIds,
                ));
                $this->getHelper('ViewRenderer')->direct('building');
                self::$_renderedNodeIds[] = $nodeId;
            }
        } else {
            Streamwide_Web_Log::debug('Rendering Routing Tree on TreeId: ' . $treeId);

            $nodeTypes = SwIRS_Web_Node_Abstract::getNodeTypes();
            $currentTreeInfo = Streamwide_Web_Model::call('Tree.GetById', array($treeId));

            $rootTreeId = $currentTreeInfo['ParentTreeId'] ? $currentTreeInfo['ParentTreeId'] : $treeId;
            $subTreeLists = Streamwide_Web_Model::call('Tree.GetSubTrees', array($rootTreeId));

            $rootTreeInfo = $currentTreeInfo;
            if ($rootTreeId != $treeId) {
                $rootTreeInfo = Streamwide_Web_Model::call('Tree.GetById', array($rootTreeId));
            }

            $treeNodes = Streamwide_Web_Model::call('Tree.GetNodes', array($treeId));
            $treeNodes = $this->_formatTreeNodes($treeNodes);

            $this->view->assign(array(
                'NodeTypes' => $nodeTypes,
                'CurrentTreeId' => $treeId,
                'CurrentTreeInfo' => $currentTreeInfo,
                'RootTreeInfo' => $rootTreeInfo,
                'SubTreeLists' => $subTreeLists,
                
                'TreeNodes' => $treeNodes,
            ));
        }
    }

    /**
     * Formatting the Nodes whose belongs to a tree
     *
     * @param array $treeNodes the nodes list
     *
     * @return array Filtered datas in key/value pattern
     */
    private function _formatTreeNodes(array $treeNodes)
    {
        $data = array();
        foreach($treeNodes as $item) {
            $data[$item['NodeId']] = $item;
        }
        return $data;
    }
}

/* EOF */
