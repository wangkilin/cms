<?php
/**
 * $Rev: 2651 $
 * $LastChangedDate: 2010-06-22 23:09:28 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   library
 * @subpackage node
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.com>
 * @version    $Id: Hangup.php 2651 2010-06-22 15:09:28Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Hangup extends SwIRS_Web_Node_Abstract
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::HANGUP);
    }

    /**
     *
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::create($request);
        $releaseCauseId = $request->getParam('ReleaseCauseId');
        $nodeParameter = array(
            'NodeId' => $node['NodeId'],
            'ReleaseCauseId' => $releaseCauseId
        );

        $nodeParameterId = Streamwide_Web_Model::call('Hangup.AddNodeParameter',array($nodeParameter));
        $node['NodeParamHangupId'] = $nodeParameterId;
        return $node;
    }

    /**
     *
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);
        $defaults = array(
            'NodeParamHangupId' => null,
            'ReleaseCauseId' => null
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        if (count($nodeParameter) > 1) {
            $result = Streamwide_Web_Model::call('Hangup.UpdateNodeParameter',array($nodeParameter));
        }
        return $node;
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        $releaseCauses = Streamwide_Web_Model::call('Hangup.GetReleaseCauses', array());
        return array(
            'ReleaseCauses' => $releaseCauses
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
        $nodeParameter = Streamwide_Web_Model::call('Hangup.GetNodeParameter',array($nodeId));

        return array(
            'Node' => $node,
            'NodeParameter' => $nodeParameter
        );
    }
}
/*EOF*/
