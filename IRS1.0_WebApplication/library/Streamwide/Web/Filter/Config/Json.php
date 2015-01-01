<?php
/**
 * $Rev: 2224 $
 * $LastChangedDate: 2010-01-15 11:19:57 +0800 (Fri, 15 Jan 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Json.php 2224 2010-01-15 03:19:57Z kwu $
 */

/**
 *
 */
class Streamwide_Web_Filter_Config_Json implements Zend_Filter_Interface
{
    /**
     *
     */
    public function filter($config)
    {
        if ($config instanceof Zend_Config) {
            $config = $config->toArray();
        }
        foreach ($config as $key => &$param) {
            if (is_array($param)) {
                $param = $this->filter($param);
            }
            else if ($this->_is_json($param)) {
                $param = $this->_jsonToArray($param);
            }
        }
        return $config;
    }

    /**
     *
     */
    private function _is_json($value)
    {
        return preg_match('/^\s*{.*}\s*$|^\s*\[.*\]\s*$/',$value) > 0;
    }

    /**
     *
     */
    private function _jsonToArray($value)
    {
        return Zend_Json::decode(str_replace('\'','"',$value),Zend_Json::TYPE_ARRAY);
    }
}
/* EOF */
