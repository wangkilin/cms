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
 * @version    $Id: RunTestCase.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'Streamwide/PHPUnit/Runner/TestCase.php';
require_once 'Streamwide/PHPUnit/Runner/TestCaseResult.php';
require_once 'Streamwide/PHPUnit/Runner/TestCaseResult/Factory.php';

/**
 * Runs a phpunit test case based on file name, class name and test case
 * and echoes a serialized Streamwide_PHPUnit_Runner_TestCaseResult
 *
 * This class receives the following request variables:
 *
 * $_REQUEST['file'],         string
 * $_REQUEST['class'],        string
 * $_REQUEST['test'],         string
 * $_REQUEST['codeCoverage'], boolean (optional)
 * $_REQUEST['includePath']   string  (optional)
 *
 * To use it call the run method in a script.
 * This script should be called remotely over http.
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 */
class Streamwide_PHPUnit_Runner_TestCaseRunner_RemoteOverHttp_RunTestCase
{
    /**
     * Test Case object.
     *
     * @var Streamwide_PHPUnit_Runner_TestCase
     */
    private $_testCase;
    
    /**
     * Switch to see if test runned
     * without unrecoverable errors.
     *
     * @var boolean
     */
    private $_successful;
    
    /**
     * Setup and run.
     *
     * @return void
     */
    public function run()
    {
        if (isset($_REQUEST['file'])
            && isset($_REQUEST['class'])
            && isset($_REQUEST['test']))
        {
            $codeCoverage = false;
            if (isset($_REQUEST['codeCoverage'])) {
                $codeCoverage = (boolean) $_REQUEST['codeCoverage'];
            }
    
            if (isset($_REQUEST['includePath'])) {
                set_include_path(get_include_path() . PATH_SEPARATOR . $_REQUEST['includePath']);
            }
            
            $this->_testCase = new Streamwide_PHPUnit_Runner_TestCase(
                $_REQUEST['file'],
                $_REQUEST['class'],
                $_REQUEST['test']
            );
        
            $this->_runTestCaseSafe($this->_testCase, $codeCoverage);
        }
    }
    
    /**
     * Enters the script in safe error mode.
     *
     * In case of errors or unexpected end of the script
     * we must not break the normal flow.
     * We treat this through an output buffering callback to
     * normally exit the script by completing and sending the suite report.
     *
     * @return void
     */
    private function _initSafeMode()
    {
        $this->_successful = false;
        
        // start output buffering with callback
        ob_start(array($this, 'ob_callback'));
    }

    /**
     * This function will be called when ob_get_flush() is called, or when
     * the output buffer is flushed to the cli at the end of the request.
     * If a fatal error happened in a test, it will suppress normal output
     * but instead will save it into the test results.
     *
     * @param string $buffer buffered output
     * @return string new serialized TestCaseResult if an error ocured
     *                or the normal buffer if successful
     */
    public function ob_callback($buffer)
    {
        if(!$this->_successful) {
            
            // the script terminated abnormally
            
            // create the test case result
            $errorMessage = '<div class="fatalError">' . $buffer . '</div>';
            
            $testCaseResult = new Streamwide_PHPUnit_Runner_TestCaseResult(
                $this->_testCase,
                Streamwide_PHPUnit_Runner_TestCaseResult::ERROR,
                $errorMessage);
    
            return serialize($testCaseResult);
        }
        
        return $buffer;
    }

    /**
     * Run a test suite and return the results.
     *
     * @param Streamwide_PHPUnit_Runner_TestCase $testCase     test case
     * @param boolean                            $codeCoverage (optional) whether to collect code coverage
     * @return PHPUnit_Framework_TestResult phunit test result
     */
    private function _runTestCase($testCase, $codeCoverage = false)
    {
        require_once $testCase->getFile();
    
        $result = new PHPUnit_Framework_TestResult;
        
        $result->collectCodeCoverageInformation($codeCoverage);
    
        $class = $testCase->getClass();
        $testCase = new $class($testCase->getTest());
    
        $testCase->setInIsolation(true);
    
        // run the test case
        $testCase->run($result);
    
        return $result;
    }

    /**
     * Run the program in safe mode.
     * This function prints the suite report.
     *
     * @param Streamwide_PHPUnit_Runner_TestCase $testCase     test case
     * @param boolean                            $codeCoverage whether to collect code coverage or not
     * @return boolean true if test runned, false otherwise
     */
    private function _runTestCaseSafe(Streamwide_PHPUnit_Runner_TestCase $testCase, $codeCoverage)
    {
        // enters the script in safe mode
        $this->_initSafeMode();
    
        global $successful;
    
        // run the test
        $result = $this->_runTestCase($testCase, $codeCoverage);
    
        // if we reach this point then the test run was successful
        $this->_successful = true;
    
        // end output buffering
        $buffer = ob_get_contents();
        ob_end_clean();
        
        // create the test case result from PHPUnit_Framework_TestResult
        $testCaseResult = Streamwide_PHPUnit_Runner_TestCaseResult_Factory::fromPHPUnitTestResult($testCase, $result);
    
        // set the buffer
        if (!empty($buffer)) {
            $testCaseResult->setBuffer($buffer);
        }
        
        echo serialize($testCaseResult);
    }
}

/* EOF */