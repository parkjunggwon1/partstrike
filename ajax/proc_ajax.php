<?
/*******************************************************************************************************
*** 
*******************************************************************************************************/
include  $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.meminfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.partinfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.board.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.mybox.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.memfee.php";

$actty = replace_in($actty);
$actkind = replace_in($actkind);
$actidx = replace_in($actidx);
$rel_idx = replace_in($rel_idx);
$mem_idx = replace_in($mem_idx);
$part_type = replace_in($part_type);
$part_no = replace_in($part_no);
$page = replace_in($page);
$mode = replace_in($mode);
$idx = replace_in($idx);


switch($actty) {
   case "terms":
   case "joinus":
   case "joinus2":
   case "main_stock":   
   case "side":   
   case "side_order" :   //약관출력 , 가입폼출력, 기본사이드출력   
   case "side_stock":
   case "side_company_info":
   case "main_company_det":
   case "side_black_list":
   case "agreement":
   case "guide":
   case "board":
   case "mybox":
   case "remit":
   case "lab":
   case "memfee":
   case "contact":
   case "askpasswd":
	   fnSel($actty,$rel_idx,$mem_type,$mode);
   break;
   case "record":
   case "order":
	   fnSelRecord($actty,$odr_type);
   break;   
   case "memfee1":
	   fnmemfeelist("1",$page); 
   break;
   case "memfee2":
	   fnmemfeelist("2",$page); 
   break;
   case "side_memfee":
	   fnmemfeeview($actty,$idx); 
   break;
   case "boardlist":
	   fnboardlist($page,$mode,$wantcnt,$strsearch); 
   break;
   case "boardwrite":
	   fnboardwrite($mode,$board_idx); 
   break;
   case "side_board":
	   fnboardview($actty,$mode,$board_idx,$main); 
   break;
   case "agent":
	   fnagent($actty,$strsearch,$strsearch1,$page); 
   break;
   case "side_agency_info":
	   fnagencyview($actty,$idx,$nat,$strsearch); 
   break;
   case "turnkey":
	   fnSel($actty,$rel_idx,$mem_type,$mode);
   break;
   case "side_turnkey":
	fnSelturnkey($actty,$turnkey_idx);
   break;
   case "main_list":
	  fnmain_list($actkind, $actidx);
	break;
   case "turnkeyedit":
	  fnturnkeyedit($page);
   break;
   case "turnkeylist":
      fnturnkeylist($page,$part_no);
   break;
   case "part":
	  fnSelPart($actty, $part_type);
   break;
   case "mainpartlist":
	  	if ($top_part_no){$searchand .= "and part_no like '%$top_part_no%' ";}
		if ($top_manufacturer){$searchand .= "and manufacturer like '%$top_manufacturer%' ";}
		if ($top_qty){$searchand .= "and quantity >= $top_qty ";}
		if ($dc){$searchand .= "and (case when part_type = '2' then 1=1 else dc >= $dc end) ";}
		if ($area=="on"){	// 근접지역 표시
			$searchand .= "and nation = '".$_SESSION["NATION"]."' ";
			$areaonsrch ="and dtl_par_code = '".$_SESSION["NATION"]."' ";
		}
		if ($top_rhtype){
			if ($both == "Y"){
				$searchand .= "and (rhtype = 'HF' or rhtype='RoHS') ";
			}else{
				$searchand .= "and rhtype = '$top_rhtype' ";
			}
		}
		$opt_shand =$searchand;
		if ($sel_nation){
			$searchand .= "and (nation = '".$sel_nation."' or dosi='".$sel_nation."')  ";
			
		}
		if($sel_manufacturer){
			$searchand .= "and manufacturer = '".$sel_manufacturer."'";
		}
	   	echo GET_MAIN_LIST("N", $part_type, $page, $searchand,$area);
   break;
   case "impship":
    fnImpship($rel_idx,$idx);
   break;
   case "agency":
	   fnAgency($rel_idx,$idx);
   break;
   case "partlist":
   	   fnPartList($page,$part_type,$part_no);
   break;
   case "recordlist":
   	   fnRecordList($odr_type, $part_no,$yr,$mon,$this_mem_idx,$page);
   break;
   case "sideodrlist":
	   fnSideodrlist($odr_type, $this_mem_idx);
   break;
   case "orderlist":
	   fnOdrlist($odr_type, $this_mem_idx);
   break;
   case "remitlist":
   	   fnRemitList($yr,$mon,$remit_ty,$page);
   break;

   case "SD":  //select Deposit 여부
	   	$cnt = QRY_CNT("mybank", "and charge_type = 8 and (mem_idx = $session_mem_idx or rel_idx = $session_mem_idx)");
		echo $cnt == 0 ? "N" : "Y";
   break;
   case "GDA": //get delivery addr
		echo GET_CHG_ODR_DELIVERY_ADDR($actidx,$loadpage,$odr_idx);
   break;
   case "mem":
	   $mem_type = replace_in($mem_type);
	   fnSelMem($rel_idx, $mem_type, $idx);
	   break;
   case "PR":
	   fnProcReady($actidx);
	   break;
   case "CS":
	   update_val("fty_history","confirm_yn","Y", "fty_history_idx", $actidx);
	   $odr_idx = get_any("fty_history","odr_idx", "fty_history_idx = $actidx");
	   update_val("odr","complete_yn","Y", "odr_idx", $actidx);
	   break;
   case "RM":		//-------- 발주창 데이터 삭제(납기 확인중인건 제외) ----------------------------
	    //$imsi_odr_no =  "IM-$actidx-".$_SESSION["MEM_IDX"];
	    $imsi_odr_no = $actidx;
		$odr_status = $odrstat;//ajax로 넘겨 받으려 함
		if ($imsi_odr_no){
			if($odr_status==16){ //2016-03-25:납기확인된 창에서 추가했던 품목 삭제..
				$sql = "delete from odr_det where odr_idx in (SELECT odr_idx FROM `odr` WHERE imsi_odr_no = '$imsi_odr_no' ) and amend_yn = 'Y' ";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			}
			//공통적으로 Stock 품목 삭제
			$sql = "delete from odr_det where odr_idx in (SELECT odr_idx FROM `odr` WHERE imsi_odr_no = '$imsi_odr_no') and part_type not in (2,5,6)";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			if (QRY_CNT("odr_det", "and odr_idx = (SELECT odr_idx FROM `odr` WHERE imsi_odr_no = '$imsi_odr_no')")==0){
				$sql = "delete from ship where ship_idx in (select ship_idx from odr where imsi_odr_no = '$imsi_odr_no')";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
				$sql = "delete from odr where imsi_odr_no = '$imsi_odr_no'";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			}		
		}
	   break;	
	case "RMA":	    
	    $odr_idx = $actidx;
		if ($odr_idx){
			$sql = "delete from odr_det where odr_idx = $odr_idx and amend_yn ='Y'";
			//echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}
	   break;	
	case "RMS": //Save Data 중 '납기' 품목 제외한 amend Data 모두 삭제 2016-04-03
	    $odr_idx = $actidx;
		if ($odr_idx){
			$sql = "delete from odr_det where odr_idx = $odr_idx and amend_yn ='Y' AND part_type NOT IN(2,5,6)";
			echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}
	   break;
   case "RT" : //received test parts 테스트 물품 수령처리
	  $fty_his = get_fty_history($actidx);
      update_val("fty_history","confirm_yn","Y", "fty_history_idx", $actidx);
	  $parts_mem_idx = get_any("member", "min(mem_idx)", "mem_type = 0");
	  $sql = "insert into fty_history set 
				odr_idx		= '".$fty_his[odr_idx]."'
				,odr_det_idx = '".$fty_his[odr_det_idx]."'
				,status = 28
				,status_name = '수령'
				,etc1 = 'Testing'
				,confirm_yn = 'N'
				,reason_ty = '6'
				,sell_mem_idx = '".$fty_his[sell_mem_idx]."'
				,buy_mem_idx = '".$fty_his[buy_mem_idx]."'
				,reg_mem_idx = '$parts_mem_idx'   
				,reg_date = now()";
//		echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		break;
   case "IM":
	   $sql = "insert into mybank (mem_idx, rel_idx, charge_type, charge_amt, charge_method, odr_idx, odr_det_idx,  memo, reg_date, reg_ip)
				select $mem_idx, $rel_idx , charge_type, -1*charge_amt, charge_method, odr_idx, odr_det_idx, memo, now(), reg_ip from mybank where odr_idx = $actidx and odr_det_idx = $actkind";
	   $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	   update_val("odr","odr_status","30", "odr_idx", $actidx);
	   update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $actidx);	
	   $sql = "update fty_history set confirm_yn  = 'Y' where odr_idx = $actidx and odr_det_idx = $actkind and confirm_yn = 'N'";
	   $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	   $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $actidx");
	   $sql = "insert into fty_history set 
				odr_idx		= '$actidx'
				,odr_det_idx = '$actkind'
				,status = 30
				,status_name = '완료'
				,etc1 = ''
				,confirm_yn = 'N'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
//		echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());


	   break;
   case "CF":
	   //구매자가 수령했다는 내용을 판매자가 확인 하고, 완료 버튼을 눌렀을 때.
       // 또는 삭제/ 취소후 완료 버튼을 눌렀을 때 actidx = odr_history_idx
	   //1. odr_status 변경 : 종료로.
	   $odr_idx = get_any("odr_history" , "odr_idx", "odr_history_idx= $actidx");
   	   $odr_det_idx = get_any("odr_history" , "odr_idx", "odr_history_idx= $actidx");
	   $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
	   $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
	   $part_idx = get_any("odr_det", "part_idx" , "odr_det_idx = $actidx");

	   update_val("odr_history","confirm_yn","Y", "odr_history_idx", $actidx);

	   $sql = "insert into odr_history set 
				odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,status = 15
				,status_name = '완료'
				,etc1 = ''
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,confirm_yn = 'Y'
				,reg_date = now()";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

		$det_cnt = QRY_CNT("odr_det", "and odr_idx= $odr_idx");
		$end_cnt = QRY_CNT("odr_history", "and odr_idx= $odr_idx and status=15");
		if ($det_cnt == $end_cnt ) { //전체 일경우.
		   update_val("odr","odr_status","15", "odr_idx", $odr_idx);
		   update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $odr_idx);	   
		   update_val("odr","complete_yn","Y", "odr_idx", $odr_idx);	   
		}

		//판매자가 취소할때만 주문이 한 건도 없을때 파트 삭제 2016-12-12 박정권						
/*
		if ($buy_mem_idx == $_SESSION["MEM_IDX"])
		{			
			$odr_cnt_check = QRY_CNT("odr_det","and part_idx ='".$part_idx."' and odr_idx <> ".$odr_idx." and (odr_status <> 0 and odr_status <> 99)") ;

			if ($odr_cnt_check == "0")
			{	
				$sql = "delete from part where part_idx ='".$part_idx."' ";					

				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			}
		}		
*/		
		break;
	//-- 종료 및 입금 처리 : 구매자가 수령했다는 내용을 판매자가 확인 하고, 완료 버튼을 눌렀을 때 ----------------------------------------
   case "CF2": 
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$buy_rel_idx = get_any("odr", "rel_idx" , "odr_idx = $odr_idx");
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$sell_rel_idx = get_any("odr", "sell_rel_idx" , "odr_idx = $odr_idx");
		$pay_amt = 0;
		$mybank_hold = 0;
		$data = array();  //json

		//1. history insert : odr_det_idx '0' 인것은 odr 전체다 -------------------------
		$sql = "insert into odr_history set 
				odr_idx = '$odr_idx' ";
				if($odr_det_idx > 0){
					$sql .= ",odr_det_idx = '$odr_det_idx' ";
				}
		$sql .= ",status = 15
				,status_name = '종료'
				,etc1 = ''
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,confirm_yn = 'Y'
				,reg_date = now()";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		
		//2016-11-13 : 완료 처리(det 전체 일 경우)
		if ($odr_det_idx<1) { //전체 일경우.
			$sql = "UPDATE odr SET odr_status='15', status_edit_mem_idx=$session_mem_idx, complete_yn='Y'
						WHERE odr_idx=$odr_idx";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}

		//2. 이전단계 history '읽음' 처리 --------------------------------
		$sql = "UPDATE odr_history SET confirm_yn='Y' WHERE odr_idx=$odr_idx AND status=6 AND confirm_yn='N'";
		if($odr_det_idx > 0){$sql .= " AND odr_det_idx=$odr_det_idx";}
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

		//3. fault가 아닌경우(정상거래) 입금 처리 -----------------
		//2016-05-23 : fault 중- 수량부족(추가선적), 거절(교환)도 입금처리 필요하다. 처리하자...
		$fault_yn = get_any("odr_history", "fault_yn" , "odr_idx = $odr_idx AND odr_det_idx=$odr_det_idx AND status=6");
		$fault_select = get_any("odr_history", "fault_select" , "odr_idx = $odr_idx AND odr_det_idx=$odr_det_idx AND status=6");
		if($fault_yn != 'Y' || ($fault_yn == 'Y' && ($fault_select == '1' || $fault_select == '3'))){
			//3-1. 합계금액 계산
			//2016-05-23 : fault 의경우, fault_quantity 와 금액을 곱해야 한다. => 이나다, fault가 해결이 되야(환불이 아닌경우) 본 주문수량금액 전체가 입금된다.
			if($odr_det_idx > 0){ //det 단위 -----
				$pay_amt += get_any("odr_det", "odr_price * supply_quantity" , "odr_det_idx = $odr_det_idx");
			}else{ //----------------- odr 단위 -----
				$sql = "SELECT (odr_price * supply_quantity) AS amt FROM odr_det WHERE odr_idx = $odr_idx";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
				while($row = mysql_fetch_array($result)){
					$pay_amt += $row["amt"];
				} //end while
				
				$vat_price = get_any("ship" ,"tax", "odr_idx=$odr_idx ");	//부가세
				$vat_plus =  number_format($pay_amt*($vat_price/100));
				$pay_amt = $pay_amt + $vat_plus;			
 
			}
			//3-1. 판매자 MyBank 적립 ---------------------------------------------
			$sql = "insert into mybank set
					mem_idx = '$sell_mem_idx'
					,rel_idx = '$sell_rel_idx'
					,mybank_yn = 'Y'
					,charge_type = '4'
					,charge_amt = '$pay_amt'
					,mybank_hold = '0'
					,invoice_no = '$invoice_no'
					,charge_method = '0'
					,odr_idx = '$odr_idx'";
					if($odr_det_idx > 0){
						$sql .= ",odr_det_idx = '$odr_det_idx' ";
					}
			$sql .= ",reg_date = now()
					,reg_ip= '$log_ip'";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			$sell_bank_idx=mysql_insert_id();
			//bank, hold 합계 Update
			update_val("mybank","mybank_amt", SumMyBank2($sell_mem_idx, $sell_rel_idx, 0), "mybank_idx", $sell_bank_idx);
			update_val("mybank","hold_amt", SumBankHold($sell_mem_idx, $sell_rel_idx, 0), "mybank_idx", $sell_bank_idx);
			//3-2. 구매자 결재 방법이 MyBank 라면 예치금 차감
			$charge_method = get_any("mybank", "charge_method" , "mem_idx=$buy_mem_idx AND mybank_yn='N' AND charge_type=3 AND odr_idx=$odr_idx");
			if($charge_method == 'MyBank'){
				//3-2. 구매자 예치금 차감 ------------------------------------------------
				$sql = "insert into mybank set
						mem_idx = '$buy_mem_idx'
						,rel_idx = '$buy_rel_idx'
						,mybank_yn = 'Y'
						,charge_type = '3'
						,charge_amt = 0
						,mybank_hold = '-$pay_amt'
						,invoice_no = '$invoice_no'
						,charge_method = '0'
						,odr_idx = '$odr_idx'";
						if($odr_det_idx > 0){
							$sql .= ",odr_det_idx = '$odr_det_idx' ";
						}
				$sql .= ",reg_date = now()
						,reg_ip= '$log_ip'";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
				$buy_bank_idx=mysql_insert_id();
				//bank, hold 합계 Update
				update_val("mybank","mybank_amt", SumMyBank2($buy_mem_idx, $buy_rel_idx, 0), "mybank_idx", $buy_bank_idx);
				update_val("mybank","hold_amt", SumBankHold($buy_mem_idx, $buy_rel_idx, 0), "mybank_idx", $buy_bank_idx);
			}
		}
		$data["pay_amt"] = $pay_amt;
		//4. 지속적...(3주이상) 일경우, 판매자 보증금 반환
		if(QRY_CNT("odr_det", "and odr_idx = $odr_idx AND part_type='2'")>0){	//지속적.. 있다.
			if(QRY_CNT("odr_history", "and odr_idx=$odr_idx AND reg_mem_idx=$sell_mem_idx AND status=5 AND charge_ty='D'") > 0){	//계약금 결제 이력
				$charge_method = get_any("mybank", "charge_method",	"mybank_yn='N' AND odr_idx=$odr_idx AND mem_idx=$sell_mem_idx AND charge_type=2");//결재수단
				$charge_amt =		get_any("mybank","charge_amt",			"mybank_yn='N' AND odr_idx=$odr_idx AND mem_idx=$sell_mem_idx AND charge_type=2");//결재금액
				$mybank_hold = ($charge_method == "MyBank")? $charge_amt:0;
				$sql = "insert into mybank set
						mem_idx = '$sell_mem_idx'
						,rel_idx = '$sell_rel_idx'
						,mybank_yn = 'Y'
						,charge_type = '6'
						,charge_amt = -'$charge_amt'
						,mybank_hold = $mybank_hold
						,invoice_no = '$invoice_no'
						,charge_method = '0'
						,odr_idx = '$odr_idx'
						,reg_date = now()
						,reg_ip= '$log_ip'";
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
				$sell_bank_idx2=mysql_insert_id();
				//bank, hold 합계 Update
				update_val("mybank","mybank_amt", SumMyBank2($sell_mem_idx, $sell_rel_idx, 0), "mybank_idx", $sell_bank_idx2);
				update_val("mybank","hold_amt", SumBankHold($sell_mem_idx, $sell_rel_idx, 0), "mybank_idx", $sell_bank_idx2);
				$data["mybank_hold"] = $mybank_hold;
			}
		}
		//5. 결과전송 -----------------------------------------------------
		if($result){
			$data["err"] = "OK";
		}else{
			$data["err"] = $result;
		}
		//json
		$output = json_encode($data);
		echo $output;
		break;
	/**********************************************************************************************************************
	*** 환불(구매자 화면) 완료 처리
	*** 2016-06-01 : 구매자 환불처리(충전) 해주고, history '종료' 처리
	**********************************************************************************************************************/
	case "RCF":
		$buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $odr_idx");
		$buy_rel_idx = get_any("odr", "rel_idx" , "odr_idx = $odr_idx");
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
		$sell_rel_idx = get_any("odr", "sell_rel_idx" , "odr_idx = $odr_idx");
		$refund_invoice = get_any("odr_det", "refund_invoice" , "odr_det_idx = $odr_det_idx");
		$pay_amt = get_any("odr_det", "odr_price * supply_quantity" , "odr_det_idx = $odr_det_idx");
		$fault_amt = get_any("odr_det", "odr_price * fault_quantity" , "odr_det_idx = $odr_det_idx");
		$data = array();  //json
		//1. 환불 처리(구매자 충전)--------------------------------------------------------
		$sql = "insert into mybank set
				mem_idx = '$buy_mem_idx'
				,rel_idx = '$buy_rel_idx'
				,mybank_yn = 'Y'
				,charge_type = '10'
				,charge_amt = '$fault_amt'
				,invoice_no = '$refund_invoice'
				,charge_method = '0'
				,odr_idx = '$odr_idx'
				,odr_det_idx = '$odr_det_idx'
				,reg_date = now()
				,reg_ip= '$log_ip'";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$buy_bank_idx=mysql_insert_id();
		//bank, hold 합계 Update
		update_val("mybank","mybank_amt", SumMyBank2($buy_mem_idx, $buy_rel_idx, 0), "mybank_idx", $buy_bank_idx);
		update_val("mybank","hold_amt", SumBankHold($buy_mem_idx, $buy_rel_idx, 0), "mybank_idx", $buy_bank_idx);
		//2. Hitory 처리 : 추가로 '종료(15)' 처리 할지는 추후 결정. - 2016-06-01
		update_val("odr_history","confirm_yn","Y", "odr_history_idx", $actidx);
		//3. 구매자 MyBank 로 구매 시 예치금 '차감' 처리
		$charge_method = get_any("mybank", "charge_method" , "mem_idx=$buy_mem_idx AND mybank_yn='N' AND charge_type=3 AND odr_idx=$odr_idx");
		if($charge_method == 'MyBank'){
			$sql = "insert into mybank set
					mem_idx = '$buy_mem_idx'
					,rel_idx = '$buy_rel_idx'
					,mybank_yn = 'Y'
					,charge_type = '3'
					,charge_amt = 0
					,mybank_hold = '-$pay_amt'
					,invoice_no = '$invoice_no'
					,charge_method = '0'
					,odr_idx = '$odr_idx'
					,odr_det_idx = '$odr_det_idx'
					,reg_date = now()
					,reg_ip= '$log_ip'";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			$buy_bank_idx=mysql_insert_id();
			//bank, hold 합계 Update
			update_val("mybank","mybank_amt", SumMyBank2($buy_mem_idx, $buy_rel_idx, 0), "mybank_idx", $buy_bank_idx);
			update_val("mybank","hold_amt", SumBankHold($buy_mem_idx, $buy_rel_idx, 0), "mybank_idx", $buy_bank_idx);
		}
		//4. 결과전송 -----------------------------------------------------
		if($result){
			$data["err"] = "OK";
		}else{
			$data["err"] = $result;
		}
		$data["pay_amt"] = $fault_amt;
		//json
		$output = json_encode($data);
		echo $output;
	break;
	//--- CF only   정상 종료가 아닌 경우에는 (환불) 모든 것을 다 처리 하고 종료 할때에는 confirm_yn 만 y로 변경해준다.
	case "CFO": 
		update_val("odr_history","confirm_yn","Y", "odr_history_idx", $actidx);
	break;
	case "DP": 
		// 첫 지연 처리	   
		$period = $actkind;
		if ($period==""){
			$period ="1";
			$status = "20";    //첫 지연은 1week 자동 : 상태값 "지연"
		}else{
			//한번 이상 지연
			$status = "4";     // 기간을 선택한 지연 : 상태값 "납기 연장"
		}
		//기존에 자동 지연 한 내역이 있으면 확인 처리
		$sql = "update odr_history set confirm_yn = 'Y' where odr_idx = $actidx and status in ('20','4') and confirm_yn = 'N'";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	    $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $actidx");
	    update_val("odr","odr_status",$status, "odr_idx", $actidx);	  
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $actidx);	   
	    $sql = "insert into odr_history set 
				odr_idx = '$actidx'
				,status = $status
				,status_name = '지연'
				,etc1 = '".$period."WK'
				,sell_mem_idx = '$session_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
//		 echo $sql;
		 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		 break;
   case "DLP":  //------------- 납기 품목 '삭제' 처리(구매자:발주서 창) ------------------------------------------------
		 //2016-04-04 : 저장 창에서 삭제할 경우
		 $save_yn = get_any("odr", "save_yn" , "odr_idx = $actidx");
		 if($save_yn == "Y"){
			 //저장꺼의 rel_det_idx를 가져와서
			 $rel_det_idx = get_any("odr_det", "rel_det_idx" , "odr_det_idx = $det_idx");
			 //해당 det의 odr idx와 odr_det idx 가져오자
			 $actidx = get_any("odr_det", "odr_idx" , "odr_det_idx = $rel_det_idx");
			 $det_idx = $rel_det_idx;
		 }
	     update_val("odr","odr_status","7", "odr_idx", $actidx); //odr 테이블 상태
		 if($det_idx) update_val("odr_det","odr_status","7", "odr_det_idx", $det_idx);
	     update_val("odr","imsi_odr_no","", "odr_idx", $actidx);
		 update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $actidx);	   
	     update_val("odr_history","confirm_yn","Y", "odr_idx", $actidx);
		 $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $actidx");
		 $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $actidx");
		 $reason_ty = $buy_mem_idx == $session_mem_idx? "3" : "2";
		 $sql = "insert into odr_history set 
				odr_idx = '$actidx'
				,status = '7'
				,status_name = '삭제'
				,etc1 = '종료'
				,reason = '$actkind'
				,reason_ty = '$reason_ty'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		 //저장 Data에서 삭제 할 경우(정상루트건 삭제)
		 /**
		 if($save_yn =="Y"){
			 $result = DEL_ORIGIN_PERIOD($actkind); // /sql/sql.odr.php
		 }**/
		 //저장 Data에 해당 품목이 있다면 삭제
		 $sql = "DELETE FROM odr_det WHERE rel_det_idx = $det_idx";
		 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	   break;
    case "DLP2":  //------------- 납기 품목 '삭제' 처리(판매자 - 납기답변 창에서) ------------------------------------------------
		 //판매자 삭제의 경우(납기 답변 창에서) 2016-04-07
		 $det_idx = get_any("odr_det", "odr_det_idx" , "odr_idx = $actidx");
		 $part_idx = get_any("odr_det", "part_idx" , "odr_det_idx = $det_idx");
		 $saved_odr_idx = get_any("odr a INNER JOIN odr_det b on(a.odr_idx=b.odr_idx)", "a.odr_idx" , "b.rel_det_idx = $det_idx AND a.save_yn='Y'");
	     update_val("odr","odr_status","7", "odr_idx", $actidx); //odr 테이블 상태
		 if($det_idx) update_val("odr_det","odr_status","7", "odr_det_idx", $det_idx);
	     update_val("odr","imsi_odr_no","", "odr_idx", $actidx);
		 update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $actidx);	   
	     update_val("odr_history","confirm_yn","Y", "odr_idx", $actidx);
		 $buy_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $actidx");
		 $sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $actidx");
		 $reason_ty = $buy_mem_idx == $session_mem_idx? "3" : "2";
		 $sql = "insert into odr_history set 
				odr_idx = '$actidx'
				,status = '7'
				,status_name = '삭제'
				,etc1 = '종료'
				,reason = '$actkind'
				,reason_ty = '$reason_ty'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		 //저장 데이터와 저장 odr 체크
		 if($saved_odr_idx){
			 //저장 Data에 해당 품목이 있다면 삭제
			 $sql = "DELETE FROM odr_det WHERE rel_det_idx = $det_idx AND odr_idx = $saved_odr_idx";
			 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			 $save_cnt = QRY_CNT("odr_det", "odr_idx = $saved_odr_idx");
			 if($save_cnt<1){
				 $sql = "DELETE FROM odr WHERE odr_idx = $saved_odr_idx";
				 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
				 $sql = "DELETE FROM ship WHERE odr_idx = $saved_odr_idx";
				 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			 }
		 }
		 //part 테이블 품목 삭제 처리
		 update_val("part","del_yn","Y", "part_idx", $part_idx);
	   break;
	case "DA":	//-------------------------------------------------------------------------------
		update_val("odr_history","fault_select","Y", "odr_history_idx", $actidx);	  
		$odr_idx = get_any("odr_history", "odr_idx" , "odr_history_idx = $actidx");
		update_val("odr","accept_yn","Y", "odr_idx", $odr_idx);	  
		break;
	case "UO":
		$sql = "update ship set 
			ship_info = '$ship_info'
			,ship_account_no = '$ship_account_no'
			,insur_yn = '$insur_yn'
			,memo = '$actkind'
			where odr_idx = $actidx and ship_type='1'
			";
			//echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		break;
	case "UQ":	//[발주서]창에서 '발주서 확인' 버튼
		//수정 발주서
		/*2016-12-06 : 수정발주서의 재고 계산을 여기서 않고, 서류 확인 후 계산 - ccolle
		if($amd_yn == "Y"){
			$part_idx = get_any("odr_det", "part_idx", " odr_det_idx = $actidx");
			$old_odr = get_any("odr_det", "odr_quantity", " odr_det_idx = $actidx");			
			//$up_stock = $quantity  - $actkind; //재고수랑 계산	
			$up_stock = ($quantity + $old_odr) - $actkind; //재고수랑 계산
			//재고수량 Update
			update_val("part","quantity", $up_stock, "part_idx", $part_idx);
		}
		*/
		$actkind = str_replace(",","",$actkind);
		$sql = "update odr_det set 
				odr_quantity = '$actkind' 
				where odr_det_idx =$actidx";
		//		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		break;
	case "UAQ":
		if ($actkind > 0){
			if(get_any("odr_det", "add_quantity", " odr_idx = $actidx and part_type =2") == ""){
				$sql = "update odr_det set 
						add_quantity = '$actkind'  , odr_quantity = odr_quantity + $actkind , supply_quantity =  supply_quantity + $actkind 
						where odr_idx =$actidx and part_type =2";
				//		echo $sql;
				$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			}
		}
		break;
	case "CO":
		update_val("odr","odr_status","8", "odr_idx", $actidx);
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $actidx);	   
		if ($actkind=="1"){
			$reason = "납기 기한을 지키지 않아 취소";
		}
		update_val("odr","accept_yn","N", "odr_idx", $actidx);	  
		$sql = "update odr_history set  fault_select ='N' where odr_idx = $actidx and confirm_yn = 'N' and status = '4' ";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$sql = "update odr_history set confirm_yn = 'Y' where odr_idx = $actidx and confirm_yn = 'N'";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $actidx");
		 $sql = "insert into odr_history set 
				odr_idx = '$actidx'
				,status = '8'
				,status_name = '취소'
				,etc1 = '종료'
				,reason = '$reason'
				,reason_ty = '$actkind'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$session_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
//		 echo $sql;
		 $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		break;

	case "AC": //accept cancel
		$sql = "update odr set cancel_accept_yn ='Y' where odr_idx = $actidx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$sql = "update odr_history set  fault_select ='Y' where odr_idx = $actidx and status = '8' ";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		break;
	case "GAC" : //get appintment carrier
		$ext_clause = "rel_idx = (SELECT case when sell_rel_idx = 0 then sell_mem_idx else sell_rel_idx end as com_idx FROM `odr` WHERE odr_idx =$actidx) and assign_type = 1";
		if ($actkind =="CH"){
			$assign = get_any("assign", "o_company_idx", $ext_clause);
			if ($assign){
				echo strtolower(GF_Common_GetSingleList("DLVR",$assign));
			}
		}else{
			$sql = "update assign set o_company_idx = '' where $ext_clause"; 
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}
		break;
	case "AR" : //appointment reg
			$rel_idx = get_any("odr", "case when sell_rel_idx = 0 then sell_mem_idx else sell_rel_idx end ","odr_idx = $actkind");
			$ass1_idx = get_any("assign", "assign_idx", "rel_idx=$rel_idx and assign_type = 1");
			
			if ($ass1_idx){ // update
				$sql = "update assign 
						set o_company_idx = $actidx						
						where assign_idx = $ass1_idx";
			}else{ 
				 //insert
				$sql = "insert into assign(rel_idx , assign_type ,  o_company_idx,  i_company_idx,  sort, reg_date )  
				values($rel_idx, 1 ,'$actidx' , '' ,  1 , now())";	
			}		
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	break;
	case "RS" : //reg impship				
		if (QRY_CNT("impship", "and rel_idx = $com_idx and company_idx = $actidx")==0){
			 //insert
			$sql = "insert into impship(rel_idx , company_idx, account_no ,sort)  
			values($com_idx, $actidx ,'$actkind' ,0)";	
			
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		}
	break;

	case "UA" : // update account no , ship_info
		$odr =get_odr($odr_idx);
		$ship_idx = $odr[ship_idx];
		$sql = "update ship set ship_account_no = '$account_no', ship_info = '$ship_info' where ship_idx = $ship_idx";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	break;

	case "VSB":
		echo GET_WhatsNew($actidx,$actkind);
	break;
	case "RP": //return pay
		$tot_amt = get_any("mybank" , "abs(charge_amt)" ,"mem_idx = $session_mem_idx and odr_idx = $actidx and  charge_type = 2");
		
	     //구매자가 이 함수를 호출함.
		// 1. mybank insert    //결제 관련 계약금 환불시 먼저 구매자의 계약금을 되찾아 오고, 판매자의 계약금도 받아야한다. 
		//먼저 구매자 지불 charget_type = '6' 은 계약금 환불
		$sql = "insert into mybank set
				mem_idx = '$session_mem_idx'
				,rel_idx = '$session_rel_idx'
				,charge_type = '6'
				,charge_amt = '$tot_amt'
				,charge_method = 'MyBank'
				,memo = '구매시 본인의 계약금 환불'
				,odr_idx = '$actidx'
				,reg_date = now()
				,reg_ip= '$log_ip'";
	//	echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
		// 판매자 계약금도 가져오기 charget_type = '6' 은 계약금 환불
		$sql = "insert into mybank set
				mem_idx = '$session_mem_idx'
				,rel_idx = '$session_rel_idx'
				,charge_type = '7'
				,charge_amt = '$tot_amt'
				,charge_method = 'MyBank'
				,memo = '판매자의 계약금 회수'
				,odr_idx = '$actidx'
				,reg_date = now()
				,reg_ip= '$log_ip'";
	//	echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
		//2. odr_status 변경
		update_val("odr","odr_status","15", "odr_idx", $actidx);
		update_val("odr","status_edit_mem_idx",$session_mem_idx, "odr_idx", $actidx);	
		//3. histoy update(취소를 확인 한 상태로 update : 계약금을 제대로 환불 받음을 뜻함)
		$odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $actidx and status = 8");
		update_val("odr_history","confirm_yn","Y", "odr_history_idx", $odr_history_idx);
		//4. 종료 처리
		$sell_mem_idx = get_any("odr", "mem_idx" , "odr_idx = $actidx");
		$sql = "insert into odr_history set 
						odr_idx = '$actidx'
						,status = 15
						,status_name = '완료'
						,etc1 = ''
						,sell_mem_idx = '$sell_mem_idx'
						,buy_mem_idx = '$session_mem_idx'
						,reg_mem_idx = '$session_mem_idx'
						,reg_date = now()";
				//echo $sql;
				$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		break;		
   case "EP" : //RnD 후 종료 프로세스 #########################################################################################################################
  	$winner = $testresult=="F"? "B":"S";
	$fty_his = get_fty_history($actidx);
	//$tTy : 지금 접속한 접속자. S: seller, B : buyer
	if($tTy =="S"){	//------------------------------------------------------------ 판매자 단 ------------------------
		//buyer가 지불 했던 위로금 만큼을 나한테 충전해주고.
		//$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=11 and mem_idx=".$fty_his[buy_mem_idx]);		
		$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and mem_idx=".$fty_his[buy_mem_idx]);	//구매자가 지불한 비용
		$mybank = get_mybank($mybank_idx);
		$mem_idx = $fty_his[sell_mem_idx];
		$rel_idx = get_any("member", "rel_idx", "mem_idx = $mem_idx");
		//금액 계산 : 구매자 지불 비용에서 '테스트의뢰'비용 $1,000 뺌
		$charge_amt = -($mybank[charge_amt]) - 1000;
		if ($winner == "S") { //내가(판매자) 승 ---------<<
			$sql = "insert into mybank set
			mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '11'
			,mybank_yn = 'Y'
			,charge_amt = '$charge_amt'
			,odr_idx = '".$mybank[odr_idx]."'
			,odr_det_idx = '".$mybank[odr_det_idx]."'
			,fty_history_idx = '".$fty_his[fty_history_idx]."'
			,reg_date = now()
			,reg_ip= '$log_ip'";
			//	echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
			$new_idx=mysql_insert_id(); 
			//$sql = "update mybank set charge_amt = charge_amt * -1 where mybank_idx =$new_idx";
			//$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		

			//내가(seller) 지불했던 부대 비용들을 다시 충전 해줌.
			$sql = "insert into mybank (mem_idx, rel_idx, charge_type, charge_amt, mybank_yn, odr_idx, odr_det_idx, fty_history_idx,  memo, reg_date, reg_ip)
				select $mem_idx, $rel_idx , '16', -1*charge_amt, 'Y', odr_idx, odr_det_idx, ".$fty_his[fty_history_idx].", memo, now(), reg_ip from mybank where odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and mem_idx=".$fty_his[sell_mem_idx];
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}else{	//내가(판매자) 패 ----------------<<
			//seller의 운임료를 차감.
			$mem_idx = $fty_his[seller_mem_idx];
			$rel_idx = get_any("member", "rel_idx", "mem_idx = $mem_idx");
			//운임료 차감
			/** 2016-11-03
			$sql = "insert into mybank set
			mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '15'
			,charge_amt = '-".$actkind."'
			,charge_method = 'MyBank'
			,odr_idx = '".$mybank[odr_idx]."'
			,odr_det_idx = '".$mybank[odr_det_idx]."'
			,reg_date = now()
			,reg_ip= '$log_ip'";
			//	echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			**/
		}
		$my_idx = get_any("mybank", "mybank_idx ", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and charge_amt<0 and mem_idx=$mem_idx ");
	}else{	//----------------------------------------------- 구매자 단 --------------------------------------
		//우선, 보상금(부대비용) 챙기고..
		//$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=13 and mem_idx=".$fty_his[sell_mem_idx]); //JSJ
		$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and mem_idx=".$fty_his[sell_mem_idx]);
		$mybank = get_mybank($mybank_idx);
		$mem_idx = $fty_his[buy_mem_idx];
		$rel_idx = get_any("member", "rel_idx", "mem_idx = $mem_idx");
		//금액 계산 : 구매자 지불 비용에서 '테스트의뢰'비용 $1,000 뺌
		$charge_amt = -($mybank[charge_amt]) - 1000;
		if ($winner == "B") {	//내가(구매자) 승 -----------<<
			$sql = "insert into mybank set
			mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '13'
			,mybank_yn = 'Y'
			,charge_amt = '$charge_amt'
			,odr_idx = '".$mybank[odr_idx]."'
			,odr_det_idx = '".$mybank[odr_det_idx]."'
			,fty_history_idx = '".$fty_his[fty_history_idx]."'
			,reg_date = now()
			,reg_ip= '$log_ip'";
			//	echo $sql."<BR>";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
			$new_idx=mysql_insert_id(); 
			//-값이 한번에 안들어가길래 insert후 -를 업데이트함.JSJ
			//$sql = "update mybank set charge_amt = charge_amt * -1 where mybank_idx =$new_idx";
			//$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			//테스트결과 보상
			$sql = "insert into mybank (mem_idx, rel_idx, charge_type, charge_amt, charge_method, odr_idx, odr_det_idx, fty_history_idx, memo, reg_date, reg_ip)
				select $mem_idx, $rel_idx , '16', -1*charge_amt, 'MyBank', odr_idx, odr_det_idx, ".$fty_his[fty_history_idx].", memo, now(), reg_ip from mybank where odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=11 and mem_idx=".$fty_his[buy_mem_idx];
				//echo $sql."<BR>";
				//exit;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}else{	//내가(구매자) 패 -----------<<
			//운임료 차감 : 테스트 위해 본사(파츠)로 보낸 운송료(파츠에서 착불로 지불된 금액)
		}
		$my_idx = get_any("mybank", "mybank_idx ", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and charge_amt<0 and mem_idx=$mem_idx ");
	//	echo "!!!!!!!!!!!!odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=11 and charge_amt<0 !!!!!!!!!";
	}

	//1. mybank update
	update_val("mybank","chk","Y", "mybank_idx", $my_idx);
//	echo $my_idx."~~~~~~~~~";
	//if (QRY_CNT("mybank","and odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type in(11,13) and charge_amt<0 and chk='Y'")=="2"){ //2016-11-02
	if (QRY_CNT("mybank","and odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type ='12' and charge_amt<0 and chk='Y'")=="2"){
		$sql = "update fty_history set confirm_yn='Y' where fty_history_idx=$actidx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	}
   break;

   case "MRO" :   //Move To Real Order (임시 order에서 real order로 발주 들어가는 과정 ----------------------------------- MRO(실 발주) --------------------------------------------------/
	// $actidx : odr_idx, $actkind : odr_det_idx
	$remain_cnt = QRY_CNT("odr_det", "and odr_idx = $actidx and odr_det_idx not in ($actkind)");
	/**재고수량 처리 전에 현, 재고 먼저 체크
	2016-09-13 : 지속적은 안전재고 체크 않함
	2016-11-13 : 턴키도 안전재고 계산에서 제외 **/
	$safe_stock = QRY_CNT_STOCK($actkind);

	if ($delivery_addr_idx == "0" && $delivery_save_yn != "Y")
	{
		$sql = "insert into delivery_addr set 
						mem_idx = '$session_mem_idx'
						,save_yn = 'Y'
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
						,addr_det = '$addr_det'
						,addr = '$addr'
						,reg_date = '$log_date'
						,reg_ip = '$log_ip'
						";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		//echo $sql;
		$delivery_addr_idx_val=mysql_insert_id(); 

		$sql = "update ship set 
			delivery_addr_idx = '$delivery_addr_idx_val'			
			where odr_idx = $actidx and ship_type = '1'
			";
		//	echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}

	if($safe_stock>0){ //-- 재고 부족 -------------------------------------------------
		echo "ERR";
	}else{
		
		//-- 재고수량 처리 2016-04-01--------------------------------------------------
		//-- 2016-09-18 : 지속적....은 재고 없으므로 빼지 않기. 
		$sql = "UPDATE part AS a 
				LEFT JOIN odr_det AS b
				ON(a.part_idx = b.part_idx)
				SET a.quantity = (a.quantity - b.odr_quantity)
				WHERE b.odr_det_idx IN($actkind) AND a.part_type != '2'
				";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		//-- 발주서 처리--------------------------------------------------------------------
		if ($remain_cnt > 0) {   //선택한 발주외에도  임시 발주서에 부품이 남아있다면 
			//선택한 부품들은 새로운 odr_idx를 따서 옮겨야 함.
			$sql = "insert into odr (odr_no, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status , memo, reg_date, reg_ip)
					select '".get_odr_no("PO")."' , mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, 0 , memo, now(), reg_ip from odr where odr_idx = $actidx ";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			$new_odr_idx=mysql_insert_id(); 
			// 선적 정보도 옮김.
			$sql = "insert into ship (ship_type, odr_idx, delivery_addr_idx, ship_info, ship_account_no, insur_yn,memo) 
			select ship_type, '$new_odr_idx', '$delivery_addr_idx_val', ship_info, ship_account_no, insur_yn,memo from ship where odr_idx = $actidx and ship_type=1 ";
			
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$new_ship_idx=mysql_insert_id(); 
			$sql = "update odr set ship_idx = $new_ship_idx where odr_idx = $new_odr_idx";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			//odr_det
			$sql = "update odr_det set odr_idx = $new_odr_idx where odr_det_idx in ($actkind)";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			//odr_history
			$sql = "update odr_history set odr_idx = $new_odr_idx where odr_det_idx in ($actkind)";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			$rtn = $new_odr_idx;
			
		}else{  //선택한 발주가 임시 발주 품목들 전체라면 현재의 odr를 임시가 아닌 진짜 발주서로 update만 하면 됨.
			$sql = "update odr set odr_no = '".get_odr_no("PO")."', imsi_odr_no = '' where odr_idx = $actidx";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			$rtn = $actidx;
			//납기 받은거 history 삭제.
			$sql = "DELETE FROM odr_history WHERE odr_idx = $actidx AND status IN(1,16)";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		} //end of 부분/전체
		//기존 odr_det 에 amend 삭제
		update_val("odr_det","amend_yn","N", "odr_idx", $rtn);	//amend_yn 2016-04-14(수정발주서 에서 닫으면 삭제되서...)

		//-- 저장 Data 중에 납기 받은 품목 발주가 있다면, What's New(정상루트) 품목에서 삭제
		//$_odr = get_odr($actidx);
		//$save_yn = $_odr[save_yn];
		//if($save_yn == "Y"){ //저장 데이터----------------------
			//납기 받은 품목 갯수
			$period_cnt = QRY_CNT("odr_det", "and odr_idx = $actidx and odr_det_idx in ($actkind) AND odr_status=16");
			if($period_cnt>0){ //납기 받은 품목이 있다.
				//정상루트 Data 삭제
				$result = DEL_ORIGIN_PERIOD($actkind); // /sql/sql.odr.php
			}
		//}  //end of 저장 데이터
		echo $rtn;

	} //end of 재고부족
   break;	//------------------------------------------------------------------------- end of MRO --------------------------------------------------------

   case "NORD" :   //2016-03-23 : 납기 품목 있는 발주 창에서 납기 삭제 후, 나머지는 새 발주번호(ord)-------------------------------------
		//선택한 부품들은 새로운 odr_idx를 따서 옮겨야 함.
		$sql = "insert into odr (imsi_odr_no, odr_no, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status , memo, reg_date, reg_ip)
				select 'IM-".date("ymdhms").RndomNum(4)."', odr_no, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, 0 , memo, now(), reg_ip from odr where odr_idx = $actidx ";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$new_odr_idx=mysql_insert_id(); 
		// 선적 정보도 옮김.
		$sql = "insert into ship (ship_type, odr_idx, delivery_addr_idx, ship_info, ship_account_no, insur_yn,memo) 
		select ship_type, '$new_odr_idx', delivery_addr_idx, ship_info, ship_account_no, insur_yn,memo from ship where odr_idx = $actidx and ship_type=1 ";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$new_ship_idx=mysql_insert_id(); 
		
		$sql = "update odr set ship_idx = $new_ship_idx where odr_idx = $new_odr_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		// 품목 정보
		$sql = "INSERT INTO odr_det (odr_idx, part_idx, part_type, odr_quantity, supply_quantity, fault_dc, rnd_yn, period, odr_status)
				SELECT $new_odr_idx, part_idx, part_type, odr_quantity, supply_quantity, fault_dc, rnd_yn, period, odr_status FROM odr_det WHERE odr_idx = $actidx AND odr_status != 7 ORDER BY odr_det_idx ASC ";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		//---- 기존 odr의 odr_det 삭제 ------------------------
		$sql = "DELETE FROM odr_det WHERE odr_idx = $actidx AND odr_status != 7"; //odr 테이블
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

		echo $new_odr_idx;
   break;

   case "POCS" :   //2016-04-13 : 판매자 송장화면(30_08->po_cancel), 구매자 '수정발주서' 에서 선택 품목 취소 **********************************************************************
		//0. 기존 odr 정보 열람
		$odr = get_odr($odr_idx);
		$sell_mem_idx = $odr[sell_mem_idx];
		$buy_mem_idx = $odr[mem_idx];
		//1. 넘어온 odr_det이 전체인지 일부인지 판단하기 위해 각각 갯수 체크
		$odr_det_cnt = QRY_CNT("odr_det", "and odr_idx = $odr_idx");	//기존PO det 갯수
		$del_det_cnt = QRY_CNT("odr_det", "and odr_det_idx IN ($cancel_det_idx)");	//삭제할 det 갯수
		//2. 삭제할게 PO 전체가 아니라면, 신규 odr 생성
		if($odr_det_cnt >$del_det_cnt){ //-- 일부 취소 일경우 -----------------------------------------------------------
			//1. odr 복제
			$sql = "INSERT INTO odr (odr_no, imsi_odr_no, invoice_no, amend_no, amend_date, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status, turnkey_idx, accept_yn, cancel_accept_yn, ship_idx, fault_delivery_no, buyer_delivery_fee, faulty_delivery_fee, memo, save_yn, reg_date, status_edit_mem_idx, complete_yn, reg_ip)
					SELECT odr_no, imsi_odr_no, invoice_no, amend_no, amend_date, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status, turnkey_idx, accept_yn, cancel_accept_yn, ship_idx, fault_delivery_no, buyer_delivery_fee, faulty_delivery_fee, memo, save_yn, reg_date, status_edit_mem_idx, complete_yn, reg_ip FROM odr WHERE odr_idx = $odr_idx
					";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			$del_odr_idx=mysql_insert_id();
			//2. Ship(선적정보) 복제
			$sql = "INSERT INTO ship (ship_type, invoice_no, odr_idx, odr_det_idx, delivery_addr_idx, ship_info, ship_account_no, delivery_no, ship_weight, weight_type, appoint_yn, tax, insur_yn, recv, refer, content, memo, reg_date, reg_ip) 
						SELECT ship_type, invoice_no, $del_odr_idx, odr_det_idx, delivery_addr_idx, ship_info, ship_account_no, delivery_no, ship_weight, weight_type, appoint_yn, tax, insur_yn, recv, refer, content, memo, reg_date, reg_ip FROM ship where odr_idx = $odr_idx ";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$new_ship_idx=mysql_insert_id();
			//3. 기존 history 신규 odr_idx로 전체 복사
			$sql = "INSERT INTO odr_history (odr_idx, odr_det_idx, sell_mem_idx, buy_mem_idx, status, status_name, etc1, etc2, fault_select, charge_ty, reason, reason_ty, return_method, confirm_yn, fault_yn, with_deposit, file1, file2, file3, reg_mem_idx, reg_date)
						SELECT $del_odr_idx, odr_det_idx, sell_mem_idx, buy_mem_idx, status, status_name, etc1, etc2, fault_select, charge_ty, reason, reason_ty, return_method, 'Y', fault_yn, with_deposit, file1, file2, file3, reg_mem_idx, reg_date FROM odr_history WHERE odr_idx = $odr_idx ORDER BY odr_history_idx ASC
						";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			//4. 기존 odr_det 이동(신규 odr로)
			$sql = "UPDATE odr_det SET odr_idx = $del_odr_idx WHERE odr_det_idx IN($cancel_det_idx)";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$up_odr_idx = $del_odr_idx;
		}else{ //-------------------------------- 전체 취소 일경우 --------------------------------------------------------------------------------
			$up_odr_idx = $odr_idx;
			//기존 history 확인처리
			update_val("odr_history","confirm_yn","Y", "odr_idx", $odr_idx);	//상태
		}
		//공통1. odr_det 에 사유 입력 ----------------------------------<<
		for($i=0; $i<count($odr_det_idx); $i++){
			$det_idx = $odr_det_idx[$i];
			$reas = $reason[$i];
			update_val("odr_det","reason","$reas", "odr_det_idx", $det_idx);	//상태
		}
		//공통2. history 생성 ---------------------------------------------<<
		$sql = "insert into odr_history set 
				odr_idx = '$up_odr_idx'
				,status = '8'
				,status_name = '취소'
				,etc1 = '종료'
				,fault_yn = 'Y'
				,sell_mem_idx = '$sell_mem_idx'
				,buy_mem_idx = '$buy_mem_idx'
				,reg_mem_idx = '$session_mem_idx'
				,reg_date = now()";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		//공통 3.odr 상태정보 Update ---------------------------------<<
		update_val("odr","odr_status","8", "odr_idx", $up_odr_idx);	//상태
		update_val("odr","status_edit_mem_idx","$session_mem_idx", "odr_idx", $up_odr_idx);	//상태 update 한 mem_idx
		//판매자 송장(30_08)취소 : 재고삭제 및 취소 카운트 증가 ------------------------------------<<
		if($load_page == "30_08"){	//판매자 '송장'화면에서 취소
			for($i=0; $i<count($odr_det_idx); $i++){
				$det_idx = $odr_det_idx[$i];
				$odr_det = get_odr_det_each($det_idx);
				$part_idx = $odr_det[part_idx];
				update_val("part","quantity", 0, "part_idx", $part_idx);	//재고수량 Update
				update_val("part","del_chk", 0, "part_idx", $part_idx);	//재고수정 Update
			}
		}else{	//그 외 : 구매자 '송장' -> '수정 발주서(09_01)'->'취소'
			for($i=0; $i<count($odr_det_idx); $i++){
				$det_idx = $odr_det_idx[$i];
				$odr_det = get_odr_det_each($det_idx);
				$odr_qty = $odr_det[odr_quantity];
				$supp_qty = $odr_det[supply_quantity];
				$part_idx = $odr_det[part_idx];

				$stock_qty =  get_any("part", "quantity" , "part_idx = $part_idx");
				$add_qty = ($supp_qty>0)? $supp_qty:$odr_qty;
				$up_stock = $stock_qty + $add_qty;
				update_val("part","quantity",$up_stock, "part_idx", $part_idx);	//재고수량 Update
			}
		}

		//창 정리(닫고, 띄우고)
		if($odr_det_cnt >$del_det_cnt){ //-- 일부 취소 일경우 --
			//송장(30_08)로 전환 layer3
			//ReopenLayer("layer3","30_08","?odr_idx=$odr_idx");
			ReopenLayer("layer3",$load_page,"?odr_idx=$odr_idx");
			/**
			closeLayer("layer3");
			closeLayer("layer5");
			closeLayer("layer");
			**/
			Parent_Search_Refresh();
		}else{
			closeLayer("layer3");
			closeLayer("layer5");
			closeLayer("layer");
			Parent_Search_Refresh();
		}

	break;
	case "ODRCP":  //2016-04-22 선택 품목을 가지고 복제 주문 만들기(선적에서.. 선택 '선적')에 이용 --------------------------------------------------------------------------
			//1. odr 복제 ------------------------------------------------
			$sql = "INSERT INTO odr (odr_no, imsi_odr_no, invoice_no, amend_no, amend_date, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status, turnkey_idx, accept_yn, cancel_accept_yn, ship_idx, fault_delivery_no, buyer_delivery_fee, faulty_delivery_fee, memo, save_yn, reg_date, status_edit_mem_idx, complete_yn, reg_ip)
					SELECT odr_no, imsi_odr_no, invoice_no, amend_no, amend_date, mem_idx, rel_idx, sell_mem_idx, sell_rel_idx, period, odr_status, turnkey_idx, accept_yn, cancel_accept_yn, ship_idx, fault_delivery_no, buyer_delivery_fee, faulty_delivery_fee, memo, save_yn, reg_date, status_edit_mem_idx, complete_yn, reg_ip FROM odr WHERE odr_idx = $odr_idx
					";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			$new_odr_idx=mysql_insert_id();
			//2. Ship(선적정보) 복제 ------------------------------------
			$sql = "INSERT INTO ship (ship_type, invoice_no, odr_idx, odr_det_idx, delivery_addr_idx, ship_info, ship_account_no, delivery_no, ship_weight, weight_type, appoint_yn, tax, insur_yn, recv, refer, content, memo, reg_date, reg_ip) 
						SELECT ship_type, invoice_no, $new_odr_idx, odr_det_idx, delivery_addr_idx, ship_info, ship_account_no, delivery_no, ship_weight, weight_type, appoint_yn, tax, insur_yn, recv, refer, content, memo, reg_date, reg_ip FROM ship where odr_idx = $odr_idx ";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$new_ship_idx=mysql_insert_id();
			//3. 기존 history 신규 odr_idx로 전체 복사 -------------
			$sql = "INSERT INTO odr_history (odr_idx, odr_det_idx, sell_mem_idx, buy_mem_idx, status, status_name, etc1, etc2, fault_select, charge_ty, reason, reason_ty, return_method, confirm_yn, fault_yn, with_deposit, file1, file2, file3, reg_mem_idx, reg_date)
						SELECT $new_odr_idx, odr_det_idx, sell_mem_idx, buy_mem_idx, status, status_name, etc1, etc2, fault_select, charge_ty, reason, reason_ty, return_method, 'Y', fault_yn, with_deposit, file1, file2, file3, reg_mem_idx, reg_date FROM odr_history WHERE odr_idx = $odr_idx ORDER BY odr_history_idx ASC
						";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			//echo "$det_idx:".$det_idx."<br>";
			//4. 기존 odr_det 이동(신규 odr로) ----------------------
			$sql = "UPDATE odr_det SET odr_idx = $new_odr_idx WHERE odr_det_idx IN($det_idx)";
			//echo "$sql:".$sql."<br>";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			//5. histoy update(결제확인을 한 상태로 update) - 원본꺼
			/**
			$prev_odr_history_idx = get_any("odr_history" , "odr_history_idx", "odr_idx= $new_odr_idx and status = 5 and confirm_yn = 'N'");
			update_val("odr_history","confirm_yn","Y", "odr_history_idx", $prev_odr_history_idx);
			**/
			//새로만든 idx 반환
			echo $new_odr_idx;
	break;
	case "COMPLE" :   //2016-04-13 : 판매자 송장화면(30_08->po_cancel)에서 선택 품목 취소 --------------------------------------------------------------------------
	break;
    case "mainsrch":	 /******************************** 메인 검색 ***********************************************************************************************/
	$top_qty = str_replace(",","",$top_qty);
	  	if ($top_part_no){$searchand .= "and part_no like '%$top_part_no%' ";}
		if ($top_manufacturer){$searchand .= "and manufacturer like '%$top_manufacturer%' ";}
		
		if ($area=="on"){	// 근접지역 표시
			$searchand .= "and nation = '".$_SESSION["NATION"]."' ";
			$areaonsrch ="and dtl_par_code = '".$_SESSION["NATION"]."' ";
		}

		// 요청수량, 제조년, RoHS, HF 선택 시 - 지속적 공급가능한 Special Price Part는 무조건 검색됨 즉, part_type=2일 때는 이 4개는 검색 필터링 필요 없음.
		if ($top_qty){$searchand_pt1 .= "and quantity >= $top_qty ";}
		if ($dc){$searchand_pt1 .= "and dc >= $dc  ";}
		if ($top_rhtype){
			if ($both == "Y"){
				$searchand_pt1 .= "and (rhtype = 'HF' or rhtype='RoHS') ";
			}else{
				$searchand_pt1 .= "and rhtype = '$top_rhtype' ";
			}
		}

		$opt_shand1 =$searchand.$searchand_pt1;
		$opt_shand2 =$searchand;
		if ($sel_nation){
			$searchand .= "and (nation = '".$sel_nation."' or dosi='".$sel_nation."')  ";
			
		}
		$withoutManuf = $searchand;
		if($sel_manufacturer){			
			$searchand .= "and manufacturer = '".$sel_manufacturer."'";		
		}

		$searchand_basic = $searchand;

	//echo $searchand;
	for ($i = 1; $i<=6; $i++){
		if ($i == 2) { 
			$opt_shand = $opt_shand2;
			$searchand = $searchand_basic;

		}else{
			$opt_shand = $opt_shand1;
			$searchand = $searchand_basic.$searchand_pt1;
		}
		echo GET_MAIN_LIST("Y", $i, 1, $searchand , $area);	//class.partinfo.php
	}
	echo ":::".GET_SEl_BOX("opt1", TRUE, $area=="on"?"City/Province":"Nation", $sel_nation,"", $area=="on"?$areaonsrch:$opt_shand,$area).":::".GET_SEl_BOX("opt2", TRUE, "Manufacturer", $sel_manufacturer,"", $withoutManuf,$area);
	break;

	case "SLS" : // show layer step for history *******************************************************************************************/
		get_layer_step($actidx, $actkind, "odr");
	break;
	case "PMI" : // put money in (입금 처리)
		$confirm_yn = "N";

		$sql = "update mybank set put_money_yn = 'Y' where mybank_idx = $mybank_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		//----------------------------------------------
		$mybank = get_mybank($mybank_idx);
		//----------------------------------------------
		
		if ($mybank[deposit_yn] =="Y"){//보증금....
			$sql = "update mybank set put_money_yn = 'Y' where mem_idx = $mybank[mem_idx] and rel_idx = $mybank[rel_idx] and charge_type = 8 ";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}

		//2016-05-27 : '충전'의 경우 실제 MyBank 에 충전 ------------------------------------------------
		if($mybank[charge_type] == '1'){ //'충전'인 경우
			//1. MyBank Insert -----------------------------------------------------------------------
			$sql = "insert into mybank set
					mem_idx = '$mybank[mem_idx]'
					,rel_idx = '$mybank[rel_idx]'
					,mybank_yn = 'Y'
					,charge_type = '1'
					,charge_amt = '$mybank[charge_amt]'
					,mybank_amt = '$new_amt'
					,invoice_no = '$mybank[invoice_no]'
					,charge_method = '$mybank[charge_method]'
					,reg_date = now()
					,reg_ip= '$log_ip'";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			$new_bank_idx=mysql_insert_id();
			//2. 합계금액 Update ---------------------------------------------------------------------
			$bank_amt = SumMyBank2($mybank[mem_idx], $mybank[rel_idx], 0);
			update_val("mybank","mybank_amt",$bank_amt, "mybank_idx", $new_bank_idx);

				$sql = "insert into odr_history set 
						odr_idx = '$mybank[odr_idx]'
						,odr_det_idx = '$mybank[odr_det_idx]'
						,status = 5
						,status_name = '결제완료'
						,etc1 = '은행 송금'
						,etc2 = 'Mybank 충전'
						,with_deposit = '$mybank[deposit_yn]'
						,charge_ty = '$charge_ty'
						,confirm_yn = '$confirm_yn'
						,buy_mem_idx = '$mybank[mem_idx]'
						,reg_mem_idx = '0'
						,reg_date = now()";
			//echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());


		}elseif (($mybank[deposit_yn] =="Y" && -$mybank[charge_amt] !=1000) || $mybank[deposit_yn] !="Y"){ //충전이 아닌 경우만 History
			//------------------------------------------
			$odr = get_odr($mybank[odr_idx]);
			//------------------------------------------
			$sql = "update odr_history set confirm_yn  = 'Y' where odr_idx = $mybank[odr_idx] and confirm_yn ='N' and status in('18','5','19')";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			//-- 지속적... 계약금(판매자 or 구매자) or 잔금 ------------------------------------
			if($mybank[charge_type] == '2'){//계약금--------------
				$charge_ty = "D";
				if($mybank[mem_idx] == $odr[sell_mem_idx]){	//판매자(계약금) 결재
					$confirm_yn = "Y";
					//구매자.. '결재완료' 읽지 않음 처리
					$sql = "UPDATE odr_history SET confirm_yn = 'N' WHERE odr_idx = $mybank[odr_idx] AND status=5 AND charge_ty='D' AND reg_mem_idx=$odr[mem_idx]";
					$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
				}
			}else{//계약금 아닌 나머지 -----------------------------
				//지속적... 에서 잔금
				if(QRY_CNT("odr_history", "AND odr_idx=$mybank[odr_idx] AND status=5 AND charge_ty='D'") > 1){
					$charge_ty = "F";
				}
			}//-- end of 지속적.. 일때 ------------------------------------------------------		
				$sql = "insert into odr_history set 
						odr_idx = '$mybank[odr_idx]'
						,odr_det_idx = '$mybank[odr_det_idx]'
						,status = 5
						,status_name = '결제완료'
						,etc1 = '은행 송금'
						,etc2 = '$".number_format(($mybank[charge_amt]*-1),2)."'
						,with_deposit = '$mybank[deposit_yn]'
						,charge_ty = '$charge_ty'
						,confirm_yn = '$confirm_yn'
						,sell_mem_idx = '$odr[sell_mem_idx]'
						,buy_mem_idx = '$odr[mem_idx]'
						,reg_mem_idx = '0'
						,reg_date = now()";
			//echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		}
		
		//exit;
	break;
	case "PMIF" : // put money in (입금 처리) - faulty(불량통보)쪽.  status = 27 ----------------------------------------------------------------------------------------------------------<<
		$sql = "update mybank set put_money_yn = 'Y' where mybank_idx = $mybank_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$mybank = get_mybank($mybank_idx);
		//echo "~~~~".$mybank[deposit_yn];
			//exit;
			$odr = get_odr($mybank[odr_idx]);
			$sql = "update fty_history set confirm_yn  = 'Y' where odr_det_idx = $mybank[odr_det_idx] and confirm_yn ='N' and status in('13','27')";
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

			//2016-10-15 : 송장(Invoice)정보 History Insert (우선, RnD Test Fee.. 만)
			$sql = "insert into fty_history set 
						odr_idx = '$mybank[odr_idx]'
						,odr_det_idx = '$mybank[odr_det_idx]'
						,status = 18
						,status_name = '송장'
						,reason_ty = '6'
						,etc1 = '$mybank[invoice_no]'
						,sell_mem_idx = '$odr[sell_mem_idx]'
						,buy_mem_idx = '$odr[mem_idx]'
						,reg_mem_idx = '$mybank[mem_idx]'
						,confirm_yn  = 'Y'
						,reg_date = now()";
			//echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

			//History -> 결재완료
			$sql = "insert into fty_history set 
						odr_idx = '$mybank[odr_idx]'
						,odr_det_idx = '$mybank[odr_det_idx]'
						,status = 27
						,status_name = '결제완료'
						,reason_ty = '6'
						,etc1 = '$".number_format(-$mybank[charge_amt],2)."-은행송금'
						,sell_mem_idx = '$odr[sell_mem_idx]'
						,buy_mem_idx = '$odr[mem_idx]'
						,reg_mem_idx = '$mybank[mem_idx]'
						,reg_date = now()";
			//echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		//exit;
	break;
	case "PMWI" : //Put Mybank Withdrawal   인출 완료 처리(mybank에 있는 돈을 실제 입금 해주고, mybank에서는 차감) --------------------------------------------------------------<<
	$sql = "update mybank set put_money_yn = 'Y' where mybank_idx = $mybank_idx";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$mybank = get_mybank($mybank_idx);
		$mem_idx = $mybank[mem_idx];
		$rel_idx = $mybank[rel_idx];
		$tot = $mybank[charge_amt];
		$charge_method = $mybank[charge_method];
		$invoice_no = $mybank[invoice_no];

		//2. 합계금액 Update ---------------------------------------------------------------------
		$bank_amt = SumMyBank2($mybank[mem_idx], $mybank[rel_idx], 0);
		update_val("mybank","mybank_amt",$bank_amt, "mybank_idx", $mybank_idx);
		
		$sql = "insert into mybank set 
		mem_idx = '$mem_idx'
			,rel_idx = '$rel_idx'
			,charge_type = '9'
			,charge_amt = '0'
			,mybank_hold = '$tot'
			,mybank_yn = 'Y'
			,charge_method = '$charge_method'
			,invoice_no = '$invoice_no'
			,reg_date = now()
			,reg_ip= '$log_ip'";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
	$sql = "insert into odr_history set 
						odr_idx = '$mybank[odr_idx]'
						,odr_det_idx = '$mybank[odr_det_idx]'
						,status = 5
						,status_name = '결제완료'
						,etc1 = '은행 송금'
						,etc2 = '인출'
						,with_deposit = '$mybank[deposit_yn]'
						,charge_ty = '$charge_ty'
						,confirm_yn = 'N'
						,buy_mem_idx = '$mybank[mem_idx]'
						,reg_mem_idx = '0'
						,reg_date = now()";
//			echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if ($mybank[memo]=="탈퇴"){   //탈퇴를 위한 인출이면 한번에 탈퇴 승인 처리까지 하기.
		update_val("member","del_permit","Y", "mem_idx", $mem_idx);
	}
	break;
	case "RMTP": //탈퇴처리
	$sql="update member set del_permit='Y' where mem_idx='$mem_idx'
		";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	break;
   case "PWC" : //password confirm 
	fnSelectPw($actidx, $actkind);
   break;

   case "GAN": //get account no
		echo get_any("impship", "account_no", "rel_idx = $actidx and company_idx = $actkind");
   break;
   case "STC": //select tel code 국제 코드 뿌려주기
		fnselectTelCode($actidx);
	break;
	case "NPT": //select tel code 국제 코드 뿌려주기
		fnselectNationCode($actidx);
	break;
	case "SDA": //dosi 다시 뿌려주기
	fnSelectDosiArea($actkind, $actidx,$lang);  
	break;

	case "SA" : //sigungu 다시 뿌려주기
	fnSelectArea($actkind, $actidx,$lang);  
	break;



}
function fnAgency($rel_idx,$idx){
	//mem_idx -> checked_idx
	echo GF_GET_AGENCY_DATA($rel_idx,$idx);
}

function fnPartList($page,$part_type,$part_no){
	//mem_idx -> checked_idx
	echo GF_GET_PART_LIST($page,$part_type,$part_no);	//class.partinfo.php
}

function fnRecordList($odr_type, $part_no,$yr,$mon,$this_mem_idx,$page){
	echo GF_GET_RECORD_LIST($odr_type, $part_no,$yr,$mon,$this_mem_idx,$page);
}

function fnSideodrlist($odr_type,$this_mem_idx){
	echo GET_Order($odr_type, $this_mem_idx);
}

function fnOdrlist($odr_type, $this_mem_idx){
		for ($i = 1; $i<=6; $i++){
			echo GET_RCD_DET_LIST($i , $odr_type, " and a.".($odr_type=="S"?"sell_":"")."mem_idx=$this_mem_idx ", "S");
		}
}

function fnRemitList($yr,$mon,$remit_ty,$page){
	echo GF_GET_REMIT_LIST($yr,$mon,$remit_ty,$page);
}
function fnmain_list($actkind, $actidx){
	
	if ($actkind == "opt1"){
		$searchand = "and (nation = '".$actidx."' || dosi = '".$actidx."') ";
	}else{
		$searchand = "and manufacturer like '%".$actidx."%' ";
	}
	//echo $searchand;
	for ($i = 1; $i<=6; $i++){
		echo GET_MAIN_LIST("Y", $i, 1, $searchand);
	}
}


function fnImpship($rel_idx,$idx){
	//mem_idx -> checked_idx
	echo GF_GET_IMPSHIP_DATA($rel_idx,$idx);
}
function fnmemfeelist($gubun,$page){
	//mem_idx -> checked_idx
	if($gubun=="1"){
		echo GF_GET_MEMFEE_LIST1();
	}else{
		echo GF_GET_MEMFEE_LIST2($page);
	}
}
function fnmemfeeview($actty,$idx){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}
function fnboardlist($page,$mode,$wantcnt,$strsearch){
	//mem_idx -> checked_idx
	echo GF_GET_BOARD_LIST($page,$mode,$wantcnt,$strsearch);
}
function fnboardwrite($mode,$board_idx){
	//mem_idx -> checked_idx
	echo GF_GET_BOARD_WRITE($mode,$board_idx);
}

function fnturnkeylist($page,$part_no){
	//mem_idx -> checked_idx
	echo GF_GET_TURNKEY_LIST($page,$part_no);
}

function fnturnkeyedit($page){
	//mem_idx -> checked_idx
	echo GF_GET_TURNKEY_EDIT($page);
}

function fnSel($actty,$rel_idx,$mem_type,$mode){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}

function fnSelPart($actty,$part_type){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}
function fnboard($actty,$board_idx){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}
function fnboardview($actty,$mode,$board_idx,$main){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}
function fnagent($actty,$strsearch,$strsearch1,$page){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}

function fnagencyview($actty,$idx,$nat,$strsearch){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}

function fnSelturnkey($actty,$turnkey_idx){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}

function fnSelRecord($actty,$odr_type){
	 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/$actty.php");
}
function fnSelMem($rel_idx, $mem_type,$idx){
	echo GF_GET_MEM_DATA($rel_idx, $mem_type,$idx);
}

function fnSelectDosiArea($actkind ,$actidx,$lang="" ){
		//echo GF_Common_SetComboList("dosi$lang", "NA", $actidx ,"2", "True", ($lang==""?"도/시":"Do/Si") ,"", "",$lang);
		echo GF_Common_SetComboList("dosi$lang", "NA", $actidx ,"2", "True", ($lang==""?"":"") ,"", "",$lang);

}
function fnSelectArea($actkind ,$actidx,$lang="" ){
//		echo GF_Common_SetComboList("sigungu$lang", "NA", $actidx ,"3", "True", ($lang==""?"시/군/구":"Si/Gun/Gu") ,"", "",$lang);
		echo GF_Common_SetComboList("sigungu$lang", "NA", $actidx ,"3", "True", ($lang==""?"":"") ,"", "",$lang);

}

function fnselectTelCode($actidx){
	$telCode = get_any("code_group_detail","code_desc_mt", "grp_idx = 9 and dtl_code= $actidx");
	if ($telCode){
		echo "+".$telCode."-";
	}
}

function fnselectNationCode($actidx){
	if ($actidx)
	{
		$NationCode = get_any("code_group_detail","code_desc_en", "grp_idx = 9 and dtl_code= $actidx group by code_desc;");
		if ($NationCode){
			echo $NationCode;
		}
	}
	
}

function fnProcReady($idx){
		//status =15 (종료)의 경우는 tb_type : odr일 때는 제외하고 싶어서 문구 추가함.
	/*	global $config_sell_status;
		$searchand = "and ((case when $config_sell_status then sell_mem_idx='$idx'
						WHEN status =4 THEN CASE WHEN sell_mem_idx = '$idx' THEN sell_mem_idx = '$idx' and fault_select ='' ELSE buy_mem_idx = '$idx' and fault_select is null end 
						when status = 7 then case when sell_mem_idx = '$idx' then sell_mem_idx = '$idx' and reg_mem_idx <> '$idx' else buy_mem_idx = '$idx' and reg_mem_idx <> '$idx' end
						when status = 8 then CASE WHEN sell_mem_idx = '$idx' then sell_mem_idx = '$idx' and fault_select ='' else buy_mem_idx = '$idx' and fault_select = 'Y' end
					  else reg_mem_idx <> '$idx'  and (sell_mem_idx = '$idx' || buy_mem_idx = '$idx') end) or (status = 5 and sell_mem_idx = '$idx')) AND confirm_yn = 'N'";
	*/

	$sql = "select status, sell_mem_idx, buy_mem_idx , 'odr' as tb_type,reg_date, DATE_FORMAT(reg_date,'%d, %b, %Y') reg_date_fmt from odr_history
			where 
			(case when status in (1,2,3,11) then reg_mem_idx <> '$idx' and sell_mem_idx = '$idx' 
				  when status in (16,18,19,20,21,22,23,24,29) then reg_mem_idx <> '$idx' and buy_mem_idx = '$idx' 
				  when status in (9,10,7) then reg_mem_idx <> '$idx' and (buy_mem_idx = '$idx' or sell_mem_idx = '$idx') 
				  WHEN status = 4 THEN (CASE WHEN sell_mem_idx = '$idx' THEN sell_mem_idx = '$idx' and fault_select <>'' ELSE buy_mem_idx = '$idx' and fault_select is null end)
				  else (buy_mem_idx = '$idx' or sell_mem_idx = '$idx') 
			end)			
			 and confirm_yn = 'N' and status not in (15)
			union all 
			select status, sell_mem_idx, buy_mem_idx , 'fty' as tb_type, reg_date , DATE_FORMAT(reg_date,'%d, %b, %Y') reg_date_fmt from fty_history
			where 
			(case  when status in (25) then reg_mem_idx <> '$idx' and reason_ty!='6' and (buy_mem_idx = '$idx' or sell_mem_idx = '$idx') when status in (29) then reg_mem_idx <> '$idx' and buy_mem_idx = '$idx' when status in (27) then (buy_mem_idx = '$idx' or sell_mem_idx = '$idx') else reg_mem_idx <> '$idx' and (buy_mem_idx = '$idx' or sell_mem_idx = '$idx') end) and confirm_yn = 'N' and status not in (15)
			order by reg_date desc";



//echo $sql;
	$conn = dbconn();
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
//	$result = QRY_HISTORY_LIST(1,$searchand , 1 ,"reg_date DESC ");
	if($result){
		$row = mysql_fetch_array($result);
		
		$now_date = date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s').' - 3day')); 
		$reg_date = $row["reg_date"];
		$valid_yn = $now_date<=$reg_date?"Y":"N";	

		echo replace_out($row["status"]).":".replace_out($row["sell_mem_idx"]).":".$row["tb_type"].":".$valid_yn;
	}
}


function fnUpdateAccessAuth($actkind,$actidx){
		$conn = dbconn();
		$sql = "update designer set access_auth = '$actkind' where designer_idx = $actidx";
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}

function fnUpdateAccessSaleAuth($actkind,$actidx){
		$conn = dbconn();
		$sql = "update designer set access_auth = '$actkind' where designer_idx = $actidx";
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}


function fnMoveCustomer($actkind,$actidx){
		$conn = dbconn();
		$sql = "update member set designer_idx = '$actkind' where mem_idx in ($actidx)";
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}

function fnUpdatePassword($actkind,$actidx){
		$conn = dbconn();
		$sql = "update designer set passwd = '$actkind' where designer_idx = $actidx";
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}

function fnSelectPw($actidx, $actkind){			
		$mem_pwd=md5($actkind);
		$cnt=QRY_CNT("member","and mem_idx='".$actidx."' and mem_pwd = '$mem_pwd'");
		echo ($cnt  == 0) ? "N" : "Y";
}


function fnUpdateMngPw($actkind,$actidx){
		$cnt=QRY_CNT("manager","and id='".$_SESSION["id"]."' and passwd = '$actkind'");
		if ($cnt  == 0){
			echo "현재 비밀번호를 다시 입력해주세요.";
		}else{
			$conn = dbconn();
			$sql = "update manager set passwd = '$actidx' where id='".$_SESSION["id"]."'";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			if ($result){
				echo "비밀번호가 변경되었습니다.";
			}else{
				echo "비밀번호 변경에 실패 했습니다.";
			}

		}
}

function fnUpdateLink($actkind,$actidx,$actyn){
	if ($actyn == "Y") { //연결
		$sql = "insert into search_link ( car_idx, bd_idx, reg_date) 
		values ( '$actkind', '$actidx' , now())";

		$conn = dbconn();
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}else{  //연결끊기
		$sql = "delete from search_link where car_idx = $actkind and bd_idx = $actidx";
		$conn = dbconn();
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());		
	}
}

function fnUpdateAdmPw($actkind,$actidx){
		$cnt=QRY_CNT("admin","and id='".$_SESSION["id"]."' and passwd = '$actkind'");
		if ($cnt  == 0){
			echo "현재 비밀번호를 다시 입력해주세요.";
		}else{
			$conn = dbconn();
			$sql = "update admin set passwd = '$actidx' where id='".$_SESSION["id"]."'";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			if ($result){
				echo "비밀번호가 변경되었습니다.";
			}else{
				echo "비밀번호 변경에 실패 했습니다.";
			}

		}
}

?>

