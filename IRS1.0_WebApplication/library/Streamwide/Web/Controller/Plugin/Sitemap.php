<?php
/**
 * $Rev: 2478 $
 * $LastChangedDate: 2010-04-04 00:48:39 +0800 (Sun, 04 Apr 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Sitemap.php 2478 2010-04-03 16:48:39Z kwu $
 */

/**
 *
 */
class Streamwide_Web_Controller_Plugin_Sitemap extends Zend_Controller_Plugin_ErrorHandler
{
    /**
     *
     */
    public function __construct(array $option = array())
    {
        $errorhandler = array('controller'=>'index','action'=>'sitemap');
        $errorhandler = array_merge($errorhandler,$option);
        parent::__construct($errorhandler);
    }

    /**
     * 
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        if ($request->has('mca')) {
            $mca = $request->getParam('mca');
            list($module,$controller,$action) = explode('/',$mca);
            $request->setModuleName($module)
                    ->setControllerName($controller)
                    ->setActionName($action);
            $keys   = $request->getParam('key');
            $values = $request->getParam('value');
            $request->setParamSources();
            $params = array_combine($keys,$values);
            if (get_magic_quotes_gpc()) {
                foreach ($params as $key => &$value) {
                    $decode = Zend_Json::decode(stripslashes($value), Zend_Json::TYPE_ARRAY);
                    if (!empty($decode)) {
                        $value = $decode;
                    }
                }
            }
            $request->setParams($params);
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
