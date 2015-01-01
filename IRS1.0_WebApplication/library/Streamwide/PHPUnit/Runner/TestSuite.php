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
 * @version    $Id: TestSuite.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Runner/TestCase.php';

/**
 * A class that acts as a test case iterator and aggregates test results.
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 */
class Streamwide_PHPUnit_Runner_TestSuite implements Iterator, Countable
{
    /**
     * @var integer
     */
    protected $_position = 0;

    /**
     * @var Streamwide_PHPUnit_Runner_TestCase[]
     */
    protected $_tests;
    
    /**
     * Aggregate results for test cases.
     *
     * @var SwPHPPUnit_Runner_TestSuiteResult
     */
   protected $_testSuiteResult;
   
   /**
    * Constructor.
    *
    */
   public function __construct()
   {
   
   }
   
   public function addTest(Streamwide_PHPUnit_Runner_TestCase $testCase)
   {
       $this->_tests[] = $testCase;
   }
   
    /**
     * Rewinds the Iterator to the first element.
     *
     * @return void
     */
    public function rewind()
    {
        $this->_position = 0;
    }

    /**
     * Checks if there is a current element after calls to rewind() or next().
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->_position < count($this->_tests);
    }

    /**
     * Returns the key of the current element.
     *
     * @return integer
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * Returns the current element.
     *
     * @return PHPUnit_Framework_Test
     */
    public function current()
    {
        return $this->valid() ? $this->_tests[$this->_position] : null;
    }

    /**
     * Moves forward to next element.
     *
     * @return void
     */
    public function next()
    {
        $this->_position++;
    }
    
    /**
     * Gets the number of elements.
     *
     * @return integer
     */
    public function count()
    {
        return count($this->_tests);
    }
}

/* EOF */