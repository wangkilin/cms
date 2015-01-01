<?php
abstract class My_Abstract
{
    /**
     *@boolean    set true, class will debug
     */
    public $debug = false;

    /**
     *@resouce    database handler
     */
    protected $_db;

    /**
     *@string    class error information string
     */
    protected $_errorStr;

    /*
     * @var int The DB selection offset
     */
    protected $_limitOffset = 0;

    /*
     * @var int The DB selection row count limit
     */
    protected $_limitRowCount = 25;

    /*
     * @var array The property list which allowed to be changed
     */
    protected $_setList = array('limitOffset', 'limitRowCount');

    public function __construct($className)
    {
         global $My_Lang;
         My_Kernel::loadLanguage('class', $className);//load class language
    }


    /**
     * Constructor
     * @param object $db The system DB handler
     */
    public function General($db)
    {
         if(is_object($db)) {
             $this->_db = $db;
         }
    }

    /**
     * set properties
     * @param array $options The property association list
     * @return object $this
     */
    public function setOptions($options)
    {
        foreach((array)$options as $key=>$value){
            if(in_array($key, $this->_setList)) {
                $key = '_' . $key;
                $this->$key = $value;
            }
        }

        return $this;
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
    protected function & getListBySql($sql, $param, $bind=array())
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
     * get total number from the input SQL and parameters
     *
     * @param string $sql The sql to be executed
     * @param array  $paramsList The parameters list
     *
     * @return int Total number
     */
    protected function count ($sql, $paramsList=array())
    {
        $return = 0;

        if (count((array)$paramsList)) {
            $this->_db->query($sql, $paramsList);
        } else {
            $this->_db->query($sql);
        }

        if ($row = $this->_db->fetchRow()) {
            $return = (int)$row[0];
        }

        return $return;
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

}