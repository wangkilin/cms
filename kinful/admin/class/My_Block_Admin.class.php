<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : My_Block.class.php
 *@Author   : WangKilin
 *@Email    : wangkilin@126.com
 *@Date     : 2007-4-14
 *@Homepage : http://www.kinful.com
 *@Version  : 0.1
 */
defined('Kinful') or die("forbidden");

require_once(MY_ROOT_PATH . '/class/My_Block.class.php');

class My_Block_admin extends My_Block
{


    /****************** START::method zone *************************/

    /**
     * Get all public blocks
     *
     * @return array All public blocks list
     */
    public function & getAllPublicBlocks()
    {
        $blocks = array();
        $sql = $My_Sql['getAllPublicBlocks'];
        $this->_db->query($sql);

        while ($row = $this->_db->fetchArray()) {
            $blocks [] = $row;
        }

        return $blocks;
    }

    /**
     *@Description: load all front Blocks information
     *
     *@return: void
     */
    public function getAllFrontBlocks($checkLoad=false)
    {
        global $_system;
        global $My_Sql;

        if(!empty($_system['config']['block_in_file'])
           && file_exists(MY_ROOT_PATH . 'config/My_Block.ini.php')) {
        // block in file. require it.
            include_once(MY_ROOT_PATH."config/My_Block.ini.php");
        } else if(isset($_system['block'])) {
        // make sure to use our own block.
            unset($_system['block']);
        }

        $frontBlocks = array();
        if($checkLoad === true || !isset($_system['block'])) {
        // block file has no content or no block file
            $this->_db->query($My_Sql['getAllFrontBlocks']);
            while($row = $this->_db->fetchArray()) {
                $frontBlocks[] = $row;
            }
        } else if(isset($_system['block'])) {
            foreach($_system['block'] as $block) {
                if(!$block['is_admin']) {
                    $frontBlocks[] = $block;
                }
            }
            unset($block);
        }

        return $frontBlocks;

    }//END::function loadAllBlocks

    /**
     *@Description: load all common page Blocks
     *
     *@return array
     */
    public function getPageCommonBlocks($checkLoad=false)
    {
        global $_system;
        global $My_Sql;

        $commonBlocks = array();
        $this->_db->query($My_Sql['getPageCommonBlocks']);
        while($row = $this->_db->fetchArray()) {
            $commonBlocks[] = $row;
        }

        return $commonBlocks;

    }//END::function loadAllBlocks

    /**
     * sort blocks list by module id. the returned array will used moduleId as key
     *
     * @param array $unsortedBlocks The unsorted blocks list
     *
     * @return array
     */
    public function & sortBlockByModuleId($unsortedBlocks)
    {
        $sortedBlocks = array();
        foreach((array)$unsortedBlocks as $block) {
            if(!isset($sortedBlocks[$block['module_id']])) {
                $sortedBlocks[$block['module_id']] = array();
            }
            $sortedBlocks[$block['module_id']][] = $block;
        }

        return $sortedBlocks;
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

/* EOF */
