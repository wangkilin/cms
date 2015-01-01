<?php
/**
 * The default database tester implementation.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: DefaultTester.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'PHPUnit/Extensions/Database/AbstractTester.php';

require_once 'Streamwide/PHPUnit/Extensions/Database/Operation/Factory.php';

/**
 * This is the default implementation of the database tester. It receives its
 * connection object from the constructor.
 */
class Streamwide_PHPUnit_Extensions_Database_DefaultTester extends PHPUnit_Extensions_Database_AbstractTester
{

    /**
     * @var PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected $connection;

    /**
     * Creates a new default database tester using the given connection.
     *
     * @param PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection
     */
    public function __construct(PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection)
    {
        $this->connection = $connection;

        $this->setUpOperation = Streamwide_PHPUnit_Extensions_Database_Operation_Factory::CLEAN_INSERT();
        $this->tearDownOperation = Streamwide_PHPUnit_Extensions_Database_Operation_Factory::NONE();
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }
}

/* EOF */