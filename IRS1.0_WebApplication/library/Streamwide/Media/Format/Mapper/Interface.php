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
 * @version    $Id: Interface.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Media mapper interface.
 * Maps a file extension to a media format.
 *
 * @package    Streamwide_Media
 */
interface Streamwide_Media_Format_Mapper_Interface
{
    /**
     * Gets the preffered file extension for the given media format.
     *
     * @param Streamwide_Media_Format_Abstract|string $format format
     * @return array
     */
    public function getFileExtension($format);
    
    /**
     * Gets the format associated with a file extension.
     *
     * @param string $fileExtension
     * @return string associated format class name
     */
    public function getFormat($fileExtension);
}

/* EOF */