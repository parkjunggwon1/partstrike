<?php
include "./_inc/_local_setting.php";
include "./_inc/_injection.php";
include "./_inc/_db_class.php";
include "./_inc/_functions.php";

$DB = new DB();


$qry_items="select goods_name from ".$config[table];
$res_items= $DB->query($qry_items);

$items = array();

while($items_row = $DB->fetch_array($res_items)){
	array_push($items,urlencode($items_row[goods_name]));
}

?>
<script>
var goods = <?=urldecode(json_encode($items));?>;
</script>