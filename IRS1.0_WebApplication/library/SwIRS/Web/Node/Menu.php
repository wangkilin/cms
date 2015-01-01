<?php
/**
 * $Rev: 2671 $
 * $LastChangedDate: 2010-06-24 09:45:18 +0800 (Thu, 24 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   library
 * @subpackage node
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.com>
 * @version    $Id: Menu.php 2671 2010-06-24 01:45:18Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Menu extends SwIRS_Web_Node_Abstract
{
    const NODE_OUTPUT_LABEL_ERROR = 'Error Output';

    private static $_dtmfKeys = array(
        'DTMF 0',
        'DTMF 1',
        'DTMF 2',
        'DTMF 3',
        'DTMF 4',
        'DTMF 5',
        'DTMF 6',
        'DTMF 7',
        'DTMF 8',
        'DTMF 9',
        'Hash' => 'DTMF #',
        'Star' => 'DTMF *',
        'Error' => self::NODE_OUTPUT_LABEL_ERROR
    );

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::MENU);
    }

    /**
     *
     * NodeOutputs = array(
     *      array (
     *          Label
     *      )
     * )
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::create($request);
        $nodeOutputs = array(
            array(
                'NodeId' => $node['NodeId'],
                'Label' => self::NODE_OUTPUT_LABEL_ERROR,
                'IsActive' => true,
                'IsDefault' => true,
                'IsAllowed' => true
            )
        );
        $outputs = $request->getParam('NodeOutputs', array());
        foreach ($outputs as $key => $output) {
            $nodeOutputs[] = array(
                'NodeId' => $node['NodeId'],
                'Label' => self::$_dtmfKeys[$key],
                'IsActive' => true,
                'IsDefault' => false,
                'IsAllowed' => true
            );
        }
        $nodeOutputs = $this->addOutputs($nodeOutputs);
        $node['NodeOutputs'] = $this->_shuffle($nodeOutputs);

        $defaults = array(
            'NodeId' => $node['NodeId'],
            'MaxTries' => 3,
            'NoinputTimeout' => 5,
            'DetectDtmfOnPrompt' => false,
            'GreetingPromptId' => null,
            'NoinputPromptId' => null,
            'WrongKeyPromptId' => null
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        $nodeParameterId = Streamwide_Web_Model::call('Menu.AddNodeParameter',array($nodeParameter));
        $node['NodeParamMenuId'] = $nodeParameterId;
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
     * NodeOutputs = array(
     *      array(
     *          NodeOutputId
     *          NodeId
     *          NextNodeId
     *          Label
     *          IsDefault
     *          IsActive
     *          IsAllowed
     *      )
     * )
     *
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);

        $outputs = $request->getParam('NodeOutputs');
        $this->updateOutputs($outputs);

        $defaults = array(
            'NodeParamMenuId' => null,
            'MaxTries' => null,
            'NoinputTimeout' => null,
            'DetectDtmfOnPrompt' => null,
            'GreetingPromptId' => null,
            'NoinputPromptId' => null,
            'WrongKeyPromptId' => null
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        if (count($nodeParameter) > 1) {
            $result = Streamwide_Web_Model::call('Menu.UpdateNodeParameter',array($nodeParameter));
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
        $nodeParameter = Streamwide_Web_Model::call('Menu.GetNodeParameter',array($nodeId));
        $nodeOutputs = $node['NodeOutputs'];
        $nodeOutputs = $this->_shuffle($nodeOutputs);

        return array(
            'Node' => $node,
            'NodeParameter' => $nodeParameter,
            'NodeOutputs' => $nodeOutputs
        );
    }

    /**
     * To get the public dtmf keys
     *
     * @return array        The public dtmf keys list
     */
    public static function getDtmfKeys()
    {
        return self::$_dtmfKeys;
    }

    /**
     * To shuffle the NodeOutputs in key/value pattern
     *
     * @param array $outputs The NodeOutputs source list
     *
     * @return array         The NodeOutputs filtered list
     */
    private function _shuffle(array $outputs)
    {
        $shuffled = array();
        foreach($outputs as $output) {
            $key = array_search($output['Label'], self::$_dtmfKeys);
            $shuffled[$key] = $output;
        }
        return $shuffled;
    }
}
/*EOF*/
