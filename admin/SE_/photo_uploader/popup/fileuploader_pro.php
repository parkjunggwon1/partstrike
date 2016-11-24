<?php

	/** 파일 업로드 ******************************************/
	include('fileuploader.php');
	$query_name = "update_image"; //input 파라메터 이름

	if($_FILES[$query_name]) {
		$maxSize = '16777216'; //500 KB, 파일 용량 제한
		$dir_dest = $imagepath; //파일 저장 폴더 지정
		$filename1 = uploadProc( $query_name, $dir_dest, $maxSize);
	}
	/*******************************************************/

	$size = GetImageSize($update_image); 
	$width = $size[0]; //입력받은 파일의 가로크기를 구합니다.
	$height = $size[1]; //입력받은 파일의 세로크기를 구합니다.
	 
	 echo "<script language=javascript>
				opener.parent.insertIMG('".$id."','".$filename1."','".$width."','".$height."');
				self.close();
			</script>";
?>
