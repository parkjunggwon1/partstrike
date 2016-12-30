<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?
 // chkLogin($session_mem_idx);
  if ($invoice_no==""){
	 $invoice_no = get_auto_no("WI", "invoice" , "invoice_no");
  }else{
	$rqst_amt = get_any("mybank", "charge_amt","invoice_no='$invoice_no' and mybank_yn = 'Y'");
}

 //인출 관련 sheet 
  $result_buyer = QRY_ODR_MEMBER_VIEW("","idx",($_SESSION["REL_IDX"]==0?$_SESSION["MEM_IDX"]:$_SESSION["REL_IDX"]),$invoice_no); //사는 회사 정보
  $row_buyer = mysql_fetch_array($result_buyer);
  $parts_mem_idx = get_any("member", "min(mem_idx)", "mem_type = 0");
  $result_seller = QRY_ODR_MEMBER_VIEW("","idx",$parts_mem_idx, $invoice_no); //파는 회사 정보
  $row_seller = mysql_fetch_array($result_seller);
  
  
  //날짜 형식 이렇게 표시
  $invoice_date = date("d, M, Y",strtotime($log_date)); 


  $rqst_amt = str_replace(",","",$rqst_amt);
  $escrow =  -$rqst_amt *0.01;
  //sheet에 보여주기 위한 escrow fee 계산은 하지만, tot에는 포함시키지 않음. 왜냐하면 청구는 그렇게 하지만, 실제 인출 해줄때는 escrow fee 제외한 금액만 입금해주면 되므로 admin에만 표시 해주면 됨.
  $tot = $rqst_amt;

?>
<script type="text/javascript">
<!--
	function withdrawal(){
		var f =  document.f;
		 f.target = "proc";
		 f.action = "/kor/proc/record_proc.php";
		 f.submit();			
	}

//-->
</script>
<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<div style="margin-bottom:5px"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="75"  height="18" alt="" style="vertical-align:middle">
				<span  lang="en"><?=$row_buyer["mem_nm_en"]?></span>
				</div>
			</li>
			<li>
				<span lang="en"><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"> <?=$row_buyer["homepage"]?> </span>
			</li>
		</ul>
		<ul class="contact-info">
			<li><?=$row_buyer["addr_det_en"]?> <?=strlen($row_buyer["addr_en"])?></li>
			<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?> </li>
			<li><span class="tel">Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?><br><?=$row_odr["email"]?></li>
		</ul>
	</div>	
	
		
	<div class="order-info">
		<ul>			
			<li class="b1"><strong>
			<?if ($for_readonly=="" || $for_readonly=="Y"){?>
				Withdrawal Invoice No.</strong><span><?=$invoice_no?></span>
			<?}elseif ($for_readonly=="P"){?>
				Packing List No.</strong><span><?=str_replace("NCI","PL",$invoice_no)?></span>
			<?}?>
			</li>
			<li class="b2"><strong>Date</strong><span><?=$invoice_date?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<li class="b3"><strong>Ship Via</strong><span><img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship[ship_info]))?>.gif" alt="" height="10"></span></li>
			<li><strong>Account No.</strong><span>&nbsp;</span></li>
			<li class="b2"><strong>Transport insurance</strong><span><?=$row_ship[insur_yn]=="o"?"Yes":"No"?> </span></li>
		</ul>
		<ul>
			<li class="b1"><strong>Payment Term</strong><span>CBD</span></li>
			<li><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
		</ul>
	</div>
	
	<div class="buyer-info ship-info">
		<h2><img src="/kor/images/txt_shipto.gif" alt="ship to"></h2>
		<div class="info-wrap">
			<ul class="company-info">
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" width="75"  height="18"  alt=""></span>
					<span class="b2" lang="en"><?=$row_seller["mem_nm_en"]?></span>
				</li>
				<li>
					<span class="b1"><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_seller["nation"])?>"></span>
					<span lang="en"><?=$row_seller["homepage"]?></span>
				</li>
			</ul>
			<ul class="contact-info">
			<?if ($row_ship["delivery_addr_idx"]){// 배송지 변경한 건
			$delivery_addr=get_delivery_addr($row_ship["delivery_addr_idx"]);
			?>
				<li><?=$delivery_addr["addr"]?></li>
				<li><span class="tel">Tel : <?=$delivery_addr["tel"]?></span>Fax : <?=$delivery_addr["fax"]?></li>
				<li>Contact : <?=$delivery_addr["manager"]?> / <?=$delivery_addr["pos_nm"]?></li>
				<li><?=$delivery_addr["email"]?></li>
			<?}else{?>
				<li><?=$row_seller["addr_det_en"]?> <?=$row_seller["addr_en"]?></li>
				<li><span class="tel">Tel : <?=$row_seller["tel"]?></span>Fax : <?=$row_seller["fax"]?></li>
				<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_seller["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?></li>
				<li><?=$row_seller["email"]?></li>
			<?}?>
			</ul>
		</div>
	</div>
	
	<div class="seller-info">
		<h2><img src="/kor/images/txt_billto.gif" alt="bill to"></h2>
		<div class="info-wrap">
			<ul class="company-info">
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" width="75"  height="18"  alt=""></span>
					<span class="b2" lang="en"><?=$row_seller["mem_nm_en"]?></span>
				</li>
				<li>
					<span class="b1"><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_seller["nation"])?>"></span>
					<span lang="en"><?=$row_seller["homepage"]?></span>
				</li>
			</ul>
			<ul class="contact-info">
				<li><?=$row_seller["addr_det_en"]?> <?=$row_seller["addr_en"]?></li>
				<li><span class="tel">Tel : <?=$row_seller["tel"]?></span>Fax : <?=$row_seller["fax"]?></li>
				<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_seller["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?></li>
				<li><?=$row_seller["email"]?></li>
			</ul>
		</div>
	</div>
	
<form name="f6" id="f"  method="post" enctype="multipart/form-data">

		<input type="hidden" name="typ" id="typ" value="withdrawal">	
		<input type="hidden" name="mem_idx" value="<?=$session_mem_idx?>">
		<input type="hidden" name="rel_idx" value="<?=$session_rel_idx?>">
		<input type="hidden" name="remitTy" value="<?=$remitTy?>">
		<input type="hidden" name="charge_method" value="2">
		<input type="hidden" name="tot" value="<?=$tot?>">
	<!-- order-table -->
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_<?if ($for_readonly=="Y"){?>non_commercial_invoice<?}elseif($for_readonly=="P"){?>packing_list<?}else{?>invoice<?}?>.gif"></h2>
		<span class="currency">( Currency : US$ ) </span>

		
	<table>
	<thead>
		<tr>
			<th scope="col">No.</th>
			<th scope="col">Description</th>
			<th scope="col">Price</th>
			<th scope="col">Amount</th>
		</tr>
	</thead>
	<tbody>
	
	<tr><td>1</td>
	<td>Request Remittance of my bank in PARTStrike.com</td>
	<td>$<?=number_format($rqst_amt,2);?></td>
	<td>$<?=number_format($rqst_amt,2);?></td>
	</tbody>
	</table>
	<ul class="total-price left">
		<?if ($_SESSION["NATION"]=="1"){?>
			<li class="total t-lt"><strong>Total :</strong><span><td>￦<?=number_format($rqst_amt*getExchangeRate())?></td></span></li>
		<?}?>
	</ul>		

	<ul class="total-price">
	<li class="sub"><strong>Sub Total  :</strong><span>$<?=number_format($rqst_amt,2)?>	</li>
	<li class="sub  c-red"><strong>Escrow Fee :</strong><span><?=str_replace("-","-$",number_format($escrow,2))?>	</li>
	<li class="total"><strong>Total :</strong><span>$<?=number_format($rqst_amt+$escrow,2)?></span></li>
	</ul>
	</div>

	</form>
	<!-- //order-table -->
	

	
	<div class="etc-info1">
		<div class="txt-area">
			<strong><?=$row_buyer["mem_nm_en"]?> Bank Information</strong>
			<ul class="txt3">
				<li>Beneficiary Name : <?=$row_buyer["bank_user_name"]?></li>
				<li>Bank Name : <?=$row_buyer["bank_name"]?></li>
				<li>Account No. <?=$row_buyer["bank_account"]?></li>
				<li>Bank Address :  </li>
				<li>Bank Phone No. : </li>
				<li>Swift(BIC) Code : </li>
			</ul>
		</div>
	</div>
	

	
	<div class="etc-info2">
		
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_buyer["filesign"]?>" height="21" alt=""></strong></li>
			<li><span>CEO : </span><strong><?=$row_buyer["pos_nm_en"]?></strong></li>
			<li><span>Tel : </span><strong><?=$row_buyer["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_buyer["fax"]?></strong></li>
		</ul>
	</div>
	
	<div class="btn-area">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
		<?if ($forread==""){?><button type="button" class="f-rt" onclick="withdrawal();"><img src="/kor/images/btn_request.gif" alt="요청"></button><?}?>
	</div>
</div>