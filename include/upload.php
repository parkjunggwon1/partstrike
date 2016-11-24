<?php
if($_FILES["upload"]["size"]>0){
	//현재시간추출
	$current_time=time();
	$time_info=getdate($current_time);
	$date_filedir=$time_info["year"].$time_info["month"].$time_info["day"].$time_info["hour"].$time_info["minutes"].$time_info["seconds"];

	//오리지날 파일 이름 확장자
	$ext=substr(strrchr($_FILES["upload"]["name"],"."),1);
	$ext=strtolower($ext);
	$savefilename=$date_filedir."_editor_img".".".$ext;
	$uploadpath = "../upload/se/";


	if($ext=="jpg" or $ext=="gif" or $ext=="png"){
		if(move_uploaded_file($_FILES["upload"]["tmp_name"],$uploadpath."/".$savefilename)){
			$uploadfile = $savefilename;
			echo "<script type='text/javascript'>
					alert('업로드성공');
				</script>";
		}
	}else{
		echo "<script type='text/javascript'>
					alert('jpg,gif,png파일만 업로드 가능합니다');
				</script>";
	}
}else{
	exit;
}
echo "<script type='text/javascript'>
	window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']}, '/upload/se/$uploadfile');
</script>";
?>
