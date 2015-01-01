<?php
/**
 * A TestCase defines the fixture to run multiple tests.
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: TestCase.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Streamwide/PHPUnit/Framework/MockObject/Generator.php';
require_once 'Streamwide/PHPUnit/Framework/MockObject/Matcher/InvokedAtMethodCall.php';

/**
 * A TestCase defines the fixture to run multiple tests.
 *
 * To define a TestCase
 *
 *   1) Implement a subclass of PHPUnit_Framework_TestCase.
 *   2) Define instance variables that store the state of the fixture.
 *   3) Initialize the fixture state by overriding setUp().
 *   4) Clean-up after a test by overriding tearDown().
 */
abstract class Streamwide_PHPUnit_Framework_TestCase extends PHPUnit_Framework_TestCase
{

    /**
     * Sets the expected exception.
     *
     * @param  mixed                                $exceptionName     the object type of the returned exception
     * @param  string|PHPUnit_Framework_Constraint  $exceptionMessage  exception message or constraint
     * @param  integer                              $exceptionCode     exception code
     */
    public function setExpectedException($exceptionName, $exceptionMessage = '', $exceptionCode = 0)
    {
        $this->expectedException        = $exceptionName;
        $this->expectedExceptionMessage = $exceptionMessage;
        $this->expectedExceptionCode    = $exceptionCode;
    }

    /**
     * Override to run the test and assert its state.
     *
     * @return mixed
     * @throws RuntimeException
     */
    protected function runTest()
    {
        if ($this->name === NULL) {
            throw new RuntimeException(
              'PHPUnit_Framework_TestCase::$name must not be NULL.'
            );
        }

        try {
            $class  = new ReflectionClass($this);
            $method = $class->getMethod($this->name);
        }

        catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }

        try {
            if (empty($this->data)) {
                $testResult = $method->invokeArgs($this, $this->dependencyInput);
            } else {
                $testResult = $method->invokeArgs($this, $this->data);
            }
        }

        catch (Exception $e) {
            if (!$e instanceof PHPUnit_Framework_IncompleteTest &&
                !$e instanceof PHPUnit_Framework_SkippedTest &&
                is_string($this->expectedException) &&
                $e instanceof $this->expectedException) {
                if (is_string($this->expectedExceptionMessage) &&
                    !empty($this->expectedExceptionMessage)) {
                    $this->assertContains(
                      $this->expectedExceptionMessage,
                      $e->getMessage()
                    );
                } else if ($this->expectedExceptionMessage instanceof PHPUnit_Framework_Constraint) {
                    self::assertThat($e->getMessage(), $this->expectedExceptionMessage);
                }

                if (is_int($this->expectedExceptionCode) &&
                    $this->expectedExceptionCode !== 0) {
                    $this->assertEquals(
                      $this->expectedExceptionCode, $e->getCode()
                    );
                }

                $this->numAssertions++;

                return;
            } else {
                throw $e;
            }
        }

        if ($this->expectedException !== NULL) {
            $this->numAssertions++;
            $this->fail('Expected exception ' . $this->expectedException);
        }

        return $testResult;
    }


    /**
     * Returns a mock object for the specified class.
     * Overrides PHPUnit_Framework_TestCase::getMock() to return a customized mock, which knows atMethodCall matcher.
     *
     * @param  string  $originalClassName
     * @param  array   $methods
     * @param  array   $arguments
     * @param  string  $mockClassName
     * @param  boolean $callOriginalConstructor
     * @param  boolean $callOriginalClone
     * @param  boolean $callAutoload
     * @return object
     * @throws InvalidArgumentException
     * @since  Method available since Release 3.0.0
     */
    protected function getMock($originalClassName, $methods = array(), array $arguments = array(), $mockClassName = '', $callOriginalConstructor = TRUE, $callOriginalClone = TRUE, $callAutoload = TRUE)
    {
        if (!is_string($originalClassName)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        if (!is_string($mockClassName)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(4, 'string');
        }

        if (!is_array($methods) && !is_null($methods)) {
            throw new InvalidArgumentException;
        }

        if ($mockClassName != '' && class_exists($mockClassName, FALSE)) {
            throw new RuntimeException(
              sprintf(
                'Class "%s" already exists.',
                $mockClassName
              )
            );
        }

        $mock = Streamwide_PHPUnit_Framework_MockObject_Generator::generate(
          $originalClassName,
          $methods,
          $mockClassName,
          $callOriginalClone,
          $callAutoload
        );

        if (!class_exists($mock['mockClassName'], FALSE)) {
            eval($mock['code']);
        }

        if ($callOriginalConstructor && !interface_exists($originalClassName, $callAutoload)) {
            if (count($arguments) == 0) {
                $mockObject = new $mock['mockClassName'];
            } else {
                $mockClass  = new ReflectionClass($mock['mockClassName']);
                $mockObject = $mockClass->newInstanceArgs($arguments);
            }
        } else {
            // Use a trick to create a new object of a class
            // without invoking its constructor.
            $mockObject = unserialize(
              sprintf('O:%d:"%s":0:{}', strlen($mock['mockClassName']), $mock['mockClassName'])
            );
        }

        $this->mockObjects[] = $mockObject;

        return $mockObject;
    }

    /**
     * Returns a matcher that matcher when the specified method is called for the $index time
     * The method constraint must the of type equalTo ( which is the default type )
     *
     * @param int $index
     * @return Streamwide_PHPUnit_Framework_MockObject_Matcher_InvokedAtMethodCall
     */
    protected function atMethodCall( $index )
    {
        return new Streamwide_PHPUnit_Framework_MockObject_Matcher_InvokedAtMethodCall($index);
    }

}


/*EOF*/
