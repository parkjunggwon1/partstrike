<?
session_start();

if ($_GET['menu']=="M")
{
	$_SESSION["menu_side"] = "side_order";
	echo $_SESSION["menu_side"];
}

else
{
	echo $_SESSION["menu"];
}
exit;

?>