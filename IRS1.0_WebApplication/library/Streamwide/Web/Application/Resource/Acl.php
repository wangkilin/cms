<?php
/**
 * $Rev: 2504 $
 * $LastChangedDate: 2010-04-16 12:31:00 +0800 (Fri, 16 Apr 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Acl.php 2504 2010-04-16 04:31:00Z junzhang $
 */

/**
 * Resource for setting Acl options
 */
class Streamwide_Web_Application_Resource_Acl extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Instance of Zend_Acl
     *
     * @var Zend_Acl
     */
    protected $_acl = null;

    /**
     * Instance role
     *
     * @var string
     */
    protected $_role;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_Acl
     */
    public function init()
    {
        $this->getBootstrap()->bootstrap('FrontController')
                             ->bootstrap('Logger')
                             ->bootstrap('Session');
        $front = $this->getBootstrap()->getResource('FrontController');
        $log = $this->getBootstrap()->getResource('Logger');

        if (!$front->hasPlugin('Streamwide_Web_Controller_Plugin_Acl')) {
            $front->registerPlugin(new Streamwide_Web_Controller_Plugin_Acl($this->_options),2); //2: the very first plugin after Log
        }

        $ini = $this->_options['definition'];
        $definitions = new Zend_Config_Ini($ini,'resource');
        $acl = $this->getAcl();
        $acl->addRole('visitor')
            ->addRole('developer')
            ->addResource(new Streamwide_Web_Acl_Resource_Mca('*','*','*'));

        $acl->deny('visitor');
        foreach ($definitions->toArray() as $definition) {
            $rules = array();
            list($module,$controller,$action,$roles) = $this->_getDef($definition,$rules);
            $mca = new Streamwide_Web_Acl_Resource_Mca($module,$controller,$action);
            if (!$acl->has($mca)) {
                $acl->addResource($mca);
            }
            foreach ($roles as $role => $allow) {
                if (!$acl->hasRole($role)) {
                    $acl->addRole($role);
                }
                if ($allow) {
                    $acl->allow($role,$mca);
                } else {
                    $acl->deny($role,$mca);
                }
            }
        }
        $acl->allow('developer');

        $role = getenv('APPLICATION_ROLE');
        if (!empty($role)) {
            $this->_role = $role;
        } else {
            if (!Zend_Session::isStarted()) {
                Zend_Session::start(true);
            }
            $this->_role = isset($_SESSION['APPLICATION_ROLE']) ? $_SESSION['APPLICATION_ROLE'] : 'visitor';
        }

        $log->setEventItem('role',$this->_role);
        return $acl;
    }

    /**
     * Retrieve acl object
     *
     * @return Zend_Acl
     */
    public function getAcl()
    {
        if (is_null($this->_acl)) {
            $this->_acl = new Zend_Acl();
        }
        return $this->_acl;
    }

    /**
     * Retrieve Instance role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * Get the defined rules
     *
     * @param string|array $def   Resource
     * @param array        $rules Rules
     *
     * @return array Definition rules
     */
    protected function _getDef($def,array &$rules)
    {
        if (is_array($def)) {
            list($key) = array_keys($def);
            array_push($rules,$key);
            $this->_getDef($def[$key],$rules);
        } else {
            $roles = Zend_Json::decode(str_replace('\'','"',$def),Zend_Json::TYPE_ARRAY);
            array_push($rules,$roles);
        }
        return $rules;
    }
}

/* EOF */