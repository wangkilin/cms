<?php
/**
 * The default Strategy to discover phone number format.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PhoneNumber
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Default.php 1954 2009-09-24 15:27:45Z rgasler $
 */

/**
 * Streamwide_PhoneNumber_Strategy_DiscoverFormat_Default
 *
 *  It tries to dicover the format based on the following rules:
 *  - starts with IDD or '+' => IDD-CC-NN
 *  - starts with NDD => NDD-NN
 *  - longer that NN max => CC-NN
 *  - has open dialling plan:
 *    - shorter than SN min => short
 *    - shorter than NN min => SN
 *  - else:
 *    - shorter than NN min => short
 *    - less or equal to NN max:
 *      - starts with CC and len(pn - CC) >= NN min => CC-NN
 *      - else => NN
 *  - finally => NN
 */
class Streamwide_PhoneNumber_Strategy_DiscoverFormat_Default implements Streamwide_PhoneNumber_Strategy_DiscoverFormat_Interface
{
    /**
     * Transformer object context.
     *
     * @var Streamwide_PhoneNumber_Transformer
     */
    protected $_context;

    /**
     * Set the Streamwide_PhoneNumber_Transformer Context object this strategy resides in.
     *
     * @param Streamwide_PhoneNumber_Transformer $context the context of the transformer
     * @return void
     */
    public function setContext(Streamwide_PhoneNumber_Transformer $context)
    {
        $this->_context = $context;
        
        return $this;
    }

    /**
     * Return the current Streamwide_PhoneNumber_Transformer context object
     *
     * @return Streamwide_PhoneNumber_Transformer
     */
    public function getContext()
    {
        return $this->_context;
    }
    
    /**
     * Discover phone number format based on locale settings.
     *
     * @return string the format of the phone number
     * @see Streamwide_PhoneNumber_Transformer::getAllFormats()
     */
    public function discoverFormat()
    {
        // using the following variables from context
        $locale = $this->_context->getLocale();
        $phoneNumber = $this->_context->getPhoneNumber();
        
        // Starts with IDD or '+'
        $codes = array($locale->getInternationalAccessCode(), '+');
        foreach ($codes as $IDD) {
            if (substr($phoneNumber, 0, strlen($IDD)) == $IDD) {
                return Streamwide_PhoneNumber_Transformer::IDDCCNN;
            }
        }

        // Starts with NDD
        $NDD = $locale->getNationalAccessCode();
        if (substr($phoneNumber, 0, strlen($NDD)) == $NDD) {
            return Streamwide_PhoneNumber_Transformer::NDDNN;
        }

        // Apply limits:
        $phoneNumberLength = strlen($phoneNumber);

        // If longer that NN max it is international
        if ($phoneNumberLength > $locale->getNationalNumberMaxLength()) {
            return Streamwide_PhoneNumber_Transformer::CCNN;
        }

        // for open dialling plan try to see if it is Subscriber Number
        if ($locale->hasOpenDiallingPlan()) {
            if ($phoneNumberLength < $locale->getSubscriberNumberMinLength()) {
                // it is a short number
                return Streamwide_PhoneNumber_Transformer::SHORT;
            }
            if ($phoneNumberLength < $locale->getNationalNumberMinLength()) {
                return Streamwide_PhoneNumber_Transformer::SN;
            }
        } else {
            // Closed dialling plan:
            if ($phoneNumberLength < $locale->getNationalNumberMinLength()) {
                // it is a short number
                return Streamwide_PhoneNumber_Transformer::SHORT;
            }
            if ($phoneNumberLength <= $locale->getNationalNumberMaxLength()) {
                // Here we make the assumption that for an open numbering plan
                // the NN does not start with CC.
                // In the rare exceptions to this rule, a new strategy should be
                // defined to handle these cases.
                $CC = $locale->getCountryCode();
                if ((substr($phoneNumber, 0, strlen($CC)) == $CC)
                    && (strlen($phoneNumber) - strlen($CC) >= $locale->getNationalNumberMinLength())) {
                    return Streamwide_PhoneNumber_Transformer::CCNN;
                } else {
                    return Streamwide_PhoneNumber_Transformer::NN;
                }
            }
        }

        // forcefully the only possible left solution is NN
        return Streamwide_PhoneNumber_Transformer::NN;
    }
}

/* EOF */