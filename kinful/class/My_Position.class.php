<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_position.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-4-29
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");
define('MY_POSITION_CLASS_INC',1);

require_once(dirname(__FILE__) . '/My_Abstract.class.php');

class My_Position extends My_Abstract
{
    /****************** START::property zone *************************/

    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Description : constructor
     *
     *@return: constractor
     */
    public function __construct(&$db)
    {
         global $My_Lang;

         My_Kernel::loadLanguage('class','position');//load class language
         if(is_object($db))
             $this->_db = $db;
    }// END::constructor

    /**
     *@Decription : load all position information
     *
     *@return: void
     */
    public function & getPositions($mustLoadFromDb=false)
    {
        global $_system;
        global $My_Sql;

        $positions = array();

        if( true!==$mustLoadFromDb && $_system['config']['position_in_file'] && file_exists(MY_ROOT_PATH. "config/my_position.ini.php")) {
        // position information is in config file, load the config file
            require_once(MY_ROOT_PATH."config/my_position.ini.php");
        } elseif(isset($_system['position'])) {
            unset($_system['position']);
        }

        if ($mustLoadFromDb===true) {
            unset($_system['position']);
        }

        if(!isset($_system['position'])) {
            $this->_db->query($My_Sql['getAllPositions']);
            while($positionInfo = $this->_db->fetchArray()) {
                $positions [] = $positionInfo;
            }
        }

        return $positions;
        /*
                $position_id = $positionInfo['position_id'];
                $position_name = $positionInfo['position_name'];
                $show_page =
                $show_in_com = $show_in_com?(explode($_system['config']['db_int_seperator'],substr($show_in_com,1,strlen($show_in_com)-2))):array();// 指定显示在组件列表中
                $show_in_mod  = $show_in_mod?(explode($_system['config']['db_int_seperator'],substr($show_in_mod,1,strlen($show_in_mod)-2))):array();//自定义显示在那些模块
                $_system['position']["$position_id"] = array('position_name'=>$position_name, 'show_page'=>$show_page, 'show_in_com'=>$show_in_com, 'show_in_mod'=>$show_in_mod, 'from_db'=>true);
            }
        }


/*
        if(!empty($_system['config']['position_in_file']) && (list(,$positionInfo) = each($_system['position'])) && $positionInfo['from_db']===true) {
            $positionFile = '';
            foreach($_system['position'] as $position_id=>$positionInfo)
            {
                $positionFile .= sprintf("%-35s",'$_system["position"]["'.$position_id.'"]')."=\t array(
                                        'position_name'=>'".$positionInfo['position_name']."',
                                        'show_page'=>".$positionInfo['show_page'].",
                                        'show_in_com'=>array(".join(',',$positionInfo['show_in_com'])."),
                                        'show_in_mod'=>array(".join(',',$positionInfo['show_in_mod'])."),
                                        'from_db'=>false
                                    );\t//\n";
            }
            $this->_createConfigFile("my_position.ini.php", $positionFile);
        }*/
    }//END::function loadAllPosition

    /**
     *@Decription : delete position by id
     *
     *@Param : int    position id
     *
     *@return: boolean
     */
    public function deletePositionById($positionId)
    {
    }//END::function deletePositionById

    /**
     *@Decription : change position by id
     *
     *@Param : int        position id
     *@Param : array    new position information
     *
     *@return: boolean
     */
    public function changePositionById($positionId, $newPositionInfo)
    {
    }//END::function changePositionById

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
