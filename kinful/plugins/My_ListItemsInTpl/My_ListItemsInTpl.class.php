<?php

class My_ListItemsInTpl
{
    /**
     * Container. Be used to set item HTML tags.
     * @var array
     */
    protected $container = array( 'pool'  =>array('class'=>'itemZone'),
                                  'item'  =>array('class'=>'item'),
                                  'subItem'=>array('class'=>'subItem'),
                                  'header'=>array('class'=>'itemHeader'),
                                  'menu ' =>array('class'=>'itemMenu'),
                                  'page'  =>array('class'=>'itemPage'),
                                  'number'=>array('class'=>'itemNumberForPage')
                           );

    protected $listKeys = array();

    protected $itemMenu = array();

    protected $itemHeader = array();

    protected $enablePageGuide = true;

    protected $enableSelectNumberForPage = true;

    protected $totalItemNumber = 3;

    protected $currentPage     = 1;
    protected $pageLink        = '?';

    protected $numberPerPageIndex = 0;
    static private $numberListPerPage = array(5, 10, 15, 20, 30, 50);

    protected $templateFileName = 'plugin_list_items.php';

    static private $itemLang          = array();


    static public function my_print_item ($params)
    {
        $return = '';

        extract($params);

        if (isset($listKey, $item)) {
            if (is_string($listKey) && isset($item[$listKey])) {
                $return = $item[$listKey];
            } else if (is_array($listKey) && isset($listKey['key'], $listKey['value'])) {
                $valueList = array();
                if (is_array($listKey['value'])) {
                    foreach($listKey['value'] as $valueKey) {
                        $valueKey = (string) $valueKey;
                        $_valueKey = substr($valueKey, 6);
                        $valueList[] = (substr($valueKey, 0, 6)=='$lang_' && isset($item[$_valueKey], self::$itemLang[$item[$_valueKey]]))
                                         ? self::$itemLang[$item[$_valueKey]] : (isset($item[$valueKey]) ? $item[$valueKey] : $valueKey);
                    }
                } else {
                    $valueList[] = (string) $listKey['value'];
                }
                $return = vsprintf($listKey['key'], $valueList);
            } else {
                $return = (string)$listKey;
            }
        }

        return $return;
    }

    static public function my_print_item_menu ($params)
    {//process menu
        $return = '';

        extract($params);

        if (!isset($menuKey, $menuOption, $item)) {
            return $return;
        }

        if (isset($menuOption['class'])) {
            $menuClass = $menuOption['class'];
            unset($menuOption['class']);
        } else {
            $menuClass = 'MENU_' . $menuKey;
        }

        if(is_array($menuOption) && isset($menuOption['html'])){
            if (is_array($menuOption['html'])) {
                foreach($menuOption['html'] as $menuHTML) {
                    if(count($menuOption)>1){
                        $paramList = array();
                        foreach($menuOption as $key=>$optionKey){
                            if('html'!=$key) {
                                $optionKey = (string) $optionKey;
                                $_optionKey = substr($optionKey, 6);
                                $paramList[] = (substr($valueKey, 0, 6)=='$lang_' && isset($item[$_optionKey], self::$itemLang[$item[$_optionKey]])) ? self::$itemLang[$item[$_optionKey]] :
                                          (isset($item[$optionKey]) ? $item[$optionKey] : $optionKey);
                            }
                        }
                        $return .= vsprintf($menuHTML, $paramList);
                    } else {
                        $return .= $menuHTML;
                    }
                }
            } else if (is_string) {

                if(count($menuOption)>1){
                    $paramList = array();
                    foreach($menuOption as $key=>$optionKey){
                        if('html'!=$key) {
                            $optionKey = (string) $optionKey;
                            $_optionKey = substr($optionKey, 6);
                            $paramList[] = (substr($valueKey, 0, 6)=='$lang_' && isset($item[$_optionKey], self::$itemLang[$item[$_optionKey]])) ? self::$itemLang[$item[$_optionKey]] :
                                      (isset($item[$optionKey]) ? $item[$optionKey] : $optionKey);
                        }
                    }
                    $return .= vsprintf($menuOption['html'], $paramList);
                } else {
                    $return .= $menuOption['html'];
                }
            }
        } else if(is_array($menuOption) && isset($menuOption['url'])){
            if(count($menuOption)>1){
                $paramList = array();
                foreach($menuOption as $key=>$optionKey){
                    if('url'!=$key) {
                        $paramList[] = isset($item[$optionKey])?$item[$optionKey]:$optionKey;
                    }
                }
                $return .= "<a href='".vsprintf($menuOption['url'], $paramList) . "' title='". $menuKey . "'>". $menuKey . "</a>";
            } else {
                $return .= "<a href='{$menuOption['url']}' title='" . $menuKey . "'>". $menuKey . "</a>";
            }
        } else if(is_string($menuOption)){
            $return .= "<a href='{$menuOption}' title='" . $menuKey . "'>". $menuKey . "</a>";
        }


        return $return;
    }

    public function set ($property, $value)
    {
        if (isset($this->$property)) {
            $this->$property = $value;
        } else if (isset(self::$$property)) {
            self::$$property = $value;
        }

        return $this;
    }

    public function get ($property)
    {
        if (isset($this->$property)) {
            return $this->$property;
        } else if (isset(self::$$property)) {
            return self::$$property;
        }

        return NULL;
    }

    public function setOptions ($propertyList)
    {
        foreach ($propertyList as $property=>$value) {
            $this->set($property, $value);
        }

        return $this;
    }

    public function listItemsInTpl ($menus)
    {
        global $My_Kernel;

        $templateInfo = $My_Kernel->getTemplateInfo(array('type' => 'plugin',
                                                          'file' => $this->templateFileName
                                                        )
                    );
        if (!isset(self::$numberListPerPage[$this->numberPerPageIndex])) {
            $this->numberPerPageIndex = 0;
        }
        $totalPage = ceil($this->totalItemNumber/self::$numberListPerPage[$this->numberPerPageIndex]);

        return $My_Kernel->getTemplater()
                         ->clearAssign()
                         ->registerFunction('my_print_item', 'MY_listItemsInTpl::my_print_item')
                         ->registerFunction('my_print_item_menu', 'MY_listItemsInTpl::my_print_item_menu')
                         ->assignList(array(
                                          'container' =>$this->container,
                                          'items'     => $menus,
                                          'itemMenu'  => $this->itemMenu,
                                          'itemHeader'=> $this->itemHeader,
                                          'listKeys'  => $this->listKeys,
                                          'enablePageGuide' => $this->enablePageGuide,
                                          'enableSelectNumberForPage' =>$this->enableSelectNumberForPage,
                                          'totalItemNumber' => $this->totalItemNumber,
                                          'currentPage'     => $this->currentPage,
                                          'totalPage'       => $totalPage,
                                          'pageLink'        => $this->pageLink,
                                          'numberListPerPage' => self::$numberListPerPage,
                                          'numberPerPageIndex'=> $this->numberPerPageIndex
                                      )
                           )
                         ->assignRefList(array(
                                          'language' =>$this->lang,
                                          'itemLang' =>self::$itemLang,
                                      )
                           )
                         ->setOptions($templateInfo)
                         ->render();
    }

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
         global $My_Lang;

         MY_kernel::loadLang('plugin','listItems');//load plugin language

         $this->lang = &  $My_Lang->plugin['listItems'];
    }
}

/* EOF */
