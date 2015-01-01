<?php
/**
 * The module abstract class
 */
abstract class module
{
	/****************** START::property zone *************************/
    /*
     * @var array
     * module information.(module id and module name)
     */
    protected $_moduleInfo;

    /*
     * @var object
     * The templater system is using
     */
    protected $templater;

    /*
     * @var array
     * parameters list
     */
    protected $_params = array();

    protected $_isFinalPage = false;


	/****************** END::property zone *************************/
    public function __construct ($moduleInfo)
    {
        global $My_Kernel;
        global $My_Lang;

        $My_Kernel->loadLanguage('module', $moduleInfo['moduleName']);

        $this->lang = & $My_Lang->module[$moduleInfo['moduleName']];

        $this->_moduleInfo = $moduleInfo;

        $this->templater = $My_Kernel->getTemplater ();
        $this->templater->clearAssign()
                        ->assign('module_id', $this->_moduleInfo['moduleId'])
                        ->assign('module_name', $this->_moduleInfo['moduleName'])
                        ->assign('MY_ROOT_URL', MY_ROOT_URL)
                       ;
    }

    public function setParams ($parameterExpressionString, $isFinalPage=false)
    {
        if (is_string($parameterExpressionString)) {
            $parameterList = explode (MY_PARAM_SEPARATOR, $parameterExpressionString);
            reset($parameterList);
            while (list(, $param) = each($parameterList)) {
                $paramInfo = explode('=', $param, 2);
                if ($paramInfo) {
                    $this->_params[$paramInfo[0]] = trim($paramInfo[1]);
                }
            }
        }

        return $this;
    }

    public function setFinalPage()
    {
        $this->_isFinalPage = true;

        return $this;
    }
    
    public function goHomepage()
    {
    	
        $ret = array('content_type' => 'URL',
                     'content'      => MY_ROOT_URL);
        
        return $ret;
    }

    abstract public function returnWeb();

    public function returnWap()
    {
        return '';
    }

    public function returnRss()
    {
        return '';
    }
}
/* EOF */