<?php
/**
* @version $Id: mamboxml.php,v 1.17 2004/09/26 09:19:49 saka Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Parameters handler
* @package Mambo_4.5.1
*/
class mosParameters {
	/** @var object */
	var $_params = null;
	/** @var string The raw params string */
	var $_raw = null;
	/** @var string Path to the xml setup file */
	var $_path = null;
	/** @var string The type of setup file */
	var $_type = null;
	/** @var object The xml params element */
	var $_xmlElem = null;
/**
* Constructor
* @param string The raw parms text
* @param string Path to the xml setup file
* @var string The type of setup file
*/
	function mosParameters( $text, $path='', $type='component' ) {
	    $this->_params = $this->parse( $text );
	    $this->_raw = $text;
	    $this->_path = $path;
	    $this->_type = $type;
	}
/**
* @param string The name of the param
* @param string The value of the parameter
* @return string The set value
*/
	function set( $key, $value='' ) {
		$this->_params->$key = $value;
		return $value;
	}
/**
* Sets a default value if not alreay assigned
* @param string The name of the param
* @param string The value of the parameter
* @return string The set value
*/
	function def( $key, $value='' ) {
	    return $this->set( $key, $this->get( $key, $value ) );
	}
/**
* @param string The name of the param
* @param mixed The default value if not found
* @return string
*/
	function get( $key, $default='' ) {
	    if (isset( $this->_params->$key )) {
	        return $this->_params->$key === '' ? $default : $this->_params->$key;
		} else {
		    return $default;
		}
	}
/**
* Parse an .ini string, based on phpDocumentor phpDocumentor_parse_ini_file function
* @param mixed The ini string or array of lines
* @param boolean add an associative index for each section [in brackets]
* @return object
*/
	function parse( $txt, $process_sections = false ) {
	    if (is_string( $txt )) {
			$lines = explode( "\n", $txt );
		} else if (is_array( $txt )) {
		    $lines = $txt;
		} else {
		    $lines = array();
		}
		$obj = new stdClass();

	    $sec_name = '';
	    $unparsed = 0;
	    if (!$lines) {
			return $obj;
		}
	    foreach ($lines as $line) {
	        // ignore comments
	        if ($line && $line[0] == ';') {
				continue;
			}
	        $line = trim( $line );

	        if ($line == '') {
	            continue;
	        }
	        if ($line && $line[0] == '[' && $line[strlen($line) - 1] == ']') {
	            $sec_name = substr( $line, 1, strlen($line) - 2 );
				if ($process_sections) {
	            	$obj->$sec_name = new stdClass();
	            }
	        } else {
	            if ($pos = strpos( $line, '=' )) {
	                $property = trim( substr( $line, 0, $pos ) );

	                if (substr($property, 0, 1) == '"' && substr($property, -1) == '"') {
	            		$property = stripcslashes(substr($property,1,count($property) - 2));
	                }
	                $value = trim( substr( $line, $pos + 1 ) );
	                if ($value == 'false') {
						$value = false;
					}
	                if ($value == 'true') {
						$value = true;
					}
	                if (substr( $value, 0, 1 ) == '"' && substr( $value, -1 ) == '"') {
	                    $value = stripcslashes( substr( $value, 1, count( $value ) - 2 ) );
	                }

	                if ($process_sections) {
	                    if ($sec_name != '') {
      						$obj->$sec_name->$property = $value;
      					} else {
        					$obj->$property = $value;
        				}
	                } else {
						$obj->$property = $value;
	                }
	            } else {
	                if ($line && trim($line[0]) == ';') {
						continue;
					}
	                if ($process_sections) {
	                    $property = '__invalid' . $unparsed++ . '__';
		                if ($process_sections) {
		                    if ($sec_name != '') {
	      						$obj->$sec_name->$property = trim($line);
	      					} else {
	        					$obj->$property = trim($line);
	        				}
		                } else {
							$obj->$property = trim($line);
		                }
	                }
	            }
	        }
	    }
	    return $obj;
	}
/**
* @param string The name of the default text area is a setup file is not found
* @return string HTML
*/
	function render( $name='params' ) {
		global $mosConfig_absolute_path;

	    if ($this->_path) {
	        if (!is_object( $this->_xmlElem )) {
				require_once( $mosConfig_absolute_path . '/includes/domit/xml_domit_lite_include.php' );

				$xmlDoc =& new DOMIT_Lite_Document();
				$xmlDoc->resolveErrors( true );
				if ($xmlDoc->loadXML( $this->_path, false, true )) {
					$element =& $xmlDoc->documentElement;

					if ($element->getTagName() == 'mosinstall' && $element->getAttribute( "type" ) == $this->_type) {
						if ($element = &$xmlDoc->getElementsByPath( 'params', 1 )) {
							$this->_xmlElem =& $element;
						}
					}
				}
			}
		}

	    if (is_object( $this->_xmlElem )) {
			$html = array();
			$html[] = '<table class="paramlist">';

			$element =& $this->_xmlElem;

			if ($description = $element->getAttribute( 'description' )) {
			    // add the params description to the display
			    $html[] = '<tr><td colspan="3">' . $description . '</td></tr>';
			}

			//$params = mosParseParams( $row->params );
			$this->_methods = get_class_methods( 'mosParameters' );

			foreach ($element->childNodes as $param) {
			    $result = $this->renderParam( $param );
				$html[] = '<tr>';

				$html[] = '<td width="35%" align="right" valign="top">' . $result[0] . '</td>';
				$html[] = '<td>' . $result[1] . '</td>';
				$html[] = '<td width="10%" align="left" valign="top">' . $result[2] . "</td>";

				$html[] = '</tr>';
			}
			$html[] = '</table>';

			if (count( $element->childNodes ) < 1) {
				$html[] = "<tr><td colspan=\"2\"><i>" . _NO_PARAMS . "</i></td></tr>";
			}
			return implode( "\n", $html );
		} else {
			return "<textarea name=\"$name\" cols=\"40\" rows=\"10\" class=\"text_area\">$this->_raw</textarea>";
		}
	}
/**
* @param object A param tag node
* @return array Any array of the label, the form element and the tooltip
*/
	function renderParam( &$param ) {
	    $result = array();

		$name = $param->getAttribute( 'name' );
		$label = $param->getAttribute( 'label' );

		$value = $this->get( $name, $param->getAttribute( 'default' ) );
		$description = $param->getAttribute( 'description' );

		$result[0] = $label ? $label : $name;
		if ( $result[0] == '@spacer' ) {
			$result[0] = '<hr/>';
		} else if ( $result[0] ) {
			$result[0] .= ':';
		}

		$type = $param->getAttribute( 'type' );

		if (in_array( '_form_' . $type, $this->_methods )) {
			$result[1] = call_user_func( array( 'mosParameters','_form_' . $type), $name, $value, $param );
		} else {
		    $result[1] = _HANDLER . ' = ' . $type;
		}

		if ( $description ) {
			$result[2] = mosToolTip( $description, $name );
		} else {
			$result[2] = '';
		}

		return $result;
	}
/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_text( $name, $value, &$node ) {
		$size = $node->getAttribute( 'size' );
		return "<input type=\"text\" name=\"params[$name]\" value=\"$value\" class=\"text_area\" size=\"$size\"/>";
	}
/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_list( $name, $value, &$node ) {
		$size = $node->getAttribute( 'size' );

		$options = array();
		foreach ($node->childNodes as $option) {
			$val = $option->getAttribute( 'value' );
			$text = $option->gettext();
			$options[] = mosHTML::makeOption( $val, $text );
		}
		return mosHTML::selectList( $options, "params[$name]", "class=\"inputbox\"", 'value', 'text', $value );
	}
/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_radio( $name, $value, &$node ) {
		$options = array();
		foreach ($node->childNodes as $option) {
			$val = $option->getAttribute( 'value' );
			$text = $option->gettext();
			$options[] = mosHTML::makeOption( $val, $text, true );
		}
		return mosHTML::radioList( $options, "params[$name]", '', $value );
	}
/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_mos_section( $name, $value, &$node ) {
		global $database;

		$query = "SELECT id AS value, title AS text"
		. "\n FROM #__sections"
		. "\n WHERE published='1' AND scope='content'"
		. "\n ORDER BY title"
		;
		$database->setQuery( $query );
		$options = $database->loadObjectList();
		array_unshift( $options, mosHTML::makeOption( '0', '- Select Content Section -' ) );
		return mosHTML::selectList( $options, "params[$name]", "class=\"inputbox\"", 'value', 'text', $value );
	}
/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_mos_category( $name, $value, &$node ) {
		global $database;

	    $database->setQuery( "SELECT c.id AS value, CONCAT_WS( '/',s.title, c.title ) AS text"
			. "\n FROM #__categories AS c"
			. "\n LEFT JOIN #__sections AS s ON s.id=c.section"
			. "\n WHERE c.published='1' AND s.scope='content'"
			. "\n ORDER BY c.title"
		);
		$options = $database->loadObjectList();
		array_unshift( $options, mosHTML::makeOption( '0', '- Select Content Category -' ) );
		return mosHTML::selectList( $options, "params[$name]", "class=\"inputbox\"", 'value', 'text', $value );
	}
/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_mos_menu( $name, $value, &$node ) {
		global $database;

	    $database->setQuery( "SELECT m.params"
			. "\n FROM #__modules AS m"
			. "\n WHERE m.module = 'mod_mainmenu'"
		);
		$menus = $database->loadObjectList();
		$total = count( $menus );
		foreach( $menus as $menu ) {
			$params = mosParameters::parse( $menu->params );
			$menutype = @$params->menutype;
			$options[] = mosHTML::makeOption( $menutype, $menutype );
		}
		array_unshift( $options, mosHTML::makeOption( '', '- Select Menu -' ) );
		return mosHTML::selectList( $options, "params[$name]", "class=\"inputbox\"", 'value', 'text', $value );
	}
/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_imagelist( $name, $value, &$node ) {
		global $mosConfig_absolute_path;

		// path to images directory
		$path = $mosConfig_absolute_path . $node->getAttribute( 'directory' );
		$files = mosReadDirectory( $path, '\.png$|\.gif$|\.jpg$|\.bmp$|\.ico$' );

		$options = array();
		foreach ($files as $file) {
			$options[] = mosHTML::makeOption( $file, $file );
		}
		if ( !$node->getAttribute( 'hide_none' ) ) {
			array_unshift( $options, mosHTML::makeOption( '-1', '- Do not use an image -' ) );
		}
		if ( !$node->getAttribute( 'hide_default' ) ) {
			array_unshift( $options, mosHTML::makeOption( '', '- Use Default image -' ) );
		}
		return mosHTML::selectList( $options, "params[$name]", "class=\"inputbox\"", 'value', 'text', $value );
	}

/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_textarea( $name, $value, &$node ) {
		$rows = $node->getAttribute( 'rows' );
		$cols = $node->getAttribute( 'cols' );
		return "<textarea name=\"params[$name]\" cols=\"$cols\" rows=\"$rows\" class=\"text_area\">$value</textarea>";
	}

/**
* @var string The name of the form element
* @var string The value of the element
* @var object The xml element for the parameter
* @return string The html for the element
*/
	function _form_spacer( $name, $value, &$node ) {
		if ( $value ) {
			return $value;
		} else {
			return '<hr />';
		}
	}
}

/**
* @param string
* @return string
*/
function mosParseParams( $txt ) {
	return mosParameters::parse( $txt );
}

function walkNodesAndReturnMosNodeList(&$nodeList, &$contextNode) {
	//STEP 1: DO SOME ERROR CHECKING (this can be omitted if you want to optimize, but isn't as safe)
	//ensure that node is not null
	if (!isset( $contextNode )) {
		return;
	}

	//ensure that node is a DOMIT element
	if (strtolower( get_class( $contextNode ) ) != 'domit_element') {
		//if contextNode is a DOMIT Document, grab the documentElement
		if (strtolower( get_class( $contextNode ) ) == 'domit_document') {
			$contextNode =& $contextNode->documentElement;
			if (!isset( $contextNode )) {
				return;
			}
		} else {
			return;
		}
	}

	//STEP 2: EVALUATE THE CONTEXT NODE BASED ON SOME CRITERIA
	//determine whether the context node should be added to the master nodeList
	if ((strlen( $contextNode->nodeName ) > 3) && (substr( $contextNode->nodeName, 0, 4 ) == "mos:")) {
		$nodeList->appendNode($contextNode);
	}

	//STEP 3: ITERATE THROUGH THE CONTEXT NODE CHILDREN AND
	//RECURSIVELY CALL THIS FUNCTION WITH THE CHILD AS THE CONTEXT NODE
	$total = $contextNode->childCount;

	for ($i = 0; $i < $total; $i++) {
		walkNodesAndReturnMosNodeList($nodeList, $contextNode->childNodes[$i]);
	}
} //walkNodesAndReturnMosNodeList

/*
	You'd call the function like this:

	$myNodeList =& new DOMIT_NodeList();
	walkNodesAndReturnMosNodeList($myNodeList, $someXMLDoc);
*/

class mosEmpty {
	function def( $key, $value='' ) {
	    return 1;
	}
	function get( $key, $default='' ) {
	    return 1;
	}
}
?>
