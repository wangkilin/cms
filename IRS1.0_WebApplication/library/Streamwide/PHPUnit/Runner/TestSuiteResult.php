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
 * @version    $Id: TestSuiteResult.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Runner/TestCaseResult.php';

/**
 * A class that acts as a test case result container.
 *
 * Test results are indexed by class and status.
 *
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 */
class Streamwide_PHPUnit_Runner_TestSuiteResult
{
    /**
     * Array of test results.
     *
     * @var Streamwide_PHPUnit_Runner_TestCaseResult[]
     */
    protected $_results;
    
    /**
     * Whether to collect code coverage or not.
     *
     * @var boolean
     */
    protected $_collectCodeCoverage = false;
    
    /**
     * Code coverage provided by xdebug.
     *
     * @var array
     */
    protected $_codeCoverage;
    
    /**
     *
     * @var Streamwide_PHPUnit_Runner_TestCaseResult[]
     */
    protected $_statusIndex;
    
    /**
     *
     * @var Streamwide_PHPUnit_Runner_TestCaseResult[]
     */
    protected $_classIndex;

    /**
     * Constructor.
     *
     * @param $collectCodeCoverage whether to collect code coverage
     */
    public function __construct($collectCodeCoverage = false)
    {
        $this->_collectCodeCoverage = $collectCodeCoverage;
    }
    
    /**
     * Add a test case result.
     *
     * @param Streamwide_PHPUnit_Runner_TestCaseResult $testCaseResult test case result
     * @return void
     */
    public function addTestResult(Streamwide_PHPUnit_Runner_TestCaseResult $testCaseResult)
    {
        $this->_results[] = $testCaseResult;
        
        $status = $testCaseResult->getStatus();
        $class = $testCaseResult->getTestCase()->getClass();
        $index = count($this->_results) - 1;
        
        $this->_statusIndex[$status][$class][] = $testCaseResult;
        $this->_classIndex[$class][$status][] = $testCaseResult;
    }

    /**
     * Get all test case results that match selected criteria.
     *
     * If both class and status are null all results are returned.
     * If class name or status is given test results are
     * returned as an associative array indexed by status or class name.
     *
     * @param string $class  class name
     * @param string $status test case result status
     * @return array array of test case results
     * @throws Streamwide_PHPUnit_Runner_Exception when unknown status is given
     */
    public function results($class = null, $status = null)
    {
        if (!is_null($status) && !in_array($status, Streamwide_PHPUnit_Runner_TestCaseResult::getAllStatusConstants())) {
            require_once 'Streamwide/PHPUnit/Runner/Exception.php';
            throw new Streamwide_PHPUnit_Runner_Exception('Unknown status ' . $status);
        }
        
        if (is_null($class) && is_null($status)) {
            return $this->_results;
        } else if (!is_null($class) && !is_null($status)) {
            return $this->_classIndex[$class][$status];
        } else if (!is_null($class)) {
            return $this->_classIndex[$class];
        } else if (!is_null($status)) {
            return $this->_statusIndex[$status];
        }
    }
    
    /**
     * Counts all test case results that match selected criteria.
     *
     * @param string $class  class name
     * @param string $status test case result status
     * @return integer count of test case results
     * @throws Streamwide_PHPUnit_Runner_Exception when unknown status is given
     */
    public function count($class = null, $status = null)
    {
        return count($this->results($class, $status));
    }

    /**
     * Returns the time for all test case runs that match selected criteria.
     *
     * @param string $class  class name
     * @param string $status test case result status
     * @return integer time of test case run
     * @throws Streamwide_PHPUnit_Runner_Exception when unknown status is given
     */
    public function time($class = null, $status = null)
    {
        $time = 0;
        foreach ($this->results($class, $status) as $result) {
            $time += $result->getTime();
        }
        return $time;
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