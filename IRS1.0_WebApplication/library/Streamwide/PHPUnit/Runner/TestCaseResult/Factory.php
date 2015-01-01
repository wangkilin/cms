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
 * @version    $Id: Factory.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'PHPUnit/Framework/TestResult.php';
require_once 'Streamwide/PHPUnit/Runner/TestCase.php';
require_once 'Streamwide/PHPUnit/Runner/TestCaseResult.php';

/**
 * Factory for Streamwide_PHPUnit_Runner_TestCaseResult.
 *
 * Separates the creation of a Streamwide_PHPUnit_Framework_TestCaseResult
 * from a PHPUnit_Framework_TestResult object.
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 */
class Streamwide_PHPUnit_Runner_TestCaseResult_Factory
{
    /**
     * Creates a Streamwide_PHPUnit_Runner_TestCaseResult from a PHPUnit_Framework_TestResult.
     *
     * @param Streamwide_PHPUnit_Runner_TestCase    $testCase   test case
     * @param PHPUnit_Framework_TestResult $testResult test result
     * @return Streamwide_PHPUnit_Runner_TestCaseResult test case result
     */
    public static function fromPHPUnitTestResult(Streamwide_PHPUnit_Runner_TestCase $testCase, PHPUnit_Framework_TestResult $testResult)
    {
        $passed         = $testResult->passed();
        $skipped        = $testResult->skipped();
        $errors         = $testResult->errors();
        $failures       = $testResult->failures();
        $notImplemented = $testResult->notImplemented();
        $time           = $testResult->time();
        
        $statusMessage = null;
        $codeCoverage = null;

        if (!empty($passed)) {
            $status = Streamwide_PHPUnit_Runner_TestCaseResult::PASSED;
            $codeCoverage = $testResult->getCodeCoverageInformation();
        } else if (!empty($skipped)) {
            $status = Streamwide_PHPUnit_Runner_TestCaseResult::SKIPPED;
            $statusMessage = $skipped[0]->toStringVerbose(true);
        }  else if (!empty($notImplemented)) {
            $status = Streamwide_PHPUnit_Runner_TestCaseResult::NOT_IMPLEMENTED;
            $statusMessage = $notImplemented[0]->toStringVerbose(true);
        } else if (!empty($errors)) {
            $status = Streamwide_PHPUnit_Runner_TestCaseResult::ERROR;
            $statusMessage = $errors[0]->toStringVerbose(true) .
            PHPUnit_Util_Filter::getFilteredStacktrace($errors[0]->thrownException());
        } else if (!empty($failures)) {
            $status = Streamwide_PHPUnit_Runner_TestCaseResult::FAILED;
            $statusMessage = $failures[0]->toStringVerbose(true) .
            PHPUnit_Util_Filter::getFilteredStacktrace($failures[0]->thrownException());
        }
    
        $testCaseResult = new Streamwide_PHPUnit_Runner_TestCaseResult($testCase, $status, $statusMessage, null, $time, $codeCoverage);
        return $testCaseResult;
    }
}

/* EOF */