<?php
/**
 * Abstract specification class.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Specification
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Abstract.php 1954 2009-09-24 15:27:45Z rgasler $
 */

abstract class Streamwide_Specification_Abstract
{
    /**
     * Is the specification satisfied by $candidate?
     *
     * @param object $candidate Candidate object
     * @return boolean
     */
    abstract public function isSatisfiedBy( $candidate );
    
    /**
     * Perform a logical AND between this specification and $spec and
     * return the composite specification
     *
     * @param Streamwide_Specification_Abstract $spec Specification
     * @return Streamwide_Specification_Abstract
     */
    public function logicalAnd( Streamwide_Specification_Abstract $spec )
    {
        return new Streamwide_Specification_And( $this, $spec );
    }
    
    /**
     * Perform a logical OR between this specification and $spec and return
     * the composite specification
     *
     * @param Streamwide_Specification_Abstract $spec Specification
     * @return Streamwide_Specification_Abstract
     */
    public function logicalOr( Streamwide_Specification_Abstract $spec )
    {
        return new Streamwide_Specification_Or( $this, $spec );
    }
    
    /**
     * Negate the $spec specification
     *
     * @return Streamwide_Specification_Abstract
     */
    public function not()
    {
        return new Streamwide_Specification_Not( $this );
    }
}

/* EOF */