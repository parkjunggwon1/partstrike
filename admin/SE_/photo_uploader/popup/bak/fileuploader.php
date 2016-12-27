
<?php
	include "../../../../include/class.upload.php";
	include "../../../../include/common.php";


	// $query_name : input �̸�
	// $folder : ���� ����

	function uploadProc( $query_name, $dir_dest, $maxSize) {
		$handle = new Upload($_FILES[$query_name]);
		
		if ($handle->uploaded) {
			$handle->file_max_size = $maxSize;
			$handle->file_name_body_pre      = date("YmdHis")."_";

			if ($handle->file_src_size > $handle->file_max_size ) {
				die(popupMsgBack("(500KB)�̻� ���Ͼ��ε带 �����մϴ�."));
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
	
?>


