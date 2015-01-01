<?php
/**
 * $Rev: 2405 $
 * $LastChangedDate: 2010-03-08 16:40:03 +0800 (Mon, 08 Mar 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Sitemap.php 2405 2010-03-08 08:40:03Z kwu $
 */

/**
 *
 */
class Streamwide_Web_Application_Resource_Sitemap extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_Navigation
     */
    protected $_sitemap = null;

    /**
     *
     */
    public function init()
    {
        $this->getBootstrap()->bootstrap('FrontController')
                             ->bootstrap('Acl');
        $front = $this->getBootstrap()->getResource('FrontController');
        if (!$front->hasPlugin('Streamwide_Web_Controller_Plugin_Sitemap')) {
            $front->registerPlugin(new Streamwide_Web_Controller_Plugin_Sitemap($this->_options),3); //3: the very first plugin after Acl
        }
        return $this->getSitemap();
    }

    /**
     *
     */
    public function getSitemap()
    {
        if (is_null($this->_sitemap)) {
            $options = $this->getOptions();
            $front = $this->getBootstrap()->getResource('FrontController');
            $root = dirname($front->getModuleDirectory()); //modules directory
            $acl = $this->getBootstrap()->getResource('Acl');
            $role = $this->getBootstrap()->getPluginResource('acl')->getRole();

            try{
                $dir = new DirectoryIterator($root);
            }catch(Exception $e){
                throw new Streamwide_Exception("Directory $root not readable");
            }
            $this->_sitemap = new Zend_Navigation();
            foreach ($dir as $file) {
                if ($file->isDot() || !$file->isDir()) {
                    continue;
                }

                $module = $file->getFilename();
                // Don't use SCCS directories as modules
                if (preg_match('/^[^a-z]/i', $module) || ('CVS' == $module)) {
                    continue;
                }

                $controllerPath = "$root/$module/controllers";
                $controllers = $this->_getControllers($controllerPath);
                foreach ($controllers as $controller => $class) {
                    $actions = $this->_getActions($class);
                    foreach ($actions as $action) {
                        $mca = new Streamwide_Web_Acl_Resource_Mca($module,strtolower($controller),strtolower($action));
                        $all = new Streamwide_Web_Acl_Resource_Mca('*','*','*');
                        if ($acl->has($mca) && !$acl->isAllowed($role,$mca)) continue;
                        if (!$acl->has($mca) && !$acl->isAllowed($role,$all)) continue;
                        $this->_sitemap->addPage(Zend_Navigation_Page::factory(
                            array(
                                "label"=>"$module/$controller/$action",
                                "module"=>$module,
                                "controller"=>$controller,
                                "action"=>$action)
                        ));
                    }
                }
            }
        }
        return $this->_sitemap;
    }

    /**
     *
     */
    protected function _getControllers($controllerPath)
    {
        $controllers = array();
        try{
            $dir = new DirectoryIterator($controllerPath);
        }catch(Exception $e){
            throw new Streamwide_Exception("Directory $controllerPath not readable");
        }

        $module = basename(dirname($controllerPath)); //default, admin ...
        $module = $module == 'default' ?  "" : ucfirst($module) . "_";

        foreach ($dir as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }
            $controllerFile = $file->getFilename();
            $match = array();
            if (!preg_match('/([A-Za-z0-9]+)Controller.php$/', $controllerFile,$match)) {
                continue;
            }
            Zend_Loader::loadFile($controllerFile,$controllerPath,true);
            $controller = $match[1];
            $controllers[$controller] = $module . $controller . "Controller";
        }
        return $controllers;
    }

    /**
     *
     */
    protected function _getActions($controllerClass)
    {
        $methods = get_class_methods($controllerClass);
        foreach ($methods as $key => &$method) {
            $match = array();
            if (!preg_match('/([A-Za-z0-9]+)Action$/', $method,$match)) {
                unset($methods[$key]);
                continue;
            }
            $method = $match[1];
        }
        return $methods;
    }
}
/* EOF */
