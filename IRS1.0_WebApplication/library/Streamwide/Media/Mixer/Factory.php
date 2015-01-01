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
 * @version    $Id: Factory.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Mixer factory default implementation.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Mixer_Factory implements Streamwide_Media_Mixer_Factory_Interface
{
    /**
     * Creates a new mixer based on mixed files type.
     *
     * @param string                  $inputFiles input files to mix
     * @param boolean                 $adjustDuration (optional) whether to create a new mixer with adjust file duration capabilities
     * @return Streamwide_Media_Mixer_Interface
     */
    public function newMixer($inputFiles, $adjustDuration = false)
    {
        // we use only one mixer for all file types
        $mixer = Streamwide_Media_Mixer_SoxMix();
        
        // if we need to adjust duration use the decorator
        if ($adjustDuration) {
            $joiner = new Streamwide_Media_Joiner();
            $decoder = new Streamwide_Media_Decoder();
            $converter = new Streamwide_Media_Converter();
            
            $mixer = new Streamwide_Media_Mixer_Decorator_AdjustDuration($mixer, $joiner, $decoder, $converter);
        }
        
        return $mixer;
    }
}
/* EOF */