<?php
/**
 * $Rev: 2650 $
 * $LastChangedDate: 2010-06-22 19:18:47 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Request.php 2650 2010-06-22 11:18:47Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Request
{
    const CURRENT_PAGE = 1;
    const ITEMS_PER_PAGE = 25;
    const SUPER_ADMIN_CUSTOMER_ACCOUNT_ID = -1;

    const STATE_ACTIVE = 0;
    const STATE_PROVISIONAL = 1;

    const SUPER_ADMIN = 'super_admin';
    const ACCOUNT_ADMIN = 'account_admin';
    const TREE_ADMIN = 'tree_admin';
    const AGENT = 'agent';
    const VISITOR = 'visitor';
    const PROVISIONAL = 'provisional';

    /**
     *
     * @param Zend_Controller_Request_Abstract $request The instance request
     * @param array                            $params  The default values
     *
     * @return array The status on whether or nor is super admin
     */
    public static function getParam(Zend_Controller_Request_Abstract $request, array $defaults)
    {
        $data = array();
        foreach ($defaults as $key => $default) {
            $value = $request->getParam($key, $default);
            if (!is_null($value)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     *
     * @param Zend_Controller_Request_Abstract
     *
     * @return boolean The status on whether or nor is super admin
     */
    public static function isSuperAdmin(Zend_Controller_Request_Abstract $request)
    {
        $customerAccountId = $request->getParam('CustomerAccountId');
        $secondCustomerAccountId =$request->getParam('SecondaryCustomerAccountId');

        $isReal = $customerAccountId == self::SUPER_ADMIN_CUSTOMER_ACCOUNT_ID 
                  && $customerAccountId == $secondCustomerAccountId;

        return $isReal;
    }

    /**
     *
     * @param Zend_Controller_Request_Abstract $request The instance request
     *
     * @return boolean The status on whether or nor is visitor
     */
    public static function isVisitor(Zend_Controller_Request_Abstract $request)
    {
        return Zend_Session::isStarted() && !Zend_Session::namespaceIsset('SwIRS_Web');
    }

    /**
     *
     * @param Zend_Controller_Request_Abstract $request The instance request
     *
     * @return boolean The status on whether or nor is provisional
     */
    public static function isProvisional(Zend_Controller_Request_Abstract $request)
    {
        $customerState = $request->getParam('CustomerState');
        return $customerState == self::STATE_PROVISIONAL;
    }

    /**
     *
     * @param array $profile The instance profile
     *
     * @return string The role label
     */
    public static function getRole(array $profile)
    {
        unset($profile['ProfileId']);
        unset($profile['Label']);
        $roles = array(
            self::SUPER_ADMIN => array(
                'SuperAdmin' => 1,
                'AdminUsers' => 1,
                'AdminTrees' => 1,
                'AdminResources' => 1,
                'AdminStats' => 1,
                'AgentCapability' => 0
            ),
            self::ACCOUNT_ADMIN => array(
                'SuperAdmin' => 0,
                'AdminUsers' => 1,
                'AdminTrees' => 1,
                'AdminResources' => 1,
                'AdminStats' => 1,
                'AgentCapability' => 0
            ),
            self::TREE_ADMIN => array(
                'SuperAdmin' => 0,
                'AdminUsers' => 0,
                'AdminTrees' => 1,
                'AdminResources' => 1,
                'AdminStats' => 1,
                'AgentCapability' => 0
            ),
            self::AGENT => array(
                'SuperAdmin' => 0,
                'AdminUsers' => 0,
                'AdminTrees' => 0,
                'AdminResources' => 0,
                'AdminStats' => 0,
                'AgentCapability' => 1
            )
        );

        foreach ($roles as $role => $capabilities) {
            if ($capabilities == $profile) {
                return $role;
            }
        }
        return self::VISITOR;
    }

    /**
     *
     * @param string $role The role label
     *
     * @return array The reference navigation menu
     */
    public static function getMenu($role)
    {
        $menus = array(
            self::SUPER_ADMIN => array(
                'routing' => array(
                    'tree',
                    'number'
                ),
                'resource' => array(
                    'origin',
                    'origingroup',
                    'media'
                ),
                'user' => array(
                    'customer',
                    'admin'
                ),
                'equipment' => array(
                    'trunk',
                    'trunkgroup',
                    'trunkroute'
                ),
                'admin/account' => array(
                )
            ),
            self::ACCOUNT_ADMIN => array(
                'routing' => array(
                    'tree',
                    'numbergroup',
                    'number'
                ),
                'resource' => array(
                    'blacklist',
                    'origin',
                    'calendar',
                    'media',
                    'contact',
                    'agentgroup'
                ),
                'user' => array(
                    'admin'
                ),
                'report' => array(
                ),
                'admin/account' => array(
                )
            ),
            self::TREE_ADMIN => array(
                'routing' => array(
                    'tree',
                    'numbergroup',
                    'number'
                ),
                'resource' => array(
                    'blacklist',
                    'origin',
                    'calendar',
                    'media',
                    'contact',
                    'agentgroup'
                ),
                'report' => array(
                ),
                'admin/account' => array(
                )
            ),
            self::AGENT => array(
                'admin/account' => array(
                )
            ),
            self::PROVISIONAL => array(
                'admin/account' => array(
                )
            ),
            self::VISITOR => array(
            )
        );
        return $menus[$role];
    }
}

/* EOF */
