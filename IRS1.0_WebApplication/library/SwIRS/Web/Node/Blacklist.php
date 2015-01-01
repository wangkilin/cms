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
 * @version    $Id: Blacklist.php 2670 2010-06-23 13:44:30Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Blacklist extends SwIRS_Web_Node_Abstract
{
    const NODE_OUTPUT_LABEL_YES = 'In the blacklist';
    const NODE_OUTPUT_LABEL_NOT = 'Not in the blacklist';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::BLACKLIST);
    }

    /**
     *
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::create($request);
        $nodeOutputs = array(
            array(
                'NodeId' => $node['NodeId'],
                'Label' => self::NODE_OUTPUT_LABEL_YES,
                'IsActive' => true,
                'IsDefault' => false,
                'IsAllowed' => true
            ),
            array(
                'NodeId' => $node['NodeId'],
                'Label' => self::NODE_OUTPUT_LABEL_NOT,
                'IsActive' => true,
                'IsDefault' => true,
                'IsAllowed' => true
            )
         );
        $nodeOutputs = $this->addOutputs($nodeOutputs);
        $node['NodeOutputs'] = $nodeOutputs;

        $defaults = array(
            'NodeId' => $node['NodeId'],
            'HasPayphoneFilter' => false,
            'PayphoneRejectionPromptId' => null,
            'BlacklistId' => null,
            'BlacklistRejectionPromptId' => null
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        $nodeParameterId = Streamwide_Web_Model::call('Blacklist.AddNodeParameter',array($nodeParameter));
        $node['NodeParamBlacklistId'] = $nodeParameterId;
        return $node;
    }

    /**
     *
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);
        $defaults = array(
            'NodeParamBlacklistId' => null,
            'HasPayphoneFilter' => null,
            'PayphoneRejectionPromptId' => null,
            'BlacklistId' => null,
            'BlacklistRejectionPromptId' => null
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        if (count($nodeParameter) > 1) {
            $result = Streamwide_Web_Model::call('Blacklist.UpdateNodeParameter',array($nodeParameter));
        }
        return $node;
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        $customerPrompts = array();
        $blacklists = array();
        if (!SwIRS_Web_Request::isSuperAdmin($request)) {
            $customerAccountId = $request->getParam('CustomerAccountId');
            $customerPrompts = Streamwide_Web_Model::call('Prompt.GetByCustomer',array($customerAccountId));
            $blacklists = Streamwide_Web_Model::call('Blacklist.GetByCustomer',array($customerAccountId));
        }
        $standardPrompts = Streamwide_Web_Model::call('Prompt.GetByCustomer',array(null));
        return array(
            'CustomerPrompts' => $customerPrompts,
            'StandardPrompts' => $standardPrompts,
            'Blacklists' => $blacklists
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
        $nodeParameter = Streamwide_Web_Model::call('Blacklist.GetNodeParameter',array($nodeId));
        $nodeOutputs = $node['NodeOutputs'];

        return array(
            'Node' => $node,
            'NodeParameter' => $nodeParameter,
            'NodeOutputs' => $nodeOutputs
        );
    }
}
/*EOF*/
