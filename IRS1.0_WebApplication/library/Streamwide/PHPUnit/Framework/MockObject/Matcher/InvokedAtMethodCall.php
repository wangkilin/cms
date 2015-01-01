<?php
/**
 * Invoked at method call matcher class.
 * Defines a matcher that matches when a method is called the $index time, with the provided params.
 * $index is 0 for the first call of the method, 1 for the second, etc.
 *
 * <code>
 * $mock = $this->getMock('AnInterface');
 * $mock->expects($this->atMethodCall( 1 ))
 *     ->method('doSomething')
 *     ->with( 3, 'test' );
 *
 * $mock->doSomething( 5, 'test' );
 * $mock->doSomething( 3, 'test' );
 * </code>
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Irina MIRICI <imirici@streamwide.ro>
 * @version    $Id: InvokedAtMethodCall.php 2103 2009-11-15 20:51:51Z rgasler $
 */

/**
 * This class defines an InvokedAtMethodCall matcher.
 *
 * @author imirici
 */
class Streamwide_PHPUnit_Framework_MockObject_Matcher_InvokedAtMethodCall implements PHPUnit_Framework_MockObject_Matcher_Invocation
{
    protected $sequenceIndex;

    protected $currentIndex = -1;

    /**
     * The name of the method we expect to be called
     *
     * @var string $methodName
     */
    public $methodName = null;

    public function __construct($sequenceIndex)
    {
        $this->sequenceIndex = $sequenceIndex;
    }

    /**
     * Getter for currentIndex, used just for testing purposes
     *
     * @return int
     */
    public function getCurrentIndex()
    {
        return $this->currentIndex;
    }

    /**
     * Getter for sequenceIndex, used just for testing purposes
     *
     * @return int
     */
    public function getSequenceIndex()
    {
        return $this->sequenceIndex;
    }

    public function toString()
    {
        return 'invoked at sequence index ' . $this->sequenceIndex;
    }

    /**
     * Method that returns true when the method is called for the specified index time.
     *
     * @param PHPUnit_Framework_MockObject_Invocation $invocation
     * @return boolean
     */
    public function matches(PHPUnit_Framework_MockObject_Invocation $invocation)
    {
        /*
         * Increment the currentIndex only when the called method is the same as the method we expect
         * This is the difference between this matcher and the atIndex matcher,
         * which counts all calls of all methods from a mocked class.
         */
        if ( $this->methodName !== $invocation->methodName ) {
            return false;
        }
        $this->currentIndex++;

        return $this->currentIndex == $this->sequenceIndex;
    }

    public function invoked(PHPUnit_Framework_MockObject_Invocation $invocation)
    {
    }

    /**
     * FMethod the throws an error if the specified call for the method was not reached.
     * CurrentIndex counts how many times the mathod was called, and sequenceIndex is the specified call we expect.
     *
     * @throws PHPUnit_Framework_ExpectationFailedException
     */
    public function verify()
    {
        if ($this->currentIndex < $this->sequenceIndex) {
            throw new PHPUnit_Framework_ExpectationFailedException(
              sprintf(
                'The expected call with index %s was never reached.',

                $this->sequenceIndex
              )
            );
        }
    }
}

/* EOF */
