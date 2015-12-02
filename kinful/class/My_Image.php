<?php
/**
 *@Author        : WangKilin
 *@Email         : wangkilin@126.com
 *@Homepage      : http://www.kinful.com
 *@CreateDate    : 2011-5-30
 * 
 *
 * $Id$
 * $LastChangedDate$
 */

class My_Image
{
	const IMAGE_FILE_NOT_EXISTS = 0x01;
	
	const IMAGE_GET_INFO_FAILED = 0x02;
	
	protected $_baseImageInfo = array();
	
	protected $_topImageInfo = array();
	
	protected $_errorCode = NULL;
	
	public function __construct()
	{
		
	}
	
	/**
	 * Merge two images into one
	 * @param string $topImage The path of top image
	 * @param string $baseImage The path of base image
	 * @param array  $positionInfo The setting of merge
	 * 
	 * @return resource The base image opening handler
	 */
	public function mergeImages($topImage, $baseImage, $positionInfo=array())
	{
		$topImgHandler = $this->_openImage($topImage, $this->_topImageInfo);
		$baseImgHandler = $this->_openImage($baseImage, $this->_baseImageInfo);
		if($baseImgHandler && $topImgHandler) {
			if(!isset($positionInfo['dst_x'])) {
				$positionInfo['dst_x'] = $this->_baseImageInfo[0] - $this->_topImageInfo[0];
			}
			if(!isset($positionInfo['dst_y'])) {
				$positionInfo['dst_y'] = $this->_baseImageInfo[1] - $this->_topImageInfo[1];
			}
			if(!isset($positionInfo['pct'])) {
				$positionInfo['pct'] = 30;
			}
			/*
			var_dump($baseImgHandler, $topImgHandler, $positionInfo['dst_x'],
			  $positionInfo['dst_x'], 0, 0, $this->_topImageInfo[0],
			  $this->_topImageInfo[1], $positionInfo['pct']);exit;//*/
			imagecopymerge($baseImgHandler, $topImgHandler, $positionInfo['dst_x'],
			  $positionInfo['dst_y'], 0, 0, $this->_topImageInfo[0],
			  $this->_topImageInfo[1], $positionInfo['pct']);
			  
		    return $baseImgHandler;
		}
		
		return false;
	}
	
	/**
	 * Open an existing image
	 * @param string $imagePath The image path to be opened
	 * @param array  $imageInfo The image information
	 * 
	 * @return resource The image opening handler
	 */
	protected function _openImage($imagePath, &$imageInfo)
	{
		$imgHandler = NULL;
		if(!is_file($imagePath)) {
			$this->_errorCode = self::IMAGE_FILE_NOT_EXISTS;
		} else {
			$imageInfo = getimagesize($imagePath);
			switch($imageInfo[2]) {
				case IMAGETYPE_JPEG:
					$imageFuncName = 'imagecreatefromjpeg';
					break;
					
				case IMAGETYPE_PNG:
					$imageFuncName = 'imagecreatefrompng';
					break;
					
				case IMAGETYPE_BMP:
					$imageFuncName = 'imagecreatefrombmp';
					break;
					
				case IMAGETYPE_GIF:
					$imageFuncName = 'imagecreatefromgif';
					break;
					
					
				default:
					$this->_errorCode = self::IMAGE_GET_INFO_FAILED;
					break;
			}
			
			if(isset($imageFuncName)) {
				$imgHandler = $imageFuncName($imagePath);
			}
		}
		
		return $imgHandler;
	}
	
	/*
	 * Get the class error code
	 * 
	 * @return int
	 */
	public function getErrorCode()
	{
		return $this->_errorCode;
	}
	
	public function __destruct()
	{
	}
}

$imageModel = new My_Image();
$imageHandler = $imageModel->mergeImages('./img/top.png', './img/base.gif');
if($imageHandler) {
	//var_dump($imageHandler);
    header('Content-Type: image/gif');
    imagegif($imageHandler);
} else {
	echo $imageModel->getErrorCode();
}

