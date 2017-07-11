<?php
/**
 * $Rev: 2543 $
 * $lastChangedDate$
 * $lastChangedBy$
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     Lance LI <yaoli@streamwide.com>
 * @version    $Id: CalendarController.php 2543 2010-06-12 10:11:22Z yaoli $
 */

/**
 *
 */
class CalendarController extends Zend_Controller_Action
{
    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        /* Initialize action controller here */
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->view->layout()->disableLayout();
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
     * list calendars
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $customerAccountId = $request->getParam('CustomerAccountId');
        $calendarLabelPart = $request->getParam('CalendarLabelPart','');
        $calendarLabelPart = trim($calendarLabelPart);

        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

        $pagination['ItemsTotal'] = 0;
        $calendars = array();
        if (strlen($calendarLabelPart) > 0) {
            Streamwide_Web_Log::debug("list calendars whose name contains $calendarLabelPart");
            $calendars = Streamwide_Web_Model::call('Calendar.GetByLabelPart',
                array(
                    $customerAccountId,
                    $calendarLabelPart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Calendar.Count',array($customerAccountId,$calendarLabelPart));
        } else {
            Streamwide_Web_Log::debug("list calendars");
            $calendars = Streamwide_Web_Model::call('Calendar.GetByCustomer',
                array(
                    $customerAccountId,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Calendar.Count',array($customerAccountId));
        }
        $this->view->assign(array(
            'Calendars' => $calendars,
            'Pagination' => $pagination
            )
        );
    }

    /**
     * create a calendar
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        if ('create' == $act) {
            Streamwide_Web_Log::debug("create a calendar actual");

            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            $defaults = array(
                 'Label' => '',
                 'CalendarTypeId' => 1,
                 'Automatic' => false,
                 'CustomerUserId' => 1 ,
                 'CustomerAccountId' => 1
            );

            $calendar = SwIRS_Web_Request::getParam($request,$defaults);
            $calendarId = Streamwide_Web_Model::call('Calendar.Create',array($calendar));

            Streamwide_Web_Log::debug("calendar $calendarId is created");

            $period = array();
            if (3 == $calendar['CalendarTypeId']) {
                $periodLabels = $request->getParam('PeriodLabel', array());
                foreach ($periodLabels as $key => $periodLabel) {
                    $periodLabel = $periodLabel;
                    $period = array (
                        'CalendarId' => $calendarId,
                        'Label' => $periodLabel
                    );
                    $periodIds[$key] = Streamwide_Web_Model::call('Calendar.AddPeriod', array($period));
                    Streamwide_Web_Log::debug("period $periodIds[$key] is created");
                }
            } else {
                $period = array(
                    'CalendarId' => $calendarId,
                    'Label' => ''
                );
                $periodId = Streamwide_Web_Model::call('Calendar.AddPeriod', array($period));
                $periodIds[] = $periodId;
                Streamwide_Web_Log::debug("period $periodId is created");
            }

            foreach ($periodIds as $periodId) {
                $dates = $request->getParam('Date', array());
                $startDates = $endDates = '';
                if (count($dates) > 0) {
                    $startDates = $endDates = $dates;
                } else {
                    $startDates = $request->getParam('StartDate', array());
                    $endDates = $request ->getParam('EndDate', array());
                }
                $count = 0;
                foreach ($startDates as $startDate) {
                    $endDate = $endDates[$count];
                    $count++;
                    $periodDay = array(
                        'PeriodId' => $periodId,
                        'StartDate' => $startDate,
                        'EndDate' => $endDate
                    );
                    $periodDaysId = Streamwide_Web_Model::call('Calendar.AddPeriodDay', array($periodDay));
                    Streamwide_Web_Log::debug("period day $periodDaysId is created");
                }
            }

            $startSeconds = $request->getParam('StartSecond', array());
            $endSeconds = $request->getParam('EndSecond', array());

            foreach ($periodIds as $key => $periodId) {
                $startSecond = $startSeconds;
                $endSecond = $endSeconds;
                if (3 == $calendar['CalendarTypeId']) {
                    $startSecond = $startSeconds[$key];
                    $endSecond = $endSeconds[$key];
                }
                foreach ($startSecond as $index => $start) {
                    $end = $endSecond[$index];
                    $frequency = array(
                       'PeriodId' => $periodId,
                       'StartSecond' => $start,
                       'EndSecond' => $end
                    );
                    $periodFrequencyId = Streamwide_Web_Model::call('Calendar.AddPeriodFrequency', array($frequency));
                    Streamwide_Web_Log::debug("period frequency $periodFrequencyId is created");
                }
            }

            $this->view->assign(array(
                'CalendarLabel' => $calendar['Label'],
                'CustomerUserId' => $calendar['CustomerUserId'],
                'CustomerAccountId' => $calendar['CustomerAccountId'],
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('create-ack');

        } else {
            Streamwide_Web_Log::debug("create a calendar modal window");
            $calendarTypes = Streamwide_Web_Model::call('Calendar.GetTypes', array());

            $this->view->assign(array(
                    'CalendarTypes' => $calendarTypes
                )
            );
        }
    }

    /**
     * update calendar
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $calendarId = $request->getParam('CalendarId');

        if ('update' == $act) {
            Streamwide_Web_Log::debug("update a calendar $calendarId actual");
            $calendarLabel = $request->getParam('Label');

            $result = Streamwide_Web_Model::call('Calendar.Update', array($calendarId, $calendarLabel));

            $this->view->assign('Result',$result);
            $this->getHelper('viewRenderer')->direct('update-ack');
        } else {
            Streamwide_Web_Log::debug("update calendar $calendarId modal window");
            $calendarTypes = Streamwide_Web_Model::call('Calendar.GetTypes', array());
            $periods = Streamwide_Web_Model::call('Calendar.GetPeriods', array($calendarId));

            foreach ($periods as $key => $period) {
                $periodDays = Streamwide_Web_Model::call('Calendar.GetPeriodDays', array($period['PeriodId']));
                $periods[$key]['PeriodDays'] = $periodDays;
                $frequencies = Streamwide_Web_Model::call('Calendar.GetPeriodFrequencies', array($period['PeriodId']));
                $periods[$key]['Frequencies'] = $frequencies;
            }
            $this->view->assign(array(
                    'Periods' => $periods,
                    'CalendarTypes' => $calendarTypes
                )
            );
        }
        Streamwide_Web_Log::debug("get a calendar $calendarId");
        $calendar = Streamwide_Web_Model::call('Calendar.GetById', array($calendarId));
        $this->view->assign('Calendar', $calendar);
    }

    /**
     * delete calendar
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $calendarIds = $request->getParam('CalendarIds');
        $calendarLabels = $request->getParam('Labels');
        $deleted = implode(',',$calendarLabels);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($calendarIds as $calendarId) {
                $result = Streamwide_Web_Model::call('Calendar.Delete',array($calendarId));
            }

            Streamwide_Web_Log::debug("deleted calendar $deleted");
            $this->view->assign(array(
                'DeletedCalendarLabels' => $deleted,
                'CustomerUserId' => $request->getParam('CustomerUserId'),
                'CustomerAccountId' => $request->getParam('CustomerAccountId'),
                'Pagination' => $pagination
            ));

            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            $this->view->assign('DeletedCalendarLabels', $deleted);
        }
    }

    /**
     * period management
     */
    public function periodAction()
    {
        $request = $this->getRequest();
        $calendarId = $request->getParam('CalendarId');
        $periodId = $request->getParam('PeriodId');
        $label = $request->getParam('PeriodLabel');
        $act = $request->getParam('Act');

        switch ($act)
        {
            case 'add':

                $periodId = Streamwide_Web_Model::call('Calendar.AddPeriod', array(
                    array(
                        'CalendarId' => $calendarId,
                        'Label' => $label
                    )
                ));
                Streamwide_Web_Log::debug("period $periodId is created");

                $this->view->assign(array('PeriodId' => $periodId));
                $this->getHelper('viewRenderer')->direct('period-add-ack');
                break;
            case 'update':
                Streamwide_Web_Log::debug("update a period $periodId actual");
                $result = Streamwide_Web_Model::call('Calendar.UpdatePeriod', array($periodId, $label));

                $this->view->assign('Result', $result);
                $this->getHelper('viewRenderer')->direct('period-update-ack');
                break;
            case 'delete':
                $result = Streamwide_Web_Model::call('Calendar.DeletePeriod', array($periodId));
                Streamwide_Web_Log::debug("period $periodId is deleted");

                $this->view->assign('Result', $result);
                $this->getHelper('viewRenderer')->direct('period-delete-ack');
                break;
            default:
                break;
        }
    }

    /**
     * period day management
     */
    public function perioddayAction()
    {
        $request = $this->_request;
        $periodDaysId = $request->getParam('PeriodDaysId');
        $periodId = $request->getParam('PeriodId');
        $startDate = $request->getParam('StartDate');
        $endDate = $request->getParam('EndDate');
        $act = $request->getParam('Act');

        switch ($act)
        {
            case 'add':
                $periodDaysId = Streamwide_Web_Model::call('Calendar.AddPeriodDay', array(array(
                    'PeriodId' => $periodId,
                    'StartDate' => $startDate,
                    'EndDate' => $endDate
                )));
                Streamwide_Web_Log::debug("period day $periodDaysId is created");

                $this->view->assign(array('PeriodDayId' => $periodDaysId));
                $this->getHelper('viewRenderer')->direct('period-day-add-ack');
                break;
            case 'update':
                Streamwide_Web_Log::debug("update a period day $periodDaysId actual");
                $result = Streamwide_Web_Model::call('Calendar.UpdatePeriodDay', array($periodId, array(
                    'PeriodDaysId' => $periodDaysId,
                    'StartDate' => $startDate,
                    'EndDate' => $endDate
                )));

                $this->view->assign('Result', $result);
                $this->getHelper('viewRenderer')->direct('period-day-update-ack');
                break;
            case 'delete':
                $result = Streamwide_Web_Model::call('Calendar.DeletePeriodDay', array($periodDaysId));
                Streamwide_Web_Log::debug("period day $periodDaysId is deleted");

                $this->view->assign('Result', $result);
                $this->getHelper('viewRenderer')->direct('period-day-delete-ack');
                break;
            default:
                break;
        }
    }

    /**
     * frequency management
     */
    public function frequencyAction()
    {
        $request = $this->_request;
        $periodFrequencyId= $request->getParam('PeriodFrequencyId');
        $periodId = $request->getParam('PeriodId');
        $startSecond = $request->getParam('StartSecond');
        $endSecond = $request->getParam('EndSecond');
        $act = $request->getParam('Act');

        switch ($act)
        {
            case 'add':
                $periodFrequencyId = Streamwide_Web_Model::call('Calendar.AddPeriodFrequency', array(
                    array(
                        'PeriodId' => $periodId,
                        'StartSecond' => $startSecond,
                        'EndSecond' => $endSecond
                    )
                ));
                Streamwide_Web_Log::debug("period frequency $periodFrequencyId is created");

                $this->view->assign(array('PeriodFrequencyId' => $periodFrequencyId));
                $this->getHelper('viewRenderer')->direct('frequency-add-ack');
                break;
            case 'update':
                Streamwide_Web_Log::debug("update a period frequency $periodFrequencyId actual");
                $result = Streamwide_Web_Model::call('Calendar.UpdatePeriodFrequency', array(
                    array(
                        'PeriodFrequencyId' => $periodFrequencyId,
                        'StartSecond' => $startSecond,
                        'EndSecond' => $endSecond
                        )
                    ));

                $this->view->assign('Result', $result);
                $this->getHelper('viewRenderer')->direct('frequency-update-ack');
                break;
            case 'delete':
                $result = Streamwide_Web_Model::call('Calendar.DeletePeriodFrequency', array($periodFrequencyId));
                Streamwide_Web_Log::debug("period frequency $periodFrequencyId is deleted");

                $this->view->assign('Result', $result);
                $this->getHelper('viewRenderer')->direct('frequency-delete-ack');
                break;
            default:
                break;
        }
    }
}

/* EOF */
