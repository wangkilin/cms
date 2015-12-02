<?php
/**
 * $Rev: 2617 $
 * $LastChangedDate: 2010-06-21 16:13:16 +0800 (Mon, 21 Jun 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: BlacklistController.php 2617 2010-06-21 08:13:16Z yaoli $
 */

/**
 *
 */
class BlacklistController extends Zend_Controller_Action
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
    	//$this->_forward('list');
        $this->listAction();
    }

    /**
     * create a blacklist
     * Actual create
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * BlacklistName
     * DynamicBlacklist
     * DynamicDtmf
     * DynamicDuration
     *
     * <view-assign>
     * BlacklistName
     * CustomerUserId
     * CustomerAccountId
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     *
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
            Streamwide_Web_Log::debug("create a blacklist actual");

            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            $defaults = array(
                 'BlacklistName' => '',
                 'DynamicBlacklist' => false,
                 'DynamicDtmf' => null,
                 'DynamicDuration' => null,
                 'CustomerUserId' => null ,
                 'CustomerAccountId' => null
            );
            $blacklist = SwIRS_Web_Request::getParam($request,$defaults);
            $blacklistId = Streamwide_Web_Model::call('Blacklist.Create',array($blacklist));

            Streamwide_Web_Log::debug("blacklist $blacklistId is created");
            $this->view->assign(array(
                'BlacklistName' => $blacklist['BlacklistName'],
                'CustomerUserId' => $blacklist['CustomerUserId'],
                'CustomerAccountId' => $blacklist['CustomerAccountId'],
                'Pagination' => $pagination
            ));
            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug("create a blacklist modal window");
        }
    }

    /**
     * list blacklists
     *
     * <request>
     * CurrentPage
     * ItemsPerPage
     * BlacklistNamePart
     *
     * <view-assign>
     * Blacklists = array(
     *      array(
     *          BlacklistId
     *          BlacklistName
     *          DynamicBlacklist
     *          DynamicDtmf
     *          DynamicDuration
     *          CustomerUserId
     *          CustomerUserName
     *          CustomerAccountId
     *          CreationDateTime
     *          ModificationDateTime
     *          ReferenceCounter
     *          NumberCount
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
        $blacklistNamePart = $request->getParam('BlacklistNamePart','');
        $blacklistNamePart = trim($blacklistNamePart);
        $customerAccountId = $request->getParam('CustomerAccountId');

        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
        $blacklists = array();
        if (strlen($blacklistNamePart) > 0) {
            Streamwide_Web_Log::debug("list blacklists whose name contains $blacklistNamePart");
            $blacklists = Streamwide_Web_Model::call('Blacklist.GetByName',
                array(
                    $customerAccountId,
                    $blacklistNamePart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Blacklist.Count',array($customerAccountId,$blacklistNamePart));
        } else {
            Streamwide_Web_Log::debug("list blacklists");
            $blacklists = Streamwide_Web_Model::call('Blacklist.GetByCustomer',
                array(
                    $customerAccountId,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Blacklist.Count',array($customerAccountId));
        }
        $this->view->assign(array(
            'Blacklists' => $blacklists,
            'Pagination' => $pagination
        ));
     }

    /**
     * update a blacklist
     *
     * Actual update
     * -------------
     * <request>
     * Act
     * BlacklistId
     * BlacklistName
     * DynamicBlacklist
     * DynamicDtmf
     * DynamicDuration
     * <view-assign>
     * Result
     * Blacklist = array(
     *     BlacklistId
     *     BlacklistName
     *     DynamicBlacklist
     *     DynamicDtmf
     *     DynamicDuration
     *     CustomerUserId
     *     CustomerUserName
     *     CustomerAccountId
     *     CreationDateTime
     *     ModificationDateTime
     *     ReferenceCounter
     *     NumberCount
     * )
     *
     * Modal window
     * -------------
     * <request>
     * BlacklistId
     * <view-assign>
     * Blacklist = array(
     *     BlacklistId
     *     BlacklistName
     *     DynamicBlacklist
     *     DynamicDtmf
     *     DynamicDuration
     *     CustomerUserId
     *     CustomerUserName
     *     CustomerAccountId
     *     CreationDateTime
     *     ModificationDateTime
     *     ReferenceCounter
     *     NumberCount
     * )
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $blacklistId = $request->getParam('BlacklistId');

        if ('update' == $act) {
            Streamwide_Web_Log::debug("update a blacklist $blacklistId actual");

            $defaults = array(
                 'BlacklistId' => $blacklistId,
                 'BlacklistName' => null,
                 'DynamicBlacklist' => null,
                 'DynamicDtmf' => null,
                 'DynamicDuration' => null
            );
            $blacklist = SwIRS_Web_Request::getParam($request,$defaults);
            $result = Streamwide_Web_Model::call('Blacklist.Update',array($blacklist));
            $this->view->assign('Result',$result);
            $this->getHelper('viewRenderer')->direct('update-ack');
        }
        Streamwide_Web_Log::debug("get a blacklist $blacklistId");
        $blacklist = Streamwide_Web_Model::call('Blacklist.GetById',array($blacklistId));
        $this->view->assign('Blacklist',$blacklist);
    }

    /**
     * delete a blacklist
     *
     * Actual delete
     * -------------
     * <request>
     * Act
     * BlacklistIds = array($BlacklistId)
     * BlacklistNames = array($BlacklistName)
     * CurrentPage
     * ItemsPerPage
     *
     * <view-assign>
     * DeletedBlacklistNames
     * CustomerUserId
     * CustomerAccountId
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     *
     * Modal window
     * ------------
     * <request>
     * BlacklistIds = array($BlacklistId)
     * BlacklistNames = array($BlacklistName)
     *
     * <view-assign>
     * DeletedBlacklistNames
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $blacklistIds = $request->getParam('BlacklistIds');
        $blacklistNames = $request->getParam('BlacklistNames');
        $deleted = implode(',',$blacklistNames);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($blacklistIds as $blacklistId) {
                $result = Streamwide_Web_Model::call('Blacklist.Delete',array($blacklistId));
            }

            Streamwide_Web_Log::debug("deleted blacklist $deleted");
            $this->view->assign(array(
                'DeletedBlacklistNames' => $deleted,
                'CustomerUserId' => $request->getParam('CustomerUserId'),
                'CustomerAccountId' => $request->getParam('CustomerAccountId'),
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            $this->view->assign('DeletedBlacklistNames', $deleted);
        }
    }

    /**
     * add number into blacklist
     * <request>
     * CurrentPage
     * ItemsPerPage
     * BlacklistId
     * PhoneNumber
     *
     * <view-assign>
     * PhoneNumber
     * BlacklistId
     *
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     */
    public function addnumberAction()
    {
        $request = $this->getRequest();
        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

        $blacklistId = $request->getParam('BlacklistId');
        $blacklistNumber = array (
            'PhoneNumber' => $request->getParam('PhoneNumber'),
            'Dynamic' => false
        );

        $blacklistNumberId = Streamwide_Web_Model::call('Blacklist.AddNumber',array($blacklistId,$blacklistNumber));
        Streamwide_Web_Log::debug("added number " . $blacklistNumber['PhoneNumber'] . " to blacklist " . $blacklistId);
        $this->view->assign(array(
            'BlacklistId' => $blacklistId,
            'PhoneNumber' => $blacklistNumber['PhoneNumber'],
            'Pagination' => $pagination
        ));
    }

    /**
     * list blacklist number
     * <request>
     * CurrentPage
     * ItemsPerPage
     * BlacklistNumberPart
     * BlacklistId
     *
     * <view-assign>
     * BlacklistNumbers = array(
     *      array(
     *          BlacklistNumberId
     *          PhoneNumber
     *          EndDate
     *          Dynamic
     *          BlacklistId
     *      )
     * )
     *
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     *      ItemsTotal =>
     * )
     */
    public function listnumberAction()
    {
        $request = $this->getRequest();
        $blacklistNumberPart = $request->getParam('BlacklistNumberPart','');
        $blacklistNumberPart = trim($blacklistNumberPart);
        $blacklistId = $request->getParam('BlacklistId');

        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
        $blacklistNumbers = array();
        if (strlen($blacklistNumberPart) > 0) {
            Streamwide_Web_Log::debug("list blacklist numbers whose number contains $blacklistNumberPart");
            $blacklistNumbers = Streamwide_Web_Model::call('Blacklist.GetNumbersByNumberPart',
                array(
                    $blacklistId,
                    $blacklistNumberPart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Blacklist.CountNumbers',array($blacklistId,$blacklistNumberPart));
        } else {
            Streamwide_Web_Log::debug("list blacklist numbers");
            $blacklistNumbers = Streamwide_Web_Model::call('Blacklist.GetNumbers',
                array(
                    $blacklistId,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Blacklist.CountNumbers',array($blacklistId));
        }
        $this->view->assign(array(
            'BlacklistNumbers' => $blacklistNumbers,
            'Pagination' => $pagination
        ));
     }

    /**
     * update number in blacklist
     * <request>
     * Act
     * BlacklistNumberId
     * PhoneNumber
     * EndDate
     * Dynamic
     *
     * <view-assign>
     * Result
     * BlacklistNumber = array(
     *     BlacklistNumberId
     *     PhoneNumber
     *     EndDate
     *     Dynamic
     *     BlacklistId
     * )
     */
    public function updatenumberAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $blacklistNumberId = $request->getParam('BlacklistNumberId');

        if ('update' == $act) {
            Streamwide_Web_Log::debug("update a blacklist number $blacklistNumberId actual");

            $defaults = array(
                 'BlacklistNumberId' => $blacklistNumberId,
                 'PhoneNumber' => null,
                 'EndDate' => null,
                 'Dynamic' => null
            );
            $blacklistNumber = SwIRS_Web_Request::getParam($request,$defaults);
            $result = Streamwide_Web_Model::call('Blacklist.UpdateNumber',array($blacklistNumber));
            $this->view->assign('Result',$result);
            $this->getHelper('viewRenderer')->direct('updatenumber-ack');
        }
        Streamwide_Web_Log::debug("get a blacklist number $blacklistNumberId");
        $blacklistNumber = Streamwide_Web_Model::call('Blacklist.GetNumberById',array($blacklistNumberId));
        $this->view->assign('BlacklistNumber',$blacklistNumber);
     }

    /**
     * delete number from blacklist
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     * BlacklistNumberIds = array($BlacklistNumberId)
     * BlacklistNumberNames = array($BlacklistNumber)
     * BlacklistId
     *
     * <view-assign>
     * DeletedPhoneNumbers
     * BlacklistId
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     */
    public function deletenumberAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $blacklistNumberIds = $request->getParam('BlacklistNumberIds');
        $blacklistNumberNames = $request->getParam('BlacklistNumberNames');
        $deleted = implode(',',$blacklistNumberNames);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($blacklistNumberIds as $blacklistNumberId) {
                $result = Streamwide_Web_Model::call('Blacklist.RemoveNumber',array($blacklistNumberId));
            }
            Streamwide_Web_Log::debug("deleted blacklist number $deleted");
            $this->view->assign(array(
                'DeletedPhoneNumbers' => $deleted,
                'BlacklistId' => $request->getParam('BlacklistId'),
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('deletenumber-ack');
        } else {
            $this->view->assign('DeletedPhoneNumbers', $deleted);
        }
     }

    /**
     * export blacklistNumber
     */
    public function exportAction()
    {
        $this->view->layout()->disableLayout();

        $request = $this->getRequest();
        $customerAccountId = $request->getParam('CustomerAccountId');
        $act = $request->getParam('Act');

        if ('export' == $act) {
            Streamwide_Web_Log::debug("export $customerAccountId blacklist file");
            $fileContent = Streamwide_Web_Model::call('Blacklist.Export', array($customerAccountId));
            $fileContent = base64_decode($fileContent);

            $response = $this->getResponse();
            $response->clearAllHeaders();
            $response->clearBody();
            $fileName = 'F-'. time();

            $response->setHeader('Content-Type', 'application/octet-stream')
                     ->setHeader('Content-Disposition', "attachment;filename=$fileName.csv")
                     ->setHeader('Content-Length', strlen($fileContent));
            $response->setBody($fileContent);
        } else {
            Streamwide_Web_Log::debug('export blacklist file');
        }
        $this->getHelper('viewRenderer')->setNoRender();
    }

    /**
     * import blacklistNumber
     */
    public function importAction()
    {
        $this->view->layout()->disableLayout();

        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $customerUserId = $request->getParam('CustomerUserId');
        $customerAccountId = $request->getParam('CustomerAccountId');

        if ('import' == $act) {
            if (isset($_FILES['Filedata'])) {
                Streamwide_Web_Log::debug("import blacklist file". $_FILES['Filedata']['name']);

                $fileContent = file_get_contents($_FILES['Filedata']['tmp_name']);

                $importJobId = Streamwide_Web_Model::call('Blacklist.Import',array(
                    $customerUserId,
                    $customerAccountId,
                    base64_encode($fileContent)
                ));

                $this->view->assign(array(
                    'ImportJobId' => $importJobId,
                    'CustomerUserId' => $customerUserId,
                    'CustomerAccountId' => $customerAccountId
                ));
                $this->getHelper('viewRenderer')->direct('import-ack');
            } else {
                //do nothing
            }
        } else {
            Streamwide_Web_Log::debug('import blacklist file');
            $this->getHelper('viewRenderer')->setNoRender();
        }
    }
}
/* EOF */
