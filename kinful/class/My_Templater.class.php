<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_templater.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-2-2
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Templater extends My_Abstract
{
    /****************** START::property zone *************************/


    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Description :
     *
     *@return: constractor
     */
    public function __construct($templaterName, $options=null)
    {
        My_Kernel::loadLang('class','templater');//load class language

        switch ( strtolower($templaterName) ) {
            case 'smarty':
            default:
                require_once (dirname(__FILE__) . '/templates/MY_smarty.class.php');
                $this->_templater = new MY_smarty();
                if ($options) {
                    $this->setOptions($options);
                }
                break;
        }
    }// END::function

    public function setOptions ($options)
    {
        $this->_templater->setOptions($options);

        return $this;
    }

    public function display ($positions, $blocks, $mainBlock='')
    {
        //var_dump($positions, $blocks);
        $contentList = array();

        $positionsContent = array();
        reset($blocks);
        while (list(, $block) = each($blocks)) {
            $positionId = $block['position_id'];
            if (!isset($positionsContent[$positionId])) {
                $positionsContent[$positionId] = array();
            }
            $blockName = $block['block_show_name'];
            $positionsContent[$positionId][$blockName] = & $block['content'];
            //echo $block['content'];
        }

        reset($positions);
        while(list(, $positionInfo) = each($positions)) {
            $positionId = $positionInfo['position_id'];
            if(isset($positionsContent[$positionId])) {
                $contentList[$positionInfo['position_name']] = & $positionsContent[$positionId];
                //var_dump($positionInfo['position_name'], $positionsContent[$positionId]);
            }
        }

        if ($mainBlock != '') {
            if (isset($contentList['my_main'])) {
                $contentList['my_main'] = array();
            }
            $contentList['my_main']['my_main_content'] = & $mainBlock;
        }

        //var_dump($contentList);
        $this->render($contentList, true);
    }

    public function & render ($contentList=array(), $display=false)
    {
        //var_dump($contentList);
        $ret = $this->_templater->render ($contentList, $display);

        return $ret;
    }

    public function assign ($key, $value)
    {
        $this->_templater->assign($key, $value);

        return $this;
    }

    public function assignByRef ($key, $value)
    {
        $this->_templater->assignByRef($key, $value);

        return $this;
    }

    public function assignList ($assignList)
    {
        if (! is_array($assignList)) {
            return;
        }

        foreach ($assignList as $key => $value) {
            if (is_string($key) && ! is_numeric($key)) {
                $this->assign($key, $value);
            }
        }

        return $this;
    }

    public function assignRefList ($assignList)
    {
        if (! is_array($assignList)) {
            return;
        }

        foreach ($assignList as $key => $value) {
            if (is_string($key) && ! is_numeric($key)) {
                $this->assignByRef($key, $assignList[$key]);
            }
        }

        return $this;
    }

    public function clearAssign ()
    {
        $this->_templater->clearAssign();

        return $this;
    }

    public function registerFunction ($funcName, $functionName)
    {
        $this->_templater->registerFunction($funcName, $functionName);

        return $this;
    }
    /****************** END::method zone *************************/

}// END::class
?>
