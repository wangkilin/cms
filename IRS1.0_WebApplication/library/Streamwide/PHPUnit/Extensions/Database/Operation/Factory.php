<?php
/**
 * A factory to easily return database operations.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Factory.php 2103 2009-11-15 20:51:51Z rgasler $
 */


require_once 'PHPUnit/Extensions/Database/Operation/IDatabaseOperation.php';
require_once 'PHPUnit/Extensions/Database/Operation/Factory.php';

require_once 'Streamwide/PHPUnit/Extensions/Database/Operation/Insert.php';

/**
 * A class factory to easily return database operations.
 */
class Streamwide_PHPUnit_Extensions_Database_Operation_Factory extends PHPUnit_Extensions_Database_Operation_Factory
{
    /**
     * Returns a clean insert database operation. It will remove all contents
     * from the table prior to re-inserting rows.
     *
     * @param bool $cascadeTruncates Set to true to force truncates to cascade on databases that support this.
     * @return PHPUnit_Extensions_Database_Operation_IDatabaseOperation
     */
    public static function CLEAN_INSERT($cascadeTruncates = FALSE)
    {
        return new PHPUnit_Extensions_Database_Operation_Composite(array(
            self::DELETE_ALL(),
            self::INSERT()
        ));
    }

    /**
     * Returns an insert database operation.
     *
     * @return PHPUnit_Extensions_Database_Operation_IDatabaseOperation
     */
    public static function INSERT()
    {
        return new Streamwide_PHPUnit_Extensions_Database_Operation_Insert();
    }
}

/* EOF */