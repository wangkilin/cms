<?php

class My_ListItems
{
    /**
     * Container. Be used to set item HTML tags.
     * @var array
     */
    protected $_container = array('pool'=>array('div'=>array('class'=>'itemZone')),
                                  'item'=>'div',
                                  'list'=>array('p'=>array('class'=>'item')),
                                  'header'=>array('div'=>array('class'=>'itemHeader')),
                                  'menu'=>array('p'=>array('class'=>'item itemMenu')),
                                  'page'=>array('div'=>array('class'=>'itemPage')),
                                  'number'=>array('div'=>array('class'=>'itemNumberForPage'))
                           );

    /**
     * Flag to be attached to id
     * @var string
     */
    private $_flagAttachId = '';

    /**
     * loop line class
     */
    private $_loopLineClasses = array('itemOddLine', 'itemEvenLine');

    private $_sortItems = 1;

    private $_enablePageGuide = true;

    private $_enableSelectNumberForPage = true;

    private $_totalItemNumber = 100;

    private $_currentPage     = 1;
    private $_totalPage       = 5;
    private $_pageLink        = '#';

    private $_myLang          = array();

    /**
     * Get flag string used to attach Id
     *
     * @param array $item  Data information
     *
     * @return string
     */
    private function _getFlagFromItem(array $item)
    {
        if(''!=$this->_flagAttachId && isset($item[$this->_flagAttachId])){
            return (string) $item[$this->_flagAttachId];
        }
        return '';
    }


    public function set ($property, $value)
    {
        if (is_string($property) && ''!=$property) {
            $this->$property = $value;
        }

        return $this;
    }

    public function setList ($propertyList)
    {
        foreach($propertyList as $property => $value) {
            $this->set($property, $value);
        }

        return $this;
    }

    public function get ($property)
    {
        if (is_string($property) && ''!=$property && isset($this->$property)) {
            return $this->$property;
        } else {
            return null;
        }
    }

    /**
     * Get container start tag
     *
     * @param string $containerKey The key to be used to find in $this->_container
     * @param string $attachFlag String to be attached to tag Id
     *
     * @return string
     */
    protected function getStartTag($containerKey, $attachFlag='')
    {
        $startTag = '';
        if(isset($this->_container[$containerKey])){
        //specify container TAG
            if(is_array($this->_container[$containerKey])){
            //more than one tag to be used
                reset($this->_container[$containerKey]);
                while(list($tag, $option) = each($this->_container[$containerKey])){
                // check if set attributes for tag
                    if(is_array($option)) {
                        $startTag .= "<" . $tag;
                        if(''!=$attachFlag){
                            if(is_string($attachFlag) || is_int($attachFlag)){
                                $option['id'] = isset($option['id'])?$option['id']:$tag;
                                $option['id'] .= $attachFlag;
                            } else if(is_array($attachFlag)){
                                //var_dump($attachFlag);
                                foreach($attachFlag as $attachKey=>$attachValue){
                                    isset($option[$attachKey]) ? ($option[$attachKey].= ' '.$attachValue):($option[$attachKey]= $attachValue);
                                }
                            }
                        }
                        while(list($attrKey, $attrValue) = each($option)){
                            if (''==$attrValue) {
                                continue;
                            }
                            if ($attrKey=='id' && is_numeric($attrValue)) {
                                $attrValue = $tag . '_' . $attrValue;
                            }
                            $startTag .= " " . $attrKey . "='{$attrValue}'";
                        }
                        $startTag .= ">";
                    } else {
                        $startTag .= "<" . $option . ">";
                    }
                }
            } else if (is_string($this->_container[$containerKey]) && ''!=trim($this->_container[$containerKey])){
                $startTag .= "<" . $this->_container[$containerKey];

                if(''!=$attachFlag){
                    if(is_string($attachFlag)){
                        $startTag .= " id='" . $this->_container[$containerKey] . "_{$attachFlag}'";
                    } else if(is_array($attachFlag)){
                        foreach($attachFlag as $attachKey=>$attachValue){
                            if (''==$attachValue) {
                                continue;
                            }
                            if ($attachKey=='id' && is_numeric($attachValue)) {
                                $attachValue = $this->_container[$containerKey] . '_' . $attachValue;
                            }
                            $startTag .= ' ' . $attachKey . '="' . (string)$attachValue . '"';
                        }
                    }
                }
                $startTag .= ">";
            } else {
                $startTag = '';
            }
        } else {
        //not specify tag, use div
            $attachFlag = $attachFlag ? " id='div_$attachFlag'" : '';
            $startTag .= "<div{$attachFlag}'>";
        }
        $startTag .= "\n";

        return $startTag;
    }

    /**
     * Get container end tag
     *
     * @param string $containerKey The key to be used to find in $this->_container
     *
     * @return string
     */
    protected function getEndTag($containerKey)
    {
        $endTag = '';
        if(isset($this->_container[$containerKey])){
        //specify tag
            if(is_array($this->_container[$containerKey])){
            //more than one tag
                reset($this->_container[$containerKey]);
                while(list($tag, $option) = each($this->_container[$containerKey])){
                    if(is_array($option)) {
                        $endTag = "</" . $tag . ">" . $endTag;
                    } else {
                        $endTag = "</" . $option . ">" . $endTag;
                    }
                }

            } else if (is_string($this->_container[$containerKey])){

                $endTag .= '</' . $this->_container[$containerKey] . '>';
            }
        } else {
            $endTag .= "</div>";
        }
        $endTag .= "\n";

        return $endTag;
    }

    /**
     * Set container
     * @example setListContainer(array('itemTag'=>'div', 'listTag'=>'p'))
     * @example setListContainer(array('itemTag'=>array('div', 'ul'), 'listTag'=>'li'))
     * @example setListContainer(array('itemTag'=>array('div'=>array('class'=>'className'), 'ul'), 'listTag'=>'li'))
     *
     * @param array $container Container information
     *
     * @return object $this
     */
    public function setListContainer(array $container)
    {
        if(isset($container['itemTag'], $container['listTag'])){
            $this->_container = $container;
        }
        return $this;
    }

    /**
     * List items information in HTML, and items with menu
     *
     * @param array $headerList Information header
     * @param array $titleList  Information titles
     * @param array $itemList   Informations data
     * @param array $menuList   Menu information
     *
     * @return string
     */
    public function listItems(array $itemList, array $listKeys, array $headerList, array $menuList = array())
    {
        $html = '';

        //process items
        $listEndTag = $this->getEndTag('list');
        $menuEndTag = $this->getEndTag('menu');
        if (!empty($headerList)){
            $html = $this->getStartTag('header');
            reset($headerList);

            $attachNum = 0;
            foreach ($headerList as $header) {
                $listStartTag = $this->getStartTag('list', array('class'=>'LIST_'.$attachNum));
                    $html .= $listStartTag . $header . $listEndTag;
                $attachNum++;
            }unset($attachNum);

            //process menu
            reset($menuList);
            while(list($menuKey,$menuOption) = each($menuList)) {
                if (isset($menuOption['class'])) {
                    $menuClass = $menuOption['class'];
                    unset($menuOption['class']);
                } else {
                    $menuClass = 'MENU_' . $menuKey;
                }
                $menuStartTag = $this->getStartTag('menu', array('class'=>$menuClass));
                $html .= $menuStartTag;
                $html .= $menuKey;
                $html .= $menuEndTag;
            }

            $html .= $this->getEndTag('header');
        }

        $classNum = count($this->_loopLineClasses);
        reset($itemList);
        $itemIndex = 0;
        while(list(, $item) = each($itemList)){
            if ($classNum>1) {
                $classIndex = $itemIndex++%$classNum;
                $html .= $this->getStartTag('item', array('class'=>$this->_loopLineClasses[$classIndex], 'id'=>$this->_getFlagFromItem($item)));
            } else {
                $html .= $this->getStartTag('item', $this->_getFlagFromItem($item));
            }

            $attachNum = 0;
            if (is_int($this->_sortItems)) {
                $listStartTag = $this->getStartTag('list', array('class'=>'LIST_'.$attachNum++));
                $html .= $listStartTag . $this->_sortItems++ . $listEndTag;
            }
            foreach ($listKeys as $itemKey) {
                $listStartTag = $this->getStartTag('list', array('class'=>'LIST_'.$attachNum));
                if (is_string($itemKey) && isset($item[$itemKey])) {
                    $html .= $listStartTag . $item[$itemKey] . $listEndTag;
                } else if (is_array($itemKey) && isset($itemKey['key'], $itemKey['value'])) {
                    $valueList = array();
                    if (is_array($itemKey['value'])) {
                        foreach($itemKey['value'] as $valueKey) {
                            $valueKey = (string) $valueKey;
                            $_valueKey = substr($valueKey, 6);
                            $valueList[] = (substr($valueKey, 0, 6)=='$lang_' && isset($item[$_valueKey], $this->_myLang[$item[$_valueKey]])) ? $this->_myLang[$item[$_valueKey]] :
                                      (isset($item[$valueKey]) ? $item[$valueKey] : $valueKey);
                        }
                    } else {
                        $valueList[] = (string) $itemKey['value'];
                    }
                    $html .= $listStartTag . vsprintf($itemKey['key'], $valueList) . $listEndTag;
                } else {
                    $html .= $listStartTag . (string)$itemKey . $listEndTag;
                }
                $attachNum++;
            }unset($attachNum);

            //process menu
            reset($menuList);
            while(list($menuKey,$menuOption) = each($menuList)) {
                if (isset($menuOption['class'])) {
                    $menuClass = $menuOption['class'];
                    unset($menuOption['class']);
                } else {
                    $menuClass = 'MENU_' . $menuKey;
                }
                $menuStartTag = $this->getStartTag('menu', array('class'=>$menuClass));
                $html .= $menuStartTag;
                if(is_array($menuOption) && isset($menuOption['html'])){
                    if (is_array($menuOption['html'])) {
                        foreach($menuOption['html'] as $menuHTML) {
                            if(count($menuOption)>1){
                                $paramList = array();
                                foreach($menuOption as $key=>$optionKey){
                                    if('html'!=$key) {
                                        $optionKey = (string) $optionKey;
                                        $_optionKey = substr($optionKey, 6);
                                        $paramList[] = (substr($valueKey, 0, 6)=='$lang_' && isset($item[$_optionKey], $this->_myLang[$item[$_optionKey]])) ? $this->_myLang[$item[$_optionKey]] :
                                                  (isset($item[$optionKey]) ? $item[$optionKey] : $optionKey);
                                    }
                                }
                                $html .= vsprintf($menuHTML, $paramList);
                            } else {
                                $html .= $menuHTML;
                            }
                        }
                    } else if (is_string) {

                        if(count($menuOption)>1){
                            $paramList = array();
                            foreach($menuOption as $key=>$optionKey){
                                if('html'!=$key) {
                                    $optionKey = (string) $optionKey;
                                    $_optionKey = substr($optionKey, 6);
                                    $paramList[] = (substr($valueKey, 0, 6)=='$lang_' && isset($item[$_optionKey], $this->_myLang[$item[$_optionKey]])) ? $this->_myLang[$item[$_optionKey]] :
                                              (isset($item[$optionKey]) ? $item[$optionKey] : $optionKey);
                                }
                            }
                            $html .= vsprintf($menuOption['html'], $paramList);
                        } else {
                            $html .= $menuOption['html'];
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
                        $html .= "<a href='".vsprintf($menuOption['url'], $paramList) . "' title='". $menuKey . "'>". $menuKey . "</a>";
                    } else {
                        $html .= "<a href='{$menuOption['url']}' title='" . $menuKey . "'>". $menuKey . "</a>";
                    }
                } else if(is_string($menuOption)){
                    $html .= "<a href='{$menuOption}' title='" . $menuKey . "'>". $menuKey . "</a>";
                }
                $html .= $menuEndTag;
                $attachNum++;
            }
            $html .= $this->getEndTag('item');
        }
        $html = $this->getStartTag('pool') . $html;

        if ($this->_totalItemNumber) {
            if ($this->_enablePageGuide
                && $this->_currentPage
                && $this->_totalPage
                && $this->_pageLink) {
                $html .= $this->getStartTag('page')
                      . ($this->_currentPage>1 ? sprintf('<a href="'.$this->_pageLink.'">'.$this->lang['first_page'].'</a>', 1) : $this->lang['first_page'])
                      . ' ' . ($this->_currentPage>1 ? sprintf('<a href="'.$this->_pageLink.'">'.$this->lang['pre_page'].'</a>', $this->_currentPage-1) :$this->lang['pre_page'])
                      . ' ' . ($this->_currentPage<$this->_totalPage ? sprintf('<a href="'.$this->_pageLink.'">'.$this->lang['next_page'].'</a>', $this->_currentPage+1) :$this->lang['next_page'])
                      . ' ' . ($this->_currentPage>=$this->_totalPage ? $this->lang['last_page'] :sprintf('<a href="'.$this->_pageLink.'">'.$this->lang['last_page'].'</a>', $this->_totalPage) )
                      . ' ' . $this->lang['jump_to'] . '<input type="text" size=2 name="page">'
                         . $this->lang['page']
                      . $this->getEndTag('page');
            }

            if ($this->_enableSelectNumberForPage) {
                $html .= $this->getStartTag('number')
                      . $this->lang['number_per_page']
                      .   '<select name="number_per_page">'
                      .     '<option value=5>5</option>'
                      .     '<option value=10>10</option>'
                      .     '<option value=20>20</option>'
                      .     '<option value=30>30</option>'
                      .     '<option value=40>40</option>'
                      .     '<option value=50>50</option>'
                      .   '</select>'
                      . $this->getEndTag('number');
            }
        }

        $html .= $this->getEndTag('pool');

        return $html;
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

/*
$list = new MY_listItems;
echo $list->listItems(array(array('aaa',11, 'uid'=>'1', 'cid'=>11), array('bbbb',22, 'uid'=>'2', 'cid'=>33)),
                 array(0, '<input type=radio>', 1),
                 array('order', '<input type=radio>', 'order1'),
                 array('edit'=>array('url'=>'gg_%d_%d','id'=>'uid', 'cid'=>'cid'))
                 );
*/
/* EOF */
