<?php
/**
 * $Rev: 2640 $
 * $LastChangedDate: 2010-06-22 16:40:52 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   library
 * @subpackage node
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Kai WU <kwu@streamwide.com>
 * @version    $Id: Calendar.php 2640 2010-06-22 08:40:52Z kwu $
 */

/**
 *
 */
class SwIRS_Web_Node_Calendar extends SwIRS_Web_Node_Abstract
{
    const NODE_OUTPUT_LABEL_OTHERS = 'Others';
    const CALENDAR_TYPE_MULTI_VIEW = 3;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(parent::CALENDAR);
    }

    /**
     *
     */
    private function _getPeriods($output,$request)
    {
        $calendarId = $output['CalendarId'];
        $periodIds = array();
        if (!is_null($calendarId)) {
            $periods = Streamwide_Web_Model::call('Calendar.GetPeriods',array($calendarId));
            foreach ($periods as $period) {
                $periodIds[$period['PeriodId']] = $period['Label'];
            }
        } else {
            $calendarId = $output['MultiViewCalendarId'];
            if (is_null($calendarId)) {
                $customerUserId = $request->getParam('CustomerUserId');
                $customerAccountId = $request->getParam('CustomerAccountId');
                $calendar = array(
                    'CalendarTypeId' => $output['CanlendarTypeId'],
                    'Label' => $output['CalendarType'],
                    'CustomerUserId' => $customerUserId,
                    'CustomerAccountId' => $customerAccountId,
                    'Automatic' => true
                );
               
                $calendarId = Streamwide_Web_Model::call('Calendar.Create',array($calendar));
            }
            $period = array(
                'CalendarId' => $calendarId,
                'Label' => $output['Label']
            );
            $periodId = Streamwide_Web_Model::call('Calendar.AddPeriod',array($period));
            $periodIds[$periodId] = $period['Label'];
        }
        return $periodIds;
    }

    /**
     *
     * NodeOutputs = array(
     *      array(
     *          Label
     *          CalendarTypeId
     *          CalendarType
     *          CalendarId
     *      )
     * )
     */
    public function create(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::create($request);
        $nodeOutputs = array(
            array(
                'NodeId' => $node['NodeId'],
                'Label' => self::NODE_OUTPUT_LABEL_OTHERS,
                'IsActive' => true,
                'IsDefault' => true,
                'IsAllowed' => true
            )
        );
        $outputs = $request->getParam('NodeOutputs');
        foreach ($outputs as $output)
        {
            $periodIds = $this->_getPeriods($output,$request);
            foreach ($periodIds as $periodId => $periodLabel) {
                $nodeOutputs[] = array(
                    'NodeId' => $node['NodeId'],
                    'Label' => $periodLabel,
                    'IsActive' => true,
                    'IsDefault' => false,
                    'IsAllowed' => true,
                    'PeriodId' => $periodId
                );
            }
        }

        $nodeOutputs = $this->addOutputs($nodeOutputs);
        $node['NodeOutputs'] = $nodeOutputs;

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
     *
     */
    public function addOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("calendar node add output");
        $nodeOutput = parent::addOutput($nodeOutput);
        if (!is_null($nodeOutput['PeriodId'])) {
            $nodeParameter = array(
                'NodeId' => $nodeOutput['NodeId'],
                'NodeOutputId' => $nodeOutput['NodeOutputId'],
                'PeriodId' => $nodeOutput['PeriodId']
            );
            $nodeParameterId = Streamwide_Web_Model::call('Calendar.AddNodeParameter',array($nodeParameter));
            $nodeOutput['NodeParamCalendarId'] = $nodeParameterId;
        }
        return $nodeOutput;
    }

    /**
     *
     */
    public function deleteOutput($nodeOutput)
    {
        Streamwide_Web_Log::debug("calendar node delete output");
        $nodeOutputId = $nodeOutput['NodeOutputId'];
        $result = Streamwide_Web_Model::call('Calendar.RemoveNodeParameterByNodeOutput',array($nodeOutputId));
        parent::deleteOutput($nodeOutput);
        return $result;
    }

    /**
     *
     * NodeOutputs = array(
     *      array(
     *          NodeOutputId
     *          NodeId
     *          NextNodeId
     *          Label
     *          IsDefault
     *          IsActive
     *          IsAllowed
     *          CalendarTypeId
     *          CalendarType
     *          CalendarId
     *          MultiViewCalendarId
     *      )
     * )
     */
    public function update(Zend_Controller_Request_Abstract $request)
    {
        $node = parent::update($request);
        $outputs = $request->getParam('NodeOutputs');

        $addOutputs = array();
        $oldOutputs = array();
        foreach ($outputs as $output) {
            if (is_null($output['NodeOutputId']) && !is_null($output['NodeId'])) {
                $addOutputs[] = $output;
            } else {
                $oldOutputs[] = $output;
            }
        }
        $this->updateOutputs($oldOutputs);

        $nodeOutputs = array();
        foreach ($addOutputs as &$output) {
            $periodIds = $this->_getPeriods($output,$request);
            foreach ($periodIds as $periodId => $periodLabel) {
                $nodeOutputs[] = array(
                    'NodeId' => $node['NodeId'],
                    'Label' => $periodLabel,
                    'IsActive' => true,
                    'IsDefault' => false,
                    'IsAllowed' => true,
                    'PeriodId' => $periodId
                );
            }
        }
        $this->addOutputs($nodeOutputs);
        
        return $node;
    }

    /**
     *
     */
    public function getModalWindowData(Zend_Controller_Request_Abstract $request)
    {
        $calendarTypes = Streamwide_Web_Model::call('Calendar.GetTypes',array());
        $customerAccountId = $request->getParam('CustomerAccountId');
        $calendars = Streamwide_Web_Model::call('Calendar.GetByCustomer',array($customerAccountId));
        return array(
            'CalendarTypes' => $calendarTypes,
            'Calendars' => $calendars
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
        $nodeParameters = Streamwide_Web_Model::call('Calendar.GetNodeParameters',array($nodeId));

        return array(
            'Node' => $node,
            'NodeParameters' => $nodeParameters
        );
    }
}
/*EOF*/
