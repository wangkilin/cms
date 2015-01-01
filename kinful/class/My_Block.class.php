<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_block.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-4-14
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");
define('MY_BLOCK_CLASS_INC', 1);    // all files including this class should check if this is defined

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Block extends My_Abstract
{
    /****************** START::property zone *************************/

    /**
     *@array    block information got by last query
     */
    protected $_blockInfo = array();

    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Description : constructor
     *
     *@return: constractor
     */
    public function __construct($db)
    {
         global $My_Lang;
         My_Kernel::loadLanguage('class','block');//load class language
         if(is_object($db))
             $this->_db = $db;
    }// END::constructor

    /**
     * get All public block for the front page.
     *
     * @param int $displayPageId  By this page id, check blocks: -1=>all pages
     *
     * @return array blocks list
     */
    public function & getPublicBlocks ($displayPageId=-1)
    {
        global $my_client_type;
        global $My_Sql;

        switch ($my_client_type) {
            case MY_CLIENT_IS_WAP:
                $clientType = MY_SUPPORT_WAP;
                break;

            case MY_CLIENT_IS_RSS:
                $clientType = MY_SUPPORT_RSS;
                break;

            default:// my client is web browser
                $clientType = MY_SUPPORT_WEB;
                break;
        }

        $blocks = array();
        $sql = $My_Sql['getPublicBlocks'];
        $this->_db->query($sql, array($displayPageId, $clientType));
        //var_dump($sql, $displayPageId, $clientType);

        while ($row = $this->_db->fetchArray()) {
            if($row['access_roles']) {
                $accessRoles = explode(MY_INT_SEPARATOR, trim($row['access_roles'], MY_INT_SEPARATOR));
                if(count(array_intersect($_SESSION['my_user']['role_ids'], $accessRoles))<1 ) {
                    continue;
                }
            }
            if($row['more_params']) {
                $row['params'] = $row['params'] . MY_PARAM_SEPARATOR . $row['more_params'];
            }
            $blocks [] = $row;
        }

        return $blocks;
    }

    /**
     * get blocks by page
     *
     */
    public function getPageBlocks($pageId)
    {
        global $My_Sql;

        $blocks = array();
        $sql = $My_Sql['getPageBlocks'];
        $this->_db->query($sql, array($pageId));

        while ($row = $this->_db->fetchArray()) {
            $blocks [] = $row;
        }

        return $blocks;
    }

    /**
     *@Description: load all Blocks information
     *
     *@return: void
     */
    public function loadAllBlocks($checkLoad=false, $onlyPublic=true)
    {
        global $_system;
        global $My_Kernel;
        global $_params;
        $this->loadAllModules();
        if(isset($_system['component']) && isset($_system['module']) && !empty($_system['config']['block_in_file']) && file_exists(MY_ROOT_PATH."config/my_block.ini.php"))
        {// block in file. require it.
            include_once(MY_ROOT_PATH."config/my_block.ini.php");
        }
        elseif(isset($_system['block']))
        {// make sure to use our own block.
            unset($_system['block']);
        }

        if($checkLoad === true || !isset($_system['block']))
        {// block file has no content or no block file
            if(isset($_system['module']) && isset($_system['component']))
            {
                $select_block = "select * from #._block ";
                if($onlyPublic===true)
                    $select_block .= " where publish = 1";
                $this->_db->query($select_block);
                while($row = $this->_db->fetchArray())
                {
                    $_module_id = $row['module_id'];
                    $_block_id = $row['block_id'];
                    if(!isset($_system['module']["$_module_id"]))
                    {
                        $delete_block = "delete from #._block where block_id = $_block_id";
                        //$this->_db->query($delete_block);
                        echo $delete_block;
                        continue ;
                    }
                    $_parent_id = $row['parent_id'];
                    $_block_name = $row['block_name']?$row['block_name']:'';
                    $_position_id = $row['position_id'];
                    $_order = $row['order'];
                    $_params = $row['params']?$row['params']:'';
                    $_block_link = $row['block_link'];
                    $_show_link = $row['show_link'];
                    $_type = $row['type'];
                    $_show_page = $row['show_page'];// ����Щλ����ʾ(0:ȫ����1����ҳ��2��ָ��ģ��)
                    $_show_in_com = $row['show_in_com']?(explode($_system['config']['db_int_seperator'],substr($row['show_in_com'],1,strlen($row['show_in_com'])-2))):array();// ָ����ʾ������б���
                    $_show_in_mod  = $row['show_in_mod']?(explode($_system['config']['db_int_seperator'],substr($row['show_in_mod'],1,strlen($row['show_in_mod'])-2))):array();//�Զ�����ʾ����Щģ��
                    $_show_level = $row['show_level'];
                    $_system['block']["$_position_id"][] = array('block_id'=>$_block_id,
                        'parent_id'    =>$_parent_id,
                        'block_name'=>$_block_name,
                        'position_id'=>$_position_id,
                        'module_id'    =>$_module_id,
                        'order'        =>$_order,
                        'params'    =>$_params,
                        'block_link'=>$_block_link,
                        'show_link'    =>$_show_link,
                        'type'=>$_type,
                        'show_page'    =>$_show_page,
                        'show_in_com'=>$_show_in_com,
                        'show_in_mod'=>$_show_in_mod,
                        'show_level' =>$_show_level,
                        'publish'    =>$row['publish'],
                        'from_db'    =>true
                    );
                }
            }
            else
            {
                $select_block = "select * from #._component as c left join #._module as m on m.comp_id=c.comp_id left join #._block as b on b.module_id = m.module_id where c.publish = 1";
                //$this->_db->setDebug(true);
                $this->_db->query($select_block);
                //$this->_db->setDebug(false);
                $_tmp_module_id = '';// later, we will compare real module id with it
                $_tmp_block_id = '';// later, we will compare real block id with it
                while(list($_comp_id, $_comp_name, $_c_inter_file, $_c_inter_function, $_c_config_file, $_c_config_function, $_db_type, $_db_num, $_c_publish, $_dir_name, , , $_c_access_level, $_desc, $_m_module_id, $_module_name, $_m_publish, $_m_inter_function, $_m_config_function, $_access_level, $_m_comp_id,$_m_desc, $_block_id, $_parent_id, $_block_name, $_b_module_id, $_position_id, $_order, $_params, $_block_link, $_show_link, $_type, $_show_page, $_b_publish, $_show_in_com, $_show_in_mod, $_show_level) = $this->_db->fetchRow())
                {
                    if($_block_id && $_tmp_block_id != $_block_id)
                    {
                        $_tmp_block_id = $_block_id;
                        /***** start block zone *****/
                        $_block_name = $_block_name?$_block_name:'';
                        $_params = $_params?$_params:'';
                        $_show_in_com = $_show_in_com?(explode($_system['config']['db_int_seperator'],substr($_show_in_com,1,strlen($_show_in_com)-2))):array();// ָ����ʾ������б���
                        $_show_in_mod  = $_show_in_mod?(explode($_system['config']['db_int_seperator'],substr($_show_in_mod,1,strlen($_show_in_mod)-2))):array();//�Զ�����ʾ����Щģ��
                        $_system['block']["$_position_id"][] = array('block_id'=>$_block_id,
                            'parent_id'=>$_parent_id,
                            'block_name'=>$_block_name,
                            'position_id'=>$_position_id,
                            'module_id'=>$_b_module_id,
                            'order'=>$_order,
                            'params'=>$_params,
                            'block_link'=>$_block_link,
                            'show_link'=>$_show_link,
                            'type'=>$_type,
                            'show_page'=>$_show_page,
                            'show_in_com'=>$_show_in_com,
                            'show_in_mod'=>$_show_in_mod,
                            'show_level'=>$_show_level,
                            'publish'    =>$_b_publish,
                            'from_db'=>true
                        );
                        /***** end block zone *****/
                    }
                    if($_m_module_id && $_m_module_id != $_tmp_module_id)
                    {
                        $_tmp_module_id = $_m_module_id;
                        /***** start module zone *****/
                        $inter_function = $_m_inter_function?$_m_inter_function:$_c_inter_function;
                        $inter_file = $_c_inter_file;
                        $_system['module']["$_m_module_id"] = array("module_name"=>$_module_name,
                            'db_type'=>$_db_type,
                            'dir_name'=>$_dir_name,
                            'inter_file'=>$inter_file,
                            'inter_function'=>$inter_function,
                            'access_level'=>$_access_level,
                            'comp_id'=>$_comp_id,
                            'desc'=>$_m_desc,
                            'from_db'=>true
                        );
                        /***** end module zone *****/
                    }

                    $_system['component']["$_comp_id"] = array('comp_name'=>$_comp_name, 'inter_file'=>$_c_inter_file, 'inter_function'=>$_c_inter_function,  'db_type'=>$_db_type, 'db_num'=>$_db_num, 'dir_name'=>$_dir_name, 'desc'=>$_desc, 'access_level'=>$_c_access_level, 'from_db'=>true);

                }//End while
            }//End if(isset($_system['module']) && isset($_system['component']))
        }//End if(!isset($_system['block']))
    }//END::function loadAllBlocks

    /**
     * get using blocks by block ids list
     *
     * @param array $blockIdsList The block ids list
     *
     * @return array The blocks
     */
    public function getUsingBlockByIds($blockIdsList)
    {
        global $My_Sql;

        foreach($blockIdsList as $key=>$id) {
            $blockIdsList[$key] = intval($id);
        }
        $blocks = array();
        $sql = $My_Sql['getUsingBlockByIds'];
        $this->_db->query($sql, array(join("','", $blockIdsList)));
        while ($row = $this->_db->fetchArray()) {
            $blocks [] = $row;
        }

        return $blocks;

    }

    /**
     * Get the pages that block does not be shown in
     * @param int $blockId The block id
     *
     * @return array The page list
     */
    public function getExcludePageByBlockId($blockId)
    {
        global $My_Sql;

        return $this->getListBySql($My_Sql['getExcludePageByBlockId'], array($blockId));
    }

    /**
     * Get the pages by using block id
     * @param int $usingBlockId The using block id
     * @return array The page list
     */
    public function getIncludePageByUsingBlockId($usingBlockId)
    {
        global $My_Sql;

        return $this->getListBySql($My_Sql['getIncludePageByUsingBlockId'], array($usingBlockId));
    }

    /**
     * Remove using block by using block id
     * @param int $usingBlockId The using block id
     * @return void
     */
    public function removeUsingBlock($usingBlockId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['removeUsingBlock'], array($usingBlockId));
    }

    /**
     * Remove page data from #._using_page_block by using page id
     * @param int $usingPageId The using page id
     * @return void
     */
    public function removeBlockPage($usingPageId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['removeBlockPage'], array($usingPageId));
    }

    /**
     * Add block page, eigher INCLUDE page, or EXCLUDE page
     * @param int $usingBlockId The using block id
     * @param int $pageId The page id
     * @return void
     */
    public function addBlockPage($usingBlockId, $pageId)
    {
        global $My_Sql;

        $this->_db->query($My_Sql['addBlockPage'], array($usingBlockId, $pageId));

        return $this->_db->insertId();
    }

    /**
     * Set using block option.
     * @param int $usingBlockId The using block id
     * @param array $optionValue Key is field name, Value is new value
     * @return void
     */
    public function setUsingBlock($usingBlockId, $optionValue)
    {
        global $My_Sql;

        list($key, $value) = $optionValue;
        switch($key) {
            case 'showInType':
                $this->_db->query($My_Sql['setUsingBlockShowInType'], array($value, $usingBlockId));
                break;

            default:
                break;
        }
    }

    /**
     * Add block as using block
     * @param array $blockInfo The block information list.
     *              At least it has : position_id, page_id, block_id, block_name, show_in_type
     * @return int The new using block id
     */
    public function addVisibleBlock($blockInfo)
    {
        global $My_Sql;

        if(!isset($blockInfo['position_id'], $blockInfo['block_id'], $blockInfo['page_id'],
                  $blockInfo['block_name'], $blockInfo['show_in_type'])) {
            return 0;
        }

        $params = array($blockInfo['block_id'], $blockInfo['block_name'], $blockInfo['position_id'], $blockInfo['show_in_type']);
      //  var_dump(__FILE__ . __LINE__, $My_Sql['addVisibleBlock'], $params);
        $this->_db->query($My_Sql['addVisibleBlock'], $params);
        $usingBlockId = $this->_db->insertId();
        if($usingBlockId && isset($blockInfo['page_id'])) {
            $this->addBlockPage($usingBlockId, $blockInfo['page_id']);
        }

        return $usingBlockId;
    }

    /**
     * Get data list from DB.
     *
     * @param string $sql The unformated sql statement
     * @param array $param The parameters list
     * @param array $bind If set, the returned list will be bind with Id/label
     *
     * @return array
     */
    protected function getListBySql($sql, $param, $bind=array())
    {
        $retList = array();
        $this->_db->query($sql, $param);
        while($row=$this->_db->fetchArray()) {
            if(isset($bind['id'], $bind['label'])) {
                $retList[$bind['id']] = $row[$bind['label']];
            } else if (isset($bind['id'])) {
                $retList[$bind['id']] = $row;
            } else {
                $retList [] = $row;
            }
        }

        return $retList;
    }

    /**
     *@Description : get class error
     *
     *@return: string
     */
    public function getError()
    {
        return $this->_errorStr;
    }//END::function getError

    /**
     *@Description : set class debug mode
     *
     *@param : boolean
     *
     *@return: void
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;;
    }//END::function setDebug

    /****************** END::method zone *************************/

}// END::class
?>
