<?php
/**
 * $Rev: 2431 $
 * $LastChangedDate: 2010-03-15 22:38:37 +0800 (Mon, 15 Mar 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Translate.php 2431 2010-03-15 14:38:37Z kwu $
 */

/**
 *
 */
class Streamwide_Web_Translate
{
    private static $_functor = null;
    private static $_helper = null;
    /**
     *
     */
    public static function getTranslate()
    {
        $front = Zend_Controller_Front::getInstance();
        return $front->getParam('bootstrap')->getResource('translate');
    }

    /**
     *
     */
    public static function translate($message)
    {
        if (is_null(self::$_helper)) {
            $translate = self::getTranslate();
            self::$_helper = new Zend_View_Helper_Translate($translate);
        }
        return self::$_helper->translate($message);
    }

    /**
     *
     */
    public static function functor()
    {
        if (is_null(self::$_functor)) {
            self::$_functor = create_function('$msg','return Streamwide_Web_Translate::translate($msg);');
        } 
        return self::$_functor;
    }
}
/* EOF */
