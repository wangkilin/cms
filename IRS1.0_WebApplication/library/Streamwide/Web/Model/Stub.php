<?php
/**
 * $Rev: 2603 $
 * $LastChangedDate: 2010-05-17 22:40:22 +0800 (Mon, 17 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web_Model
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Stub.php 2603 2010-05-17 14:40:22Z kwu $
 */

/**
 * 
 */
class Streamwide_Web_Model_Stub implements Streamwide_Web_Model_Interface
{
    /**
     *
     */
    private $_methods = array();

    /**
     *
     */
    public function __construct($class)
    {
        $methods = get_class_methods($class);
        foreach ($methods as $method)
        {
            if (preg_match("/^[A-Za-z]+_[A-Za-z]+$/",$method)) {
                $this->_methods[preg_replace("/_/",".",$method)] = array($class,$method);
            }
        }
    }

    /**
     *
     */
    public function add($method,$functor)
    {
        if (is_callable($functor)) {
            $this->_methods[$method] = $functor;
        }
    }

    /**
     *
     */
    public function call($method,array $params = array())
    {
        if (!array_key_exists($method,$this->_methods)) {
            throw new Streamwide_Exception("$method is not defined in model stub");
        }
        $methodToCall = $this->_methods[$method];
        return call_user_func($methodToCall,$params);
    }
}
/* EOF */
