<?
//include  $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>

<?
$items = array();
$result_a =QRY_LIST("agency","all",$page," and agency_idx='0' "," idx desc");
while($row_a = mysql_fetch_array($result_a)){
	array_push($items,urlencode($row_a[agency_name]));
}
?>
<script>
var goods = "<?=urldecode(json_encode($items));?>";
</script>