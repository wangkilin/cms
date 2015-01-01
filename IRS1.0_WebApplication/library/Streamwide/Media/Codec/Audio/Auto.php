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
 * @version    $Id: Auto.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Represents an autodetectable media codec.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
class Streamwide_Media_Codec_Audio_Auto extends Streamwide_Media_Codec_Audio
{
    /**
     * Media codec name. A string to identify the media codec.
     *
     * @var string
     */
    protected $_codecName = 'auto';
    
    /**
     * Media codec description.
     *
     * @var string
     */
    protected $_codecDescription = 'autodetect codec';
}

/* EOF */