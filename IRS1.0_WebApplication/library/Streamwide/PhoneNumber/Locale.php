<?php
/**
 * Phone Number Locale class.
 *
 * Used to define a phone numbering and dialling plan.
 *
 * $Rev: 1981 $
 * $LastChangedDate: 2009-09-28 19:07:50 +0800 (Mon, 28 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PhoneNumber
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Locale.php 1981 2009-09-28 11:07:50Z rgasler $
 */

/**
 * Used to keep Phone Numbering and Dialling Plan properties.
 *
 * @package Streamwide_PhoneNumber
 */
class Streamwide_PhoneNumber_Locale
{
    // Country properties

    /**
     * The name of the country
     *
     * @var string
     */
    protected $_countryName;

    /**
     * The Country Code (CC) (1-3 digits, no country code starts with 0)
     *
     * @var string
     */
    protected $_countryCode;

    /**
     * International Access Code (IDD Prefix)
     * Needed to dial a call from this country TO another country.
     *
     * @var string
     */
    protected $_internationalAccessCode;

    /**
     * National Access Code (NDD Prefix)
     * Needed to make a call WITHIN this country from one area to another.
     *
     * @var string
     */
    protected $_nationalAccessCode;

    /**
     * National Number min length
     *
     * @var int
     */
    protected $_nationalNumberMinLength;

    /**
     * National Number max length
     *
     * @var int
     */
    protected $_nationalNumberMaxLength;

    /**
     * If the country has open dialling plan
     *
     * @var boolean
     */
    protected $_hasOpenDiallingPlan = false;

    // The following properties apply only to
    // a region within a country with open dialling plan

    /**
     * Subscriber Number min length
     * for closed numbering plan equals $_subscriberNumberMaxLength
     * must be defined for open dialing plans
     *
     * @var int
     */
    protected $_subscriberNumberMinLength;

    /**
     * Subscriber Number max length
     * for closed numbering plan equals $_subscriberNumberMinLength
     * must be defined for open dialing plans
     *
     * @var int
     */
    protected $_subscriberNumberMaxLength;

    /**
     * Area Code
     *
     * @var string
     */
    protected $_areaCode;

    /**
     * National short number patterns
     *
     * @var array
     */
    protected $_nationalShortNumberPatterns;

    /**
     * Country constructor.
     *
     * @param string     $countryName               Country Name
     * @param int        $countryCode               Country Code
     * @param string|int $internationalAccessCode   International Access Code
     * @param string|int $nationalAccessCode        National Access Code
     * @param int        $nationalNumberMinLength   National Number min length
     * @param int        $nationalNumberMaxLength   National Number max length
     * @param int        $subscriberNumberMinLength (optional) Subscriber Number min length - set for open dialling plan
     * @param int        $subscriberNumberMaxLength (optional) Subscriber Number max length - set for open dialling plan
     * @param string|int $areaCode                  (optional) Area Code
     * @return Streamwide_PhoneNumber_Country
     * @throws Streamwide_PhoneNumber_Exception When SN min and max length and AC are not all set for open dialling plan
     */
    public function __construct($countryName, $countryCode, $internationalAccessCode, $nationalAccessCode,
                                $nationalNumberMinLength, $nationalNumberMaxLength,
                                $subscriberNumberMinLength = null, $subscriberNumberMaxLength = null,
                                $areaCode = null)
    {
        $this->_setCountryName($countryName);
        $this->_setCountryCode($countryCode);
        $this->_setInternationalAccessCode($internationalAccessCode);
        $this->_setNationalAccessCode($nationalAccessCode);
        $this->_setNationalNumberMinLength($nationalNumberMinLength);
        $this->_setNationalNumberMaxLength($nationalNumberMaxLength);

        // For open dialling plans define Subscriber Number limits
        if (!is_null($subscriberNumberMinLength)
            && !is_null($subscriberNumberMaxLength)
            && !is_null($areaCode)) {
            $this->_setSubscriberNumberMinLength($subscriberNumberMinLength);
            $this->_setSubscriberNumberMaxLength($subscriberNumberMaxLength);
            $this->_setAreaCode($areaCode);
            $this->_hasOpenDiallingPlan = true;
        } else if (!is_null($subscriberNumberMinLength)
                   || !is_null($subscriberNumberMaxLength)
                   || !is_null($areaCode)) {
            throw new Streamwide_PhoneNumber_Exception('Subscriber Number min and max length and Area Code must all be set for open dialling plan.');
        }
    }

    /**
     * Sets the Country Name.
     *
     * @param string $name Country Name
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _setCountryName($name)
    {
        if (!is_string($name)) {
            throw new Streamwide_PhoneNumber_Exception('Country name must be a string.');
        }

        $this->_countryName = $name;
    }

    /**
     * Sets the Country Code.
     *
     * @param int $code Country Code
     * @return void
     * @throws Exception
     */
    private function _setCountryCode($code)
    {
        // country code regexp
        $regexp = '/^[1-9][0-9]{0,2}$/';

        if (!is_string($code) && !is_int($code)) {
            throw new Exception('Country Code must be a string or an int.');
        }
        if (!preg_match($regexp, $code)) {
            throw new Streamwide_PhoneNumber_Exception('Country Code must have 1-3 digits and must not begin with 0.');
        }

        $this->_countryCode = $code;
    }

    /**
     * Sets the International Access Code (IDD Prefix).
     *
     * @param string|int $code International Access Code
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _setInternationalAccessCode($code)
    {
        $this->_validateCode($code, 'International Access Code');

        $this->_internationalAccessCode = $code;
    }

    /**
     * Sets the National Access Code (NDD Prefix).
     *
     * @param string|int $code National Access Code
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _setNationalAccessCode($code)
    {
        $this->_validateCode($code, 'National Access Code');

        $this->_nationalAccessCode = $code;
    }

    /**
     * Sets the National Number minimum length.
     *
     * @param int $length National Number min length
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _setNationalNumberMinLength($length)
    {
        $this->_validateLength($length, 'National Number minimum length');

        if (!is_null($this->_nationalNumberMaxLength)
            && $this->_nationalNumberMaxLength < $length) {
            throw new Streamwide_PhoneNumber_Exception('National Number minimum length must be <= maximum length.');
        }

        $this->_nationalNumberMinLength = $length;
    }

    /**
     * Sets the National Number maximum length.
     *
     * @param int $length National Number max length
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _setNationalNumberMaxLength($length)
    {
        $this->_validateLength($length, 'National Number maximum length');
        
        if (!is_null($this->_nationalNumberMinLength)
            && $this->_nationalNumberMinLength > $length) {
            throw new Streamwide_PhoneNumber_Exception('National Number maximum length must be >= minimum length.');
        }

        $this->_nationalNumberMaxLength = $length;
    }

    /**
     * Sets the Subscriber Number minimum length.
     *
     * @param int $length Subscriber Number min length
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _setSubscriberNumberMinLength($length)
    {
        $this->_validateLength($length, 'Subscriber Number minimum length');

        if (!is_null($this->_subscriberNumberMaxLength)
            && $this->_subscriberNumberMaxLength < $length) {
            throw new Streamwide_PhoneNumber_Exception('Subscriber Number minimum length must be <= maximum length.');
        }

        $this->_subscriberNumberMinLength = $length;
    }

    /**
     * Sets the Subscriber Number maximum length.
     *
     * @param int $length Subscriber Number max length
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _setSubscriberNumberMaxLength($length)
    {
        $this->_validateLength($length, 'Subscriber Number maximum length');
        
        if (!is_null($this->_subscriberNumberMinLength)
            && $this->_subscriberNumberMinLength > $length) {
            throw new Streamwide_PhoneNumber_Exception('Subscriber Number maximum length must be >= minimum length.');
        }

        $this->_subscriberNumberMaxLength = $length;
    }

    /**
     * Sets the Area Code.
     *
     * @param string|int $code the area code
     * @return void
     */
    private function _setAreaCode($code)
    {
        $this->_validateCode($code, 'Area Code');

        $this->_areaCode = (string)$code;
    }

    /**
     * Validates a length parameter.
     *
     * @param string|int $length the length parameter value
     * @param string     $name   the parameter name
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _validateLength($length, $name)
    {
        if (!is_int($length) && !is_string($length)) {
            throw new Streamwide_PhoneNumber_Exception($name . ' must be an int or a string.');
        }
        if ($length <= 0) {
            throw new Streamwide_PhoneNumber_Exception($name . ' must be > 0.');
        }
    }

    /**
     * Validates an access code parameter.
     *
     * @param string|int $code the code parameter value
     * @param string     $name the parameter name
     * @return void
     * @throws Streamwide_PhoneNumber_Exception
     */
    private function _validateCode($code, $name)
    {
        // access code regexp
        $regexp = '/^[0-9]+$/';

        if (!is_string($code) && !is_int($code)) {
            throw new Streamwide_PhoneNumber_Exception($name . ' must be a string or an int.');
        }
        if (!preg_match($regexp, $code)) {
            throw new Streamwide_PhoneNumber_Exception($name . ' must have only digits.');
        }
    }

   /**
     * Gets the Country Name.
     *
     * @return string Country Name
     */
    public function getCountryName()
    {
        return $this->_countryName;
    }

    /**
     * Gets the Country Code.
     *
     * @return string|int Country Code
     */
    public function getCountryCode()
    {
      return $this->_countryCode;
    }

    /**
     * Gets the International Access Code (IDD Prefix).
     *
     * @return string|int $code International Access Code
     */
    public function getInternationalAccessCode()
    {
        return $this->_internationalAccessCode;
    }

    /**
     * Gets the National Access Code (NDD Prefix).
     *
     * @return string|int National Access Code
     */
    public function getNationalAccessCode()
    {
        return $this->_nationalAccessCode;
    }

    /**
     * Gets the National Number minimum length.
     *
     * @return int National Number min length
     */
    public function getNationalNumberMinLength()
    {
        return $this->_nationalNumberMinLength;
    }

    /**
     * Gets the National Number maximum length.
     *
     * @return int National Number max length
     */
    public function getNationalNumberMaxLength()
    {
        return $this->_nationalNumberMaxLength;
    }

    /**
     * Gets the Subscriber Number minimum length.
     *
     * @return int Subscriber Number min length
     */
    public function getSubscriberNumberMinLength()
    {
        return $this->_subscriberNumberMinLength;
    }

    /**
     * Gets the Subscriber Number maximum length.
     *
     * @return int Subscriber Number max length
     */
    public function getSubscriberNumberMaxLength()
    {
        return $this->_subscriberNumberMaxLength;
    }

    /**
     * Gets Area Code.
     *
     * @return string Area Code
     */
    public function getAreaCode()
    {
        return $this->_areaCode;
    }

    /**
     * If the country has open dialling plan.
     * (If the dialing plan is closed national number must allways be dialled)
     *
     * @return boolean
     */
    public function hasOpenDiallingPlan()
    {
        return $this->_hasOpenDiallingPlan;
    }
}

/* EOF */