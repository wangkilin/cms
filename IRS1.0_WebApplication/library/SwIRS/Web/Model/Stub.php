<?php
/**
 * $Rev: 2669 $
 * $LastChangedDate: 2010-06-23 18:58:24 +0800 (Wed, 23 Jun 2010) $
 * $LastChangedBy: junzhang $
 *
 * @category   Streamwide
 * @package    Streamwide_Web
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.cn>
 * @version    $Id: Stub.php 2669 2010-06-23 10:58:24Z junzhang $
 */

/**
 *
 */
class SwIRS_Web_Model_Stub
{
    const OPERATION_SUCCESS = 'OK';

    protected static $_blacklist = array(
        1 => array(
            'BlacklistId' => 1,
            'BlacklistName' => 'B_name1',
            'DynamicBlacklist' => true,
            'DynamicDtmf' => '*8',
            'DynamicDuration' => 12200,
            'CustomerAccountId' => 1,
            'CustomerUserId' => 1,
            'CustomerUserName' => 'SIR customer name1',
            'CreationDatetime' =>  '2010-05-26T17:20:02+0800',
            'ModificationDatetime' => '2010-05-26T17:20:02+0800',
            'ReferenceCount' => 2,
            'NumberCount' => 200
        ),
        2 => array(
            'BlacklistId' => 2,
            'BlacklistName' => 'B_name2',
            'DynamicBlacklist' => true,
            'DynamicDtmf' => '*8',
            'DynamicDuration' => 12200,
            'CustomerAccountId' => 1,
            'CustomerUserId' => 1,
            'CustomerUserName' => 'SIR customer name2',
            'CreationDatetime' =>  '2010-05-26T17:20:02+0800',
            'ModificationDatetime' => '2010-05-26T17:20:02+0800',
            'ReferenceCount' => 2,
            'NumberCount' => 200
        ),
        3 => array(
            'BlacklistId' => 3,
            'BlacklistName' => 'B_name3',
            'DynamicBlacklist' => true,
            'DynamicDtmf' => '*8',
            'DynamicDuration' => 12200,
            'CustomerAccountId' => 1,
            'CustomerUserId' => 1,
            'CustomerUserName' => 'SIR customer name3',
            'CreationDatetime' =>  '2010-05-26T17:20:02+0800',
            'ModificationDatetime' => '2010-05-26T17:20:02+0800',
            'ReferenceCount' => 2,
            'NumberCount' => 200
        ),
    );

    protected static $_blacklistNumbers = array(
        1 => array(
            'NumberId' => 1,
            'PhoneNumber' => '1111111',
            'EndDate' => '2010-05-26T17:20:02+0800',
            'Dynamic' => true
        ),
        2 => array(
            'NumberId' => 2,
            'PhoneNumber' => '2222222',
            'EndDate' => '2010-05-26T17:20:02+0800',
            'Dynamic' => true
        ),
        3 => array(
            'NumberId' => 3,
            'PhoneNumber' => '3333333',
            'EndDate' => '2010-05-26T17:20:02+0800',
            'Dynamic' => true
        ),
        4 => array(
            'NumberId' => 4,
            'PhoneNumber' => '112233',
            'EndDate' => '2010-05-26T17:20:02+0800',
            'Dynamic' => true
        ),
        5 => array(
            'NumberId' => 5,
            'PhoneNumber' => '111222333',
            'EndDate' => '2010-05-26T17:20:02+0800',
            'Dynamic' => true
        ),
    );

    /**
     *  create blacklist
     */
    public function Blacklist_Create(array $params)
    {
        $datas = self::$_blacklist;
        shuffle($datas);
        return $datas[0]['BlacklistId'];
    }

    /**
     *  udpate blacklist
     */
    public function Blacklist_Update(array $params)
    {
        $params = array(
            'BlacklistId' => 1,
            'BlacklistName' => '',
            'DynamicBlacklist' => true,
            'DynamicDtmf' => '*8',
            'DynamicDuration' => 12200
        );
        return self::OPERATION_SUCCESS;
    }

    /**
     * get blacklist by id
     */
    public function Blacklist_GetById(array $params)
    {
        $id = $params[0];
        $data = array();
        if (array_key_exists($id, self::$_blacklist)) {
            $data = self::$_blacklist[$id];
        }
        return 	$data;
    }

    /**
     *
     */
    public function Blacklist_GetByName(array $params)
    {
        $name = $params[1];
        $data = array();
        foreach(self::$_blacklist as $item) {
            if ($item['BlacklistName'] == $name) {
                $data[] = $item;
            }
        }
        return $data;
    }

    /**
     * get the list of the phone numbers in this black list
     */
    public function Blacklist_GetNumbers(array $params)
    {
        $blacklistId = $params[0];
        return self::$_blacklistNumbers;
    }

    /**
     *get numbers by number part
     */
    public function Blacklist_GetNumbersByNumberPart(array $params)
    {
        $blacklistId = $params[0];
        $numberPart = isset($params[1]) ? $params[1] : '*';
        $datas = array();
        foreach(self::$_blacklistNumbers as $item) {
            if (preg_match('/' . $numberPart . '/i', $item['PhoneNumber'])) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     * count numbers
     */
    public function Blacklist_CountNumbers(array $params)
    {
        $blacklistId = $params[0];
        return count(self::$_blacklistNumbers);
    }

    /**
     * count numbers by number part
     */
    public function Blacklist_CountNumbersByNumberPart(array $params)
    {
        $params = array('111', 3);
        return 2;
    }

    /**
     * count the blacklists number
     */
    public function Blacklist_Count(array $params)
    {
        $customerAccountId = $params[0];
        return count(self::$_blacklist);
    }

    /**
     * count the number of blacklists by label part
     */
    public function Blacklist_CountByLabelPart(array $params)
    {
        $params = array('', 1);
        return 2;
    }

    /**
     * get the Blacklist list of the Customer user by user id
     */
    public function Blacklist_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        $datas = array();
        foreach(self::$_blacklist as $item) {
            if ($customerAccountId == $item['CustomerAccountId']) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     * get The Blacklist list of the Customer user by label part
     */
    public function Blacklist_GetByLabelPart(array $params)
    {
        $customerAccountId = $params[0];
        $namePart = isset($params[1]) ? $params[1] : '*';
        $datas = array();
        foreach(self::$_blacklist as $item) {
            if ($customerAccountId == $item['CustomerAccountId']
                && preg_match('/' . $namePart . '/i', $item['BlacklistName'])) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     * delete blacklist
     */
    public function Blacklist_Delete(array $params)
    {
        $id = $params[0];
        return self::OPERATION_SUCCESS;
    }

    /**
     * remove the number of blacklist
     */
    public function Blacklist_RemoveNumber(array $params)
    {
        $id = $params[0];
        return self::OPERATION_SUCCESS;
    }

    /**
     * import blacklist
     */
    public function Blacklist_Import(array $params)
    {
        $params[0] = 3;
        $params[1] = (string)base64_encode('admin_admin_list_last_name;Last Name');
        return 1;
    }

    /**
     * get import report
     */
    public function Blacklist_GetImportReport(array $params)
    {
        $params[0] = 1;
        $str = 'admin_admin_list_last_name;Last Name';
        return (string)base64_encode($str);
    }

    /**
     * get the content includding of blacklist numbers
     */
    public function Blacklist_Export(array $params)
    {
        $params[0] = 1;
        $str = 'admin_admin_list_last_name;Last Name';
        return (string)base64_encode($str);
    }

    /**
     * add number
     */
    public function Blacklist_AddNumber(array $params)
    {
        $params[0] = 3;
        $params[1] = array(
            'PhoneNumber' => '123456'
        );
        return 4;
    }

    /**
     * Getting the node parameter of the Node Blacklist by a specific NodeId.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array A structure of parameters
     */
    public function Blacklist_GetNodeParameter(array $params)
    {
        //the first one is the NodeId
        $nodeId = $params[0];

        return array(
            'NodeParameterBlacklistId' => 1111, // int The node parameter id
            'NodeId' => 11, //int The node id
            'HasPayphoneFilter' => true, // boolean The payphone flag
            'PayphoneRejectionPromptId' => null, // int The prompt to be played [optional]
            'BlacklistId' => 1, //int The id of blacklist [optional]
            'BlacklistRejectionPromptId' => 1, //int The prompt id to be played [optional]
        );
    }

    public function Blacklist_AddNodeParameter(array $params)
    {
        return 11;
    }

    public function Blacklist_UpdateNodeParameter(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    protected static $_calendars = array(
        1 => array(
            'CalendarId' => 1,
            'CalendarTypeId' => 1,
            'Label' => 'calendar_test1',
            'CustomerUserId' => 2,
            'CustomerUserName' => 'Test user',
            'CustomerAccountId' => 1,
            'CreationDatetime' => '2010-06-18T10:37:49+08:00',
            'ModificationDatetime' => '2010-06-18T10:37:49+08:00',
            'Automatic' => false,
            'ReferenceCounter' => 0
        ),
        2 => array(
            'CalendarId' => 2,
            'CalendarTypeId' => 1,
            'Label' => 'calendar_test',
            'CustomerUserId' => 2,
            'CustomerUserName' => 'Test user',
            'CustomerAccountId' => 1,
            'CreationDatetime' => '2010-06-18T10:37:49+08:00',
            'ModificationDatetime' => '2010-06-18T10:37:49+08:00',
            'Automatic' => false,
            'ReferenceCounter' => 0
        ),
        3 => array(
            'CalendarId' => 3,
            'CalendarTypeId' => 1,
            'Label' => 'testweek',
            'CustomerUserId' => 2,
            'CustomerUserName' => 'Test user',
            'CustomerAccountId' => 1,
            'CreationDatetime' => '2010-06-18T10:41:46+08:00',
            'ModificationDatetime' => '2010-06-18T10:41:46+08:00',
            'Automatic' => false,
            'ReferenceCounter' => 0
        )
    );

    protected static $_calendarTypes = array(
        1 => array(
            'CalendarTypeId' => 1,
            'Label' => 'Specific Date'
        ),
        2 => array(
            'CalendarTypeId' => 2,
            'Label' => 'Date Range'
        ),
        3 => array(
            'CalendarTypeId' => 3,
            'Label' => 'Week View'
        )
    );

    protected static $_periods = array(
        1 => array(
            'PeriodId' => 1,
            'Label' => '',
            'CalendarId' => 1
        ),
        2 => array(
            'PeriodId' => 2,
            'Label' => '',
            'CalendarId' => 2
        ),
        3 => array(
            'PeriodId' => 3,
            'Label' => '',
            'CalendarId' => 3
        )
    );

    protected static $_periodDays = array(
        1 => array(
            'PeriodDaysId' => 1,
            'PeriodId' => 1,
            'StartDate' => '2010-06-02',
            'EndDate' => '2010-06-02'
        ),
        2 => array(
            'PeriodDaysId' => 2,
            'PeriodId' => 2,
            'StartDate' => '2010-06-02',
            'EndDate' => '2010-06-02'
        ),
        3 => array(
            'PeriodDaysId' => 3,
            'PeriodId' => 3,
            'StartDate' => '2010-06-02',
            'EndDate' => '2010-06-02'
        )
    );

    protected static $_periodFrequencies = array(
        1 => array(
            'PeriodFrequencyId' => 1,
            'PeriodId' => 1,
            'StartSecond' => 75600,
            'EndSecond' => 81000
        ),
        2 => array(
            'PeriodFrequencyId' => 2,
            'PeriodId' => 2,
            'StartSecond' => 75600,
            'EndSecond' => 81000
        ),
        3 => array(
            'PeriodFrequencyId' => 3,
            'PeriodId' => 3,
            'StartSecond' => 75600,
            'EndSecond' => 81000
        )
    );
    /**
     * create calendar
     */
    public function Calendar_Create(array $params)
    {
        $calendars = self::$_calendars;
        shuffle($calendars);
        return $calendars[0]['CalendarId'];
    }

    /**
     * update the calendar
     */
    public function Calendar_Update(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete calendar
     */
    public function Calendar_Delete(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * get calendar by id
     */
    public function Calendar_GetById(array $params)
    {
        $calendarId = $params[0];
        return self::$_calendars[$calendarId];
    }

    /**
     * get calendar type by calendar type id
     */
    public function Calendar_GetTypes(array $params)
    {
        return self::$_calendarTypes;
    }

    /**
     * get calendar by customer account id
     */
    public function Calendar_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 40002001 );
        }
        $datas = array();
        foreach(self::$_calendars as $calendar) {
            if ($customerAccountId == $calendar['CustomerAccountId']) {
                $datas[] = $calendar;
            }
        }
        return $datas;
    }

    /**
     * 	get calendar by label part
     */
    public function Calendar_GetByLabelPart(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 40002001 );
        }
        $labelPart = $params[1];
        $datas = array();
        foreach(self::$_calendars as $calendar) {
            if (preg_match('/'. $labelPart. '/i', $calendar['Label'])) {
                $datas[] = $calendar;
            }
        }
        return $datas;
    }

    /**
     * add period
     */
    public function Calendar_AddPeriod(array $params)
    {
        $periods = self::$_periods;
        shuffle($periods);
        return $periods[0]['PeriodId'];
    }

    /**
     * delete period
     */
    public function Calendar_DeletePeriod(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * update period
     */
    public function Calendar_UpdatePeriod(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * add period day
     */
    public function Calendar_AddPeriodDay(array $params)
    {
        $periodDays = self::$_periodDays;
        shuffle($periodDays);
        return $periodDays[0]['PeriodDaysId'];
    }

    /**
     * update the period day
     */
    public function Calendar_UpdatePeriodDay(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * remove period day
     */
    public function Calendar_RemovePeriodDay(array $params)
    {
        $params[0] = 3;
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete period day
     */
    public function Calendar_DeletePeriodDay(array $params)
    {
        $params[0] = 3;
        return self::OPERATION_SUCCESS;
    }

    /**
     * get periods by calendar id
     */
    public function Calendar_GetPeriods(array $params)
    {
        $calendarId = $params[0];
        $datas = array();
        foreach(self::$_periods as $period) {
            if ($calendarId == $period['CalendarId']) {
                $datas[] = $period;
            }
        }
        return $datas;
    }

    /**
     * get period days list
     */
    public function Calendar_GetPeriodDays(array $params)
    {
        $periodId = $params[0];
        $datas = array();
        foreach(self::$_periodDays as $periodDay) {
            if ($periodId == $periodDay['PeriodId']) {
                $datas[] = $periodDay;
            }
        }
        return $datas;
    }

    /**
     * get period frequencies
     */
    public function Calendar_GetPeriodFrequencies(array $params)
    {
        $periodId = $params[0];
        $datas = array();
        foreach(self::$_periodFrequencies as $periodFrequency) {
            if ($periodId == $periodFrequency['PeriodId']) {
                $datas[] = $periodFrequency;
            }
        }
        return $datas;
    }

    /**
     * get period frequencies by id
     */
    public function Calendar_GetPeriodFrequencyById(array $params)
    {
        $periodFrequencyId = $params[0];
        return self::$_periodFrequencies[$periodFrequencyId];
    }

    /**
     * update period frequency
     */
    public function Calendar_UpdatePeriodFrequency(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete period frequency
     */
    public function Calendar_DeletePeriodFrequency(array $params)
    {
        $params[0] = 1;
        return self::OPERATION_SUCCESS;
    }

    /**
     * add period frequency
     */
    public function Calendar_AddPeriodFrequency(array $params)
    {
        $periodFrequencies = self::$_periodFrequencies;
        shuffle($periodFrequencies);
        return $periodFrequencies[0]['PeriodFrequencyId'];
    }

    /**
     * count calendar
     */
    public function Calendar_Count(array $params)
    {
        $customerAccountId = $params[0];
        $label = isset($params[1]) ? $params[1] : null;
        $count = 0;
        if ($label != null) {
            foreach(self::$_calendars as $calendar) {
                if ($customerAccountId == $calendar['CustomerAccountId']
                && preg_match('/'. $label. '/i', $calendar['Label'])) {
                    $count++;
                }
            }
            return $count;
        } else {
            return count(self::$_calendars);
        }
    }



    /**
     * Calendar get node outputs
     */
    public function Calendar_GetNodeOutputs(array $params)
    {
        $params = array(1);

        return array(
            array(
                'NodeOutputId' => 1,//    int The node output id
                'NodeOutputName' => 'Output1',  //string The node output name
                'IsActive' => 1,//    boolean The active flag
                'CalendarId' => 1,//  int The calendar id
                'CalendarTypeId' => 1,//  int The calendar type id
                'PeriodId' => 1,//    int The period id
                'NodeParameterId' => 1//
            ),
            array(
                'NodeOutputId' => 2,//    int The node output id
                'NodeOutputName' => 'Output2', // string The node output name
                'IsActive' => 1,//    boolean The active flag
                'CalendarId' => 2,//  int The calendar id
                'CalendarTypeId' => 2,//  int The calendar type id
                'PeriodId' => 2,//    int The period id
                'NodeParameterId' => 2//
            ),
            array(
                'NodeOutputId' => 3,//    int The node output id
                'NodeOutputName' => 'Output2', // string The node output name
                'IsActive' => 1,//    boolean The active flag
                'CalendarId' => 3,//  int The calendar id
                'CalendarTypeId' => 3,//  int The calendar type id
                'PeriodId' => 3,//    int The period id
                'NodeParameterId' => 3//
            ),
        );
    }

    /**
     * Calendar.RemoveNodeParameter
     */
    public function Calendar_RemoveNodeParameter(array $params) {
        $params = array(1);

        return self::OPERATION_SUCCESS;
    }
    /**
     * Calendar.AddNodeParameter
     */
    public function Calendar_AddNodeParameter(array $params)
    {
        $params = array(1,1,1); // NodeId, OutputId, PeriodId

        return 1; // NodeOutputParameterId
    }
    
    protected static $_agentGroups = array(
    	1 => array(
    		'AgentGroupId' => 1,
    		'AgentGroupName' => 'agent group 1',
    		'PostProcessingDuration' => 100,
    		'CustomerUserId' => 1,
    		'CustomerUserName' => 'admin',
    		'CustomerAccountId' => 1,
    		'CreationDatetime' => '2010-06-18T10:41:46+08:00',
    		'ModificationDatetime' => '2010-06-18T10:41:46+08:00',
    		'ReferenceCounter' => 2
    	),
    	2 => array(
    		'AgentGroupId' => 2,
    		'AgentGroupName' => 'agent group 2',
    		'PostProcessingDuration' => 100,
    		'CustomerUserId' => 1,
    		'CustomerUserName' => 'admin',
    		'CustomerAccountId' => 1,
    		'CreationDatetime' => '2010-06-18T10:41:46+08:00',
    		'ModificationDatetime' => '2010-06-18T10:41:46+08:00',
    		'ReferenceCounter' => 2
    	),
    	3 => array(
    		'AgentGroupId' => 3,
    		'AgentGroupName' => 'agent group 3',
    		'PostProcessingDuration' => 100,
    		'CustomerUserId' => 1,
    		'CustomerUserName' => 'admin',
    		'CustomerAccountId' => 1,
    		'CreationDatetime' => '2010-06-18T10:41:46+08:00',
    		'ModificationDatetime' => '2010-06-18T10:41:46+08:00',
    		'ReferenceCounter' => 2
    	)
    );
    
    /**
     * get groups by agentId
     */
    public function Agentgroup_GetGroupsByAgent(array $params) {
    	$agentId = $params[0];
    	$data = array();
    	$i = 0;
    	foreach (self::$_agentGroups as $agentGroup) {
    		if ($agentId == $agentGroup['CustomerUserId']) {
    			$data[$i]['AgentGroupId'] = $agentGroup['AgentGroupId'];
    			$data[$i]['AgentGroupName'] = $agentGroup['AgentGroupName'];
    			$i++;
    		}
    	}
    	
    	return $data;
    }

    public function Agentgroup_GetGroupsBySupervisor(array $params) {
        $agentId = $params[0];
    	$data = array();
    	$i = 0;
    	foreach (self::$_agentGroups as $agentGroup) {
    		if ($agentId == $agentGroup['CustomerUserId']) {
    			$data[$i]['AgentGroupId'] = $agentGroup['AgentGroupId'];
    			$data[$i]['AgentGroupName'] = $agentGroup['AgentGroupName'];
    			$i++;
    		}
    	}
    	
    	return $data;
    }

    public function Agentgroup_CountAllAgents (array $params)
    {
        
    }

    public function Agentgroup_CountUnaffectedAgents(array $params)
    {
        
    }
    /**
     * create agent group
     */
    public function Agentgroup_Create(array $params)
    {
    	$datas = array();
        $datas = self::$_agentGroups;
        shuffle($datas);
        
        return $datas[0]['AgentGroupId'];
    }

    /**
     * delete agent group
     */
    public function Agentgroup_Delete(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * update agent group
     */
    public function Agentgroup_Update(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * get agent group by id
     */
    public function Agentgroup_GetById(array $params)
    {
        $agentGroupId = $params[0];
        $data = array();
        foreach (self::$_agentGroups as $agentGroup) {
        	if ($agentGroup['AgentGroupId'] == $agentGroupId) {
        		$data = $agentGroup;
        		break;
        	}
        }
        
        return $data;
    }

    /**
     * agentgroup get by customer id
     */
    public function Agentgroup_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        $datas = array();
        foreach (self::$_agentGroups as $agentGroup) {
        	if ($agentGroup['CustomerAccountId'] == $customerAccountId) {
        		$datas[] = $agentGroup;
        	}
        }
        
        return $datas;
    }

    /**
     * get agentgroup by label and customer
     */
    public function Agentgroup_GetByName(array $params)
    {
        $customerAccountId = $params[0];
        $namePart = isset($params[1]) ? $params[1] : null;
        $datas = array();
        foreach (self::$_agentGroups as $agentGroup) {
        	if ($customerAccountId == $agentGroup['CustomerAccountId']
        		&& preg_match('/' . $namePart . '/i', $agentGroup['AgentGroupName'])) {
        		$datas = $agentGroup;
        	}
        }
        
        return $datas;
    }
    /**
     * get all the agent group
     */
    public function Agentgroup_GetAll(array $params)
    {
        $datas = array();
        $datas = self::$_agentGroups;
        
        return $datas;
    }

    /**
     * get agent group by label part
     */
    public function Agentgroup_GetByLabelPart(array $params)
    {
        $customerAccountId = $params[0];
        $labelPart = isset($params[1]) ? $params[1] : null;
        $datas = array();
        foreach (self::$_agentGroups as $agentGroup) {
        	if ($customerAccountId == $agentGroup['CustomerAccountId']
        		&& preg_match('/' . $labelPart . '/i', $agentGroup['AgentGroupName'])) {
        		$datas = $agentGroup;
        	}
        }
        
        return $datas;
    }

    /**
     * get unaffected agents
     */
    public function Agentgroup_GetUnaffectedAgents(array $params)
    {
        $params[0] = 1;
        $params[1] = 5;
        $params[2] = 5;
        return array(
        array(
        'Name' => 'Agent Name1',     //string  The agent name.
        'UserId' => 1           //int The user id.
        ),
        array(
        'Name' => 'Agent Name2',     //string  The agent name.
        'UserId' => 2           //int The user id.
        ),
        array(
        'Name' => 'Agent Name3',     //string  The agent name.
        'UserId' => 3           //int The user id.
        )
        );
    }

    /**
     * add agent
     */
    public function Agentgroup_AddAgent(array $params)
    {
        $params[0] = 1;
        $params[1] = array(1);
        return self::OPERATION_SUCCESS;
    }

    /**
     * get agents
     */
    public function Agentgroup_GetAgents(array $params)
    {
        $params[0] = 1;
        $params[1] = 5;
        $params[2] = 5;
        return array(
        array(
        'Name' => 'Agent Name1',     //string  The agent name.
        'UserId' => 1,           //int The user id.
        'IsLocked' => true,
        'SupervisorStatus' => true
        ),
        array(
        'Name' => 'Agent Name2',     //string  The agent name.
        'UserId' => 2,           //int The user id.
        'IsLocked' => false,
        'SupervisorStatus' => false
        ),
        array(
        'Name' => 'Agent Name3',     //string  The agent name.
        'UserId' => 3,           //int The user id.
        'IsLocked' => false,
        'SupervisorStatus' => false
        )
        );
    }

    /**
     * remove agent
     */
    public function Agentgroup_RemoveAgent(array $params)
    {
        $params[0] = 1;
        $params[1] = array(1);
        return self::OPERATION_SUCCESS;
    }

    /**
     * set supervisor
     */
    public function Agentgroup_SetSupervisor(array $params)
    {
        $params[0] = 1;
        $params[1] = 1;
        $params[2] = true;
        return self::OPERATION_SUCCESS;
    }


    protected static $_contacts = array(
        1 => array(
            'ContactId' =>  1,
            'ContactPhone' => '123',
            'ContactName' => 'abc',
            'CustomerUserId' => 1,
            'CustomerUserName' => 'jack1',
            'CustomerAccountId' => 1,
            'CreationDatetime' => '2010-05-18 15:18:02',
            'ModificationDatetime' => '2010-05-18 15:20:02',
            'ReferenceCounter' => 1
        ),
        2 => array(
            'ContactId' =>  2,
            'ContactPhone' => '1234',
            'ContactName' => 'abcd',
            'CustomerUserId' => 1,
            'CustomerUserName' => 'jack1',
            'CustomerAccountId' => 1,
            'CreationDatetime' => '2010-05-18 15:18:02',
            'ModificationDatetime' => '2010-05-18 15:20:02',
            'ReferenceCounter' => 1
        ),
        3 => array(
            'ContactId' =>  3,
            'ContactPhone' => '12345',
            'ContactName' => 'lilysd',
            'CustomerUserId' => 1,
            'CustomerUserName' => 'jack1',
            'CustomerAccountId' => 1,
            'CreationDatetime' => '2010-05-18 15:18:02',
            'ModificationDatetime' => '2010-05-18 15:20:02',
            'ReferenceCounter' => 1
        )
    );
    /**
     * create contact
     */
    public function Contact_Create(array $params)
    {
        $contacts = self::$_contacts;
        shuffle($contacts);
        return $contact[0]['ContactId'];
    }

    /**
     * update contact
     */
    public function Contact_Update(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete contact
     */
    public function Contact_Delete(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     *  get by contact id
     */
    public function Contact_GetById(array $params)
    {
        $contactId = $params[0];
        return self::$_contacts[$contactId];
    }

    /**
     *  get contact by customer id
     */
    public function Contact_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        $datas = array();
        foreach(self::$_contacts as $contact) {
            if ($customerAccountId == $contact['CustomerAccountId']) {
                $datas[] = $contact;
            }
        }
        return $datas;
    }

    /**
     *	get contact by part of contact name
     */
    public function Contact_GetByName(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 400005);
        }
        $namePart = $params[1];
        $datas = array();
        foreach(self::$_contacts as $contact) {
            if ($customerAccountId == $contact['CustomerAccountId']
            && preg_match('/'. $namePart. '/i', $contact['ContactName'])) {
                $datas[] = $contact;
            }
        }
        return $datas;
    }

    /**
     * count contacts
     */
    public function Contact_Count(array $params)
    {     
        $customerAccountId = $params[0];
        $namePart = isset($params[1]) ? $params[1] : null;
        if ($namePart != null) {
            $count = 0;
            foreach(self::$_contacts as $contact) {
                if ($customerAccountId == $contact['CustomerAccountId'] 
                && preg_match('/'. $namePart. '/i', $contact['ContactName'])) {
                    $count++;
                }
            }
            return $count;
        } else {
            return count(self::$_contacts);
        }
    }

    /**
     * 	get contact by part of contact phone number
     */
    public function Contact_GetByPhoneNumber(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountid)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 400005);
        }
        $phonePart = $params[1];
        $datas = array();
        foreach(self::$_contacts as $contact) {
            if ($customerAccountId == $contact['CustomerAccountId']
            && preg_match('/'. $phonePart. '/i', $contact['ContactPhone'])) {
                $datas[] = $contact;
            }
        }
        return $datas;
    }

    /**
     * 	import csv file
     */
    public function Contact_Import(array $params)
    {
        $params = array(1 , 1 , base64_encode('admin_admin_list_last_name;Last Name'));
        return 2;
    }

    /**
     * 	get import report
     */
    public function Contact_GetImportReport(array $params)
    {
        $params = array(2);
        $str = "admin_admin_list_first_name;hello";
        return base64_encode($str);
    }

    /**
     * 	export csv file content
     */
    public function Contact_Export(array $params)
    {
        $params = array(1);
        $str = "admin_admin_list_first_name;hello";
        return base64_encode($str);
    }

    
    protected static $_prompts = array(
        1 => array(
            'PromptId' => 1,    //int The id of prompt.
            'PromptName' => 'my Prompt1',   //string The name of prompt.
            'FileSize' => 5,    //int The size of prompt file.
            'FileName' =>   'File Name1',
            'Description' => 'Description',
            'CustomerUserId' => 1,//int The id of creator user.
            'CustomerUserName' => 'jack1',//string The name of creator user.
            'CustomerAccountId' => 1,   //int The id of customer.
            'CreationDatetime' =>   '2010-05-18 15:18:02',    //string  The creation date time.
            'ModificationDatetime' => '2010-05-18 15:18:02',    //string The modification date time.
            'ReferenceCounter' => 1 //int The count of this contact has been linked.
        ),
        2 => array(
            'PromptId' => 2,    //int The id of prompt.
            'PromptName' => 'my Prompt2',   //string The name of prompt.
            'FileSize' => 5,    //int The size of prompt file.
            'FileName' =>   'File Name2',
            'Description' => 'Description',
            'CustomerUserId' => 1,//int The id of creator user.
            'CustomerUserName' => 'jack1',//string The name of creator user.
            'CustomerAccountId' => 1,   //int The id of customer.
            'CreationDatetime' =>   '2010-05-18 15:18:02',    //string  The creation date time.
            'ModificationDatetime' => '2010-05-18 15:18:02',    //string The modification date time.
            'ReferenceCounter' => 1 //int The count of this contact has been linked.
        ),
        3 => array(
            'PromptId' => 3,    //int The id of prompt.
            'PromptName' => 'my Prompt3',   //string The name of prompt.
            'FileSize' => 5,    //int The size of prompt file.
            'FileName' =>   'File Name3',
            'Description' => 'Description',
            'CustomerUserId' => 1,//int The id of creator user.
            'CustomerUserName' => 'jack1',//string The name of creator user.
            'CustomerAccountId' => 1,   //int The id of customer.
            'CreationDatetime' =>   '2010-05-18 15:18:02',    //string  The creation date time.
            'ModificationDatetime' => '2010-05-18 15:18:02',    //string The modification date time.
            'ReferenceCounter' => 1 //int The count of this contact has been linked.
        ),
        4 => array(
            'PromptId' => 4,    //int The id of prompt.
            'PromptName' => 'system Prompt4',   //string The name of prompt.
            'FileSize' => 5,    //int The size of prompt file.
            'FileName' =>   'File Name3',
            'Description' => 'Description',
            'CustomerUserId' => 1,//int The id of creator user.
            'CustomerUserName' => 'jack1',//string The name of creator user.
            'CustomerAccountId' => null,   //int The id of customer.
            'CreationDatetime' =>   '2010-05-18 15:18:02',    //string  The creation date time.
            'ModificationDatetime' => '2010-05-18 15:18:02',    //string The modification date time.
            'ReferenceCounter' => 1 //int The count of this contact has been linked.
        ),
    );
    /**
     * 	get prompt by customer account id
     */
    public function Prompt_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        $datas = array();
        foreach(self::$_prompts as $prompt) {
            if ($customerAccountId == $prompt['CustomerAccountId']) {
                $datas[] = $prompt;
            }
        }
        return $datas;
    }

    /**
     * 	get prompt by part of prompt name
     */
    public function Prompt_GetByName(array $params)
    {
        $customerAccountId = $params[0];
        $namePart = $params[1];
        $datas = array();
        foreach(self::$_prompts as $prompt) {
            if ($customerAccountId == $prompt['CustomerAccountId']
            && preg_match('/'. $namePart. '/i', $prompt['PromptName'])) {
                $datas[] = $prompt;
            }
        }
        return $datas;
    }

    /**
     * get prompt by prompt id
     */
    public function Prompt_GetById(array $params)
    {
        $promptId = $params[0];
        return self::$_prompts[$promptId];
    }

    /**
     * create prompt
     */
    public function Prompt_Create(array $params)
    {
        $prompts = self::$_prompts;
        shuffle($prompts);
        return $prompts[0]['PromptId'];
    }

    /**
     * update prompt
     */
    public function Prompt_Update(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete prompt
     */
    public function Prompt_Delete(array $params)
    {
        $params = array(4);
        return self::OPERATION_SUCCESS;
    }

    /**
     * Getting the node output of the Node Prompt by a specific NodeId.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array A structure of parameters
     */
    public function Prompt_GetNodeOutput(array $params)
    {
        //the first one is the NodeId
        $nodeId = $params[0];

        return array(
        'NodeOutputId' => 11, // int The node output id
        'NodeId' => 1, // int The node id this output belongs to
        'Label' => '_internal_prompt_output_label_', // string The node output name
        'IsDefault' => false, //The default flag ???
        'IsActive' => true, // boolean The active flag
        'IsAllowed' => false, // boolean The allowed flag
        'NextNodeId' => 2, //int The next node id [optional]
        );
    }

    public function Prompt_AddNodeParameter(array $params)
    {
        return 1111;
    }

    public function Prompt_UpdateNodeParameter(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * Getting the node parameter of the Node Prompt by a specific NodeId.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array A structure of parameters
     */
    public function Prompt_GetNodeParameter(array $params)
    {
        //the first one is the NodeId
        $nodeId = $params[0];

        return array(
        'NodeParameterId' => 111, // int The node parameter id
        'PromptId' => null, // int THe prompt id [optional]
        'PromptName' => null, // string The prompt name [optional]
        'IsStandard' => false, //boolean The system/standard flag
        );
    }

    /**
     * count prompt
     */
    public function Prompt_Count(array $params)
    {
        $customerAccountId = $params[0];
        $namePart = isset($params[1]) ? $params[1] : null;
        if ($namePart != null) {
            $count = 0;
            foreach(self::$_prompts as $prompt) {
                if ($customerAccountId == $prompt['CustomerAccountId']
                && preg_match('/'. $namePart. '/i', $prompt['PromptName'])) {
                    $count++;
                }
            }
            return $count;
        } else {
            return count(self::$_prompts);
        }
    }

    protected static $_origins = array(
    	1 => array(
    	    'OriginId' => 1,
	        'OriginGroupId' => 1,
	        'OriginGroupName' => 'group1',
	        'OriginName' => 'beijing1',
	        'CustomerUserId' => 1,
	        'CustomerUserName' => 'jack1',
	        'CustomerAccountId' => 1,
	        'CreationDatetime' => '2010-05-18 17:10:02',
	        'ModificationDatetime' => '2010-05-18 17:18:02',
	        'ReferenceCounter' => 1
    	),
    	2 => array(
    		'OriginId' => 2,
	        'OriginGroupId' => 1,
	        'OriginGroupName' => 'group1',
	        'OriginName' => 'beijing2',
	        'CustomerUserId' => 1,
	        'CustomerUserName' => 'jack1',
	        'CustomerAccountId' => 1,
	        'CreationDatetime' => '2010-05-18 17:10:02',
	        'ModificationDatetime' => '2010-05-18 17:18:02',
	        'ReferenceCounter' => 1
    	),
    	3 => array(
    		'OriginId' => 3,
	        'OriginGroupId' => 1,
	        'OriginGroupName' => 'group1',
	        'OriginName' => 'beijing3',
	        'CustomerUserId' => 1,
	        'CustomerUserName' => 'jack1',
	        'CustomerAccountId' => 1,
	        'CreationDatetime' => '2010-05-18 17:10:02',
	        'ModificationDatetime' => '2010-05-18 17:18:02',
	        'ReferenceCounter' => 1
    	),
    	4 => array(
    		'OriginId' => 4,
	        'OriginGroupId' => 2,
	        'OriginGroupName' => 'group2',
	        'OriginName' => 'beijing4',
	        'CustomerUserId' => 1,
	        'CustomerUserName' => 'jack1',
	        'CustomerAccountId' => 1,
	        'CreationDatetime' => '2010-05-18 17:10:02',
	        'ModificationDatetime' => '2010-05-18 17:18:02',
	        'ReferenceCounter' => 1
    	)
    );
    
    protected static $_originGroups = array(
    	1 => array(
    		'OriginGroupId' => 1,
    		'OriginGroupName' => 'OriginGroupOne'
    	),
    	2 => array(
    		'OriginGroupId' => 2,
    		'OriginGroupName' => 'OriginGroupTwo'
    	),
    	3 => array(
    		'OriginGroupId' => 3,
    		'OriginGroupName' => 'OriginGroupThree'
    	),
    	4 => array(
    		'OriginGroupId' => 4,
    		'OriginGroupName' => 'OriginGroupFour'
    	),
    	5 => array(
    		'OriginGroupId' => 5,
    		'OriginGroupName' => 'OriginGroupFive'
    	)
    );
    
    /**
     * create origin
     */
    public function Origin_Create(array $params)
    {
    	$datas = array();
        $datas = self::$_origins;
        shuffle($datas);
        
        return $datas[0]['OriginId'];
    }

    /**
     * get associate origin
     */
    public function Origin_GetAssociated(array $params)
    {
        $originId = $params[0];
        $datas = array();
        foreach (self::$_origins as $origin) {
        	if ($origin['OriginGroupId'] == $_origins[$originId]['OriginGroupId']) {
        		$datas[] = $origin;
        	}
        }
        
        return $datas;
    }

    /**
     * associate origin
     */
    public function Origin_Associate(array $params)
    {
        $params = array(5,
        array(1, 2)
        );
        return self::OPERATION_SUCCESS;
    }

    /**
     * unassociate origin
     */
    public function Origin_UnAssociate(array $params)
    {
        $params = array(5,
        array(1)
        );
        return self::OPERATION_SUCCESS;
    }

    /**
     * update origin
     */
    public function Origin_Update(array $params)
    {
        $params = array(5, 'OriginName');
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete origin
     */
    public function Origin_Delete(array $params)
    {
        $params = array(5);
        return self::OPERATION_SUCCESS;
    }

    /**
     * get origin by origin id
     */
    public function Origin_GetById(array $params)
    {
        $originId = $params[0];
        $data = array();
        foreach (self::$_origins as $origin) {
        	if ($origin['OriginId'] == $originId) {
        		$data = $origin;
        		break;
        	}
        }
        
        return $data;
    }

    /**
     * get origin by customer id
     */
    public function Origin_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        $datas = array();
        foreach (self::$_origins as $origin) {
        	if ($origin['CustomerAccountId'] == $customerAccountId) {
        		$datas[] = $origin;
        	}
        }
        
        return $datas;
    }

    /**
     * get origin by part of origin name
     */
    public function Origin_GetByNamePart(array $params)
    {
        $customerAccountId = $params[0];
        $namePart = isset($params[1]) ? $params[1] : null;
        $datas = array();
        foreach (self::$_origins as $origin) {
        	if ($origin['CustomerAccountId'] == $customerAccountId 
        		&& preg_match('/' . $namePart . '/i', $origin['OriginName'])) {
        		$datas[] = $origin;
        	}
        }
        
        return $datas;
    }

    /**
     * get origin group list
     */
    public function Origin_GetGroups(array $params)
    {
    	return self::$_originGroups;
    }

    /**
     * add origin group
     */
    public function Origin_AddGroup(array $params)
    {
        $datas = self::$_originGroups;
        shuffle($datas);
        
        return $datas[0]['OriginGroupId'];
    }

    /**
     * update origin group
     */
    public function Origin_UpdateGroup(array $params)
    {
        $params = array(2, 'group2');
        return self::OPERATION_SUCCESS;
    }

    /**
     * remove origin group
     */
    public function Origin_RemoveGroup(array $params)
    {
        $params = array(2);
        return self::OPERATION_SUCCESS;
    }

    /**
     * add prefix phone number to origin
     */
    public function Origin_AddPrefix(array $params)
    {
        $params = array(2,
        array('12345', '23456')
        );
        return self::OPERATION_SUCCESS;
    }

    /**
     * remove prefix phone number from origin
     */
    public function Origin_RemovePrefix(array $params)
    {
        $params = array(2,
        array( 1, 2 )
        );
        return self::OPERATION_SUCCESS;
    }

    /**
     * get origin prefix phone number
     */
    public function Origin_GetPrefix(array $params)
    {
        $params = array(2);
        return array(
        array(
        'PrefixId' => 2,//int The id of prefix.
        'PrefixNumber' => '123'//string The The prefix phone number.
        ),
        array(
        'PrefixId' => 3,//int The id of prefix.
        'PrefixNumber' => '456'//string The The prefix phone number.
        ),
        array(
        'PrefixId' => 4,//int The id of prefix.
        'PrefixNumber' => '789'//string The The prefix phone number.
        )
        );
    }

    /**
     * count origin by customer account id
     */
    public function Origin_Count(array $params)
    {
        $customerAccountId = $params[0];
        $namePart = isset($params[1]) ? $params[1] : null;
        if ($namePart != null) {
        	$count = 0;
        	foreach (self::$_origins as $origin) {
        		if ($origin['CustomerAccountId'] == $customerAccountId 
        		&& preg_match('/' . $namePart . '/i', $origin['OriginName'])) {
        			$count++;
        		}
        	}
        	return $count;
        } else {
        	return count(self::$_origins);
        }
    }
////////////////////////////////////////////////////////////////////
    
protected static $_nodes = array(
        1 => array(
            'NodeId' => 1, 
            'Label' => 'origin 1',
            'NodeTypeId' => 1, 
            'NodeType' => 'origin', 
            'IsActive' => true
        ),
        2 => array(
            'NodeId' => 2, 
            'Label' => 'origin 2',
            'NodeTypeId' => 1, 
            'NodeType' => 'origin', 
            'IsActive' => true
        ),
        3 => array(
            'NodeId' => 3, 
            'Label' => 'origin 3',
            'NodeTypeId' => 1, 
            'NodeType' => 'origin', 
            'IsActive' => true
        ),
        4 => array(
            'NodeId' => 4, 
            'Label' => 'calendar 1',
            'NodeTypeId' => 2, 
            'NodeType' => 'calendar', 
            'IsActive' => true
        ),
        5 => array(
            'NodeId' => 5, 
            'Label' => 'calendar 2',
            'NodeTypeId' => 2, 
            'NodeType' => 'calendar', 
            'IsActive' => true
        )
    );
    
    protected static $_nodeOutput = array(
        1 => array(
            'NodeOutputId' => 1,
            'NodeId' => 1,
            'Label' => 'Output 1',
            'IsDefault' => false,
            'IsActive'  => false,
            'IsAllowed' => true,
            'NextNodeId' => 2
        ),
        2 => array(
            'NodeOutputId' => 2,
            'NodeId' => 1,
            'Label' => 'Output 2',
            'IsDefault' => false,
            'IsActive'  => false,
            'IsAllowed' => true,
            'NextNodeId' => 2
        ),
        3 => array(
            'NodeOutputId' => 2,
            'NodeId' => 2,
            'Label' => 'Output 3',
            'IsDefault' => false,
            'IsActive'  => false,
            'IsAllowed' => true,
            'NextNodeId' => 3
        )
    );
    /**
     * Detail a node by NodeId.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array A structure of Node
     */
    public function Node_GetById(array $params)
    {
        $nodeId = $params[0];
        return self::$_nodes[$nodeId];
    }

    public function Node_Create(array $params)
    {
        $nodes = self::$_nodes;
        shuffle($nodes);
        return $nodes[0]['NodeId'];
    }

    public function NodeOutput_Create(array $params)
    {
        $nodeOutput = self::$_nodeOutput;
        shuffle($nodeOutput);
        return $nodeOutput[0]['NodeOutputId'];
    }

    public function Node_Delete(array $params)
    {
        return self::OPERATION_SUCCESS;
    }
    
    public function Node_Update(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * Getting the Node Types list.
     *
     * @return array A list of Node types structures
     */
    public function Node_GetTypes()
    {
        return array(
        array(
        'NodeTypeId' => 1, //int ID of a node type.
        'NodeType' => 'origin'//string Label of a node type.
        ),
        array(
        'NodeTypeId' => 2,
        'NodeType' => 'calendar'
        ),
        array(
        'NodeTypeId' => 3,
        'NodeType' => 'link'
        ),
        array(
        'NodeTypeId' => 4,
        'NodeType' => 'menu'
        ),
        array(
        'NodeTypeId' => 5,
        'NodeType' => 'destination'
        ),
        array(
        'NodeTypeId' => 6,
        'NodeType' => 'distribution'
        ),
        array(
        'NodeTypeId' => 7,
        'NodeType' => 'blacklist'
        ),
        array(
        'NodeTypeId' => 8,
        'NodeType' => 'hangup'
        ),
        array(
        'NodeTypeId' => 9,
        'NodeType' => 'prompt'
        ),
        );
    }

    /**
     * Remove a NodeOutput by NodeOutputId.
     *
     * @return string The string 'OK' when operation success.
     */
    public function NodeOutput_Delete(array $params)
    {
        //The fist parameter is the NodeOutputId
        $id = $params[0];
        return self::OPERATION_SUCCESS;
    }
    
    public function NodeOutput_GetById(array $params)
    {
        $nodeOutputId = $params[0];
        return self::$_nodeOutput[$nodeOutputId];
    }
    
    public function NodeOutput_Update(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * Getting the Node Link default parameters.
     *
     * @return array A structure of parameters
     */
    public function Link_GetNodeParameterDefault()
    {
        return array(
        'IsInternal' => false,
        );
    }

    public function Link_AddNodeParameter(array $params)
    {
        return 1;
    }

    public function Link_UpdateNodeParameter(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * Getting the Node Distribution types.
     *
     * @return array A list of Distribution type structure.
     */
    public function Distribution_GetTypes()
    {
        return array(
        array(
        'DistributionTypeId' => 1, //int The distribution type id
        'Label' => 'proportional', //string The distribution type label
        ),
        array(
        'DistributionTypeId' => 2,
        'Label' => 'cyclical',
        ),
        );
    }

    /**
     * Getting the Node Distribution outputs.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array A list of node outputs on Node Distribution
     */
    public function Distribution_GetNodeOutputs(array $params)
    {
        // The first one is the NodeId
        $id = $params[0];

        return array(
        array(
        'NodeOutputId' => 91, // int The node output id
        'NodeId' => 1, // int The node id this output belongs to
        'Label' => 'Distribution 1', // string The node output name
        'IsDefault' => false, //The default flag ???
        'IsActive' => true, // boolean The active flag
        'IsAllowed' => false, // boolean The allowed flag
        'NextNodeId' => 92, //int The next node id [optional]
        /////mixed the NodeParameters for each one
        'DistributionTypeId' => 1, // int the distribution type id
        'NodeParameterId' => 991, //int The node parameter id
        'Percentage' => 40, //int the distribution ratio
        ),
        array(
        'NodeOutputId' => 92, // int The node output id
        'NodeId' => 1, // int The node id this output belongs to
        'Label' => 'Distribution 2', // string The node output name
        'IsDefault' => false, //The default flag ???
        'IsActive' => true, // boolean The active flag
        'IsAllowed' => false, // boolean The allowed flag
        'NextNodeId' => null, //int The next node id [optional]
        /////mixed the NodeParameters for each one
        'DistributionTypeId' => 1, // int the distribution type id
        'NodeParameterId' => 992, //int The node parameter id
        'Percentage' => 40, //int the distribution ratio
        ),
        );
    }

    /**
     * Getting the paramters of the Node Link by a specific NodeId.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array A structure of parameters
     */
    public function Link_GetNodeParameter(array $params)
    {
        return array(
            'NodeParamLinkId' => 1, //int The node parameter id
            'NodeId' => 1, // int The node id
            'LinkedNodeId' => null, //int[optional] The linked node id
            'IsInternal' => false, //boolean The internal link flag
        );
    }

    /**
     * Getting the release causes of the Node Hangup.
     *
     * @return array A list of release cause structure
     */
    public function Hangup_GetReleaseCauses()
    {
        return array( //The list of release causes
            array( //The release cause structure
                'ReleaseCauseId' => 1, //int The release cause id
                'Label' => 'Sorry, out of service', //string The release cause label
            ),
            array(
                'ReleaseCauseId' => 2,
                'Label' => 'Hmmmmm....',
            ),
        );
    }

    public function Hangup_GetNodeParameter(array $params)
    {
        $nodeParameterId = $params[0];
        return array(
            'NodeParamHangupId' => 1,
            'NodeId' => 1,
            'ReleaseCauseId' => 1,
        );
    }

    public function Hangup_AddNodeParameter(array $params)
    {
        return 1;
    }

    public function Hangup_UpdateNodeParameter(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * Getting the Node Menu default parameters.
     *
     * @return array A structure of parameters
     */
    public function Menu_GetNodeParameterDefault()
    {
        return array(
        'MaxTries' => 3, //int The number of max tries
        'NoInputTimeout' => 5, //int The no input timeout in seconds
        );
    }

    /**
     * Getting the Node Menu default parameters.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array A structure of parameters
     */
    public function Menu_GetNodeParameter(array $params)
    {
        // The first one is the NodeId
        $id = $params[0];

        return array(
            'NodeParamMenuId' => 111, // int The node parameter id
            'NodeId' => 1, //int The node id 
            'MaxTries' => 3, //int The number of max tries
            'NoInputTimeout' => 5, //int The no input timeout in seconds
            'DetectDtmfOnPrompt' => false, //boolean True if detection of dtmf during the prompt is allowed 
            'GreetingPromptId' => null, // int The greeting prompt id [optional]
            'NoInputPromptId' => null, // int The no input prompt id [optional]
            'WrongKeyPromptId' => null, // int The wrong key prompt id [optional]
        );
    }

    public function Menu_AddNodeParameter(array $params)
    {
        return 1111;
    }

    /**
     * Getting the Node Menu default parameters.
     *
     * @return array A structure of parameters
     */
    public function Menu_GetNodeOutputs(array $params)
    {
        // The first one is the NodeId
        $id = $params[0];

        return array(
        array(
        'NodeOutputId' => 10, // int The node output id
        'NodeId' => 1, // int The node id this output belongs to
        'Label' => 'Error Output', // string The node output name
        'IsDefault' => true, //The default flag ???
        'IsActive' => true, // boolean The active flag
        'IsAllowed' => false, // boolean The allowed flag
        'NextNodeId' => 2, //int The next node id [optional]
        ),
        array(
        'NodeOutputId' => 11, // int The node output id
        'NodeId' => 1, // int The node id this output belongs to
        'Label' => 'DTMF 0', // string The node output name
        'IsDefault' => false, //The default flag ???
        'IsActive' => true, // boolean The active flag
        'IsAllowed' => false, // boolean The allowed flag
        'NextNodeId' => 2, //int The next node id [optional]
        ),
        array(
        'NodeOutputId' => 12, // int The node output id
        'NodeId' => 1, // int The node id this output belongs to
        'Label' => 'DTMF 2', // string The node output name
        'IsDefault' => false, //The default flag ???
        'IsActive' => true, // boolean The active flag
        'IsAllowed' => false, // boolean The allowed flag
        'NextNodeId' => null, //int The next node id [optional]
        ),
        );
    }

///////////////////////////////////////////////////////////////////////////////////////    
    protected static $_customers = array(
        1 => array(
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'jack1',
            'CustomerAccountBillingId' => '123',
            'ContactName' => 'admin1',
            'ContactEmail' => 'admin1@admin1.com',
            'ContactPhone' => '111',
            'MaxResPrompt' => 10,
            'MaxResOrigin' => 10,
            'MaxResBlacklist' => 10,
            'MaxResCalendar' => 10,
            'MaxResAgentgroup' => 10,
            'MaxResContact' => 10,
            'MaxResUser' => 10,
            'CreationDatetime' => '2010-05-26T17:20:02+0800'
        ),
        2 => array(
            'CustomerAccountId' => 2,
            'CustomerAccountName' => 'jack2',
            'CustomerAccountBillingId' => '123',
            'ContactName' => 'admin2',
            'ContactEmail' => 'admin2@admin2.com',
            'ContactPhone' => '222',
            'MaxResPrompt' => 10,
            'MaxResOrigin' => 10,
            'MaxResBlacklist' => 10,
            'MaxResCalendar' => 10,
            'MaxResAgentgroup' => 10,
            'MaxResContact' => 10,
            'MaxResUser' => 10,
            'CreationDatetime' => '2010-05-26T17:20:02+0800'
        ),
        3 => array(
            'CustomerAccountId' => 3,
            'CustomerAccountName' => 'jack3',
            'CustomerAccountBillingId' => '123',
            'ContactName' => 'admin3',
            'ContactEmail' => 'admin3@admin3.com',
            'ContactPhone' => '333',
            'MaxResPrompt' => 10,
            'MaxResOrigin' => 10,
            'MaxResBlacklist' => 10,
            'MaxResCalendar' => 10,
            'MaxResAgentgroup' => 10,
            'MaxResContact' => 10,
            'MaxResUser' => 10,
            'CreationDatetime' => '2010-05-26T17:20:02+0800'
        )
    );
    /**
     * create customer
     */
    public function Customer_Create(array $params)
    {
        $customers = self::$_customers;
        shuffle($customers);
        return $customers[0]['CustomerAccountId'];
    }

    /**
     * count the number of customer
     */
    public function Customer_Count(array $params)
    {
        $namePart = isset($params[0]) ? $params[0] : null;
        $count = 0;
        if ($namePart != null) {
            foreach(self::$_customers as $customer) {
                if (preg_match('/'. $namePart. '/i', $customer['CustomerAccountName'])) {
                    $count++;
                }
            }
            return $count;
        } else {
            return count(self::$_customers);
        }
    }

    /**
     *	get all the customers
     */
    public function Customer_GetAll(array $params)
    {
        return self::$_customers;
    }

    /**
     *	get customer by customerAccountId
     */
    public function Customer_GetById(array $params)
    {
        $customerAccountId = $params[0];
        return self::$_customers[$customerAccountId];
    }

    /**
     * get customer by customerAccountPartName
     */
    public function Customer_GetByNamePart(array $params)
    {
        $namePart = $params[0];
        $datas = array();
        foreach(self::$_customers as $customer) {
            if (preg_match('/'. $namePart. '/i', $customer['CustomerAccountName'])) {
                $datas[] = $customer;
            }
        }
        return $datas;
    }

    /**
     * update customer
     */
    public function Customer_Update(array $params)
    {
        $params = array(
        'CustomerAccountId' => 3,
        'CustomerAccountName' => 'jack33',
        'CustomerAccountBillingId' => '123',
        'ContactName' => 'admin3',
        'ContactEmail' => 'admin3@admin3.com',
        'ContactPhone' => '333333',
        'MaxResPrompt' => 10,
        'MaxResOrigin' => 10,
        'MaxResBlacklist' => 10,
        'MaxResCalendar' => 10,
        'MaxResAgentgroup' => 10,
        'MaxResContact' => 10,
        'MaxResUser' => 10,
        );

        return self::OPERATION_SUCCESS;
    }

    /**
     * delete customer
     */
    public function Customer_Delete(array $params)
    {
        $params = array(3);

        return self::OPERATION_SUCCESS;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    protected static $_profiles = array(
        1 => array(
            'ProfileId' => 1,
            'Label' => 'Super Admin',
            'SuperAdmin' => '1',
            'AdminUsers' => '1',
            'AdminTrees' => '1',
            'AdminResources' => '1',
            'AdminStats' => '1',
            'AgentCapability' => '0'
        ),
        2 => array(
            'ProfileId' => 2,
            'Label' => 'Admin Customer',
            'SuperAdmin' => '0',
            'AdminUsers' => '1',
            'AdminTrees' => '1',
            'AdminResources' => '1',
            'AdminStats' => '1',
            'AgentCapability' => '0'
        ),
        3 => array(
            'ProfileId' => 3,
            'Label' => 'Agent',
            'SuperAdmin' => '0',
            'AdminUsers' => '0',
            'AdminTrees' => '0',
            'AdminResources' => '0',
            'AdminStats' => '0',
            'AgentCapability' => '1'
        ),
    );

    protected static $_users = array(
        1 => array(
            'UserId' => 1,
            'Name' => 'Super admin',
            'EmailAddress' => 'supervision@streamwide.com',
            'Password' => 'stream!wide',
            'TemporaryPassword' => '0',
            'ProfileId' => 1,
            'ProfileLabel' => null,
            'ParentUserId' => null,
            'ParentUserName' => null,
            'CustomerAccountId' => null,
            'CustomerAccountName' => null,
            'LastLoginDatetime' => '2010-06-22T08:26:08+08:00',
            'IsLocked' => false,
            'AgentParameters' => null,
        ),
        2 => array(
            'UserId' => 2,
            'Name' => 'Test user',
            'EmailAddress' => 'test@streamwide.com',
            'Password' => 'stream!test',
            'TemporaryPassword' => '0',
            'ProfileId' => 2,
            'ProfileLabel' => null,
            'ParentUserId' => 1,
            'ParentUserName' => 'Super admin',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => null,
            'LastLoginDatetime' => '2010-06-22T08:26:08+08:00',
            'IsLocked' => false,
            'AgentParameters' => null,
        ),
        3 => array(
            'UserId' => 3,
            'Name' => 'Test user',
            'EmailAddress' => 'test2@streamwide.com',
            'Password' => 'stream!test',
            'TemporaryPassword' => '0',
            'ProfileId' => 1,
            'ProfileLabel' => null,
            'ParentUserId' => 2,
            'ParentUserName' => 'Test user',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => null,
            'AgentParametersId' => null,
            'LastLoginDatetime' => '2010-06-22T08:26:08+08:00',
            'IsLocked' => false,
            'AgentParameters' => array(
                'AgentPhoneNumber' => '12345',
                'DisponibilityTime' => 10,
                'UnlimitedDisponibility' => false,
                'LoginDatetime' => '2010-05-26T17:20:02+0800',
            ),
        ),
        4 => array(
            'UserId' => 4,
            'Name' => 'Super admin',
            'EmailAddress' => 'supervision@streamwide.cn',
            'Password' => 'stream!wide',
            'TemporaryPassword' => '0',
            'ProfileId' => 1,
            'ProfileLabel' => null,
            'ParentUserId' => null,
            'ParentUserName' => null,
            'CustomerAccountId' => null,
            'CustomerAccountName' => null,
            'LastLoginDatetime' => '2010-06-22T08:26:08+08:00',
            'IsLocked' => true,
            'AgentParameters' => null,
        ),
    );

    /**
     * Getting the profiles
     *
     * @return array the list of profiles
     */
    public function User_GetProfiles()
    {
        return array_values(self::$_profiles);
    }

    /**
     * Getting profile by profile id
     *
     * @return array the profile structure
     */
    public function User_GetProfileById(array $params)
    {
        echo $profileId = $params[0];
        return self::$_profiles[$profileId];
    }

    /**
     * create an user
     */
    public function User_Create(array $params)
    {
        $users = self::$_users;
        shuffle($users);
        return $users[0]['UserId'];
    }

    /**
     * User.GetById
     */
    public function User_GetById(array $params)
    {
        $userId = $params[0];

        if (!array_key_exists($userId, self::$_users)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no user with the provided id', 40008001);
        }

        return self::$_users[$userId];
    }

    /**
     * user login
     */
    public function User_Login(array $params)
    {
        $email = $params[0];
        $password = $params[1];
        $data = null;
        foreach(self::$_users as $item) {
            if ($email == $item['EmailAddress']) {
                if ($password != $item['Password']) {
                    throw new Zend_XmlRpc_Client_FaultException('password error', 400002);
                } else if (true === $item['IsLocked']) {
                    throw new Zend_XmlRpc_Client_FaultException('User is locked', 400003);
                } else {
                    $data = $item;
                    break;
                }
            }
        }
        if (is_null($data)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no user with the provided login and password', 400004);
        }

        return $data;
    }

    /**
     * get user by customer
     */
    public function User_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 400005);
        }
        $data = array();
        foreach(self::$_users as $item) {
            if ($customerAccountId == $item['CustomerAccountId']) {
                $data[] = $item;
            }
        }
        return $data;
    }

    /**
     *
     */
    public function User_GetByNamePart(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 400005);
        }
        $namePart = isset($params[1]) ? $params[1] : '*';
        $data = array();
        foreach(self::$_users as $item) {
            if ($customerAccountId == $item['CustomerAccountId']
                && preg_match('/' . $namePart . '/i', $item['Name'])) {
                $data[] = $item;
            }
        }

        return $data;
    }

    /**
     * update user
     */
    public function User_Update(array $params)
    {
//        $params = array(
//        'UserId' => 3,// int The user id
//        'Name' => 'admin33',// string The user name
//        'EmailAddress' => 'admin3@admin3.com',// string The user email address
//        'Password' => 'admin3',// string The user password
//        'ProfileId' => 1,// int The granted profile id for user
//        'ProfileLabel' => 'Admin',// string The granted profile label for user
//        'ParentUserId' => 1, // int The parent user id
//        'ParentUserName' => 'mySelf',// string The parent user name
//        'CustomerAccountId' => 3,// int The customer account id user belongs to
//        'CustomerAccountName' => 'jack3',// string The customer account name user belongs to
//        'IsLocked' => false,// boolean The flag indicating if the user is locked
//        'AgentParameters' => array(),// struct The agent attributes for the user
//        'AgentPhoneNumber' => '12222222',// string The agent phone number
//        'DisponibilityTime' => 11111,// int The disponibility time in seconds
//        'UnlimitedDisponibility' => true,// boolean The flag indicating unlimited disponibility
//        'LoginDatetime' => '2010-05-26 12:12:12'// string The login date time'
//        );

        return self::OPERATION_SUCCESS;
    }

    /**
     * delete user
     */
    public function User_Delete(array $params)
    {
        $userId = $params[0];
        if (is_null($userId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no user with the provided id', 40008001);
        }

        return self::OPERATION_SUCCESS;
    }

    /**
     * count users
     */
    public function User_Count(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 400005);
        }

        $data = array();
        foreach(self::$_users as $item) {
            if ($customerAccountId == $item['CustomerAccountId']) {
                $datas[] = $item;
            }
        }

        return count($data);
    }

    /**
     * reset user
     */
    public function User_Reset(array $params)
    {
        return self::OPERATION_SUCCESS;
    }


    protected static $_premiumNumbers = array(
        1 => array(
            'PremiumNumberId' => 1,
            'PremiumNumber' => '1111',
            'PremiumNumberUI' => '1112',
            'SolutionId' => 1,
            'SolutionTypeId' => 2,
            'SolutionType' => 'Static',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => 'Templete 1',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'MaxCallDuration' => 20,
            'CreationDatetime' => '05/12/10 08:00',
            'StaticContactId' => 1,
            'StaticContactName' => 'Name',
            'StaticContactPhone' => '1111111'
        ),
        2 => array(
            'PremiumNumberId' => 2,
            'PremiumNumber' => '2222',
            'PremiumNumberUI' => '1112',
            'SolutionId' => 1,
            'SolutionTypeId' => 2,
            'SolutionType' => 'Full',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => 'Templete 1',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'MaxCallDuration' => 20,
            'CreationDatetime' => '05/12/10 08:00',
            'StaticContactId' => 1,
            'StaticContactName' => 'Name',
            'StaticContactPhone' => '1111111'
        ),
        3 => array(
            'PremiumNumberId' => 3,
            'PremiumNumber' => '1133',
            'PremiumNumberUI' => '1112',
            'SolutionId' => 2,
            'SolutionTypeId' => 2,
            'SolutionType' => 'Static',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => '',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'MaxCallDuration' => 20,
            'CreationDatetime' => '05/12/10 08:00',
            'StaticContactId' => 1,
            'StaticContactName' => 'Name',
            'StaticContactPhone' => '1111111'
        ),
        4 => array(
            'PremiumNumberId' => 4,
            'PremiumNumber' => '1144',
            'PremiumNumberUI' => '1112',
            'SolutionId' => 3,
            'SolutionTypeId' => 2,
            'SolutionType' => 'Static',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => '',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'MaxCallDuration' => 20,
            'CreationDatetime' => '05/12/10 08:00',
            'StaticContactId' => 1,
            'StaticContactName' => 'Name',
            'StaticContactPhone' => '1111111'
        ),
    );
    /**
     * create a premium number
     */
    public function PremiumNumber_Create(array $params)
    {
        $premiumNumbers = self::$_premiumNumbers;
        shuffle($premiumNumbers);
        return $premiumNumbers[0]['PremiumNumberId'];
    }

    /**
     * get premium number by its id
     */
    public function PremiumNumber_GetById(array $params)
    {
        $numberId = $params[0];
        return self::$_premiumNumbers[$numberId];
    }

    /**
     * get premium numbers assgined to a customer account, get all if id is missing
     */
    public function PremiumNumber_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            return self::$_premiumNumbers;
        } else {
            $datas = array();
            foreach(self::$_premiumNumbers as $number) {
                if ($customerAccountId == $number['CustomerAccountId']) {
                    $datas[] = $number;
                }
            }
            return $datas;
        }
    }

    /**
     * get ungrouped premium numbers of a specific solution and a customer account
     */
    public function PremiumNumber_GetNotGrouped(array $params)
    {
        $solutionId = $params[0];
        $datas = array();
        foreach(self::$_premiumNumbers as $number) {
            if ($solutionId == $number['SolutionId']) {
                $datas = $number;
            }
        }
        return $datas;
    }

    /**
     * search premium numbers that start with the partial number, search all if id is missing
     */
    public function PremiumNumber_GetByNumberPart(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 40002001);
        }
        $numberPart = isset($params[1]) ? $params[1] : '*';
        $datas = array();
        foreach(self::$_premiumNumbers as $item) {
            if ($customerAccountId == $item['CustomerAccountId']
                && preg_match('/' . $numberPart . '/i', $item['PremiumNumber'])) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     * delete a premium number
     */
    public function PremiumNumber_Delete(array $params)
    {
        $params = array();
        return self::OPERATION_SUCCESS;
    }

    /**
     * update a premium number by its id
     */
    public function PremiumNumber_Update(array $params)
    {
        $params = array();
        return self::OPERATION_SUCCESS;
    }

    /**
     * count premium numbers, count all if id is missing
     */
    public function PremiumNumber_Count(array $params)
    {
        return 5;
    }


    private static $_premiumNumberGroups = array(
        1 => array(
            'PremiumNumberGroupId' => 1,
            'PremiumNumberGroupName' => 'Group 1',
            'SolutionId' => 1,
            'SolutionTypeId' => 1,
            'SolutionType' => 'Full',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => 'Templete 1',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'CustomerUserId' => 1,
            'CustomerUserName' => 'User Name',
            'CreationDatetime' => '05/05/2010 08:00',
            'ModificationDatetime' => '05/05/2010 08:00',
            'EmergencyTreeId' => 1,
            'EmergencyActivated' => true,
        ),
        2 => array(
            'PremiumNumberGroupId' => 2,
            'PremiumNumberGroupName' => 'Group 2',
            'SolutionId' => 1,
            'SolutionTypeId' => 1,
            'SolutionType' => 'Static',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => '',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'CustomerUserId' => 1,
            'CustomerUserName' => 'User Name',
            'CreationDatetime' => '05/05/2010 08:00',
            'ModificationDatetime' => '05/05/2010 08:00',
            'EmergencyTreeId' => 1,
            'EmergencyActivated' => false,
        ),
        3 => array(
            'PremiumNumberGroupId' => 3,
            'PremiumNumberGroupName' => 'Group 3',
            'SolutionId' => 1,
            'SolutionTypeId' => 1,
            'SolutionType' => 'Full',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => 'Templete 3',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'CustomerUserId' => 1,
            'CustomerUserName' => 'User Name',
            'CreationDatetime' => '05/05/2010 08:00',
            'ModificationDatetime' => '05/05/2010 08:00',
            'EmergencyTreeId' => 1,
            'EmergencyActivated' => true,
        ),
    );

    /**
     * create a premium number group
     */
    public function PremiumNumberGroup_Create(array $params)
    {
        $premiumNumberGroups = self::$_premiumNumberGroups;
        shuffle($premiumNumberGroups);
        return $premiumNumberGroups[0]['PremiumNumberGroupId'];
    }

    /**
     * get a premium number group by its id
     */
    public function PremiumNumberGroup_GetById(array $params)
    {
        $premiumNumberGroupId = $params[0];
        return self::$_premiumNumberGroups[$premiumNumberGroupId];
    }

    /**
     * get premium number groups by cutomer account id
     */
    public function PremiumNumberGroup_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        $datas = array();
        foreach(self::$_premiumNumberGroups as $item) {
            if ($customerAccountId === $item['CustomerAccountId']) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     * get premium number groups by partial name
     */
    public function PremiumNumberGroup_GetByNamePart(array $params)
    {
        $customerAccountId = $params[0];
        if (is_null($customerAccountId)) {
            throw new Zend_XmlRpc_Client_FaultException('There is no CustomerAccount with the provided id', 400005);
        }
        $namePart = isset($params[1]) ? $params[1] : '*';
        $data = array();
        foreach(self::$_premiumNumberGroups as $item) {
            if ($customerAccountId == $item['CustomerAccountId']
                && preg_match('/' . $namePart . '/i', $item['PremiumNumberGroupName'])) {
                $data[] = $item;
            }
        }

        return $data;
    }

    /**
     * update a premium number group by its id
     */
    public function PremiumNumberGroup_Update(array $params)
    {
        //$params = array(1, array('Group', 1, false));
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete a premium number group by its id
     */
    public function PremiumNumberGroup_Delete(array $params)
    {
        //$params = array(1);
        return self::OPERATION_SUCCESS;
    }

    /**
     * count premium number groups by customer account id
     */
    public function PremiumNumberGroup_GetPremiumNumbers(array $params)
    {
        $params = array(1);
        return array(
        array(
        'PremiumNumberId' => 1,  // int The premium number id
        'PremiumNumber' => '1111',   //  string The actual premium number
        'PremiumNumberUI' => '1111',  //string The presented premium number
        'SolutionId' => 1,  // int The solution id the premium number belongs to
        'SolutionTypeId' => 1,   //int The solution type id
        'SolutionType' => 'Full',  //string The solution type literal
        'TemplateTreeId' => 1,  //int The template tree id assigned to restricted solution
        'TemplateTreeLabel' => 'Templete1',  //string The template tree label
        'CustomerAccountId' => 1,  //int The customer account id the premium number is assigned to
        'CustomerAccountName' => 'CustomeName1',   //string The customer account label
        'MaxCallDuration' => 20,  //int The maximum call duraion in seconds for this premium number
        'CreationDatetime' => '05/18/2010',  //string The creation date time
        'StaticContactId' => 1,  //int The redirected contact id for the static premium number
        'StaticContactName' => 'ContactName1',   //string The redirected contact name for the static premium number
        'StaticContactPhone' => ''   //string The redirected contact phone for the static premium number
        ),
        array(
        'PremiumNumberId' => 2,  // int The premium number id
        'PremiumNumber' => '1112',   //  string The actual premium number
        'PremiumNumberUI' => '1112',  //string The presented premium number
        'SolutionId' => 2,  // int The solution id the premium number belongs to
        'SolutionTypeId' => 2,   //int The solution type id
        'SolutionType' => 'Static',  //string The solution type literal
        'TemplateTreeId' => 1,  //int The template tree id assigned to restricted solution
        'TemplateTreeLabel' => 'Templete2',  //string The template tree label
        'CustomerAccountId' => 1,  //int The customer account id the premium number is assigned to
        'CustomerAccountName' => 'CustomeName2',   //string The customer account label
        'MaxCallDuration' => 20,  //int The maximum call duraion in seconds for this premium number
        'CreationDatetime' => '05/18/2010',  //string The creation date time
        'StaticContactId' => 1,  //int The redirected contact id for the static premium number
        'StaticContactName' => 'ContactName2',   //string The redirected contact name for the static premium number
        'StaticContactPhone' => '1124'   //string The redirected contact phone for the static premium number
        ),
        array(
        'PremiumNumberId' => 3,  // int The premium number id
        'PremiumNumber' => '1113',   //  string The actual premium number
        'PremiumNumberUI' => '1113',  //string The presented premium number
        'SolutionId' => 1,  // int The solution id the premium number belongs to
        'SolutionTypeId' => 1,   //int The solution type id
        'SolutionType' => 'Full',  //string The solution type literal
        'TemplateTreeId' => 1,  //int The template tree id assigned to restricted solution
        'TemplateTreeLabel' => '',  //string The template tree label
        'CustomerAccountId' => 1,  //int The customer account id the premium number is assigned to
        'CustomerAccountName' => 'CustomeName3',   //string The customer account label
        'MaxCallDuration' => 20,  //int The maximum call duraion in seconds for this premium number
        'CreationDatetime' => '05/18/2010',  //string The creation date time
        'StaticContactId' => 1,  //int The redirected contact id for the static premium number
        'StaticContactName' => 'ContactName3',   //string The redirected contact name for the static premium number
        'StaticContactPhone' => '1125'   //string The redirected contact phone for the static premium number
        )
        );
    }

    /**
     * add premium numbers to premium number group
     */
    public function PremiumNumberGroup_AddPremiumNumbers(array $params)
    {
        $params = array(1, array(1,2));
        return self::OPERATION_SUCCESS;
    }

    /**
     * remove premium numbers from premium number group
     */
    public function PremiumNumberGroup_RemovePremiumNumbers(array $params)
    {
        $params = array(1, array(1,2));
        return self::OPERATION_SUCCESS;
    }

    /**
     * get allocated trees by premium number group id
     */
    public function PremiumNumberGroup_GetAllocatedTrees(array $params)
    {
        $params = array(1);
        return array(
        array(
        'RoutingPlanId' => 1,
        'TreeId' => 1,
        'TreeLabel' => 'TreeLabel 1',
        'StartDatetime' => '2010-04-05 08:00',
        'EndDatetime' => '2010-04-07 18:00'
        ),
        array(
        'RoutingPlanId' => 2,
        'TreeId' => 2,
        'TreeLabel' => 'TreeLabel 2',
        'StartDatetime' => '2010-04-05 08:00',
        'EndDatetime' => '2010-04-05 08:00'
        ),
        array(
        'RoutingPlanId' => 3,
        'TreeId' => 3,
        'TreeLabel' => 'TreeLabel 3',
        'StartDatetime' => '2010-04-05 08:00',
        'EndDatetime' => '2010-04-05 08:00'
        )
        );
    }

    /**
     * add allocated tree for a premium number group id
     */
    public function PremiumNumberGroup_AddAllocatedTree(array $params)
    {
        $params = array(1,
        array(
        'TreeId' => 1,
        'StartDatetime' => '24/12/09 08:00',
        'EndDatetime' => '24/12/09 10:00'
        )
        );
        return 3;
    }

    /**
     * remove an allocated tree for a premium number group
     */
    public function PremiumNumberGroup_RemoveAllocatedTree(array $params)
    {
        $params = array(3);
        return self::OPERATION_SUCCESS;
    }

    public function PremiumNumberGroup_Count(array $params)
    {
        return 11;
    }

    /**
     * update tree or time to a allocated tree for a premium number group id
     */
    public function PremiumNumberGroup_UpdateAllocatedTree(array $params)
    {
        $params = array(
        array(
        'RoutingPlanId' => 2,
        'TreeId' => 1,
        'StartDatetime' => '24/12/09 08:00',
        'EndDatetime' => '24/12/09 10:00'
        )
        );
        return self::OPERATION_SUCCESS;
    }

    /**
     * get all solutions
     */
    public function Solution_GetAll(array $params)
    {
        $params = array();
        return array(
            array(
                'SolutionId' => 1,
                'SolutionTypeId' => 1,
                'SolutionType' => 'Static',
                'TemplateTreeId' => 1,
                'TemplateTreeLabel' => 'Templete Tree Label 1'
            ),
            array(
                'SolutionId' => 2,
                'SolutionTypeId' => 2,
                'SolutionType' => 'Restricted',
                'TemplateTreeId' => 2,
                'TemplateTreeLabel' => 'Templete Tree Label 2'
            ),
            array(
                'SolutionId' => 3,
                'SolutionTypeId' => 3,
                'SolutionType' => 'Full',
                'TemplateTreeId' => 3,
                'TemplateTreeLabel' => 'Templete Tree Label 3'
            ),
        );
    }

    protected static $_trunks = array(
        1 => array(
            'TrunkId' => 1,
            'Label' => 'My Trunk Name1',
            'ExternalId' => 'My Trunk Name1',
            'IpAddress' => '1.1.1.1',
            'Port' => 3000,
            'TrunkStatusId' => 1,
            'TrunkStatus' => 'use',
            'CreationDatetime' => '05/31/10 08:00'
        ),
        2 => array(
            'TrunkId' => 2,
            'Label' => 'My Trunk Name2',
            'ExternalId' => 'My Trunk Name2',
            'IpAddress' => '1.1.1.1',
            'Port' => 3000,
            'TrunkStatusId' => 1,
            'TrunkStatus' => 'use',
            'CreationDatetime' => '05/31/10 08:00'
        ),
        3 => array(
            'TrunkId' => 3,
            'Label' => 'My Trunk Name3',
            'ExternalId' => 'My Trunk Name3',
            'IpAddress' => '1.1.1.1',
            'Port' => 3000,
            'TrunkStatusId' => 1,
            'TrunkStatus' => 'use',
            'CreationDatetime' => '05/31/10 08:00'
        )
    );
    /**
     * create a trunk
     */
    public function Trunk_Create(array $params)
    {
        $trunks = self::$_trunks;
        shuffle($trunks);
        return $trunks[0]['TrunkId'];
    }

    /**
     * get trunk by id
     */
    public function Trunk_GetById(array $params)
    {
        $trunkId = $params[0];
        return self::$_trunks[$trunkId];
    }

    /**
     * get all trunks
     */
    public function Trunk_GetAll(array $params)
    {
        return self::$_trunks;
    }

    /**
     * get trunk by partName
     */
    public function Trunk_GetByLabelPart(array $params)
    {
        $labelPart = $params[0];
        $datas = array();
        foreach(self::$_trunks as $trunk) {
            if (preg_match('/'. $labelPart. '/i', $trunk['Label'])) {
                $datas[] = $trunk;
            }
        }
        return $datas;
    }

    /**
     * update a trunk
     */
    public function Trunk_Update(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete a trunk
     */
    public function Trunk_Delete(array $params)
    {
        return self::OPERATION_SUCCESS;
    }

    /**
     * count trunks
     */
    public function Trunk_Count(array $params)
    {
        $label = isset($params[0]) ? $params[0] : null;
        $count = 0;
        if ($label != null) {
            foreach(self::$_trunks as $trunk) {
                if (preg_match('/'. $label. '/i', $trunk['Label'])) {
                    $count++;
                }
            }
            return $count;
        } else {
            return count(self::$_trunks);
        }
    }

    /**
     * get trunk status
     */
    public function Trunk_GetStatuses(array $params)
    {
        $params = array();

        return array(
            array(
                'TrunkStatusId' => 1,
                'TrunkStatus' => 'use'
            ),
            array(
                'TrunkStatusId' => 2,
                'TrunkStatus' => 'no use'
            )
        );
    }

    /**
     * get trunkgroups by trunk id
     */
    public function Trunk_GetTrunkGroups(array $params)
    {
        $params = array(1);

        return array(
            array(
                'TrunkGroupId' => 1,
                'TrunkGroupLabel' => 'Trunk Group 1'
            ),
            array(
                'TrunkGroupId' => 2,
                'TrunkGroupLabel' => 'Trunk Group 2'
            ),
            array(
                'TrunkGroupId' => 3,
                'TrunkGroupLabel' => 'Trunk Group 3'
            )
        );
    }

    protected static $_trunkGroups = array(
    	1 => array(
    		'TrunkGroupId' => 1,
    		'Label' => 'Trunk Group 1',
    		'CreationDatetime' => '05/31/10 08:00',
    		'TrunkCount' => 1
    	),
    	2 => array(
    		'TrunkGroupId' => 2,
    		'Label' => 'Trunk Group 2',
    		'CreationDatetime' => '05/31/10 08:00',
    		'TrunkCount' => 1
    	),
    	3 => array(
    		'TrunkGroupId' => 3,
    		'Label' => 'Trunk Group 3',
    		'CreationDatetime' => '05/31/10 08:00',
    		'TrunkCount' => 1
    	),
    	4 => array(
    		'TrunkGroupId' => 4,
    		'Label' => 'Trunk Group 4',
    		'CreationDatetime' => '05/31/10 08:00',
    		'TrunkCount' => 1
    	)
    );
    
    /**
     * create a trunkgroup
     */
    public function TrunkGroup_Create(array $params)
    {
    	$datas = array();
        $datas = self::$_trunkGroups;
        shuffle($datas);
        
        return $datas[0]['TrunkGroupId'];
    }

    /**
     * get trunkgroup by id
     */
    public function TrunkGroup_GetById(array $params)
    {
        $trunkGroupId = $params[0];
        $data = array();
        foreach (self::$_trunkGroups as $trunkGroup) {
        	if ($trunkGroup['TrunkGroupId'] == $trunkGroupId) {
        		$data = $trunkGroup;
        		break;
        	}
        }
        
        return $data;
    }

    /**
     * get all trunkgroups
     */
    public function TrunkGroup_GetAll(array $params)
    {
        return self::$_trunkGroups;
    }

    /**
     * get trunkgroup by partName
     */
    public function TrunkGroup_GetByLabelPart(array $params)
    {
        $labelPart = isset($params[0]) ? $params[0] : null;
        $datas = array();
        foreach (self::$_trunkGroups as $trunkGroup) {
        	if (preg_match('/' . $labelPart . '/i', $trunkGroup['Label'])) {
        		$datas[] = $trunkGroup;
        	}
        }
        
        return $datas;
    }

    /**
     * update trunkgroup
     */
    public function TrunkGroup_Update(array $params)
    {
        $params = array(
        'TrunkGroupId' => 1,
        'Label' => 'Trunk Group 11'
        );

        return self::OPERATION_SUCCESS;
    }

    /**
     * get trunks in the trunkgroup
     */
    public function TrunkGroup_GetTrunks(array $params)
    {
        $params = array(1);

        return array(
        array(
        'TrunkId' => 1,
        'Label' => 'My Trunk Name1',
        'ExternalId' => 'My Trunk Name1',
        'IpAddress' => '1.1.1.1',
        'Port' => 3000,
        'TrunkStatusId' => 1,
        'TrunkStatus' => 'use',
        'CreationDatetime' => '05/31/10 08:00'
        )
        );
    }

    /**
     * add trunks to trunkGroup
     */
    public function TrunkGroup_AddTrunks(array $params)
    {
        $params = array(1, array(2, 3));

        return self::OPERATION_SUCCESS;
    }

    /**
     * remove trunks from trunkGroup
     */
    public function TrunkGroup_RemoveTrunks(array $params)
    {
        $params = array(1, array(2, 3));

        return self::OPERATION_SUCCESS;
    }

    /**
     * delete a trunkgroup
     */
    public function TrunkGroup_Delete(array $params)
    {
        $params = array(1);

        return self::OPERATION_SUCCESS;
    }

    /**
     * count trunkgroups
     */
    public function TrunkGroup_Count(array $params)
    {
	    $namePart = isset($params[0]) ? $params[0] : null;
	        if ($namePart != null) {
	        	$count = 0;
	        	foreach (self::$_trunkGroups as $trunkGroup) {
	        		if (preg_match('/' . $namePart . '/i', $trunkGroup['TrunkGroupName'])) {
	        			$count++;
	        		}
	        	}
	        	return $count;
	        } else {
	        	return count(self::$_trunkGroups);
	        }
    }

    protected static $_trunkRoutes = array(
    	1 => array(
    		'Prefix' => 'route 1',
			'PrimaryTrunkGroupId' => 1,
			'PrimaryTrunkGroupLabel' => 'Trunk Group 1',
			'SecondaryTrunkGroupId' => 2,
			'SecondaryTrunkGroupLabel' => 'Trunk Group 2',
			'CreationDatetime' => '05/31/10 08:00'
    	),
    	2 => array(
    		'Prefix' => 'route 2',
			'PrimaryTrunkGroupId' => 2,
			'PrimaryTrunkGroupLabel' => 'Trunk Group 2',
			'SecondaryTrunkGroupId' => 3,
			'SecondaryTrunkGroupLabel' => 'Trunk Group 3',
			'CreationDatetime' => '05/31/10 08:00'
    	),
    	3 => array(
    		'Prefix' => 'route 3',
			'PrimaryTrunkGroupId' => 3,
			'PrimaryTrunkGroupLabel' => 'Trunk Group 3',
			'SecondaryTrunkGroupId' => 4,
			'SecondaryTrunkGroupLabel' => 'Trunk Group 4',
			'CreationDatetime' => '05/31/10 08:00'
    	)
    );
    
    /**
     * import trunk route
     */
    public function TrunkRoute_Import(array $params)
    {
        $params = array();

        return self::OPERATION_SUCCESS;
    }

    /**
     * get all trunk routes
     */
    public function TrunkRoute_GetAll(array $params)
    {
        $datas = array();
        $datas = self::$_trunkRoutes;
        
        return $datas;
    }

    /**
     * get trunkroute by partname
     */
    public function TrunkRoute_GetByNamePart(array $params)
    {
        $namePart = isset($params[0]) ? $params[0] : null;
        $datas = array();
        foreach (self::$_trunkRoutes as $trunkRoute) {
        	if (preg_match('/' . $namePart . '/i', $trunkRoute['Prefix'])) {
        		$datas[] = $trunkRoute;
        	}
        }
        
        return $datas;
    }
    
    /**
     * get trunkroute by labelPart
     */
	public function TrunkRoute_GetByLabelPart(array $params)
    {
        $labelPart = isset($params[0]) ? $params[0] : null;
        $datas = array();
        foreach (self::$_trunkRoutes as $trunkRoute) {
        	if (preg_match('/' . $labelPart . '/i', $trunkRoute['Prefix'])) {
        		$datas[] = $trunkRoute;
        	}
        }
        
        return $datas;
    }

    /**
     * count trunkroute
     */
    public function TrunkRoute_Count(array $params)
    {
        $prefixPart = isset($params[0]) ? $params[0] : null;
        if ($prefixPart != null) {
        	$count = 0;
        	foreach (self::$_trunkRoutes as $trunkRoute) {
        		if (preg_match('/' . $prefixPart . '/i', $trunkRoute['Prefix'])) {
        			$count++;
        		}
        	}
        	return $count;
        } else {
        	return count(self::$_trunkRoutes);
        }
    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    protected static $_treeLists = array(
        1 => array(
            'TreeId' => 1,//int The tree id
            'Label' => 'Tree 1',//string The tree label
            'IsTemplate' => false,//boolean The flag indicating if the tree is a template
            'ParentTreeId' => null,//int The parent tree id if create a sub tree
            'ParentTreeLabel' => null,//string The parent tree label
            'NodeConstraints' => 'NodeConstraints',//string The json string for node constraints of the template
            'SolutionId' => 1,//int The solution id if the tree
            'SolutionTypeId' => 1,//int The solution type id
            'SolutionType' => 'Full',//string The solution type literal
            'TemplateTreeId' => 1,//int The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => 'TempleteLabel1',//string the template label
            'StatusId' => 1,//int The id of tree status
            'StatusLabel' => 'In Use',//string The status literal of tree
            'CustomerUserId' => 1,//int The id of user who creates the tree
            'CustomerUserName' => 'User Name',//string The name of user who creates the tree
            'CustomerAccountId' => 1,//int The id of account whose user creates the tree
            'RootNodeId'  => 1,//int The root node of the tree
            'RootNodeLabel' => 'RootNodeLabel',//string The root node label of the tree
            'CreationDatetime' => '2010-05-26T17:20:02+0100',//string The creation date time
            'ModificationDatetime' => '2010-05-26T17:20:02+0100'   //string The modification date time
        ),
        2 => array(
            'TreeId' => 2,//int The tree id
            'Label' => 'Tree 2',//string The tree label
            'IsTemplate' => false,//boolean The flag indicating if the tree is a template
            'ParentTreeId' => 1,//int The parent tree id if create a sub tree
            'ParentTreeLabel' => 'Parent Tree',//string The parent tree label
            'NodeConstraints' => 'NodeConstraints',//string The json string for node constraints of the template
            'SolutionId' => 1,//int The solution id if the tree
            'SolutionTypeId' => 1,//int The solution type id
            'SolutionType' => 'Static',//string The solution type literal
            'TemplateTreeId' => 1,//int The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => 'TempleteLabel2',//string the template label
            'StatusId' => 1,//int The id of tree status
            'StatusLabel' => 'Active',//string The status literal of tree
            'CustomerUserId' => 1,//int The id of user who creates the tree
            'CustomerUserName' => 'User Name',//string The name of user who creates the tree
            'CustomerAccountId' => 1,//int The id of account whose user creates the tree
            'RootNodeId'  => 1,//int The root node of the tree
            'RootNodeLabel' => 'RootNodeLabel',//string The root node label of the tree
            'CreationDatetime' => '2010-05-26T17:20:02+0800',//string The creation date time
            'ModificationDatetime' => '2010-05-26T17:20:02+0800'   //string The modification date time
        ),
        3 => array(
            'TreeId' => 3,//int The tree id
            'Label' => 'Tree 3',//string The tree label
            'IsTemplate' => false,//boolean The flag indicating if the tree is a template
            'ParentTreeId' => 1,//int The parent tree id if create a sub tree
            'ParentTreeLabel' => 'Parent Tree',//string The parent tree label
            'NodeConstraints' => 'NodeConstraints',//string The json string for node constraints of the template
            'SolutionId' => 1,//int The solution id if the tree
            'SolutionTypeId' => 1,//int The solution type id
            'SolutionType' => 'Full',//string The solution type literal
            'TemplateTreeId' => 1,//int The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => '',//string the template label
            'StatusId' => 3,//int The id of tree status
            'StatusLabel' => 'Inactive',//string The status literal of tree
            'CustomerUserId' => 1,//int The id of user who creates the tree
            'CustomerUserName' => 'User Name',//string The name of user who creates the tree
            'CustomerAccountId' => 1,//int The id of account whose user creates the tree
            'RootNodeId'  => 1,//int The root node of the tree
            'RootNodeLabel' => 'RootNodeLabel',//string The root node label of the tree
            'CreationDatetime' => '2010-05-26T17:20:02+0800',//string The creation date time
            'ModificationDatetime' => '2010-05-26T17:20:02+0800'   //string The modification date time
        ),
        4 => array(
            'TreeId' => 4, //int The tree id
            'Label' => 'test sub tree 4', //string The tree label
            'IsTemplate' => false, //boolean The flag indicating if the tree is a template
            'ParentTreeId' => 1, //int[optional] The parent tree id if create a sub tree
            'ParentTreeLabel' => null, //string[optional] The parent tree label
            'NodeConstraints' => '', //string The json string for node constraints of the template
            'SolutionId' => 1, //int The solution id if the tree
            'SolutionTypeId' => 1, //int The solution type id
            'SolutionType' => 'full', //string The solution type literal
            'TemplateTreeId' => null, //int[optional] The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => null, //string[optional] the template label
            'StatusId' => 1, //int The id of tree status
            'StatusLabel' => 'active', //string The status literal of tree
            'CustomerUserId' => 1, //int The id of user who creates the tree
            'CustomerUserName' => 'Tester', //string The name of user who creates the tree
            'CustomerAccountId' => 'Streamwide', //int The id of account whose user creates the tree
            'RootNodeId' => null, //int[optional] The root node of the tree
            'RootNodeLabel' => 'origin 1', //string[optional] The root node label of the tree
            'CreationDatetime' => '2010-05-18T17:10:02+0800', //string The creation date time
            'ModificationDatetime' => '2010-05-18T17:10:02+0800' //string The modification date time
        ),
        5 => array(
            'TreeId' => 5, //int The tree id
            'Label' => 'test sub tree 5', //string The tree label
            'IsTemplate' => false, //boolean The flag indicating if the tree is a template
            'ParentTreeId' => 1, //int[optional] The parent tree id if create a sub tree
            'ParentTreeLabel' => 'first test tree', //string[optional] The parent tree label
            'NodeConstraints' => '', //string The json string for node constraints of the template
            'SolutionId' => 1, //int The solution id if the tree
            'SolutionTypeId' => 1, //int The solution type id
            'SolutionType' => 'full', //string The solution type literal
            'TemplateTreeId' => null, //int[optional] The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => null, //string[optional] the template label
            'StatusId' => 1, //int The id of tree status
            'StatusLabel' => 'active', //string The status literal of tree
            'CustomerUserId' => 1, //int The id of user who creates the tree
            'CustomerUserName' => 'Tester', //string The name of user who creates the tree
            'CustomerAccountId' => 'Streamwide', //int The id of account whose user creates the tree
            'RootNodeId' => null, //int[optional] The root node of the tree
            'RootNodeLabel' => 'origin 1', //string[optional] The root node label of the tree
            'CreationDatetime' => '2010-05-18T17:10:02+0800', //string The creation date time
            'ModificationDatetime' => '2010-05-18T17:10:02+0800' //string The modification date time
        ),
        6 => array(
            'TreeId' => 6, //int The tree id
            'Label' => 'test sub tree 6', //string The tree label
            'IsTemplate' => false, //boolean The flag indicating if the tree is a template
            'ParentTreeId' => 1, //int[optional] The parent tree id if create a sub tree
            'ParentTreeLabel' => 'first test tree', //string[optional] The parent tree label
            'NodeConstraints' => '', //string The json string for node constraints of the template
            'SolutionId' => 1, //int The solution id if the tree
            'SolutionTypeId' => 1, //int The solution type id
            'SolutionType' => 'full', //string The solution type literal
            'TemplateTreeId' => null, //int[optional] The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => null, //string[optional] the template label
            'StatusId' => 1, //int The id of tree status
            'StatusLabel' => 'active', //string The status literal of tree
            'CustomerUserId' => 1, //int The id of user who creates the tree
            'CustomerUserName' => 'Tester', //string The name of user who creates the tree
            'CustomerAccountId' => 'Streamwide', //int The id of account whose user creates the tree
            'RootNodeId' => null, //int[optional] The root node of the tree
            'RootNodeLabel' => 'origin 1', //string[optional] The root node label of the tree
            'CreationDatetime' => '2010-05-18T17:10:02+0800', //string The creation date time
            'ModificationDatetime' => '2010-05-18T17:10:02+0800' //string The modification date time
        ),
        7 => array(
            'TreeId' => 7, //int The tree id
            'Label' => 'test sub tree 7', //string The tree label
            'IsTemplate' => false, //boolean The flag indicating if the tree is a template
            'ParentTreeId' => 1, //int[optional] The parent tree id if create a sub tree
            'ParentTreeLabel' => 'first test tree', //string[optional] The parent tree label
            'NodeConstraints' => '', //string The json string for node constraints of the template
            'SolutionId' => 1, //int The solution id if the tree
            'SolutionTypeId' => 1, //int The solution type id
            'SolutionType' => 'full', //string The solution type literal
            'TemplateTreeId' => null, //int[optional] The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => null, //string[optional] the template label
            'StatusId' => 1, //int The id of tree status
            'StatusLabel' => 'active', //string The status literal of tree
            'CustomerUserId' => 1, //int The id of user who creates the tree
            'CustomerUserName' => 'Tester', //string The name of user who creates the tree
            'CustomerAccountId' => 'Streamwide', //int The id of account whose user creates the tree
            'RootNodeId' => null, //int[optional] The root node of the tree
            'RootNodeLabel' => 'origin 1', //string[optional] The root node label of the tree
            'CreationDatetime' => '2010-05-18T17:10:02+0800', //string The creation date time
            'ModificationDatetime' => '2010-05-18T17:10:02+0800' //string The modification date time
        ),
        8 => array(
            'TreeId' => 8, //int The tree id
            'Label' => 'test tree 8', //string The tree label
            'IsTemplate' => true, //boolean The flag indicating if the tree is a template
            'ParentTreeId' => null, //int[optional] The parent tree id if create a sub tree
            'ParentTreeLabel' => null, //string[optional] The parent tree label
            'NodeConstraints' => '', //string The json string for node constraints of the template
            'SolutionId' => 1, //int The solution id if the tree
            'SolutionTypeId' => 1, //int The solution type id
            'SolutionType' => 'full', //string The solution type literal
            'TemplateTreeId' => null, //int[optional] The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => null, //string[optional] the template label
            'StatusId' => 1, //int The id of tree status
            'StatusLabel' => 'active', //string The status literal of tree
            'CustomerUserId' => 1, //int The id of user who creates the tree
            'CustomerUserName' => 'Tester', //string The name of user who creates the tree
            'CustomerAccountId' => 'Streamwide', //int The id of account whose user creates the tree
            'RootNodeId' => null, //int[optional] The root node of the tree
            'RootNodeLabel' => 'origin 1', //string[optional] The root node label of the tree
            'CreationDatetime' => '2010-05-18T17:10:02+0100', //string The creation date time
            'ModificationDatetime' => '2010-05-18T17:10:02+0100' //string The modification date time
        ),
        9 => array(
            'TreeId' => 9, //int The tree id
            'Label' => 'test sub tree 9', //string The tree label
            'IsTemplate' => true, //boolean The flag indicating if the tree is a template
            'ParentTreeId' => 8, //int[optional] The parent tree id if create a sub tree
            'ParentTreeLabel' => 'test tree 8', //string[optional] The parent tree label
            'NodeConstraints' => '', //string The json string for node constraints of the template
            'SolutionId' => 1, //int The solution id if the tree
            'SolutionTypeId' => 1, //int The solution type id
            'SolutionType' => 'full', //string The solution type literal
            'TemplateTreeId' => null, //int[optional] The template tree id if create a tree for restricted solution
            'TemplateTreeLabel' => null, //string[optional] the template label
            'StatusId' => 1, //int The id of tree status
            'StatusLabel' => 'active', //string The status literal of tree
            'CustomerUserId' => 1, //int The id of user who creates the tree
            'CustomerUserName' => 'Tester', //string The name of user who creates the tree
            'CustomerAccountId' => 'Streamwide', //int The id of account whose user creates the tree
            'RootNodeId' => null, //int[optional] The root node of the tree
            'RootNodeLabel' => 'origin 1', //string[optional] The root node label of the tree
            'CreationDatetime' => '2010-05-18T17:10:02+0100', //string The creation date time
            'ModificationDatetime' => '2010-05-18T17:10:02+0800' //string The modification date time
        ),
    );

    /**
     * get trees by customer account id and optionally further restricted by solution
     */
    public function Tree_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        $datas = array();
        foreach(self::$_treeLists as $item) {
            if ($customerAccountId == $item['CustomerAccountId']
                && false === $item['IsTemplate']) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     * get all nodes of the tree, optionally from specified node id.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array The list of nodes of the tree
     */
    public function Tree_GetNodes(array $params)
    {
        // The first one is the TreeId
        $id = $params[0];
        // The second one is the specified node id
        $nodeId = isset($params[1]) ? $params[1] : null;

        $datas = array(
        array(
        'NodeId' => 1,  //int The node id
        'Label' => 'origin 1', //string The node label
        'NodeTypeId' => 1, // int The node type id
        'NodeType' => 'origin', // string The node type
        'IsActive' => true, // boolean The flag indicating if the node is active
        'Outputs' => array( // The node outputs
        array(
        'NodeOutputId' => 11, //int the node output id
        'NodeId' => 1, // int the node id the output belongs to
        'NextNodeId' => 2, // int[optional] the next node id this output indicates
        'Label' => 'Paris', // string the node output label
        'IsDefault' => false, // boolean the flag indicating the output is default
        'IsActive' => true, //boolean the flag indicating the output is active
        'IsAllowed' => true //boolean the flag indicating the output is allowed
        ),
        array(
        'NodeOutputId' => 12,
        'NodeId' => 1,
        'NextNodeId' => null,
        'Label' => 'China',
        'IsDefault' => false,
        'IsActive' => true,
        'IsAllowed' => true
        ),
        array(
        'NodeOutputId' => 13,
        'NodeId' => 1,
        'NextNodeId' => null,
        'Label' => 'USA',
        'IsDefault' => false,
        'IsActive' => true,
        'IsAllowed' => true
        ),
        )
        ),
        array(
        'NodeId' => 2,  //int The node id
        'Label' => 'origin 1', //string The node label
        'NodeTypeId' => 1, // int The node type id
        'NodeType' => 'origin', // string The node type
        'IsActive' => true, // boolean The flag indicating if the node is active
        'Outputs' => array( // The node outputs
        array(
        'NodeOutputId' => 21, //int the node output id
        'NodeId' => 1, // int the node id the output belongs to
        'NextNodeId' => 3, // int[optional] the next node id this output indicates
        'Label' => 'Beijing', // string the node output label
        'IsDefault' => false, // boolean the flag indicating the output is default
        'IsActive' => true, //boolean the flag indicating the output is active
        'IsAllowed' => true //boolean the flag indicating the output is allowed
        ),
        )
        ),
        array(
        'NodeId' => 3,  //int The node id
        'Label' => 'End', //string The node label
        'NodeTypeId' => 3, // int The node type id
        'NodeType' => 'link', // string The node type
        'IsActive' => true, // boolean The flag indicating if the node is active
        'Outputs' => array( // The node outputs
        )
        ),
        array(
        'NodeId' => 4,  //int The node id
        'Label' => 'menu 1', //string The node label
        'NodeTypeId' => 4, // int The node type id
        'NodeType' => 'menu', // string The node type
        'IsActive' => true, // boolean The flag indicating if the node is active
        'Outputs' => array( // The node outputs
        array(
        'NodeOutputId' => 41, //int the node output id
        'NodeId' => 4, // int the node id the output belongs to
        'NextNodeId' => 1, // int[optional] the next node id this output indicates
        'Label' => 'key1', // string the node output label
        'IsDefault' => false, // boolean the flag indicating the output is default
        'IsActive' => true, //boolean the flag indicating the output is active
        'IsAllowed' => true //boolean the flag indicating the output is allowed
        ),
        array(
        'NodeOutputId' => 41, //int the node output id
        'NodeId' => 4, // int the node id the output belongs to
        'NextNodeId' => null, // int[optional] the next node id this output indicates
        'Label' => 'error', // string the node output label
        'IsDefault' => false, // boolean the flag indicating the output is default
        'IsActive' => true, //boolean the flag indicating the output is active
        'IsAllowed' => true //boolean the flag indicating the output is allowed
        ),
        )
        ),
        );
        if ($nodeId) {
            return array_slice($datas, rand(0, count($datas) - 1));
        }
        return $datas;
    }

    /**
     * get sub trees with a tree id
     *
     * @param array $params Array of parameters for the method
     *
     * @return array The list of trees whose parent is the specified tree id
     */
    public function Tree_GetSubTrees(array $params)
    {
        // The first one is the TreeId
        $id = $params[0];
        $datas = array();
        foreach(self::$_treeLists as $item) {
            if ($id = $item['ParentTreeId']) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     * Detail a tree by TreeId.
     *
     * @param array $params Array of parameters for the method
     *
     * @return array A structure of Tree
     */
    public function Tree_GetById(array $params)
    {
        // The first one is the TreeId
        $id = $params[0];
        return self::$_treeLists[$id];
    }

    /**
     * create a tree or tree template
     */
    public function Tree_Create(array $params)
    {
//        $params = array(
//            'Label' => 'Tree 5',
//            'IsTemplate' => false,
//            'ParentTreeId' => 1,
//            'NodeConstraints' => 'NodeConstraints',
//            'SolutionId' => 1,
//            'CustomerAccountId' => 1,
//            'CustomerUserId' => 1
//        );
        $treeLists = self::$_treeLists;
        shuffle($treeLists);
        return $treeLists[0]['TreeId'];
    }

    /**
     * update a tree
     */
    public function Tree_Update(array $params)
    {
//        $params = array(
//            'TreeId' => 1,
//            'Label' => 'Tree 4',
//            'RootNodeId' => 1,
//            'NodeConstraints' => 'NodeConstraints',
//            'StatusId' => 1
//        );
        return self::OPERATION_SUCCESS;
    }

    /**
     * delete a tree and all of its nodes by its id
     */
    public function Tree_Delete(array $params)
    {
        $id = $params[0];
        return self::OPERATION_SUCCESS;
    }

    public function Tree_GetLastModified(array $params)
    {
        $isTemplate = $params[0];
        $counter = isset($params[1]) ? $params[1] > 5 ? 5 : $params[1] : 5;
        $datas = array();
        foreach(self::$_treeLists as $item) {
            if (count($datas) > $counter) {
                break;
            }
            if ($isTemplate) {
                if ($item['IsTemplate']) {
                    $datas[] = $item;
                }
            } else {
                if (!$item['IsTemplate']) {
                    $datas[] = $item;
                }
            }
        }
        return $datas;
    }

    /**
     * count total number of trees  by customer account id
     */
    public function Tree_Count(array $params)
    {
        $customerAccountId = $params[0];
        $counter = 0;
        foreach(self::$_treeLists as $item) {
            if ($customerAccountId == $item['CustomerAccountId']
                && false === $item['IsTemplate']) {
                $counter++;
            }
        }
        return $counter;
    }

    /**
     *
     */
    public function Tree_CountTemplates(array $params)
    {
        $solutionId = isset($params[0]) ? $params[0] : null;
        $counter = 0;
        foreach(self::$_treeLists as $item) {
            if (true === $item['IsTemplate']) {
                if (null !== $solutionId && $solutionId != $item['SolutionId']) {
                    break;
                }
                $counter++;
            }
        }
        return $counter;
    }

    /**
     *
     */
    public function Tree_GetTemplates(array $params)
    {
        $solutionId = isset($params[0]) ? $params[0] : null;
        $datas = array();
        foreach(self::$_treeLists as $item) {
            if (true === $item['IsTemplate']) {
                if (null !== $solutionId && $solutionId != $item['SolutionId']) {
                    break;
                }
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     *
     */
    public function Tree_GetByLabelPart(array $params)
    {
        $customerAccountId = $params[0];
        $labelPart = $params[1];
        $datas = array();
        foreach(self::$_treeLists as $item) {
            if (false === $item['IsTemplate']
                && $customerAccountId == $item['CustomerAccountId']
                && preg_match('/' . $labelPart . '/i', $item['Label'])) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     *
     */
    public function Tree_GetTemplatesByLabelPart(array $params)
    {
        $labelPart = $params[0];
        $datas = array();
        foreach(self::$_treeLists as $item) {
            if (true === $item['IsTemplate']
                && preg_match('/' . $labelPart . '/i', $item['Label'])) {
                $datas[] = $item;
            }
        }
        return $datas;
    }

    /**
     * Copy a tree
     */
    public function Tree_Copy(array $params)
    {
        $treeId = $params[0];
        $treeLists = self::$_treeLists;
        unset($treeLists[$treeId]);
        shuffle($treeLists);
        return $treeLists[0]['TreeId'];
    }

    public function Tree_GetStatuses()
    {
        $datas = array(
            array(
                'StatusId' => 1,
                'Label' => 'Valid',
            ),
            array(
                'StatusId' => 2,
                'Label' => 'Active',
            ),
            array(
                'StatusId' => 3,
                'Label' => 'Edition',
            ),
        );

        return $datas;
    }

    public function Tree_GetNumberGroup(array $params)
    {
    }

    /**
     * Getting the list of outgoing types
     *
     * @return array the list of outgoing types
     */
    public function Outgoing_GetDestinationTypes()
    {
        return array(
        array( //The outgoing types structure
        'DestinationTypeId' => 1, // int The destination type id
        'DestinationType' => 'simple_number' // string The destination type literal
        ),
        array(
        'DestinationTypeId' => 2,
        'DestinationType' => 'agent_group'
        ),
        array(
        'DestinationTypeId' => 3,
        'DestinationType' => 'simplified_failover_group'
        ),
        );
    }

    /**
     * Getting the constraints default settings on Node Outgoing
     *
     * @return array the list of constraints default settings
     */
    public function Outgoing_GetNodeParameterDefault()
    {
        return array(
        'IsAgentGroupAllowed' => true, // boolean The agent group allowed flag
        'IsFailoverAllowed' => true, // boolean The failover allowed flag
        'IsWaitingQueueAllowed' => true, // boolean The waiting queue allowed flag
        'RingDuration' => 30, // int The ring duration in seconds
        'WaitingQueue' => array(
        'HasWaitingQueue' => true, // boolean The waiting queue active flag
        'QueueMaxLength' => 1, // int The queue max length
        'QueueMaxWaitingTime' => 15, // int The queue max waiting time in seconds
        'QueueHasPositionPrompt' => true, // boolean The queue position flag
        'QueueMaxPositionPrompt' => 10, // int The limit to queue poistion
        ),
        'IsSimutaneousCallAllowed' => true, // boolean The simutaneous call allowed flag
        'SimutaneousCall' => array(
        'HasSimutaneousCalls' => true, // boolean The simutaneous call active flag
        ),
        );
    }

    
    protected static $_reports = array(
        1 => array(
            'ReportId' => 1,
            'ReportType' => 1,
            'ReportName' => '1112',
            'SolutionId' => 1,
            'SolutionTypeId' => 2,
            'SolutionType' => 'Static',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => 'Templete 1',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'MaxCallDuration' => 20,
            'CreationDatetime' => '05/12/10 08:00',
            'ModificationDatetime' => '05/12/10 08:00',
            'CustomerUserName' => 'User Name',
            'ReportFormat' => 'csv'
        ),
        2 => array(
            'ReportId' => 2,
            'ReportType' => 1,
            'ReportName' => '1112',
            'SolutionId' => 1,
            'SolutionTypeId' => 2,
            'SolutionType' => 'Full',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => 'Templete 1',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'MaxCallDuration' => 20,
            'CreationDatetime' => '05/12/10 08:00',
            'ModificationDatetime' => '05/12/10 08:00',
            'CustomerUserName' => 'User Name',
            'ReportFormat' => 'csv'
        ),
        3 => array(
            'ReportId' => 3,
            'ReportType' => 1,
            'ReportName' => '1112',
            'SolutionId' => 2,
            'SolutionTypeId' => 2,
            'SolutionType' => 'Static',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => '',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'MaxCallDuration' => 20,
            'CreationDatetime' => '05/12/10 08:00',
            'ModificationDatetime' => '05/12/10 08:00',
            'CustomerUserName' => 'User Name',
            'ReportFormat' => 'csv'
        ),
        4 => array(
            'ReportId' => 4,
            'ReportType' => 1,
            'ReportName' => '1112',
            'SolutionId' => 3,
            'SolutionTypeId' => 2,
            'SolutionType' => 'Static',
            'TemplateTreeId' => 1,
            'TemplateTreeLabel' => '',
            'CustomerAccountId' => 1,
            'CustomerAccountName' => 'Account Name',
            'MaxCallDuration' => 20,
            'CreationDatetime' => '05/12/10 08:00',
            'ModificationDatetime' => '05/12/10 08:00',
            'CustomerUserName' => 'User Name',
            'ReportFormat' => 'csv'
        )
    );
    
    public function Report_Create(array $params)
    {
        $reports = self::$_reports;
        shuffle($reports);
        return $reports[0]['ReportId'];
    }
    
    public function Report_Update(array $params)
    {
        return self::OPERATION_SUCCESS;
    }
    
    public function Report_Delete(array $params)
    {
        return self::OPERATION_SUCCESS;
    }
    
    public function Report_GetById(array $params)
    {
        $reportId = $params[0];
        return self::$_reports[$reportId];
    }
    
    public function Report_GetByCustomer(array $params)
    {
        $customerAccountId = $params[0];
        $datas = array();
        foreach(self::$_reports as $report) {
            if ($customerAccountId == $report['CustomerAccountId']) {
                $datas[] = $report;
            }
        }
        return $datas;
    }
    
    public function Report_Count(array $params)
    {
        return 4;
    }
    
    public function Report_GetByNamePart(array $params)
    {
        $namePart = $params[0];
        $datas = array();
        foreach(self::$_reports as $report) {
            if (preg_match('/'. $namePart. '/i', $report['ReportName'])) {
                $datas[] = $report;
            }
        }
        return $datas;
    }
    
    public function Report_GetTimeframes(array $params)
    {
        $datas = array(
            array(
                "ReportTimeframeId" => 1,
                "Resolution" => 2,
                "ResolutionUnit" => '',
                "TimeframeUnit" => '',
                "TimeframeMax" => '',
            ),
            array(
                "ReportTimeframeId" => 1,
                "Resolution" => 2,
                "ResolutionUnit" => '',
                "TimeframeUnit" => '',
                "TimeframeMax" => '',
            ),
        );
        return 4;
    }

}

/* EOF */