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
 * @version    $Id: TestCaseResult.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Runner/TestCase.php';

/**
 * A class that acts as a test case result container.
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 */
class Streamwide_PHPUnit_Runner_TestCaseResult
{
	/**
	 * Constants that define the possible test statuses.
	 */
    const PASSED          = 'passed';
    const FAILED          = 'failed';
    const ERROR           = 'error';
    const SKIPPED         = 'skipped';
    const NOT_IMPLEMENTED = 'notImplemented';
   
    /**
     * The test result of the runned test case.
     *
     * @var string
     */
    protected $_status;
    
    /**
     * The additional messages thrown by the runned test.
     *
     * @var string
     */
    protected $_buffer = null;

    /**
     * Test case result message,
     * set if the test failed or there was an error and
     * the test case could not be run.
     *
     * @var string
     */
    protected $_statusMessage = null;
    
    /**
     * Http headers for remote tests.
     *
     * @var array
     */
    protected $_httpHeaders = null;
    
    /**
     * Code coverage provided by xdebug.
     *
     * @var array
     */
    protected $_codeCoverage = null;
    
    /**
     * @var    float
     */
    protected $_time = 0;
    
    /**
     * Constructor.
     *
     * @param Streamwide_PHPUnit_Runner_TestCase $testCase      test case object
     * @param string                    $status        test case status
     * @param string                    $statusMessage (optional) status message (if test failed or error occured)
     * @param string                    $buffer        (optional) message buffer
     * @param float                     $time          (optional) time took to run the test case
     * @param array                     $codeCoverage  (optional) code coverage provided by xdebug
     * @param array                     $httpHeaders   (optional) http headers of the runned test (if runned remote)
     */
    public function __construct(Streamwide_PHPUnit_Runner_TestCase $testCase,
                                $status,
                                $statusMessage = null,
                                $buffer = null,
                                $time = 0,
                                Array $codeCoverage = null,
                                Array $httpHeaders = null
                               )
    {
        $this->setTestCase($testCase);
        $this->setStatus($status);
        $this->setTime($time);
        
        if (!is_null($statusMessage)) {
            $this->setStatusMessage($statusMessage);
        }
        if (!is_null($buffer)) {
            $this->setBuffer($buffer);
        }
        if (!is_null($codeCoverage)) {
            $this->setCodeCoverage($codeCoverage);
        }
        if (!is_null($httpHeaders)) {
            $this->setHttpHeaders($httpHeaders);
        }
    }
    
    /**
     * Set the test case.
     *
     * @param Streamwide_PHPUnit_Runner_TestCase $testCase test case
     * @return void
     */
    public function setTestCase(Streamwide_PHPUnit_Runner_TestCase $testCase)
    {
        $this->_testCase = $testCase;
    }
    
    /**
     * Get the test case.
     *
     * @return Streamwide_PHPUnit_Streamwide_TestCase
     */
    public function getTestCase()
    {
        return $this->_testCase;
    }
    
    /**
     * Set the test status.
     *
     * @param string $status test result
     * @return void
     */
    public function setStatus($status)
    {
        if (!in_array($status, self::getAllStatusConstants())) {
            throw new Streamwide_PHPUnit_Runner_Exception('Unrecognized test result.');
        }
        
        $this->_status = $status;
    }

    /**
     * Get the test result.
     *
     * @return PHPUnit_Framework_TestResult
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Retrieves the error message.
     *
     * @return string|boolean the error message or false if there is no error message
     */
    public function getStatusMessage()
    {
        return $this->_statusMessage;
    }
    
    /**
     * Sets the status message.
     *
     * @param string $message the status message to be set
     * @return void
     */
    public function setStatusMessage($message)
    {
        $this->_statusMessage = $message;
    }
    
    /**
     * Sets the buffer messages.
     *
     * @param string $buffer buffer messages
     * @return void
     */
    public function setBuffer($buffer)
    {
        $this->_buffer = $buffer;
    }
    
    /**
     * Gets the buffer messages.
     *
     * @return string buffer
     */
    public function getBuffer()
    {
        return $this->_buffer;
    }
    
    /**
     * Sets the http headers.
     *
     * @param array $headers http headers
     * @return void
     */
    public function setHttpHeaders(Array $headers = null)
    {
        $this->_httpHeaders = $headers;
    }
    
    /**
     * Gets the http headers.
     *
     * @return array headers
     */
    public function getHttpHeaders()
    {
        return $this->_httpHeaders;
    }
    
    /**
     * Sets the code coverage.
     *
     * @param array $codeCoverage code coverage provided by xdebug
     * @return void
     */
    public function setCodeCoverage(Array $codeCoverage)
    {
        $this->_codeCoverage = $codeCoverage;
    }
    
    /**
     * Gets the code coverage.
     *
     * @return array code coverage provided by xdebug
     */
    public function getCodeCoverage()
    {
        return $this->_codeCoverage;
    }
    
    /**
     * Sets the time took to run the test case.
     *
     * @param float $time time took to run the test case
     * @return void
     */
    public function setTime($time)
    {
        $this->_time = $time;
    }
    
    /**
     * Gets the time took to run the test case.
     *
     * @return float time took to run the test case
     */
    public function getTime()
    {
        return $this->_time;
    }
   
    /**
     * Gets all possible results as an array.
     *
     * @return array all result constants
     */
    public static function getAllStatusConstants()
    {
        return array(self::PASSED,
                     self::FAILED,
                     self::ERROR,
                     self::SKIPPED,
                     self::NOT_IMPLEMENTED);
    }
}

/* EOF */