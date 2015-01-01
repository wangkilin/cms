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
 * @version    $Id: Mapper.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Abstract class to map a file extension to a media format.
 *
 * @package    Streamwide_Media
 */
class Streamwide_Media_Format_Mapper implements Streamwide_Media_Format_Mapper_Interface
{
    /**
     * Mapping between file extension and media format class.
     *
     * @var array
     */
    protected $_mapping = array(
        'al'  => 'Streamwide_Media_Format_Audio_Alaw',
        'amr' => 'Streamwide_Media_Format_Audio_Amr',
        'mp3' => 'Streamwide_Media_Format_Audio_Mp3',
        'wav' => 'Streamwide_Media_Format_Audio_Wav',
        'wma' => 'Streamwide_Media_Format_Audio_Wma',
        '3gp' => 'Streamwide_Media_Format_Video_ThirdGP',
        'flv' => 'Streamwide_Media_Format_Video_Flv',
        'wmv' => 'Streamwide_Media_Format_Video_Wmv',
        'stw' => 'Streamwide_Media_Format_Mixed_Stw'
    );
    
    /**
     * Gets the file extensions for the given media format.
     *
     * @param Streamwide_Media_Format_Abstract|string $format format
     * @return string|boolean file extension or false if there is no mapping for provided format
     */
    public function getFileExtension($format)
    {
        if ($format instanceof Streamwide_Media_Format_Abstract) {
            foreach ($mapping as $fileExtension => $formatMap) {
                if ($format instanceof $formatMap) {
                    return $fileExtension;
                }
            }
         } else {
             $reverseMapping = array_flip($this->_mapping);
             
             if (isset($reverseMapping[$format])) {
                 return $reverseMapping[$format];
             }
         }
         
         return false;
    }
    
    /**
     * Gets the format associated with a file extension.
     *
     * @param string $fileExtension
     * @return string associated format class name
     */
    public function getFormat($fileExtension)
    {
        return $this->_mapping[$fileExtension];
    }
}

/* EOF */