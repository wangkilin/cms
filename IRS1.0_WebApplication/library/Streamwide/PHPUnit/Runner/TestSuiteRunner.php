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
 * @version    $Id: TestSuiteRunner.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Runner/TestSuite.php';
require_once 'Streamwide/PHPUnit/Runner/TestSuiteResult.php';
require_once 'Streamwide/PHPUnit/Runner/TestCaseRunner/RemoteOverHttp.php';

/**
 * A test suite runner.
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 */
class Streamwide_PHPUnit_Runner_TestSuiteRunner
{
    /**
     * Test suite.
     *
     * @var Streamwide_PHPUnit_Runner_TestSuite
     */
    protected $_testSuite;
    
    /**
     * Test suite result.
     *
     * @var Streamwide_PHPUnit_Runner_TestSuiteResult
     */
    protected $_testSuiteResult;
    
    /**
     * Whether to collect code coverage.
     *
     * @var boolean
     */
    protected $_collectCodeCoverage;
    
    /**
     * Test case runner.
     *
     * @var Streamwide_PHPUnit_Runner_TestCaseRunner
     */
    protected $_testCaseRunner;
    
    /**
     * Constructor.
     *
     * @param Streamwide_PHPUnit_Runner_TestSuite $testSuite           test suite
     * @param boolean                    $collectCodeCoverage (optional) whether to collect code coverage or not
     * @param string                     $testCaseRunner      (optional) test case runner
     */
    public function __construct(Streamwide_PHPUnit_Runner_TestSuite $testSuite, $testCaseRunner, $collectCodeCoverage = false)
    {
        $this->_testSuite = $testSuite;
        $this->_collectCodeCoverage = $collectCodeCoverage;
        if (!is_null($testCaseRunner)) {
            $this->setTestCaseRunner($testCaseRunner);
        }
        // initialize the test suite result
        $this->_testSuiteResult = new Streamwide_PHPUnit_Runner_TestSuiteResult($collectCodeCoverage);
    }
    
    /**
     * Runs all test cases.
     *
     * @return Streamwide_PHPUnit_Runner_TestSuiteResult test suite result
     */
    public function runAll()
    {
       while ($this->runNext()) {
           // run until there is no test left
       }
       
       return $this->_testSuiteResult;
    }
    
    /**
     * Runs the current test case, increments the test suite index.
     *
     * @return Streamwide_PHPUnit_Runner_TestCaseResult|boolean test case result or false if there is no test to run
     */
    public function runNext()
    {
       if ($this->_testSuite->valid()) {
           // run the test case with the test case runner
           $result = call_user_func(array($this->_testCaseRunner, 'run'), $this->_testSuite->current());
           // next test in suite
           $this->_testSuite->next();
           
           $this->_testSuiteResult->addTestResult($result);
    
           return $result;
       }
       
       return false;
    }
    
    /**
     * Set the test case runner.
     *
     * @param Streamwide_PHPUnit_Runner_TestCaseRunner $testCaseRunner
	 * @return Streamwide_PHPUnit_Runner_TestSuiteRunner *Provides a fluid interface*
     */
    public function setTestCaseRunner(Streamwide_PHPUnit_Runner_TestCaseRunner $testCaseRunner)
    {
        $this->_testCaseRunner = $testCaseRunner;
        
        return $this;
    }
    
    /**
     * Get the test case runner.
     *
     * @return string the test case runner
     */
    public function getTestCaseRunner()
    {
       return $this->_testCaseRunner;
    }
    
    /**
     * Gets the test suite.
     *
     * @return Streamwide_PHPUnit_Runner_TestSuite
     */
    public function getSuite()
    {
        return $this->_testSuite;
    }
    
    /**
     * Whether it is set to collect code coverage or not.
     *
     * @return boolean
     */
    public function getCollectCodeCoverage()
    {
        return $this->_collectCodeCoverage;
    }
}

/* EOF */