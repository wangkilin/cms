<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_smarty.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-2-2
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

define('SMARTY_DIR', MY_ROOT_PATH . 'class/smarty/');

require_once(SMARTY_DIR . 'Smarty.class.php');

class MY_smarty
{
    /****************** START::property zone *************************/

    /**
     *@boolean    set true, class will debug
     */
    public $debug = false;

    protected $left_delimiter = '<?';

    protected $right_delimiter = '?>';

    protected $force_compile = false;


    private $_smarty = NULL;

    protected $tplName = 'index.php';

    protected $template_dir = './themes/kinful';

    protected $compile_dir  = './compile_dir/kinful';

    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Description :
     *
     *@return: constractor
     */
    public function MY_smarty()
    {
        MY_kernel::loadLang('class','smarty');//load class language

        $this->_smarty = new Smarty;

        $this->_smarty->left_delimiter  = $this->left_delimiter;
        $this->_smarty->right_delimiter = $this->right_delimiter;
        $this->_smarty->force_compile   = $this->force_compile;
        $this->_smarty->template_dir    = MY_ROOT_PATH . $this->template_dir;
        $this->_smarty->compile_dir     = MY_ROOT_PATH . $this->compile_dir;


    }// END::function

    public function setOptions ($options)
    {
        if (is_array($options)) {
            if (isset($options['template']) && is_file($options['template'])) {
                $this->tplName = basename($options['template']);
                $options['template_dir'] = dirname($options['template']);
                unset($options['template']);
            }

            foreach ($options as $key => $value) {
                $this->_smarty->$key = $value;
            }
        }

        return $this;
    }

    public function display ($positions, $blocks, $mainBlock='')
    {
        //var_dump($positions, $blocks);
        if ((string)$mainBlock != '') {
            $this->_smarty->assign_by_ref('my_main', $mainBlock);
        }
        $positionsContent = array();

        reset($blocks);
        while (list(, $block) = each($blocks)) {
            $positionId = $block['position_id'];
            if (!isset($positionsContent[$positionId])) {
                $positionsContent[$positionId] = array();
            }
            $blockName = $block['block_show_name'];
            $positionsContent[$positionId][$blockName] = & $block['content'];
        }

        reset($positions);
        while(list(, $positionInfo) = each($positions)) {
            $positionId = $positionInfo['position_id'];
            if(isset($positionsContent[$positionId])) {
                $this->assignByRef($positionInfo['position_name'], $positionsContent[$positionId]);
                //var_dump($positionInfo['position_name'], $positionsContent[$positionId]);
            }
        }

        $this->_smarty->display($this->tplName);
    }

    public function & render ($contentList=array(), $display=false)
    {
        $ret = false;
        if (is_array($contentList)) {
            $my_position = array();
            foreach($contentList as $contentKey => $contentValue) {
                //var_dump($contentKey, $contentValue);
                $this->assignByRef($contentKey, $contentList[$contentKey]);
                $my_position[] = $contentKey;
            }
            $this->assignByRef('my_position', $my_position);

            if (true===$display) {
                $this->_smarty->display($this->tplName);
                $ret = true;
            } else {
                //echo $this->tplName;
                $ret = $this->_smarty->fetch($this->tplName);
            }
        }

        return $ret;
    }

    public function assign ($key, $value)
    {
        $this->_smarty->assign($key, $value);
    }

    public function assignByRef ($key, $value)
    {
        $this->_smarty->assign_by_ref($key, $value);
    }

    public function clearAssign ()
    {
        $this->_smarty->clear_all_assign();
    }

    public function registerFunction ($funcName, $functionName)
    {
        $this->_smarty->register_function($funcName, $functionName);
    }


    /****************** END::method zone *************************/

}// END::class
?>
