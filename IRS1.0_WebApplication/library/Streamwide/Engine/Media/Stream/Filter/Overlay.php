<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

class Streamwide_Engine_Media_Stream_Filter_Overlay extends Streamwide_Engine_Media_Stream_Filter
{

    const PARAM_DURATION = 'duration';
    const PARAM_IMAGE_PATH = 'image_path';
    const PARAM_TEXT_VALUE = 'text_value';
    const PARAM_TEXT_GRAVITY = 'text_gravity';
    const PARAM_FONT_COLOR = 'font_color';
    const PARAM_FONT_SIZE = 'font_size';
    const PARAM_FONT_TYPE = 'font_type';
    const PARAM_IMAGE_TILE = 'image_tile';
    
    /**
     * A timer to measure how long the filter is active
     *
     * @var Streamwide_Engine_Timer_Timeout
     */
    protected $_timer;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_name = self::FILTER_OVERLAY;
        $this->_streamDirection = self::STREAM_INCOMING;
    }
    
    /**
     * Set the timer widget that will handle the duration parameter
     *
     * @param Streamwide_Engine_Timer_Timeout $timer
     * @return void
     */
    public function setTimer( Streamwide_Engine_Timer_Timeout $timer )
    {
        $this->_timer = $timer;
    }
    
    /**
     * Get the timer widget that will handle the duration parameter
     *
     * @return Streamwide_Engine_Timer_Timeout
     */
    public function getTimer()
    {
        return $this->_timer;
    }
    
    /**
     * Duration in ms for which this filter is active. Once time is off, the filter deactivates itself.
     * -1 indicates an infinite time. Once timed out, duration needs to be reset.
     *
     * @param integer $duration
     * @return void
     */
    public function setDuration( $duration )
    {
        $duration = (int)$duration;
        
        if ( $duration < -1 ) {
            $duration = -1;
        }
        
        $this->_params[self::PARAM_DURATION] = $duration;
    }
    
    /**
     * Get the duration
     *
     * @return integer|null
     */
    public function getDuration()
    {
        if ( isset( $this->_params[self::PARAM_DURATION] ) ) {
            return $this->_params[self::PARAM_DURATION];
        }
    }
    
    /**
     * The path to the image file that overlays the stream
     *
     * @param string $imagePath
     * @return void
     */
    public function setImagePath( $imagePath )
    {
        $this->_params[self::PARAM_IMAGE_PATH] = (string)$imagePath;
    }
    
    /**
     * Get the path to the image file that overlays the stream
     *
     * @return string|null
     */
    public function getImagePath()
    {
        if ( isset( $this->_params[self::PARAM_IMAGE_PATH] ) ) {
            return $this->_params[self::PARAM_IMAGE_PATH];
        }
    }
    
    /**
     * The value of the text to display
     *
     * @param string $textValue
     * @return void
     */
    public function setTextValue( $textValue )
    {
        $this->_params[self::PARAM_TEXT_VALUE] = (string)$textValue;
    }
    
    /**
     * Get the value of the text to display
     *
     * @return string|null
     */
    public function getTextValue()
    {
        if ( isset( $this->_params[self::PARAM_TEXT_VALUE] ) ) {
            return $this->_params[self::PARAM_TEXT_VALUE];
        }
    }
    
    /**
     * Set where on the screen the text shold be displayed.
     * Supported values are "N", "NW", "W", "SW","S", "SE", "E", "NE".
     *
     * @param string $textGravity
     * @return void
     */
    public function setTextGravity( $textGravity )
    {
        $textGravity = strtoupper( $textGravity );
        
        switch ( $textGravity ) {
            case "N":
            case "NW":
            case "W":
            case "SW":
            case "S":
            case "SE":
            case "E":
            case "NE":
                $this->_params[self::PARAM_TEXT_GRAVITY] = $textGravity;
            break;
        }
    }
    
    /**
     * @return string|null
     */
    public function getTextGravity()
    {
        if ( isset( $this->_params[self::PARAM_TEXT_GRAVITY] ) ) {
            return $this->_params[self::PARAM_TEXT_GRAVITY];
        }
    }
    
    /**
     * Set the color of the text
     *
     * @param string $fontColor
     * @return void
     */
    public function setFontColor( $fontColor )
    {
        $this->_params[self::PARAM_FONT_COLOR] = $fontColor;
    }
    
    /**
     * Return the color of the text
     *
     * @return string|null
     */
    public function getFontColor()
    {
        if ( isset( $this->_params[self::PARAM_FONT_COLOR] ) ) {
            return $this->_params[self::PARAM_FONT_COLOR];
        }
    }
    
    /**
     * Set the size of the text, in relative height (from 0.0 to 1.0) the first being nothing,
     * second would be the height of the stream.
     *
     * @param float $fontSize
     * @return void
     */
    public function setFontSize( $fontSize )
    {
        $fontSize = round( $fontSize, 1 );
        
        if ( $fontSize < 0 ) {
            $fontSize  = 0.0;
        }
        
        if ( $fontSize > 1 ) {
            $fontSize = 1.0;
        }
        
        $this->_params[self::PARAM_FONT_SIZE] = $fontSize;
    }
    
    /**
     * Get the size of the font
     *
     * @return string|null
     */
    public function getFontSize()
    {
        if ( isset( $this->_params[self::PARAM_FONT_SIZE] ) ) {
            return $this->_params[self::PARAM_FONT_SIZE];
        }
    }
    /**
     * The type of the font, or a path to a specific font
     *
     * @param string $fontType
     * @return void
     */
    public function setFontType( $fontType )
    {
        $this->_params[self::PARAM_FONT_TYPE] = $fontType;
    }
    
    /**
     * Get the type of the font
     *
     * @return string|null
     */
    public function getFontType()
    {
        if ( isset( $this->_params[self::PARAM_FONT_TYPE] ) ) {
            return $this->_params[self::PARAM_FONT_TYPE];
        }
    }
    
    /**
     * Set the tile in which the image is displayed. If the image is bigger than the space left inside
     * the tile, it is reduced to match in. A tile is described as "<width>x<height>;<x_off>x<y_off>". All
     * those values are float between 0.0 and 1.0. (example: "0.8x0.8;0.2x0.2"). If "image_tile" is set to
     * "all" (default), then no transformation is done to the image, it is simply displayed with x_off and
     * y_off equal to 0 and resized to match the stream size.
     *
     * @param string $imageTile
     * @return void
     */
    public function setImageTile( $imageTile )
    {
        $imageTile = strtolower( $imageTile );
        
        if ( 1 === preg_match( '!^(?:all|(?:0\.[0-9]|1\.0)x(?:0\.[0-9]|1\.0);(?:0\.[0-9]|1\.0)x(?:0\.[0-9]|1\.0))$!', $imageTile ) ) {
            $this->_params[self::PARAM_IMAGE_TILE] = $imageTile;
        }
    }
    
    /**
     * @return string|null
     */
    public function getImageTile()
    {
        if ( isset( $this->_params[self::PARAM_IMAGE_TILE] ) ) {
            return $this->_params[self::PARAM_IMAGE_TILE];
        }
    }
    
    /**
     * If we activate the filter force duration to be infinite (-1) and use the user provided duration parameter
     * as a delay for the internal timer. If we deactivate the filter we disarm the internal timer
     *
     * @param boolean $activate
     * @return boolean
     */
    protected function _applyFilterSettings( $activate = true )
    {
        if ( true === $activate ) {
            $duration = isset( $this->_params['duration'] ) ? $this->_params['duration'] : null;
            
            // force duration to be infinite and handle it using a timer
            if ( null !== $duration ) {
                $this->_params['duration'] = -1;
            
                if ( !$this->_armTimer( $duration ) ) {
                    trigger_error( 'Unable to arm internal timer to handle the duration parameter', E_USER_NOTICE );
                }
            }
        } else {
            if ( !$this->_disarmTimer() ) {
                return false;
            }
        }
        
        return parent::_applyFilterSettings( $activate );
    }
    
    /**
     * Arm the internal timer
     *
     * @param integer $delay
     * @return boolean
     */
    protected function _armTimer( $delay )
    {
        $this->_timer->reset();
        $this->_timer->setOptions( array( Streamwide_Engine_Timer_Timeout::OPT_DELAY => $delay ) );
        $this->_timer->addEventListener(
            Streamwide_Engine_Events_Event::TIMEOUT,
            array(
                'callback' => array( $this, 'deactivate' ),
                'options' => array( 'autoRemove' => 'before' )
            )
        );
        
        return $this->_timer->arm();
    }
    
    /**
     * Disarm the internal timer
     *
     * @return boolean
     */
    protected function _disarmTimer()
    {
        if ( $this->_timer->isArmed() ) {
            return $this->_timer->disarm();
        }
        
        return true;
    }
    
    
}
 
/* EOF */