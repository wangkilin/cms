<?php
/**
 * $Rev: 2666 $
 * $LastChangedDate: 2010-06-23 18:24:07 +0800 (Wed, 23 Jun 2010) $
 * $LastChangedBy: zwang $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: TrunkRouteController.php 2666 2010-06-23 10:24:07Z zwang $
 */

/**
 * 
 */
class TrunkRouteController extends Zend_Controller_Action
{
	/**
	 * init()
	 */
	public function init()
	{
		//disable layout for ajax
		if ($this->_request->isXmlHttpRequest()) {
			$this->view->layout()->disableLayout();
		}
	}
	
	/**
	 * indexAction()
	 */
	public function indexAction()
	{
		$this->listAction();
	}
	
	/**
	 * list all trunks
	 */
	public function listAction()
	{
		$request = $this->getRequest();
		$labelPart = $request->getParam('ResourceKeyWord');
        $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE); 
        $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);
        $pagination['ItemsTotal'] = 0;
		$trunkRoutes = array();
        
		if (strlen($labelPart)) {
			$trunkRoutes = Streamwide_Web_Model::call('TrunkRoute.GetByLabelPart',
                array(
                    $labelPart,
                    $pagination['CurrentPage'],
                    $pagination['ItemsPerPage']
                )
            );
            $pagination['ItemsTotal'] = Streamwide_Web_Model::call('TrunkRoute.Count',array($labelPart));
		} else {
			$pagination['ItemsTotal'] = Streamwide_Web_Model::call('TrunkRoute.Count',array());
			$trunkRoutes = Streamwide_Web_Model::call('TrunkRoute.GetAll', array($pagination['CurrentPage'], $pagination['ItemsPerPage']));
		}
		$this->view->assign(
			array(
				'TrunkRoutes' => $trunkRoutes,
				'Pagination' => $pagination
			)
		);
	}
	
	/**
	 * import trunk route
	 */
	public function importAction()
	{
		
	}
}