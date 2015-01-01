<?php
/**
 * StreamWIDE Framework
 *
 * $Rev: 2608 $
 * $LastChangedDate: 2010-05-18 10:01:35 +0800 (Tue, 18 May 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   Streamwide
 * @package    Streamwide_Package
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Mixer.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Mixer facade.
 *
 * This class acts as a facade for the other low-level mixers.
 * It decides which mixer to instantiate based on a mixer factory
 * and delegates the mixing to the mixer.
 *
 * <code>
 * $result = $mixer->setRepeatMixFile(true)->mix($source, $mixFile, $destination);
 * </code>
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Mixer
 */
class Streamwide_Media_Mixer implements Streamwide_Media_Mixer_Interface
{
    /**
     * Mixer factory.
     *
     * @var Streamwide_Media_Mixer_Factory_Interface
     */
    protected $_mixerFactory;
    
    /**
     * Format mapper.
     *
     * @var Streamwide_Media_Format_Mapper_Interface
     */
    protected $_formatMapper;
    
    /**
     * Default mixer factory.
     *
     * @var string
     */
    protected $_defaultMixerFactory = 'Streamwide_Media_Mixer_Factory';
    
    /**
     * Default format mapper.
     *
     * @var string
     */
    protected $_defaultFormatMapper = 'Streamwide_Media_Format_Mapper';
    
    /**
     * Use this option to adjust (by repeating or cutting)
     * the mix files until they have the duration of the first file.
     *
     * @var boolean
     */
    protected $_adjustDuration = false;
    
    /**
     * Constructor.
     *
     * @param Streamwide_Media_Mixer_Factory_Interface $factory (optional) mixer factory
     * @param Streamwide_Media_Format_Mapper_Interface $mapper  (optional) format mapper
     */
    public function __construct(
        Streamwide_Media_Mixer_Factory_Interface $factory = null,
        Streamwide_Media_Format_Mapper_Interface $mapper = null
    )
    {
        if (is_null($factory)) {
            $factory = new $this->_defaultMixerFactory();
        }
        if (is_null($mapper)) {
            $mapper = new $this->_defaultFormatMapper();
        }
        
        $this->_mixerFactory = $factory;
        $this->_formatMapper = $mapper;
    }
    
    /**
     * This method mixes the given files.
     *
     * @param array   $inputFiles  Source files
     * @param string  $outputFile  The destination file
     * @return string|boolean      resulted file path or false if the mix failed
     */
    public function mix(Array $inputFiles, $outputFile)
    {
        $fileType = pathinfo($outputFile, PATHINFO_EXTENSION);
        
        // verify that input files and output file have the same type
        foreach($inputFiles as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) != $fileType) {
                throw new Streamwide_Media_Exception("$file and $outputFile must have the same file type for mixing." );
            }
        }
        
        // get the mixer from factory
        $mixer = $this->_mixerFactory->newMixer($inputFiles, $this->_adjustDuration);
        
        return $mixer->mix($inputFiles, $outputFile);
    }
    
    /**
     * Set the adjust duration mix option.
     *
     * @param boolean $adjustDuration Use this option to adjust (by repeating or cutting)
     *                                the mix files until they have the duration of the first file.
     * @return void
     * @throws Stremawide_Media_Exception when parameter is invalid
     */
    public function setAdjustDuration($adjustDuration)
    {
        if (is_boolean($adjustDuration)) {
            $this->_adjustDuration = $adjustDuration;
        } else {
            throw new Streamwide_Media_Exception('Parameter must be boolean.');
        }
    }
    
    /**
     * Get the repeat mix file option.
     *
     * @return boolean
     */
    public function getAdjustDuration()
    {
        return $this->_adjustDuration;
    }
}

/* EOF */