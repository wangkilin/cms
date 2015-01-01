<?php
/**
 *
 * $Rev: 2066 $
 * $LastChangedDate: 2009-10-22 20:18:09 +0800 (Thu, 22 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Media
 * @version 1.0
 *
 */

/**
 * An image media file
 */
class Streamwide_Engine_Media_File_Image extends Streamwide_Engine_Media_File_Abstract
{

    /**
     * Possible options for playing image medias
     */
    const OPT_DURATION = 'duration';
    const OPT_TEXT_VALUE = 'text_value';
    const OPT_TEXT_DEG = 'text_deg';
    const OPT_TEXT_GRAVITY = 'text_gravity';
    const OPT_TEXT_OFFSET = 'text_offset';
    const OPT_FONT_COLOR = 'font_color';
    const OPT_FONT_SIZE = 'font_size';
    const OPT_FONT_TYPE = 'font_type';
    const OPT_IMAGE_TILE = 'image_tile';
    const OPT_BG_COLOR = 'background_color';
    const OPT_VIDEO_FORMAT = 'video_format';
    
    /**
     * Allowed channels for this media file
     *
     * @var array
     */
    protected $_allowedChannels = array(
        self::CHANNEL_VIDEO,
        self::CHANNEL_AV
    );

    /**
     * Allowed extensions for this media file
     *
     * @var array
     */
    protected $_allowedExtensions = array(
        self::EXT_JPG,
        self::EXT_BMP,
        self::EXT_PNG,
        self::EXT_XMP,
        self::EXT_GIF
    );

    /**
     * Allowed forced types for this media file
     *
     * @var array
     */
    protected $_allowedForcedTypes = array(
        self::FT_JPG,
        self::FT_BMP,
        self::FT_PNG,
        self::FT_XMP,
        self::FT_GIF
    );

    /**
     * Playing options for this media file
     *
     * @var array
     */
    protected $_playingOptions = array();

    /**
     * Sets the play duration for this file
     *
     * @param string $duration
     * @return void
     */
    public function setDuration( $duration )
    {
    	$this->_playingOptions[self::OPT_DURATION] = $duration;
    }

    /**
     * Sets a text to be displayed on top of the image
     *
     * @param string $textValue
     * @return void
     */
    public function setTextValue( $textValue )
    {
        $this->_playingOptions[self::OPT_TEXT_VALUE] = $textValue;
    }

    /**
     * Sets the rotation of the text on top of the image
     *
     * @param string $textDeg
     * @return void
     */
    public function setTextDeg( $textDeg )
    {
    	$this->_playingOptions[self::OPT_TEXT_DEG] = $textDeg;
    }

    /**
     * Sets the text position on the screen
     *
     * @param string $textGravity
     * @return void
     */
    public function setTextGravity( $textGravity )
    {
    	$this->_playingOptions[self::OPT_TEXT_GRAVITY] = $textGravity;
    }

    /**
     * Sets the text offset on the screen
     *
     * @param string $textOffset
     * @return void
     */
    public function setTextOffset( $textOffset )
    {
        $this->_playingOptions[self::OPT_TEXT_OFFSET] = $textOffset;
    }

    /**
     * Sets the font color of the text
     *
     * @param string $fontColor
     * @return void
     */
    public function setFontColor( $fontColor )
    {
    	$this->_playingOptions[self::OPT_FONT_COLOR] = $fontColor;
    }

    /**
     * Sets the font size of the text
     *
     * @param string $fontSize
     * @return void
     */
    public function setFontSize( $fontSize )
    {
    	$this->_playingOptions[self::OPT_FONT_SIZE] = $fontSize;
    }

    /**
     * Sets the font type of the text
     *
     * @param string $fontType
     * @return void
     */
    public function setFontType( $fontType )
    {
        $this->_playingOptions[self::OPT_FONT_TYPE] = $fontType;
    }

    /**
     * Sets the image tiling options
     *
     * @param string $imageTilingOpts
     * @return void
     */
    public function setImageTile( $imageTilingOpts )
    {
    	$this->_playingOptions[self::OPT_IMAGE_TILE] = $imageTilingOpts;
    }

    /**
     * Sets the background color
     *
     * @param string $bgColor
     * @return void
     */
    public function setBackgroundColor( $bgColor )
    {
        $this->_playingOptions[self::OPT_BG_COLOR] = $bgColor;
    }

    /**
     * Sets the video format
     *
     * @param string $videoFormat
     * @return void
     */
    public function setVideoFormat( $videoFormat )
    {
	    $this->_playingOptions[self::OPT_VIDEO_FORMAT] = $videoFormat;
    }

    /**
     * Array representation of this object (to be used in conjunction with the PLAY signal)
     *
     * @return array
     */
    public function toArray()
    {
        $filename = '';
        $hasPlayingOptions = !empty( $this->_playingOptions );
        if ( $hasPlayingOptions ) {
            if ( null === $this->_forcedType ) {
            	$filename = sprintf( 'file-%s/', $this->_extension );
            } else {
            	$filename = sprintf( '%s/', $this->_forcedType );
            }
            $it = new CachingIterator( new ArrayIterator( $this->_playingOptions ) );
            foreach ( $it as $opt => $val ) {
                $filename .= sprintf( '%s=%s', $opt, $val );
                if ( $it->hasNext() ) {
                	$filename .= ',';
                }
            }
            $filename .= ':';
        } else {
            if ( null !== $this->_forcedType ) {
            	$filename = sprintf( '%s:', $this->_forcedType );
            }
        }
        $filename .= $this->_folder . DIRECTORY_SEPARATOR . $this->_name;

        $ret = array( self::ARR_FILENAME => $filename );
        $ret[self::ARR_TYPE] = $this->_channel;
        if ( null !== $this->_transition ) {
            $ret[self::ARR_TRANS] = $this->_transition;
        }
        return $ret;
    }
}

/* EOF */