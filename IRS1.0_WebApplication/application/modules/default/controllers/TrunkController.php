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
 * @version    $Id: TrunkController.php 2507 2010-06-11 02:47:34Z zwang $
 */

/**
 * 
 */
class TrunkController extends Zend_Controller_Action
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
     * create a trunk
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
            Streamwide_Web_Log::debug("create a trunk actual");
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE); 
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            $defaults = array(
                'Label' => '',
                'ExternalId' => '',
                'IpAddress' => '',
                'Port' => 0,
            );
            $trunk = SwIRS_Web_Request::getParam($request,$defaults);
            $trunkId = Streamwide_Web_Model::call('Trunk.Create',array($trunk));
            Streamwide_Web_Log::debug("trunk $trunkId is created");

            $this->view->assign(array(
                'Label' => $trunk['Label'],
                'Pagination' => $pagination
            ));
            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug("create a trunk modal window");
        }
    }

    /**
     * list all trunks
     * <request>
     * CurrentPage
     * ItemsPerPage
     * TrunkLabelPart
     *
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
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     *      ItemsTotal =>
     * )
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $trunkLabelPart = $request->getParam('TrunkLabelPart','');
        $trunkLabelPart = trim($trunkLabelPart);

        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE); 
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
        $trunks = array();
        if (strlen($trunkLabelPart)>0) {
            Streamwide_Web_Log::debug("list trunks which contain $trunkLabelPart");
            $trunks = Streamwide_Web_Model::call('Trunk.GetByLabelPart',
                array(
                    $trunkLabelPart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Trunk.Count',array($trunkLabelPart));
        } else {
            Streamwide_Web_Log::debug("list trunks");
            $trunks = Streamwide_Web_Model::call('Trunk.GetAll',
                array(
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Trunk.Count',array());
        }
        $this->view->assign(array(
            'Trunks' => $trunks,
            'Pagination' => $pagination
        ));
    }	

    /**
     * update a trunk
     * Actual update
     * -------------
     * <request>
     * Act
     * TrunkId
     * Label
     * ExternalId
     * IpAddress
     * Port
     *
     * <view-assign>
     * Result
     * Trunk = array(
     *     TrunkId
     *     Label
     *     ExternalId
     *     IpAddress
     *     Port
     *     TrunkStatusId
     *     TrunkStatus
     *     CreationDateTime
     * )
     *
     * Modal window
     * -------------
     * <request>
     * TrunkId
     * <view-assign>
     * Trunk = array(
     *     TrunkId
     *     Label
     *     ExternalId
     *     IpAddress
     *     Port
     *     TrunkStatusId
     *     TrunkStatus
     *     CreationDateTime
     * )
     *
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $trunkId = $request->getParam('TrunkId');
        if ('update' == $act) {
            Streamwide_Web_Log::debug("update trunk $trunkId actual");
            $defaults = array(
                'Label' => null,
                'ExternalId' => null,
                'IpAddress' => null,
                'Port' => null,
            );
            $trunk = SwIRS_Web_Request::getParam($request,$defaults);
            $result = Streamwide_Web_Model::call('Trunk.Update',array($trunk));
            $this->view->assign('Result',$result);
            $this->getHelper('viewRenderer')->direct('update-ack');
        }
        $trunk = Streamwide_Web_Model::call('Trunk.GetById',array($trunkId));
        $this->view->assign('Trunk',$trunk);
    }

    /**
     * delete a trunk
     * Actual delete
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * TrunkIds = array($TrunkId)
     * TrunkLabels = array($TrunkLabel)
     * <view-assign>
     *
     * DeletedTrunks
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     * Modal window
     * -------------
     * <request>
     * TrunkIds = array($TrunkId)
     * TrunkLabels = array($TrunkLabel)
     *
     * <view-assign>
     * DeletedTrunks
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $trunkIds = $request->getParam('TrunkIds');
        $trunkLabels = $request->getParam('TrunkLabels');
        $deleted = implode(',',$trunkLabels);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($trunkIds as $trunkId) {
                $result = Streamwide_Web_Model::call('Trunk.Delete',array($trunkId));
            }
            Streamwide_Web_Log::debug("deleted trunk $deleted");
            $this->view->assign(array(
                'DeletedTrunks' => $deleted,
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            $this->view->assign('DeletedTrunks', $deleted);
        }
    }
}
/*EOF*/
