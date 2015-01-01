<?php
/**
 * $Rev: 2228 $
 * $LastChangedDate: 2010-01-16 14:51:37 +0800 (Sat, 16 Jan 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Ini.php 2228 2010-01-16 06:51:37Z kwu $
 */

/**
 * [introspection]
 * Foo_Bar.0 = "{'type':'int'...}"
 * Foo_Bar.1.0 = "{'type':'int'...}"
 * Foo_Bar.2.key1 = "{'type':'int'...}"
 * Foo_Bar.2.key2 = "{'type':'string'...}"
 * Foo_Bar.2.key3 = "{'type':'int'...}"
 * Foo_Bar.2.key4.0 = "{'type':'string'...}"
 * Foo_Bar.2.key5.sub1 = "{'type':'int'...}"
 * Foo_Bar.2.key5.sub2 = "{'type':'string'...}"
 * Foo_Bar.2.key5.sub3 = "{'type':'int'...}"
 * Foo_Bar.3 = "{'type':'int'...}"
 * Foo_Bar.4.0 = "{'type':'int'...}"
 */
class Streamwide_Web_Webservice_Introspection_Ini extends Zend_XmlRpc_Client_ServerIntrospection
{
    /**
     *
     */
    private $_signitures = array();

    /**
     *
     */
    public function __construct(Zend_XmlRpc_Client $client,array $ini)
    {
        parent::__construct($client);
        $this->_signitures = $ini;
        $this->_getSignitures($this->_signitures);
    }

    /**
     * method = 'Foo.Bar'
     */
    public function getMethodSignature($method)
    {
        // Foo.Bar => Foo_Bar
        $method = str_replace('.','_',$method);
        return isset($this->_signitures[$method]) ? $this->_signitures[$method] : null;
    }

    /**
     *
     */
    public function listMethods()
    {
        return array_keys($this->_signitures);
    }

    /**
     *
     */
    private function _getSignitures(array &$ini)
    {
        foreach ($ini as $key => &$value) {
            if (is_array($value)) {
                $this->_getSignitures($value);
            }
            else if (is_string($value)) {
                $format = Zend_Json::decode(str_replace('\'','"',$value),Zend_Json::TYPE_ARRAY);
                $value = isset($format['type']) ? $format['type'] : 'string';
            }
            else {
                throw new Streamwide_Exception('Invalid configuration file provided; unknown introspection type');
            }
        }
    }
}
/* EOF */
