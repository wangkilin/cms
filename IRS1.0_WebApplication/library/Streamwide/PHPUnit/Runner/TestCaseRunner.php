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
 * @version    $Id: TestCaseRunner.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Runner/TestCase.php';

/**
 * Test Case Runner interface.
 * Every test case runner must implement this interface.
 *
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 */
interface Streamwide_PHPUnit_Runner_TestCaseRunner
{
    /**
     * Runs a test case.
     *
     * @param Streamwide_PHPUnit_Runner_TestCase $testCase     test case
     * @param boolean                   $codeCoverage (optional) whether to collect code coverage or not
     * @param array                     $options      (optional) additional options to pass to the runner
     * @return Streamwide_PHPUnit_Runner_TestCaseResult
     */
    public function run(Streamwide_PHPUnit_Runner_TestCase $testCase, $codeCoverage = false, Array $options = null);
}

/* EOF */