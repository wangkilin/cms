<?php
/**
 * $Rev: 2647 $
 * $LastChangedDate: 2010-06-22 18:37:07 +0800 (Tue, 22 Jun 2010) $
 * $LastChangedBy: yaoli $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: ReportController.php 2647 2010-06-22 10:37:07Z yaoli $
 */

/**
 *
 */
class ReportController extends Zend_Controller_Action
{
    const REPORT_FORMAT_CSV = 'CSV';
    const REPORT_FORMAT_HTML = 'HTML';
    const REPORT_TYPE_OVERALL = 'OVERALL';
    const REPORT_TYPE_AGENT = 'AGENT';
    const REPORT_TYPE_GROUP = 'GROUP';
    const REPORT_TYPE_WAITING = 'WAITING';
    const REPORT_TYPE_ORIGIN = 'ORIGIN';
    const REPORT_TYPE_QUALITY = 'QUALITY';
    const REPORT_PHONE_NUMBER_TYPE_ALL = 'ALL';
    const REPORT_PHONE_NUMBER_TYPE_ONE = 'ONE';
    const REPORT_PHONE_NUMBER_TYPE_RANGE = 'RANGE';


    /**
     *
     */
    public function init()
    {
        //disable layout for ajax
        if ($this->_request->isXmlHttpRequest()) {
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
     * create a report
     *
     * Actual create
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * ReportName
     * ReportFormat
     * ReportType
     * OriginGroupId
     *
     * CustomerAccountId
     * CustomerUserId
     *
     * PhoneNumberType
     * PhoneNumberFrom
     * PhoneNumberTo
     *
     * EmailFrequency
     * Recipients = array($UserId)
     *
     * ReportStartDate
     * ReportEndDate
     * SumOnly
     *
     * ReportTimeframeValue
     * ReportTimeframeId
     *
     * <view-assign>
     * ReportName
     * CustomerAccountId
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     *
     * Modal window
     * -------------
     * <request>
     * <view-assign>
     * ReportTimeframes = array(
     *      array(
     *          ReportTimeframeId
     *          Resolution
     *          ResolutionUnit
     *          TimeframeUnit
     *          TimeframeMax
     *      )
     * )
     *
     * Users = array(
     *      array(
     *          UserId
     *          Name
     *          ....
     *      )
     * )
     *
     * OriginGroups = array(
     *      array(
     *          OriginGroupId
     *          OriginGroupName
     *      )
     * )
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $customerUserId = $request->getParam('CustomerUserId');
        $customerAccountId = $request->getParam('CustomerAccountId');

        if ('create' == $act) {
            Streamwide_Web_Log::debug("create a report actual");
            $report = array();
            $report['reportName'] = $request->getParam('ReportName');
            $report['reportFormat'] = $request->getParam('ReportFormat');
            $report['reportType'] = $request->getParam('ReportType');
            if (self::REPORT_TYPE_ORGIN == $report['reportType']) {
                $report['OriginGroupId'] = $request->getParam('OriginGroupId');
            }
            $report['CustomerUserId'] = $customerUserId;
            $report['CustomerAccountId'] = $customerAccountId;

            $report['PhoneNumber']['PhoneNumberType'] = $request->getParam('PhoneNumberType');
            $report['PhoneNumber']['PhoneNumberFrom'] = $request->getParam('PhoneNumberFrom');
            $report['PhoneNumber']['PhoneNumberTo'] = $request->getParam('PhoneNumberTo');

            $report['EmailFrequency'] = $request->getParam('EmailFrequency');
            $report['Recipients'] = $request->getParam('Recipients');

            $reportStartDate = $request->getParam('ReportStartDate');
            $reportEndDate = $request->getParam('ReportEndDate');
            if (!is_null($reportStartDate) && !is_null($reportEndDate)) {
                $report['Timeframe']['ReportStartDate'] = $reportStartDate;
                $report['Timeframe']['ReportEndDate'] = $reportEndDate;
                $report['Timeframe']['SumOnly'] = $request->getParam('SumOnly',0);
            } else {
                $report['Timeframe']['ReportTimeframeValue'] = $request->getParam('ReportTimeframeValue');
                $report['Timeframe']['ReportTimeframeId'] = $request->getParam('ReportTimeframeId');
            }

            $reportId = Streamwide_Web_Model::call('Report.Create',array($report));
            Streamwide_Web_Log::debug("report $reportId is created");

            $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);

            $this->view->assign(
                array(
                    'ReportName' => $report['reportName'],
                    'CustomerAccountId' => $customerAccountId,
                    'Pagination' => $pagination
                )
            );

            $this->getHelper('viewRenderer')->direct('create-ack');
        } else {
            Streamwide_Web_Log::debug("create a report modal window");
            $users = Streamwide_Web_Model::call('User.GetByCustomer',array($customerAccountId));
            $reportTimeframes = Streamwide_Web_Model::call('Report.GetTimeframes',array());
            $originGroups = Streamwide_Web_Model::call('Origin.GetGroups',array());
            $this->view->assign(array(
                    'ReportTimeframes' => $reportTimeframes,
                    'Users' => $users,
                    'OriginGroups' => $originGroups
            ));
            $this->view->assign($this->_getDates());
        }
    }

    /**
     * list all reports
     * <request>
     * CurrentPage
     * ItemsPerPage
     * ReportNamePart
     * CustomerAccountId
     *
     * <view-assign>
     * Reports = array(
     *      array(
     *          ReportName
     *          ReportFormat
     *          ReportType
     *          ....
     *      )
     * )
     *
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     *      ItemsTotal =>
     * )
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $reportNamePart = $request->getParam('ReportNamePart','');
        $reportNamePart = trim($reportNamePart);
        $customerAccountId = $request->getParam('CustomerAccountId');

        $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;

        $reports = array();
        if (strlen($reportNamePart) > 0) {
            Streamwide_Web_Log::debug("list reports whose name contains $reportNamePart");
            $reports = Streamwide_Web_Model::call('Report.GetByNamePart',
                array(
                    $customerAccountId,
                    $reportNamePart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Report.Count', array($customerAccountId, $reportNamePart));
        } else {
            Streamwide_Web_Log::debug('list reports');
            $reports = Streamwide_Web_Model::call('Report.GetByCustomer',
                array(
                    $customerAccountId,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('Report.Count', array($customerAccountId));
        }
        $this->view->assign(
            array(
                'Reports' => $reports,
                'Pagination' => $pagination
            )
        );
    }

    /**
     * update a report
     * Actual update
     * -------------
     * <request>
     * Act
     *
     * <view-assign>
     * Result
     *
     * Modal window
     * -------------
     * <request>
     * <view-assign>
     * ReportTimeframes = array(
     *      array(
     *          ReportTimeframeId
     *          Resolution
     *          ResolutionUnit
     *          TimeframeUnit
     *          TimeframeMax
     *      )
     * )
     *
     * Users = array(
     *      array(
     *          UserId
     *          Name
     *          ....
     *      )
     * )
     *
     * Recipients = array(
     *      array(
     *          UserId
     *          Name
     *          ....
     *      )
     * )
     *
     * OriginGroups = array(
     *      array(
     *          OriginGroupId
     *          OriginGroupName
     *      )
     * )
     *
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');
        $reportId = $request->getParam('ReportId');
        $customerUserId = $request->getParam('CustomerUserId');
        $customerAccountId = $request->getParam('CustomerAccountId');

        if ('update' == $act) {
            Streamwide_Web_Log::debug("update report $reportId actual");
            $defaults = array(
                'ReportId' => $reportId,
                'ReportName' => null,
                'ReportFormat' => null,
                'ReportType' => null,
                'OriginGroupId' => null,
                'EmailFrequency' => null
            );
            $report = SwIRS_Web_Request::getParam($request,$defaults);

            $phoneNumberDefaults = array(
                'PhoneNumberType' => null,
                'PhoneNumberFrom' => null,
                'PhoneNumberTo' => null
            );
            $reportPhoneNumber = SwIRS_Web_Request::getParam($request,$phoneNumberDefaults);
            if (!empty($reportPhoneNumber)) {
                $report['PhoneNumber'] = $reportPhoneNumber;
            }

            $timeframeDefaults = array(
                'ReportStartDate' => null,
                'ReportEndDate' => null,
                'SumOnly' => null,
                'ReportTimeframeValue' => null,
                'ReportTimeframeId' => null
            );
            $reportTimeframe = SwIRS_Web_Request::getParam($request,$timeframeDefaults);
            if (!empty($reportTimeframe)) {
                $report['Timeframe'] = $reportTimeframe;
            }
            $result = Streamwide_Web_Model::call('Report.Update',array($report));
            $this->view->assign('Result',$result);

            $this->getHelper('viewRenderer')->direct('update-ack');
        } else {
            Streamwide_Web_Log::debug("update a report modal window");
            $users = Streamwide_Web_Model::call('User.GetByCustomer',array($customerAccountId));
            $recipients = Streamwide_Web_Model::call('Report.GetRecipients',array($reportId));
            $reportTimeframes = Streamwide_Web_Model::call('Report.GetTimeframes',array());
            $originGroups = Streamwide_Web_Model::call('Origin.GetGroups',array());
            $this->view->assign(array(
                    'ReportTimeframes' => $reportTimeframes,
                    'Users' => $users,
                    'Recipients' => $recipients,
                    'OriginGroups' => $originGroups
            ));
        }
        $report = Streamwide_Web_Model::call('Report.GetById', array($reportId));
        $this->view->assign('Report',$report);
        $this->view->assign($this->_getDates());
    }

    /**
     * delete a report
     * Actual delete
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     * ReportIds = array($ReportId)
     * ReportNames = array($ReportName)
     * CustomerAccountId
     *
     * <view-assign>
     * DeletedReports
     * CustomerAccountId
     *
     * Pagination = array (
     *      CurrentPage =>
     *      ItemsPerPage =>
     * )
     * Modal window
     * -------------
     * <request>
     * ReportIds = array($ReportId)
     * ReportNames = array($ReportName)
     *
     * <view-assign>
     * DeletedReports
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $act = $request->getParam('Act');

        $customerAccountId = $request->getParam('CustomerAccountId');

        $reportIds = $request->getParam('ReportIds');
        $reportNames = $request->getParam('ReportNames');
        $deletedReports = implode(',', $ReportNames);

        if ('delete' == $act) {
            $pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);

            foreach ($reportIds as $reportId) {
                Streamwide_Web_Model::call('Report.Delete', array($reportId));
            }
            Streamwide_Web_Log::debug("deleted report $deletedReports");
            $this->view->assign(
                array(
                    'DeletedReports' => $deletedReports,
                    'CustomerAccountId' => $customerAccountId,
                    'Pagination' => $pagination
                )
            );
            $this->getHelper('viewRenderer')->direct('delete-ack');
        } else {
            Streamwide_Web_Log::debug('delete report modal window');
            $this->view->assign('DeletedReports', $deletedReports);
        }
    }

    /**
     *
     */
    public function recipientsAction()
    {
        $request = $this->getRequest();
        $act = $this->getParam('Act');
        $recipients = $request->getParam('Recipients');

        if ('add' == $act) {
            $result = Streamwide_Web_Model::call('Report.AddRecipients',array($recipients));
        } else {
            $result = Streamwide_Web_Model::call('Report.RemoveRecipients',array($recipients));
        }
        $this->view->assign('Result',$result);
    }

    /**
     *
     */
    protected function _getDates()
    {
        $datas = array(
            'ReportTypes' => array(
                '-1' => 'select',
                'OVERALL' => 'overall',
                'AGENT' => 'agent',
                'GROUP' => 'group',
                'WAITING' => 'waiting',
                'ORIGIN' => 'origin',
                'QUALITY' => 'quality'
            ),
            'ReportFormats' => array(
                '-1' => 'select',
                'CSV' => 'csv',
                'HTML' => 'html'
            ),
            'EmailFrequencies' => array(
                '-1' => 'select',
                'TIME' => 'time',
                'DAY' => 'day',
                'WEEK' => 'week',
                'MONTH' => 'month'
            )
        );
        return $datas;
    }
}
/*EOF*/