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

/**
 * An abstract factory that returns (decorated) notification filters
 */
abstract class Streamwide_Engine_NotifyFilter_Factory {

    const T_EVT_SIG_PARAM_PARAM = 'EventSignalParameterParameter';
    const T_EVT_SIG_PARAM_NAME = 'EventSignalParameterName';
    const T_EVT_SIG_PARAM_REMOTE = 'EventSignalParameterRemote';
    const T_EVT_PARAM = 'EventParameter';
    const T_EVT_ERR_CODE = 'EventErrorCode';
    const T_SIG_PARAM = 'SignalParameter';
    
    const FILTER_IN_ARRAY = 'inArray';
    const FILTER_EQUAL_TO = 'equalTo';
    const FILTER_INSTANCE_OF = 'instanceOf';
    
    /**
     * Filter types
     *
     * @var array
     */
    public static $filterTypes = array(
        self::FILTER_IN_ARRAY,
        self::FILTER_EQUAL_TO,
        self::FILTER_INSTANCE_OF
    );
    
    /**
     * Constructor
     *
     * @return void
     */
    final public function __construct()
    {}
    
    /**
     * Returns a filter that tests a candidate value for equality with a user provided value
     *
     * @param mixed $value
     * @param boolean $strict
     * @return Streamwide_Specification_Abstract
     */
    public function equalToFilter( $value, $strict = false )
    {
        return new Streamwide_Engine_NotifyFilter_EqualTo( $value, $strict );
    }
    
    /**
     * Returns a filter that tests the existence of candidate value in a user provided list of values
     *
     * @param array $list
     * @param boolean $emptyListSatisfiesAll
     * @param boolean $strict
     * @return Streamwide_Specification_Abstract
     */
    public function inArrayFilter( Array $list, $emptyListSatisfiesAll = false, $strict = false )
    {
        return new Streamwide_Engine_NotifyFilter_InArray( $list, $emptyListSatisfiesAll, $strict );
    }
    
    /**
     * Returns a filter that tests whether or not a candidate value is a instance of a certain class
     *
     * @param string $class
     * @return Streamwide_Specification_Abstract
     */
    public function instanceOfFilter( $class )
    {
        return new Streamwide_Engine_NotifyFilter_InstanceOf( $class );
    }
    
    /**
     * Returns the appropriate filter based on provided parameters
     *
     * @param string $factoryType The type of factory that will create the filter
     * @param string $filterType The type of filter to be created
     * @param mixed $args The arguments needed by the filter
     * @param boolean Whether or not $args is the first argument for the filter
     * @return Streamwide_Specification_Abstract
     * @throws InvalidArgumentException
     */
    public static function factory( $factoryType, $filterType, $args )
    {
        $factoryClass = null;
        
        switch ( $factoryType ) {
            case self::T_EVT_SIG_PARAM_PARAM:
                $factoryClass = 'Streamwide_Engine_NotifyFilter_Factory_EventSignalParameterParameter';
            break;
            case self::T_EVT_SIG_PARAM_NAME:
                $factoryClass = 'Streamwide_Engine_NotifyFilter_Factory_EventSignalParameterName';
            break;
            case self::T_EVT_SIG_PARAM_REMOTE:
                $factoryClass = 'Streamwide_Engine_NotifyFilter_Factory_EventSignalParameterRemote';
            break;
            case self::T_EVT_PARAM:
                $factoryClass = 'Streamwide_Engine_NotifyFilter_Factory_EventParameter';
            break;
            case self::T_EVT_ERR_CODE:
                $factoryClass = 'Streamwide_Engine_NotifyFilter_Factory_EventErrorCode';
            break;
            case self::T_SIG_PARAM:
                $factoryClass = 'Streamwide_Engine_NotifyFilter_Factory_SignalParameter';
            break;
            default:
                throw new InvalidArgumentException( 'Invalid notification filter factory type provided' );
            break;
        }
        
        if ( !in_array( $filterType, self::$filterTypes ) ) {
            throw new InvalidArgumentException( 'Invalid notification filter type provided' );
        }
        $filterMethod = sprintf( '%sFilter', $filterType );
        
        if ( !is_array( $args ) ) {
            $args = array( $args );
        }
        
        $class = new ReflectionClass( $factoryClass );
        $method = $class->getMethod( $filterMethod );
        return $method->invokeArgs( $class->newInstance(), $args );
    }
    
}
 
/* EOF */