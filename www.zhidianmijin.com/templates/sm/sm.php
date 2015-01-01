<?if ($xing<>"") ?>
  <?include file='common/displayUserInfo.php'?>
  <?if isset($subIncludePage) ?>
      <?include file="$subIncludePage"?>
  <?/if?>
<? else  ?>
  <?include file="common/crackBorder.php" includePage='common/enterAllInfoForm.php' ?>
<?/if?>
