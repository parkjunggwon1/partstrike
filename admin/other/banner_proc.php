<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$dir_dest = "../..".$file_path; //파일 저장 폴더 지정

if ($typ=="write"){
	/** 파일 업로드 ******************************************/
	For ($i=1;$i<=5;$i++){
		$query_name = "file".$i; //input 파라메터 이름
		
		if($_FILES[$query_name]) {
			$FILE_1			= RequestFile("file".$i);
			
			$FILE_1_size	= $FILE_1[size];
			$maxSize = '5242880'; //5mb, 파일 용량 제한
			${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
		}
	}
	/*******************************************************/

	$sql = " insert into banner set 
				bn_gubun='$mode'
				, bn_title='$bn_title'
				, bn_file1='$filename1'
				, bn_url1='$bn_url1'
				, bn_file2='$filename2'
				, bn_url2='$bn_url2'
				, bn_file3='$filename3'
				, bn_url3='$bn_url3'
				, bn_file4='$filename4'
				, bn_url4='$bn_url4'
				, bn_file5='$filename5'
				, bn_url5='$bn_url5'		
		";
		echo  $sql;

	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Url("/admin/other/banner_write.php?mode=$mode");
	}

}
if ($typ == "edit"){
	/** 파일 업로드 ******************************************/
	For ($i=1;$i<=5;$i++){
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
	/*******************************************************/

	$sql="
		UPDATE
			banner
		SET
			bn_title='$bn_title'
			,bn_file1='$filename1'
			, bn_url1='$bn_url1'
			, bn_file2='$filename2'
			, bn_url2='$bn_url2'
			, bn_file3='$filename3'
			, bn_url3='$bn_url3'
			, bn_file4='$filename4'
			, bn_url4='$bn_url4'
			, bn_file5='$filename5'
			, bn_url5='$bn_url5'
		WHERE
			bn_gubun='$mode'
	";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Url("/admin/other/banner_write.php?mode=$mode");	
	}
}


?>
