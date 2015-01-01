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
 * @version    $Id: TestCase.php 2103 2009-11-15 20:51:51Z rgasler $
 */

/**
 * Test Case representation.
 *
 * There are three components that identify uniquely a phpunit test case:
 * 1) file path
 * 2) class name
 * 3) test name
 *
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 */
class Streamwide_PHPUnit_Runner_TestCase
{
    /**
     * The file that contains the test case.
     *
     * @var string
     */
    protected $_file;
    
    /**
     * The class name that contains the test case.
     *
     * @var string
     */
    protected $_class;
    
    /**
     * The test case function.
     *
     * @var string
     */
    protected $_test;
    
    /**
     * Test Case constructor.
     *
     * @param string $file  file name of the test case
     * @param string $class class name of the test case
     * @param string $test  test case function name
     */
    public function __construct($file, $class, $test)
    {
        $this->_file  = $file;
        $this->_class = $class;
        $this->_test  = $test;
    }
    
    /**
     * Get the test file.
     *
     * @return string test file
     */
    public function getFile()
    {
        return $this->_file;
    }
    
    /**
     * Get test the class name.
     *
     * @return string class name
     */
    public function getClass()
    {
        return $this->_class;
    }
    
    /**
     * Get the test function name
     *
     * @return string function name
     */
    public function getTest()
    {
        return $this->_test;
    }
    
    /**
     * Returns an unique identifier of the test case.
     * Can be used to easily compare test cases.
     *
     * @return string unque identifier
     */
    public function toString()
    {
        return $this->_file . ':' . $this->_class . ':' . $this->_test;
    }
}

/* EOF */