<?php
/**
 * $Rev: 2635 $
 * $LastChangedDate: 2010-06-22 12:44:43 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   library
 * @subpackage node
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.com>
 * @version    $Id: Origin.php 2635 2010-06-22 04:44:43Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Origin extends SwIRS_Web_Node_Abstract
{
    const NODE_OUTPUT_LABEL_OTHERS = 'Others';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::ORIGIN);
    }

    /**
     *
     */
    private function _getOrigin($origins,$prefixes,$request)
    {
        $customerUserId = $request->getParam('CustomerUserId');
        $customerAccountId = $request->getParam('CustomerAccountId');
        $origin = array(
            'OriginName' => 'Automatic Origin ' . time(),
            'CustomerUserId' => $customerUserId,
            'CustomerAccountId' => $customerAccountId,
            'Automatic' => true
        );
        $originId = Streamwide_Web_Model::call('Origin.Create',array($origin));
        if(!empty($origins)) {
            Streamwide_Web_Model::call('Origin.Associate',array($originId,$origins));
        }
        if (!empty($prefixes)) {
            $result = Streamwide_Web_Model::call('Origin.AddPrefix',array($originId,$prefixes));
        }
        return $originId;
    }

    /**
     *
     * NodeOutputs = array(
     *      array(
     *          Label
     *          OriginId
     *          Origins
     *          Prefixes
     *      )
     * )
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::create($request);
        $nodeOutputs = array(
            array(
                'NodeId' => $node['NodeId'],
                'Label' => self::NODE_OUTPUT_LABEL_OTHERS,
                'IsActive' => true,
                'IsDefault' => true,
                'IsAllowed' => true
            )
        );
        $outputs = $request->getParam('NodeOutputs');
        foreach ($outputs as $output)
        {
            $originId = is_null($output['OriginId']) ? $this->_getOrigin($output['Origins'],$output['Prefixes'],$request) : $output['OriginId'];
            $nodeOutputs[] = array(
                'NodeId' => $node['NodeId'],
                'Label' => $output['Label'],
                'IsActive' => true,
                'IsDefault' => false,
                'IsAllowed' => true,
                'OriginId' => $originId
            );
        }
        $nodeOutputs = $this->addOutputs($nodeOutputs);
        $node['NodeOutputs'] = $nodeOutputs;

        return $node;
    }

    /**
     *
     */
    public function check(Zend_Controller_Request_Abstract $request)
    {
        $outputs = $request->getParam('NodeOutputs');
        foreach ($outputs as $output) {
            if (!is_null($output['NodeOutputId']) && !is_null($output['NextNodeId']) && is_null($output['NodeId'])) {
                return false;
            }
        }
        return true;
    }

    /**
     *
     */
    public function updateOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("origin node update output");
        $result = parent::updateOutput($nodeOutput);
        if (!is_null($nodeOutput['OriginId'])) {
            $nodeParameter = array(
                'NodeOutputId' => $nodeOutput['NodeOutputId'],
                'OriginId' => $nodeOutput['OriginId']
            );
            $result = Streamwide_Web_Model::call('Origin.UpdateNodeParameterByNodeOutput',array($nodeParameter));
        }
        return $result;
    }

    /**
     *
     */
    public function addOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("origin node add output");
        $nodeOutput = parent::addOutput($nodeOutput);
        if (!is_null($nodeOutput['OriginId'])) {
            $nodeParameter = array(
                'NodeId' => $nodeOutput['NodeId'],
                'NodeOutputId' => $nodeOutput['NodeOutputId'],
                'OriginId' => $nodeOutput['OriginId']
            );
            $nodeParameterId = Streamwide_Web_Model::call('Origin.AddNodeParameter',array($nodeParameter));
            $nodeOutput['NodeParamOriginId'] = $nodeParameterId;
        }
        return $nodeOutput;
    }

    /**
     *
     */
    public function deleteOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("origin node delete output");
        $nodeOutputId = $nodeOutput['NodeOutputId'];
        $result = Streamwide_Web_Model::call('Origin.RemoveNodeParameterByNodeOutput',array($nodeOutputId));
        parent::deleteOutput($nodeOutput);
        return $result;
    }

    /**
     *
     * NodeOutputs = array(
     *      array(
     *          NodeOutputId
     *          NodeId
     *          NextNodeId
     *          Label
     *          IsDefault
     *          IsActive
     *          IsAllowed
     *          OriginId
     *          Origins
     *          Prefixes
     *      )
     * )
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);
        $outputs = $request->getParam('NodeOutputs');
        foreach ($outputs as &$output) {
            if (is_null($output['OriginId']) && (!is_null($output['Origins']) || !is_null($output['Prefixes']))) {
                $output['OriginId'] = $this->_getOrigin($output['Origins'],$output['Prefixes'],$request);
            }
        }
        
        $this->updateOutputs($outputs);

        return $node;
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        $customerAccountId = $request->getParam('CustomerAccountId');
        $customerOrigins = Streamwide_Web_Model::call('Origin.GetByCustomer',array($customerAccountId));
        $standardOrigins = Streamwide_Web_Model::call('Origin.GetByCustomer',array(null));
        return array(
            'CustomerOrigins' => $customerOrigins,
            'StandardOrigins' => $standardOrigins
        );
    }

    /**
     *
     */
    public function getParameters(Zend_Controller_Request_Abstract $request)
    {
        $nodeId = $request->getParam('NodeId');
        Streamwide_Web_Log::debug("get " . $this->_type . " node parameters by node id $nodeId");

        $node = Streamwide_Web_Model::call('Node.GetById',array($nodeId));
        $nodeParameters = Streamwide_Web_Model::call('Origin.GetNodeParameters',array($nodeId));

        return array(
            'Node' => $node,
            'NodeParameters' => $nodeParameters
        );
    }
}
/*EOF*/
