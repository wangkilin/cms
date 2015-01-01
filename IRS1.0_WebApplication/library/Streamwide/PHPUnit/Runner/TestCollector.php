<?php
/**
 * StreamWIDE PHPUnit
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: TestCollector.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Runner/Util.php';

/**
 * Parser for tests folders.
 *
 * @package    Streamwide_PHPUnit
 * @subpackage TestRunner
 */
class Streamwide_PHPUnit_Runner_TestCollector
{
    /**
     * folder to parse
     *
     * @var string
     */
    private $_rootFolder = null;

    /**
     * root folder id
     *
     * @var string
     */
    private $_rootFolderId = null;

    /**
     * folder id prefix
     *
     * @var string
     */
    private $_folderIdPrefix = null;

    /**
     * suite id prefix
     *
     * @var string
     */
    private $_suiteIdPrefix = null;

    /**
     * suite file suffix
     *
     * @var string
     */
    private $_testSuiteSuffix = null;
    
    /**
     * test case prefix
     *
     * @var string
     */
    private $_testCasePrefix = null;

    /**
     * excluded folders patterns for parsing
     *
     * @var array
     */
    private $_exclude = array();

    /**
     * Folders tree.
     * Format:
     * array(string folderId => array ('path'       => string FolderPath
     *                                 'subfolders' => array(string folderId)
     *                                 'suites'     => array(string suiteId)
     *                                )
     *      )
     *
     * @var array
     */
    private $_folders = array();

    /**
     * Suites and tests array.
     * Format:
     * array(string suiteId => array('path'  => string filePath,
     *                               'tests' => array(string testName)
     *                              )
     *      )
     *
     * @var array
     */
    private $_suites = array();

    /**
     * Array of links from paths to suites ids.
     * Format:
     * array(string suitePath => string suiteId)
     *
     * @var array
     */
    private $_suitePathToId = array();

    /**
     * Constructor for the FolderParser class.
     *
     * @param string $folder          folder to parse for tests
     * @param array  $exclude         (optinal) excluded folders patterns for parsing
     * @param string $testSuiteSuffix (optional) test file suffix
     * @param string $testCasePrefix  (optional) test case prefix
     * @param string $folderIdPrefix  (optional) folder id prefix
     * @param string $suiteIdPrefix   (optional) suite id prefix
     */
    public function __construct($folder, $exclude = array(), $testSuiteSuffix = 'Test.php',
                                $testCasePrefix = 'test', $folderIdPrefix = 'dir', $suiteIdPrefix = 'suite')
    {
        $this->_rootFolder      = $folder;
        $this->_exclude         = $exclude;
        $this->_testSuiteSuffix = $testSuiteSuffix;
        $this->_testCasePrefix  = $testCasePrefix;
        $this->_folderIdPrefix  = $folderIdPrefix;
        $this->_suiteIdPrefix   = $suiteIdPrefix;

        $this->_rootFolderId = $this->_parseFolder($this->_rootFolder);
    }

    /**
     * Returns root folder id.
     * If there are no tests found it returns 0.
     *
     * @return string root folder id
     */
    public function getRootFolderId()
    {
        return $this->_rootFolderId;
    }

    /**
     * Returns information about a folder id.
     *
     * @param string folder id
     * @return array suite information
     */
    public function getFolder($folderId)
    {
        return $this->_folders[$folderId];
    }

    /**
     * Returns the folder path.
     *
     * @param int folder id
     * @return string folder path
     */
    public function getFolderPath($folderId)
    {
        return $this->_folders[$folderId]['path'];
    }

    /**
     * Returns information about a suite id.
     *
     * @param int suite id
     * @return  array suite information
     */
    public function getSuite($suiteId)
    {
        $suite = $this->_suites[$suiteId];

        // add the name of the suite to the result array
        $suite['name'] = str_replace($this->_testSuiteSuffix, '', basename($suite['path']));

        return $suite;
    }

    /**
     * Returns the suite id for a given suite path.
     *
     * @param string suite path
     * @return string suite id or 0 if there is no suite with that path
     */
    public function getSuiteId($suitePath)
    {
        return $this->_suitePathToId[$suitePath];
    }

    /**
     * Returns the suite tests array.
     *
     * @param int suite id
     * @return  array suite tests
     */
    public function getSuiteTests($suiteId)
    {
        return $this->_suites[$suiteId]['tests'];
    }

    /**
     * Returns the suite path.
     *
     * @param int suite id
     * @return string suite path
     */
    public function getSuitePath($suiteId)
    {
        return $this->_suites[$suiteId]['path'];
    }

    /**
     * Returns next available id for folders or suites.
     *
     * @param boolean $folders folders or suites (0 for suites and 1 for folders)
     * @return string folder or suite id
     */
    private function _getNextId($folders)
    {
        // set array and prefix
        $array  = $folders ? $this->_folders : $this->_suites;
        $prefix = $folders ? $this->_folderIdPrefix : $this->_suiteIdPrefix;
        // get last key
        end($array);
        $id = key($array);

        if(is_null($id)) {
            $newId = $prefix . '1';
        } else {
            // extract number component of id
            $n = substr($id, strlen($prefix));
            // add folder prefix
            $newId = $prefix . ++$n;
        }
        return $newId;
    }

    /**
     * Returns next available folder id.
     *
     * @return string folder id
     */
    private function _getNextFolderId()
    {
        return $this->_getNextId(true);
    }

    /**
     * Returns next available suite id.
     *
     * @return string suite id
     */
    private function _getNextSuiteId()
    {
        return $this->_getNextId(false);
    }

    /**
     * Parses recursively a folder to search for tests.
     * On the way it creates $this->_suites and $this->_folders.
     *
     * @param string $dir folder path
     * @return int folder id or 0 if there are no subfolders with suites
     */
    private function _parseFolder($path)
    {
        $items = scandir($path);

        $folderId = $this->_getNextFolderId();
        $folder = array('path' => $path);
        // use reference because we might update suites and subfolders components later on
        $this->_folders[$folderId] = &$folder;
        $suites = array();
        $subfolders = array();

        // parse the folders contentes
        foreach ($items as $item) {
            $itemPath = $path . '/' . $item;
            // if is dir and is not hidden nor . or ..
            if ((is_dir($itemPath)) && (substr($item, 0, 1) !== '.')) {
                // filter the folder through exludes
                $descend = true;
                foreach($this->_exclude as $pattern) {
                    if(preg_match($pattern, $item)) {
                        $descend = false;
                        break;
                    }
                }
                // descend recursively into folder if not excluded
                if($descend) {
                    $subfolderId = $this->_parseFolder($itemPath);
                    if($subfolderId) {
                        $subfolders[] = $subfolderId;
                    }
                }
            }
            // if is file and ends with test suffix
            if (is_file($itemPath) && (substr($itemPath, -(strlen($this->_testSuiteSuffix))) == $this->_testSuiteSuffix)) {
                $tests = Streamwide_PHPUnit_Runner_Util::getTests($itemPath);
                if ($tests) {
                    $suiteId = $this->_getNextSuiteId();
                    $suite = array('path'  => $itemPath,
                                   'tests' => $tests
                    );
                    $this->_suites[$suiteId] = $suite;
                    $this->_suitePathToId[$itemPath] = $suiteId;
                    $suites[] = $suiteId;
                }
            }
        }

        // update the suites and subfolders components
        if(count($suites)) {
            $folder['suites'] = $suites;
        }
        if(count($subfolders)) {
            $folder['subfolders'] = $subfolders;
        }

        if(isset($folder['suites']) || isset($folder['subfolders'])) {
            return $folderId;
        } else {
            unset($this->_folders[$folderId]);
            return 0;
        }
    }
}

/*EOF*/