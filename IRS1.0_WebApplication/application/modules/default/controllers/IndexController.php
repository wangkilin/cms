<?php
/**
 * $Rev: 2610 $
 * $LastChangedDate: 2010-06-21 11:31:27 +0800 (Mon, 21 Jun 2010) $
 * $LastChangedBy: slan $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: IndexController.php 2610 2010-06-21 03:31:27Z slan $
 */

/**
 *
 */
class IndexController extends Zend_Controller_Action
{
    /**
     * Initialization
     *
     * @return void
     */
    public function init()
    {
    }

    /**
     * Index, gateway for this web application
     * While the operator is not logged in, direct to login action
     * While the operator has been logged in but is locked, direct to account action in admin controller
     * Otherwise, direct to dashboard action
     * @see Zend_Controller_Action_Helper_ActionStack::direct() for more detail
     *
     * @return void
     */
    public function indexAction()
    {
        $this->getHelper('viewRenderer')->setNoRender();
        $request = $this->getRequest();
        $actionStackHelper = $this->getHelper('actionStack');
        if (SwIRS_Web_Request::isVisitor($request)) {
            $actionStackHelper->direct('login', null, null);
        } elseif (SwIRS_Web_Request::isProvisional($request)) {
            $actionStackHelper->direct('account', 'admin', null);
        } else {
            $actionStackHelper->direct('dashboard', null, null);
        }
    }

    /**
     * Dashboard, the home for this web application
     *
     * @return void
     */
    public function dashboardAction()
    {
        Streamwide_Web_Log::debug('rendering the dashboard');
        $request = $this->getRequest();
        $viewDatas = array();
        $viewDatas['IsSuperAdmin'] = SwIRS_Web_Request::isSuperAdmin($request);
        if (!SwIRS_Web_Request::isSuperAdmin($request) && !SwIRS_Web_Request::isVisitor($request)) {
            $viewDatas['TreeLists'] = Streamwide_Web_Model::call('Tree.GetLastModified', array(false));
        }
        $this->view->assign($viewDatas);
    }

    /**
     * Login, register environments on this web application
     *
     * --------------------//Actual Login
     * <request>
     * 'Username'          //string
     * 'Password'          //string
     * <view-assign>
     * 'User'              //struct        $loggedUserInfo
     *
     * --------------------//Default
     * <request>
     * <view-assign>
     *
     * @return void
     */
    public function loginAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {

            if ($this->getRequest()->isXmlHttpRequest()) {
                $this->getHelper('Layout')->disableLayout();
            }

            $username = $request->getParam("Username");
            $password = $request->getParam("Password");

            $webservice = $this->getInvokeArg('bootstrap')->getResource('webservice');
            $webservice->setAuth(array('user' => $username,'password' => $password));

            $user = Streamwide_Web_Model::call('User.Login', array($username, $password));
            //$user = $user[0];

            Streamwide_Web_Log::debug("user $username login");
            $namespace = new Zend_Session_Namespace('SwIRS_Web');
            $namespace->userInfo = $user;
            $namespace->username = $username;
            $namespace->password = $password;
            $namespace->customerState = $user['TemporaryPassword'];
            $namespace->customerUserId = $user['UserId'];
            $namespace->customerAccountId = $user['CustomerAccountId'];
            $namespace->secondaryCustomerAccountId = $user['CustomerAccountId'];

            $profile = Streamwide_Web_Model::call('User.GetProfileById',array($user['ProfileId']));
            $namespace->profile = $profile;

            $role = SwIRS_Web_Request::getRole($profile);
            $_SESSION['APPLICATION_ROLE'] = $role;
            if ($role == SwIRS_Web_Request::SUPER_ADMIN) {
                $namespace->customerAccountId = SwIRS_Web_Request::SUPER_ADMIN_CUSTOMER_ACCOUNT_ID;
                $namespace->secondaryCustomerAccountId = SwIRS_Web_Request::SUPER_ADMIN_CUSTOMER_ACCOUNT_ID;
            }
            if ($namespace->customerState == SwIRS_Web_Request::STATE_PROVISIONAL) {
                $role = SwIRS_Web_Request::PROVISIONAL;
            }

            $menu = SwIRS_Web_Request::getMenu($role);
            $namespace->menu = $menu;

            $this->view->assign('User', $user);
            $this->getHelper('viewRenderer')->direct('login-ack');
        }
    }

    /**
     * Logout, unregister environments on this web application
     *
     * @return void
     */
    public function logoutAction()
    {
        $this->view->layout()->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender();

        $request = $this->getRequest();
        $customerUserId = $request->getParam('CustomerUserId');
        Streamwide_Web_Log::debug("user $customerUserId logout");
        Zend_Session::destroy();
        $this->getHelper('redirector')->gotoSimpleAndExit('index');
    }

    /**
     * Locale, quick switcher locale environment on this web application
     *
     * @return void
     */
    public function localeAction()
    {
        $request = $this->getRequest();
        $locale = $request->getParam('Locale','en');
        $_SESSION['APPLICATION_LOCALE'] = $locale;
        $this->getHelper('viewRenderer')->setNoRender();
    }

    /**
     * Reset, handling the operator reset their password
     *
     * --------------------//Actual Reset
     * <request>
     * 'Username'          //string
     * <view-assign>
     * 'Result'            //string        'OK' while succeed
     *
     * @return void
     */
    public function resetAction()
    {
        $this->getHelper('ViewRenderer')->setNoRender();
        $this->getHelper('Layout')->disableLayout();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $username = $request->getParam("Username");
            Streamwide_Web_Log::debug("reset user $username");
            $result = Streamwide_Web_Model::call('User.Reset',array($username));
            $this->view->assign('Result', $result);
            $this->getHelper('viewRenderer')->render('reset-ack');
        }
    }

    /**
     * Sitemap, internal tool for developer
     * @see Streamwide_Web_Application_Resource_Sitemap
     *
     * --------------------//Actual Reset
     * <request>
     * <view-assign>
     * 'sitemap'           //array
     *
     * @return void
     */
    public function sitemapAction()
    {
        $this->view->assign(
            'sitemap',
            $this->getInvokeArg('bootstrap')->getResource('sitemap')
        );
    }
}

/* EOF */
