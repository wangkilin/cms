<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : MY_channel.class.php
 *@Author    : WangKilin
 *@Email    : wangkilin@126.com
 *@Date        : 2007-4-14
 *@Homepage    : http://www.kinful.com
 *@Version    : 0.1
 */
defined('Kinful') or die("forbidden");

class MY_FormAction
{
    /****************** START::property zone *************************/
    protected $_setting = array();

    protected $_supportAction = array('new', 'edit', 'save', 'copy', 'publish', 'unpublish',
                                      'move', 'delete', 'help', 'next', 'return');

    /****************** END::property zone *************************/


    /****************** START::method zone *************************/
    /**
     *@Description : constructor
     *
     *@return: constractor
     */
    public function __construct()
    {
         global $My_Lang;

         My_Kernel::loadLang('plugin','formAction');//load class language

         $this->lang = & $My_Lang->plugin['formAction'];
    }// END::constructor

    /**
     *@param array $setting array('action' => array ( 'new' , ....)
     *                            'preAction' => array('new'=>'preNew', ...))
     */
    public function load ($formId, $setting)
    {
        global $My_Kernel;

        $formId = trim((string)$formId);

        if ($formId=='' || !isset($setting['action']) || !is_array($setting['action'])) {
            return '';
        }

        $templater = $My_Kernel->getTemplater ();
        $templater->clearAssign()
                  ->assignList(array('MY_ROOT_URL' => MY_ROOT_URL,
                                     'form'    => $formId,
                                     'action'  => $setting['action'],
                                     'lang'    => $this->lang
                                    )
                               )
                       ;

        if (isset($setting) && is_array($setting)) {
            if (isset($setting['preAction'])) {
                $templater->assign('pre_action', $setting['preAction']);
            }

            if (isset($setting['warning'])) {
                $templater->assign('warning', $setting['warning']);
            }
        }

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'plugin',
                                                          'file' => 'plugin_form_action.php'
                                                        )
                    );

        return $templater->setOptions($templateInfo)->render();
    }

    /****************** END::method zone *************************/

}// END::class
?>
