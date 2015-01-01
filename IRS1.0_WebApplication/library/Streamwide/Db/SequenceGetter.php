<?php
/**
 * Sequence getter class.
 *
 * $Rev: 1954 $
 * $LastChangedDate: 2009-09-24 23:27:45 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Db
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: SequenceGetter.php 1954 2009-09-24 15:27:45Z rgasler $
 */

abstract class Streamwide_Db_SequenceGetter
{
    /**
     * Constructor. Declared as final because at creation time no parameters are specified for the constructor.
     */
    final public function __construct()
    {
    }

    /**
     * Factory method. Returns an instance of a subclass based on $type
     *
     * @param string $class the type of the SequenceGetter subclass to be instantiated
     * @throws Exception
     * @return object SequenceGetter
     */
    public static function factory( $class )
    {
        if ( ! is_string( $class ) ) {
            require_once 'Zend/Db/Adapter/Exception.php';
            throw new Zend_Db_Adapter_Exception( __CLASS__ . '::getInstance() expects parameter 1 to be string, ' . gettype( $class ) . ' given' );
        }

        if ( ! class_exists( $class ) ) {
            require_once 'Zend/Db/Adapter/Exception.php';
            throw new Zend_Db_Adapter_Exception( 'Class "' . $class . '" is not included or does not exist' );
        }

        $sequenceGetter = new $class;

        if ( ! $sequenceGetter instanceof Streamwide_Db_SequenceGetter ) {
            require_once 'Zend/Db/Adapter/Exception.php';
            throw new Zend_Db_Adapter_Exception( 'Class "' . $class . '" is not an instance of Streamwide_Db_SequenceGetter!' );
        }

        return $sequenceGetter;
    }

    /**
     * Builds the sequence name
     *
     * @param string $tableName the table name for whom to build the sequence name
     * @return string|boolean
     */
    public abstract function getSequenceName( $tableName );
}

/* EOF */