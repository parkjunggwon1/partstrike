<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.memfee.php";

?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?
 $result_parts = QRY_MEMBER_VIEW("idx",get_any("member", "min(mem_idx)", "mem_type = 0")); //사는 회사 정보
 $row_parts = mysql_fetch_array($result_parts);

 $result_buyer = QRY_MEMBER_VIEW("idx",($_SESSION["REL_IDX"]==0?$_SESSION["MEM_IDX"]:$_SESSION["REL_IDX"])); //사는 회사 정보
 $row_buyer = mysql_fetch_array($result_buyer);
 $row_ship = get_ship($row_odr_det["ship_idx"]);

 $invoice_no=get_auto_no("CMBI", "mybank" , "invoice_no");

 //날짜 형식 이렇게 표시
 $invoice_date = date("d, M, Y",strtotime($log_date)); 
 $rqst_amt = str_replace(",","",$rqst_amt);
?>
<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<div style="margin-bottom:5px"><img src="/upload/file/<?=$row_parts["filelogo"]?>" width="75"  height="18" alt="" style="vertical-align:middle">
				<span  lang="en"><?=$row_parts["mem_nm_en"]?></span>
				</div>
			</li>
			<li>
				<span lang="en"><img src="/kor/images/nation_title2_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"> <?=$row_parts["homepage"]?> </span>				 
			</li>
		</ul>
		<ul class="contact-info">
			<li><?=$row_parts["addr_det_en"]?> <?=$row_parts["addr_en"]?></li>
			<li><span class="tel">Tel : <?=$row_parts["tel"]?></span>Fax : <?=$row_parts["fax"]?></li>
			<li><span class="tel">Contact : <?=$row_parts["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_parts["mem_idx"])?> / <?=$row_parts["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_parts["mem_idx"])?><br><?=$row_parts["email"]?></li>
		</ul>
	</div>
	
	<div class="order-info">
		<ul>
			<li class="b1"><strong>Charge My Bank Invoice No.</strong><span><?=$invoice_no?></span></li>
			<li class="b2"><strong>Date</strong><span><?=$invoice_date?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<li class="b3"><strong>Ship Via</strong><span>&nbsp;</span></li>
			<li><strong>Account No.</strong><span>&nbsp;</span></li>
			<li class="b2"><strong>Transport insurance</strong><span>&nbsp;</span></li>
		</ul>
		<ul>
			<li class="b1"><strong>Payment Term</strong><span>CBD</span></li>
			<li><img src="/kor/images/nation_title2_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
		</ul>
	</div>
	
	
	<div class="buyer-info ship-info">
		<h2><img src="/kor/images/txt_shipto.gif" alt="ship to"></h2>
		<div class="info-wrap">
			<ul class="company-info">
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="46" height="17" alt=""></span>
					<span class="b2" lang="en"><?=$row_buyer["mem_nm_en"]?></span>
				</li>
				<li>
					<span class="b1"><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"></span>
					<span lang="en"><?=$row_buyer["homepage"]?></span>
				</li>
			</ul>
			<ul class="contact-info">			
				<li><?=$row_buyer["addr_en"]?></li>
				<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?></li>
				<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?></li>
				<li><?=$row_buyer["email"]?></li>
			</ul>
		</div>
	</div>
	
	<div class="seller-info">
		<h2><img src="/kor/images/txt_billto.gif" alt="bill to"></h2>
		<div class="info-wrap">
			<ul class="company-info">
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="46" height="17" alt=""></span>
					<span class="b2" lang="en"><?=$row_buyer["mem_nm_en"]?></span>
				</li>
				<li>
					<span class="b1"><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"></span>
					<span lang="en"><?=$row_buyer["homepage"]?></span>
				</li>
			</ul>
			<ul class="contact-info">
				<li><?=$row_buyer["addr_en"]?></li>
				<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?></li>
				<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?></li>
				<li><?=$row_buyer["email"]?></li>
			</ul>
		</div>
	</div>
	
	<!-- order-table -->
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_invoice.gif" alt="Invoice"></h2>
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
				<tr>
					<td>1</td>
					<td class="t-lt">Charge My Bank of PARTStrike.com</td>
					<td>$<?=number_format($rqst_amt,2)?></td>
					<td>$<?=number_format($rqst_amt,2)?></td>
				</tr>
			</tbody>
		</table>
		
		<ul class="total-price">
			<li class="sub"><strong>Sub Total :</strong><span><td>$<?=number_format($rqst_amt,2)?></td></span></li>
			<li class="total"><strong>Total :</strong><span><td>$<?=number_format($rqst_amt,2)?></td></span></li>
		</ul>
		<ul class="total-price left">
			<?if ($_SESSION["NATION"]=="1"){?>
				<li class="total t-lt"><strong>Total :</strong><span><td>￦<?=number_format($rqst_amt*getExchangeRate())?></td></span></li>
			<?}?>
		</ul>		
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		<div class="txt-area">
			<?=get_bank_info($row_buyer["nation"])?>
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
	
	<div class="btn-area t-rt" odr_idx="" odr_det_idx="" fromLoadPage="" deposit_yn="" charge_type="1" tot_amt="<?=$rqst_amt?>">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
		<a href="#" class="btn-dialog-18-2-12"><img src="/kor/images/btn_card.gif" alt="신용카드"></a>&nbsp;<a href="#" class="f-rt btn-pop-3013"><img src="/kor/images/btn_remittance.gif" alt="은행송금"></a>
	</div>

	<?$typ = $typ==""?"pay":$typ;
	$charge_type="1";?>
<form name="payform">
	<input type="hidden" name="typ" value="chmybank">
	<input type="hidden" name="tot_amt" value="<?=$rqst_amt?>">
	<input type="hidden" name="charge_type" value="<?=$charge_type?>">
</form>

</div>

