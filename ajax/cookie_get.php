<?
session_start();
if ($_GET['menu']=="M")
{
	$_SESSION["menu"] = "side_order";
	echo $_SESSION["menu"];
}
else
{
	echo $_SESSION["menu"];
}
exit;

?>