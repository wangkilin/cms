<?php
/**
 * Implementation of the AND operation.
 *
 * $Rev: 1992 $
 * $LastChangedDate: 2009-09-30 16:40:48 +0800 (Wed, 30 Sep 2009) $
 * $LastChangedBy: salexandru $
 *
 * @category   Streamwide
 * @package    Streamwide_Specification
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: And.php 1992 2009-09-30 08:40:48Z salexandru $
 */

class Streamwide_Specification_And extends Streamwide_Specification_Abstract
{
    
    /**
     * The left operand of a logical AND operation
     *
     * @var Streamwide_Specification_Abstract
     */
    protected $_leftSpec;
    
    /**
     * The right operand of a logical AND operation
     *
     * @var Streamwide_Specification_Abstract
     */
    protected $_rightSpec;
    
    /**
     * Flag to indicate whether or not the logical AND will be short circuited
     *
     * @var boolean
     */
    protected $_shortCircuit = true;
    
    /**
     * Constructor
     *
     * @param Streamwide_Specification_Abstract $leftSpec  Left specification
     * @param Streamwide_Specification_Abstract $rightSpec Right specification
     * @return void
     */
    public function __construct( Streamwide_Specification_Abstract $leftSpec, Streamwide_Specification_Abstract $rightSpec )
    {
        $this->_leftSpec = $leftSpec;
        $this->_rightSpec = $rightSpec;
    }
    
    /**
     * Retrieve the left specification
     *
     * @return Streamwide_Specification_Abstract
     */
    public function getLeftSpec()
    {
        return $this->_leftSpec;
    }
    
    /**
     * Retrieve the right specification
     *
     * @return Streamwide_Specification_Abstract
     */
    public function getRightSpec()
    {
        return $this->_rightSpec;
    }
    
    /**
     * Is the specification satisfied by $candidate?
     *
     * @param object $candidate Candidate object
     * @return boolean
     */
    public function isSatisfiedBy( $candidate )
    {
        if ( !$this->_shortCircuit ) {
            $ret = $this->_leftSpec->isSatisfiedBy( $candidate );
            return ( $this->_rightSpec->isSatisfiedBy( $candidate ) && $ret );
        }
        
        return (
            $this->_leftSpec->isSatisfiedBy( $candidate ) &&
            $this->_rightSpec->isSatisfiedBy( $candidate )
        );
    }
    
    /**
     * Set the short circuit flag
     *
     * @param boolean $bool Short circuit flag
     * @return Streamwide_Specification_Abstract
     */
    public function shortCircuit( $bool )
    {
        $this->_shortCircuit = (bool)$bool;
        return $this;
    }
}

/* EOF */