<?php
/**
 * StreamWIDE Framework
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Joiner
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Cat.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Joins media files using cat.
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Joiner
 */
class Streamwide_Media_Joiner_Cat implements Streamwide_Media_Joiner_Interface
{
    /**
     * Default command to use.
     *
     * @var string
     */
    protected $_defaultCommand = 'Streamwide_Media_Command_Cat';
    
    /**
     * Command instance.
     *
     * @var Streamwide_Media_Command_Cat
     */
    protected $_command;
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->_command = new $this->_defaultCommand;
    }

    /**
     * This method joins multiple sources into a new file.
     *
     * @param array   $inputFiles Source files
     * @param string  $outputFile The destination file
     * @return string|boolean the resulted file path or false if the join failed
     */
    public function join(Array $inputFiles, $outputFile)
    {
        foreach ($inputFile as $file) {
            $this->_command->addInputFile($file);
        }
        
        $this->_command->setOutputFile($outputFile);
        
        return $this->_command->run();
    }
}

/* EOF */