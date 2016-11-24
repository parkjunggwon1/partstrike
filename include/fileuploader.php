
<?php
	include $_SERVER["DOCUMENT_ROOT"]."/include/class.upload.php";
	include $_SERVER["DOCUMENT_ROOT"]."/include/common.php";


	// $query_name : input 이름
	// $folder : 저장 폴더

	function uploadProc( $query_name, $dir_dest, $maxSize) {
		$handle = new Upload($_FILES[$query_name]);

		if ($handle->uploaded) {
			$handle->file_max_size = $maxSize;
			$handle->file_name_body_pre      = date("YmdHis")."_";
			$advicesize = $maxSize/1048576;
			if ($handle->file_src_size > $handle->file_max_size ) {
				die(popupMsgBack("( $advicesize MB )이상 파일업로드를 금지합니다."));
				exit;
			}

			$handle->Process($dir_dest);

			if ( $handle->file_dst_name == null ) {
				die(popupMsg("Required Parameter Missing. An error occured."));
				return false;
			}

			if ($handle->processed) {
				return $handle->file_dst_name;
			} else {
				popupMsg($handle->error);
				return false;
			}

			$handle-> Clean();

		} else {
			//popupMsg($handle->error);
			return false;
		}
	}
		
	function make_thumbnail($fileDic, $fileName, $w, $h, $q){
		
		if(!file_exists($fileDic."/thumb/".$fileName) && $fileName != ''){ //섬네일 파일이 없다면,
			
			//업로드 폴더가 없다면, 업로드 폴더 생성
			@mkdir("{$fileDic}/thumb", 0707);

			//업로드될 파일 명
			$thumb_filename = $fileDic."/thumb/".$fileName;


			//생성 기준 이미지
			$dest_file = $fileDic."/file/".$fileName;


			
			$main_img = @getimagesize($dest_file);

			if ($main_img[2] == 1){
				$src = imagecreatefromgif($dest_file);
			}elseif ($main_img[2] == 2){
				$src = imagecreatefromjpeg($dest_file);
			}elseif ($main_img[2] == 3){
				$src = imagecreatefrompng($dest_file);
			}else{
				continue;
			}


			if($main_img[0] >= $main_img[1]){
				$width = $w;
				$height = (  $w * $main_img[1] ) / $main_img[0];
				if($height >  $h ){
					$height =  $h ;
				}
			}elseif($main_img[0] < $main_img[1]){
				$height = $h;
				$width = ( $h * $main_img[0] ) / $main_img[1];
				if($width >  $w ){
					$width =  $w ;
				}
			}

			$dst = imagecreatetruecolor($width, $height);


			imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $main_img[0], $main_img[1]);
			imagejpeg($dst, "{$fileDic}/thumb/{$fileName}", $q);//기본 생성 퀄리티 = 100
			chmod("{$fileDic}/thumb/{$fileName}", 0606);
		}
	}
?>



