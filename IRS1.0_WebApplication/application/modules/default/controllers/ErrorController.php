<?php
/**
 * $Rev: 2566 $
 * $LastChangedDate: 2010-06-17 12:37:55 +0800 (Thu, 17 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: ErrorController.php 2566 2010-06-17 04:37:55Z junzhang $
 */

/**
 * Error handler while exceptions raised (@see Zend_Controller_Plugin_ErrorHandler).
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     * Const - Model Exception; exceptions thrown by Zend_XmlRpc_Client_FaultException
     */
    const EXCEPTION_MODEL = 'EXCEPTION_MODEL';

    /**
     * Error, instance on (@link Zend_Controller_Plugin_ErrorHandler)
     *
     * @return void
     */
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        $exception = $errors->exception;
        $exceptionType = get_class($exception);
        switch ($exceptionType) {
            case 'Zend_XmlRpc_Client_FaultException':
                $error->type = self::EXCEPTION_MODEL;
                Streamwide_Web_Log::error($exception->getCode() . ':' . $exception->getMessage());
                break;
            default:
                break;
        }
        
        switch ($errors->type) { 
            case self::EXCEPTION_MODEL:
                $this->view->message = 'XmlRpc error';
                break;
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;

        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->getHelper('viewRenderer')->direct('ajax');
        }
    }

    /**
     * Acl, error while the access deny
     * For Role[visitor] (@see SwIRS_Web_Request::isVisitor()), redirect to homepage
     * Otherwise, displayed the 403 Error page
     *
     * @return void
     */
    public function aclAction()
    {
        $this->getHelper('Layout')->disableLayout();
        Streamwide_Web_Log::debug('acl rejected');
        $request = $this->getRequest();
        if (SwIRS_Web_Request::isVisitor($request)) {
            Streamwide_Web_Log::debug('redirect the role[visitor] to homepage');
            $this->getHelper('ViewRenderer')->setNoRender();
            $this->getHelper('Redirector')->gotoSimpleAndExit('index', 'index');
        } else {
            // 403 error -- HTTP Error 403, access forbidden
            $this->getResponse()->setHttpResponseCode(403);
        }
    }
}

/* EOF */