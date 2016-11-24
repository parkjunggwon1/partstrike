<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

$file_idx = $_REQUEST['file_idx'];
$temp_file = $_REQUEST['temp_file'];
$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];
$path = $_REQUEST['path'];
$num = $_REQUEST['num'];
$temp = $_REQUEST['temp'];


$file_idx = replace_in($file_idx);
$file = replace_in($temp_file);
$mode = replace_in($mode);
$idx = replace_in($idx);
$path = replace_in($path);
$num = replace_in($num);	//포토게시판경우 몇번째 이미지인지 가져온다
$temp = replace_in($temp);	//상품일경우 file인지 color인지 구분값(임시이다)

If (strtoupper(substr($mode,0,2))=="AA"){
	$sql = "update member set picture='' where mem_idx=$file_idx";
	echo $sql;
	
	if(  $mode == "AA012" or  $mode == "AA011" ){
	  $gopage = "/admin/board5/board_write.php";
	}else if(  $mode == "AA010"    ){
		$gopage = "/admin/board3/board_write.php";	
	}else{
	  $gopage = "/admin/board/board_write.php";	
	}
	
	
}
echo substr($mode,0,2);
If ($file_idx) {
	
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	//파일삭제
	if($file!=""){
		//echo "<br> pass2";
		
		//echo "$path"."$file";
		
		$file_added = "$path"."$file";
		
		if(file_exists("$path.$file")){
			echo "<br> pass3 1";
			unlink("$path.$file");
		}
		
		if(file_exists(  $file_added  )){
			echo "<br> pass3 2";
			unlink( $file_added );
		}
		
		//echo "<br>::ee::".is_file(  "$file_added"  );
		//echo "<br>::gg:1:".is_file(  "/www/upload/file/"."$file"  );
		//echo "<br>::gg:2:".is_file(  "/index.php"  );
		//echo "<br>::gg:2:".is_file(  "/home/hosting_users/evictor32/www/index.php"  );
		//echo "<br>::gg:a:"."/www/upload/file/"."$file"    ;
		
		if(is_file(  "/home/hosting_users/eroom3100/www/upload/file/"."$file" )){
			//echo "<br> pass3  3";
			unlink(  "/home/hosting_users/eroom3100/www/upload/file/"."$file" );
		}		
		
	}
	
	?>
	<script type="text/javascript">		
		
		//alert(''+' <?=$path?> ...  <?=$file?> ' );
		
		parent.location.href = "<?=$gopage?>?idx=<?=$idx?>&mode=<?=$mode?>&typ=edit"
	</script>
<? } ?>
