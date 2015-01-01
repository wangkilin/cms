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
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Converter.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Converter facade.
 *
 * This class acts as a facade for the other converters.
 * It decides which converter to instantiate based on a converter factory
 * and delegates the conversion to the converter.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Converter implements Streamwide_Media_Converter_Interface
{
    /**
     * Converter factory.
     *
     * @var Streamwide_Media_Converter_Factory_Interface
     */
    protected $_converterFactory;
    
    /**
     * Format mapper.
     *
     * @var Streamwide_Media_Format_Mapper_Interface
     */
    protected $_formatMapper;
    
    /**
     * Default converter factory.
     *
     * @var string
     */
    protected $_defaultConverterFactory = 'Streamwide_Media_Converter_Factory';
    
    /**
     * Default format mapper.
     *
     * @var string
     */
    protected $_defaultFormatMapper = 'Streamwide_Media_Format_Mapper';

    
    /**
     * Constructor.
     *
     * @param Streamwide_Media_Converter_Factory_Interface $factory (optional) converter factory
     * @param Streamwide_Media_Format_Mapper_Interface     $mapper  (optional) format mapper
     */
    public function __construct(
        Streamwide_Media_Converter_Factory_Interface $factory = null,
        Streamwide_Media_Format_Mapper_Interface $mapper = null
    )
    {
        if (is_null($factory)) {
            $factory = new $this->_defaultConverterFactory();
        }
        if (is_null($mapper)) {
            $mapper = new $this->_defaultFormatMapper();
        }
        
        $this->_converterFactory = $factory;
        $this->_formatMapper = $mapper;
    }
    
    /**
     * Converts a file to the specified media format.
     *
     * @param string|array            $inputFiles one or more input files
     * @param string                  $outputFile destination file
     * @param string|Streamwide_Media_Format $outputFormat (optional) output format
     * @return string|boolean created file path or false if conversion has failed
     * @throws Streamwide_Media_Exception when the format is invalid or not supported
     */
    public function convert($inputFiles, $outputFile, $outputFormat = null)
    {
        // setup output format
        if (!is_null($outputFormat)) {
            if (is_string($outputFormat)) {
                $format = new $this->_formatMapper->getFormat($outputFormat);
            } else {
                $format = $outputFormat;
            }
            
            if (!$format instanceof Streamwide_Media_Format) {
                throw new Streamwide_Media_Exception('Unknown output format: ' . $format);
            }
        } else {
            $type = pathinfo($outputFile, PATHINFO_EXTENSION);
            
            $formatClass = $this->_formatMapper->getFormat($type);
            
            $format = new $formatClass;
        }
        
        // get the converter from factory
        $converter = $this->_converterFactory->newConverter($inputFiles, $format);
        
        // delegate the conversion to the converter
        return $converter->convert($inputFiles, $outputFile, $format);
    }
    
    /**
     * Set the converter factory.
     *
     * @param Streamwide_Media_Converter_Factory $factory
     * @return Streamwide_Media_Converter *Provides fluent interface*
     */
    protected function setConverterFactoy(Streamwide_Media_Converter_Factory $factory)
    {
        $this->_converterFactory = $factory;
        
        return $this;
    }

    /**
     * Gets media format for the file based on file extension.
     *
     * @param string $destination
     * @return Streamwide_Media_Format
     */
    protected function _getMediaFormat($file)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        if ($format = $this->_formatMapper->getMediaFormat($ext)) {
            return new $format;
        } else {
            return new Streamwide_Media_Exception('Unknown media format for file ' . $file);
        }
    }
}

/* EOF */