<?php
$smarty->assign('includePage', 'sm/sbwr.php');
$smarty->assign('subIncludePage', 'common/enterDateTimeNameSex.php');
if(isset($_POST['act']) && $_POST['act']=="ok") {
	  $sbnum=0;
	  $csrq=$_POST["y"] . $_POST["m"] . $_POST["d"];
	  for ($i = 0; $i<=strlen($csrq); $i++) {
       $sbnum=$sbnum + substr($csrq,$i,1);
   }

$sbnum2=0;
for ($i = 0; $i<=strlen($sbnum); $i++) { 
$sbnum2=$sbnum2 + substr($sbnum,$i,1) ;
}
$sbnum3=0;
for ($i = 0; $i<=strlen($sbnum2) ; $i++) {
$sbnum3=$sbnum3 + substr($sbnum2,$i,1) ;
}

$smarty->assign('name', $_POST["name"]);
$smarty->assign('yearsOld', $thisYear - $_POST["y"]);
$smarty->assign('y', $_POST["y"]);
$smarty->assign('m', $_POST["m"]);
$smarty->assign('d', $_POST["d"]);
$smarty->assign('hh', $_POST["hh"]);
$smarty->assign('fen', $_POST["fen"]);
$smarty->assign('sbnum3', $sbnum3);


$sql="select * from sbwr where num=?";
$result = $db->query($sql, array($sbnum3));
if($rs = $db->fetchArray($result)) {
$smarty->assign('intro', $rs["intro"]);
}
}
 ?>
