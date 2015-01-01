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
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Factory.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Default Format Decoder factory.
 *
 * @package    Streamwide_Media
 * @subpackage Streamwide_Media_Format
 */
class Streamwide_Media_Decoder_Factory implements Streamwide_Media_Decoder_Factory_Interface
{
    /**
     * Creates a new format decoder.
     *
     * @param string $fileType file type to decode (identified by file extension)
     * @return Streamwide_Media_Decoder_Interface|boolean returns false if cannot instantiate a converter for given file
     */
    public function newDecoder($file)
    {
        $type = pathinfo($file, PATHINFO_EXTENSION);
        
        // cannot take a decision if we don't have file extension hint
        if (empty($type)) {
            return false;
        }

        switch ($type) {
            case 'al':
                // Use SoXI
                $decoder = new Streamwide_Media_Format_Decoder_SoxInfo();
                break;
                
            case 'stw':
                // Use Stw
                $decoder = new Streamwide_Media_Format_Decoder_Stw();
                break;
                
            default :
                // Use FFmpeg
                $decoder = new Streamwide_Media_Format_Decoder_FFmpeg();
                break;
        }
        
        return $decoder;
    }
}

/* EOF */