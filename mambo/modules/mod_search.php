<?php
/**
* @version $Id: mod_search.php,v 1.10 2004/09/20 18:07:56 stingrey Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$width 			= intval( $params->get( 'width', 20 ) );
$text 			= $params->get( 'text', _SEARCH_BOX );
$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );
?>

<form action="<?php echo sefRelToAbs("index.php"); ?>" method="post">
<div align="left" class="search<?php echo $moduleclass_sfx; ?>">
	<input alt="search" class="inputbox" type="text" name="searchword" size="<?php echo $width; ?>" value="<?php echo $text; ?>"  onblur="if(this.value=='') this.value='<?php echo $text; ?>';" onfocus="if(this.value=='<?php echo $text; ?>') this.value='';" />
	<input type="hidden" name="option" value="search" />
</div>
</form>