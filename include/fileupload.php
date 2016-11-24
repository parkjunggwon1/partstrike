
<?php
	include "class.upload.php";
	include "common.php";


	// $query_name : input 이름
	// $folder : 저장 폴더

	function uploadProc( $query_name, $dir_dest, $maxSize) {
		$handle = new Upload($_FILES[$query_name]);

		if ($handle->uploaded) {
			$handle->file_max_size = $maxSize;
			$handle->file_name_body_pre      = date("YmdHis");//BY yuri ."_";  and class.upload.php

			if ($handle->file_src_size > $handle->file_max_size ) {
				(popupMsg("(5 MB)이상 파일업로드를 금지합니다."));
			}

			$handle->Process($dir_dest);

			if ( $handle->file_dst_name == null ) {
				(popupMsg("잘못된 파일입니다."));
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

?>


