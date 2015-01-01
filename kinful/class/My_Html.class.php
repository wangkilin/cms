<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_html.class.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-2-2
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Html extends My_Abstract
{
	/****************** START::property zone *************************/

	/****************** END::property zone *************************/


	/****************** START::method zone *************************/
	/**
	 *@Decription : load specify type database class
	 *
	 *@Param : string	database type
	 *@Param : int		which Db will be connected to
	 *
	 *@return: constractor
	 */
	public function __construct()
	{
		My_Kernel::loadLang('class','html');//load class language
	}// END::function database

	/**
	 *@Description : append meta paramters
	 *
	 *@Param : array	key is meta name, value is meta content
	 *
	 *@return: string
	 */
	public function appendMeta($metaArray)
	{
		$meta = '';
		foreach($metaArray as $key => $value)
		{
			$meta .= "<meta name='$key' content='$value'>\n";
		}
		return $meta;
	}//END:: function appendMeta

	/**
	 *@Decription : redirect window to another URL
	 *
	 *@Param : URL
	 *
	 *@return: void
	 */
	public function redirect($url, $method = 'header')
	{
		switch ($method)
		{
			case 'meta':
				break;
			default:
				header("Location:$url");
				break;
		}
	}//END::function redirect

	/**
	 *@Decription : more blocks showing at same zone
	 *
	 *@Param : array	blocks info
	 *
	 *@return: string	html code
	 */
	public function parallelBlocks($blocks)
	{
		$titleStr = '';
		$blockStr = '';
		$i=0;

		while(list($title, $block) = each($blocks))
		{
			$titleStr .= "<td><div name='parallel_title[]' class='parallel_title".($i==0?"_click":'')."' onclick=\"kinful_parallelBlocks($i, 'parallel_title[]', 'parallel_block[]')\" align='center'><table border='0' width='80' cellspacing='4' cellpadding='0'><tr><td>$title</td></tr></table></div></td>";
			$blockStr .= "<div name='parallel_block[]' ".($i==0?'':"style='display:none;'")."><table border='0' width='100%' cellspacing='4' cellpadding='0'><tr><td>$block</td></tr></table></div>";
			$i++;
		}
		$style ="<style>
		<!--
		.parallel_node
		{
			border-top-width: 0px;
			border-right-width: 1px;
			border-bottom-width: 1px;
			border-left-width: 1px;
			border-top-style: solid;
			border-right-style: solid;
			border-bottom-style: solid;
			border-left-style: solid;
			border-top-color: #CCC5B7;
			border-right-color: #CCC5B7;
			border-bottom-color: #CCC5B7;
			border-left-color: #CCC5B7;
			padding-top: 20px;
			padding-right: 20px;
			padding-bottom: 20px;
			padding-left: 20px;
			background-color: #FFFFFF;
		}
		.parallel_title_click
		{
			border-top-width: 1px;
			border-right-width: 1px;
			border-bottom-width: 0px;
			border-left-width: 1px;
			border-top-style: solid;
			border-right-style: solid;
			border-bottom-style: solid;
			border-left-style: solid;
			border-top-color: #CCC5B7;
			border-right-color: #CCC5B7;
			border-bottom-color: #CCC5B7;
			border-left-color: #CCC5B7;
			padding-top: 1px;
			padding-right: 1px;
			padding-bottom: 1px;
			padding-left: 1px;
			background-color: #FFFFFF;
		}
		.parallel_title
		{
			border-top-width: 1px;
			border-right-width: 1px;
			border-bottom-width: 0px;
			border-left-width: 1px;
			border-top-style: solid;
			border-right-style: solid;
			border-bottom-style: solid;
			border-left-style: solid;
			border-top-color: #CCC5B7;
			border-right-color: #CCC5B7;
			border-bottom-color: #CCC5B7;
			border-left-color: #CCC5B7;
			padding-top: 1px;
			padding-right: 1px;
			padding-bottom: 1px;
			padding-left: 1px;
			background-color: #CCC5B7;
		}


		-->
		</style>";
		$jsCode = "<script language=\"JavaScript\">
		<!--
		function kinful_parallelBlocks(clickNum, titleName, blockName)
		{

			var titleObjs = document.getElementsByName(titleName);
			var blockObjs = document.getElementsByName(blockName);
			var i=0;
			maxLength =titleObjs.length;
			if(maxLength==0)
			{
				titleObjs=document.getElementById('YEAHEASY_PARALLEL_TITLE').getElementsByTagName('DIV');
				blockObjs = document.getElementById('YEAHEASY_PARALLEL_BLOCK').getElementsByTagName('DIV');
				maxLength = titleObjs.length;
			}


			for(;i<maxLength;i++)
			{
				if(i==clickNum)
				{
					titleObjs[i].className='parallel_title_click';
					blockObjs[i].style.display='block';
				}
				else
				{
					titleObjs[i].className='parallel_title';
					blockObjs[i].style.display='none';
				}
			}

		}
		//-->
		</script>";
		$titleStr = "<table border='0' width='100%' cellspacing='0' cellpadding='0' id='YEAHEASY_PARALLEL_TITLE'><tr><td><table border='0' width='60%' cellspacing='0' cellpadding='0'><tr>$titleStr</tr></table></td><td style='border-bottom-style: solid;			border-bottom-color: #CCC5B7;border-bottom-width: 1px;' width='100%'> &nbsp;</td></tr></table>\n";
		//$blockStr = "<table border='0' width='100%' cellspacing='4' cellpadding='0' id='YEAHEASY_PARALLEL_BLOCK'><tr><td align='center'>$blockStr</td></tr></table>\n";
		return "$style\n$jsCode\n<table border='0' cellspacing='0' cellpadding='0' width='100%'>\n<tr><td align='left'>$titleStr</td></tr>\n<tr><td class='parallel_node' align='center' id='YEAHEASY_PARALLEL_BLOCK'>$blockStr</td></tr>\n</table>\n";
	}//END::function parallelBlocks


	/****************** END::method zone *************************/

}// END::class
?>
