<?php
/**
 *
 * $Rev: 2089 $
 * $LastChangedDate: 2009-10-30 23:14:18 +0800 (Fri, 30 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Streamwide_Engine
 * @subpackage Streamwide_Engine_Log
 * @version 1.0
 *
 */

/**
 * Provides loggin capabilities in multicall environment
 */
class Streamwide_Engine_Log extends Streamwide_Log
{
    
    /**
     * The logging format
     *
     * @var string
     */
    protected $_format = '%timestamp%.%milliseconds% | %memory% | %pid% | %clid% | %sessionid% | %from% | %to% | %priorityName% | ';
    
    /**
     * In multicall we need to update the event items based on phpId. This array
     * stores the values for the event items indexed by phpId
     *
     * @var array
     */
    protected $_callInfo = array();

    /**
     * Constructor
     *
     * @param Streamwide_Log_Writer_Abstract|null $writer
     * @return void
     */
    public function __construct( $writer = null )
    {
        if ( null === $writer ) {
            $writer = new Streamwide_Log_Writer_Console();
            $writer->setFormatter( new Streamwide_Log_Formatter_Standard( $this->_format ) );
        }
        
        parent::__construct( $writer );
        $this->setEventItem( 'clid', '' );
        $this->setEventItem( 'sessionid', '' );
        $this->setEventItem( 'from', '' );
        $this->setEventItem( 'to', '' );
    }

    /**
     * Retrieve the logger priorities
     *
     * @return array
     */
    public function getPriorities()
    {
        return $this->_priorities;
    }
    
    /**
     * Update the custom event items
     *
     * @param array $data
     * @return void
     */
    public function updateEventItems( Array $data )
    {
        list( $phpId, $record ) = each( $data );
        $this->_addCallInfoRecord( $phpId, $record );
        $this->_setEventItems( $phpId );
    }
    
    /**
     * Add a record to the call info array
     *
     * @param integer $phpId
     * @param array $record
     * @return void
     */
    protected function _addCallInfoRecord( $phpId, $record )
    {
        if ( !array_key_exists( $phpId, $this->_callInfo ) && is_array( $record ) ) {
            $keys = array( 'sip_call-id', 'source', 'destination' );
            $recordKeys = array_keys( $record );
             
            if ( count( array_intersect( $keys, $recordKeys ) ) === count( $keys ) ) {
                $this->_callInfo[$phpId] = array(
                    'sessionid' => $record['sip_call-id'],
                    'from' => $record['source'],
                    'to' => $record['destination']
                );
            }
        }
    }
    
    /**
     * Set the event items based on the new php id
     *
     * @param string $phpId
     * @return void
     */
    protected function _setEventItems( $phpId )
    {
        if ( !array_key_exists( $phpId, $this->_callInfo ) ) {
            return null;
        }
        
        $callInfo = $this->_callInfo[$phpId];
        $this->setEventItem( 'clid', $phpId );
        $this->setEventItem( 'sessionid', $callInfo['sessionid'] );
        $this->setEventItem( 'from', $callInfo['from'] );
        $this->setEventItem( 'to', $callInfo['to'] );
    }
    
}
 
/* EOF */