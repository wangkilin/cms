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
 * @version    $Id: Interface.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Converter factory interface.
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Converter
 */
interface Streamwide_Media_Converter_Factory_Interface
{
    /**
     * Creates a new converter based on input file types
     * and the output format.
     *
     * @param string|array $inputFiles one or more input files
     * @param Streamwide_Media_Format $outputFormat
     * @return Streamwide_Media_Converter
     */
    public function newConverter($inputFiles, Streamwide_Media_Format $outputFormat);
}

/* EOF */