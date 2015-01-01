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

class Streamwide_Engine_Media_Playlist extends Streamwide_Collection
{
    
    /**
     * The Iterator class to use for iterating through the playlist
     *
     * @var string
     */
    protected $_iteratorClass;
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct( 'Streamwide_Engine_Media_File_Abstract' );
    }
    
    /**
     * Destructor
     *
     * @return void
     */
    public function __destruct()
    {
        $this->clear();
    }
    
    /**
     * Append a playlist to the current playlist. Invalid items from $playlist
     * will be silently filtered out.
     *
     * @param Streamwide_Engine_Media_Playlist $playlist
     * @return void
     */
    public function appendPlaylist( Streamwide_Engine_Media_Playlist $playlist )
    {
        if ( $playlist->isEmpty() ) {
            return;
        }
        
        array_splice( $this->_collection, $this->count(), 0, $playlist->toArray() );
    }
    
    /**
     * Prepend a playlist to the current playlist. Invalid items from $playlist
     * will be silently filtered out. This method assigns existing items to new offsets
     *
     * @param Streamwide_Engine_Media_Playlist $playlist
     * @return void
     */
    public function prependPlaylist( Streamwide_Engine_Media_Playlist $playlist )
    {
        if ( $playlist->isEmpty() ) {
            return;
        }
        
        array_splice( $this->_collection, 0, 0, $playlist->toArray() );
    }
    
    /**
     * Add another playlist into the current starting from $offset. Invalid items from $playlist
     * will be silently filtered out. This method assigns existing items to new offsets
     *
     * @param integer $offset
     * @param Streamwide_Engine_Media_Playlist $playlist
     * @return void
     */
    public function addPlaylistAt( $offset, Streamwide_Engine_Media_Playlist $playlist )
    {
        if ( $playlist->isEmpty() ) {
            return;
        }
        
        array_splice( $this->_collection, $offset, 0, $playlist->toArray() );
    }
    
    /**
     * Load the playlist from an array. Invalid items from $playlist
     * will be silently filtered out.
     *
     * @param array $playlist
     * @return void
     */
    public function loadFromArray( Array $playlist )
    {
        $this->_collection = array_values( array_filter( $playlist, array( $this, '_checkUserProvidedItem' ) ) );
    }
    
    /**
     * Filter the items of the playlist. If no $callback is provided
     * it will filter out items based on php boolean coversion rules
     *
     * @param array|string|null $callback
     */
    public function filter( $callback )
    {
        $this->_collection = array_values( array_filter( $this->_collection, $callback ) );
    }
    
    /**
     * Sorts the playlist based on the provied comparison callback
     *
     * @param Streamwide_Comparator_Interface|array|string $cmp
     * @return void
     */
    public function sort( $cmp )
    {
        parent::sortCollection( $cmp );
    }
    
    /**
     * Whether the playlist is empty or not
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return ( $this->count() === 0 );
    }
    
    /**
     * Clear (empty) the playlist
     *
     * @return void
     */
    public function clear()
    {
        parent::resetCollection();
    }
    
    /**
     * Retrieve an iterator for traversing the playlist
     *
     * @return Iterator
     */
    public function getIterator()
    {
        $this->_checkCallback();
        
        $iteratorClass = 'ArrayIterator';
        if ( null !== $this->_iteratorClass ) {
            $iteratorClass = $this->_iteratorClass;
        }
        
        return new $iteratorClass( $this->_collection );
    }
    
    /**
     * Set the iterator class that will be used to traverse the playlist
     *
     * @param string $iteratorClass
     * @return void
     */
    public function setIteratorClass( $iteratorClass )
    {
        $this->_iteratorClass = $iteratorClass;
    }
    
    /**
     * Get the iterator class that will be used to traverse the playlist
     *
     * @return string
     */
    public function getIteratorClass()
    {
        return $this->_iteratorClass;
    }
    
    /**
     * Get an array representation of the playlist
     *
     * @return array
     */
    public function toArray()
    {
        return parent::getCollection();
    }
    
}
 
/* EOF */