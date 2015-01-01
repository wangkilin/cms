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
 * @version    $Id: Video.php 2608 2010-05-18 02:01:35Z kwu $
 */

abstract class Streamwide_Media_Track_Video extends Streamwide_Media_Track
{
    /**
     * Allowed codecs.
     *
     * @var array
     */
    protected $_allowedCodecs = array(
        'Streamwide_Media_Codec_Video'
    );
}

/* EOF */