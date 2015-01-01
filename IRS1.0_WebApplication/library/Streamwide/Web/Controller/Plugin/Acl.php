<?php
/**
 * $Rev: 2245 $
 * $LastChangedDate: 2010-01-20 18:34:11 +0800 (Wed, 20 Jan 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Acl.php 2245 2010-01-20 10:34:11Z kwu $
 */

/**
 * Check ACL
 * Plugins: Log -> Acl
 * remain effective in between every other dispatch
 * filter the response object while dispatch loop shutdown
 */
class Streamwide_Web_Controller_Plugin_Acl extends Zend_Controller_Plugin_ErrorHandler
{
    /**
     *
     */
    public function __construct(array $option = array())
    {
        $errorhandler = array('controller'=>'error','action'=>'acl');
        $errorhandler = array_merge($errorhandler,$option);
        parent::__construct($errorhandler);
    }

    /**
     * 
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        $front = Zend_Controller_Front::getInstance();
        $acl = $front->getParam('bootstrap')->getResource('acl');
        $role = $front->getParam('bootstrap')->getPluginResource('acl')->getRole();

        $allow = false;
        do {
            if (!$acl->hasRole($role)) {
                break;
            }
            if ($acl->isAllowed($role)) {
                $allow = true;
                break;
            }

            $mca = new Streamwide_Web_Acl_Resource_Mca($module,$controller,$action);
            $all = new Streamwide_Web_Acl_Resource_Mca('*','*','*');
            if ($acl->has($mca)) {
                $allow = $acl->isAllowed($role,$mca); 
            } else { //the resource is not defined in acl,check against its *.*.* definition
                $allow = $acl->isAllowed($role,$all); 
            }
        }
        while (0);

        if (!$allow) {
            $request->setModuleName($this->getErrorHandlerModule())
                    ->setControllerName($this->getErrorHandlerController())
                    ->setActionName($this->getErrorHandlerAction());
        }
    }

    /**
     * overwrite ErrorHandler plugin, do nothing
     */
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
    }
}
/* EOF */
