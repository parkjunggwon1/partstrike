
<?php
	include $_SERVER["DOCUMENT_ROOT"]."/include/class.upload.php";
	include $_SERVER["DOCUMENT_ROOT"]."/include/common.php";
	include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.image.php";

	// $query_name : input 이름
	// $folder : 저장 폴더

	function uploadProc( $query_name, $dir_dest, $maxSize) {
		
		//박정권 20161227 이미지 업로드 변경 -- class.image.php
		$today = date("Ymdhis");
		$dirRoot = $_SERVER["DOCUMENT_ROOT"];		

		$ext = explode(".", strtolower($_FILES[$query_name]['name'])); 

		$uploaddir = $dirRoot."/upload/file"; 
		$uploadfile = $uploaddir ."/".$today."_".$_SESSION["MEM_IDX"].".".$ext[1]; //제품이미지1

		if($_FILES[$query_name]['tmp_name'] != "")
		{
			if(($_FILES[$query_name]['error'] > 0) || ($_FILES[$query_name]['size'] <= 0)){ 
				 // echo "파일 업로드에 실패하였습니다."; 
			 } else { 
				  // HTTP post로 전송된 것인지 체크합니다. 
				  if(!is_uploaded_file($_FILES[$query_name]['tmp_name'])) { 
						//echo "HTTP로 전송된 파일이 아닙니다."; 
				  } else { 
						// move_uploaded_file은 임시 저장되어 있는 파일을 ./uploads 디렉토리로 이동합니다. 
						if (move_uploaded_file($_FILES[$query_name]['tmp_name'], $uploadfile)) { 
						//	 echo "성공적으로 업로드 되었습니다.\n"; 
							// uploads디렉토리에 파일을 업로드합니다. 
							
							if($ext[1]=="jpg" || $ext[1]=="jpeg")
							{
								$img = imagecreatefromjpeg($uploadfile);
							}
							else if($ext[1]=="gif")
							{
								$img = imagecreatefromgif($uploadfile);
							}
							else if($ext[1]=="png")
							{
								$img = imagecreatefrompng($uploadfile);
							}
							

							//$width = imageSX($img);
							//$height = imageSY($img);
							// 이미지 사이즈 지정.. 아래 사이즈 보다 이미지가 작으면 나머지 공간은 검은색으로 모두 채움.
						
							
							$image = new Image($uploadfile);
							list($width,$height) = getimagesize($uploadfile);

							if($width+$height > 1000)
							{
								if($width>$height)
								{
									$image->width(500);
								}
								else
								{
									$image->height(500);
								}
							}
							
							$image->save();

							return $today."_".$_SESSION["MEM_IDX"].".".$ext[1];
						} else { 
							// echo "파일 업로드 실패입니다.\n"; 
						} 
				  } 
			 } 
		}

		/*
		
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
		}*/

		
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



