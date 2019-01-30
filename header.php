<?
if($_SESSION['valid_token'] == "3"){
	echo "<a href=\"pass_logout.php\" title=\"µn¥X\" style=\"color:#ffffff;\">  <img src=\"images\\cover.png\" style='position: absolute; top: 0px; left: 0px; opacity: 0;'> </a>";
}
else{
	echo "<a href=\"pass_login.php\"  style=\"color:#ffffff;\"> <img src=\"images\\cover.png\" style='position: absolute; top: 0px; left: 0px; opacity: 0;'> </a>";
}

require_once("cover.php");
require_once("menuN.php");
require_once("logoN.php");
?>