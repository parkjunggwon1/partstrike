<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
if ($typ == "edit"){
	 $ary_T_popul_idx = $_POST[T_popul_idx];
	 $ary_T_partno = $_POST[T_partno];
	 $ary_T_price = $_POST[T_price];
	 $ary_M_popul_idx = $_POST[M_popul_idx];
	 $ary_M_partno = $_POST[M_partno];
	 $ary_M_price = $_POST[M_price];
 	 
	 
	 for ($j = 0 ; $j<10; $j++){
			$sql = "update populpart set 
				partno		= '".$ary_T_partno[$j]."'
				,price	= '".$ary_T_price[$j]."'
				where populpart_idx = '".$ary_T_popul_idx[$j]."'";
			//	echo $sql."<BR>";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	 }

	 for ($j = 0 ; $j<10; $j++){
			$sql = "update populpart set 
				partno		= '".$ary_M_partno[$j]."'
				,price	= '".$ary_M_price[$j]."'
				where populpart_idx = '".$ary_M_popul_idx[$j]."'";
			//	echo $sql."<BR>";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	 }


	if($result){
		Page_Msg_Need("저장되었습니다.");
	}
}
?>
