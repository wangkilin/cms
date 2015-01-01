<?php
/**
 * Provides a basic interface for communicating with a database.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: DefaultDatabaseConnection.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'PHPUnit/Extensions/Database/DataSet/QueryTable.php';
require_once 'PHPUnit/Extensions/Database/DB/IDatabaseConnection.php';
require_once 'PHPUnit/Extensions/Database/DB/ResultSetTable.php';
require_once 'PHPUnit/Extensions/Database/DB/DataSet.php';
require_once 'PHPUnit/Extensions/Database/DB/FilteredDataSet.php';

require_once 'Streamwide/PHPUnit/Extensions/Database/DB/MetaData.php';
require_once 'Streamwide/PHPUnit/Extensions/Database/Adapter/Oracle.php';

/*
 * This class provides a basic interface for communicating with a database.
 *
 * It replicates most so the
 * PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection code -
 * because of PDO type hinting for constructor it cannot be extended.
 *
 */
class Streamwide_PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection implements PHPUnit_Extensions_Database_DB_IDatabaseConnection
{
    /**
     * @var PDO|resource
     */
    protected $connection;

    /**
     * @var string
     */
    protected $schema;

    /**
     * The metadata object used to retrieve table meta data from the database.
     *
     * @var PHPUnit_Extensions_Database_DB_IMetaData
     */
    protected $metaData;

    /**
     * Creates a new database connection
     *
     * @param PDO|resource $connection PDO or an oci8 connection identifier
     * @param string $schema - The name of the database schema you will be testing against.
     */
    public function __construct($connection, $schema)
    {
        if (is_resource($connection)
            && get_resource_type($connection) == 'oci8 connection') {
            $this->connection = new Streamwide_PHPUnit_Extensions_Database_Adapter_Oracle($connection);
        } else {
            if ($connection instanceof PDO) {
                $this->connection = $connection;

                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } else {
                throw new Exception('Connection must be a PDO or an oci8 connection identifier.');
            }
        }

        $this->metaData = Streamwide_PHPUnit_Extensions_Database_DB_MetaData::createMetaData($connection, $schema);
        $this->schema = $schema;
    }

    /**
     * Close this connection.
     */
    public function close()
    {
        unset($this->connection);
    }

    /**
     * Returns a database metadata object that can be used to retrieve table
     * meta data from the database.
     *
     * @return PHPUnit_Extensions_Database_DB_IMetaData
     */
    public function getMetaData()
    {
        return $this->metaData;
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
     * Creates a dataset containing the specified table names. If no table
     * names are specified then it will created a dataset over the entire
     * database.
     *
     * @param array $tableNames
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     * @todo Implement the filtered data set.
     */
    public function createDataSet(Array $tableNames = NULL)
    {
        if (empty($tableNames)) {
            return new PHPUnit_Extensions_Database_DB_DataSet($this);
        } else {
            return new PHPUnit_Extensions_Database_DB_FilteredDataSet($this, $tableNames);
        }
    }

    /**
     * Creates a table with the result of the specified SQL statement.
     *
     * @param string $resultName
     * @param string $sql
     * @return PHPUnit_Extensions_Database_DB_Table
     */
    public function createQueryTable($resultName, $sql)
    {
        return new PHPUnit_Extensions_Database_DataSet_QueryTable($resultName, $sql, $this);
    }

    /**
     * Returns this connection database configuration
     *
     * @return PHPUnit_Extensions_Database_Database_DatabaseConfig
     */
    public function getConfig()
    {

    }

    /**
     * Returns a PDO or oci8 connection
     *
     * @return PDO|resource
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Returns the number of rows in the given table. You can specify an
     * optional where clause to return a subset of the table.
     *
     * @param string $tableName
     * @param string $whereClause
     * @param int
     */
    public function getRowCount($tableName, $whereClause = NULL)
    {
        $query = "SELECT COUNT(*) FROM ".$this->quoteSchemaObject($tableName);

        if (isset($whereClause)) {
            $query .= " WHERE {$whereClause}";
        }
    }

    /**
     * Returns a quoted schema object. (table name, column name, etc)
     *
     * @param string $object
     * @return string
     */
    public function quoteSchemaObject($object)
    {
        return $this->getMetaData()->quoteSchemaObject($object);
    }

    /**
     * Returns the command used to truncate a table.
     *
     * @return string
     */
    public function getTruncateCommand()
    {
        return $this->getMetaData()->getTruncateCommand();
    }

    /**
     * Returns true if the connection allows cascading
     *
     * @return bool
     */
    public function allowsCascading()
    {
        return $this->getMetaData()->allowsCascading();
    }
}

/* EOF */