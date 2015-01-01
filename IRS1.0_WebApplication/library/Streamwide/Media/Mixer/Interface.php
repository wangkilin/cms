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

interface Streamwide_Media_Mixer_Interface
{
    /**
     * Mixes the input files.
     *
     * @param array  $inputFiles Input files
     * @param string $outputFile The output file
     * @return string|boolean    resulted file path or false if the mix failed
     */
    public function mix(Array $inputFiles, $outputFile);
}

/* EOF */