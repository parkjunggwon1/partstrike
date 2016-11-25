<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
//위로금용 동의 sheet
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?$result_odr = QRY_ODR_VIEW($odr_idx);    
  $row_odr = mysql_fetch_array($result_odr);

  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_det_idx = ".$odr_det_idx,0); 
  $row_odr_det = mysql_fetch_array($result_odr_det);


  $result_buyer = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"])); //사는 회사 정보
  $row_buyer = mysql_fetch_array($result_buyer);

  $result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"])); //파는 회사 정보
  $row_seller = mysql_fetch_array($result_seller);
//echo get_odr_det_no("AS");
  if($row_odr_det["agreement_no"]==""){ 
	  $sql = "update odr_det set agreement_no= '".get_odr_det_no("AS")."', agreement_reg_date = now() where odr_det_idx=".$odr_det_idx;
	  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
  }

?>

<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" width="75" height="18" alt=""></span>
				<span class="b2" lang="en"><?=$row_seller["mem_nm_en"]?></span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_seller["nation"])?>"></span>
				<span lang="en"><?=$row_seller["homepage"]?></span>
			</li>
		</ul>
	</div>
	
	<div class="order-info">
		<ul>
			<li class="b1"><strong>Agreement Sheet No.</strong><span><?=$row_odr_det["agreement_no"]?></span></li>
			<li class="b2"><strong>Date</strong><span><?=$row_odr_det["agreement_reg_date"]?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<li class="b3"><strong>Ship Via</strong><span><img src="/kor/images/icon_dhl.gif" alt="" height="10"></span></li>
			<li><strong>Account No.</strong><span><?=$row_odr["ship_account_no"]?></span></li>
			<li class="b2"><strong>Transport insurance</strong><span><?=$row_odr["insur_yn"]?></span></li>
		</ul>
		<ul>
			<li class="b1"><strong>Payment Term</strong><span>CBD</span></li>
			<li><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
		</ul>
	</div>
	
	<div class="buyer-info">
		<h2><img src="/kor/images/txt_buyer.gif" alt="buyer"></h2>
		<div class="info-wrap">
			<ul class="company-info pd-l20">
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="75" height="18" alt=""></span>
					<span class="b2" lang="en"><?=$row_buyer["mem_nm_en"]?></span>
				</li>
				<li>
					<span class="b1"><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" ></span>
					<span lang="en"><?=$row_buyer["homepage"]?></span>
				</li>
			</ul>
			<table class="small">
				<tbody>
					<tr>
						<th scope="row">Ship to :</th>
						<td>
							<ul class="contact-info">
								<?if ($row_odr["delivery_addr_idx"]){// 배송지 변경한 건
								$delivery_addr=get_delivery_addr($row_odr["delivery_addr_idx"]);
								?>
									<li><?=$delivery_addr["com_name"]?></li>
									<li><?=$delivery_addr["addr"]?></li>
									<li><span class="tel">Tel : <?=$delivery_addr["tel"]?></span>Fax : <?=$delivery_addr["fax"]?></li>
									<li>Contact : <?=$delivery_addr["manager"]?> / <?=$delivery_addr["pos_nm"]?></li>
									<li><?=$delivery_addr["email"]?></li>
								<?}else{?>
									<li><?=$row_buyer["mem_nm_en"]?></li>
									<li><?=$row_buyer["addr_det_en"]?> <?=$row_buyer["addr_en"]?></li>
									<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?></li>
									<li>Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?></li>
									<li><?=$row_buyer["email"]?></li>
								<?}?>
							</ul>
						</td>
					</tr>
					<tr>
						<th scope="row">Bill to :</th>
						<td>
							<ul class="contact-info">
								<li><?=$row_buyer["mem_nm_en"]?></li>
								<li><?=$row_buyer["addr_det_en"]?> <?=$row_buyer["addr_en"]?></li>
								<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?></li>
								<li>Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?></li>
								<li><?=$row_buyer["email"]?></li>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="seller-info" style="bottom:-12px">
		<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$row_seller["mem_idx"]?>">
		<h2><img src="/kor/images/txt_seller.gif" alt="seller"></h2>
		<div class="info-wrap">
			<ul class="company-info">
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" alt="" width="46" height="17"></span>
					<span class="b2" lang="en"><?=$row_seller["mem_nm_en"]?></span>
				</li>
				<li>
					<span class="b1"><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_seller["nation"])?>"></span>
					<span lang="en"><?=$row_seller["homepage"]?></span>
				</li>
			</ul>
			<ul class="contact-info">
				<li><?=$row_seller["addr_det_en"]?> <?=$row_seller["addr_en"]?></li>
				<li><span class="tel">Tel : <?=$row_seller["tel"]?></span>Fax : <?=$row_seller["fax"]?> </li>
				<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_seller["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> </li>
				<li><?=$row_seller["email"]?></li>
			</ul>
		</div>
	</div>
	
	<!-- order-table -->
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_agreement_sheet.gif" alt="Agreement Sheet"></h2>
		<span class="currency">( Currency : US$ ) </span>
		<?echo GET_RCD_DET_LIST_V2(" and odr_idx=$odr_idx and odr_det_idx =$odr_det_idx" ,"21_3_01"); ?>			
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		<div class="txt-area">
			<strong>Buyer</strong>
		</div>
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_buyer["filesign"]?>" height="21" alt=""></strong></li>
			<li><span>CEO : </span><strong><?=$row_buyer["pos_nm_en"]?></strong></li>
			<li><span>Tel : </span><strong><?=$row_buyer["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_buyer["fax"]?></strong></li>
		</ul>
	</div>
	
	<div class="etc-info2">	
		<div class="txt-area">
			<strong>Seller</strong>
		</div>
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_seller["filesign"]?>" height="21" alt=""></strong></li>
			<li><span>CEO : </span><strong><?=$row_seller["pos_nm_en"]?></strong></li>
			<li><span>Tel : </span><strong><?=$row_seller["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_seller["fax"]?></strong></li>
		</ul>	
	</div>
	
	<div class="btn-area t-rt">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
		<?
		//이 sheet는 구매자 잘못이기 때문에 접속자가 구매자이면 송장확인, 판매자이면 동의
		// 아무리 전 페이지에서 $bpway == "Y"로 넘어왔다 하더라도 접속자가 판매자이면 bpway= "";
		if ($row_odr["sell_mem_idx"]== $_SESSION["MEM_IDX"]) {
			$bpway ="";
		}
		
		
		if ($bpway == "Y") { ?> 
			<a href="#" class="btn-view-sheet-21-3-06" odr_idx ="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장 확인"></a>
			<?}else{?>
		<a href="#" class="agreeConfirm" odr_idx ="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" agreement_no="<?=$row_odr_det["agreement_no"]?>" reason_ty="5"><img src="/kor/images/btn_agree.gif" alt="동의"></a>
		<?}?>
		<!--<a href="#" class="btn-pop-21-7-01"><img src="/kor/images/btn_refuse.gif" alt="거절"></a>
		-->
		
	</div>
</div>

