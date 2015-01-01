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

abstract class Streamwide_Engine_Widget_Wrapper extends Streamwide_Engine_Widget
{
    
    /**
     * The wrapped widget
     *
     * @var Streamwide_Engine_Widget
     */
    protected $_widget;

    /**
     * Constructor
     *
     * @param Streamwide_Engine_Widget
     */
    public function __construct( Streamwide_Engine_Widget $widget )
    {
        $this->_widget = $widget;
    }

    /**
     * Destructor
     */
    public function destroy()
    {
        parent::destroy();
        
        if ( isset( $this->_widget ) ) {
            $this->_widget->destroy();
            unset( $this->_widget );
        }
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setEventDispatcher()
     */
    public function setEventDispatcher( Streamwide_Event_Dispatcher_Interface $eventDispatcher )
    {
        return $this->_widget->setEventDispatcher( $eventDispatcher );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#setStateManager()
     */
    public function setStateManager( Streamwide_Engine_Widget_State_Manager $stateManager )
    {
        return $this->_widget->setStateManager( $stateManager );
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setRegistry()
     */
    public function setRegistry( Streamwide_Engine_Registry $registry )
    {
        return $this->_widget->setRegistry( $registry );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getRegistry()
     */
    public function getRegistry()
    {
        return $this->_widget->getRegistry();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getController()
     */
    public function getController()
    {
        return $this->_widget->getController();
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setContextParams()
     */
    public function setContextParams( Array $contextParams, $merge = false )
    {
        return $this->_widget->setContextParams( $contextParams, $merge );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getContextParams()
     */
    public function getContextParams()
    {
        return $this->_widget->getContextParams();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getContextParamsOptions()
     */
    public function getContextParamsOptions()
    {
        return $this->_widget->getContextParamsOptions();
    }
    
    /**
     * @see Engine/Streamwide_Engine_Widget#setOptions()
     */
    public function setOptions( Array $options )
    {
        return $this->_widget->setOptions( $options );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getOptions()
     */
    public function getOptions()
    {
        return $this->_widget->getOptions();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getOption()
     */
    public function getOption( $optionName )
    {
        return $this->_widget->getOption( $optionName );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#setCallbackId()
     */
    public function setCallbackId()
    {
        return $this->_widget->setCallbackId();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getCallbackId()
     */
    public function getCallbackId()
    {
        return $this->_widget->getCallbackId();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getErrors()
     */
    public function getErrors()
    {
        return $this->_widget->getErrors();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#clearContextParams()
     */
    public function clearContextParams( Array $contextParams = null )
    {
        return $this->_widget->clearContextParams();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#reset()
     */
    public function reset()
    {
        return $this->_widget->reset();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#isAllowedEventType()
     */
    public function isAllowedEventType( $eventType )
    {
        return $this->_widget->isAllowedEventType( $eventType );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#dispatchEvent()
     */
    public function dispatchEvent( Streamwide_Event_Interface $event )
    {
        return $this->_widget->dispatchEvent( $event );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#dispatchErrorEvent()
     */
    public function dispatchErrorEvent( $code, Array $eventParams = null )
    {
        return $this->_widget->dispatchErrorEvent( $code, $eventParams );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#addEventListener()
     */
    public function addEventListener( $eventType, Array $callback )
    {
        return $this->_widget->addEventListener( $eventType, $callback );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#removeEventListener()
     */
    public function removeEventListener( $eventType, Array $callback )
    {
        return $this->_widget->removeEventListener( $eventType, $callback );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#hasEventListener()
     */
    public function hasEventListener( $eventType, Array $callback )
    {
        return $this->_widget->hasEventListener( $eventType, $callback );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#hasEventListeners()
     */
    public function hasEventListeners( $eventType = null )
    {
        return $this->_widget->hasEventListeners( $eventType );
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#getEventListeners()
     */
    public function getEventListeners()
    {
        return $this->_widget->getEventListeners();
    }

    /**
     * @see Engine/Streamwide_Engine_Widget#flushEventListeners()
     */
    public function flushEventListeners( Array $criteria = null )
    {
        return $this->_widget->flushEventListeners( $criteria );
    }

    /**
     * Route all calls to unexistent methods to the decorated object
     *
     * @param string $method
     * @param array|null $args
     * @return mixed
     */
    public function __call( $method, $args )
    {
        return call_user_func_array( array( $this->_widget, $method ), $args );
    }
    
}
 
/* EOF */