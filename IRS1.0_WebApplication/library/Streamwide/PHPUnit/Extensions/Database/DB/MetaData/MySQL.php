<?php
/**
 * Provides functionality to retrieve meta data from a MySQL database.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: MySQL.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'PHPUnit/Extensions/Database/DB/MetaData/MySQL.php';

/**
 * Provides functionality to retrieve meta data from a MySQL database.
 *
 * This class also disables loading of primary keys which is
 * a costly action on systems with many databases.
 */
class Streamwide_PHPUnit_Extensions_Database_DB_MetaData_MySQL extends PHPUnit_Extensions_Database_DB_MetaData_MySQL
{
    /**
     * Returns an array containing the names of all the primary key columns in
     * the $tableName table.
     *
     * @param string $tableName
     * @return array
     */
    public function getTablePrimaryKeys($tableName)
    {
        return array();
    }
}

/*EOF*/