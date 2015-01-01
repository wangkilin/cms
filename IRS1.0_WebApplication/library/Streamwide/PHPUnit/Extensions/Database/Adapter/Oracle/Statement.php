<?php
/**
 * Statement adapter for oci8 to PDO.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Statement.php 2103 2009-11-15 20:51:51Z rgasler $
 */

/**
 * Statement adapter for oci8 to PDO.
 */
class Streamwide_PHPUnit_Extensions_Database_Adapter_Oracle_Statement
{
    /**
     * oci8 statement identifier
     *
     * @var resource
     */
    protected $statement;

    /**
     * Creates a new oci8 statement adapter.
     *
     * @param resource $statement
     * @return Streamwide_PHPUnit_Extensions_Database_DB_Adapter_Oracle_Statement
     */
    public function __construct($statement)
    {
        if (is_resource($statement)
            && get_resource_type($statement) == 'oci8 statement') {
                $this->statement = $statement;
        } else {
            throw new Exception('Statement must be a valid oci8 statement identifier.');
        }
    }

    /**
     * Executes a prepared statement.
     *
     * @param array $args an array of values with as many elements as there are bound parameters in the statement
     * @return boolean returns true on success or false on failure
     */
    public function execute($args = array())
    {
        foreach($args as $key => $value) {
            oci_bind_by_name($this->statement, ":" . $key, $args[$key]);
        }
        return oci_execute($this->statement, OCI_DEFAULT);
    }

    /**
     * Fetches the next row from a result set.
     *
     * @return array|boolean
     */
    public function fetch()
    {
        $row = oci_fetch_row($this->statement);
        return $row;
    }

    /**
     * Returns an array containing all of the result set rows.
     *
     * @param int $fetchStyle a pdo fetch syle constant
     * @return array
     */
    public function fetchAll($fetchStyle = PDO::FETCH_BOTH)
    {
        switch($fetchStyle) {
            case PDO::FETCH_BOTH:
                $flags = OCI_FETCHSTATEMENT_BY_ROW + OCI_BOTH;
                break;
            case PDO::FETCH_ASSOC:
                $flags = OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC;
            default:
                $flags = 0;
                break;

        }
        oci_fetch_all($this->statement, $rows, null, null, $flags);
        return $rows;
    }

    /**
     * Returns a single column from the next row of a result set.
     *
     * @param integer $columnNumber
     * @return string|boolean
     */
    public function fetchColumn($columnNumber = 0)
    {
        $row = $this->fetch();
        if ($row) {
            return $row[$columnNumber];
        }

        return false;
    }
}

/*EOF*/