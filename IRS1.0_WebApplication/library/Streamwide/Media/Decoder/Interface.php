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
 * @package    Streamwide_Media_Format
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Interface.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Format decoder interface.
 *
 * @package    Streamwide_Media
 * @package    Streamwide_Media_Format
 */
interface Streamwide_Media_Decoder_Interface
{
    /**
     * Decodes a media file format and transforms it
     * into a Streamwide_Media_Format object
     *
     * @param string $file media file to decode
     * @return Streamwide_Media_Format
     */
    public function decodeFormat($file);
}

/* EOF */