<?
 ob_start();
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";

if (!$_SESSION["MEM_IDX"]){ReopenLayer("layer6","alert","?alert=sessionend");exit;}
$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
/*************************************************************************************************************************************************************/
/********************************************************************** write / odredit / periodreq **********************************************************/
/*************************************************************************************************************************************************************/
if ($typ=="write" || $typ=="odredit" ||$typ =="periodreq"){   //periodreq : 납기확인
	
	if (!$odr_idx){  
			$part=get_part($part_idx);
			$sell_mem_idx = $part[mem_idx];
			$sell_rel_idx = $part[rel_idx];
			$part_type = $part[part_type];
		
		//1. 임시 odr_idx 를 구한다. 구하지 말고 우선 그냥 무조건 insert 시켜보자.
		//$odr_idx = get_any("odr a left outer join odr_det b ON a.odr_idx = b.odr_idx", "a.odr_idx", "part_idx = $part_idx and imsi_odr_no <> '' and mem_idx=".$_SESSION["MEM_IDX"]." and rel_idx=".$_SESSION["REL_IDX"]);	
	}

	
	if (!$odr_idx){   //odr idx가 없으면 odr_idx 생성
	$sql = "insert into odr set
			imsi_odr_no = 'IM-".date("ymdhms").RndomNum(4)."'
			,mem_idx = $session_mem_idx
			,rel_idx = $session_rel_idx
			,sell_mem_idx = $sell_mem_idx
			,sell_rel_idx = $sell_rel_idx
			,period = ''
			,odr_status= '0'
			,memo = '$memo'
			,save_yn = '$save_yn'
			,reg_date = now()
			,reg_ip= '$log_ip'
		";
	//	echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$odr_idx=mysql_insert_id(); 

		
		//일반 배송으로 ship_info 하나 생성.
		$sql = "insert into ship set 				
				  ship_type = '1' , 
				  odr_idx  = '$odr_idx' ,		
				  ship_info ='$ship_info',
				  ship_account_no = '$ship_account_no' , 
				  insur_yn ='$insur_yn',
				  reg_date =  now(),
				  reg_ip = '$log_ip'
		";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$new_ship_idx=mysql_insert_id(); 		
		$sql = "update odr set ship_idx = $new_ship_idx where odr_idx = $odr_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());


	//	$sql = "update odr set odr_no = 'PO$part_ty-".$sell_mem_idx."-".$odr_idx."' 
	//			where odr_idx = $odr_idx";
	
	//	$sql = "update odr set odr_no = '".get_odr_no("PO")."' 
	//			where odr_idx = $odr_idx";
	//	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	
	}elseif($save_yn){
		$sql = "update odr set save_yn = '$save_yn' where odr_idx = $odr_idx";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}

	if ($odr_idx && $fromPage!="add"){
	//	elseif($memo || $ship_account_no || $delivery_addr_idx){   //memo 값이 들어있다는 얘기는 extra data가 넘어왔다는 뜻 안들어왔어도 update 하자. 썻다 지우고 싶을수도 있으니까.
		$sql = "update ship set 
			ship_info = '$ship_info'
			,delivery_addr_idx = '$delivery_addr_idx'
			,ship_account_no = '$ship_account_no'
			,insur_yn = '$insur_yn'
			,memo = '$memo'
			where odr_idx = $odr_idx and ship_type = '1'
			";
		//	echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}
	// write, periodreq(납기확인) ---------------------------------------------------------------------------
	if ($typ !="odredit"){   //odredit일때는 odr_det는 안건드리고 odr 테이블만 업데이트 한다. 
		$cnt = get_any ("odr_det" , "count(*)", "odr_idx= $odr_idx and part_idx = $part_idx");
		if ($cnt > 0 ) { 
			ReopenLayer("layer3",$fromLoadPage,"?odr_idx=$odr_idx");
	//		Page_Parent_Msg_Url("이미 발주 또는 납기 확인요청이 들어간 부품입니다.","/kor/");
			$sql = "update odr_det set odr_quantity =  '$odr_quantity' where odr_idx = $odr_idx and part_idx = $part_idx";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$odr_det_idx=get_any ("odr_det" , "odr_det_idx", "odr_idx= $odr_idx and part_idx = $part_idx");
		}else{
			if(!$part_type){
				$part_type = get_any("part", "part_type", "part_idx=$part_idx");
			}
			//odr_det에 insert 	
			if ($part_type==7){
				$odr_quantity = 1;
			}
			
			$amend_yn = $fromLoadPage == "09_01" ? "Y":"N";
			$sql = "insert into odr_det set
					odr_idx = $odr_idx 			
					,part_idx =  '$part_idx'
					,part_type =  '$part_type'
					,odr_quantity =  '$odr_quantity'
					,period =  '$period'
					,amend_yn =  '$amend_yn'
			";
	//		echo $sql;
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$odr_det_idx=mysql_insert_id(); 			
		}
	}//end of - ($typ !="odredit")

	if (!$fromLoadPage){ $fromLoadPage="05_04";}
	if ($typ =="periodreq") {  //납기 확인의 경우
		//1. status 변경
		$sql = "update odr set odr_status = 1 where odr_idx= $odr_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

		$sql ="update odr_history set confirm_yn = 'Y' where odr_idx = $odr_idx and confirm_yn = 'N'";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

		//2. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 1
				,status_name = '납기'
				,etc1 = '확인'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$session_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;		
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		//exit;
		closeLayer("layer4");
		if ($fromPage=="add"){
			ReopenLayer("layer3",$fromPage=="add"?"05_01":$fromLoadPage,"?odr_idx=$odr_idx".($fromPage=="add"?"&addsearch_part_no=$addsearch_part_no&fromLoadPage=$fromLoadPage":""));
		}else{
			closeLayer("layer3");
		}
	}else{	//납기 확인이 아닐 경우
		if($result){			
			if ($save_yn == "Y"){
				Page_Parent_Url("/kor/");
			}else{
				ReopenLayer("layer3",$fromPage=="add"?"05_01":$fromLoadPage,"?odr_idx=$odr_idx".($fromPage=="add"?"&addsearch_part_no=$addsearch_part_no&fromLoadPage=$fromLoadPage":""));
			}
			exit;
		}
	}

}	//end if 'write'
/*************************************************************************************************************************************************************/
/********************************************************************** edit *********************************************************************************/
/***********************************************************************************************************************************************************/
if ($typ == "edit"){
	 $no = $_POST[delchk];
	 $ary_part_idx = $_POST[mod_part_idx];
	 $ary_part_no = $_POST[mod_part_no];
	 $ary_manufacturer = $_POST[mod_manufacturer];
	 $ary_package = $_POST[mod_package];
	 $ary_dc = $_POST[mod_dc];
	 $ary_rhtype = $_POST[mod_rhtype];
	 $ary_quantity = $_POST[mod_quantity];
 	 
	 if ($part_type =="7"){
		$sql = "update turnkey set price = '".$price."' where turnkey_idx = $turnkey_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
//		echo $sql;
	 }

	
	 for ($j = 0 ; $j<count($ary_part_idx); $j++){

		  if ($part_type== "2"){
			$option = ", price = '".$ary_price[$j]."'";
		  }elseif($part_type =="7"){ //turnkey
			$option = ", quantity = '".$ary_quantity[$j]."'";
			if ($i <=4){
			}
		  }else{
			$option = ", quantity		= '".$ary_quantity[$j]."'
					   , price			= '".$ary_price[$j]."' ";
		  }


			$sql = "update part set 
				mem_idx ='".$_SESSION["MEM_IDX"]."'
				,rel_idx='".$_SESSION["REL_IDX"]."' 
				, part_no		= '".$ary_part_no[$j]."'
				, manufacturer	= '".$ary_manufacturer[$j]."'
				, package		= '".$ary_package[$j]."'
				,  dc			= '".$ary_dc[$j]."'
				, rhtype		= '".$ary_rhtype[$j]."' 
				$option 			
				where part_idx = $ary_part_idx[$j]";

				//echo $sql."<BR>";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		
	 }
	if($result){
		PageReLoad("저장되었습니다.",$part_type);
	}
}

if ($typ =="invreg"){   //송장 정보 등록
	 $ary_odr_det_idx = $_POST[odr_det_idx];
	 $ary_supply_quantity= $_POST[supply_quantity];
	 $ary_part_condition = $_POST[part_condition];
	 $ary_pack_condition1 = $_POST[pack_condition1];
	 $ary_pack_condition2 = $_POST[pack_condition2];
	 $ary_part_no = $_POST[part_no];
	 $ary_manufacturer = $_POST[manufacturer];
	 $ary_package = $_POST[package];
	 $ary_memo = $_POST[memo];
 	
	
	//1. odr_det 정보 업데이트
	 for ($j = 0 ; $j<count($ary_odr_det_idx); $j++){		
			$sql = "update odr_det set 
				 supply_quantity			= '".$ary_supply_quantity[$j]."'
				, part_condition			= '".$ary_part_condition[$j]."'
				, pack_condition1			= '".$ary_pack_condition1[$j]."'
				, pack_condition2			= '".$ary_pack_condition2[$j]."'
				, memo						= '".$ary_memo[$j]."'
				where odr_det_idx = $ary_odr_det_idx[$j]";
				echo $sql."<BR>";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		

				//송장에서도 개별 파트정보 업데이트 가능
				$part_idx =get_any("odr_det", "part_idx" ,"odr_det_idx=$ary_odr_det_idx[$j]"); 
				$sql = "update part set part_no = '".$ary_part_no[$j]."',
						manufacturer = '".$ary_manufacturer[$j]."', 
						package= '".$ary_package[$j]."'
						where part_idx = ".$part_idx."";
						//echo $sql;
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	 }

	 $sql = "update ship set appoint_yn = '$appoint_yn' , tax = '$tax' where odr_idx = $odr_idx";
	 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		

	
	if($result){
		ReopenLayer("layer5","30_09","?odr_idx=$odr_idx");
	}

}

if($typ =="invconfirm"){
 //1. status변경
	update_val("odr","odr_status","18", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	
	//2. 송장 번호 등록
	$inv_no = get_auto_no("EI", "odr", "invoice_no");		
	update_val("odr","invoice_no",$inv_no , "odr_idx", $odr_idx);	
	$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
	//3. histoy update(발주서를 확인 한 상태로 update)
	$odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and (status = 2 or status=3) and confirm_yn='N'");
	update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);
	//3. history 등록
	$session_mem_idx = $_SESSION["MEM_IDX"];
	$sql = "insert into odr_history set 
			odr_idx = '$odr_idx'
			,status = 18
			,status_name = '송장'
			,etc1 = '$inv_no'
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

if($typ =="del"){
	$sql = "delete from $tbl where ".($tbl=="member"?"mem":$tbl)."_idx = ".$idx;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}
}

if ($typ =="odrconfirm"){		
	    //0. 만약에 odr_status가 납기 확인한 데이터가 있다면 그 테이터를 확인 한것으로 표시 (confirm_yn = Y') 
		$odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 16");
		if ($odr_history_idx){update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);}
		
		//1. odr_status 변경
		update_val("odr","odr_status","2", "odr_idx", $odr_idx);
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

		$odr_no = get_any("odr", "odr_no", "odr_idx = $odr_idx");
		//2. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,status = 2
				,status_name = '발주서'
				,etc1 = '$odr_no'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		update_val("odr","save_yn","N", "odr_idx", $odr_idx);

		//3. session 비우기		
//		$part_type = get_any("odr_det" ,"min(part_type)" , "odr_idx = $odr_idx");
//		$part_ty = ($part_type == "1" || $part_type == "3" || $part_type=="4")?"S":$part_idx;    //S: stock은 한번에 같이 order 그 외는 개별 odr
//		$_SESSION["IMSI_".$part_ty."_".$sell_mem_idx."_".$session_mem_idx]="";
		if($result){
			echo "SUCCESS";
			exit;
		}
}

if ($typ =="odramendconfirm"){		
	    //0. 만약에 odr_status가  송장 또는 도착한 데이터가 있다면 그 테이터를 확인 한것으로 표시 (confirm_yn = Y')  왜냐면, 수정 발주서를 발행하는 시점은 처음 송장 받았거나, 물건이 도착 한 후에 할수 있으므로.
		$odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and (status = 18 or status = 19) and confirm_yn='N'");
		if ($odr_history_idx){update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);}
		
		//1. odr_status 변경
		update_val("odr","odr_status","3", "odr_idx", $odr_idx);
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

		$amend_no = get_any("odr", "amend_no", "odr_idx = $odr_idx");
		//2. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,status = 3
				,status_name = '수정발주서'
				,etc1 = '$amend_no'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		update_val("odr","save_yn","N", "odr_idx", $odr_idx);
		if($result){
			echo "SUCCESS";
			exit;
		}
}

if($typ =="chmybank"){
//charge my bank 일 때에는
	$invoice_no = get_auto_no("CMBI", "mybank" , "invoice_no");
	$sql = "insert into mybank set
				mem_idx = '$mem_idx'
				,rel_idx = '$rel_idx'
				,charge_type = '1'
				,charge_amt = '$tot_amt'
				,invoice_no = '$invoice_no'
				,charge_method = '$charge_method'
				,deposit_yn = '$with_deposit'
				,odr_idx = '$odr_idx'
				,reg_date = now()
				,reg_ip= '$log_ip'";
	//	echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());	
		insert_invoice($invoice_no, "CMBI", $mem_idx, $rel_idx, "","",$log_ip); //odr_idx, odr_det_idx
		if ($result){
			echo "SUCCESS";
			exit;
		}
}


if ($typ == "pay"){
		if (QRY_CNT("odr_det", "and odr_idx = $odr_idx and part_type='2'")>0){$typ ="pay_jisok";}
}


function deposit_proc($mem_idx, $rel_idx, $tot_amt,$charge_method){
	if ($_SESSION["DEPOSIT"]=="N" && $tot_amt >= 1000){  //보증금을 내지 않았다면 보증금과 한번에 결제 된 것이므로 여기서 처리
		$invoice_no = get_auto_no("DI", "mybank" , "invoice_no");
		$sql = "insert into mybank set 
		mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '8'
			,invoice_no = '$invoice_no'
			,charge_amt = '-1000'
			,charge_method = '$charge_method'
			,reg_date = now()
			,reg_ip= '$log_ip'";
		$conn = dbconn();	
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
		$_SESSION["DEPOSIT"] = "Y";
		insert_invoice($invoice_no, "DI", $mem_idx, $rel_idx, "","",$log_ip); //odr_idx, odr_det_idx
		return $tot_amt - 1000;
	}else{
		return $tot_amt;
	}
}

if ($typ == "pay"){  //결제 처리
	// 보증금 확인 작업
		if ($_SESSION["MEM_IDX"] == $mem_idx){
			$remain_tot_amt = deposit_proc($mem_idx, $rel_idx, $tot_amt, $charge_method);
			if ($remain_tot_amt < $tot_amt){
			$with_deposit = "Y";
			$tot_amt = $remain_tot_amt;
		}
		$odr = get_odr($odr_idx);	
		$mem_idx = $odr[mem_idx];
		$rel_idx = $odr[rel_idx];
		$sell_mem_idx = $odr[sell_mem_idx];
		$sell_rel_idx = $odr[sell_rel_idx];
		// 1. mybank insert    //결제 관련 insert를 할 때에는 pair로 해야 한다. 판매자에게는 충전이 되고, 구매자에게는 차감해야 하기 때문에 .
		//먼저 구매자 지불 charget_type = '3' 은 물품 금액 지불
		$sql = "insert into mybank set
				mem_idx = '$mem_idx'
				,rel_idx = '$rel_idx'
				,charge_type = '3'
				,charge_amt = '-$tot_amt'
				,charge_method = '$charge_method'
				,deposit_yn = '$with_deposit'
				,odr_idx = '$odr_idx'
				,reg_date = now()
				,reg_ip= '$log_ip'";
	//	echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
		// 판매자에게는 충전 charge_type = '4' : 물품 금액만큼 충전
		$sql = "insert into mybank set
				mem_idx = '$sell_mem_idx'
				,rel_idx = '$sell_rel_idx'
				,charge_type = '4'
				,charge_amt = '$tot_amt'
				,charge_method = '$charge_method'
				,odr_idx = '$odr_idx'
				,reg_date = now()
				,reg_ip= '$log_ip'";
	//	echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
		//2. odr_status 변경
		update_val("odr","odr_status","5", "odr_idx", $odr_idx);
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

		//3. histoy update(송장을 확인 한 상태로 update)
		$sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and status= 18 and confirm_yn = 'N'";	
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"입금":"My Bank");
		//4. history 등록
			$session_mem_idx = $_SESSION["MEM_IDX"];
			$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
			$tot_amt = number_format($tot_amt,2);
			$sql = "insert into odr_history set 
					odr_idx = '$odr_idx'
					,status = 5
					,status_name = '결제완료'
					,etc1 = '$tot_amt $prt_method'
					,with_deposit = '$with_deposit'
					,sell_mem_idx = '$sell_mem_idx'
					,buy_mem_idx = '$mem_idx'
					,reg_mem_idx = '$mem_idx'
					,reg_date = now()";
			//echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			if($result){
				echo "SUCCESS";
				exit;
			}
	}else{  //판매자가 결제 하는 경우 - Deposit
		$remain_tot_amt = deposit_proc($sell_mem_idx, $sell_rel_idx, $tot_amt,$charge_method);
		if($remain_tot_amt==0){
			echo "SUCCESS-Deposit";
			exit;
		}
	}
	
}

if ($typ == "pay_access"){ //부대비용 지불
	$odr = get_odr($odr_idx);	
	$mem_idx = $odr[mem_idx];
	$rel_idx = $odr[rel_idx];
	$sell_mem_idx = $odr[sell_mem_idx];
	$sell_rel_idx = $odr[sell_rel_idx];
	// 판매자에게는 지불 : 부대비용 금액만큼 지불
	$sql = "insert into mybank set
			mem_idx = '$sell_mem_idx'
			,rel_idx = '$sell_rel_idx'
			,charge_type = '13'
			,charge_amt = '-$tot_amt'
			,charge_method = '$charge_method'
			,odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		

// 1. mybank insert    //결제 관련 insert를 할 때에는 pair로 해야 한다. 
	//구매자 충전 
	$sql = "insert into mybank set
			mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '13'
			,charge_amt = '$tot_amt'
			,charge_method = '$charge_method'
			,odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	//2. odr_status 변경
	update_val("odr","odr_status","5", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

	//3. histoy update(반품선적완료를 확인 한 상태로 update)
	$sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and  (status = 11 or status=18)  and confirm_yn = 'N'";	
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	$prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"입금":"My Bank");
	//4. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$tot_amt = number_format($tot_amt,2);
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 5
				,status_name = '결제완료'
				,etc1 = '$tot_amt $prt_method'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}

}

if ($typ == "pay_jisok"){
	$session_mem_idx = $_SESSION["MEM_IDX"];
	$odr = get_odr($odr_idx);	
	$buy_mem_idx = $odr[mem_idx];
	$buy_rel_idx = $odr[rel_idx];
	$sell_mem_idx = $odr[sell_mem_idx];
	$sell_rel_idx = $odr[sell_rel_idx];

	$sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and confirm_yn = 'N'";	
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	if ($session_mem_idx == $sell_mem_idx) { // 판매자가 결제 하는 경우 : 계약금(부품총액의 10%)
		$charge_type = "2";
		$invoice_no = get_auto_no("DPI", "mybank", "invoice_no");		
		//$tot_amt = $tot_amt / 10;
		$charge_ty = "D";
		//histoy update(결제를 확인한 상태로 update)
		$mem_idx = $sell_mem_idx;
		$rel_idx = $sell_rel_idx;
	}else{   //구매자가 결제 하는 경우 2가지 case : 계약금(총액의 10%), 나머지 금액 (총액의 90%)
		$odr_pay_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 5");
		$invoice_no = get_auto_no("EI", "odr", "invoice_no");		
		if ($odr_pay_idx){   //결제 한 이력이 있으면 90% 결제할 차례
			$charge_type = "3";
		//	$tot_amt = $tot_amt - $tot_amt / 10;
			$charge_ty = "F";
			//도착한 메세지를 확인한 상태로 update
			
		}else{  //없으면 구매자가 계약금 결제 할 차례
			$invoice_no = get_auto_no("DPI", "mybank", "invoice_no");		
			$charge_type = "2";
		//	$tot_amt = $tot_amt / 10;
			$charge_ty = "D";
			//3. histoy update(송장을 확인 한 상태로 update)
			
		}
	}

	// 1. mybank insert    //
	//charget_type = '2' 은 계약금 지불
	
	$sql = "insert into mybank set
			mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,invoice_no = '$invoice_no'
			,charge_type = '$charge_type'
			,charge_amt = '-$tot_amt'
			,charge_method = '$charge_method'
			,odr_idx = '$odr_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	//2. odr_status 변경
	update_val("odr","odr_status","5", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	$prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"입금":"My Bank");
	//4. history 등록		
		$tot_amt = number_format($tot_amt,2);
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,status = 5
				,status_name = '결제완료'
				,etc1 = '$tot_amt $prt_method'
				,charge_ty = '$charge_ty'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
//		echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}

}


if ($typ == "refund"){  //환불 처리
	// 1. mybank insert    //결제 관련 insert를 할 때에는 pair로 해야 한다. 환불은 구매자에게는 충전이 되고, 판매자에게는 차감해야 하기 때문에 .
	//먼저 구매자에게 충전 charget_type = '10' 은 물품 금액 환불
	$sql = "insert into mybank set
			mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '10'
			,charge_amt = '$tot_amt'
			,charge_method = '$charge_method'
			,invoice_no = '$invoice_no'
			,odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	// 판매자에게는 차감 charge_type = '10' : 물품 금액만큼 차감
	$sql = "insert into mybank set
			mem_idx = '$sell_mem_idx'
			,rel_idx = '$sell_rel_idx'
			,charge_type = '10'
			,charge_amt = '-$tot_amt'
			,charge_method = '$charge_method'
			,invoice_no = '$invoice_no'
			,odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,reg_date = now()
			,reg_ip= '$log_ip'";
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	//2. odr_status 변경
	update_val("odr","odr_status","24", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	

	//3. histoy update(환불 해달라는 history요청을 확인 한 상태로 update)    status = 10 인 경우도 환불 하지만, 5(결제완료)인 경우도 환불 하는경우가 있다. (18-2-15 상황)
	$odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and (status = 10 or status= 5) and confirm_yn='N'");
	update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);
	$prt_method = $charge_method=="1" ? "신용카드" : ($charge_method=="2"?"입금":"My Bank");
	//4. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$tot_amt = number_format($tot_amt,2);
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 24
				,status_name = '환불'
				,etc1 = '$tot_amt $prt_method'
				,fault_select = '4'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			echo "SUCCESS";
			exit;
		}
}



if($typ == "shipping"){  //선적 처리	
	//1. 운송장 번호 update
	if($fault_yn=="Y"){
		update_val("odr","fault_delivery_no",$delivery_no, "odr_idx", $odr_idx);
			$sql = "update odr_det set 
			 fault_quantity			= '".$fault_quantity."'
			,fault_method			= '".$fault_method."'
			, fault_part_condition			= '".$part_condition."'
			, fault_pack_condition1			= '".$pack_condition1."'
			, fault_pack_condition2			= '".$pack_condition2."'
			, fault_dc			= '".$fault_dc."'
			, fault_memo						= '".$memo."'
			where odr_idx = $odr_idx";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
//			echo $sql;
			//2. histoy update(반품선적 완료를 확인한 상태로 update)  수량 부족일 때에는 수량 부족을 확인 한 상태로 update
			if ($fault_method == "3"){ $prev_status = "10";} else{ $prev_status = "11";}
			$prev_odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = '$prev_status' and confirm_yn = 'N'");
			update_val("odr_history","confirm_yn","Y", "odr_history_idx", $prev_odr_history_idx);
	}else{
		update_val("ship","delivery_no",$delivery_no, "odr_idx", $odr_idx);
		//2. histoy update(결제확인을 한 상태로 update)
		$prev_odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 5 and confirm_yn = 'N'");
		update_val("odr_history","confirm_yn","Y", "odr_history_idx", $prev_odr_history_idx);
	}
	
	//3. odr_status 변경
	update_val("odr","odr_status","21", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	$ship_info_nm=GF_Common_GetSingleList("DLVR",$ship_info);
	if ($odr_history_idx) { 
		//4. history update
		$sql = "update odr_history 
			set etc2 = '$etc2'
			,odr_det_idx = '$odr_det_idx'
			,etc1 = '$ship_info_nm $delivery_no'
			,fault_select= '$fault_select'
			,fault_yn = '$fault_yn'
			,confirm_yn = 'N'
			where odr_history_idx = '$odr_history_idx'";
		echo $sql;
	}else{
	//4. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		if ($session_mem_idx == $buy_mem_idx) { 
		}
		$tot_amt = number_format($tot_amt,2);
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 21
				,status_name = '선적완료'
				,etc1 = '$ship_info_nm $delivery_no'
				,fault_yn = '$fault_yn'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
//		echo $sql;
	}
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		
		if($result){
			Page_Parent_Msg_Url1("선적 완료 메세지가 구매자에게 성공적으로 전달되었습니다.","/kor/");
		}
}

if ($typ =="succEnd"){   //수령 및 정상 종료 처리
	$det_cnt = QRY_CNT("odr_det", "and odr_idx= $odr_idx");
	$arr = explode(",", $odr_det_idx );
	$session_mem_idx = $_SESSION["MEM_IDX"];
	$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
	for ($j = 0 ; $j<count($arr); $j++){
		$ary_odr_det_idx  = $arr[$j];
		//2. history 등록		
		$sql = "insert into odr_history set 
				odr_idx		= '$odr_idx'
				,odr_det_idx = '$ary_odr_det_idx'
				,status = 6
				,status_name = '수령'
				,etc1 = '종료'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$session_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
//		echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	}
		
	 //3. odr_status 변경 
	 $his_cnt = get_any("odr_history","count( DISTINCT odr_det_idx, STATUS ) ", "odr_idx =$odr_idx AND STATUS IN ( 6, 9, 10 )"); 
	if ($his_cnt >= $det_cnt) { 
		//1. histoy update(선적을 확인한 상태로 update)
		$sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and status= 21 and confirm_yn = 'N'";	
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		update_val("odr","odr_status","6", "odr_idx", $odr_idx);
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	}
	if($result){
		Page_Parent_Msg_Url1("정상적으로 수령 및 종료 되었습니다.","/kor/");
	}
}

if ($typ =="arrival"){   //물건 도착
  //1. odr_status 변경
	update_val("odr","odr_status","19", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
  //2. 추가 공급 가능 물량 및 부품,포장상태, 메모정보  update	
	$sql = "update odr_det set 
	 add_capa_quantity			= '".$addcapa."'
	, part_condition			= '".$part_condition."'
	, pack_condition1			= '".$pack_condition1."'
	, pack_condition2			= '".$pack_condition2."'
	, memo						= '".$memo."'
	where odr_idx = $odr_idx";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	$sql = "update ship set appoint_yn = '$appoint_yn' , tax = '$tax' where odr_idx = $odr_idx";
	 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		

	//2. histoy update(결제를 확인한 상태로 update, 혹시 지연요청을 한적 있으면 그 지연 요청도 확인 한 상태로 update)
	$sql = "update odr_history set confirm_yn = 'Y' where odr_idx= $odr_idx and status in (4,5,20) and confirm_yn = 'N'";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	

	//3. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,status = 19
				,status_name = '도착'
				,etc1 = '$addcapa EA'
				,sell_mem_idx = '$session_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			Page_Parent_Msg_Url1("구매자에게 도착 메세지를 보냈습니다.","/kor/");
		}
}

if ($typ =="updweight"){ //선적 중량 update
//	echo $odr_idx;
	$sql = "update ship set ship_weight = '$ship_weight' , weight_type = '$weight_type' where odr_idx = $odr_idx";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		echo "SUCCESS";
	}
}

if ($typ =="updbuyerdelifee"){ //구매자 운임 등록
	update_val("odr", "buyer_delivery_fee", "$buyer_delivery_fee", "odr_idx",$odr_idx);	
	echo "SUCCESS";
}

if ($typ =="updfaultydelifee"){ //불량 운임 등록
	update_val("odr", "faulty_delivery_fee", "$faulty_delivery_fee", "odr_idx",$odr_idx);	
	echo "SUCCESS";
}

if ($typ =="periodcfrm"){ //납기기한 확인
	//납기 확인 전에 개별 part 정보 update 할수 있게 수정.
	$part_idx =get_any("odr_det", "part_idx" ,"odr_det_idx=$odr_det_idx"); 
	$sql = "update part set part_no = '$part_no',
			manufacturer = '$manufacturer', 
			package= '$package',
			dc = '$dc'
			where part_idx = $part_idx";
			//echo $sql;

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		
	//	echo $sql;
	//납기 기한 update
	update_val("odr_det" , "period", "$period$pkind", "odr_det_idx" , $odr_det_idx);  
	update_val("odr_det" , "supply_quantity", "$supply_quantity", "odr_det_idx" , $odr_det_idx);  
	$odr_idx = get_any("odr_det", "odr_idx" ,"odr_det_idx=$odr_det_idx");

	if (QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0){   //물건 도착한 이후라면.. 
		if ($pkind == "WK" && $period >2 ) {  //period 값이 2주 이상이라면 odr를 분리 해야 한다. 
			$mem_idx = get_any("odr", "mem_idx", "odr_idx  = $odr_idx");	
			$odr_idx_im = get_any("odr", "odr_idx", "imsi_odr_no ='IM-".date("ymdhms").RndomNum(4)."'");	
			$odr_idx_old = $odr_idx;
			if (!$odr_idx_im) { 
				$sql = "insert into odr (imsi_odr_no, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status ,  memo, reg_date, reg_ip,status_edit_mem_idx)
					select 'IM-".$session_mem_idx."-".$mem_idx."', mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status , memo, now(), reg_ip, $session_mem_idx from odr where odr_idx = $odr_idx ";
				//	echo $sql;
					$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
					$odr_idx=mysql_insert_id(); 			
					// 선적 정보도 분리한다.
					$sql = "insert into ship (ship_type, odr_idx, delivery_addr_idx, ship_info, ship_account_no, insur_yn) 
					select ship_type, '$odr_idx', delivery_addr_idx, ship_info, ship_account_no, insur_yn from ship where odr_idx = $odr_idx_old and ship_type=1 ";
					$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
					$new_ship_idx=mysql_insert_id();       		
					$sql = "update odr set ship_idx = $new_ship_idx where odr_idx = $odr_idx";
					$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());



					$sql = "update odr_det set odr_idx = $odr_idx where odr_det_idx = $odr_det_idx";
					$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
					$sql = "update odr_history set odr_idx = $odr_idx where odr_det_idx = $odr_det_idx";
					$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

			}
		}		
	}

	
	//1. histoy update(납기 확인한 상태로 update)
		$odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and odr_det_idx = $odr_det_idx and status = 1");
		update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);

	//2. history 등록
		$session_mem_idx = $_SESSION["MEM_IDX"];
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 16
				,status_name = '납기 확인'
				,etc1 = '$period$pkind'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	$cnt = QRY_CNT("odr_det" , "and odr_idx = $odr_idx and (part_type = '2' or part_type = '5' or part_type='6') and period =''");
		
	if ($cnt ==0){  //해당 odr_idx의 모든 납기 확인이 끝났을 때에야 odr_status 변경하고
		//0. period 등록 : 제일 긴 period로
		$max_period = get_any("odr_det" ,"period", "odr_idx =$odr_idx ORDER BY CASE WHEN instr( period, 'WK' ) >0 THEN period *7 ELSE period *1 END DESC LIMIT 0 , 1 ");
		update_val("odr", "period", $max_period, "odr_idx", $odr_idx);
		//1. odr_status 변경 : 납기 확인 으로.
		update_val("odr","odr_status","16", "odr_idx", $odr_idx);
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
		echo "SUCCESS ALL";
	}else{
		echo "SUCCESS";
	}
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
			$odr_history_idx = get_any("odr_history", "odr_history_idx", "odr_idx =$odr_idx and confirm_yn = 'N'");
			if ($deposit_yn=="Y") {   //송금액에 보증금도 포함되어 있다는 의미
				$invoice_no = get_auto_no("DI", "mybank", "invoice_no");		//보증금 : DI
				$sql = "insert into mybank set 
				 mem_idx = '$mem_idx'
				,rel_idx = '$rel_idx'
				,charge_type = '8'
				,charge_amt = '-1000'
				,invoice_no = '$invoice_no'
				,charge_method = '$charge_method'
				,deposit_yn = '$deposit_yn'
				,odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,odr_history_idx = '$odr_history_idx'
				,reg_date = now()
				,reg_ip= '$log_ip'";
				//echo $sql;
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
				update_want("member", " deposit='1' ", " and mem_idx='$mem_idx' ");
				//구매자의 보증금은 냈다고 미리 처리 해주자. (단, 판매자는 미리 처리 해주면 안된다. 바로 선적 가능 해버리기 때문에. 구매자는 미리 해줘도 된다. 보증금 이외의 금액이 모두 입금 확인 되어야 그 다음 단계를 진행 할수 있기 때문에.)
				$odr = get_odr($odr_idx);
				if ($odr[mem_idx] == $mem_idx){
					$_SESSION["DEPOSIT"] = "Y";
				}
				$tot_amt = $tot_amt - 1000;
			}
			if ($tot_amt > 0 ) {
				 if ($invoice_no ==""){
					 $invChr = get_any("code_group_detail", "dtl_code" , "grp_idx = 19 and code_desc_mt = '$charge_type'");
					 if ($charge_type=="3"){
						$invoice_no = get_auto_no("EI", "odr", "invoice_no");
					 }elseif ($invChr){
						 $invoice_no = get_auto_no($invChr, "mybank", "invoice_no");
					 }
				 }
				 $sql = "insert into mybank set
						 mem_idx = '$mem_idx'
						,rel_idx = '$rel_idx'
						,charge_type = '$charge_type'
						,charge_amt = '".($charge_type=="1"?"":"-")."$tot_amt'
						,invoice_no = '$invoice_no'
						,charge_method = '$charge_method'
						,odr_idx = '$odr_idx'
						,odr_det_idx = '$odr_det_idx'
						,odr_history_idx = '$odr_history_idx'
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
if ($typ=="imgfileup" || $typ =="imgfiledel"){   //18R_21 에서 사용. 
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
	if ($pos==true){   //부품의 라벨/사진 정보 (odr_det에 저장)
		$arr = explode("_", $i);
		$odr_det_idx = $arr[0];
		$file_no = $arr[1];
		$sql = "update odr_det set file$file_no = '$filename' 
		where odr_det_idx = $odr_det_idx";
	//	echo $sql;
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
	}else{   //거절이나, 수량 부족시 사진 정보 (odr_history 에 저장)
		if ($odr_history_idx==""){
			$sql = "insert into odr_history set 
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
			$odr_history_idx=mysql_insert_id(); 
		}

		$sql = "update odr_history set 
		file$i  = '$filename' 
		where odr_history_idx = $odr_history_idx";	
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		
		if($result){
			if ($typ=="imgfileup"){
				Page_Updval("odr_history_idx",$odr_history_idx);
				Page_ImgUpload($no, $filename);
				exit;
			}else{
				echo "SUCCESS";
				exit;
			}
		}
	}
}

if ($typ=="refuse"){
	//0. 수량 부족일 때 
	if ($status == "10"){
		$sql = "update odr_det set fault_quantity = '$fault_quantity' , fault_method = '$fault_method' where odr_idx = $odr_idx and odr_det_idx = $odr_det_idx";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}
	if ($fault_select==""){
		if (strpos($etc2,"EA")==0){	$etc2 = $etc2."EA";}		//몇개 부족인지
	}else{
		switch($fault_select){
			case "1":
				$etc2= "교환";
			break;
			case "2":
				$etc2 = "반품";
			break;
			case "3" :
				$etc2 = "추가선적";
			break;
			case "4" :
				$etc2 = "환불";
			break;
		}
	}
	



//1. odr_status 변경 : 거절으로.
	update_val("odr","odr_status",$status, "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);		
		
	//3. history update (왔다 갔다 한게 1번 이상이면 거절/수량부족 확인 한 상태로)
	$sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and status = $status and confirm_yn = 'N'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());



	if ($odr_history_idx){
		//4. history update
		$sql = "update odr_history 
			set etc2 = '$etc2' 
			,etc1 = '$etc1'
			,odr_det_idx = '$odr_det_idx'
			,fault_select= '$fault_select'
			,fault_yn = '$fault_yn'
			,reason = '$memo'
			,confirm_yn = 'N'
			where odr_history_idx = '$odr_history_idx'";
			//echo $sql;
	}else{
		$sql = "insert into odr_history set 
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
	}
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());


	$det_cnt = QRY_CNT("odr_det", "and odr_idx= $odr_idx");
	$his_cnt = get_any("odr_history","count( DISTINCT odr_det_idx, STATUS ) ", "odr_idx =$odr_idx AND STATUS IN ( 6, 9, 10 )"); 

	if ($his_cnt == $det_cnt) { 
		//2. histoy update(선적 확인한 상태로 update : 개별 상품이 여러개라면.. 모든 상품이 (수량부족/거절/수령) 진행 중이어야 선적확인 완료 상태로 update 가능  
		$pre_odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $odr_idx and status = 21");
		update_val("odr_history","confirm_yn","Y", "odr_history_idx", $pre_odr_history_idx);
	}


		echo "SUCCESS";
}

if ($typ=="notify"){
	//0. 불량통보일 때 
	
	//1. odr_status 변경 : 거절으로.
	update_val("odr","odr_status",$status, "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	if ($odr_history_idx){
		//4. history update
		$sql = "update odr_history 
			set etc2 = '$etc2' 
			,etc1 = '$etc1'
			,fault_select= '$fault_select'
			,fault_yn = '$fault_yn'
			,reason = '$memo'
			,confirm_yn = 'N'
			where odr_history_idx = '$odr_history_idx'";
			//echo $sql;
	}else{
		$sql = "insert into odr_history set 
			odr_idx = '$odr_idx'
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
	}
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		echo "SUCCESS";
}

if ($typ =="return_method"){
	//1. odr_status 변경 : 반품 방법으로
	update_val("odr","odr_status","22", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	//2. history update (1번 이상이면 거절 확인 한 상태로)
	$sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $odr_idx and status = 9 and confirm_yn = 'N'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$etc1 = $return_method == "1" ? "반품포기" : GF_Common_GetSingleList("DLVR",$ship_info)."-".$ship_account_no;	
	if ($return_method =="2") {
		$ship_type = $ship_type == "" ? "1" : $ship_type;
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
					  reg_date =  now()
			";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$ship_idx=mysql_insert_id(); 
		}
		$sql = "update odr_det set ship_idx = '$ship_idx' where odr_det_idx  = '$odr_det_idx'";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}

	$sql = "insert into odr_history set 
			odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,status = $status
			,status_name = '$status_name'
			,etc1 = '$etc1'			
			,etc2 = '$etc2'
			,fault_select= '$fault_select'
			,return_method = '$return_method'
			,reason = '$memo'
			,confirm_yn  = 'N'
			,sell_mem_idx = '$sell_mem_idx'
			,buy_mem_idx = '$buy_mem_idx'
			,reg_mem_idx = '$session_mem_idx'
			,reg_date = now()";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		echo "SUCCESS";
}
//////반품 선적시 etc2 : 반품 , fault_select : 2 , odr_det_idx :  세개 다 넘겨야 하는것 할 차례.
if ($typ =="return_submit"){
	//1. odr_status 변경 : 반품 선적 완료로
	update_val("odr","odr_status","11", "odr_idx", $odr_idx);
	update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	
	//2. history update (반품 방법 확인한 상태로)
	$searchand = "odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and status = 22 and confirm_yn = 'N'";
	$prev_odr_history_idx = get_any("odr_history" , "odr_history_idx", $searchand);
	if ($prev_odr_history_idx) {
		$odr_his = get_odr_history($prev_odr_history_idx);
		//$etc2 = $odr_his[etc2];
		$fault_select = $odr_his[fault_select];
		$return_method= $odr_his[return_method];		
		$sql = "update odr_history set confirm_yn  = 'Y' where odr_history_idx = $prev_odr_history_idx";		
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}
	$etc1 = $return_method == "1" ? "반품포기" : GF_Common_GetSingleList("DLVR",$ship_info) ." ".$delivery_no;
	$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
	$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");

	$sql = "insert into odr_history set 
			odr_idx = '$odr_idx'
			,odr_det_idx = '$odr_det_idx'
			,status = '11'
			,status_name = '반품선적완료'
			,etc1 = '$etc1'
			,etc2 = '$etc2'
			,fault_select= '$fault_select'
			,return_method = '$return_method'
			,confirm_yn  = 'N'
			,sell_mem_idx = '$sell_mem_idx'
			,buy_mem_idx = '$buy_mem_idx'
			,reg_mem_idx = '$session_mem_idx'
			,reg_date = now()";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			if ($return_method == "1"){
				echo "SUCCESS";
			}else{
				Page_Parent_Msg_Url1("반품 선적 완료 메세지가 판매자에게 성공적으로 전달되었습니다.","/kor/");
			}
		}
}

if($typ=="mybox_in"){
	$already_idx = get_want("mybox","idx"," and mem_idx = '$session_mem_idx' and part_idx = '$part_idx'");
	if($already_idx){
		$sql = "delete from mybox where idx='$already_idx'";
		$already="";
	}else{
		$sql = "insert into mybox set
				mem_idx = '$session_mem_idx'
				,mem_id = '$session_mem_id'
				,part_idx = '$part_idx'
				,part_type = '$part_type'
				,reg_date = '$log_date'
				,reg_ip = '$log_ip'
				";
		$already="1";
	}
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		Page_Chg_Mybox($already,$part_idx);		
		if($work=="del"){
			ReopenLayer2(".col-left", "mybox");
		}
		ReopenLayer2(".col-right", "side_order");
		echo "SUCCESS";
}

if($typ=="delivery_save"){
	if($delivery_addr_idx){	 //수정
			$sql = "update delivery_addr set 
					mem_idx = '$session_mem_idx'
					,save_yn = '$delivery_save_yn'
					,nation = '$nation'
					,com_name='$com_name'
					,manager= '$manager'
					,pos_nm = '$pos_nm'
					,depart_nm = '$depart_nm'
					,com_type = '$com_type'
					,tel = '$tel'
					,fax = '$fax'
					,hp = '$hp'
					,email = '$email'
					,homepage = '$homepage'
					,zipcode = '$zipcode'
					,dosi = '$dosi'
					,dositxt = '$dositxt'
					,sigungu = '$sigungu'
					,addr = '$addr'
					where delivery_addr_idx = $delivery_addr_idx
			";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}else{  //추가
			$sql = "insert into delivery_addr set 
					mem_idx = '$session_mem_idx'
					,save_yn = '$delivery_save_yn'
					,nation = '$nation'
					,com_name='$com_name'
					,manager= '$manager'
					,pos_nm = '$pos_nm'
					,depart_nm = '$depart_nm'
					,com_type = '$com_type'
					,tel = '$tel'
					,fax = '$fax'
					,hp = '$hp'
					,email = '$email'
					,homepage = '$homepage'
					,zipcode = '$zipcode'
					,dosi = '$dosi'
					,dositxt = '$dositxt'
					,sigungu = '$sigungu'
					,addr = '$addr'
					,reg_date = '$log_date'
					,reg_ip = '$log_ip'
					";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		//echo $sql;
		$delivery_addr_idx=mysql_insert_id(); 
		echo $delivery_addr_idx;
	}			
		
		

}

if($typ =="delivery_del"){
	$sql = "delete from delivery_addr where delivery_addr_idx = $delivery_addr_idx";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
?>
