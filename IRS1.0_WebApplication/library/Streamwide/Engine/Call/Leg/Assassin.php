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
 * @subpackage Streamwide_Engine_Widget
 * @version 1.0
 *
 */

/**
 * Provides call leg termination capabilities
 */
class Streamwide_Engine_Call_Leg_Assassin extends Streamwide_Engine_Widget
{
    
    /**
     * Error codes
     */
    const KILL_SIGNAL_SEND_FAILURE_ERR_CODE = 'CALLLEGASSASSIN-100';
    const CALL_LEG_NOT_ALIVE_ERR_CODE = 'CALLLEGASSASSIN-200';
    
    /**
     * Allowed event types
     *
     * @var array
     */
    protected $_allowedEventTypes = array(
        Streamwide_Engine_Events_Event::ERROR,
        Streamwide_Engine_Events_Event::SUCCESS
    );
    
    /**
     * Mapping of error codes to error messages
     *
     * @var array
     */
    protected $_errors = array(
        self::KILL_SIGNAL_SEND_FAILURE_ERR_CODE => 'Unable to send the KILL signal',
        self::CALL_LEG_NOT_ALIVE_ERR_CODE => 'Call leg already dead'
    );

    /**
     * Kills a call leg
     *
     * @param Streamwide_Engine_Call_Leg_Abstract $callLeg
     * @param boolean $force
     * @return boolean
     */
    public function kill( Streamwide_Engine_Call_Leg_Abstract $callLeg, $force = false )
    {
        if ( false === $force && !$callLeg->isAlive() ) {
            $this->dispatchErrorEvent( self::CALL_LEG_NOT_ALIVE_ERR_CODE );
            return false;
        }
        
        $callLegName = $callLeg->getName();
        
        $signal = Streamwide_Engine_Signal::factory(
            Streamwide_Engine_Signal::KILL,
            $callLegName
        );
        
        if ( false === $signal->send() ) {
            $this->dispatchErrorEvent( self::KILL_SIGNAL_SEND_FAILURE_ERR_CODE );
            return false;
        }
        
        $callLeg->setDead();
        $event = new Streamwide_Engine_Events_Event( Streamwide_Engine_Events_Event::SUCCESS );
        $event->setParam( 'callLeg', $callLeg );
        $this->dispatchEvent( $event );
        return true;
    }
    
}

/* EOF */