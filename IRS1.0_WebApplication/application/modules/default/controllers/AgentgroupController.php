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
 * @version    $Id: AgentgroupController.php 2668 2010-06-23 10:50:16Z zwang $
 */

/**
 *
 */
class AgentgroupController extends Zend_Controller_Action
{
    const AGENT_PROFILE_ID = 2; // profile id for agent
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
            $request->setParam('CustomerAccountId',1); // global resource has customer account id null
        }
    }

    /**
     * index action.
     * list all agent groups
     */
    public function indexAction()
    {
        $this->listAction();
    }

    /**
     * create agent group
     * Actual create
     * ------------
     * <request>
     * 'act'
     * 'AgentGroupName'
     * 'PostProcessingDuration'
     * 'AgentIds' => array()
     *
     * <view-assign>
     * 'Result'
     * 'AgentsCount' // count by AgentgroupId
     * 'AgentGroupId'
     * 'AgentGroupName'
     *
     * Modal window
     * ------------
     * <request>
     * <view-assign>
     *
     */
    public function createAction()
    {
        $request = $this->_request;
        $customerUserId = $request->getParam('CustomerUserId');
        $customerAccountId = $request->getParam('CustomerAccountId');
        $act = $request->getParam('act');

        if ('create' == $act) {
            // get parameters
            Streamwide_Web_Log::debug('create agentgroup actual');
            $agentGroupName = $request->getParam('AgentGroupName');
            $postProcessingDuration = $request->getParam('PostProcessingDuration');
            $agentIds = $request->getParam('AgentIds');
            // compose parameter
            $params = array(
                'AgentGroupName' => $agentGroupName,
                'PostProcessingDuration' => $postProcessingDuration,
                'CustomerUserId' => $customerUserId,
                'CustomerAccountId' => $customerAccountId
            );

            $agentGroupId = Streamwide_Web_Model::call('AgentGroup.Create', array($params)); // do create
            if(is_array($agentIds) && count($agentIds)) {
                Streamwide_Web_Model::call('AgentGroup.AddAgent', array($agentGroupId, $agentIds));
            }

            $this->view->assign(array(
                'AgentsCount' => count($agentIds),
                'AgentGroupId' => $agentGroupId,
                'AgentGroupName' => $agentGroupName
                )
            );

            $this->getHelper('viewRenderer')->direct('create-ack'); // render ack page

        } else {
            Streamwide_Web_Log::debug('create agentgroup modal window');
         //   $this->view->assign(array());
                 //do not assign anything
        }
    }

    /**
     * list agent groups
     * ------------
     * <request>
     * 'CurrentPage'
     * 'ItemsPerPage'
     * 'KeyWord'
     * <view-assign>
     * 'AgentGroupsList' => array (
     *     array(
     *       'AgentGroupId'
     *       'AgentGroupName'
     *       'AgentCount'
     *     )
     *     ...
     *  )
     * 'CurrentPage'
     * 'ItemsPerPage'
     * 'ItemsTotal'
     * 'KeyWord'
     */
    public function listAction()
    {
        Streamwide_Web_Log::debug('list agentgroups');
        $request = $this->_request;
        $customerAccountId = $request->getParam('CustomerAccountId');
        $keyWord = trim($this->_request->getParam('ResourceKeyWord'));

        $currentPage = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $itemsPerPage = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);

         // total number of admins : got from model
        if (strlen($keyWord)) {
            $params = array($customerAccountId, $keyWord, $currentPage, $itemsPerPage);
            $agentGroupList = Streamwide_Web_Model::call('AgentGroup.GetByName', $params);
        } else {
            $params = array($customerAccountId, $currentPage, $itemsPerPage);
            $agentGroupList = Streamwide_Web_Model::call('AgentGroup.GetByCustomer', $params);
        }
        foreach($agentGroupList as $key => $agentGroup){
            $agentCount = Streamwide_Web_Model::call('AgentGroup.CountAgents', array($agentGroup['AgentGroupId']));
            $agentGroupList[$key]['AgentCount'] = $agentCount;
        }

        $countUnaffectedAgents = Streamwide_Web_Model::call('AgentGroup.CountUnaffectedAgents', array($customerAccountId));
        $countAllAgents = Streamwide_Web_Model::call('AgentGroup.CountAllAgents', array($customerAccountId));

        $this->view->assign(array(
            'AgentGroupList' => $agentGroupList,
            'CurrentPage'  => $currentPage,
            'ItemsPerPage' => $itemsPerPage,
            'ItemsTotal'   => $countAllAgents,
            'KeyWord'      => $keyWord,
            'CountUnaffectedAgents' => $countUnaffectedAgents,
            'CountAllAgents'        => $countAllAgents
            )
        );
    }

    /**
     * edit agent group
     *
     * Actual update
     * ------------
     * <request>
     * 'act'
     * 'AgentGroupId'
     * 'AgentGroupName'
     * 'PostProcessingDuration'
     *
     * <view-assign>
     * 'Result'
     * 'OldAgentGroupName'
     *
     * Modal window
     * ------------
     * <request>
     * 'AgentGroupId'
     * <view-assign>
     * 'AgentGroupId'
     * 'AgentGroupName'
     */
    public function editAction()
    {
        $request = $this->_request;
        $act = $request->getParam('act');

        if ('edit' == $act) { // actual update
            // get parameters
            Streamwide_Web_Log::debug('update agentgroup actual');
            $agentGroupId = $request->getParam('AgentGroupId');
            $agentGroupName = $request->getParam('AgentGroupName');
            $postProcessingDuration = $request->getParam('PostProcessingDuration');

            // compose parameter
            $params = array('AgentGroupId' => intval($agentGroupId),
                            'AgentGroupName' => $agentGroupName,
                            'PostProcessingDuration' => intval($postProcessingDuration)
            );
            $oldAgentGroupInfo = Streamwide_Web_Model::call('AgentGroup.GetById', array($agentGroupId));

            $result = Streamwide_Web_Model::call('AgentGroup.Update', array($params)); // do update

            $oldAgentGroupName = $oldAgentGroupInfo['AgentGroupName'];
            $this->view->assign(array(
                'Result' => $result ,
                'OldAgentGroupName' => $oldAgentGroupName,
                'AgentGroupName' => $agentGroupName,
                'AgentgroupId'   => $agentGroupId
                )
            );

            $this->getHelper('viewRenderer')->direct('edit-ack'); // render ack page

        } else {
            Streamwide_Web_Log::debug('update agentgroup modal window');
            $agentGroupId = $request->getParam('AgentGroupId');
            $agentGroupInfo = Streamwide_Web_Model::call('AgentGroup.GetById', array($agentGroupId));

            $this->view->assign($agentGroupInfo);
        }
    }

    /**
     * Delete agent group action.
     *
     * Actual delete
     * ------------
     * <request>
     * 'act'
     * 'AgentGroupId'
     *
     * <view-assign>
     * 'Result'
     * 'AgentGroupName'
     * 'AgentGroupId'
     *
     * Modal window
     * ------------
     * <request>
     * 'AgentGroupId'
     * <view-assign>
     * 'AgentGroupId'
     * 'AgentGroupName'
     */
    public function removeAction()
    {
        $request = $this->_request;
        $act = $request->getParam('act');
        $agentGroupId = $request->getParam('AgentGroupId');
        $customerAccountId = $request->getParam('CustomerAccountId');
        $agentGroupInfo = Streamwide_Web_Model::call('AgentGroup.GetById', array($agentGroupId));
        $this->view->assign($agentGroupInfo);

        if('remove'==$act) {
            Streamwide_Web_Log::debug('delete agentgroup actual');
            $result = Streamwide_Web_Model::call('AgentGroup.Delete', array($agentGroupId));
            $countUnaffectedAgents = Streamwide_Web_Model::call('AgentGroup.CountUnaffectedAgents', array($customerAccountId));
            $this->view->assign('Result', $result);
            $this->view->assign('CountUnaffectedAgents', $countUnaffectedAgents);

            $this->getHelper('viewRenderer')->direct('remove-ack'); // render ack page
        } else {
            Streamwide_Web_Log::debug('delete agentgroup modal window');
        }
    }

    /**
     * list agents by group id
     *
     * ------------
     * <request>
     * 'AgentGroupId'
     * 'CurrentPage'
     * 'ItemsPerPage'
     * 'KeyWord'
     * <view-assign>
     * 'AgentsList' => array (
     *     array(
     *       'UserId'
     *       'AgentName'
     *       'SupervisorStatus'
     *     )
     *     ...
     *  )
     * 'AgentGroupId'
     * 'CurrentPage'
     * 'ItemsPerPage'
     * 'ItemsTotal'
     * 'KeyWord'
     */
    public function listagentAction()
    {
        Streamwide_Web_Log::debug('list agents');
        $request = $this->_request;
        $customerAccountId = $request->getParam('CustomerAccountId');
        $keyWord = trim($this->_request->getParam('KeyWord'));
        $agentGroupId = $request->getParam('AgentGroupId');

        $currentPage = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $itemsPerPage = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);

         // total number of admins : got from model
        if (strlen($keyWord)) {
            $params = array($agentGroupId, $keyWord, $currentPage, $itemsPerPage);
            $count = count(Streamwide_Web_Model::call('User.GetByName', $params));
            $agentList = Streamwide_Web_Model::call('User.GetByName', $params);
        } else {
            if('0'==$agentGroupId) {
                $params = array($customerAccountId, $currentPage, $itemsPerPage);
                $agentList = Streamwide_Web_Model::call('AgentGroup.GetUnaffectedAgents', $params);
            } else if('-1'==$agentGroupId) {
                $params = array($customerAccountId, $currentPage, $itemsPerPage);
                $agentList = Streamwide_Web_Model::call('AgentGroup.GetAllAgents', $params);
            } else {
                $params = array($agentGroupId, $currentPage, $itemsPerPage);
                $agentList = Streamwide_Web_Model::call('AgentGroup.GetAgents', $params);
            }
            foreach($agentList as $key => $agent){
                $agentList[$key]['AgentName'] = $agent['Name'];
            }
        }

        $this->view->assign(array(
            'AgentList'    => $agentList,
            'AgentGroupId' => $agentGroupId,
            'CurrentPage'  => $currentPage,
            'ItemsPerPage' => $itemsPerPage,
            //'ItemsTotal'   => $count,
            'KeyWord'      => $keyWord
            )
        );
    }

    /**
     * add agent into agent group
     *
     * Actual remove
     * ------------
     * <request>
     * 'act'
     * 'AgentIds' => array()
     * 'AgentGroupId'
     *
     * <view-assign>
     * 'Result'
     * 'AgentsCount' // count by AgentgroupId
     *
     * Modal window
     * ------------
     * <request>
     * 'AgentIds' => array()
     * 'AgentGroupId'
     * <view-assign>
     * 'AgentIds' => array()
     * 'AgentgroupId'
     */
    public function addagentAction()
    {
        $request = $this->_request;
        $customerAccountId = $request->getParam('CustomerAccountId');
        $act = $request->getParam('act');

        if('add' == $act) {
            Streamwide_Web_Log::debug('add agent actual');
            $agentIds = $request->getParam('agentIds');
            foreach($agentIds as $key=>$value) {
                $agentIds[$key] = intval($value);
            }
            $agentGroupId = $request->getParam('AgentGroupId');
            $agentList = Streamwide_Web_Model::call('AgentGroup.GetAgents', array($agentGroupId));
            foreach($agentList as $agent) {
            // find exising agents in group, remove from adding agents list
                $key = array_search($agent['UserId'], $agentIds);
                if(false!==$key) {
                    unset($agentIds[$key]);
                }
            }
            $params = array($agentGroupId, $agentIds);
            $result = Streamwide_Web_Model::call('AgentGroup.AddAgent', $params);

            $countGroupAgents = count(Streamwide_Web_Model::call('AgentGroup.GetAgents', array($agentGroupId)));
            $countUnaffectedAgents = Streamwide_Web_Model::call('AgentGroup.CountUnaffectedAgents', array($customerAccountId));

            $this->view->assign(array(
                'Result'                => $result,
                'CountGroupAgents'      => $countGroupAgents,
                'CountUnaffectedAgents' => $countUnaffectedAgents
                )
            );
            $this->getHelper('viewRenderer')->direct('addagent-ack'); // render ack page
        }
    }

    /**
     * create new agent
     *
     * Actual create
     * ------------
     * <request>
     * 'act'
     * 'AgentName'
     * 'Login'
     * 'Password'
     * 'Email'
     * 'PhoneNumber'
     * 'Status'
     * 'AgentGroupId'
     * 'SupervisorStatus'
     *
     * <view-assign>
     * 'Result'
     * 'AgentsCount' // count by AgentgroupId
     * 'AgentName'
     * 'Email'
     * 'PhoneNumber'
     * 'Status'
     * 'AgentGroupId'
     * 'AgentGroupName'
     * 'SupervisorStatus'
     *
     * Modal window
     * ------------
     * <request>
     * 'AgentGroupId'
     * <view-assign>
     * 'AgentgroupId'
     * 'AgentGroupName'
     */
    public function createagentAction()
    {
        $request = $this->_request;
        $act = $request->getParam('act');
        $customerAccountId = $request->getParam('CustomerAccountId');
        $currentUserId     = $request->getParam('CustomerUserId');// session plugin set it
        if('create' == $act){
            Streamwide_Web_Log::debug('create agent actual');
            $agentName = $request->getParam('AgentName');
            //$login = $request->getParam('Login');
            $password = $request->getParam('Password');
            $email = $request->getParam('Email');
            $phoneNumber = $request->getParam('PhoneNumber');
            $status = $request->getParam('Status');
            $disponibilityTime = $request->getParam('DisponibilityTime');
            $unlimitedDisponibility = $request->getParam('UnlimitedDisponibility');
            $userParams = array(
                'Name'=>$agentName,// string The user name
                'EmailAddress'=>$email,// string The user email address
                'Password'=>$password,// string The user password
                'ProfileId'=>self::AGENT_PROFILE_ID,// int The granted profile for agent user
                'ParentUserId'=> $currentUserId,// int The parent user id
                'CustomerAccountId'=>$customerAccountId,// int The customer account user belongs to
                'AgentParameters'=>array(// struct The agent parameter structure [optional]
                    'PhoneNumber'      =>$phoneNumber,// string The agent phone number
                    'DisponibilityTime'     =>intval($disponibilityTime),// int The disponibility time in seconds
                    'UnlimitedDisponibility'=>(bool)$unlimitedDisponibility,// boolean The flag indicating unlimited disponibility
                )
            );
            $userId = Streamwide_Web_Model::call('User.Create', array($userParams));
            $agentParams = array(
                'AgentId'     => $userId,
                'IsAvailable' => $status,
                'IsOnline'    => false
            );
            Streamwide_Web_Model::call('AgentGroup.SetAgentOptions', array($agentParams));
            $agentGroupIds = $request->getParam('AffectedGroups');
            $supervisorStatus = $request->getParam('SupervisorStatus');
            if (is_array($agentGroupIds) && is_array($supervisorStatus)) {
                $agentGroupIds = array_unique(array_merge($agentGroupdIds, $supervisorStatus));
            } else if (is_array($supervisorStatus)) {
                $agentGroupIds = $supervisorStatus;
            }
            if (is_array($agentGroupIds) && count($agentGroupIds)) {
                foreach ($agentGroupIds as $agentGroupId) {
            		      $params = array($agentGroupId, array($userId));
                    $result = Streamwide_Web_Model::call('AgentGroup.AddAgent', $params);

                    $isSupervisor = in_array($agentGroupId, $supervisorStatus);

                    if($isSupervisor) {
                        Streamwide_Web_Model::call('AgentGroup.SetSupervisor', array($agentGroupId, $userId, $isSupervisor));
                    }
            	}
            }

            $this->view->assign('AgentName', $agentName);
            $this->getHelper('viewRenderer')->direct('createagent-ack'); // render ack page
        } else {
            Streamwide_Web_Log::debug('create agent modal window');
            $agentGroupList = Streamwide_Web_Model::call('AgentGroup.GetByCustomer', array($customerAccountId));
            $this->view->assign('AgentGroupList', $agentGroupList);
        }
    }

    /**
     * edit group
     */
    public function editagentAction()
    {
        $request = $this->_request;
        $act = $request->getParam('act');
        $customerAccountId = $request->getParam('CustomerAccountId');

        if ('edit' == $act) {
            Streamwide_Web_Log::debug('update agentgroup actual');
            $agentId = $request->getParam('AgentId');
            $agentName = $request->getParam('AgentName');
            $password = $request->getParam('Password');
            $email = $request->getParam('Email');
            $phoneNumber = $request->getParam('PhoneNumber');
            $status = $request->getParam('Status');
            $supervisorStatus = $request->getParam('SupervisorStatus');
            $disponibilityTime = $request->getParam('DisponibilityTime');
            $unlimitedDisponibility = $request->getParam('UnlimitedDisponibility');
            $userParams = array(
                'UserId' => $agentId,
                'Name' => $agentName,
                'EmailAddress' => $email,
                'AgentParameters'=>array(// struct The agent parameter structure [optional]
                    'PhoneNumber'      =>$phoneNumber,// string The agent phone number
                    'DisponibilityTime'     =>intval($disponibilityTime),// int The disponibility time in seconds
                    'UnlimitedDisponibility'=>(bool)$unlimitedDisponibility,// boolean The flag indicating unlimited disponibility
                )
            );
            if(strlen($password)) {
                $userParams['Password'] = $password;
            }

            $agentGroupIds = $request->getParam('AffectedGroups');
            $supervisorStatus = $request->getParam('SupervisorStatus');
            if (is_array($agentGroupIds) && is_array($supervisorStatus)) {
                $agentGroupIds = array_unique(array_merge($agentGroupIds, $supervisorStatus));
            } else if (is_array($supervisorStatus)) {
                $agentGroupIds = $supervisorStatus;
            }

            // remove agent from agent group first
            if (!is_array($agentGroupIds)) {
                $agentGroupIds = array();
            }

            $affectedGroups = Streamwide_Web_Model::call('AgentGroup.GetGroupsByAgent', array($agentId));
            $affectedGroupIds = array();
            foreach ($affectedGroups as $affectedGroup) {// remove agent from agent group
                $affectedGroupIds[] = $affectedGroup['AgentgroupId'];
                if (!in_array($affectedGroup['AgentgroupId'], $agentGroupIds)) {
                    Streamwide_Web_Model::call('AgentGroup.RemoveAgent', array($affectedGroup['AgentgroupId'], array($agentId)));
                }
            }


            if (count($agentGroupIds)) {
                foreach ($agentGroupIds as $key => $agentGroupId) {
                	  if (!in_array($agentGroupId, $affectedGroupIds)) {// new group
                        $params = array($agentGroupId, array($agentId));
                        $result = Streamwide_Web_Model::call('AgentGroup.AddAgent', array($params));
                	  } else {// keep the new agent groups
                	      unset($agentGroupIds[$key]);
                	  }

                    $isSupervisor = in_array($agentGroupId, $supervisorStatus);
                    if($isSupervisor) {
                        Streamwide_Web_Model::call('AgentGroup.SetSupervisor', array($agentGroupId, $agentId, $isSupervisor));
                    }
                }
            }

            $result = Streamwide_Web_Model::call('User.Update', array($userParams));
            $agentParams = array(
                'AgentId'     => $agentId,
                'IsAvailable' => $status
            );
            Streamwide_Web_Model::call('AgentGroup.SetAgentOptions', array($agentParams));
            $agentInfo = Streamwide_Web_Model::call('User.GetById', array($agentId));

            $this->view->assign($agentInfo);

            $this->getHelper('viewRenderer')->direct('editagent-ack'); // render ack page
        } else {
            Streamwide_Web_Log::debug('update agent modal window');
            $agentId = $request->getParam('AgentId');
            $agentInfo = Streamwide_Web_Model::call('User.GetById', array($agentId));
            $affectedGroups = Streamwide_Web_Model::call('AgentGroup.GetGroupsByAgent', array($agentId));
            $supervisorGroups = Streamwide_Web_Model::call('AgentGroup.GetGroupsBySupervisor', array($agentId));
            $agentGroups = Streamwide_Web_Model::call('AgentGroup.GetByCustomer', array($customerAccountId));
            //$agentOptions = Streamwide_Web_Model::call('AgentGroup.GetAgentOptions', array($agentId));
            $agentOptions = array(
            'AgentId' => $agentId,//     int The user id
            'OnlineStatus' => true,//    boolean The agent on/off status
            'AvailabilityStatus' => true,//  boolean The agent free/on call/post processing status
            );
            $this->view->assign(array(
                'User' => $agentInfo,
                'AffectedGroups'   => $affectedGroups,
                'SupervisorGroups' => $supervisorGroups ,
                'AgentGroups'      => $agentGroups,
                'AgentOptions'     => $agentOptions
                )
            );
        }

    }

    /**
     * remove agent from agent group
     *
     * Actual remove
     * ------------
     * <request>
     * 'act'
     * 'AgentIds' => array()
     * 'AgentGroupId'
     *
     * <view-assign>
     * 'Result'
     * 'AgentsCount' // count by AgentgroupId
     *
     * Modal window
     * ------------
     * <request>
     * 'AgentIds' => array()
     * 'AgentGroupId'
     * <view-assign>
     * 'AgentInfo' => array( // if only remove ONE agent
     *     'AgentName'
     *     'PhoneNumber'
     *     'Email'
     *     'AffectedGroup' => array(
     *         array(
     *             'AgentgroupId'
     *             'AgentgroupName
     *         )
     *     )
     *     'SupervisorGroup'=> array(
     *         array(
     *             'AgentgroupId'
     *             'AgentgroupName
     *         )
     *     )
     *     'Status'
     * )
     * 'AgentIds' => array()
     * 'AgentgroupId'
     */
    public function removeagentAction()
    {
        $request = $this->_request;
        $act = $request->getParam('act');
        $customerAccountId = $request->getParam('CustomerAccountId');

        if('remove' == $act){
            Streamwide_Web_Log::debug('delete agent actual');
            $agentIds = $request->getParam('agentIds');
            $agentGroupId = $request->getParam('AgentGroupId');
            $params = array($agentGroupId, $agentIds);
            $result = Streamwide_Web_Model::call('AgentGroup.RemoveAgent', $params);

            $countGroupAgents = count(Streamwide_Web_Model::call('AgentGroup.GetAgents', array($agentGroupId)));
            $countUnaffectedAgents = Streamwide_Web_Model::call('AgentGroup.CountUnaffectedAgents', array($customerAccountId));

            $this->view->assign(array(
                'Result'                => $result,
                'CountGroupAgents'      => $countGroupAgents,
                'CountUnaffectedAgents' => $countUnaffectedAgents
            ));

            $this->getHelper('viewRenderer')->direct('removeagent-ack'); // render ack page

        } else {
            Streamwide_Web_Log::debug('delete agent modal window');

            $agentIds = $request->getParam('AgentIds');
            $agentGroupId = $request->getParam('AgentGroupId');
            if(count($agentIds) > 1){
                $this->view->assign(array(
                    'AgentIds' => $agentIds,
                    'AgentGroupId' => $agentGroupId
                ));
            } else {
                $agentInfo = Streamwide_Web_Model::call('User.GetById', array($agentIds));
                $this->view->assing(
                array(
                    'AgentInfo' => $agentInfo,
                    'AgentIds' => $agentIds,
                    'AgentGroupId' => $agentGroupId
                ));
            }
        }
    }

    /**
     * delete agent
     */
    public function deleteagentAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('act');
        $isBatch = $request->getParam('isBatch');
        $agentName = $request->getParam('agentName');

        if('delete' == $act) {
            $agentIds = $request->getParam('agentIds');
            $minusGroups = array();
            foreach($agentIds as $agentId) {
                $groupList = Streamwide_Web_Model::call('AgentGroup.GetGroupsByAgent', array($agentId));
                if(count($groupList)<1) {// not group match
                    $minusGroups[] = '0';
                }
                foreach($groupList as $group) {
                    $minusGroups[] = $group['AgentGroupId'];
                }
                Streamwide_Web_Model::call('User.Delete', array($agentId));
            }
            $this->view->assign(array(
                    'IsBatch' => $isBatch,
                    'AgentName' => $agentName,
                    'MinusAgentGroupList' => $minusGroups
                )
            );

            $this->getHelper('viewRenderer')->direct('deleteagent-ack'); // render ack page
        } else {// model window
            $this->view->assign(array(
                    'IsBatch' => $isBatch,
                    'AgentName' => $agentName
                )
            );
        }
    }

    /**
     * export agent
     */
    public function exportAction()
    {

    }

    /**
     * import agent
     */
    public function importAction()
    {

    }

    /**
     * agent group overview
     */
    public function overviewAction()
    {
        $request = $this->getRequest();
        $agentGroupId = $request->getParam('AgentGroupId');
        $customerAccountId = $request->getParam('CustomerAccountId');
        if (intval($agentGroupId)>0) {
            $agentGroupInfo = Streamwide_Web_Model::call('AgentGroup.GetById', array($agentGroupId));
            $agentGroupInfo['AgentGroupAgentsCount'] =count(Streamwide_Web_Model::call('AgentGroup.GetAgents', array($agentGroupId)));
            $agentGroupInfo['AgentGroupId'] = $agentGroupInfo['AgentGroupId'];

            $this->view->assign($agentGroupInfo);
        } else if ($agentGroupId=='0') {// get unaffected agents
            $agentsCount = Streamwide_Web_Model::call('AgentGroup.CountUnaffectedAgents', array($customerAccountId));

            $this->view->assign(array(
                'AgentGroupAgentsCount' => $agentsCount,
                'AgentGroupId'          => 0
            ));
        } else {
            $agentsCount = Streamwide_Web_Model::call('AgentGroup.CountAllAgents', array($customerAccountId));
            $this->view->assign(array(
                'AgentGroupAgentsCount' => $agentsCount,
                'AgentGroupId'          => -1
            ));
        }
    }

    /**
     * live statistic for agentgroup
     * Actual Statistic
     * --------------
     * <request>
     * Act
     * AgentGroupId
     * AgentNamePart
     * CurrentPage
     * ItemsPerPage
     *
     * <view-assign>
     * Statistics = array(
     *      array(
     *          Name
     *          UserId
     *          OnlineStatus
     *          CallsTaken
     *          AvilabilityStatus
     *          Timestamp
     *      )
     * )
     * Pagination = array(
     *     CurrentPage
     *     ItemsPerPage
     *     ItemsTotal
     * )
     *
     * Modal Window
     * --------------
     * <request>
     * AgentId
     * <view-assign>
     * AgentGroups = array(
     *      array (
     *          AgentGroupId
     *          AgentGroupName
     *      )
     * )
     *
     */
    public function statisticsAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        if ('statistics' == $act) {
            $agentGroupId = $request->getParam('AgentGroupId');
            Streamwide_Web_Log::debug("list agent group $agentGroupId statistics");

            $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
            $pagination['ItemsTotal'] = 0;

            $agentNamePart = $request->getParam('AgentNamePart','');
            $agentNamePart = trim($agentNamePart);
            $statistics = array();
            if (strlen($agentNamePart) > 0) {
                $statistics = Streamwide_Web_Model::call('AgentGroup.GetStatisticsByAgentNamePart',
                    array(
                        $agentGroupId,
                        $agentNamePart,
                        $pagination['CurrentPage'],
                        $pagination['ItemsPerPage']
                    )
                );
                $pagination['ItemsTotal'] = Streamwide_Web_Model::call('AgentGroup.CountAgents', array($agentGroupId, $agentNamePart));
            } else {
                $statistics = Streamwide_Web_Model::call('AgentGroup.GetStatistics',
                    array(
                        $agentGroupId,
                        $pagination['CurrentPage'],
                        $pagination['ItemsPerPage']
                    )
                );
                $pagination['ItemsTotal'] = Streamwide_Web_Model::call('AgentGroup.CountAgents', array($agentGroupId));
           }
            $this->view->assign(
                array(
                    'Statistics' => $statistics,
                    'Pagination' => $pagination
                )
            );
            $this->getHelper('viewRenderer')->direct('statistics-ack');
        } else {
            $agentId = $request->getParam('AgentId');
            Streamwide_Web_Log::debug("list agent groups whose supervisor is $agentId");
            $agentGroups = Streamwide_Web_Model::call('AgentGroup.GetGroupsBySupervisor',array($agentId));
            $this->view->assign('AgentGroups',$agentGroups);
        }
    }
}
/* EOF */
