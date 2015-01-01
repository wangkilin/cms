<?php
/**
 * $Rev: 2652 $
 * $LastChangedDate: 2010-06-23 10:57:21 +0800 (Wed, 23 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: ContactController.php 2652 2010-06-23 02:57:21Z kwu $
 */

/**
 *
 */
class ContactController extends Zend_Controller_Action
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
     * create new contact
     * Actual create
     * -----------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * ContactPhone
     * ContactName
     * CustomerUserId
     * CustomerAccountId
     *
     * <view-assign>
     * ContactName
     * CustomerUserId
     * CustomerAccountId
     * Pagination = array(
     *     CurrentPage =>
     *     ItemsPerPage =>
     * )
     *
     * Model Window
     * ----------------
     * <request>
     * <view-assign>
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        if ('create' == $act) {
            Streamwide_Web_Log::debug('create contact actual');

            $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);

            $defaults = array(
                'ContactPhone' => '',
                'ContactName' => '',
                'CustomerUserId' => null,
                'CustomerAccountId' => null,
                'Automatic' => false
            );
            $contact = SwIRS_Web_Request::getParam($request, $defaults);
            $contactId = Streamwide_Web_Model::call('Contact.Create', array($contact));

            Streamwide_Web_Log::debug("contact $contactId is created");

            $this->view->assign(
                array(
                    'ContactName' => $contact['ContactName'],
                    'CustomerUserId' => $contact['CustomerUserId'],
                    'CustomerAccountId' => $contact['CustomerAccountId'],
                    'Pagination' => $pagination
                )
            );
            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug('create contact modal window');
        }
    }

    /**
     * list contacts
     * <request>
     * CurrentPage
     * ItemsPerPage
     * CustomerAccountId
     * Keyword
     *
     * <view-assign>
     * Contacts = array(
     *     array(
     *         ContactId =>
     *         ContactPhone =>
     *         ContactName =>
     *         CustomerUserId =>
     *         CustomerUserName =>
     *         CustomerAccountId =>
     *         CreationDateTime =>
     *         ModificationDateTime =>
     *         Automatic =>
     *         ReferenceCounter =>
     *     )
     * )
     * Pagination = array(
     *     CurrentPage =>
     *     ItemsPerPage =>
     *     TotalPage =>
     * )
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;

        $customerAccountId = $request->getParam('CustomerAccountId');
        $act = $request->getParam('Act');
        $keyword = $request->getParam('Keyword');
        $keyword = trim($keyword);

        $contacts = array();
        if (strlen($keyword) > 0) {
            Streamwide_Web_Log::debug("list contacts whose name contains $keyword");
            $method = 'Contact.GetByName';
            $searchKey = 'ContactName';
            if (eregi('^[0-9]+$',$keyword)) {
                $method = 'Contact.GetByPhoneNumber';
                $searchKey = 'ContactPhone';
            }

            $contacts = Streamwide_Web_Model::call($method,
                array(
                    $customerAccountId,
                    $keyword,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Contact.Count', array($customerAccountId, $keyword));
        } else {
            Streamwide_Web_Log::debug('list contacts');
            $contacts = Streamwide_Web_Model::call('Contact.GetByCustomer',
                array(
                    $customerAccountId,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Contact.Count', array($customerAccountId));
        }
        $this->view->assign(array(
            'Contacts' => $contacts,
            'Pagination' => $pagination
        ));
        if ('search' == $act) {
            $this->getHelper('viewRenderer')->direct('search');
            $this->view->assign(
                array(
                    'Keyword' => $keyword,
                    'SearchKey' => $searchKey
                )
            );
        }
    }

    /**
     * update a contact
     * Actual update
     * ----------------
     * <request>
     * Act
     * ContactName
     * ContactNumber
     * ContactId
     *
     * <view-assign>
     * Result
     * Contact = array(
     *     ContactId
     *     ContactPhone
     *     ContactName
     *     CustomerUserId
     *     CustomerUserName
     *     CustomerAccountId
     *     CreationDateTime
     *     ModificationDateTime
     *     Automatic
     *     ReferenceCounter
     * )
     *
     * Modal window
     * ----------------
     * <request>
     * ContactId
     *
     * <view-assign>
     * Contact = array(
     *     ContactId
     *     ContactPhone
     *     ContactName
     *     CustomerUserId
     *     CustomerUserName
     *     CustomerAccountId
     *     CreationDateTime
     *     ModificationDateTime
     *     Automatic
     *     ReferenceCounter
     * )
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $contactId = $request->getParam('ContactId');

        if ('update' == $act) {
            Streamwide_Web_Log::debug('contact update actual');
            $defaults = array(
                'ContactId' => $contactId,
                'ContactPhone' => null,
                'ContactName' => null,
                'Automatic' => false
            );
            $contact = SwIRS_Web_Request::getParam($request, $defaults);
            $result = Streamwide_Web_Model::call('Contact.Update', array($contact));

            Streamwide_Web_Log::debug("contact $contactId is updated");

            $this->view->assign('Result', $result);
            $this->getHelper('viewRenderer')->direct('update-ack');
        }
        Streamwide_Web_Log::debug("get a contact $contactId");
        $contact = Streamwide_Web_Model::call('Contact.GetById', array($contactId));
        $this->view->assign('Contact', $contact);
    }

    /**
     *delete one or more contacts
     *Actual delete
     *-----------------
     *<request>
     *Act
     *ContactIds = array($ContactId)
     *ContactNames = array($ContactName)
     *CurrentPage
     *ItemsPerPage
     *
     *<view-assign>
     *DeletedContactNames
     *CustomerUserId
     *CustomerAccountId
     *Pagination = array(
     *    CurrentPage =>
     *    ItemsPerPage =>
     *)
     *Modal Window
     *-----------------
     *<request>
     *ContactIds = array($ContactId)
     *ContactNames = array($ContactName)
     *
     *<view-assign>
     *DeletedContactNames
     */
    public function deleteAction()
    {
        $request = $this->_request;
        $act = $request->getParam('Act');
        $contactIds = $request->getParam('ContactIds');
        $contactNames = $request->getParam('ContactNames');
        $deletedContactNames = implode(',', $contactNames);

        if ('delete' == $act) {
            Streamwide_Web_Log::debug('delete contact actual');
            $pagination['CurrentPage'] = $request->getParam('CurrentPage');
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage');
            foreach ($contactIds as $contactId) {
                Streamwide_Web_Model::call('Contact.Delete', array($contactId));
            }
            Streamwide_Web_Log::debug("deleted contact $deletedContactNames");
            $this->view->assign(array(
                'DeletedContactNames' => $deletedContactNames,
                'CustomerUserId' => $request->getParam('CustomerUserId'),
                'CustomerAccountId' => $request->getParam('CustomerAccountId'),
                'Pagination' => $pagination
            ));
            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            Streamwide_Web_Log::debug('delete contact modal window');
            $this->view->assign('DeletedContactNames', $deletedContactNames);
        }
    }

    /**
     *import a file
     *
     *<request>
     *CustomerAccountId
     *CustomerUserId
     *Act
     *
     *<view-assign>
     *CustomerAccountId
     *CustomerUserId
     *ImportJobId
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
                Streamwide_Web_Log::debug("import contact file". $_FILES['Filedata']['name']);

                $fileContent = file_get_contents($_FILES['Filedata']['tmp_name']);

                $importJobId = Streamwide_Web_Model::call('Contact.Import',array(
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
            Streamwide_Web_Log::debug('import contact file');
            $this->getHelper('viewRenderer')->setNoRender();
        }
    }

    /**
     *export contact file
     *<request>
     *CustomerAccountId
     *Act
     *
     *<view-assign>
     *
     */
    public function exportAction()
    {
        $this->view->layout()->disableLayout();

        $request = $this->getRequest();
        $customerAccountId = $request->getParam('CustomerAccountId');
        $act = $request->getParam('Act');

        if ('export' == $act) {
            Streamwide_Web_Log::debug("export $customerAccountId contact file");
            $fileContent = Streamwide_Web_Model::call('Contact.Export', array($customerAccountId));
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
            Streamwide_Web_Log::debug('export contact file');
        }
        $this->getHelper('viewRenderer')->setNoRender();
    }

    /**
     * NodeParamOutgoingId
     * FailoverContacts = array {
     *      array(
     *          Rank
     *          ContactId
     *      )
     * }
     */
    public function addfailoverAction()
    {
        $request = $this->getRequest();
        $nodeParamOutgoingId = $request->getParam('NodeParamOutgoingId');
        $failoverContacts = $request->getParam('FailoverContacts');
        $result = Streamwide_Web_Model::call('Outgoing.AddFailoverContacts',array($nodeParamOutgoingId,$failoverContacts));
    }

    /**
     * FailoverContacts = array {
     *      NodeParamOutgoingFailoverId
     * }
     */
    public function removefailoverAction()
    {
        $request = $this->getRequest();
        $failoverContacts = $request->getParam('FailoverContacts');
        $result = Streamwide_Web_Model::call('Outgoing.RemoveFailoverContacts',array($failoverContacts));
    }

    /**
     * FailoverContactIdA
     * FailoverContactIdB
     */
    public function swaprankAction()
    {
        $request = $this->getRequest();
        $failoverContactIdA = $request->getParam('FailoverContactIdA');
        $failoverContactIdB = $request->getParam('FailoverContactIdB');
        $result = Streamwide_Web_Model::call('Outgoing.SwapFailoverContacts',array($failoverContactIdA,$failoverContactIdB));
    }
}

/* EOF */
