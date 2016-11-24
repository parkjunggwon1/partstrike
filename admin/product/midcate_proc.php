<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
if ($typ=="cate1"){
	for($i=0; $i<$s_count; $i++){
		$param=$s[$i];
		$ary_param = explode(":", $param);
		$product_type_idx = $ary_param[0];
		$dtl_code		   = $ary_param[1];
		$gubun			   = $ary_param[2];
		$product_type_name = $ary_param[3];
		$sort = $i+1;

		if ($product_type_idx >0){
			$sql="
				UPDATE
					product_type
				SET
					sort=$sort		
				WHERE
					product_type_idx='$product_type_idx'
			";
		}else{
				$sql="
					INSERT INTO product_type
						(gubun									
						, dtl_code
						, product_type_name
						, sort
						, reg_date
						)
					VALUES
						('$gubun'						
						,'$dtl_code'
						,'$product_type_name'
						,'$sort'
						,'$log_date'
						)
					";

		}
		//echo $sql;
		$result = mysql_query($sql,$conn);
	}			

	if ($mid_ty != "Y") $mid_ty = "N";
	$sql = "update board_create set headyn = '$mid_ty', headtext = '$mid_title' , secret = '$mid_secret'
			where gubun = '$gubun'"; 
		//	echo $sql;
	$result = mysql_query($sql,$conn);

	if($result){
		Page_Msg_Url("정상적으로 수정되었습니다.","/admin/product/cate1.php?gubun=$gubun");
	}	
}
if ($typ=="cate2"){
	include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
	$dir_dest = "../..".$file_path; //파일 저장 폴더 지정

	For ($i=0;$i<=5;$i++){
		if (${"file".$i}){
			$query_name = "file".$i; //input 파라메터 이름
			
			if($_FILES[$query_name]) {
				$FILE_1			= RequestFile("file".$i);
				$FILE_1_size	= $FILE_1[size];
				$maxSize = '5242880'; //5mb, 파일 용량 제한
				${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
				//echo $filename1;
			}

			if(${"file_o".$i}){
				$old_file=${"file_o".$i};
				if(file_exists("$file_path/$old_file")){
					unlink("$file_path/$old_file");
				}
			}
		}else{
			${"filename".$i} = ${"file_o".$i};
		}
	}
	$product_content = replace_con_in($product_content);
	$sql="
			UPDATE
				product_type
			SET
				product_type_name='$product_type_name'			
				,product_content   ='$product_content'				
				,filename0='$filename0'
			WHERE
				product_type_idx=$product_type_idx
		";
		//echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			Page_Parent_Msg_Url("정상적으로 수정되었습니다.","cate.php?gubun=$gubun");	
		}

}
?>