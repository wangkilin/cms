<?php
/**
 * Class for inserting rows from a dataset into a database.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Insert.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'PHPUnit/Extensions/Database/Operation/RowBased.php';

/**
 * This class provides functionality for inserting rows from a dataset into a database.
 */
class Streamwide_PHPUnit_Extensions_Database_Operation_Insert extends PHPUnit_Extensions_Database_Operation_RowBased
{

    protected $operationName = 'INSERT';

    /*
     * Builds the query with named parameters instead of positional which is the default in PHPUnit.
     * This is because non-pdo adapters like oci8 do not support positional parameters.
     */
    protected function buildOperationQuery(PHPUnit_Extensions_Database_DataSet_ITableMetaData $databaseTableMetaData, PHPUnit_Extensions_Database_DataSet_ITable $table, PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection)
    {
        $columnCount = count($table->getTableMetaData()->getColumns());

        if ($columnCount > 0) {
            $placeHolders = '';
            foreach ($table->getTableMetaData()->getColumns() as $key => $column) {
                $placeHolders .= ':param' . $key . 'x, ';
            }
            $placeHolders = substr($placeHolders, 0, -2);

            $columns = '';
            foreach ($table->getTableMetaData()->getColumns() as $column) {
                $columns .= $connection->quoteSchemaObject($column).', ';
            }
            $columns = substr($columns, 0, -2);

            $query = "
                INSERT INTO {$connection->quoteSchemaObject($table->getTableMetaData()->getTableName())}
                ({$columns})
                VALUES
                ({$placeHolders})
            ";

            return $query;
        } else {
            return FALSE;
        }
    }

    /*
     * Builds arguments with named parameters instead of positional which is the default in PHPUnit.
     * This is because non-pdo adapters like oci8 do not support positional parameters.
     */
    protected function buildOperationArguments(PHPUnit_Extensions_Database_DataSet_ITableMetaData $databaseTableMetaData, PHPUnit_Extensions_Database_DataSet_ITable $table, $row)
    {
        $args = array();
        foreach ($table->getTableMetaData()->getColumns() as $key => $columnName) {
            $args['param' . $key.'x'] = $table->getValue($row, $columnName);
        }
        return $args;
    }
}

/* EOF */