<?php
/**
 * StreamWIDE PHPUnit
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: EnvironmentInterface.php 2103 2009-11-15 20:51:51Z rgasler $
 */

/**
 * Global environment interface.
 *
 * You can implement this interface to provide
 * global setUp() and tearDown() functions,
 * that are runned before and after all suites run.
 *
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 */
interface Streamwide_PHPUnit_Runner_EnvironmentInterface
{
	/**
	 * Sets up the fixture for tests.
	 * This method is called before all tests are executed.
	 *
	 * @return void
	 */
	public function setUp();

	/**
	 * Tears down the fixture for tests.
	 * This method is called after all tests are executed.
	 *
	 * @return void
	 */
	public function tearDown();
}

/* EOF */