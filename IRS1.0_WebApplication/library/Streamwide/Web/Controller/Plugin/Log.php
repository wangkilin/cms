<?php
/**
 * $Rev: 2240 $
 * $LastChangedDate: 2010-01-18 23:32:51 +0800 (Mon, 18 Jan 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Log.php 2240 2010-01-18 15:32:51Z kwu $
 */

/**
 * Update %module% %controller% %action% in log header
 * Plugins: Log -> Acl
 * remain effective in between every other dispatch
 */
class Streamwide_Web_Controller_Plugin_Log extends Zend_Controller_Plugin_Abstract
{
    /**
     *
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        $front = Zend_Controller_Front::getInstance();
        $logger = $front->getParam('bootstrap')->getResource('logger');
        $logger->setEventItem('http',$request->isXmlHttpRequest() ? 'AJAX' : $request->getMethod());
        $logger->setEventItem('module',$module);
        $logger->setEventItem('controller',$controller);
        $logger->setEventItem('action',$action);
    }
}
/* EOF */
