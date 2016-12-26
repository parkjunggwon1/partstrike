<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?$result_odr = QRY_ODR_VIEW($odr_idx);    
  $row_odr = mysql_fetch_array($result_odr);


  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_idx = ".$odr_idx,0); 
  $row_odr_det = mysql_fetch_array($result_odr_det);
  $row_ship = get_ship($row_odr_det["ship_idx"]);
  
  if ($row_odr_det[non_com_invoice]==""){
	  $invoice_no = get_auto_no("NCI","odr_det","non_com_invoice");
	  $invoice_date = date("Y-m-d");
	  $sql = "update odr_det set non_com_invoice= '".$invoice_no."', non_com_date = now() where odr_det_idx=".$odr_det_idx;
	  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	  update_val("ship", "invoice_no", $invoice_no, "ship_idx" ,$row_ship["ship_idx"]);
	}else{
		$invoice_no = $row_odr_det[non_com_invoice];
		$invoice_date= substr($row_odr_det[non_com_date],0,10);
	}

	if ($row_ship[ship_type] == "4"){   //RND TEST를 위한 연구소에 반품이므로 parts에 보내야 함.
		$parts_mem_idx = get_any("member", "min(mem_idx)", "mem_type = 0");
		$result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",$parts_mem_idx,$invoice_no); //파는 회사 정보
	}else{
		$result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"]),$invoice_no); //파는 회사 정보
	}
	$row_seller = mysql_fetch_array($result_seller);

	$result_buyer = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"]),$invoice_no); //사는 회사 정보
	$row_buyer = mysql_fetch_array($result_buyer);

?>
<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="75" height="18" alt=""></span>
				<span class="b2" lang="en"><?=$row_buyer["mem_nm_en"]?></span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"></span>
				<span lang="en"><?=$row_buyer["homepage"]?></span>
			</li>
		</ul>
		<ul class="contact-info">
			<li><?=$row_buyer["addr_det_en"]?> <?=$row_buyer["addr_en"]?></li>
			<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?> </li>
			<li><span class="tel">Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?><br><?=get_any("member", "email", "mem_idx=".$row_odr["mem_idx"])?></li>
		</ul>
	</div>	
	
	<div class="order-info">
		<ul>			
			<li class="b1"><strong>
			<?if ($for_readonly=="" || $for_readonly=="Y"){?>
				Non-Commercial Invoice No.</strong><span><?=$invoice_no?></span>
			<?}elseif ($for_readonly=="P"){?>
				Packing List No.</strong><span><?=str_replace("NCI","PL",$invoice_no)?></span>
			<?}?>
			</li>
			<li class="b2"><strong>Date</strong><span><?=$invoice_date?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<li class="b3"><strong>Ship Via</strong><span><img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship[ship_info]))?>.gif" alt="" height="10"></span></li>
			<li><strong>Account No.</strong><span><?=$row_ship[ship_account_no]?></span></li>
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
					<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" width="46" height="17" alt=""></span>
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
					<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" width="46" height="17" alt=""></span>
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
	
	<!-- order-table -->
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_<?if ($for_readonly=="Y"){?>non_commercial_invoice<?}elseif($for_readonly=="P"){?>packing_list<?}else{?>non_commercial_invoice<?}?>.gif"></h2>
		<span class="currency">( Currency : US$ ) </span>
		<?echo GET_ODR_DET_LIST_V2(" and odr_idx=$odr_idx and odr_det_idx=$odr_det_idx", $for_readonly); ?>			
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		<div class="txt-area2-outer">
			<div class="inner">
			<?if ($for_readonly=="" || $for_readonly=="P"){				
				$ship_weight=$row_ship[ship_weight];
				$weight_type=$row_ship[weight_type];
			?>
				<span class="c-blue">Weight : <?=($ship_weight)?number_format($ship_weight,2):""?> <?=GF_Common_GetSingleList("WEIGHT",($weight_type)?$weight_type:"1")?></span><br><br>
			<?}?>
			<span >RMA No. : <strong class="c-red"><?=str_replace("NCI","RMA",$row_odr_det[non_com_invoice])?></strong></span>


			
			</div>
		</div>
	</div>
	
	<div class="etc-info2">
		<div class="txt-area">
			<strong>CERTIFICATION and APPROVAL of INVOICE</strong>
			<p class="txt2">I hereby certify that I as a member is well-informed with the PARTStrike’s  Treatments mentioned on the pages also will not violate any items mentioned  in the Treatment of PARTStrike and agrees to pay the above lists without any  complaints or argument. </p>
		</div>
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_buyer["filesign"]?>" height="21" alt=""></strong></li>
			<li><span>CEO : </span><strong><?=$row_buyer["pos_nm_en"]?></strong></li>
			<li><span>Tel : </span><strong><?=$row_buyer["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_buyer["fax"]?></strong></li>
		</ul>
	</div>
	
	<div class="btn-area">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
	</div>
</div>

