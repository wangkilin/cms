<?php
/**
 * $rev$
 * $LastChangedDate: 2010-06-23 18:13:54 +0800 (Wed, 23 Jun 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: NumbergroupController.php 2665 2010-06-23 10:13:54Z yaoli $
 */

/**
 *
 */
class NumbergroupController extends Zend_Controller_Action
{
    /**
     *
     */
    public function init()
    {
        // disable layout for ajax
        if ($this->_request->isXmlHttpRequest()) {
            $this->view->layout()->disableLayout();
        }
    }

    /**
     *
     */
    public function indexAction()
    {
        $this->listAction();
    }

    /**
     *delete numbergroup
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $premiumNumberGroupIds = $request->getParam('PremiumNumberGroupIds');
        $premiumNumberGroupNames = $request->getParam('PremiumNumberGroupNames');
        $deleted = implode(',', $premiumNumberGroupNames);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($premiumNumberGroupIds as $premiumNumberGroupId) {
                $result = Streamwide_Web_Model::call('PremiumNumberGroup.Delete',array($premiumNumberGroupId));
            }

            Streamwide_Web_Log::debug("deleted numbergroup $deleted");
            $this->view->assign(array(
                'PremiumNumberGroupNames' => $deleted,
                'CustomerUserId' => $request->getParam('CustomerUserId'),
                'CustomerAccountId' => $request->getParam('CustomerAccountId'),
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            $this->view->assign('PremiumNumberGroupNames', $deleted);
        }
    }

    /**
     * update numbergroup
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $premiumNumberGroupId = $request->getParam('PremiumNumberGroupId');
        $act = $request->getParam('Act');

        if ('update' == $act) {
            Streamwide_Web_Log::debug("update a number group $premiumNumberGroupId actual");
            $defaults = array(
                'PremiumNumberGroupId' => $premiumNumberGroupId,
                'PremiumNumberGroupName' => null,
                'EmergencyTreeId' => null,
                'EmergencyActivated' => null
            );

            $premiumNumberGroup = SwIRS_Web_Request::getParam($request, $defaults);
            $result = Streamwide_Web_Model::call('PremiumNumberGroup.Update', array($premiumNumberGroup));
            $this->view->assign('Result', $result);

            $premiumNumberGroup = Streamwide_Web_Model::call('PremiumNumberGroup.GetById', array($premiumNumberGroupId));
            if(! is_int($premiumNumberGroup['TemplateTreeId'])){
                $premiumNumberGroup['TemplateTreeLabel'] = '-';
            }
            $this->view->assign('PremiumNumberGroup', $premiumNumberGroup);
            $this->getHelper('viewRenderer')->direct('update-ack');

        } else {
            Streamwide_Web_Log::debug("udpate a number group $premiumNumberGroupId modal window");
            $customerAccountId = $request->getParam('CustomerAccountId');
            $premiumNumberGroup = Streamwide_Web_Model::call('PremiumNumberGroup.GetById', array($premiumNumberGroupId));

            $premiumNumbers = Streamwide_Web_Model::call('PremiumNumberGroup.GetPremiumNumbers',
                array($premiumNumberGroupId));
            $allocatedTrees = Streamwide_Web_Model::call('PremiumNumberGroup.GetAllocatedTrees',
                array($premiumNumberGroupId));
            $availableNumbers = Streamwide_Web_Model::call('PremiumNumber.GetNotGrouped',
                array($premiumNumberGroup['SolutionId'], $premiumNumberGroup['CustomerAccountId']));
            $routingTrees = Streamwide_Web_Model::call('Tree.GetByCustomer',
                array($customerAccountId, $premiumNumberGroup['SolutionId']));

            $this->view->assign(
                array(
                    'PremiumNumberGroup' => $premiumNumberGroup,
                    'GroupNumbers' => $premiumNumbers,
                    'AllocatedTrees' => $allocatedTrees,
                    'AvailableNumbers' => $availableNumbers,
                    'RoutingTrees' => $routingTrees
                ));
        }
    }

    /**
     * create new numbergroup
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        if ('create' == $act) {
            Streamwide_Web_Log::debug("create a number group actual");
            $defaults = array(
                'PremiumNumberGroupName' => '',
                'SolutionId' => 1,
                'CustomerAccountId' => 1,
                'CustomerUserId' => 1,
                'EmergencyTreeId' => null,
                'EmergencyActivated' => null
            );
            $premiumNumberGroup = SwIRS_Web_Request::getParam($request, $defaults);
            $premiumNumberGroupId = Streamwide_Web_Model::call('PremiumNumberGroup.Create', array($premiumNumberGroup));

            Streamwide_Web_Log::debug("number group $premiumNumberGroupId is created");

            $premiumNumberIds = $request->getParam('PremiumNumberIds', array());
            if (! empty($premiumNumberIds)) {
                Streamwide_Web_Log::debug("add numbers to a number group $premiumNumberGroupId");
                $result = Streamwide_Web_Model::call('PremiumNumberGroup.AddPremiumNumber',
                    array($premiumNumberGroupId, $premiumNumberIds));
            }

            $treeIds = $request->getParam('TreeIds', array());
            $startDatetimes = $request->getParam('StartDatetimes', array());
            $endDatetimes = $request->getParam('EndDatetimes', array());
            foreach ($treeIds as $key => $treeId) {
                $routingPlanId[] = Streamwide_Web_Model::call('PremiumNumberGroup.AddAllocatedTree',
                    array(
                        $premiumNumberGroupId,
                        $treeId,
                        $startDatetimes[$key],
                        $endDatetimes[$key]
                    )
                );
                Streamwide_Web_Log::debug("allocate tree $treeId to a number group $premiumNumberGroupId");
            }

            $this->view->assign(array(
                'PremiumNumberGroupName' => $premiumNumberGroup['PremiumNumberGroupName'],
                'CustomerUserId' => $premiumNumberGroup['CustomerUserId'],
                'CustomerAccountId' => $premiumNumberGroup['CustomerAccountId'],
                'Pagination' => $premiumNumberGroup
            ));

            $this->getHelper('viewRenderer')->direct('create-ack');
        } if ('change-solution' == $act) {
            $solutionId = $request->getParam('SolutionId');
            $customerAccountId = $request->getParam('CustomerAccountId');
            Streamwide_Web_Log::debug("change solution as $solutionId");
            $availableNumbers = Streamwide_Web_Model::call('PremiumNumber.GetNotGrouped', array($solutionId, $customerAccountId));
            $trees = Streamwide_Web_Model::call('Tree.GetByCustomer', array($customerAccountId, $solutionId));
            $this->view->assign(
                array(
                    'AvailableNumbers' => $availableNumbers,
                    'Trees' => $trees
                )
            );
            $this->getHelper('viewRenderer')->direct('change-solution');
        } else {
            $solutions = Streamwide_Web_Model::call('Solution.GetAll', array());
            $this->view->assign(
                array(
                    'Solutions' => $solutions
                )
            );
        }
    }

    /**
     * list numbergroups
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $customerAccountId = $request->getParam('CustomerAccountId');
        $premiumNumberGroupNamePart = $request->getParam('PremiumNumberGroupNamePart', '');
        $premiumNumberGroupNamePart = trim($premiumNumberGroupNamePart);

        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
        $premiumNumberGroups = array();
        if (strlen($premiumNumberGroupNamePart) > 0) {
            Streamwide_Web_Log::debug("list premium number groups whose name contains $premiumNumberGroupNamePart");
            $premiumNumberGroups = Streamwide_Web_Model::call('PremiumNumberGroup.GetByNamePart',
                array(
                    $customerAccountId,
                    $premiumNumberGroupNamePart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('PremiumNumberGroup.Count',
                array($customerAccountId, $premiumNumberGroupNamePart)
            );
        } else {
            Streamwide_Web_Log::debug("list premium number groups");
            $premiumNumberGroups = Streamwide_Web_Model::call('PremiumNumberGroup.GetByCustomer',
                array(
                    $customerAccountId,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('PremiumNumberGroup.Count',
                array($customerAccountId)
            );
        }
        foreach($premiumNumberGroups as $key => $premiumNumberGroup){
            if(! is_int($premiumNumberGroup['TemplateTreeId'])){
                $premiumNumberGroups[$key]['TemplateTreeLabel'] = '-';
            }
        }
        $this->view->assign(
            array(
                'PremiumNumberGroups' => $premiumNumberGroups,
                'Pagination' => $pagination
            )
        );
    }

    /**
     * numbers management
     */
    public function numberAction()
    {
        $request = $this->getRequest();
        $premiumNumberGroupId = $request->getParam('PremiumNumberGroupId');
        $premiumNumberIds = $request->getParam('PremiumNumberIds');
        $premiumNumbers = $request->getParam('PremiumNumbers');
        $numbers = implode(',', $premiumNumbers);
        $act = $request->getParam('Act');
        switch ($act)
        {
            case 'add':
                Streamwide_Web_Log::debug("add numbers to number group $premiumNumberGroupId");
                $result = Streamwide_Web_Model::call('PremiumNumberGroup.AddPremiumNumber',
                    array($premiumNumberGroupId, $premiumNumberIds));

                $this->view->assign('Result', $result);
                $this->getHelper('viewRenderer')->direct('number-add-ack');
                break;
            case 'delete':
                Streamwide_Web_Log::debug("delete numbers from number group $premiumNumberGroupId");
                $result = Streamwide_Web_Model::call('PremiumNumberGroup.RemovePremiumNumber',
                    array($premiumNumberGroupId, $premiumNumberIds));

                $this->view->assign('Result', $result);
                $this->getHelper('viewRenderer')->direct('number-delete-ack');
                break;
            default:
                break;
        }
        $this->view->assign(array(
            'PremiumNumbers' => $numbers
        ));
    }

    /**
     * allocated tree management
     */
    public function allocatedtreeAction()
    {
        $request = $this->getRequest();
        $premiumNumberGroupId = $request->getParam('PremiumNumberGroupId');
        $routingPlanId = $request->getParam('RoutingPlanId');
        $treeId = $request->getParam('TreeId');
        $startDatetime = $request->getParam('StartDatetime');
        $endDatetime = $request->getParam('EndDatetime');
        $act = $request->getParam('Act');
        switch ($act)
        {
            case 'add':
                $routingPlanId = Streamwide_Web_Model::call('PremiumNumberGroup.AddAllocatedTree', array(
                    array(
                        'PremiumNumberGroupId' => $premiumNumberGroupId,
                        'TreeId' => $treeId,
                        'StartDatetime' => $startDatetime,
                        'EndDatetime' => $endDatetime
                    )
                ));
                Streamwide_Web_Log::debug("routing plan $routingPlanId added");

                $this->view->assign(array('RoutingPlanId' => $routingPlanId));
                $this->getHelper('viewRenderer')->direct('allocated-tree-add-ack');
                break;
            case 'update':
                $result = Streamwide_Web_Model::call('PremiumNumberGroup.UpdateAllocatedTree', array(array(
                    'RoutingPlanId' => $routingPlanId,
                    'TreeId' => $treeId,
                    'StartSecond' => $startSecond,
                    'EndSecond' => $endSecond
                )));
                Streamwide_Web_Log::debug("routing plan $routingPlanId updated");

                $this->view->assign(array('Result' => $result));
                $this->getHelper('viewRenderer')->direct('allocated-tree-update-ack');
                break;
            case 'delete':
                $result = Streamwide_Web_Model::call('PremiumNumberGroup.RemoveAllocatedTree', array($routingPlanId));
                Streamwide_Web_Log::debug("routing plan $routingPlanId deleted");

                $this->view->assign(array('Result' => $result));
                $this->getHelper('viewRenderer')->direct('allocated-tree-delete-ack');
                break;
            default:
                break;
        }
    }
}

/* EOF */
