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
 * @subpackage Streamwide_Media_Converter
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Factory.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Audio/Video converter factory default implementation.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Converter_Factory implements Streamwide_Media_Converter_Factory_Interface
{
    /**
     * Creates a new converter based on input
     * formats and output format.
     *
     * @param string|array $inputFiles one or more input files
     * @param Streamwide_Media_Format $outputFormat
     * @return Streamwide_Media_Converter
     */
    public function newConverter($inputFiles, Streamwide_Media_Format $outputFormat)
    {
        // We'll make a simple choice:
        // for stw use Streamwide_Media_Converter_StwFileHandler
        // for enything else use Streamwide_Media_Converter_FFmpeg
        if ($outputFormat instanceof Streamwide_Media_Format_Stw) {
                return new Streamwide_Media_Converter_StwFileHandler();
        }
        
        // if we only have one input format make it an array
        if (!is_array($inputFiles)) {
            $inputFiles = array($inputFiles);
        }
        
        foreach ($inputFiles as $inputFile) {
            if ('stw' == pathinfo($inputFile, PATHINFO_EXTENSION)) {
                return new Streamwide_Media_Converter_StwFileHandler();
            }
        }
        
        // if no stw, use the default
        return new Streamwide_Media_Converter_FFmpeg();
    }
}
/* EOF */