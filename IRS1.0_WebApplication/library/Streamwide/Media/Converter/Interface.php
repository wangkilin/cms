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
 * @subpackage Subpackage
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Interface.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Media file converter interface.
 *
 * @package    Streamwide_Media
 */
interface Streamwide_Media_Converter_Interface
{
    /**
     * Converts a file to the specified media format.
     *
     * @param string|array                   $inputFiles   one or more input files
     * @param string                         $outputFile   destination file
     * @param string|Streamwide_Media_Format $outputFormat output format
     * @return string|boolean created file path or false if conversion has failed
     */
    public function convert($inputFiles, $outputFile, $outputFormat);
}

/* EOF */