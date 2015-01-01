<?php
/**
 * Phone Number Transformer class.
 *
 * Based on a phone number string and a phone number locale
 * transforms the phone number to various formats.
 *
 * $Rev: 1953 $
 * $LastChangedDate: 2009-09-24 22:02:35 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PhoneNumber
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Transformer.php 1953 2009-09-24 14:02:35Z rgasler $
 */

/**
 * Keeps a phone number characteristics in a specific locale.
 *
 * @package Streamwide_PhoneNumber
 */
class Streamwide_PhoneNumber_Transformer
{
    /**
     * Phone Number formats.
     */
    const CCNN    = 'CC-NN';     // International Number
    const IDDCCNN = 'IDD-CC-NN'; // International Direct Dialing
    const NDDNN   = 'NDD-NN';    // National Direct Dialing
    const NN      = 'NN';        // National Number
    const SN      = 'SN';        // Subscriber Number

    /**
     * A constant that says that a phone number is short.
     */
    const SHORT   = 'SHORT';     // Short Number
    
    /**
     * The phone number in input format
     *
     * @var string
     */
    protected $_phoneNumber;

    /**
     * The phone number locale of the phone number
     *
     * @var Streamwide_PhoneNumber_Locale
     */
    protected $_locale;

    /**
     * The phone number format
     *
     * @var string
     */
    protected $_format;

    // Phone number forms:

    /**
     * The phone number in CCNN format
     *
     * @var string
     */
    protected $_internationalPhoneNumber;

    /**
     * The phone number in NN format
     *
     * @var string
     */
    protected $_nationalPhoneNumber;

    /**
     * The phone number in SN format
     *
     * @var string
     */
    protected $_subscriberPhoneNumber;

    /**
     * Tells if the phone number is short
     *
     * @var boolean
     */
    protected $_isShort = false;

    /**
     * A state variable:
     * Tells whether the phone number has been prepared
     * (the format and one of its forms has been set)
     *
     * @var boolean
     */
    protected $_prepared = false;
    
    /**
     * The strategy used to discover phone number format.
     *
     * @var Streamwide_PhoneNumber_Strategy_DiscoverFormat_Interface
     */
    protected $_discoverFormatStrategy = null;

    /**
     * Constructor
     *
     * @param Streamwide_PhoneNumber_Locale $locale      (optional) the locale context for the phone number
     * @param string|int                    $phoneNumber (optional) represents a phone number
     * @param string                        $format      (optional) the phone number format if known
     * @param Streamwide_PhoneNumber_Strategy_DiscoverFormat_Interface $strategy (optional) the strategy to use to discover the phone number format
     * @return Streamwide_PhoneNumber
     */
    public function __construct(Streamwide_PhoneNumber_Locale $locale = null,
                                $phoneNumber = null,
                                $format = null,
                                Streamwide_PhoneNumber_Strategy_DiscoverFormat_Interface $strategy = null)
    {
        // set the locale
        if (!is_null($locale)) {
            $this->setLocale($locale);
        }
        
        // set the phone number and format
        if (!is_null($phoneNumber)) {
            $this->setPhoneNumber($phoneNumber, $format);
        }
        
        // if format and strategy are not provided, set default strategy
        if (is_null($format) && is_null($strategy)) {
            $strategy = new Streamwide_PhoneNumber_Strategy_DiscoverFormat_Default();
        }
        
        // set the strategy
        if (!is_null($strategy)) {
            $this->setDiscoverFormatStrategy($strategy);
        }
    }

    /**
     * Sets the Phone Number.
     *
     * @param string|int $phoneNumber the phone number
     * @param string     $format      (optional) the phone number format if known
     * @return Streamwide_PhoneNumber_Transformer *Provides a fluid interface*
     */
    public function setPhoneNumber($phoneNumber, $format = null)
    {
        // phone number regexp
        $regexp = '/^\+?[0-9]+$/';

        if (!is_string($phoneNumber) && !is_int($phoneNumber)) {
            throw new Streamwide_PhoneNumber_Exception('Phone Number must be a string or an int.');
        }
        if (!preg_match($regexp, $phoneNumber)) {
            throw new Streamwide_PhoneNumber_Exception('Invalid format for Phone Number.');
        }

        // clear prepared state
        $this->_clear();

        $this->_phoneNumber = $phoneNumber;

        // set format
        if (!is_null($format)) {
            $this->_setFormat($format);
        }

        return $this;
    }

    /**
     * Sets the Phone Number Locale.
     *
     * @param Streamwide_PhoneNumber_Locale $locale locate object
     * @return Streamwide_PhoneNumber_Transformer *Provides a fluid interface*
     */
    public function setLocale(Streamwide_PhoneNumber_Locale $locale)
    {
        // clear prepared state
        $this->_clear();

        $this->_locale = $locale;

        return $this;
    }
    
    /**
     * Sets the Strategy to use to discover the phone number format.
     *
     * @param Streamwide_PhoneNumber_Strategy_DiscoverFormat_Interface $strategy strategy to use to discover the phone number format
     * @return Streamwide_PhoneNumber_Transformer *Provides a fluid interface*
     */
    public function setDiscoverFormatStrategy(Streamwide_PhoneNumber_Strategy_DiscoverFormat_Interface $strategy)
    {
        $this->_clear();
        
        $this->_discoverFormatStrategy = $strategy;
        
        return $this;
    }

    /**
     * Transforms the phone number to desired format.
     *
     * @param string $format (optional) the phone number in desired format (if not set returns in input format)
     * @see Streamwide_PhoneNumber_Transformer::getAllFormats()
     * @return string phone number in desired format or null if cannot convert to desired format
     */
    public function getPhoneNumber($format = null)
    {
        // assure that the transformer is prepared
        if (!is_null($format) && !$this->_prepared) {
            $this->_prepare();
        }

        switch ($format) {
            case null:
                return $this->_phoneNumber;
                break;
            case self::CCNN:
                return $this->_getInternational();
                break;
            case self::IDDCCNN:
                if (!is_null($this->_getInternational())) {
                    return $this->_locale->getInternationalAccessCode() . $this->_getInternational();
                }
                break;
            case self::NDDNN:
                if (!is_null($this->_getNational())) {
                    return $this->_locale->getNationalAccessCode() . $this->_getNational();
                }
                break;
            case self::NN:
                return $this->_getNational();
                break;
            case self::SN:
                if ($this->_locale->hasOpenDiallingPlan()) {
                    return $this->_getSubscriber();
                } else {
                    throw new Streamwide_PhoneNumber_Exception('SN format is supported only for locales with open dialling plan.');
                }
                break;
            default:
                throw new Streamwide_PhoneNumber_Exception('Unrecognized Phone Number Format.');
                break;
        }

        return null;
    }

    /**
     * Gets the Phone Number Locale.
     *
     * @return Streamwide_PhoneNumber_Locale
     */
    public function getLocale()
    {
        return $this->_locale;
    }

    /**
     * Gets the Phone Number Foramt.
     *
     * @return string the phone number format
     */
    public function getFormat()
    {
        // if format is not set and transformer is not prepared
        if (is_null($this->_format) && !$this->_prepared) {
            $this->_prepare();
        }

        return $this->_format;
    }
    
    /**
     * Tells if a phone number is national in the current locale context.
     *
     * @return boolean true if the phone number in national, false otherwise
     */
    public function isNational()
    {
        // assure that the transformer is prepared
        if (!$this->_prepared) {
            $this->_prepare();
        }

        return (!is_null($this->_getNational()));
    }

    /**
     * Tells if a phone number is local in the current locale context.
     *
     * @return boolean true if the phone number in local, false otherwise
     */
    public function isLocal()
    {
        // assure that the transformer is prepared
        if (!$this->_prepared) {
            $this->_prepare();
        }

        return (!is_null($this->_getSubscriber()));
    }


    /**
     * Tells if a phone number is short in the current locale context.
     *
     * @return boolean true if the phone number is short, false otherwise
     */
    public function isShort()
    {
        // assure that the transformer is prepared
        if (!$this->_prepared) {
            $this->_prepare();
        }

        return $this->_isShort;
    }

    /**
     * Wrapper function that returns the coutry code if the number is national.
     *
     * @return int|null the country code or null if the number is not natinal
     */
    public function getCountryCodeIfNational()
    {
        if ($this->isNational()) {
            return $this->getLocale()->getCountryCode();
        }

        return null;
    }

    /**
     * Wrapper function that returns the area code if the number is local.
     *
     * @return int|null the area code or null if the number is not local
     */
    public function getAreaCodeIfLocal()
    {
        if ($this->isLocal()) {
            return $this->getLocale()->getAreaCode();
        }

        return null;
    }

    /**
     * Sets the Phone Number format.
     *
     * @param string|int $format the phone number format
     * @return null
     */
    private function _setFormat($format)
    {
        if (!in_array($format, self::getAllFormats())) {
            throw new Streamwide_PhoneNumber_Exception('Unrecognized Phone Number Format.');
        }

        $this->_format = $format;
    }

    /**
     * Clear previously set phone number forms.
     * The state of the object becomes unprepared.
     *
     * @return null
     */
    private function _clear()
    {
        if ($this->_prepared) {
            $this->_prepared = false;

            $this->_internationalPhoneNumber = null;
            $this->_nationalPhoneNumber = null;
            $this->_subscriberPhoneNumber = null;
            $this->_isShort = false;
            $this->_format = null;
        }
    }

    /**
     * Sets one of international, national or subscriber number
     * based on phone number format.
     * If the format is not konwn it tries to discover it.
     *
     * @return null
     */
    private function _prepare()
    {
        if (is_null($this->_format)) {
            $this->_discoverFormat();
        }
        switch ($this->_format) {
            case self::CCNN:
                $this->_internationalPhoneNumber = $this->_phoneNumber;
                break;
            case self::IDDCCNN:
                $this->_internationalPhoneNumber = substr($this->_phoneNumber, strlen($this->_locale->getInternationalAccessCode()));
                break;
            case self::NDDNN:
                $this->_nationalPhoneNumber = substr($this->_phoneNumber, strlen($this->_locale->getNationalAccessCode()));
                break;
            case self::NN:
                $this->_nationalPhoneNumber = $this->_phoneNumber;
                break;
            case self::SN:
                $this->_subscriberPhoneNumber = $this->_phoneNumber;
                break;
            default:
                break;
        }

        $this->_prepared = true;
    }

    /**
     * Analyses the phone number and tries to determine the format
     * using the locale rules.
     *
     * @return void
     */
    private function _discoverFormat()
    {
        $this->_discoverFormatStrategy->setContext($this);
        $format = $this->_discoverFormatStrategy->discoverFormat();
        
        if (self::SHORT === $format) {
            $this->_isShort = true;
        } else if (in_array($format, self::getAllFormats())) {
            $this->_format = $format;
        }
    }
        
    /**
     * Tries to set international phone number and returns it.
     *
     * @return string international phone number
     */
    private function _getInternational()
    {
        if (is_null($this->_internationalPhoneNumber)) {
            // prepare national phone number
            $this->_getNational();
            if (!is_null($this->_nationalPhoneNumber)) {
                // add country code to national phone number
                $this->_internationalPhoneNumber = $this->_locale->getCountryCode() . $this->_nationalPhoneNumber;
            }
        }

        return $this->_internationalPhoneNumber;
    }

    /**
     * Tries to set national phone number and returns it.
     *
     * @return string national phone number
     */
    private function _getNational()
    {
        if (is_null($this->_nationalPhoneNumber)) {
            if (!is_null($this->_internationalPhoneNumber)) {
                // remove country code from international phone number
                $CC = $this->_locale->getCountryCode();
                if (substr($this->_internationalPhoneNumber, 0, strlen($CC)) == $CC) {
                    $this->_nationalPhoneNumber = substr($this->_internationalPhoneNumber, strlen($CC));
                }
            } else if (!is_null($this->_subscriberPhoneNumber)) {
                // add area code to subscriber phone number
                $this->_nationalPhoneNumber = $this->_locale->getAreaCode() . $this->_subscriberPhoneNumber;
            }
        }
        return $this->_nationalPhoneNumber;
    }

    /**
     * Tries to set subscriber phone number and returns it.
     *
     * @return string subscriber phone number
     */
    private function _getSubscriber()
    {
        if (is_null($this->_subscriberPhoneNumber)) {
            $this->_getNational();
            if (!is_null($this->_nationalPhoneNumber)) {
                // remove area code from national phone number
                $AC = $this->_locale->getAreaCode();
                if (substr($this->_nationalPhoneNumber, 0, strlen($AC)) == $AC) {
                        $this->_subscriberPhoneNumber = substr($this->_nationalPhoneNumber, strlen($AC));
                }
            }
        }

        return $this->_subscriberPhoneNumber;
    }

    /**
     * Gets all formats as an array.
     *
     * @return array all formats
     */
    public static function getAllFormats()
    {
        return array(self::CCNN,
                     self::IDDCCNN,
                     self::NDDNN,
                     self::NN,
                     self::SN);
    }
}
 
/* EOF */