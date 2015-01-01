<?php
/**
* @version $Id: mod_latest.php,v 1.1 2004/09/27 08:28:31 dappa Exp $
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$query = "SELECT a.id, a.sectionid, a.title, a.created, u.name"
. "\n FROM #__content AS a"
. "\n LEFT JOIN #__users AS u ON u.id=a.created_by"
. "\n WHERE a.state <> '-2'"
. "\n ORDER BY created DESC"
. "\n LIMIT 10"
;
$database->setQuery( $query );
$rows = $database->loadObjectList();
?>

<table class="adminlist">
<tr>
    <th colspan="3">
	<?php echo $adminLanguage->A_LATEST_ADDED;?>
	</th>
</tr>
<?php
foreach ($rows as $row) { 
	?>
	<tr>
		<?php
		if ($row->sectionid != "0") {
			?>
			<td>
			<a href="#edit" onClick="submitcpform('<?php echo $row->sectionid;?>', '<?php echo $row->id;?>')">
			<?php echo $row->title;?>
			</a>
			</td>
			<?php
		} else {
			?>
			<td>
			<?php echo $row->title;?>
			</td>
			<?php
		}
		?>
		<td>
		<?php echo $row->created;?>
		</td>
		<td>
		<?php echo $row->name;?>
		</td>
	</tr>
	<?php
}
?>
</table>