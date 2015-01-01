<?php
/**
 * A custom callback filter iterator.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Interators
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Iterator.php 1962 2009-09-24 20:49:25Z rgasler $
 */

class Streamwide_Iterators_Callback_Filter_Iterator extends FilterIterator
{
    /**
     * Callback function used for filtering elements during iteration
     *
     * @var string|array
     */
    protected $_callback;

    /**
     * Array with parameters for the callback function
     *
     * @var array
     */
    protected $_callbackArgs = array();

    /**
     * Constructor
     *
     * @param Iterator     $it       iterator
     * @param string|array $callback callback
     * @param mixed        $args     callback arguments
     */
    public function __construct( Iterator $it, $callback, $args = null )
    {
        $this->_callback = $callback;
        if ( null !== $args ) {
            if ( !is_array( $args ) ) {
                $args = array( $args );
            }
            $this->_callbackArgs = $args;
        }
        parent::__construct( $it );
    }

    /**
     * Performs the actual filtering of elements during iteration. We call the user
     * provided callback inside
     *
     * @return boolean
     */
    public function accept()
    {
        $args = $this->_callbackArgs;
        $args[] = $this->current();
        $args[] = $this->key();

        return (bool)call_user_func_array( $this->_callback, $args );
    }
}

/* EOF */