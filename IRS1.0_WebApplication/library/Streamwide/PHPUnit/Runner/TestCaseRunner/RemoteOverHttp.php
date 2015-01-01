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
 * @version    $Id: RemoteOverHttp.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Runner/TestCaseRunner.php';

/**
 * Runs a test case remote over http.
 *
 * It calls a remote script to run the test over http with parameters:
 * file, class, test, codeCoverage, includePath
 *
 * This runner preserves xdebug html formatted messages like:
 * stack traces, variable display, errors.
 *
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 */
class Streamwide_PHPUnit_Runner_TestCaseRunner_RemoteOverHttp implements Streamwide_PHPUnit_Runner_TestCaseRunner
{
    /**
     * Remote http url to use for running
     * the test case in isolation.
     *
     * @var string
     */
    protected $_remoteScriptUrl;
    
    /**
     * Constructor.
     *
     * @param string $remoteScriptUrl remote script url to call
     */
    public function __construct($remoteScriptUrl)
    {
        $this->setRemoteScriptUrl($remoteScriptUrl);
    }
    
    /**
     * Gets the remote script url.
     *
     * @return string
     */
    public function getRemoteScriptUrl()
    {
        return $this->_remoteScriptUrl;
    }
    
    /**
     * Set the remote script url
     *
     * @param string $remoteScriptUrl remote script url to call
     * @return void
     */
    public function setRemoteScriptUrl($remoteScriptUrl)
    {
        $this->_remoteScriptUrl = $remoteScriptUrl;
    }
    
    /**
     * Runs a test case.
     *
     * @param Streamwide_PHPUnit_Runner_TestCase  $testCase     test case
     * @param boolean                    $codeCoverage (optional) whether to collect code coverage or not
     * @param array                      $options      (optional) additional options to pass to the runner
     * @return Streamwide_PHPUnit_Runner_TestCaseResult
     */
    public function run(Streamwide_PHPUnit_Runner_TestCase $testCase, $codeCoverage = false, Array $options = null)
    {
        // set arguments for the script
        $args = array(
            'file'  => $testCase->getFile(),
            'class' => $testCase->getClass(),
            'test'  => $testCase->getTest(),
            'codeCoverage' =>  $codeCoverage,
            'includePath'  => get_include_path(),
            'XDEBUG_SESSION_START' => uniqid()
        );
        
        // prepare arguments for url
        $parts = array();
        foreach($args as $key => $value) {
            $parts[] = $key . '=' . urlencode($value);
        }
        $argsLine = join('&', $parts);
        
        // prepare the command
        $uri = sprintf('%s?%s', $this->_remoteScriptUrl, $argsLine);

        // set user agent and create stream context
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $opts = array(
          'http'=> array(
            'method' => "GET",
            'header' => "User-Agent: $userAgent\r\n"
            )
        );
        $context = stream_context_create($opts);
    
        // enter into a safe error reporting level
        $oldErrorReportingLevel = error_reporting(E_ERROR);
    
        // execute the http request
        $response = file_get_contents($uri, false, $context);
    
        // check if an error has occured in the request
        $result = null;
        if($response) {
            // the result should be a serialized representation of the suite report
            $result = unserialize($response);
        }
        
        // restore previous error reporting level
        error_reporting($oldErrorReportingLevel);

        // check if an error occured
        if (!$response || !($result instanceof Streamwide_PHPUnit_Runner_TestCaseResult)) {
            $error = error_get_last();
            $message = sprintf('%s<br />in %s at line %s', $error['message'], $error['file'], $error['line']);
            // if unserialize has failed (fatal error) add the response to the details
            $message .= $response;
            $message = sprintf('<div class="fatalError">%s</div>', $message);
            
            $result = new Streamwide_PHPUnit_Runner_TestCaseResult($testCase, Streamwide_PHPUnit_Runner_TestCaseResult::ERROR, $message);
        }

        global $http_response_header;
        // propagate headers
        $result->setHttpHeaders($http_response_header);

        return $result;
    }
}

/* EOF */