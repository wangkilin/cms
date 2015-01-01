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
 * @version    $Id: Format.php 2608 2010-05-18 02:01:35Z kwu $
 */

/**
 * Abstact media file format.
 *
 * @category   Streamwide
 * @package    Streamwide_Media
 */
abstract class Streamwide_Media_Format
{
    /**
     * The media file duration in seconds.
     * For static media duration will be 0.
     *
     * @var float
     */
    protected $_duration;
    
    /**
     * Sets the media file duration.
     *
     * @param float $duration file duration in seconds
     * @return Streamwide_Media_Format *Provides a fluid interface*
     * @throws Streamwide_Media_Exception when duration is not valid
     */
    public function setDuration($duration)
    {
        if (!is_int($duration) && !is_float($duration) || $duration < 0) {
            throw new Streamwide_Media_Exception('duration should be positive integer or float');
        }

        $this->_duration = $duration;
        
        return $this;
    }
    
    /**
     * Get the file duration.
     *
     * @return integer stream duration
     */
    public function getDuration()
    {
        return $this->_duration;
    }
}

/* EOF */