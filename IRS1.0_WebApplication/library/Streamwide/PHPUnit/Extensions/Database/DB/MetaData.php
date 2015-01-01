<?php
/**
 * MetaData with with oci8 support.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: MetaData.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'PHPUnit/Extensions/Database/DB/IMetaData.php';

/*
 * MetaData with with oci8 support.
 *
 * This class was needed to implement oci8 support.
 * Could not use PHPUnit_Extensions_Database_DB_MetaData
 * because constructor is final with PDO type hinting.
 */
abstract class Streamwide_PHPUnit_Extensions_Database_DB_MetaData implements PHPUnit_Extensions_Database_DB_IMetaData
{
    /**
     * Provide Oracle class mapping and overload default meta data class map for mysql.
     *
     * @var array
     */
    protected static $metaDataClassMap = array(
        'oracle' => 'Streamwide_PHPUnit_Extensions_Database_DB_MetaData_Oracle',
        'mysql'  => 'Streamwide_PHPUnit_Extensions_Database_DB_MetaData_MySQL'
    );

    /**
     * The connection used to retreive database meta data
     *
     * @var PDO|resource
     */
    protected $connection;

    /**
     * The default schema name for the meta data object.
     *
     * @var string
     */
    protected $schema;

    /**
     * The character used to quote schema objects.
     */
    protected $schemaObjectQuoteChar = '"';

    /**
     * The command used to perform a TRUNCATE operation.
     */
    protected $truncateCommand = 'TRUNCATE';

    /**
     * Creates a new database meta data object using the given connection
     * and schema name.
     *
     * @param PDO|resource $connection or oci8 connection identifier
     * @param string       $schema
     * @return Streamwide_PHPUnit_Extensions_Database_DB_MetaData
     */
    public final function __construct($connection, $schema)
    {
        if (is_resource($connection)
            && get_resource_type($connection) == 'oci8 connection') {
            $this->connection = new Streamwide_PHPUnit_Extensions_Database_Adapter_Oracle($connection);
        } else {
            if ($connection instanceof PDO) {
                $this->connection = $connection;
            } else {
                throw new Exception('Connection must be a PDO or an oci8 connection identifier.');
            }
        }

        $this->schema = $schema;
    }

    /**
     * Creates a meta data object based on the driver of given connection and
     * $schema name.
     *
     * @param PDO|resource $connection
     * @param string $schema
     * @return PHPUnit_Extensions_Database_DB_IMetaData
     */
    public static function createMetaData($connection, $schema)
    {
        // for PDO use PHPUnit_Extensions_Database_DB_IMetaData
        if ($connection instanceof PDO) {
            $driverName = $connection->getAttribute(PDO::ATTR_DRIVER_NAME);
            // register overloaded classes maps for pdo
            if (isset(self::$metaDataClassMap[$driverName])) {
                $className = self::$metaDataClassMap[$driverName];
                PHPUnit_Extensions_Database_DB_MetaData::registerClassWithDriver($className, $driverName);
            }
            return PHPUnit_Extensions_Database_DB_MetaData::createMetaData($connection, $connection);
        }

        $driverName = 'oracle';
        if (isset(self::$metaDataClassMap[$driverName])) {
            $className = self::$metaDataClassMap[$driverName];

            if ($className instanceof ReflectionClass) {
                return $className->newInstance($connection, $schema);
            } else {
                return self::registerClassWithDriver($className, $driverName)->newInstance($connection, $schema);
            }
        } else {
            throw new Exception("Could not find a meta data driver for {$driverName} driver.");
        }
    }

    /**
     * Validates and registers the given $className with the given $driver.
     * It should be noted that this function will not attempt to include /
     * require the file.
     *
     * A reflection of the $className is returned.
     *
     * @param string $className
     * @param string $driver
     * @return ReflectionClass
     */
    public static function registerClassWithDriver($className, $driver)
    {
        if (!class_exists($className)) {
            throw new Exception("Specified class for {$driver} driver ({$className}) does not exist.");
        }

        $reflection = new ReflectionClass($className);
        if ($reflection->isSubclassOf('Streamwide_PHPUnit_Extensions_Database_DB_MetaData')) {
            return self::$metaDataClassMap[$driver] = $reflection;
        } else {
            throw new Exception("Specified class for {$driver} driver ({$className}) does not extend Streamwide_PHPUnit_Extensions_Database_DB_MetaData.");
        }
    }

    /**
     * Returns the schema for the connection.
     *
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Returns a quoted schema object. (table name, column name, etc)
     *
     * @param string $object
     * @return string
     */
    public function quoteSchemaObject($object)
    {
        $parts = explode('.', $object);
        $quotedParts = array();

        foreach ($parts as $part) {
            $quotedParts[] = $this->schemaObjectQuoteChar .
                str_replace($this->schemaObjectQuoteChar, $this->schemaObjectQuoteChar.$this->schemaObjectQuoteChar, $part).
                $this->schemaObjectQuoteChar;
        }

        return implode('.', $quotedParts);
    }

    /**
     * Seperates the schema and the table from a fully qualified table name.
     *
     * Returns an associative array containing the 'schema' and the 'table'.
     *
     * @param string $fullTableName
     * @return array
     */
    public function splitTableName($fullTableName)
    {
        if (($dot = strpos($fullTableName, '.')) !== FALSE) {
            return array(
                'schema' => substr($fullTableName, 0, $dot),
                'table' => substr($fullTableName, $dot + 1)
            );
        } else {
            return array(
                'schema' => NULL,
                'table' => $fullTableName
            );
        }
    }

    /**
     * Returns the command for the database to truncate a table.
     *
     * @return string
     */
    public function getTruncateCommand()
    {
        return $this->truncateCommand;
    }

    /**
     * Returns true if the rdbms allows cascading
     *
     * @return bool
     */
    public function allowsCascading()
    {
        return FALSE;
    }
}

/**
 * I am not sure why these requires can't go above the class, but when they do
 * the classes can't find the PHPUnit_Extensions_Database_DB_MetaData
 * class.
 */
require_once 'Streamwide/PHPUnit/Extensions/Database/DB/MetaData/Oracle.php';
require_once 'Streamwide/PHPUnit/Extensions/Database/DB/MetaData/MySQL.php';

/* EOF */