<?php
/**
 *
 * $Rev: 2084 $
 * $LastChangedDate: 2009-10-27 22:37:20 +0800 (Tue, 27 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

class Streamwide_Specification_Zend_Validate_Adapter extends Streamwide_Specification_Abstract
{
    
    /**
     * A Zend validator object
     *
     * @var Zend_Validate_Interface
     */
    protected $_adaptee;
    
    /**
     * Constructor
     *
     * @param Zend_Validate_Interface $adaptee
     * @return void
     */
    public function __construct( Zend_Validate_Interface $adaptee )
    {
        $this->_adaptee = $adaptee;
    }
    
    /**
     * Calls the adaptee's isValid method
     *
     * @see Specification/Streamwide_Specification_Abstract#isSatisfiedBy($candidate)
     */
    public function isSatisfiedBy( $candidate )
    {
        return $this->_adaptee->isValid( $candidate );
    }

}
 
/* EOF */