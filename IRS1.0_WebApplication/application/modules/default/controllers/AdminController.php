<?php
/**
 * $Rev: 2615 $
 * $LastChangedDate: 2010-06-21 15:40:40 +0800 (Mon, 21 Jun 2010) $
 * $LastChangedBy: zwang $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: AdminController.php 2615 2010-06-21 07:40:40Z zwang $
 */

/**
 * 
 */
class AdminController extends Zend_Controller_Action
{
    /**
     *
     */
    public function init()
    {
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
     * create an admin user
     * Actual create
     * ---------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     * 
     * Name
     * EmailAddress
     * Password
     * AssignedProfileId
     * AssignedCustomerAccountId
     *
     * CustomerUserId
     * CustomerAccountId
     * 
     * <view-assign>
     * Name
     * CustomerAccountId
     * Pagination = array(
     *     CurrentPage =>
     *     ItemsPerPage =>
     * )
     * 
     * Modal Window
     * --------------
     * <request>
     * 
     * <view-assign>
     * Profiles = array(
     *   array(
     *     ProfileId
     *     Label
     *     SuperAdmin
     *     AdminUsers
     *     AdminTrees
     *     AdminResources
     *     AdminStats
     *     AgentCapability
     *   )
     * )
     *
     * CustomerAccounts = array(
     *     array(
     *         CustomerAccountId
     *         CustomerAccountName
     *         CustomerAccountBillingId
     *         ContactName
     *         ContactEmail
     *         ContactPhone
     *         CreationDateTime
     *         Quotas = array (
     *             MaxResPrompt
     *             MaxResOrigin
     *             MaxResBlacklist
     *             MaxResCalendar
     *             MaxResAgentgroup
     *             MaxResContact
     *             MaxResUser
     *         )
     *     )
     * )
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $customerAccountId = $request->getParam('CustomerAccountId'); //creator account id
        $customerUserId = $request->getParam('CustomerUserId'); //creator user id
        
        $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
        
        if ('create' == $act) {
            Streamwide_Web_Log::debug('create a user actual');

            $defaults = array(
               'Name' => '',
               'EmailAddress' => '',
               'Password' => '',
               'ParentUserId' => $customerUserId
            );
            $user = SwIRS_Web_Request::getParam($request, $defaults);
            $user['CustomerAccountId'] = $request->getParam('AssignedCustomerAccountId');
            $user['ProfileId'] = $request->getParam('AssignedProfileId');

            $userId = Streamwide_Web_Model::call('User.Create', array($user));
            Streamwide_Web_Log::debug("user $userId is created");
            
            $this->view->assign(
                array(
                    'Name' => $user['Name'],
                    'CustomerAccountId' => $customerAccountId,
                    'Pagination' => $pagination
                )
            );
            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug('create user modal window');
            $profiles = Streamwide_Web_Model::call('User.GetProfiles', array());
            $customerAccounts = array();

            if (SwIRS_Web_Request::isSuperAdmin($request)) {
                $customerAccounts = Streamwide_Web_Model::call('Customer.GetAll', array());
                $profiles = $this->_restrict($profiles,array('AgentCapability'=>1));
            } else {
                $customerAccount = Streamwide_Web_Model::call('Customer.GetById', array($customerAccountId));
                $customerAccounts = array($customerAccount);
                $profiles = $this->_restrict($profiles,array('AgentCapability'=>1,'SuperAdmin'=>1));
            }
            $this->view->assign(
                array(
                    'Profiles' => $profiles,
                    'CustomerAccounts' => $customerAccounts
                )
            );
        }
    }

    /**
     * list all admin users
     * <request>
     * CurrentPage
     * ItemsPerPage
     * UserNamePart
     * CustomerAccountId
     * 
     * <view-assign>
     * Users = array(
     *     array(
     *         UserId
     *         Name
     *         EmailAddress
     *         Password
     *         TemporaryPassword
     *         ProfileId
     *         ProfileLabel
     *         ParentUserId
     *         ParentUserName
     *         CustomerAccountId
     *         CustomerAccountName
     *         IsLocked
     *         AgentParametersId
     *         AgentParameters => array(
     *             PhoneNumber
     *             DisponibilityTime
     *             UnlimitedDisponibility
     *         )
     *     )
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
        $userNamePart = $request->getParam('UserNamePart','');
        $userNamePart = trim($userNamePart);
        $customerAccountId = $request->getParam('CustomerAccountId');
        
        $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
        
        $users = array();
        if (strlen($userNamePart) > 0) {
            Streamwide_Web_Log::debug("list users whose name contains $userNamePart");
            $users = Streamwide_Web_Model::call('User.GetByNamePart',
                array(
                    $customerAccountId,
                    $userNamePart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('User.Count', array($customerAccountId, $userNamePart));
        } else {
            Streamwide_Web_Log::debug('list users');
            $users = Streamwide_Web_Model::call('User.GetByCustomer',
                array(
                    $customerAccountId,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('User.Count', array($customerAccountId));
        }
        $this->view->assign(
            array(
                'Users' => $users,
                'Pagination' => $pagination
            )
        );
    }

    /**
     * update an admin user
     * Actual update
     * ----------------
     * <request>
     * Act
     * UserId
     * Name
     * EmailAddress
     * Password
     * AssignedProfileId
     * AssignedCustomerAccountId
     * IsLocked
     * 
     * <view-assign>
     * Result
     * User = array(
     *     UserId
     *     Name
     *     EmailAddress
     *     Password
     *     TemporaryPassword
     *     ProfileId
     *     ProfileLabel
     *     ParentUserId
     *     ParentUserName
     *     CustomerAccountId
     *     CustomerAccountName
     *     IsLocked
     *     AgentParametersId
     *     AgentParameters => array(
     *         PhoneNumber
     *         DisponibilityTime
     *         UnlimitedDisponibility
     *     )
     * )
     * 
     * Modal Window
     * ------------------
     * <request>
     * UserId
     * CustomerAccountId
     * 
     * <view-assign>
     * User = array(
     *     UserId
     *     Name
     *     EmailAddress
     *     Password
     *     TemporaryPassword
     *     ProfileId
     *     ProfileLabel
     *     ParentUserId
     *     ParentUserName
     *     CustomerAccountId
     *     CustomerAccountName
     *     IsLocked
     *     AgentParametersId
     *     AgentParameters => array(
     *         PhoneNumber
     *         DisponibilityTime
     *         UnlimitedDisponibility
     *     )
     * )
     * Profiles =array(
     *   array(
     *     ProfileId
     *     Label
     *     SuperAdmin
     *     AdminUsers
     *     AdminTrees
     *     AdminResources
     *     AdminStats
     *     AgentCapability
     *     )
     * )
     * CustomerAccounts = array(
     *     array(
     *         CustomerAccountId
     *         CustomerAccountName
     *         .......
     *     )
     * )
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $userId = $request->getParam('UserId');
        
        if ('update' == $act) {
            Streamwide_Web_Log::debug('update a user actual');
            $defaults = array(
                'UserId' => $userId,
                'Name' => null,
                'EmailAddress' => null,
                'Password' => null,
                'IsLocked' => null
            );
            $user = SwIRS_Web_Request::getParam($request, $defaults);
            $user['CustomerAccountId'] = $request->getParam('AssignedCustomerAccountId');
            $user['ProfileId'] = $request->getParam('AssignedProfileId');
            $result = Streamwide_Web_Model::call('User.Update', array($user));
            
            Streamwide_Web_Log::debug("user $userId is updated");
            $this->view->assign('Result',$result);
            $this->getHelper('viewRenderer')->direct('update-ack');
        } else {
            Streamwide_Web_Log::debug("update user modal window");
            $profiles = Streamwide_Web_Model::call('User.GetProfiles', array());
            $customerAccounts = array();

            if (SwIRS_Web_Request::isSuperAdmin($request)) {
                $customerAccounts = Streamwide_Web_Model::call('Customer.GetAll', array());
                $profiles = $this->_restrict($profiles,array('AgentCapability'=>1));
            } else {
                $customerAccountId = $request->getParam('CustomerAccountId');
                $customerAccount = Streamwide_Web_Model::call('Customer.GetById', array($customerAccountId));
                $customerAccounts = array($customerAccount);
                $profiles = $this->_restrict($profiles,array('AgentCapability'=>1,'SuperAdmin'=>1));
            }
            $this->view->assign(
                array(
                    'Profiles' => $profiles,
                    'CustomerAccounts' => $customerAccounts
                )
            );
        }
        $user = Streamwide_Web_Model::call('User.GetById', array($userId));
        $this->view->assign('User',$user);
    }

    /**
     * delete an admin user
     * Actual delete
     * ----------------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     * UserIds = array($UserId)
     * UserNames = array($UserName)
     * CustomerAccountId
     * 
     * <view-assign>
     * DeletedUsers
     * CustomerAccountId
     * Pagination = array(
     *     CurrentPage => 
     *     ItemsPerPage => 
     * )
     * 
     * Modal Window
     * --------------
     * <request>
     * UserIds = array($UserId)
     * UserNames = array($UserName)
     * 
     * <view-assign>
     * DeletedUsers
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $customerAccountId = $request->getParam('CustomerAccountId');
        
        $userIds = $request->getParam('UserIds');
        $userNames = $request->getParam('UserNames');
        $deletedUsers = implode(',', $userNames);
        
        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
            
            foreach ($userIds as $userId) {
                Streamwide_Web_Model::call('User.Delete', array($userId));
            }
            Streamwide_Web_Log::debug("deleted user $deletedUsers");
            $this->view->assign(
                array(
                    'DeletedUsers' => $deletedUsers,
                    'CustomerAccountId' => $customerAccountId,
                    'Pagination' => $pagination
                )
            );
            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            Streamwide_Web_Log::debug('delete user modal window');
            $this->view->assign('DeletedUsers', $deletedUsers);
        }
    }

    /**
     * update an user account
     *
     * --------------------//Actual update
     * <request>
     * 'Act'               //string
     * 'CustomerUserId'    //numberic
     * 'Name'              //string
     * 'EmailAddress'      //string
     * 'Password'          //string
     * <view-assign>
     *
     * --------------------//Default
     * <request>
     * <view-assign>
     * 'CurrentRequestUri' //string   for navigation menu
     * 'User'              //struct
     *
     * @return void
     */
    public function accountAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $userId = $request->getParam('CustomerUserId');

        if ($request->isPost() && $request->isXmlHttpRequest()) {
            Streamwide_Web_Log::debug('update a user account actual');
            $defaults = array(
                'UserId' => $userId,
                'Name' => null,
                'EmailAddress' => null,
                'Password' => null
            );
            $user = SwIRS_Web_Request::getParam($request, $defaults);
            $result = Streamwide_Web_Model::call('User.Update', array($user));
            if ('OK' == $result) {
                $_SESSION['SwIRS_Web']['userInfo'] = Streamwide_Web_Model::call('User.GetById', array($userId));
                if (array_key_exists('Password', $user)) {
                    $_SESSION['SwIRS_Web']['password'] = $user['Password'];
                }
                $_SESSION['SwIRS_Web']['customerState'] = SwIRS_Web_Request::STATE_ACTIVE;
            }
            $this->view->assign(array(
                'Result' => $result,
                'User' => $_SESSION['SwIRS_Web']['userInfo']
            ));
            $this->getHelper('viewRenderer')->direct('account-ack');
        }

        $this->view->assign(array(
            'CurrentRequestUri' => 'admin/account',
            'User' => $_SESSION['SwIRS_Web']['userInfo']
       ));
    }

    /**
     * <request>
     * AssignedCustomerAccountId
     */
    public function sudoAction()
    {
        $request = $this->getRequest();
        $customerAccountId = $request->getParam('AssignedCustomerAccountId');

        $_SESSION['SwIRS_Web']['customerAccountId'] = $customerAccountId;
        if ($customerAccountId != SwIRS_Web_Request::SUPER_ADMIN_CUSTOMER_ACCOUNT_ID) {
            Streamwide_Web_Log::debug("super admin sudo as $customerAccountId");
            $_SESSION['SwIRS_Web']['menu'] = SwIRS_Web_Request::getMenu(SwIRS_Web_Request::ACCOUNT_ADMIN);
        } else {
            Streamwide_Web_Log::debug("super admin quits sudo");
            $_SESSION['SwIRS_Web']['menu'] = SwIRS_Web_Request::getMenu(SwIRS_Web_Request::SUPER_ADMIN);
        }
    }

    /**
     * import admin file
     * <request>
     * Act
     * CustomerAccountId
     * CustomerUserId
     * 
     * <view-assign>
     * ImportJobId
     * CustomerAccountId
     * CustomerUserId
     */
    public function importAction()
    {
        $this->view->layout()->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender();
        
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $customerAccountId = $request->getParam('CustomerAccountId');
        $customerUserId = $request->getParam('CustomerUserId');
        if ('import' == $act) {
            if (isset($_FILES['Filedata'])) {
                Streamwide_Web_Log::debug("import admin file". $_FILES['Filedate']['name']);
                $fileContent = file_get_contents($_FILES['Filedate']['tmp_name']);
                $importJobId = Streamwide_Web_Model::call('User.Import', array(
                    $customerAccountId,
                    base64_encode($fileContent)
                ));
                $this->view->assign(array(
                    'ImportJobId' => $importJobId,
                    'CustomerAccountId' => $customerAccountId,
                    'CustomerUserId' => $customerUserId
                ));
                $this->getHelper('viewRenderer')->direct('import-ack');
            } else {
                //do nothing
            }
        } else {
            Streamwide_Web_Log::debug('import admin file');
        }        
    }

    /**
     * 
     */
    public function exportAction()
    {
        $this->view->layout()->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender();
        
        $request = $this->getRequest();
        $customerAccountId = $request->getParam('CustomerAccountId');
        $act = $request->getParam('Act');
        
        if ('export' == $act) {
            Streamwide_Web_Log::debug("export $customerAccountId admin file");
            $fileContent = Streamwide_Web_Model::call('User.Export', array($customerAccountId));
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
            Streamwide_Web_Log::debug('export admin file');
        }
    }

    /**
     *
     */
    private function _restrict(array $profiles,array $filters)
    {
        $restricted = array();
        foreach ($profiles as $profile) {
            $filtered = false;
            foreach ($filters as $filter => $value) {
                if ($profile[$filter] == $value) {
                    $filtered = true;
                    break;
                }
            }
            if (!$filtered) {
                $restricted[] = $profile;
            }
        }
        return $restricted;
    }
}
