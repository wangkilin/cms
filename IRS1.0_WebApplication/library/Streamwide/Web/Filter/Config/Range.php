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
 * @version    $Id: Range.php 2224 2010-01-15 03:19:57Z kwu $
 */

/**
 *
 */
class Streamwide_Web_Filter_Config_Range implements Zend_Filter_Interface
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
            $matches = array();
            if (is_array($param)) {
                $param = $this->filter($param);
            }
            else if ($this->_is_range($param,$matches)) {
                $param = $this->_rangeToArray($matches[1]);
            }
        }
        return $config;
    }

    /**
     *
     */
    private function _is_range($value,&$matches)
    {
        //range string: range(min,max,step,[])
        return preg_match('/^\s*range\((.*)\)\s*$/',$value,$matches) > 0;
    }

    /**
     *
     */
    private function _rangeToArray($match)
    {
        list($min,$max,$step,$base) = explode(',',$match,4);
        $step = is_null($step) ? 1 : $step;
        $baseArray = is_null($base) ? array() : Zend_Json::decode($base,Zend_Json::TYPE_ARRAY);
        $rangeArray = range($min,$max,$step);
        return array_merge($rangeArray,$baseArray);
    }
}
/* EOF */
