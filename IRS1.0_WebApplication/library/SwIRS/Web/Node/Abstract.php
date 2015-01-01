<?php
/**
 * $Rev: 2650 $
 * $LastChangedDate: 2010-06-22 19:18:47 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   library
 * @subpackage node
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.com>
 * @version    $Id: Abstract.php 2650 2010-06-22 11:18:47Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Abstract
{
    const BLACKLIST = 'Blacklist';
    const ORIGIN = 'Origin';
    const CALENDAR = 'Calendar';
    const DISTRIBUTION = 'Distribution';
    const HANGUP = 'Hangup';
    const LINK = 'Link';
    const MENU = 'Menu';
    const PROMPT = 'Prompt';
    const OUTGOING = 'Destination';

    protected $_type;

    private static $_types = array();

    /**
     *
     */
    public static function getNodeTypes()
    {
        if (empty(self::$_types)) {
            $types = Streamwide_Web_Model::call('Node.GetTypes',array());
            foreach ($types as $type) {
                self::$_types[$type['NodeTypeId']] = $type['NodeType'];
            }
        }
        return self::$_types;
    }

    /**
     *
     */
    public function __construct($type)
    {
        $this->_type = $type;
    }

    /**
     *
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        Streamwide_Web_Log::debug("create a " . $this->_type . " node");
        $defaults = array(
            'Label' => $this->_type . " " . time(),
            'NodeTypeId' => null,
            'TreeId' => null,
            'IsActive' => true
        );
        $node = SwIRS_Web_Request::getParam($request,$defaults);
        $nodeId = Streamwide_Web_Model::call('Node.Create',array($node));

        Streamwide_Web_Log::debug("node " . $node['Label'] . " is created with id $nodeId");
        $node['NodeId'] = $nodeId;
        return $node;
    }

    /**
     *
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        Streamwide_Web_Log::debug("update a " . $this->_type . " node");
        $defaults = array(
            'NodeId' => null,
            'Label' => null,
            'IsActive' => null
        );
        $node = SwIRS_Web_Request::getParam($request,$defaults);
        if (count($node) > 1) {
            $result = Streamwide_Web_Model::call('Node.Update',array($node));
            Streamwide_Web_Log::debug("node " . $node['NodeId'] . " is updated");
        }
        return $node;
    }

    /**
     *
     */
    public function delete(Zend_Controller_Request_Abstract $request)
    {
        $nodeId = $request->getParam('NodeId');
        Streamwide_Web_Log::debug("delete a " . $this->_type . " node whose id is $nodeId");
        $result = Streamwide_Web_Modal::call('Node.Delete',array($nodeId));
    }

    /**
     *
     */
    public function check(Zend_Controller_Request_Abstract $request)
    {
        return true;
    }

    /**
     *
     */
    public function addOutputs(array $nodeOutputs)
    {
        Streamwide_Web_Log::debug("create node outputs for " . $this->_type . " node");
        foreach ($nodeOutputs as &$nodeOutput) {
            $nodeOutput = $this->addOutput($nodeOutput);
        }
        return $nodeOutputs;
    }

    /**
     *
     */
    public function updateOutputs(array $nodeOutputs)
    {
        Streamwide_Web_Log::debug("update node outputs for " . $this->_type . " node");
        foreach ($nodeOutputs as &$nodeOutput) {
            if (!is_null($nodeOutput['NodeOutputId']) && !is_null($nodeOutput['NodeId'])) {
                $this->updateOutput($nodeOutput);
            }
            if ( is_null($nodeOutput['NodeOutputId']) && !is_null($nodeOutput['NodeId'])) {
                $nodeOutput = $this->addOutput($nodeOutput);
            }
            if (!is_null($nodeOutput['NodeOutputId']) &&  is_null($nodeOutput['NodeId'])) {
                $this->deleteOutput($nodeOutput);
            }
        }
        return $nodeOutputs;
    }

    /**
     *
     */
    public function updateOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("node output " . $nodeOutput['NodeOutputId'] . " is updated");
        $result = Streamwide_Web_Model::call('NodeOutput.Update',array($nodeOutput));
        return $result;
    }

    /**
     *
     */
    public function addOutput($nodeOutput)
    {
        $nodeOutputId = Streamwide_Web_Model::call('NodeOutput.Create',array($nodeOutput));
        $nodeOutput['NodeOutputId'] = $nodeOutputId;
        Streamwide_Web_Log::debug("node output " . $nodeOutput['NodeOutputId'] . " is created");
        return $nodeOutput;
    }

    /**
     *
     */
    public function deleteOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("node output " . $nodeOutput['NodeOutputId'] . " is deleted");
        $nodeOutputId = $nodeOutput['NodeOutputId'];
        $result = Streamwide_Web_Model::call('NodeOutput.Delete',array($nodeOutputId));
        return $reslut;
    }

    /**
     *
     */
    public function getPhtml()
    {
        return strtolower($this->_type);
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        return array();
    }
}
/*EOF*/
