<?php
/**
 * $Rev: 2633 $
 * $LastChangedDate: 2010-06-22 11:22:51 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   library
 * @subpackage node
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.com>
 * @version    $Id: Distribution.php 2633 2010-06-22 03:22:51Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Distribution extends SwIRS_Web_Node_Abstract
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::DISTRIBUTION);
    }

    /**
     *
     * NodeOutputs = array(
     *      array (
     *          Label
     *          DistributionTypeId
     *          DistributionRatio
     *      )
     * )
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::create($request);
        $nodeOutputs = $request->getParam('NodeOutputs');
        foreach ($nodeOutputs as &$nodeOutput)
        {
            $nodeOutput['NodeId'] = $node['NodeId'];
            $nodeOutput['IsActive'] = true;
            $nodeOutput['IsDefault'] = false;
            $nodeOutput['IsAllowed'] = true;
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
        Streamwide_Web_Log::debug("distribution node update output");
        $result = parent::updateOutput($nodeOutput);
        if (!is_null($nodeOutput['DistributionTypeId']) || !is_null($nodeOutput['DistributionRatio'])) {
            $nodeParameter = array(
                'NodeOutputId' => $nodeOutput['NodeOutputId'],
                'DistributionTypeId' => $nodeOutput['DisributionTypeId'],
                'DistributionRatio' => $nodeOutput['DisributionRatio']
            );
            $result = Streamwide_Web_Model::call('Distribution.UpdateNodeParameterByNodeOutput',array($nodeParameter));
        }
        return $result;
    }

    /**
     *
     */
    public function addOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("distribution node add output");
        $nodeOutput = parent::addOutput($nodeOutput);
        $nodeParameter = array(
            'NodeId' => $nodeOutput['NodeId'],
            'NodeOutputId' => $nodeOutput['NodeOutputId'],
            'DistributionTypeId' => $nodeOutput['DistributionTypeId'],
            'DistributionRatio' => $nodeOutput['DistributionRatio']
        );
        $nodeParameterId = Streamwide_Web_Model::call('Distribution.AddNodeParameter',array($nodeParameter));
        $nodeOutput['NodeParamDistributionId'] = $nodeParameterId;
        return $nodeOutput;
    }

    /**
     *
     */
    public function deleteOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("distribution node delete output");
        $nodeOutputId = $nodeOutput['NodeOutputId'];
        $result = Streamwide_Web_Model::call('Distribution.RemoveNodeParameterByNodeOutput',array($nodeOutputId));
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
     *          DistributionTypeId
     *          DistributionRatio
     *      )
     * )
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);
        $outputs = $request->getParam('NodeOutputs');
        $this->updateOutputs($outputs);

        return $node;
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        $distributionTypes = Streamwide_Web_Model::call('Distribution.GetTypes',array());
        return array(
            'DistributionTypes' => $distributionTypes
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
        $nodeParameters = Streamwide_Web_Model::call('Distribution.GetNodeParameters',array($nodeId));

        return array(
            'Node' => $node,
            'NodeParameters' => $nodeParameters
        );
    }
}
/*EOF*/
