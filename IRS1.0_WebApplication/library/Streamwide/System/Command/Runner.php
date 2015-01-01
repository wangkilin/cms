<?php
/**
 * StreamWIDE Framework
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_System
 * @subpackage Command
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Runner.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * An external command runner
 * with control of standard streams
 * (stdin, stdout, stderr)
 *
 * @category   Streamwide
 * @package    Streamwide_System
 * @subpackage Command
 */
class Streamwide_System_Command_Runner
{
    /**
     * Descriptor specification for proc_open().
     *
     * @var    array
     */
    protected static $_descriptorSpec = array(
      0 => array('pipe', 'r'),
      1 => array('pipe', 'w'),
      2 => array('pipe', 'w')
    );
    
    /**
     * Execute a command and open file pointers for input/output.
     *
     * @param  string  $command        command
     * @param  string  $stdin          (optional) string to pass to the standard input
     * @param  integer &$returnValue   (optional) return value reference, if you want to catch the return value
     * @param  string  &$stdout        (optional)
     * @param  string  &$stderr        (optional)
     * @return array|boolean associative array with 'stdout' and 'stderr' keys
     */
    public static function runCommand($command, $stdin = null, &$returnValue = null, &$stdout = null, &$stderr = null)
    {
        $process = proc_open(
          $command, self::$_descriptorSpec, $pipes
        );

        if (is_resource($process)) {

            if (!is_null($stdin)) {
                fwrite($pipes[0], $stdin);
            }
            fclose($pipes[0]);
            
            $stdout = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $stderr = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            $return = proc_close($process);
            
            if (!isset($returnValue)) {
                $returnValue = $return;
            }

            return array('stdout' => $stdout, 'stderr' => $stderr);
        }
        
        return false;
    }
    
    /**
     * Execute a shell command asyncronous.
     *
     * @param  string  $command  command
     * @param  array   $pipes    indexed array of file pointers to stdin, stdout and stderr (in this order)
     *                           when you finish, you should close the file pointers manually
     * @return resource|boolean  resource representing the process, which should be freed using proc_close()
     */
    public static function runCommandAsync($command, &$pipes)
    {
        $process = proc_open(
            $command, self::$_descriptorSpec, $pipes
        );
        
        if (is_resource($process)) {
            return $process;
        }
        
        return false;
    }
}

/* EOF */