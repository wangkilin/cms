<?php
/**
 *
 * $Rev: 2560 $
 * $LastChangedDate: 2010-04-23 15:49:53 +0800 (Fri, 23 Apr 2010) $
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
 * Base class for media files
 */
abstract class Streamwide_Engine_Media_File_Abstract extends Streamwide_Engine_Media
{

    /**
     * The extension of the file
     *
     * @var string
     */
    protected $_extension;

    /**
     * The folder in which the file resides
     *
     * @var string
     */
    protected $_folder;

    /**
     * Ignores the file extension. Example: An "al" file with the "c" extension can be played by forcing the type to be "file-al"
     *
     * @var string
     */
    protected $_forcedType;

    /**
     * Allowed extensions for this media file (implement in subclasses)
     *
     * @var array
     */
    protected $_allowedExtensions = array(
        self::EXT_3GP,
        self::EXT_AL,
        self::EXT_BMP,
        self::EXT_GIF,
        self::EXT_JPG,
        self::EXT_PNG,
        self::EXT_UL,
        self::EXT_XMP,
        self::EXT_STW
    );

    /**
     * Allowed forced types for this media file (implement in subclasses)
     *
     * @var array
     */
    protected $_allowedForcedTypes = array(
        self::FT_3GP,
        self::FT_AL,
        self::FT_BMP,
        self::FT_GIF,
        self::FT_JPG,
        self::FT_PNG,
        self::FT_TONE,
        self::FT_UL,
        self::FT_XMP,
        self::FT_STW
    );

    /**
     * Constructor
     *
     * @param string $path The absolute path to the file
     * @param string $channel
     * @param string $transition
     * @param string|null $forcedType
     * @param boolean $checkExistence
     * @throws InvalidArgumentException
     */
    public function __construct( $path, $channel = null, $transition = null, $forcedType = null, $checkExistence = true )
    {
    	if ( !is_string( $path ) ) {
    		throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be string ' . gettype( $path ) . ' given' );
    	}
        if ( true === $checkExistence && !file_exists( $path ) ) {
        	throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a valid path to a file' );
        }
        if ( null !== $channel && !in_array( $channel, $this->_allowedChannels ) ) {
        	throw new InvalidArgumentException( __METHOD__ . ' expects parameter 2 to be one of: "' . implode( '", "', $this->_allowedChannels ) . '" values' );
        }
        if ( null !== $transition && !in_array( $transition, $this->_allowedTransitions ) ) {
        	throw new InvalidArgumentException( __METHOD__ . ' expects parameter 3 to be one of: "' . implode( '", "', $this->_allowedTransitions ) . '" values' );
        }
        if ( null !== $forcedType && !in_array( $forcedType, $this->_allowedForcedTypes ) ) {
        	throw new InvalidArgumentException( __METHOD__ . ' expects parameter 4 to be one of: "' . implode( '", "', $this->_allowedForcedTypes ) . '" values' );
        }

        $path = trim( $path );
        $filename = basename( $path );
        $extension = $this->_extractExtension( $filename );

        if ( null === $forcedType && !in_array( $extension, $this->_allowedExtensions ) ) {
        	throw new InvalidArgumentException( __METHOD__ . ' expects parameter 1 to be a valid path to a file with one of: "' . implode( '", "', $this->_allowedExtensions ) . '" extensions' );
        }

        $this->_name = $filename;
        $this->_extension = $extension;
        $this->_folder = dirname( $path );
        $this->_channel = ( null === $channel ? self::CHANNEL_AV : $channel );
        $this->_transition = $transition;
        $this->_forcedType = $forcedType;
    }

    /**
     * Retrieves the name of the file
     *
     * @return string
     */
    public function getName()
    {
	   return $this->_name;
    }

    /**
     * Retrieves the file extension
     *
     * @return string
     */
    public function getExtension()
    {
    	return $this->_extension;
    }

    /**
     * Retrieves the absolute path to the file
     *
     * @return string
     */
    public function getPath()
    {
        return $this->_folder . DIRECTORY_SEPARATOR . $this->_name;
    }
    
    /**
     * Retrieves the folder in which the file is stored
     *
     */
    public function getFolder()
    {
        return $this->_folder;
    }

    /**
     * Retrieves the forced type for this file (if provided at instantiation)
     *
     * @return string|null
     */
    public function getForcedType()
    {
        return $this->_forcedType;
    }

    /**
     * Retrieves the channel on which this file is set to be played
     *
     * @return string
     */
    public function getChannel()
    {
    	return $this->_channel;
    }

    /**
     * Retrieves the file transition
     *
     * @return string|null
     */
    public function getTransition()
    {
    	return $this->_transition;
    }

    /**
     * Retrieves the allowed extensions for this file
     *
     * @return array
     */
    public function getAllowedExtensions()
    {
        return $this->_allowedExtensions;
    }

    /**
     * Retrieves the allowed forced types for this file (used for overriding extension limitations)
     *
     * @return array
     */
    public function getAllowedForcedTypes()
    {
        return $this->_allowedForcedTypes;
    }

    /**
     * Checks if the provided filename has an extension
     *
     * @return boolean
     */
    public function hasExtension()
    {
    	return ( $this->_extension !== '' );
    }

    /**
     * Array representation of this object (to be used in conjunction with the PLAY, RECORDSTART or RECORDSTOP signals)
     *
     * @return array
     */
    public function toArray()
    {
        $filename = '';
        if ( null !== $this->_forcedType ) {
        	$filename = sprintf( '%s:', $this->_forcedType );
        }
        $filename .= $this->_folder . DIRECTORY_SEPARATOR . $this->_name;

        $ret = array( Streamwide_Engine_Media::ARR_FILENAME => $filename );
        $ret[Streamwide_Engine_Media::ARR_TYPE] = $this->_channel;
        if ( null !== $this->_transition ) {
        	$ret[Streamwide_Engine_Media::ARR_TRANS] = $this->_transition;
        }
        return $ret;
    }
    
    /**
     * Returns an array with all defined forced types for media files
     *
     * @return array
     */
    public static function getAllForcedTypes()
    {
        return array(
            self::FT_3GP,
            self::FT_AL,
            self::FT_BMP,
            self::FT_GIF,
            self::FT_JPG,
            self::FT_PNG,
            self::FT_TONE,
            self::FT_UL,
            self::FT_XMP,
            self::FT_STW
        );
    }
    
    /**
     * Extracts the extension of the filename (the string after the last dot character)
     *
     * @param string $filename
     * @return string
     */
    protected function _extractExtension( $filename )
    {
        $ret = '';
        $dotPosition = strrpos( $filename, '.' );
        if ( false === $dotPosition ) {
            return $ret;
        }
        
        $ret = substr( $filename, ++$dotPosition );
        return $ret;
    }

}

/* EOF */
