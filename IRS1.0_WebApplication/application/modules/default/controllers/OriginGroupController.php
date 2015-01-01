<?php
/**
 * $Rev: 2507 $
 * $LastChangedDate: 2010-06-11 10:47:34 +0800 (Fri, 11 Jun 2010) $
 * $LastChangedBy: zwang $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: OriginGroupController.php 2507 2010-06-11 02:47:34Z zwang $
 */

/**
 *
 */
class OriginGroupController extends Zend_Controller_Action
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
     *
     */
    public function indexAction()
    {
        $this->listAction();
    }

    /**
     * create a originGroup
     *
     * Actual create
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * Label
     * ExternalId
     * IpAddress
     * Port
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
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        if ('create' == $act) {
            Streamwide_Web_Log::debug("create an origin group actual");
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
            $groupName = $request->getParam('Label');
            $groupId = Streamwide_Web_Model::call('Origin.AddGroup',array($groupName));
            Streamwide_Web_Log::debug("originGroup $groupId is created");

            $this->view->assign(array(
                'Label' => $groupName,
                'Pagination' => $pagination
            ));
            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug("create an originGroup modal window");
        }
    }

    /**
     * list all originGroups
     * <request>
     * CurrentPage
     * ItemsPerPage
     * OriginGroupLabelPart
     *
     * <view-assign>
     * OriginGroups = array(
     *      array(
     *          OriginGroupId
     *          Label
     *          ExternalId
     *          IpAddress
     *          Port
     *          OriginGroupStatusId
     *          OriginGroupStatus
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
        $originGroupLabelPart = $request->getParam('OriginGroupLabelPart','');
        $originGroupLabelPart = trim($originGroupLabelPart);

        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
        $originGroups = array();
        /*if (strlen($originGroupLabelPart)>0) {
            Streamwide_Web_Log::debug("list originGroups which contain $originGroupLabelPart");
            $originGroups = Streamwide_Web_Model::call('OriginGroup.GetByLabelPart',
                array(
                    $originGroupLabelPart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('OriginGroup.Count',array($originGroupLabelPart));
        } else {*/
            Streamwide_Web_Log::debug("list originGroups");
            $originGroups = Streamwide_Web_Model::call('Origin.GetGroups',
                array(
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            //$pagination['ItemsTotal'] = Streamwide_Web_Model::call('OriginGroup.Count',array());

        //}
        $this->view->assign(array(
            'OriginGroups' => $originGroups,
            'Pagination' => $pagination
        ));
    }

    /**
     * update a originGroup
     * Actual update
     * -------------
     * <request>
     * Act
     * OriginGroupId
     * Label
     * ExternalId
     * IpAddress
     * Port
     *
     * <view-assign>
     * Result
     * OriginGroup = array(
     *     OriginGroupId
     *     Label
     *     ExternalId
     *     IpAddress
     *     Port
     *     OriginGroupStatusId
     *     OriginGroupStatus
     *     CreationDateTime
     * )
     *
     * Modal window
     * -------------
     * <request>
     * OriginGroupId
     * <view-assign>
     * OriginGroup = array(
     *     OriginGroupId
     *     Label
     *     ExternalId
     *     IpAddress
     *     Port
     *     OriginGroupStatusId
     *     OriginGroupStatus
     *     CreationDateTime
     * )
     *
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $originGroupId = $request->getParam('OriginGroupId');
        if ('update' == $act) {
            Streamwide_Web_Log::debug("update originGroup $originGroupId actual");
            $originGroupName = $request->getParam('Label');
            $originGroupId = $request->getParam('OriginGroupId');
            $result = Streamwide_Web_Model::call('Origin.UpdateGroup',array($originGroupId, $originGroupName));
            $this->view->assign('Result',$result);
            $this->getHelper('viewRenderer')->direct('update-ack');
        }
        $originGroup = Streamwide_Web_Model::call('Origin.GetGroupById',array($originGroupId));
        $this->view->assign('OriginGroup',$originGroup);
    }

    /**
     * delete a originGroup
     * Actual delete
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * OriginGroupIds = array($OriginGroupId)
     * OriginGroupLabels = array($OriginGroupLabel)
     * <view-assign>
     *
     * DeletedOriginGroups
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     * Modal window
     * -------------
     * <request>
     * OriginGroupIds = array($OriginGroupId)
     * OriginGroupLabels = array($OriginGroupLabel)
     *
     * <view-assign>
     * DeletedOriginGroups
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $originGroupIds = $request->getParam('OriginGroupIds');
        $originGroupLabels = $request->getParam('OriginGroupLabels');
        $deleted = implode(',',$originGroupLabels);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($originGroupIds as $originGroupId) {
                $result = Streamwide_Web_Model::call('Origin.RemoveGroup',array($originGroupId));
            }
            Streamwide_Web_Log::debug("deleted originGroup $deleted");
            $this->view->assign(array(
                'DeletedOriginGroups' => $deleted,
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            $this->view->assign('DeletedOriginGroups', $deleted);
        }
    }
}
/*EOF*/
