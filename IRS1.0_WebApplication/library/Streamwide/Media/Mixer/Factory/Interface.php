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
 * @package    Streamwide_Media_Mixer
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Interface.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Mixer factory interface.
 *
 * @package    Streamwide_Media
 * @package    Streamwide_Media_Mixer
 */
interface Streamwide_Media_Mixer_Factory_Interface
{
    /**
     * Creates a new mixer based on mixed files type.
     *
     * @param string                  $inputFiles input files to mix
     * @param boolean                 $adjustDuration (optional) whether to create a new mixer with adjust file duration capabilities
     * @return Streamwide_Media_Mixer_Interface
     */
    public function newMixer($inputFiles, $adjustDuration = false);
}

/* EOF */