<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

//보증금용 sheet
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?$result_odr = QRY_ODR_VIEW($odr_idx);    
  $row_odr = mysql_fetch_array($result_odr);

  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_idx = ".$odr_idx,0); 
  $row_odr_det = mysql_fetch_array($result_odr_det);

  $row_ship = get_ship($row_odr["ship_idx"]);

  $result_buyer = QRY_MEMBER_VIEW("idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"]));
  $row_buyer = mysql_fetch_array($result_buyer);

  $result_seller = QRY_MEMBER_VIEW("idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"]));
  $row_seller = mysql_fetch_array($result_seller);

  $result_parts = QRY_MEMBER_VIEW("idx",get_any("member", "min(mem_idx)", "mem_type = 0")); //파츠 회사 정보
  $row_parts = mysql_fetch_array($result_parts);


?>
<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">	
	<div class="top-info">
	<?if ($for_readonly=="") { ?>
		<ul class="company-info">
			<li>
				<span class="b1"><img src="<?=$row_parts["filelogo"]?>" width="75" height="18" alt=""></span>
				<span class="b2" lang="en"><?=$row_parts["mem_nm_en"]?></span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title2_<?=GF_Common_GetSingleList("NA",$row_parts["nation"])?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_parts["nation"])?>"></span>
				<span lang="en"><?=$row_parts["homepage"]?></span>
			</li>
		</ul>
		
		<ul class="contact-info">
			<li><?=$row_buyer["addr_det_en"]?> <?=$row_buyer["addr_en"]?></li>
			<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?> </li>
			<li><span class="tel">Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?><br><?=get_any("member", "email", "mem_idx=".$row_odr["mem_idx"])?></li>
		</ul>
	<?}else{?>
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
		<ul class="contact-info">
			<li><?=$row_seller["addr_det_en"]?> <?=$row_seller["addr_en"]?></li>
			<li><span class="tel">Tel : <?=$row_seller["tel"]?></span>Fax : <?=$row_seller["fax"]?> </li>
			<li><span class="tel">Contact : <?=$row_odr["rel_idx"]==0?$row_seller["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?><br><?=get_any("member", "email", "mem_idx=".$row_odr["mem_idx"])?></li>
		</ul>
	<?}?>
	</div>
	<div class="order-info">
		<ul>
			<li class="b1"><strong>Deposit  Invoice No.</strong><span><?=$row_odr["invoice_no"]?></span></li>
			<li class="b2"><strong>Date</strong><span><?=$row_odr["reg_date_fmt"]?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<li class="b3"><strong>Ship Via</strong><span><?if ($row_ship["ship_info"]){?><img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship["ship_info"]))?>.gif" alt="" height="10"><?}?></span></li>
			<li><strong>Account No.</strong><span><?=$row_ship["ship_account_no"]?></span></li>
			<li class="b2"><strong>Transport insurance</strong><span><?=$row_ship["insur_yn"]=="o"?"Yes":"No"?></span></li>
		</ul>
		<ul>
			<li class="b1"><strong>Payment Term</strong><span>CBD</span></li>
			<li><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="china" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
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
	<?$tot_amt= 1000;?>
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_<?if ($for_readonly=="Y"){?>commercial_invoice<?}elseif($for_readonly=="P"){?>packing_list<?}else{?>invoice<?}?>.gif" alt="Invoice"></h2>
		<span class="currency">( Currency : US$ )</span>
		<table>
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col" width="60%">Description</th>
					<th scope="col">Price</th>
					<th scope="col">Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td  align="left">Deposit</td>
					<td>$1,000.00</td>
					<td>$1,000.00</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="tot" id="tot_<?=$odr_idx?>" value="<?=$tot_amt?>">test
		<ul class="total-price left">
			<?if ($_SESSION["NATION"]=="1"){?>
				<li class="total t-lt"><strong>Total :</strong><span><td>￦<?=number_format($tot_amt*getExchangeRate())?></td></span></li>
			<?}?>
		</ul>	
		<ul class="total-price">
			<li class="sub"><strong>Sub Total :</strong><span>$<?=number_format($tot_amt,2)?></span></li>
			<li class="total"><strong>Total :</strong><span>$<?=number_format($tot_amt,2)?></span></li>
		</ul>
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		
			<?if ($for_readonly=="P"){
					$odr = get_odr($odr_idx);
					$ship_weight=$row_ship[ship_weight];
					$weight_type=$row_ship[weight_type];
				?>
					<div class="txt-area2-outer">
						<div class="inner"><span class="c-blue">Weight : <?=($ship_weight)?number_format($ship_weight,2):""?> <?=GF_Common_GetSingleList("WEIGHT",($weight_type)?$weight_type:"1")?></span></div>				

			<?}else{?>
			<div class="txt-area">
			<strong>PARTStrike Bank Information</strong>
			<ul class="txt3">
				<li>Beneficiary Name : PARTStrike Co., Ltd.</li>
				<li>Bank Name : Inderstrial Bank of Korea</li>
				<li>Account No. 632-018768-56-00018</li>
				<li>Bank Address : EunSan Building, 8, Gyeonginro53gil, Guro-gu, Seoul, 152-864, Korea </li>
				<li>Bank Phone No. : +82-2-2672-7911</li>
				<li>Swift(BIC) Code : IBKOKRSEXXX</li>
			</ul>
			<?}?>
		</div>
	</div>
	
	<div class="etc-info2">
		<?if ($for_readonly!="P"){?>
		<div class="txt-area">
			<strong>CERTIFICATION and APPROVAL of INVOICE</strong>
			<p class="txt2">I hereby certify that I as a member is well-informed with the PARTStrike’s  Treatments mentioned on the pages also will not violate any items mentioned  in the Treatment of PARTStrike and agrees to pay the above lists without any  complaints or argument. </p>
		</div>
		<?}?>
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_buyer["filesign"]?>" height="21" alt=""></strong></li>
			<li><span>CEO : </span><strong><?=$row_buyer["pos_nm_en"]?></strong></li>
			<li><span>Tel : </span><strong><?=$row_buyer["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_buyer["fax"]?></strong></li>
		</ul>
	</div>
		<input type="hidden" name="odr_idx" id="odr_idx_30_09" value="<?=$odr_idx?>">
		<input type="hidden" name="sell_mem_idx" id="sell_mem_idx_30_09" value="<?=$row_odr["sell_mem_idx"]?>">
		<input type="hidden" name="part_type" id="part_type" value="<?=$row_odr_det["part_type"]?>">
		
	
	<div class="btn-area">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>		
		<div class="f-rt" odr_det_idx="" odr_idx="<?=$odr_idx?>">
			<button type="button" class="btn-pop-3012" odr_idx="<?=$row_odr["odr_idx"]?>" odr_det_idx="<?=$row_odr["odr_det_idx"]?>" tot_amt="<?=$tot_amt?>" fromLoadPage="<?=$LoadPage?>" deposit_yn="Y"><img src="/kor/images/btn_payment.gif" alt="결제"></button>
			
		</div>
		
	</div>
</div>

