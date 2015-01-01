<?php
/**
 * $Rev: 2564 $
 * $LastChangedDate: 2010-06-16 16:41:47 +0800 (Wed, 16 Jun 2010) $
 * $LastChangedBy: kwu $
 *
 * @category   application
 * @package    modules_default
 * @subpackage controllers
 * @copyright  Copyright (c) 2010 Streamwide SAS
 * @author     James ZHANG <junzhang@streamwide.com>
 * @version    $Id: MediaController.php 2564 2010-06-16 08:41:47Z kwu $
 */

/**
 *
 */
class MediaController extends Zend_Controller_Action
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
     * create a prompt
     * Actual create
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     *
     * PromptName
     * FileName
     * PromptContent
     * Description
     * CustomerUserId
     * CustomerAccountId
     *
     * <view-assign>
     * PromptName
     * CustomerUserId
     * CustomerAccountId
     * Pagination = array(
     * 	   CurrentPage =>
     * 	   ItemsPerPage =>
     * )
     *
     * Modal window
     * ------------
     * <request>
     * <view-assign>
     */
    public function createAction()
    {
    	$request = $this->getRequest();
    	$act = $request->getParam('Act');

    	if ('create' == $act) {
    		Streamwide_Web_Log::debug('create a prompt actual');
    		$pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
    		$pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
            $customerAccountId = $request->getParam('CustomerAccountId');
            $customerUserId = $request->getParam('CustomerUserId');
            $promptName = $request->getParam('PromptName');
            $description = $request->getParam('Description');
            $fileKey = $request->getParam('FileKey');

            $fileName = '';
            $fileContent = '';
            if (isset($_SESSION['PromptFile']) && isset($_SESSION['PromptFile'][$fileKey])) {
                $fileName = $_SESSION['PromptFile'][$fileKey]['Name'];
                $fileContent = $_SESSION['PromptFile'][$fileKey]['Content'];
            }

    		$prompt = array(
    			'PromptName' => $promptName,
    			'FileName' => $fileName,
    			'PromptContent' => $fileContent,
    			'Description' => $description,
    			'CustomerUserId' => $customerUserId,
    			'CustomerAccountId' => $customerAccountId
    		);
    		$promptId = Streamwide_Web_Model::call('Prompt.Create', array($prompt));
    		Streamwide_Web_Log::debug("prompt $promptId is created");

    		$this->view->assign(
    			array(
    				'PromptName' => $prompt['PromptName'],
    				'CustomerUserId' => $prompt['CustomerUserId'],
    				'CustomerAccountId' => $prompt['CustomerAccountId'],
    				'Pagination' => $pagination
    			)
    		);
    		$this->getHelper('viewRenderer')->direct('create-ack');
    	} else {
    		Streamwide_Web_Log::debug('create a prompt modal window');
    	}
    }

	/**
     * list prompts
     * <request>
     * CustomerUserId
     * CustomerAccountId
     * PromptNamePart
     * Pagination = array(
     *     CurrentPage =>
     *     ItemsPerPage =>
     * )
     *
     * <view-assign>
     * Prompts = array(
     *     array(
     *         PromptId
     *         PromptName
     *         FileSize
     *         FileName
     *         Description
     *         CustomerUserId
     *         CustomerUserName
     *         CustomerAccountId
     *         CreationDateTime
     *         ModificationDateTime
     *         ReferenceCounter
     *     )
     * )
     *
     * Pagination = array(
     *     CurrentPage =>
     *     ItemsPerPage =>
     *     ItemsTotal =>
     * )
     *
     */
    public function listAction()
    {
    	$request = $this->getRequest();
    	$customerAccountId = $request->getParam('CustomerAccountId');
    	$promptNamePart = $request->getParam('PromptNamePart','');
    	$promptNamePart = trim($promptNamePart);
    	$pagination['CurrentPage'] = $request->getParam('CurrentPage', SwIRS_Web_Request::CURRENT_PAGE);
    	$pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage', SwIRS_Web_Request::ITEMS_PER_PAGE);
    	$pagination['ItemsTotal'] = 0;

        $prompts = array();
    	if (strlen($promptNamePart) > 0) {
    		Streamwide_Web_Log::debug("list prompts whose name contains $promptNamePart");
    		$prompts = Streamwide_Web_Model::call('Prompt.GetByName',
    			array(
    				$customerAccountId,
    				$promptNamePart,
    				$pagination['CurrentPage'],
    				$pagination['ItemsPerPage']
    			)
    		);
    		$pagination['ItemsTotal'] = Streamwide_Web_Model::call('Prompt.Count', array($customerAccountId, $promptNamePart));
    	} else {
    		Streamwide_Web_Log::debug('list all prompts');
    		$prompts = Streamwide_Web_Model::call('Prompt.GetByCustomer',
    			array(
    				$customerAccountId,
    				$pagination['CurrentPage'],
    				$pagination['ItemsPerPage']
    			)
    		);
    		$pagination['ItemsTotal'] = Streamwide_Web_Model::call('Prompt.Count', array($customerAccountId));
    	}
    	$this->view->assign(
    		array(
    			'Prompts' => $prompts,
    			'Pagination' => $pagination
    		)
    	);
    }

	/**
     * update a prompt
     * Actual update
     * -------------
     * <request>
     * Act
     * PromptId
     * PromptName
     * FileName
     * PromptContent
     * Description
     *
     * <view-assign>
     * Result
     * Prompt = array(
     *     PromptId
     * 	   PromptName
     * 	   FileSize
     *     FileName
     *     PromptContent
     *     Description
     *     CustomerUserId
     *     CustomerUserName
     *     CustomerAccountId
     *     CreationDateTime
     *     ModificationDateTime
     *     ReferenceCounter
     * )
     *
     * Modal window
     * ------------
     * <request>
     * PromptId
     * <view-assign>
     * Prompt = array(
     *     PromptId
     * 	   PromptName
     * 	   FileSize
     *     FileName
     *     PromptContent
     *     Description
     *     CustomerUserId
     *     CustomerUserName
     *     CustomerAccountId
     *     CreationDateTime
     *     ModificationDateTime
     *     ReferenceCounter
     * )
     */
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$act = $request->getParam('Act');
    	$promptId = $request->getParam('PromptId');

    	if ('update' == $act) {
    		Streamwide_Web_Log::debug('update a prompt actual');

    		$defaults = array(
    			'PromptId' => $promptId,
    			'PromptName' => null,
    			'FileName' => null,
    			'PromptContent' => null,
    			'Description' => null
    		);
    		$prompt = SwIRS_Web_Request::getParam($request, $defaults);
    		$result = Streamwide_Web_Model::call('Prompt.Update', array($prompt));
    		$this->view->assign('Result', $result);
    		$this->getHelper('viewRenderer')->direct('update-ack');
    	}
        $prompt = Streamwide_Web_Model::call('Prompt.GetById', array($promptId));
        $this->view->assign('Prompt', $prompt);
    }

    /**
     * delete a prompt
     * Actual delete
     * -------------
     * <request>
     * Act
     * CurrentPage
     * ItemsPerPage
     * PromptIds = array(PromptId)
     * PromptNames = array(PromptName)
     *
     * <view-assign>
     * DeletedPrompts
     * CustomerUserId
     * CustomerAccountId
     * Pagination = array(
     *     CurrentPage =>
     *     ItemsPerPage =>
     * )
     *
     * Modal window
     * ------------
     * <request>
     * PromptIds = array(PromptId)
     * PromptNames = array(PromptName)
     *
     * <view-assign>
     * DeletedPrompts
     */
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$act = $request->getParam('Act');
    	$promptIds = $request->getParam('PromptIds');
    	$promptNames = $request->getParam('PromptNames');
        $deleted = implode(',',$promptNames);

    	if ('delete' == $act) {
    		Streamwide_Web_Log::debug('delete prompt actual');
            $pagination['CurrentPage'] = $request->getParam('CurrentPage',SwIRS_Web_Request::CURRENT_PAGE);
            $pagination['ItemsPerPage'] = $request->getParam('ItemsPerPage',SwIRS_Web_Request::ITEMS_PER_PAGE);

    		foreach ($promptIds as $promptId) {
    			$result = Streamwide_Web_Model::call('Prompt.Delete', array($promptId));
    		}
    		Streamwide_Web_Log::debug("deleted prompt $deleted");
    		$this->view->assign(
    			array(
    				'DeletedPrompts' => $deleted,
    				'CustomerUserId' => $request->getParam('CustomerUserId'),
    				'CustomerAccountId' => $request->getParam('CustomerAccountId'),
                    'Pagination' => $pagination
    			)
    		);
    		$this->getHelper('viewRenderer')->direct('delete-ack');
    	} else {
    		Streamwide_Web_Log::debug('delete prompt modal window');
			$this->view->assign('DeletedPrompts',$deleted);
    	}
    }

    /**
     * listen media
     * <request>
     * PromptId
     *
     * <view-assign>
     */
    public function playAction()
    {
        // Always disable the layout and viewRenderer
        $this->view->layout()->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender();
        Streamwide_Web_Log::debug("listen prompt $promptId");

        $request = $this->getRequest();
        $promptId = $request->getParam('PromptId');

        $prompt = Streamwide_Web_Model::call('Prompt.GetById', array($promptId));
        $promptContent = base64_decode($prompt['PromptContent']);
        $response = $this->getResponse();
        $response->clearAllHeaders();
        $response->clearBody();
        $response->setHeader('Content-Type', 'audio/mpeg')
                 ->setHeader('Content-Length', strlen($promptContent));
        $response->setBody($promptContent);
    }

    /**
     * upload file
     * <request>
     * <view-assign>
     * FileKey
     */
    public function uploadAction()
    {
        $this->view->layout()->disableLayout();

    	$request = $this->getRequest();
    	$act = $request->getParam('Act');

    	if ('upload' == $act) {
            if (isset($_FILES['Filedata'])) {
            	Streamwide_Web_Log::debug("upload file " . $_FILES['Filedata']['name']);
                // get the upload file
                $fileName = $_FILES['Filedata']['name'];
                $fileContent = file_get_contents($_FILES['Filedata']['tmp_name']);
                $fileKey = 'F-' . time();
                $_SESSION['PromptFile'] = array(
                	$fileKey => array(
                		'Name' => $fileName,
                		'Content' => base64_encode($fileContent)
                	)
                );

                $this->view->assign('FileKey', $fileKey);
                $this->getHelper('viewRenderer')->direct('upload-ack');
            } else {
                // Do nothing
            }
    	} else {
    		Streamwide_Web_Log::debug('upload prompt madal window');
    		$this->getHelper('viewRenderer')->setNoRender();
    	}
    }
}
/* EOF */
