<?php
/**
 * $Rev: 2668 $
 * $LastChangedDate: 2010-06-23 18:50:16 +0800 (Wed, 23 Jun 2010) $
 * $LastChangedBy: zwang $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: OriginController.php 2668 2010-06-23 10:50:16Z zwang $
 */

/**
 *
 */
class OriginController extends Zend_Controller_Action
{
    /**
     *
     */
    public function init()
    {
        // disable layout for ajax
        if ($this->_request->isXmlHttpRequest()) {
            $this->view->layout()->disableLayout();
        }
        $request = $this->getRequest();
        if (SwIRS_Web_Request::isSuperAdmin($request)) {
            $request->setParam('CustomerAccountId',null); // global resource has customer account id null
        }
    }

    /**
     *
     */
    public function indexAction()
    {
    	$this->listAction();
    }

    /**
     * remove an origin
     */
    public function removeAction()
    {
    	$request = $this->_request;
    	$Act = $request->getParam('act');
        $OriginId  = $request->getParam('id');
        $OriginName= $request->getParam('OriginName', '');
    	if('delete' == $Act) {
    		$OriginIds = $request->getParam('action_list');

    		$isBatch = $OriginId > 0 ? false : true;
    		$OriginIds = $isBatch ? $OriginIds : array($OriginId);

    		foreach($OriginIds as $originId) {
    			Streamwide_Web_Model::call('Origin.Delete', array($originId)); // do remove origin
    		}

    		$this->view->assign(array(
    		        'IsBatch' => $isBatch,
    		        'OriginName' => $OriginName
    		    )
    		);
    		$this->getHelper('viewRenderer')->direct('remove-ack'); // render ack page
    	} else {
    		$this->view->assign(array(
    		        'IsBatch' => $isBatch,
                    'OriginName' => $OriginName
    		    )
    		);
    	}
    }

    /**
     * edit origin
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        // get parameters
        $CustomerUserId = $request->getParam('CustomerUserId');
        $CustomerAccountId = $request->getParam('CustomerAccountId');
        $OriginId = $request->getParam('id');
        $Act = $request->getParam('act');

        if ('edit' == $Act) { // actual update
        	$OriginName = $request->getParam('Label');
            $OriginGroupId = $request->getParam('OriginGroupId');
            $params = array($OriginId, $OriginName);

            if ($OriginGroupId) {
                $params[2] = $OriginGroupId;
            }
            // do update
            Streamwide_Web_Model::call('Origin.Update', $params);
            //retrive origin
            $origin = Streamwide_Web_Model::call('Origin.GetById', array($OriginId));
            $this->view->assign('Origin', $origin);
            // render ack page
            $this->getHelper('viewRenderer')->direct('update-ack');
		} else {
            $originGroups  = Streamwide_Web_Model::call('Origin.GetGroups', array());// get origin groups
            $systemOrigins = Streamwide_Web_Model::call('Origin.GetByCustomer', array());// get system origins
            $userOrigins   = Streamwide_Web_Model::call('Origin.GetAssociated', array($OriginId));// get associated origins
            $prefixes      = Streamwide_Web_Model::call('Origin.GetPrefix', array($OriginId));// get prefixes
        	$origin = Streamwide_Web_Model::call('Origin.GetById', array($OriginId)); //  get origin
            $this->view->assign(array(
                'CustomerUserId'    => $CustomerUserId,
                'CustomerAccountId' => $CustomerAccountId,
                'OriginGroups'      => $originGroups,
                'SystemOrigins'     => $systemOrigins,
                'UserOrigins'       => $userOrigins,
                'Prefixes'          => $prefixes,
                'Origin'            => $origin,
                )
            );
        }
    }

    /**
     * create an origin
     */
    public function createAction()
    {
    	$request = $this->getRequest();
    	$Act = $request->getParam('act');
    	$CustomerUserId = $request->getParam('CustomerUserId');
	    $CustomerAccountId = $request->getParam('CustomerAccountId');

    	//actual create an origin
    	if ('create' == $Act) {
    		$OriginName = $request->getParam('Label');
    		$OriginGroupId = $request->getParam('OriginGroupId');
    		$OriginIds = $request->getParam('OriginIds'); //return origin id array
            $Prefixes = $request->getParam('Prefixes'); // return array
	    	//compose params
	    	$params = array(
	    		'OriginName'        => $OriginName,
	    		'CustomerUserId'    => $CustomerUserId,
	    		'CustomerAccountId' => $CustomerAccountId,
	    		'Automatic'         => false,
	    	);
	    	if ($OriginGroupId) {
	    	    $params['OriginGroupId'] = $OriginGroupId;
	    	}

	    	$originId = Streamwide_Web_Model::call('Origin.Create', array($params));//create origin

            if (is_array($OriginIds) && count($OriginIds)) {
                Streamwide_Web_Model::call('Origin.Associate', array($originId, $OriginIds));
            }

            if (is_array($Prefixes) && count($Prefixes)) {
                Streamwide_Web_Model::call('Origin.AddPrefix', array($originId, $Prefixes));
            }

	    	$this->view->assign(array(
            	'CustomerAccountId' => $CustomerAccountId,
                'CustomerUserId' => $CustomerUserId
             	)
            );

	    	$this->getHelper('viewRenderer')->direct('create-ack'); //render ack page

    	} else {
    		$originGroups  = Streamwide_Web_Model::call('Origin.GetGroups', array());// get origin groups
    		$systemOrigins = Streamwide_Web_Model::call('Origin.GetByCustomer', array());// get system origins
    		$this->view->assign(array(
    			'CustomerUserId'    => $CustomerUserId,
	    		'CustomerAccountId' => $CustomerAccountId,
    		    'OriginGroups'      => $originGroups,
    		    'SystemOrigins'      => $systemOrigins
    			)
    		);
    	}

    }

    /**
     * list origin
     */
    public function listAction()
    {
    	//get params
        $request = $this->_request;
        $CustomerAccountId = $request->getParam('CustomerAccountId');
        $keyWord = trim($this->_request->getParam('ResourceKeyWord'));
        $currentPage = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $itemsPerPage = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);


        if (strlen($keyWord)) {
        	//compose params
        	$params = array(
        		$CustomerAccountId,
        		$keyWord,
        		$currentPage,
        		$itemsPerPage
        	);
        	$count = Streamwide_Web_Model::call('Origin.Count', array($CustomerAccountId, $keyWord));
            $origin = Streamwide_Web_Model::call('Origin.GetByNamePart', $params);
        } else {
            $params = array(
        		$CustomerAccountId,
        		$currentPage,
        		$itemsPerPage
        	);
        	$count = Streamwide_Web_Model::call('Origin.Count', array($CustomerAccountId));
            $origin = Streamwide_Web_Model::call('Origin.GetByCustomer', $params);
        }

        $this->view->assign(array(
                'Origins' => $origin,
                'CurrentPage' => $currentPage,
                'ItemsPerPage' => $itemsPerPage,
                'ResourceKeyWord' => $keyWord,
                'ItemsTotal'      => $count
            )
        );
    }

    /**
     * Associate origins to an origin.
     */
    public function associateAction()
    {
    	$request = $this->getRequest();
    	$OriginId = $request->getParam('OriginId');
    	$OriginIds = $request->getParam('NewOriginIds'); //return origin id array
        $Act    = $request->getParam('act');
        if ('associate' == $Act) {
            foreach($OriginIds as $key=>$value) {
                $OriginIds[$key] = intval($value);
            }
            $_tmpOrigins = Streamwide_Web_Model::call('Origin.GetAssociated', array($OriginId));
            foreach($_tmpOrigins as $_origin) {
                $key = array_search($_origin['OriginId'], $OriginIds);
                if(false!==$key) {
                    unset($OriginIds[$key]);
                }
            }
            Streamwide_Web_Model::call('Origin.Associate', array($OriginId, $OriginIds));
            $this->view->assign('Action', 'associate');
            $this->getHelper('viewRenderer')->direct('action-ack'); //render ack page
        } else {
            $this->getHelper('viewRenderer')->setNoRender(); // never be here
        }

    }

	/**
     * Add new prefix(es) to an origin.
     */
    public function addprefixAction()
    {
    	$request = $this->getRequest();
    	$OriginId = $request->getParam('OriginId');
    	$Prefixes = $request->getParam('PrefixPhoneNumber'); // return array
    	if (is_string($Prefixes)) {
    		$Prefixes = array($Prefixes);
    	}
    	$Act    = $request->getParam('act');
    	if ('add' == $Act) {
    	    Streamwide_Web_Model::call('Origin.AddPrefix', array($OriginId, $Prefixes));
            $this->view->assign('Action', 'addPrefix');
    	    $this->getHelper('viewRenderer')->direct('action-ack'); //render ack page
    	} else {
    		$this->getHelper('viewRenderer')->setNoRender(); // never be here
    	}
    }

    /**
     * remove origin/prefix from user origin
     */
    public function removeitemAction()
    {
    	$request = $this->getRequest();
        $OriginId = $request->getParam('OriginId');
        $Prefixes = $request->getParam('RemovePrefixes'); // return array
        $Origins  = $request->getParam('RemoveOriginIds'); // return array
        $Act    = $request->getParam('act');
        if ('removeitem' == $Act) {
        	if (is_array($Prefixes)) {
        	    foreach($Prefixes as $key=>$value) {
        	        $Prefixes[$key] = intval($value);
        	    }
                Streamwide_Web_Model::call('Origin.RemovePrefix', array($Prefixes));
        	}
        	if (is_array($Origins)) {
                foreach($Origins as $key=>$value) {
                    $Origins[$key] = intval($value);
                }
        		Streamwide_Web_Model::call('Origin.UnAssociate', array($OriginId, $Origins));
        	}
            $this->view->assign('Action', 'removeitem');
            $this->getHelper('viewRenderer')->direct('action-ack'); //render ack page
        } else {
            $this->getHelper('viewRenderer')->setNoRender(); // never be here
        }
    }

    /**
     * Create a new origin group.
     */
    public function addgroupAction()
    {
    	$request = $this->getRequest();
    	$OriginGroupName = $this->getParam('OriginGroupName');
    	$OriginGroupId = Streamwide_Web_Model::call('Origin.AddGroup', array($OriginGroupName));

    	$this->view->assign('OriginGroupId', $OriginGroupId);
    }

    /**
     * Remove a group.
     */
    public function removegroupAction()
    {
    	$request = $this->getRequest();
    	$OriginGroupId = $this->getParam('OriginGroupId');

    	Streamwide_Web_Model::call('Origin.RemoveGroup', array($OriginGroupId));
    }

    /**
     * Update a new group.
     */
    public function editgroupAction()
    {
    	$request = $this->getRequest();
    	$OriginGroupId = $this->getParam('OriginGroupId');
    	$OriginGroupName = $this->getParam('OriginGroupName');

    	Streamwide_Web_Model::call('Origin.UpdateGroup', array($OriginGroupId, $OriginGroupName));
    }
}

/* EOF */
