<?php
/**
 * StreamWIDE Framework
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Codec.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents an abstract media codec.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Codec
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_codecName;
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_codecDescription;
    
    /**
     * Get the codec name.
     *
     * @return string codec name
     */
    public function getCodecName()
    {
        return $this->_codecName;
    }
    
    /**
     * Get the codec description.
     *
     * @return string codec description
     */
    public function getCodecDescription()
    {
        return $this->_description();
    }
    
    /**
     * Checks if a parameter is positive int.
     *
     * @param  string $name  parameter name
     * @param  mixed  $value parameter value
     * @return void
     * @throws Streamwide_Media_Exception
     */
    protected function _validatePositiveInt($name, $value) {
        if (!is_int($value) || $value < 0) {
            throw new Streamwide_Media_Exception($name . ' should be positive integer');
        }
    }
}
/* EOF */