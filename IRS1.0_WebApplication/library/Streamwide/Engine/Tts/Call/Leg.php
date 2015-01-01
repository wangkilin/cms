<?php
/**
 *
 * $Rev: 2066 $
 * $LastChangedDate: 2009-10-22 20:18:09 +0800 (Thu, 22 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

/**
 * A TTS (text-to-speech) call leg
 */
class Streamwide_Engine_Tts_Call_Leg extends Streamwide_Engine_Call_Leg_Abstract
{
    
    /**
     * The call leg type
     *
     * @var string
     */
    protected $_type = parent::TTS_CL;
    
}

/* EOF */