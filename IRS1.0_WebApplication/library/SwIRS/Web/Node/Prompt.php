<?php
/**
 * $Rev: 2670 $
 * $LastChangedDate: 2010-06-23 21:44:30 +0800 (Wed, 23 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   library
 * @subpackage node
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.com>
 * @version    $Id: Prompt.php 2670 2010-06-23 13:44:30Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Prompt extends SwIRS_Web_Node_Abstract
{
    const NODE_OUTPUT_LABEL = 'Next';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::PROMPT);
    }

    /**
     *
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::create($request);
        $nodeOutputDefault = array(
            'NodeId' => $node['NodeId'],
            'Label' => self::NODE_OUTPUT_LABEL,
            'IsActive' => true,
            'IsDefault' => true,
            'IsAllowed' => true
        );
        $nodeOutput = SwIRS_Web_Request::getParam($request, $nodeOutputDefault);
        $nodeOutput = $this->addOutput($nodeOutput);
        $node['NodeOutput'] = $nodeOutput;

        $promptId = $request->getParam('PromptId');
        $isStandard = $request->getParam('IsStandard',false);
        $nodeParameter = array(
            'NodeId' => $node['NodeId'],
            'PromptId' => $promptId,
            'IsStandard' => $isStandard
        );
        $nodeParameterId = Streamwide_Web_Model::call('Prompt.AddNodeParameter',array($nodeParameter));
        $node['NodeParamPromptId'] = $nodeParameterId;
        return $node;
    }

    /**
     *
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);

        $nodeOutput = $request->getParam('NodeOutput');
        $this->updateOutput($nodeOutput);

        $defaults = array(
            'NodeParamPromptId' => null,
            'PromptId' => null,
            'IsStandard' => null
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        if (count($nodeParameter) > 1) {
            $result = Streamwide_Web_Model::call('Prompt.UpdateNodeParameter',array($nodeParameter));
        }
        return $node;
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        $customerPrompts = array();
        if (!SwIRS_Web_Request::isSuperAdmin($request)) {
            $customerAccountId = $request->getParam('CustomerAccountId');
            $customerPrompts = Streamwide_Web_Model::call('Prompt.GetByCustomer',array($customerAccountId));
        }
        $standardPrompts = Streamwide_Web_Model::call('Prompt.GetByCustomer',array(null));
        return array(
            'CustomerPrompts' => $customerPrompts,
            'StandardPrompts' => $standardPrompts
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
        $nodeParameter = Streamwide_Web_Model::call('Prompt.GetNodeParameter',array($nodeId));
        $nodeOutput = $node['NodeOutputs'][0];

        return array(
            'Node' => $node,
            'NodeParameter' => $nodeParameter,
            'NodeOutput' => $nodeOutput
        );
    }
}
/*EOF*/
