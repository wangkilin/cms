<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_module.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-2-4
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");
define('MY_MODULE_CLASS_INC', 1);

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Module extends My_Abstract
{
    /****************** START::property zone *************************/

    /**
     *@array    module information got by last query
     */
    protected $_moduleInfo = array();

    static protected $_self = NULL;

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
         My_Kernel::loadLanguage('class','module');//load class language
         if(is_object($db)) {
             $this->_db = $db;
         }
    }// END::constructor

    /**
     *@Description : get module information by module id
     *
     *@param : int    module id
     *
     *@return: mixed(array/false)
     */
    public function getModuleById($moduleId)
    {
        global $My_Sql;

        if(@$this->_moduleInfo['module_id'] == $moduleId) {
            return $this->_moduleInfo;
        }

        $this->_db->query($My_Sql['getModuleById'], array($moduleId));
        if($row = $this->_db->fetchArray())
        {
            $this->_moduleInfo = $row;
            return $row;
        }

        $this->_errorStr = __CLASS__."->".__FUNCTION__."()".$My_Lang->class['module']['getModuleInfoFail'];

        return false;
    }//END::function _getModuleById

    /**
     *@Decription : load all modules information
     *
     *@Param : boolean    if true, load modules from database in case module info file does not exist Or it is empty
     *
     *@return: void
     */
    public function loadAllModules($checkLoad = false)
    {
        global $My_Kernel;
        global $_system;
        global $My_Sql;

        if( $_system['config']['module_in_file']
            && file_exists(MY_ROOT_PATH . 'config/my_module.ini.php')) {
            include_once(MY_ROOT_PATH . 'config/my_module.ini.php');
        } else if(isset($_system['module'])) {
            unset($_system['module']);
        }

        $modules = array();
        if($checkLoad || !isset($_system['module'])) {
        //config has not pick out from database
            $this->_db->query($My_Sql['getAllModules']);
            while($row = $this->_db->fetchArray()) {
                $modules[$row['module_id']] = $row;
            }
            $_system['module'] = & $modules;
        }

        return $_system['module'];
        /* else if(isset($_))
                    $module_id = $row['module_id'];
                    $comp_id = $row['comp_id'];
                    if(isset($_system['component']["$comp_id"]))
                    {// we need make sure that module has parent, then we can get inter file and etc.
                        $inter_function = $inter_function?$inter_function:$_system['component']["$comp_id"]['inter_function'];
                        $config_function = $config_function?$config_function:$_system['component']["$comp_id"]['config_function'];
                        $inter_file = $_system['component']["$comp_id"]['inter_file'];
                        $config_file = $_system['component']["$comp_id"]['config_file'];
                        $_system['module']["$module_id"] = array('module_name'=>$row['module_name'],
                                                            'dir_name'=>$_system['component']["$comp_id"]['dir_name'] ,
                                                            'inter_file'=>$inter_file,
                                                            'inter_function'=>$inter_function,
                                                            'config_file'=>$config_file,
                                                            'config_function'=>$config_function,
                                                            'access_lever'=>$row['access_level'],
                                                            'comp_id'=>$comp_id,
                                                            'desc'=>$row['desc'],
                                                            'from_db'=>true);
                    }
                }
            }
            else
            {// no component available. So we re-select component. and at the same time, select modules data
                $query_module="select  m.module_id as m_module_id, m.module_name as m_module_name, m.inter_function as m_inter_function, m.config_function as m_config_function, m.access_level as m_access_level, m.desc as m_desc, c.db_type as c_db_type, c.db_num as c_db_num, c.dir_name as c_dir_name, c.inter_file as c_inter_file, c.inter_function as c_inter_function, c.comp_id as c_comp_id, c.comp_name as c_comp_name, c.desc as c_desc, c.config_file as c_config_file, c.config_function as c_config_function from #._module as m right join #._components as c on c.comp_id=m.comp_id where c.publish = 1";
                $db->query($query_module);
                $_tmp_comp_id = '';
                while($row=$db->fetchArray())
                {
                    $module_id = $row['m_module_id'];
                    $comp_id = $row['c_comp_id'];
                    $inter_function = $row['m_inter_function'];
                    $config_function = $row['m_config_function'];
                    if($module_id)
                    {
                        $inter_function = $inter_function?$inter_function:$row['c_inter_function'];
                        $inter_file = $c_inter_file;
                        $config_function = $config_function?$config_function:$row['c_config_function'];
                        $_system['module']["$module_id"] = array('module_name'=>$module_name,
                                                    'dir_name'=>$row['dir_name'],
                                                    'inter_file'=>$row['inter_file'],
                                                    'inter_function'=>$inter_function,
                                                    'config_file'=>$row['config_file'],
                                                    'config_function'=>$config_function,
                                                    'access_lever'=>$row['access_level'],
                                                    'comp_id'=>$row['comp_id'],
                                                    'desc'=>$row['desc'],
                                                    'from_db'=>true);
                    }
                    if($_tmp_comp_id!=$comp_id)
                    {
                        $_tmp_comp_id = $comp_id;
                        $_system['component']["$comp_id"] = array('comp_name'=>$row['c_comp_name'],
                                                    'inter_file'=>$row['c_inter_file'],
                                                    'inter_function'=>$row['c_inter_function'],
                                                    'config_file'=>$row['config_file'],
                                                    'config_function'=>$row['c_config_function'],
                                                    'db_type'=>$row['c_db_type'],
                                                    'db_num'=>$row['c_db_num'],
                                                    'dir_name'=>$row['c_dir_name'],
                                                    'desc'=>$row['c_desc'],
                                                    'from_db'=>true);
                    }
                }
            }
        }*/
    }//END::function loadAllModules

    /**
     *@Description : load module file
     *
     *@param : int    module id
     *
     *@return: boolean
     */
    protected function _checkAndLoadModuleFile($moduleName)
    {
        $moduleFrontFile = MY_ROOT_PATH . 'modules/' . $moduleName . '/front.php';

        if(is_file($moduleFrontFile)) {
            require_once($moduleFrontFile);

            return true;
        } else {
            echo $moduleFrontFile . ' do not exist!';

            return false;
        }
    }//END::function _loadModuleById

    /**
     *@Description : call module interface function to show specified content
     *
     *@param : int    module id
     *@param : array    parameters that will be transfered to module interface function
     *
     *@return : string
     */
    public function callModuleInterface($moduleId, $paramArray)
    {
        $this->_loadModuleById($moduleId);
        $moduleInterFunc = $this->_moduleInfo['inter_func'];

        return $moduleInterFunc($paramArray);
    }//END::function callModuleInterface

    /**
     *@Description : check if ID is a valid module ID
     *
     *@param : int    check ID
     *
     *@return : boolean
     */
    public function isValidModuleId($moduleId)
    {
        return is_array($this->getModuleById($moduleId));
    }//END::function isValidModuleId

    public function moduleIdExists ($moduleId)
    {
        return $this->isValidModuleId ($moduleId);
    }

    public function moduleAccessable ($moduleName, $rank)
    {
        $moduleInfo = $this->getModuleByName ($moduleName);

        return $moduleInfo['access_level']<=$rank;
    }

    public function getModuleByName ($moduleName)
    {
        global $My_Sql,$My_Lang;

        if(isset($this->_moduleInfo["module_name"]) &&
            $this->_moduleInfo["module_name"] == $moduleName) {

            return $this->_moduleInfo;
        }

        $this->_db->query($My_Sql['getModuleByName'], array($moduleName));
        if($row = $this->_db->fetchArray()) {
            $this->_moduleInfo = $row;

            return $row;

        } else {
            $this->_errorStr = __CLASS__."->".__FUNCTION__."()".$My_Lang->class['module']['getModuleInfoFail'];

            return false;
        }
    }

    public function loadBlocksContentIntoPosition (& $blocks)
    {
        $contents = array();
        $blocks = (array) $blocks;
        //var_dump($blocks);
        while (list($key, $block) = each($blocks)) {
            $blocks[$key]['content'] = & $this->getBlockContent($block);
        }
    }

    public function & getBlockContent ($block)
    {
        $content = $this->getBlockHeader($block);

        $moduleId = $block['module_id'];
        $moduleInfo = $this->getModuleById($moduleId);
        $moduleName = $moduleInfo['module_name'];
        if ($moduleInfo && $this->_checkAndLoadModuleFile($moduleName)) {
            $functionName = $this->_getModuleFunctionName($moduleName);
            if (function_exists($functionName)) {
                $moduleInfo = array ('moduleId' => $moduleId,
                                     'moduleName' => $moduleName);
                $mainContent = $functionName ($moduleInfo, $block['params']);

                if (is_array($mainContent)) {
                    if (isset($mainContent['content_type'], $mainContent['content']) && $mainContent['content_type']=='URL') {
                        $content = $mainContent;
                    } else {
                        $content = array('header'=>$content, 'content'=>$mainContent);
                    }
                } else {
                    $content .= (string) $mainContent;
                }
            }
        }

        return $content;
    }

    protected function _getModuleFunctionName($moduleName)
    {
        return $moduleName . '_output';
    }

    protected function getBlockHeader ($block)
    {
        $blockHeader = '';
        if (!empty($block['show_block_name'])) {
            $blockHeader .= '<p class="block_header_name">' . $block['block_show_name'] . "</p>\n";;
        }

        if (!empty($block['show_link']) && !empty($block['block_link'])) {
            $target = '';
            if ($block['block_link_target']) {
                $target = ' target="' . $block['block_link_target'] . '" ';
            }
            $blockHeader = '<p class="block_link"><a href="' . $block['block_link'] . '"' . $target . '>' . $blockHeader . "</a></p>\n";
        }

        if (!empty($block['attach_text']) && !empty($block['attach_link'])) {
            $target = '';
            if ($block['attach_link_target']) {
                $target = ' target="' . $block['attach_link_target'] . '" ';
            }
            $blockHeader = $blockHeader . '<p class="block_attach_link"><a href="' . $block['attach_link'] . '"' . $target . '>' . $block['attach_text'] . "</a></p>\n";
        }
        //echo $blockHeader;

        return $blockHeader;
    }

    public function & getMainBlockContent ($moduleId)
    {
        $fakeBlock = array ('module_id' => $moduleId,
                            'params'    => MY_LOAD_MAIN_BLOCK_CONTENT
                     );

        return $this->getBlockContent ($fakeBlock);
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
