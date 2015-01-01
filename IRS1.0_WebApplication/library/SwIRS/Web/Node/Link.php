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
 * @version    $Id: Link.php 2651 2010-06-22 15:09:28Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Link extends SwIRS_Web_Node_Abstract
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::LINK);
    }

    /**
     *
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::create($request);
        $linkedNodeId = $request->getParam('LinkedNodeId');
        $isInternal = $request->getParam('IsInternal',false);
        $nodeParameter = array(
            'NodeId' => $node['NodeId'],
            'LinkedNodeId' => $linkedNodeId,
            'IsInternal' => $isInternal
        );

        $nodeParameterId = Streamwide_Web_Model::call('Link.AddNodeParameter',array($nodeParameter));
        $node['NodeParamLinkId'] = $nodeParameterId;
        return $node;
    }

    /**
     *
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);
        $defaults = array(
            'NodeParamLinkId' => null,
            'LinkedNodeId' => null,
            'IsInternal' => null
        );
        $nodeParameter = SwIRS_Web_Request::getParam($request,$defaults);
        if (count($nodeParameter) > 1) {
            $result = Streamwide_Web_Model::call('Link.UpdateNodeParameter',array($nodeParameter));
        }
        return $node;
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        $treeId = $request->getParam('TreeId');
        $nodes = Streamwide_Web_Model::call('Tree.GetNodes', array($treeId));
        $subtrees = Streamwide_Web_Model::call('Tree.GetSubTrees', array($treeId));
        return array(
            'Nodes' => $nodes,
            'SubTrees' => $subtrees
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
        $nodeParameter = Streamwide_Web_Model::call('Link.GetNodeParameter',array($nodeId));

        return array(
            'Node' => $node,
            'NodeParameter' => $nodeParameter
        );
    }
}
/*EOF*/
