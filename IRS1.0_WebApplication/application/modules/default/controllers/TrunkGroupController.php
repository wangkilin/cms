<?php
/**
 * $Rev: 2570 $
 * $LastChangedDate: 2010-06-17 16:16:18 +0800 (Thu, 17 Jun 2010) $
 * $LastChangedBy: zwang $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: TrunkGroupController.php 2570 2010-06-17 08:16:18Z zwang $
 */

/**
 * 
 */
class TrunkGroupController extends Zend_Controller_Action
{
    /**
     *
     */
    public function init()
    {
        //disable layout for ajax
        if ($this->_request->isXmlHttpRequest()) {
            $this->view->layout()->disableLayout();
        }
    }

    /**
     * indexAction()
     */
    public function indexAction()
    {
    	$this->listAction();
    }

    /**
     * create a trunk group
     *
     * Actual create
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * Label
     * TrunkIds = array($TrunkId)
     *
     * <view-assign>
     * Label
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     * Modal window
     * -------------
     * <request>
     * <view-assign>
     * Trunks = array(
     *      array(
     *          TrunkId
     *          Label
     *          ExternalId
     *          IpAddress
     *          Port
     *          TrunkStatusId
     *          TrunkStatus
     *          CreationDateTime
     *      )
     * )
     *
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        
        if ('create' == $act) {
            Streamwide_Web_Log::debug("create a trunk group actual");
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE); 
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            $label = $request->getParam('Label');
            $params = array(
            	'Label' => $label
            );
            $trunkGroupId = Streamwide_Web_Model::call('TrunkGroup.Create',array($params));
            Streamwide_Web_Log::debug("trunk group $trunkGroupId is created");

            $trunkIds = $request->getParam('TrunkIds');
            if (!empty($trunkIds)) {
                $result = Streamwide_Web_Model::call('TrunkGroup.AddTrunks',array($trunkGroupId,$trunkIds));
                Streamwide_Web_Log::debug("trunks added to trunk group $trunkGroupId");
            }

            $this->view->assign(array(
                'Label' => $label,
                'Pagination' => $pagination
            ));
            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug("create a trunk group modal window");
            $trunks = Streamwide_Web_Model::call('Trunk.GetAll',array());
            $this->view->assign('Trunks', $trunks);
        }
     }

    /**
     * list all trunk groups
     * CurrentPage
     * ItemsPerPage
     * TrunkGroupLabelPart
     *
     * <view-assign>
     * TrunkGroups = array(
     *      array(
     *          TrunkGroupId
     *          Label
     *          TrunkNumberCount
     *          CreationDateTime
     *      )
     * )
     *
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     *      ItemsTotal =>
     * )
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $trunkGroupLabelPart = $request->getParam('TrunkGroupLabelPart','');
        $trunkGroupLabelPart = trim($trunkGroupLabelPart);

        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE); 
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
        $trunkGroups = array();
        if (strlen($trunkGroupLabelPart)>0) {
            Streamwide_Web_Log::debug("list trunk groups which contain $trunkGroupLabelPart");
            $trunkGroups = Streamwide_Web_Model::call('TrunkGroup.GetByLabelPart',
                array(
                    $trunkGroupLabelPart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('TrunkGroup.Count',array($trunkGroupLabelPart));
        } else {
            Streamwide_Web_Log::debug("list trunk groups");
            $trunkGroups = Streamwide_Web_Model::call('TrunkGroup.GetAll',
                array(
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('TrunkGroup.Count',array());
        }
        $this->view->assign(array(
            'TrunkGroups' => $trunkGroups,
            'Pagination' => $pagination
        ));
    }

    /**
     * update a trunk group
     * Act
     * TrunkGroupId
     * Label
     *
     * <view-assign>
     * Result
     * TrunkGroup = array(
     *     TrunkGroupId
     *     Label
     *     TrunkNumberCount
     *     CreationDateTime
     * )
     *
     * Modal window
     * -------------
     * <request>
     * TrunkGroupId
     * <view-assign>
     * TrunkGroup = array(
     *     TrunkGroupId
     *     Label
     *     TrunkNumberCount
     *     CreationDateTime
     * )
     *
     * Trunks = array(
     *      array(
     *          TrunkId
     *          Label
     *          ExternalId
     *          IpAddress
     *          Port
     *          TrunkStatusId
     *          TrunkStatus
     *          CreationDateTime
     *      )
     * )
     * AssignedTrunks = array(
     *      array(
     *          TrunkId
     *          Label
     *          ExternalId
     *          IpAddress
     *          Port
     *          TrunkStatusId
     *          TrunkStatus
     *          CreationDateTime
     *      )
     * )
     *
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $trunkGroupId = $request->getParam('TrunkGroupId');
        if ('update' == $act) {
            Streamwide_Web_Log::debug("update trunk group $trunkGroupId actual");
            $defaults = array(
                'TrunkGroupId' => $trunkGroupId,
                'Label' => null
            );
            $trunkGroup = SwIRS_Web_Request::getParam($request,$defaults);
            if (!is_null($trunkGroup['Label'])) {
                $result = Streamwide_Web_Model::call('TrunkGroup.Update',array($trunkGroup));
                $this->view->assign('Result',$result);
            }
            $this->getHelper('viewRenderer')->direct('update-ack');
        } else {
            $trunks = Streamwide_Web_Model::call('Trunk.GetAll',array());
            $assignedTrunks = Streamwide_Web_Model::call('TrunkGroup.GetTrunks',array($trunkGroupId));
            $this->view->assign('Trunks', $trunks);
            $this->view->assign('AssignedTrunks', $assignedTrunks);
        }
        $trunkGroup = Streamwide_Web_Model::call('TrunkGroup.GetById',array($trunkGroupId));
        $this->view->assign('TrunkGroup',$trunkGroup);
    }

    /**
     * delete a trunk group
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * TrunkGroupIds = array($TrunkGroupId)
     * TrunkGroupLabels = array($TrunkGroupLabel)
     * <view-assign>
     *
     * DeletedTrunkGroups
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     * Modal window
     * -------------
     * <request>
     * TrunkGroupIds = array($TrunkGroupId)
     * TrunkGroupLabels = array($TrunkGroupLabel)
     *
     * <view-assign>
     * DeletedTrunkGroups
     *
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        
        $trunkGroupIds = $request->getParam('TrunkGroupIds');
        $trunkGroupLabels = $request->getParam('TrunkGroupLabels');
        $deleted = implode(',',$trunkGroupLabels);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($trunkGroupIds as $trunkGroupId) {
                $result = Streamwide_Web_Model::call('TrunkGroup.Delete',array($trunkGroupId));
            }
            Streamwide_Web_Log::debug("deleted trunk group $deleted");
            $this->view->assign(array(
                'DeletedTrunkGroups' => $deleted,
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            $this->view->assign('DeletedTrunkGroups', $deleted);
        }
    }

    /**
     * add trunk to trunkgroup
     * <request>
     * TrunkGroupId
     * TrunkIds = array($TrunkId)
     * <view-assign>
     * Result
     */
    public function addtrunkAction()
    {
        $request = $this->getRequest();
        $trunkGroupId = $request->getParam('TrunkGroupId');
        $trunkIds = $request->getParam('TrunkIds');
        $result = Streamwide_Web_Model::call('TrunkGroup.AddTrunks',array($trunkGroupId,$trunkIds));
        $this->view->assign('Result', $result);
    }

    /**
     * remove trunk from trunkgroup
     * <request>
     * TrunkGroupId
     * TrunkIds = array($TrunkId)
     * <view-assign>
     * Result
     */
    public function deletetrunkAction()
    {
        $request = $this->getRequest();
        $trunkGroupId = $request->getParam('TrunkGroupId');
        $trunkIds = $request->getParam('TrunkIds');
        $result = Streamwide_Web_Model::call('TrunkGroup.RemoveTrunks',array($trunkGroupId,$trunkIds));
        $this->view->assign('Result', $result);
    }
}
