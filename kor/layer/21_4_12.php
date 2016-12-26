<?
/*******************************************************************************************
*** 21_4_12 : Test Report(불량통보)
*******************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
//결과 report Sheet
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?
	
 $fty_his = get_fty_history($fty_history_idx);
 $odr_idx =  $fty_his[odr_idx];
 $odr_det_idx =  $fty_his[odr_det_idx];
  
  $result_odr = QRY_ODR_VIEW($odr_idx);    
  $row_odr = mysql_fetch_array($result_odr);

  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_det_idx = ".$odr_det_idx,0); 
  $row_odr_det = mysql_fetch_array($result_odr_det);

  $row_ship = get_ship($row_odr_det["ship_idx"]);
  $sell_nation = get_any("member", "nation","mem_idx = ".$fty_his["sell_mem_idx"]);
  $result_parts = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",get_any("member", "min(mem_idx)", "mem_type = 0"),$row_odr_det["test_report_no"]); //사는 회사 정보
  $row_parts = mysql_fetch_array($result_parts);

  if ($fty_his[buy_mem_idx]==$_SESSION["MEM_IDX"]){
	$confirm_yn = get_any("mybank", "chk", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and charge_amt<0 and mem_idx=".$fty_his[buy_mem_idx]);	
  }else{
	  $confirm_yn = get_any("mybank", "chk", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and charge_amt<0 and mem_idx=".$fty_his[sell_mem_idx]);

  }
 
?>

<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/upload/file/<?=$row_parts["filelogo"]?>" width="75"  height="18" alt=""></span>
				<span class="b2" lang="en"><?=$row_parts["mem_nm_en"]?></span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title2_<?=$row_parts["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_parts["nation"])?>"></span>
				<span lang="en"><?=$row_parts["homepage"]?></span>
			</li>
		</ul>

		<ul class="contact-info">
		<li><?=$row_parts["addr_en"]?></li>
		<li><span class="tel">Tel : <?=$row_parts["tel"]?></span>Fax : <?=$row_parts["fax"]?></li>
		<li><span class="tel">Contact : <?=$row_parts["pos_nm_en"]?> / CEO</span><?=get_manage_email($sell_nation)?></li>
		</ul>

	</div>
	
	<div class="order-info">
		<ul>
			<li class="b1"><strong>Test Report No.</strong><span><?=$row_odr_det["test_report_no"]?></span></li>
			<li class="b2"><strong>Date</strong><span><?=$row_odr_det["test_report_date"]?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<li class="b3"><strong>Ship Via</strong><span><?if ($row_ship["ship_info"]){?><img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship["ship_info"]))?>.gif" alt="" height="10"><?}?></span></li>
			<li><strong>Account No.</strong><span><?=$row_ship["ship_account_no"]?></span></li>
			<li class="b2"><strong>Transport insurance</strong><span><?=$row_ship["insur_yn"]=="o"?"Yes":"No"?></span></li>
		</ul>
		<ul>
			<li class="b1"><strong>Payment Term</strong><span>CBD</span></li>
			<li><img src="/kor/images/nation_title2_<?=$row_parts["nation"]?>.png" alt="china" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
		</ul>
	</div>
	
	<!-- order-table -->
	<div class="order-table" style="min-height:900px">
		<h2><img src="/kor/images/st_tit_test_report.gif" alt="Test Report"></h2>
		<table>
			<thead>
				<tr>
					<th scope="col">Test Result : <?=$fty_his[etc1]?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?=replace_con_out($row_ship[memo])?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		<div class="txt-area2-outer">
			<div class="inner"><span class="c-blue">Test Result : </span><span class="c-red"><?=$fty_his[etc1]?></span></div>
		</div>
	</div>
	
	<div class="etc-info2">
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_parts["filesign"]?>" height="21" alt=""></strong></li>
			<li><span>CEO : </span><strong><?=$row_parts["pos_nm_en"]?></strong></li>
			<li><span>Tel : </span><strong><?=$row_parts["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_parts["fax"]?></strong></li>
		</ul>
	</div>
	
	<div class="btn-area">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
		<div class="f-rt">
		<?if ($confirm_yn!="Y"){?>
			<button type="button" class="btn-dialog-21-4-13" tTy="<?=$row_odr[sell_mem_idx]==$_SESSION["MEM_IDX"]?"S":"B"?>" testresult="<?=$fty_his[reason_title]?>" fty_history_idx="<?=$fty_history_idx?>"><img src="/kor/images/btn_agree.gif" alt="동의" ></button>
		<?}?>
		</div>
	</div>
</div>

