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
 * @version    $Id: Util.php 2103 2009-11-15 20:51:51Z rgasler $
 */

/**
 * Util class, stores some utility functions.
 *
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 */
final class Streamwide_PHPUnit_Runner_Util
{
    /**
     * Transforms a realative path to an canonicalized absolute path.
     * Relative paths are resolved relative to this file directory.
     *
     * @param string  $path   the path to be transformed
     * @param string  $pwd    base folder for the relative paths
     * @param boolean $create attempt to create folder if it doesn't exist
     * @return string the absolute path
     * @throws Exception when it cannot create the folder
     */
    public static function getAbsolutePath($path, $pwd, $create = false)
    {
        if (empty($path) || DIRECTORY_SEPARATOR !== $path[0]) {
            $path = $pwd . DIRECTORY_SEPARATOR . $path;
        }
        if ($create && !is_dir($path) && !mkdir($path)) {
            throw new Exception('Cannot create folder ' . $path);
        }
        return realpath($path);
    }
    
    /**
     * Function that returns the length of the longest value of an array of strings.
     *
     * @param array of strings
     * @return int length of the longest value
     */
    public static function maxLength($array) {
        array_walk($array, create_function('&$a', '$a = strlen($a);'));
        return max($array);
    }
    
    /**
     * Creates an array with all test cases in a test file.
     *
     * @param string $file           test file path
     * @param string $testCasePrefix test case prefix
     * @return array test cases found in file
     */
    public static function getTests($file, $testCasePrefix = 'test')
    {
        return self::getTestsWithScript($file);
    }
    
    /**
     * Creates an array with all test cases in a test file.
     * It uses an external perl script that parses the file based on regexes.
     * The script is fast and also skips methods in comment blocks.
     *
     * @param string test file path
     * @return array test cases found in file of false if no test found
     */
    public static function getTestsWithScript($file, $testCasePrefix = 'test')
    {
        $command = dirname(__FILE__) . '/util/getTests.pl ' . $file . ' ' . $testCasePrefix;
        $tests = shell_exec($command);
        if (strlen($tests) > 0) {
            return explode("\n", trim($tests));
        } else {
            return false;
        }
    }
    
    /**
     * Creates an array with all test cases in a test file.
     * It uses reflection class and getMethods.
     * Problems: this method is slow. Also it returns an emtpy array if there are parsing errors.
     *
     * @param string test file path
     * @return array test cases found in file
     */
    public static function getTestsWithReflection($file, $testCasePrefix = 'test')
    {
        global $config;
        $className = getClassName($file);
        // We will get the tests name with the reflection class.
        // But we should not require the reflected class because of memory limitations.
        // Instead will run a script that generates all test method names based on TEST_CASE_PREFIX.
        $script = 'require_once("' .  $file . '"); $reflectionClass = new ReflectionClass("' . $className . '"); $methods = $reflectionClass->getMethods(); foreach($methods as $method) { echo $method->getName() . "\n"; }';
        $command = '/usr/bin/php -r \'' . $script . '\' | grep \'' . $testCasePrefix . '\'';
        $tests = shell_exec($command);
        return split("\n", trim($tests));
    }
    
    /**
     * Gets the class name from a test file
     *
     * @param string test file path
     * @return string test class name
     */
    public static function getClassName($file)
    {
        preg_match('/class (\w*)/', shell_exec("egrep '^class' $file"), $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
    
    /**
     * Check if a request is AjaxRequest
     *
     * @return boolean
     */
    public static function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER ['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
    }
    
    /**
     * This function will parse command line parameters in the form
     * of name=value and place them in the $_REQUEST super global array.
     *
     * @return boolean true if running in cli and values were set, false otherwise
     */
    public static function parse_cli_parameters()
    {
        ini_set("register_argc_argv", "true");
        global $_REQUEST; global $argc; global $argv;
        if (php_sapi_name() == 'cli' && $argc > 0)
        {
            for ($i=1;$i < $argc;$i++)
            {
                parse_str($argv[$i],$tmp);
                $_REQUEST = array_merge($_REQUEST, $tmp);
            }
            return true;
        }
    
        return false;
    }
}

/* EOF */