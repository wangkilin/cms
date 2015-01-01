<?php
/**
 * $Rev: 2555 $
 * $LastChangedDate: 2010-06-13 17:30:25 +0800 (Sun, 13 Jun 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @subpackage application
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Bootstrap.php 2555 2010-06-13 09:30:25Z yaoli $
 */

/**
 * Bootstrap for web application
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    private $_request = null;

    /**
     *
     */
    public function __construct($application)
    {
        //restore the session id after flash upload
        $request = $this->getRequest();
        if ($request->isFlashRequest()) {
            $sessionId = $this->getRequest()->getParam('PHPSESSID');
            if (!is_null($sessionId)) {
                Zend_Session::setId($sessionId);
            }
        }
        parent::__construct($application);
    }

    /**
     *
     */
    public function getRequest()
    {
        if (is_null($this->_request)) {
            $this->_request = new Zend_Controller_Request_Http();
        }
        return $this->_request;
    }

    /**
     *
     */
    public function init()
    {
        if (Zend_Session::isStarted() && Zend_Session::namespaceIsset('SwIRS_Web')) {
            $session = Zend_Session::namespaceGet('SwIRS_Web');
            $this->getRequest()->setParam('CustomerState',$session['customerState']);
            $this->getRequest()->setParam('CustomerUserId',$session['customerUserId']);
            $this->getRequest()->setParam('CustomerAccountId',$session['customerAccountId']);
            $this->getRequest()->setParam('SecondaryCustomerAccountId',$session['secondaryCustomerAccountId']);
            $this->getRequest()->setParam('Profile',$session['profile']);

            $webservice = $this->getResource('webservice');
            $webservice->setAuth(array('user'=>$session['username'],'password'=>$session['password']));

        }
        $front = $this->getResource('FrontController');
        $front->setRequest($this->getRequest());
    }

    /**
     *
     */
    public function run()
    {
        $this->init();
        parent::run();
    }
}
