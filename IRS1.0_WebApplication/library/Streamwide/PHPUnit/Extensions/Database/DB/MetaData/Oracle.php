<?php
/**
 * Provides functionality to retrieve meta data from an Oracle database.
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

require_once 'Streamwide/PHPUnit/Extensions/Database/DB/MetaData.php';

/**
 * Provides functionality to retrieve meta data from an Oracle database.
 */
class Streamwide_PHPUnit_Extensions_Database_DB_MetaData_Oracle extends Streamwide_PHPUnit_Extensions_Database_DB_MetaData
{
   protected $columns = array();
   protected $keys = array();

    /**
     * The command used to perform a TRUNCATE operation.
     */
    protected $truncateCommand = 'TRUNCATE TABLE';

   /**
    * Returns an array containing the names of all the tables in the database.
    *
    * @return array
    */
   public function getTableNames()
   {
        $tableNames = array();

       $query = "SELECT table_name
                   FROM cat
                  WHERE table_type='TABLE'
                  ORDER BY table_name";

       $result = $this->conection->query($query);

       while ($tableName = $result->fetchColumn(0)) {
           $tableNames[] = $tableName;
       }

       return $tableNames;
   }

   /**
    * Returns an array containing the names of all the columns in the
    * $tableName table,
    *
    * @param string $tableName
    * @return array
    */
   public function getTableColumns($tableName)
   {
       if (!isset($this->columns[$tableName])) {
           $this->loadColumnInfo($tableName);
       }

       return $this->columns[$tableName];
   }

   /**
    * Returns an array containing the names of all the primary key columns in
    * the $tableName table.
    *
    * @param string $tableName
    * @return array
    */
   public function getTablePrimaryKeys($tableName)
   {
       if (!isset($this->keys[$tableName])) {
           $this->loadColumnInfo($tableName);
       }

       return $this->keys[$tableName];
   }

   /**
    * Loads column info from a oracle database.
    *
    * @param string $tableName
    */
   protected function loadColumnInfo($tableName)
   {
       $this->columns[$tableName] = array();
       $this->keys[$tableName]    = array();

       $query = "SELECT COLUMN_NAME
                   FROM USER_TAB_COLUMNS
                  WHERE TABLE_NAME='".$tableName."'";

       $result = $this->connection->query($query);

       while ($columnName = $result->fetchColumn(0)) {
            $this->columns[$tableName][] = $columnName;
       }

       $keyQuery = "SELECT b.column_name
                      FROM user_constraints a, user_cons_columns b
                     WHERE a.constraint_type='P'
                       AND a.constraint_name=b.constraint_name
                       AND a.table_name = '".$tableName."' ";

        $result = $this->connection->query($keyQuery);

        while ($columnName = $result->fetchColumn(0)) {
            $this->keys[$tableName][] = $columnName;
       }
   }
}

/*EOF*/