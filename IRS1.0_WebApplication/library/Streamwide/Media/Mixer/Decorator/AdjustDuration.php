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
 * @subpackage Streamwide_Media_Mixer
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: AdjustDuration.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * This class adds extra functionality to the mixer:
 * it adjusts the duration of mix files (by repeating or cutting)
 * until they have the duration of the first file.
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Mixer
 */
class Streamwide_Media_Mixer_Decorator_AdjustDuration implements Streamwide_Media_Mixer_Interface
{
    /**
     * Mixer to decorate.
     *
     * @var Streamwide_Media_Mixer_Interface
     */
    protected $_mixer;
    
    /**
     * We need a joiner to repeat the mix file.
     *
     * @var Streamwide_Media_Joiner_Interface
     */
    protected $_joiner;
    
    /**
     * We need a format decoder to get the files durations.
     *
     * @var Streamwide_Media_Decoder_Interface
     */
    protected $_decoder;
    
    /**
     * We need a converter to cut the files to desired duration
     *
     * @var Streamwide_Media_Converter_Interface
     */
    protected $_converter;

    /**
     * Constructor.
     *
     * @param Streamwide_Media_Mixer_Interface $mixer
     * @param Streamwide_Media_Joiner_Interface $joiner
     */
    public function __construct(
        Streamwide_Media_Mixer_Interface $mixer,
        Streamwide_Media_Joiner_Interface $joiner,
        Streamwide_Media_Decoder_Interface $decoder,
        Streamwide_Media_Converter_Interface $converter)
    {
        $this->_mixer = $mixer;
        $this->_joiner = $joiner;
        $this->_decoder = $decoder;
        $this->_converter = $converter;
    }

    /**
     * Mixes the input files
     * and adjusts the duration of mix files (by repeating or cutting)
     * until they have the duration of the first file.
     *
     * @param array  $inputFiles Input files
     * @param string $outputFile The output file
     * @return string|boolean    resulted file path or false if the mix failed
     */
    public function mix(Array $inputFiles, $outputFile)
    {
        // the input files have to be repeated while the first one is played
        // we have to see for how many times each should be repeated
        
        $firstInputFile = array_shift($inputFiles);
        
        // we need the duration of first input file
        $inputFileDuration = $this->_decoder->_decodeFormat($firstInputFile)->getDuration();
 
        // add first input file unaltered
        $preparedInputFiles = array($firstInputFile);

        foreach ($inputFiles as $file) {
            // for each input file
            // we have to build a temporary mix file having the same duration as the source
            // we will join the mixFile with itself until the length of this temporary
            // file becomess greater than the source duration
            // then we will cut the temporary file for exactly matching with the source duration
   
            $fileDuration = $this->_decoder->_decodeFormat($file)->getDuration();
            
            // find out how many times the mix file should be repeated to cover the source length
            $repetitionsNumber = ceil($inputFileDuration/$fileDuration);
            
            $repeatedFile = $file;
            $repeatedFileCreated = false;
            
            if ($repetitionsNumber > 1) {
                $repeatedFile = tmp_file();
                $repeatedFileCreated = true;
                // concatenate the mixFile to the tempMixFile as many times as needed
                $joinFiles = array();
                for ($i = 1; $i < $repetitionsNumber; $i++) {
                    $joinFiles[] = $file;
                }
                $this->_joiner->join($joinFiles, $repeatedFile);
            }
            
            $adjustedFile = tmp_file();
            
            // cut the repeatedFile to the same length as the inputFile
            $format = new Streamwide_Media_Format();
            $format->setDuration($inputFileDuration);
            
            $this->_converter->convert($tempFile, $adjustedFile, $format);
            
            // add the prepared file
            $preparedInputFiles[] = $adjustedFile;
            
            // cleanup
            if ($repeatedFileCreated) {
                unlink($repeatedFile);
            }
        }
        
        // finally make the mix
        $this->_mixer->mix($preparedInputFiles, $outputFile);
        
        // check if the outputFile was created
        if (!file_exists($outputFile)) {
            return false;
        }

        return $outputFile;
    }
}

/* EOF */