<?
 ob_start();
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
if (!$_SESSION["MEM_IDX"]){
	ReopenLayer("layer6","alert","?alert=sessionend");
	exit;
}

$dir_dest = "../..".$file_path; //파일 저장 폴더 지정

if ($typ=="notify"){
	//0. 불량통보일 때 
	//1. odr_status 변경 : 거절으로.
	update_val("odr","odr_status",$status, "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	   
	//3. history update (1번 이상이면 불량통보 확인 한 상태로)
	$sql = "update fty_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and confirm_yn = 'N'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if ($fty_history_idx){
		//4. history update
		$sql = "update fty_history 
			set etc2 = '$etc2' 
			,etc1 = '$etc1'
			,fault_select= '$fault_select'
			,fault_yn = '$fault_yn'
			,reason_title = '$title'
			,reason = '$memo'
			,confirm_yn = 'N'
			where fty_history_idx = '$fty_history_idx'";
			//echo $sql;
	}else{
		$sql = "insert into fty_history set 
			odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,status = $status
			,status_name = '$status_name'
			,etc1 = '$etc1'
			,etc2 = '$etc2'
			,fault_select= '$fault_select'
			,fault_yn = '$fault_yn'
			,reason_title = '$title'
			,reason = '$memo'
			,confirm_yn  = 'N'
			,sell_mem_idx = '$sell_mem_idx'
			,buy_mem_idx = '$buy_mem_idx'
			,reg_mem_idx = '$session_mem_idx'
			,reg_date = now()";
	}
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		echo "SUCCESS";
}

//불량 통보시 
if ($typ =="updweight"){ //선적 중량 update
	$sql = "update ship set ship_weight = '$ship_weight' , weight_type = '$weight_type' where ship_idx = $ship_idx";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		echo "SUCCESS";
	}
}


if($typ=="testresult"){  //RND TEST 결과 공지
	  $fty_his = get_fty_history($fty_history_idx);
      update_val("fty_history","confirm_yn","Y", "fty_history_idx", $fty_history_idx);
	  update_val("ship","memo",replace_con_in($memo), "ship_idx", $ship_idx);
	  $sql = "update odr_det set test_report_no= '".get_odr_det_no("TR")."', test_report_date = now() where odr_det_idx=".$fty_his[odr_det_idx];
	  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	  $parts_mem_idx = get_any("member", "min(mem_idx)", "mem_type = 0");
	  //$test_result_txt = $test_result == "P" ? "Pass" : "Fail";
	  $sql = "insert into fty_history set 
				odr_idx		= '".$fty_his[odr_idx]."'
				,odr_det_idx = '".$fty_his[odr_det_idx]."'
				,status = 14
				,status_name = '결과공지'
				,etc1 = '$test_result'
				,confirm_yn = 'N'
				,reason_title = '$test_result'
				,reason = '$memo'
				,reason_ty = '6'
				,sell_mem_idx = '".$fty_his[sell_mem_idx]."'
				,buy_mem_idx = '".$fty_his[buy_mem_idx]."'
				,reg_mem_idx = '$parts_mem_idx'   
				,reg_date = now()";
//		echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
		echo "SUCCESS";
	}
}

if ($typ =="updror"){ // Reason of Return 반품 사유서 업데이트
	$sql = "update ship set recv = '$recv' , refer = '$refer' , content = '$content' where ship_idx = $ship_idx";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		echo "SUCCESS";
	}
}


if($typ == "shipping"){  //선적 처리 : from 21_2_03
	//1. 운송장 번호 update
	update_val("ship","delivery_no",$delivery_no, "ship_idx", $ship_idx);
	//2.반품선적을 확인 한 상태로 update
	$prev_fty_history_idx = get_any("fty_history" , "fty_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and status = 29 and confirm_yn = 'N'");
	update_val("fty_history","confirm_yn","Y", "fty_history_idx", $prev_fty_history_idx);
	//3. odr_status 변경
	update_val("odr","odr_status","25", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	//4. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$tot_amt = number_format($tot_amt,2);
		$ship_info_nm=GF_Common_GetSingleList("DLVR",$ship_info);
		//2016-10-20 : 본사로 반품(테스트 의뢰)은 양쪽다 않보이게(본사만 보게) confirm_yn='Y'
		if($reason_ty=="6"){
			$confirm_yn = "Y";
			$msg = "본사(PartsStrike)로";
		}else{
			$confirm_yn = "N";
			$msg = "구매자에게";
		}
		$sql = "insert into fty_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = $status
				,status_name = '$status_name'
				,etc1 = '$ship_info_nm-$delivery_no'
				,fault_yn = '$fault_yn'
				,reason_ty = '$reason_ty'
				,confirm_yn = '$confirm_yn'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$session_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			Page_Parent_Msg_Url1("반품 선적 완료 메세지가 ".$msg." 성공적으로 전달되었습니다.","/kor/");
		}
}

if ($typ =="end"){
		//구매자가 종료 요청할때 또는 판매자가 구매자 종료 요청을 똑같이 정상 종료 처리 할때.
	update_val("odr","odr_status",$status, "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	   
	//3. history update (마지막 불량통보 또는 상대방의 종료 요청을 확인 한 상태로)
	$sql = "update fty_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and (status = 12 or status = 30) and confirm_yn = 'N'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$sql = "insert into fty_history set 
			odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,status = $status
			,status_name = '$status_name'
			,etc1 = '$etc1'
			,etc2 = '$etc2'
			,fault_select= '$fault_select'
			,fault_yn = '$fault_yn'
			,reason = '$memo'
			,confirm_yn  = 'N'
			,sell_mem_idx = '$sell_mem_idx'
			,buy_mem_idx = '$buy_mem_idx'
			,reg_mem_idx = '$session_mem_idx'
			,reg_date = now()";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	echo "SUCCESS";
}


if ($typ=="bankfileup"){  //은행 송금 처리
	$i = $no;
	/** 파일 업로드 ******************************************/
		$query_name = "file".$i; //input 파라메터 이름		
		if($_FILES[$query_name]) {
			$FILE_1			= RequestFile("file".$i);			
			$FILE_1_size	= $FILE_1[size];
			$maxSize = '5242880'; //5mb, 파일 용량 제한
			$filename = uploadProc( $query_name, $dir_dest, $maxSize);			
		}

		if(${"file_o".$i}){
			$old_file=${"file_o".$i};
			if(file_exists("$dir_dest/$old_file")){
				unlink("$dir_dest/$old_file");
			}
		}

		if ($mybank_idx==""){
			$fty_history_idx = get_any("fty_history", "fty_history_idx", "odr_idx =$odr_idx and odr_det_idx =$odr_det_idx and confirm_yn = 'N'");
			if ($tot_amt > 0 ) {
				 $sql = "insert into mybank set
						 mem_idx = '$mem_idx'
						,rel_idx = '$rel_idx'
						,charge_type = '$charge_type'
						,charge_amt = '-$tot_amt'
						,charge_method = '$charge_method'
						,odr_idx = '$odr_idx'
						,odr_det_idx = '$odr_det_idx'
						,fty_history_idx = '$fty_history_idx'
						,deposit_yn = '$deposit_yn'
						,reg_date = now()
						,reg_ip= '$log_ip'";
						echo $sql;
					$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
					$mybank_idx=mysql_insert_id(); 		
					Page_Updval("mybank_idx",$mybank_idx);
			}else{
				$mybank_idx=mysql_insert_id(); 		
			}
			
		}

		$sql = "update mybank set 
		file$i  = '$filename' 
		where mybank_idx = $mybank_idx";	
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		Page_ImgUpload($no, $filename);
		exit;
}


if ($typ =="agreeconfirm"){		
	    update_val("odr","odr_status","13", "odr_idx", $odr_idx);
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

		$fty_history_idx = get_any("fty_history" , "fty_history_idx", "odr_det_idx= $odr_det_idx and confirm_yn='N'");
		if ($fty_history_idx){update_val("fty_history","confirm_yn","Y", "fty_history_idx", $fty_history_idx);}
		
		//2. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sql = "insert into fty_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 13
				,status_name = '동의서'
				,etc1 = '$agreement_no'
				,reason_ty = '$reason_ty'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		//update_val("odr","save_yn","N", "odr_idx", $odr_idx);
		if($result){
			echo "SUCCESS";
			exit;
		}

}

if ($typ =="return_method"){   //from 21_1_06 , 21_5_05
	//reason_ty : 6 은 파츠에 반품 하는 경우(RnD의뢰)
	if ($reason_ty == "6"){
		$reg_mem_idx = get_any("member", "min(mem_idx)", "mem_type = 0");  //$parts_mem_idx
	}else{
		$reg_mem_idx =$session_mem_idx;
	}

	//1. odr_status 변경 : 반품 방법으로
	update_val("odr","odr_status","29", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$reg_mem_idx, "odr_idx", $odr_idx);	
	//2. history update (1번 이상이면 거절 확인 한 상태로)
	$sql = "update fty_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and confirm_yn = 'N'";
	
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$etc1 = $return_method == "1" ? "반품포기" : GF_Common_GetSingleList("DLVR",$ship_info)."-".$ship_account_no;

	
	if ($return_method =="2") {	//반품...
		$ship_type = $ship_type == "" ? "2" : $ship_type;	//1:일반배송, 2:불량통보(반품), 3:거절/수량부족-반품, 4:연구소 의뢰
		$ship_idx = get_any("ship" , "ship_idx", "ship_type = $ship_type and odr_idx = $odr_idx and $odr_det_idx = $odr_det_idx");
		if($ship_idx==""){
			$sql = "insert into ship set 				
					  ship_type = '$ship_type' , 
					  odr_idx  = '$odr_idx' ,
					  odr_det_idx  = '$odr_det_idx' ,   
					  delivery_addr_idx = '$delivery_addr_idx' ,
					  ship_info ='$ship_info',
					  ship_account_no = '$ship_account_no' , 
					  delivery_no = '$delivery_no' , 
					  insur_yn ='$insur_yn',
					  reg_date =  now(),
					  reg_ip= '$log_ip'";
			
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$ship_idx=mysql_insert_id(); 
		}
		$sql = "update odr_det set ship_idx = '$ship_idx' where odr_det_idx  = '$odr_det_idx'";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$sql = "update ship set ship_info = '$ship_info', ship_account_no='$ship_account_no' where ship_idx  = '$ship_idx'";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}
	//반품방법(29) : history에 기 등록여부 확인하여 Update or Insert 로 변경 2016-10-18 불량통보(연구소로 선적)하면서...
	$his_cnt = QRY_CNT("fty_history"," and status=29 and odr_idx='$odr_idx' and odr_det_idx='$odr_det_idx'");
	if($his_cnt>0){
		$fty_idx = get_any("fty_history", "fty_history_idx", "status=29 and odr_idx='$odr_idx' and odr_det_idx='$odr_det_idx'");
		update_val("fty_history","etc1","$etc1", "fty_history_idx", $fty_idx);
	}else{
		$sql = "insert into fty_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = $status
				,status_name = '$status_name'
				,etc1 = '$etc1'			
				,etc2 = '$etc2'
				,reason_ty = '$reason_ty'
				,fault_select= '$fault_select'
				,return_method = '$return_method'
				,reason = '$memo'
				,confirm_yn  = 'N'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$reg_mem_idx'
				,reg_date = now()";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}
		echo "SUCCESS";
}

if ($typ =="return_submit"){
	//1. odr_status 변경 : 반품 선적 완료로
	update_val("odr","odr_status","25", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	//2. history update (반품 방법 확인한 상태로)
	$sql = "update fty_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and confirm_yn = 'N'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$etc1 = $return_method == "1" ? "반품포기" : "선적정보";
	$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
	$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");

	$sql = "insert into fty_history set 
			odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,status = '25'
			,status_name = '반품선적완료'
			,etc1 = '$etc1'
			,etc2 = '$etc2'
			,fault_select= '$fault_select'
			,return_method = '$return_method'
			,reason_ty = '$reason_ty'
			,confirm_yn  = 'N'
			,sell_mem_idx = '$sell_mem_idx'
			,buy_mem_idx = '$buy_mem_idx'
			,reg_mem_idx = '$session_mem_idx'
			,reg_date = now()";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		echo "SUCCESS";
}

if ($typ=="imgfileup" || $typ =="imgfiledel"){   //21_04 에서 불량 통보시 사용.  
	$i = $no;
	$filename ="";
	if ($typ =="imgfileup"){
		/** 파일 업로드 ******************************************/
		$query_name = "file".$i; //input 파라메터 이름		
		echo $query_name.":::::::".$dir_dest;
		//exit;

		if($_FILES[$query_name]) {
			$FILE_1			= RequestFile("file".$i);			
			$FILE_1_size	= $FILE_1[size];
			$maxSize = '5242880'; //5mb, 파일 용량 제한
			$filename = uploadProc( $query_name, $dir_dest, $maxSize);			
		}
	}		
	if(${"file_o".$i}){
		$old_file=${"file_o".$i};
		if(file_exists("$dir_dest/$old_file")){
			unlink("$dir_dest/$old_file");
		}
	}
	
	$pos = strpos($i, "_");

//	echo "~~~~".$pos."!!!!";
	if ($pos){   //부품의 라벨/사진 정보 (odr_det에 저장)
		$arr = explode("_", $i);
		$odr_det_idx = $arr[0];
		$file_no = $arr[1];
		$sql = "update odr_det set file$file_no = '$filename' 
		where odr_det_idx = $odr_det_idx";
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){	
			if ($typ=="imgfileup"){
				Page_ImgUpload($no, $filename);
				exit;		
			}else{
				echo "SUCCESS";
				exit;
			}
		}		
	}else{   //거절이나, 수량 부족시 사진 정보 (fty_history 에 저장)
		if ($fty_history_idx==""){
			$sql = "insert into fty_history set 
					odr_idx = '$odr_idx'
					,odr_det_idx = '$odr_det_idx'
					,status = $status
					,status_name = '$status_name'
					,etc1 = '$etc1'
					,confirm_yn  = 'F'
					,sell_mem_idx = '$sell_mem_idx'
					,buy_mem_idx = '$buy_mem_idx'
					,reg_mem_idx = '$session_mem_idx'
					,reg_date = now()";
		 echo $sql;
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$fty_history_idx=mysql_insert_id(); 
		}

		$sql = "update fty_history set 
		file$i  = '$filename' 
		where fty_history_idx = $fty_history_idx";	
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		
		if($result){
			if ($typ=="imgfileup"){
				Page_Updval("fty_history_idx",$fty_history_idx);
				Page_ImgUpload($no, $filename);
				exit;
			}else{
				echo "SUCCESS";
				exit;
			}
		}
	}
}


if ($typ == "pay"){  //결제 처리
	$session_mem_idx = $_SESSION["MEM_IDX"];
	// 1. mybank insert    //불량통보시 결제 관련 insert를 할 때에는 판매자가 결제를 하고, 구매자가 "확인" 버튼을 누르면 구매자에게 충전이 된다.
	$sql = "insert into mybank set
			mem_idx = '$sell_mem_idx'
			,rel_idx = '$sell_rel_idx'
			,charge_type = '10'
			,charge_amt = '-$tot_amt'
			,charge_method = 'MyBank'
			,odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	//2. odr_status 변경
	update_val("odr","odr_status","27", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

	//3. histoy update(송장을 확인 한 상태로 update)
	$fty_history_idx = get_any("fty_history" , "fty_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and confirm_yn = 'N'");
	update_val("fty_history","confirm_yn","Y", "fty_history_idx", $fty_history_idx);

	//4. history 등록
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$tot_amt = number_format($tot_amt,2);
		$sql = "insert into fty_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 27
				,status_name = '결제완료'
				,etc1 = '$tot_amt My Bank'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$mem_idx'
				,reg_mem_idx = '$sell_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}
}



if ($typ == "pay_compensation"){  // compensation : 구매자가 판매자에게 위로금 결제 처리
	$session_mem_idx = $_SESSION["MEM_IDX"];
	// 1. mybank insert    //불량통보시 결제 관련 insert를 할 때에는 구매자가 위로금 15%를 결제를 하고, 판매자가 "종료" 버튼을 누르면 판매자에게 충전이 된다.
	$sql = "insert into mybank set
			mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '11'
			,charge_amt = '-$tot_amt'
			,charge_method = 'MyBank'
			,odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	//2. odr_status 변경
	update_val("odr","odr_status","27", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

	//3. histoy update(송장을 확인 한 상태로 update)
	$fty_history_idx = get_any("fty_history" , "fty_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and confirm_yn = 'N'");
	update_val("fty_history","confirm_yn","Y", "fty_history_idx", $fty_history_idx);

	//4. history 등록
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$tot_amt = number_format($tot_amt,2);
		$sql = "insert into fty_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 27
				,status_name = '결제완료'
				,etc1 = '$tot_amt My Bank'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}
}

if ($typ == "pay_testfee"){  // testfee : 구매자가 불량 통보시 판매자가 request R&D. 각자가 test fee등등 결제 후 testing 이후의 winner에게 재충전.
//history에서 reason_ty = 6이면 testfee 동의서 (Request R&D) 에 관한 내용임.
	$session_mem_idx = $_SESSION["MEM_IDX"];
	// 1. mybank insert    //먼저 차감 하고. 결과가 나오면 충전 하는 방식.
	$sql = "insert into mybank set
			mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '12'
			,charge_amt = '-$tot_amt'
			,charge_method = 'MyBank'
			,odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	//2. odr_status 변경
	update_val("odr","odr_status","27", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

	//3. histoy update(송장을 확인 한 상태로 update)
	$fty_history_idx = get_any("fty_history" , "fty_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and confirm_yn = 'N'");
	update_val("fty_history","confirm_yn","Y", "fty_history_idx", $fty_history_idx);

	//4. history 등록
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$tot_amt = number_format($tot_amt,2);
		$sql = "insert into fty_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 27
				,status_name = '결제완료'
				,reason_ty = '6'
				,etc1 = '$tot_amt My Bank'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}
}

if ($typ == "refuse"){
	// 거절의 종류 : 종료 요청을 거절 할 수도 있고, 동의서 동의를 거절할 수도 있다. 
	//1. odr_status 변경 : 거절으로.
	update_val("odr","odr_status",$status, "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	//2.종료 요청 or 동의서를 확인 한 상태로 update
	$fty_history_idx = get_any("fty_history" , "fty_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and confirm_yn = 'N'");
	update_val("fty_history","confirm_yn","Y", "fty_history_idx", $fty_history_idx);
	//3. history 등록
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$tot_amt = number_format($tot_amt,2);
		$sql = "insert into fty_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = $status
				,status_name = '$status_name'
				,etc1 = '확인'
				,reason_ty = '$reason_ty'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){			
			Page_Parent_Msg_Url1("상대방에게 거절 메세지를 보냈습니다.","/kor/");
		}
}


if ($typ=="withdrawal"){
	if ($remitTy =="Y"){  //회원 탈퇴로 인한 인출 요청일 경우에는 메모(인출사유)를 "탈퇴"로 저장
		$sql="update member set del='1' ,del_date='$log_date' where mem_idx='$mem_idx'
		";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$remitClause = " , memo='탈퇴' ";
	}
	$invoice_no = get_auto_no("WI", "invoice" , "invoice_no");
	$sql = "insert into mybank set 
		mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '9'
			,mybank_yn = 'Y'
			,charge_amt = '-$tot'
			,mybank_hold = '$tot'
			,charge_method = '$charge_method'
			,invoice_no = '$invoice_no'
			$remitClause
			,reg_date = now()
			,reg_ip= '$log_ip'";

//			echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	insert_invoice($invoice_no, "WI", $mem_idx, $rel_idx, "","",$log_ip); //odr_idx, odr_det_idx

	


	if($result){			
			Page_Parent_Msg_Url1("파츠 연구소에 인출 요청 메세지를 보냈습니다..","/kor/");
		}
}
?>
