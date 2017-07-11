<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Module_admin.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-2-4
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

require_once (MY_ROOT_PATH . 'class/My_Module.class.php');

class My_Module_Admin extends My_Module
{
    /****************** START::property zone *************************/

    /****************** END::property zone *************************/


    /****************** START::method zone *************************/

    /**
     *@Description : load module file
     *
     *@param : int    module id
     *
     *@return: boolean
     */
    protected function _checkAndLoadModuleFile($moduleName)
    {
        $moduleFrontFile = MY_ROOT_PATH . 'modules/' . $moduleName . '/admin.php';

        if(is_file($moduleFrontFile)) {
            require_once($moduleFrontFile);

            return true;
        } else {
            //echo $moduleFrontFile . ' do not exist!';

            return false;
        }
    }//END::function _loadModuleById

    protected function _getModuleFunctionName($moduleName)
    {
        return $moduleName . '_admin';
    }

    public function installModule ($moduleName)
    {
        $moduleInfo = array();
        $moduleDescFile = MY_ROOT_PATH . 'modules/' . $moduleName . '/install.xml';
        if (is_file($moduleDescFile)) {

        } else if ($this->_checkAndLoadModuleFile($moduleName)) {
            $functionName = $moduleName . '_install';
            if (function_exists($functionName)) {
                $moduleInfo = $functionName ();
            }
        }

        if ($moduleInfo) {
            // install front
            // install admin

            return true;
        }

        return false;
    }


    /****************** END::method zone *************************/

}// END::class

/* EOF */
