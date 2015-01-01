<?php
/**
 * oci8 to PDO connection adapter.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Oracle.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Extensions/Database/Adapter/Oracle/Statement.php';

/**
 * oci8 to PDO connection adapter.
 */
class Streamwide_PHPUnit_Extensions_Database_Adapter_Oracle
{
    /**
     * oci8 resource identifier
     *
     * @var resource
     */
    protected $connection;

    /**
     * Creates a new oci8 adapter.
     *
     * @param resource $connection
     * @return Streamwide_PHPUnit_Extensions_Database_DB_Adapter_Oracle
     */
    public function __construct($connection)
    {
        if (is_resource($connection)
            && get_resource_type($connection) == 'oci8 connection') {
                $this->connection = $connection;
        } else {
            throw new Exception('Connection must be a valid oci8 connection identifier.');
        }
    }

    /**
     * Prepares Oracle statement for execution.
     *
     * @param string $query The SQL statement.
     * @return resource the statement identifier
     */
    public function prepare($query)
    {
        $statement = oci_parse($this->connection, $query);
        return new Streamwide_PHPUnit_Extensions_Database_Adapter_Oracle_Statement($statement);
    }

    /**
     * Executes a query returning a result set as a Statement object.
     *
     * @param string $query The SQL statement.
     * @return Streamwide_PHPUnit_Extensions_Database_DB_Adapter_Oracle_Statement statement
     */
    public function query($query)
    {
        $statement = $this->prepare($query);

        $statement->execute();

        return $statement;
    }
}

/*EOF*/