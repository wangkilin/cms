<?php
/**
 * $Rev: 2243 $
 * $LastChangedDate: 2010-01-19 23:30:57 +0800 (Tue, 19 Jan 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Mca.php 2243 2010-01-19 15:30:57Z kwu $
 */

/**
 * Mca : Module Controller Action
 */
class Streamwide_Web_Acl_Resource_Mca implements Zend_Acl_Resource_Interface
{
    /**
     *
     */
    private $_resource = array();

    /**
     *
     */
    public function __construct($module='*',$controller='*',$action='*')
    {
        $this->_resouce = array($module,$controller,$action);
    }

    /**
     *
     */
    public function getResourceId()
    {
        return implode('.',$this->_resouce);
    }
}
/* EOF */
