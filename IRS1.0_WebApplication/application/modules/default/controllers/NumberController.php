<?php
/**
 * $Rev: 2567 $
 * $LastChangedDate: 2010-06-17 15:58:32 +0800 (Thu, 17 Jun 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: NumberController.php 2567 2010-06-17 07:58:32Z yaoli $
 */

/**
 *
 */
class NumberController extends Zend_Controller_Action
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

        $request = $this->getRequest();
        $this->view->assign(array(
            'IsSuperAdmin' => SwIRS_Web_Request::isSuperAdmin($request)
        ));
    }

    /**
     *
     */
    public function indexAction()
    {
        $this->listAction();
    }

    /**
     * create a premium number
     * Actual create
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * PremiumNumber
     * PremiumNumberUi
     * SolutionId
     * AssignedCustomerAccountId
     * MaxCallDuration
     *
     * <view-assign>
     * PremiumNumberUi
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     *
     * Modal window
     * -------------
     * <request>
     * <view-assign>
     * Solutions = array(
     *      array(
     *          SolutionId
     *          SolutionTypeId
     *          SolutionType
     *          TemplateTreeId
     *          TemplateTreeLabel
     *      )
     * )
     *
     * Customers = array(
     *      array(
     *          CustomerAccountId
     *          CustomerAccountName
     *          CustomerAccountBillingId
     *          ContactName
     *          ContactEmail
     *          ContactPhone
     *          Quotas = array(
     *              MaxResPrompt
     *              MaxResOrigin
     *              MaxResBlacklist
     *              MaxResCalendar
     *              MaxResAgentgroup
     *              MaxResContact
     *              MaxResUser
     *          )
     *      )
     * )
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        if ('create' == $act) {
            Streamwide_Web_Log::debug("create a premium number actual");
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            $defaults = array(
                'PremiumNumber' => '0',
                'PremiumNumberUi' => '0',
                'SolutionId' => 0,
                'MaxCallDuration' => 0
            );
            $premiumNumber = SwIRS_Web_Request::getParam($request,$defaults);
            $premiumNumber['CustomerAccountId'] = $request->getParam('AssignedCustomerAccountId');
            $premiumNumberId = Streamwide_Web_Model::call('PremiumNumber.Create',array($premiumNumber));
            Streamwide_Web_Log::debug("premium number $premiumNumberId is created");

            $this->view->assign(array(
                'PremiumNumberUi' => $premiumNumber['PremiumNumberUi'],
                'CustomerAccountId' => $request->getParam('CustomerAccountId'), //SwIRS_Web_Request::SUPER_ADMIN_CUSTOMER_ACCOUNT_ID,
                                                                                //only super admin can create premium numbers
                'Pagination' => $pagination
            ));
            $this->getHelper('viewRenderer')->direct('create-ack');
         } else {
            Streamwide_Web_Log::debug("create a premium number modal window");
            $solutions = Streamwide_Web_Model::call('Solution.GetAll',array());
            $customers = Streamwide_Web_Model::call('Customer.GetAll',array());
            $this->view->assign(array(
                'Solutions' => $solutions,
                'Customers' => $customers
            ));
        }
    }

    /**
     * list premium numbers
     * <request>
     * CurrentPage
     * ItemsPerPage
     * PremiumNumberUiPart
     * CustomerAccountId
     *
     * <view-assign>
     * PremiumNumbers = array(
     *      array(
     *          PremiumNumberId
     *          PremiumNumber
     *          PremiumNumberUi
     *          PremiumNumberGroupId
     *          PremiumNumberGroupName
     *          CustomerAccountId
     *          CustomerAccountName
     *          MaxCallDuration
     *          StaticContactId
     *          StaticContactName
     *          StaticContactPhoneNumber
     *          CreationDateTime
     *          SolutionId
     *          SolutionTypeId
     *          SolutionType
     *          TemplateTreeId
     *          TemplateTreeLabel
     *      )
     * )
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     *      ItemsTotal =>
     * )
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $premiumNumberUiPart = $request->getParam('PremiumNumberUiPart','');
        $premiumNumberUiPart = trim($premiumNumberUiPart);
        $customerAccountId = $request->getParam('CustomerAccountId');
        $isSuperAdmin = $request->getParam('IsSuperAdmin');

        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
        $premiumNumbers = array();
        if (strlen($premiumNumberUiPart) > 0) {
            Streamwide_Web_Log::debug("list premium numbers which contain $premiumNumberUiPart");
            $premiumNumbers = Streamwide_Web_Model::call('PremiumNumber.GetByNumberPart',
                array(
                    $customerAccountId,
                    $premiumNumberUiPart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('PremiumNumber.Count',array($customerAccountId,$premiumNumberUiPart));
        } else {
            Streamwide_Web_Log::debug("list premium numbers");
            $premiumNumbers = Streamwide_Web_Model::call('PremiumNumber.GetByCustomer',
                array(
                    $customerAccountId,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('PremiumNumber.Count',array($customerAccountId));
        }
        $this->view->assign(array(
            'PremiumNumbers' => $premiumNumbers,
            'Pagination' => $pagination
        ));

        if (null != $isSuperAdmin) {
            $this->view->assign(array(
                'IsSuperAdmin' => $isSuperAdmin
            ));
        }
    }

    /**
     * update a premium number
     *
     * Actual update
     * -------------
     * <request>
     * Act
     * PremiumNumberId
     * MaxCallDuration
     * StaticContactId
     * StaticContactPhone
     *
     * <view-assign>
     * Result
     * PremiumNumber = array(
     *     PremiumNumberId
     *     PremiumNumber
     *     PremiumNumberUi
     *     PremiumNumberGroupId
     *     PremiumNumberGroupName
     *     CustomerAccountId
     *     CustomerAccountName
     *     MaxCallDuration
     *     StaticContactId
     *     StaticContactName
     *     StaticContactPhoneNumber
     *     CreationDateTime
     *     SolutionId
     *     SolutionTypeId
     *     SolutionType
     *     TemplateTreeId
     *     TemplateTreeLabel
     * )
     *
     * Modal window
     * -------------
     * <request>
     * PremiumNumberId
     * <view-assign>
     * PremiumNumber = array(
     *     PremiumNumberId
     *     PremiumNumber
     *     PremiumNumberUi
     *     PremiumNumberGroupId
     *     PremiumNumberGroupName
     *     CustomerAccountId
     *     CustomerAccountName
     *     MaxCallDuration
     *     StaticContactId
     *     StaticContactName
     *     StaticContactPhoneNumber
     *     CreationDateTime
     *     SolutionId
     *     SolutionTypeId
     *     SolutionType
     *     TemplateTreeId
     *     TemplateTreeLabel
     * )
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $premiumNumberId = $request->getParam('PremiumNumberId');
        if ('update' == $act) {
            Streamwide_Web_Log::debug("update premium number $premiumNumberId actual");
            $defaults = array(
                'MaxCallDuration' => null,
                'StaticContactId' => null,
                'StaticContactPhone' => null
            );
            $premiumNumber = SwIRS_Web_Request::getParam($request,$defaults);
            if (!empty($premiumNumber)) {
                $premiumNumber['PremiumNumberId'] = $premiumNumberId;
                $result = Streamwide_Web_Model::call('PremiumNumber.Update',array($premiumNumber));
                $this->view->assign('Result',$result);
            }
            $this->getHelper('viewRenderer')->direct('update-ack');
        }
        $premiumNumber = Streamwide_Web_Model::call('PremiumNumber.GetById',array($premiumNumberId));
        $this->view->assign('PremiumNumber',$premiumNumber);

        $isSuperAdmin = true;
        if (!SwIRS_Web_Request::isSuperAdmin($request)) {
            $isSuperAdmin = false;
            $this->getHelper('viewRenderer')->direct('update-redirect'); //update redirect number view for static solution
        }
        //update max call duraion view for super admin
    }

    /**
     * delete a premium number
     * Actual delete
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * PremiumNumberIds = array($PremiumNumberId)
     * PremiumNumberUis = array($PremiumNumberUi)
     *
     * <view-assign>
     * DeletedPremiumNumberUis
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     *
     * Modal window
     * -------------
     * <request>
     * PremiumNumberIds = array($PremiumNumberId)
     * PremiumNumberUis = array($PremiumNumberUi)
     *
     * <view-assign>
     * DeletedPremiumNumberUis
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $premiumNumberIds = $request->getParam('PremiumNumberIds');
        $premiumNumberUis = $request->getParam('PremiumNumberUis');
        $deleted = implode(',',$premiumNumberUis);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($premiumNumberIds as $premiumNumberId) {
                $result = Streamwide_Web_Model::call('PremiumNumber.Delete',array($premiumNumberId));
            }
            Streamwide_Web_Log::debug("deleted premium number $deleted");
            $this->view->assign(array(
                'DeletedPremiumNumberUis' => $deleted,
                'CustomerAccountId' => $request->getParam('CustomerAccountId'), //SwIRS_Web_Request::SUPER_ADMIN_CUSTOMER_ACCOUNT_ID,
                                                                                //only super admin can delete premium numbers
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            $this->view->assign('DeletedPremiumNumberUis', $deleted);
        }
     }
}
/* EOF */
