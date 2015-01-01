<?php
/**
 * $Rev: 2241 $
 * $LastChangedDate: 2010-01-19 14:30:19 +0800 (Tue, 19 Jan 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Mca.php 2241 2010-01-19 06:30:19Z kwu $
 */

/**
 * Mca : Module Controller Action
 */
class Streamwide_Web_Acl_Assert_Mca implements Zend_Acl_Assert_Interface
{
    /**
     * Returns true if and only if the assertion conditions are met
     *
     * This method is passed the ACL, Role, Resource, and privilege to which the authorization query applies. If the
     * $role, $resource, or $privilege parameters are null, it means that the query applies to all Roles, Resources, or
     * privileges, respectively.
     *
     * @param  Zend_Acl                    $acl
     * @param  Zend_Acl_Role_Interface     $role
     * @param  Zend_Acl_Resource_Interface $resource
     * @param  string                      $privilege
     * @return boolean
     */
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
    }
}
/* EOF */
