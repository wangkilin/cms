<?php
/**
 * $Rev: 2632 $
 * $LastChangedDate: 2010-06-22 10:47:35 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: NodeController.php 2632 2010-06-22 02:47:35Z kwu $
 */

/**
 *
 */
class NodeController extends Zend_Controller_Action
{
    private $_node = null;

    /**
     *
     */
    public function init()
    {
        // Always disabled the layout
        $this->getHelper('Layout')->disableLayout();
        $request = $this->getRequest();
        $type = ucfirst(strtolower($request->getParam('Type')));
        $node = "SwIRS_Web_Node_$type";
        if (class_exists($node)) {
            $this->_node = new $node();
        }
    }

    /**
     *
     */
    public function createAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            Streamwide_Web_Log::debug('create node actual');
            $node = $this->_node->create($request);
            $this->view->assign($node);
            $this->getHelper('ViewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug('create node modal window');
            $modal = $this->_node->getModalWindowData($request);
            $this->view->assign($modal);
            $phtml = $this->_node->getPhtml();
            $this->getHelper('ViewRenderer')->direct($phtml);
        }
    }

    /**
     *
     */
    public function updateAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            Streamwide_Web_Log::debug('update node actual');
            $affirmative = $request->getParam('Affirmative',false);
            if (true == $affirmative || true == $this->_node->check($request)) {
                $node = $this->_node->update($request);
                $this->view->assign($node);
                $this->getHelper('ViewRenderer')->direct('update-ack');
            } else {
                $this->getHelper('ViewRenderer')->direct('update-nack');
            }
        } else {
            Streamwide_Web_Log::debug('update node modal window');
            $modal = $this->_node->getModalWindowData($request);
            $this->view->assign($modal);

            $nodeParameters = $this->_node->getParameters($request);
            $this->view->assign($nodeParameters);

            $phtml = $this->_node->getPhtml();
            $this->getHelper('ViewRenderer')->direct($phtml);
        }
    }

    /**
     *
     */
    public function deleteAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            Streamwide_Web_Log::debug('delete node actual');
            $this->_node->delete($request);
            $this->getHelper('ViewRenderer')->direct('delete-ack');
        } else {
            Streamwide_Web_Log::debug('delete node modal window');
        }
    }

    /**
     *
     */
    public function nextAction()
    {
        $request = $this->getRequest();
        $nodeOutputId = $request->getParam('NodeOutputId');
        $nextNodeId = $request->getParam('NextNodeId');
        $nodeOutput = array(
            'NodeOutputId' => $nodeOutputId,
            'NextNodeId' => $nextNodeId
        );
        $result = Streamwide_Web_Model::call('NodeOutput.Update',array($nodeOutput));
        Streamwide_Web_Log::debug("assign node $nextNodeId as the next of the node output $nodeOutputId");
    }
}
/* EOF */
