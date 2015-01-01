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
 * @package    Streamwide_Media_Joiner
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Factory.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Default joiner factory.
 *
 * @package    Streamwide_Media
 * @package    Streamwide_Media_Joiner
 */
class Streamwide_Media_Joiner_Factory implements Streamwide_Media_Joiner_Factory_Interface
{
    /**
     * Creates a new mixer based on mixed files format.
     *
     * @param string $inputFiles input files to join
     * @param string $outputFile output file
     * @return Streamwide_Media_Mixer_Interface
     * @throws Streamwide_Media_Exception when files don't have the same type
     */
    public function newJoiner($inputFiles, $outputFile)
    {
        // restrictions: input files and output file must have the same type
        
        
    }
}

/* EOF */