<?php
/**
 * Implementation of NOT operation.
 *
 * $Rev: 1992 $
 * $LastChangedDate: 2009-09-30 16:40:48 +0800 (Wed, 30 Sep 2009) $
 * $LastChangedBy: salexandru $
 *
 * @category   Streamwide
 * @package    Streamwide_Specification
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Not.php 1992 2009-09-30 08:40:48Z salexandru $
 */

class Streamwide_Specification_Not extends Streamwide_Specification_Abstract
{

    /**
     * The specification that will be negated
     *
     * @var Streamwide_Specification_Abstract
     */
    protected $_spec;
    
    /**
     * Constructor
     *
     * @param Streamwide_Specification_Abstract $spec specification
     */
    public function __construct( Streamwide_Specification_Abstract $spec )
    {
        $this->_spec = $spec;
    }
    
    /**
     * Retrieve the specification that will be negated
     *
     * @return Streamwide_Specification_Abstract
     */
    public function getSpec() {
        return $this->_spec;
    }
    
    /**
     * Is the specification satisfied by $candidate?
     *
     * @param object $candidate Candidate object
     * @return boolean
     */
    public function isSatisfiedBy( $candidate )
    {
        return !$this->_spec->isSatisfiedBy( $candidate );
    }
}

/* EOF */