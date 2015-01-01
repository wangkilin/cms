<?php
/**
 *
 * $Rev: 2088 $
 * $LastChangedDate: 2009-10-30 20:56:54 +0800 (Fri, 30 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

abstract class Streamwide_Engine_NotifyFilter extends Streamwide_Specification_Abstract
{
    
    /**
     * The value against which the candidate is checked to see if it satisfies the specification
     *
     * @var mixed
     */
    protected $_value;
    
    /**
     * Constructor
     *
     * @param mixed $value
     * @return void
     */
    public function __construct( $value )
    {
        $this->_value = $value;
    }
    
    /**
     * Retrieve the value against which the candidate is checked
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

}
 
/* EOF */