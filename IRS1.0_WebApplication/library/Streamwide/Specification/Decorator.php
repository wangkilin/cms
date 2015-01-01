<?php
/**
 * Specification decorator.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Specification
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Decorator.php 1954 2009-09-24 15:27:45Z rgasler $
 */

abstract class Streamwide_Specification_Decorator extends Streamwide_Specification_Abstract
{
    /**
     * The decorator specification
     *
     * @var Streamwide_Specification_Abstract
     */
    protected $_spec;
    
    /**
     * Constructor
     *
     * @param Streamwide_Specification_Abstract $spec Specification
     */
    public function __construct( Streamwide_Specification_Abstract $spec )
    {
        $this->_spec = $spec;
    }
    
    /**
     * Is the specification satisfied by $candidate?
     *
     * @param object $candidate Candidate object
     * @return boolean
     */
    public function isSatisfiedBy( $candidate )
    {
        return $this->_spec->isSatisfiedBy( $candidate );
    }
    
    /**
     * Route all non existent method calls to the decorated object
     *
     * @param string $method Method name
     * @param array  $args   Method arguments
     * @return mixed
     */
    public function __call( $method, $args )
    {
        return call_user_func_array( array( $this->_spec, $method ), $args );
    }
}

/* EOF */