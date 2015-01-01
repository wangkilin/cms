<?php
/**
 * $Rev: 2580 $
 * $LastChangedDate: 2010-06-17 20:06:53 +0800 (Thu, 17 Jun 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: CustomerController.php 2580 2010-06-17 12:06:53Z yaoli $
 */

/**
 *
 */
class CustomerController extends Zend_Controller_Action
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
     * create a customer
     * Actual create
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * CustomerAccountName
     * CustomerAccountBillingId
     * ContactName
     * ContactEmail
     * ContactPhone
     * MaxResPrompt
     * MaxResOrigin
     * MaxResBlacklist
     * MaxResCalendar
     * MaxResAgentgroup
     * MaxResContact
     * MaxResUser
     *
     * <view-assign>
     * CustomerAccountName
     *
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
            Streamwide_Web_Log::debug('create a customer actual');
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            $defaults = array(
                'CustomerAccountName' => '',
                'CustomerAccountBillingId' => '',
                'ContactName' => '',
                'ContactEmail' => '',
                'ContactPhone' => ''
            );
            $quotasDefaults = array(
                'MaxResPrompt' => 0,
                'MaxResOrigin' => 0,
                'MaxResBlacklist' => 0,
                'MaxResCalendar' => 0,
                'MaxResAgentgroup' => 0,
                'MaxResContact' => 0,
                'MaxResUser' => 0
            );
            $customerAccount = SwIRS_Web_Request::getParam($request, $defaults);
            $quotas = SwIRS_Web_Request::getParam($request, $quotasDefaults);
            $customerAccount['Quotas'] = $quotas;
            Streamwide_Web_Model::call('Customer.Create', array($customerAccount));
            Streamwide_Web_Log::debug("customer " . $customerAccount['CustomerAccountName'] . " is created");

            $this->view->assign(array(
                'CustomerAccountName' => $customerAccount['CustomerAccountName'],
                'Pagination' => $pagination
            ));
            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug('create a customer modal window');
        }
    }

    /**
     * list customers
     * <request>
     * CurrentPage
     * ItemsPerPage
     * CustomerAccountNamePart
     *
     * <view-assign>
     * CustomerAccounts = array(
     *      array(
     *          CustomerAccountId
     *          CustomerAccountName
     *          CustomerAccountBillingId
     *          ContactName
     *          ContactEmail
     *          ContactPhone
     *          CreationDateTime
     *          Quotas = array (
     *             QuotaId
     *             MaxResPrompt
     *             MaxResOrigin
     *             MaxResBlacklist
     *             MaxResCalendar
     *             MaxResAgentgroup
     *             MaxResContact
     *             MaxResUser
     *          )
     * )
     * Pagination = array(
     *     CurrentPage
     *     ItemsPerPage
     *     ItemsTotal
     * )
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $customerAccountNamePart = $request->getParam('CustomerAccountNamePart','');
        $customerAccountNamePart = trim($customerAccountNamePart);
        $act = $request->getParam('Act');
        $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;

        $customerAccounts = array();
        if (strlen($customerAccountNamePart) > 0) {
            Streamwide_Web_Log::debug('list customer accounts whose name contains ' .$customerAccountNamePart);
            $customerAccounts = Streamwide_Web_Model::call('Customer.GetByNamePart',
                array(
                    $customerAccountNamePart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Customer.Count', array($customerAccountNamePart));
        } else {
            Streamwide_Web_Log::debug('list all customer accounts');
            $customerAccounts = Streamwide_Web_Model::call('Customer.GetAll',
                array(
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Customer.Count', array());
        }
        $this->view->assign(
            array(
                'CustomerAccounts' => $customerAccounts,
                'Pagination' => $pagination
            )
        );
        if ('search' == $act) {
            $this->getHelper('viewRenderer')->direct('search');
            $this->view->assign(
                array(
                    'CustomerAccountNamePart' => $customerAccountNamePart
                )
            );
        }
    }

    /**
     * update a customer
     * Actual update
     * -------------
     * <request>
     * Act
     * CustomerAccountId
     * CustomerAccountName
     * CustomerAccountBillingId
     * ContactName
     * ContactEmail
     * ContactPhone
     * MaxResPrompt
     * MaxResOrigin
     * MaxResBlacklist
     * MaxResCalendar
     * MaxResAgentgroup
     * MaxResContact
     * MaxResUser
      *
     * <view-assign>
     * Result
     * CustomerAccount = array(
     *     CustomerAccountName
     *     CustomerAccountBillingId
     *     ContactName
     *     ContactEmail
     *     ContactPhone
     *     CreationDateTime
     *     Quotas = array(
     *         QuotaId
     *         MaxResPrompt
     *         MaxResOrigin
     *         MaxResBlacklist
     *         MaxResCalendar
     *         MaxResAgentgroup
     *         MaxResContact
     *         MaxResUser
     *     )
     * )
     *
     * Modal window
     * -------------
     * <request>
     * CustomerAccountId
     *
     * <view-assign>
     * CustomerAccount = array(
     *     CustomerAccountName
     *     CustomerAccountBillingId
     *     ContactName
     *     ContactEmail
     *     ContactPhone
     *     CreationDateTime
     *     Quotas = array(
     *         QuotaId
     *         MaxResPrompt
     *         MaxResOrigin
     *         MaxResBlacklist
     *         MaxResCalendar
     *         MaxResAgentgroup
     *         MaxResContact
     *         MaxResUser
     *     )
     * )
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $customerAccountId = $request->getParam('CustomerAccountId');

        if ('update' == $act) {
            Streamwide_Web_Log::debug('update a customer actual');
            $defaults = array(
                'CustomerAccountId' => $customerAccountId,
                'CustomerAccountName' => null,
                'CustomerAccountBillingId' => null,
                'ContactName' => null,
                'ContactEmail' => null,
                'ContactPhone' => null
            );
            $quotasDefaults = array(
                'MaxResPrompt' => null,
                'MaxResOrigin' => null,
                'MaxResBlacklist' => null,
                'MaxResCalendar' => null,
                'MaxResAgentgroup' => null,
                'MaxResContact' => null,
                'MaxResUser' => null
            );
            $customerAccount = SwIRS_Web_Request::getParam($request, $defaults);
            $quotas = SwIRS_Web_Request::getParam($request, $quotasDefaults);
            if (!empty($quotas)) {
                $customerAccount['Quotas'] = $quotas;
            }
            $result = Streamwide_Web_Model::call('Customer.Update', array($customerAccount));

            Streamwide_Web_Log::debug("customer $customerAccountId is updated");
            $this->view->assign('Result', $result);
            $this->getHelper('viewRenderer')->direct('update-ack');
        }
        $customerAccount = Streamwide_Web_Model::call('Customer.GetById', array($customerAccountId));
        $this->view->assign('CustomerAccount', $customerAccount);
    }

    /**
     * delete a customer
     * Actual delete
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * CustomerAccountIds = array($CustomerAccountId)
     * CustomerAccountNames = array($CustomerAccountName)
     *
     * <view-assign>
     * DeletedCustomerAccounts
     *
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     * Modal window
     * -------------
     * <request>
     * CustomerAccountIds = array($CustomerAccountId)
     * CustomerAccountNames = array($CustomerAccountName)
     *
     * <view-assign>
     * DeletedCustomerAccounts
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $customerAccountIds = $request->getParam('CustomerAccountIds');
        $customerAccountNames = $request->getParam('CustomerAccountNames');
        $deleted = implode(',',$customerAccountNames);

        if ('delete' == $act) {
            Streamwide_Web_Log::debug('delete customer actual');
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($customerAccountIds as $customerAccountId) {
                $result = Streamwide_Web_Model::call('Customer.Delete', array($customerAccountId));
            }
            Streamwide_Web_Log::debug("deleted customer $deleted");
            $this->view->assign(array(
                'DeletedCustomerAccounts' => $deleted,
                'Pagination' => $pagination
            ));
            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            Streamwide_Web_Log::debug('delete customer modal window');
            $this->view->assign('DeletedCustomerAccounts',$deleted);
        }
    }
}
