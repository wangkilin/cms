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
 * @subpackage Streamwide_Media_Decoder
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Interface.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Media decoder factory interface.
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Decoder
 */
interface Streamwide_Media_Decoder_Factory_Interface
{
    /**
     * Creates a new format decoder.
     *
     * @param string $file file to decode
     * @return Streamwide_Media_Decoder_Interface|boolean returns false if cannot instantiate a converter for given file
     */
    public function newDecoder($file);
}

/* EOF */