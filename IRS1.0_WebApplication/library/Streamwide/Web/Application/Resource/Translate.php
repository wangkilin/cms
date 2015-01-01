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
 * @version    $Id: Translate.php 2504 2010-04-16 04:31:00Z junzhang $
 */

/**
 * Resource for setting translation options
 */
class Streamwide_Web_Application_Resource_Translate extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Instance of Zend_Translate
     *
     * @var Zend_Translate
     */
    protected $_translate;

    /**
     * Instance locale
     *
     * @var string
     */
    protected $_locale = 'en';

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_Translate
     */
    public function init()
    {
        $this->getBootstrap()->bootstrap('Logger')
                             ->bootstrap('View');

        $locale = getenv('APPLICATION_LOCALE');
        if (!empty($locale)) {
            $this->_locale = $locale;
        } else {
            if (!Zend_Session::isStarted()) {
                Zend_Session::start(true);
            }
            $this->_locale = isset($_SESSION['APPLICATION_LOCALE']) ? $_SESSION['APPLICATION_LOCALE'] : 'en';
        }

        return $this->getTranslate();
    }

    /**
     * Retrieve translate object
     *
     * @return Zend_Translate
     * @throws Streamwide_Exception When provided locales invalid, throw Streamwide_Exception
     */
    public function getTranslate()
    {
        if (null === $this->_translate) {
            $options = $this->getOptions();

            if (!isset($options['locales']) || !is_array($options['locales'])) {
                throw new Streamwide_Exception('No translation source data provided.');
            }

            $log = $this->getBootstrap()->getResource('Logger');
            $adapter = isset($options['adapter']) ? $options['adapter'] : Zend_Translate::AN_CSV;
            $locale  = isset($options['locales']['default'])  ? $options['locales']['default']  : null;
            $translateOptions = array(
                                    'scan' => Zend_Translate::LOCALE_DIRECTORY,
                                    'log' => $log,
                                    'logUntranslated' => true,
                                    'disableNotices' => $options['disableNotices']
                                );

            $this->_translate = new Zend_Translate(
                $adapter, $options['locales']['path'], $locale, $translateOptions
            );
            $this->_translate->setLocale($this->_locale);

            $view = $this->getBootstrap()->getResource('View');
            $view->doctype('XHTML1_STRICT');
            $view->translate()->setTranslator($this->_translate);
        }

        return $this->_translate;
    }

    /**
     * Retrieve locale
     *
     * @return string instance locale
     */
    public function getLocale()
    {
        return $this->_locale;
    }
}

/* EOF */