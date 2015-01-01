<?php
/**
 * $Rev: 2664 $
 * $LastChangedDate: 2010-06-23 18:04:19 +0800 (Wed, 23 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   library
 * @subpackage node
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.com>
 * @version    $Id: Destination.php 2664 2010-06-23 10:04:19Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Destination extends SwIRS_Web_Node_Abstract
{
    const NODE_OUTPUT_LABEL_SUCCESSFUL = 'success';
    const NODE_OUTPUT_LABEL_NO_ANSWER = 'no answer';
    const NODE_OUTPUT_LABEL_UNREACHABLE = 'unreachable';

    const NODE_OUTPUT_LABEL_BUSY = 'busy';
    const NODE_OUTPUT_LABEL_OVERLOAD = 'overload';
    const NODE_OUTPUT_LABEL_QUEUE_LENGTH = 'queue length exceeded';
    const NODE_OUTPUT_LABEL_QUEUE_TIME = 'queue waiting time exceeded';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::OUTGOING);
    }

    /**
     *
     */
    public function create(Zend_Controller_Request_Abstract $request)
    { 
        $node = parent::create($request);
        $nodeOutputs = $request->getParam('NodeOutputs');
        $nodeOutputs = $this->addOutputs($nodeOutputs);
        $node['NodeOutputs'] = $nodeOutputs;

        $defaults = array(
            'NodeId' => $node['NodeId'],
            'DestinationTypeId' => null,
            'ContactId' => null,
            'IsAgentGroupAllowed' => false,
            'AgentGroupId' => null,
            'IsFailoverAllowed' => false,
            'RingingDuration' => 30,
            'IsWaitingQueueAllowed' => false,
            'IsSimutaneousCallAllowed' => false
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        if ($nodeParameter['IsWaitingQueueAllowed']) {
            $waitingQueueDefaults = array(
                'HasWaitingQueue' => true,
                'QueueGreetingPromptId' => null,
                'QueuePeriodicPromptId' => null,
                'QueueMaxLength' => 10,
                'QueueMaxWaitingTime' => 600,
                'QueueHasPositionPrompt' => false,
                'QueueMaxPositionPrompt' => 10
            );
            $waitingQueue = SwIRS_Web_Request::getParam($request,$waitingQueueDefaults);
            $nodeParameter['WaitingQueue'] = $waitingQueue;
        }
        if ($nodeParameter['IsSimutaneousCallAllowed']) {
            $simutaneousCallDefaults = array(
                'HasSimutaneousCalls' => true,
                'MaxSimutaneousCalls' => 10
            );
            $simutaneousCall = SwIRS_Web_Request::getParam($request,$simutaneousCallDefaults);
            $nodeParameter['SimutaneousCall'] = $simutaneousCall;
        }
        $nodeParameterId = Streamwide_Web_Model::call('Outgoing.AddNodeParameter',array($nodeParameter));
        if ($nodeParameter['IsFailoverAllowed']) {
            $failoverContacts = $request->getParam('FailoverContacts');
            $result = Streamwide_Web_Model::call('Outgoing.AddFailoverContacts',array($nodeParameterId,$failoverContacts));
        }
        $node['NodeParamOutgoingId'] = $nodeParameterId;
        return $node; 
    }

    /**
     *
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);

        $outputs = $request->getParam('NodeOutputs');
        $this->updateOutputs($outputs);

        $defaults = array(
            'NodeParamOutgoingId' => null,
            'DestinationTypeId' => null,
            'ContactId' => null,
            'IsAgentGroupAllowed' => false,
            'AgentGroupId' => null,
            'IsFailoverAllowed' => false,
            'RingingDuration' => null,
            'IsWaitingQueueAllowed' => false,
            'IsSimutaneousCallAllowed' => false
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        if ($nodeParameter['IsWaitingQueueAllowed']) {
            $waitingQueueDefaults = array(
                'HasWaitingQueue' => null,
                'QueueGreetingPromptId' => null,
                'QueuePeriodicPromptId' => null,
                'QueueMaxLength' => null,
                'QueueMaxWaitingTime' => null,
                'QueueHasPositionPrompt' => null,
                'QueueMaxPositionPrompt' => null
            );
            $waitingQueue = SwIRS_Web_Request::getParam($request,$waitingQueueDefaults);
            $nodeParameter['WaitingQueue'] = $waitingQueue;
        }
        if ($nodeParameter['IsSimutaneousCallAllowed']) {
            $simutaneousCallDefaults = array(
                'HasSimutaneousCalls' => null,
                'MaxSimutaneousCalls' => null
            );
            $simutaneousCall = SwIRS_Web_Request::getParam($request,$simutaneousCallDefaults);
            $nodeParameter['SimutaneousCall'] = $simutaneousCall;
        }

        $result = Streamwide_Web_Model::call('Outgoing.UpdateNodeParameter',array($nodeParameter));
        return $node;
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        $customerPrompts = array();
        $agentGroups = array();
        $contacts = array();
        if (!SwIRS_Web_Request::isSuperAdmin($request)) {
            $customerAccountId = $request->getParam('CustomerAccountId');
            $customerPrompts = Streamwide_Web_Model::call('Prompt.GetByCustomer',array($customerAccountId));
            $agentGroups = Streamwide_Web_Model::call('Agentgroup.GetByCustomer',array($customerAccountId));
            $contacts = Streamwide_Web_Model::call('Contact.GetByCustomer',array($customerAccountId));
        }
        $standardPrompts = Streamwide_Web_Model::call('Prompt.GetByCustomer',array(null));
        $destinationTypes = Streamwide_Web_Model::call('Outgoing.GetDestinationTypes',array());
        return array(
            'CustomerPrompts' => $customerPrompts,
            'StandardPrompts' => $standardPrompts,
            'DestinationTypes' => $destinationTypes,
            'AgentGroups' => $agentGroups,
            'Contacts' => $contacts
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
        $nodeParameter = Streamwide_Web_Model::call('Outgoing.GetNodeParameter',array($nodeId));
        $failoverContacts = Streamwide_Web_Model::call('Outgoing.GetFailoverContacts',array($nodeParameter['NodeParamOutgoingId']));

        return array(
            'Node' => $node,
            'NodeParameter' => $nodeParameter,
            'FailoverContacts' => $failoverContacts
        );
    }
}
/*EOF*/
