<?
/********************************************************************************
*** 서류 : 환불(Invoice) 19_1_04
********************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?
//환불용 송장 sheet
  $result_odr = QRY_ODR_VIEW($odr_idx);    
  $row_odr = mysql_fetch_array($result_odr);

  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_det_idx = ".$odr_det_idx,0); 
  $row_odr_det = mysql_fetch_array($result_odr_det);


  $result_buyer = QRY_MEMBER_VIEW("idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"]));
  $row_buyer = mysql_fetch_array($result_buyer);

  $result_seller = QRY_MEMBER_VIEW("idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"]));
  $row_seller = mysql_fetch_array($result_seller);

  if($row_odr_det["refund_invoice"]==""){ 
	  $sql = "update odr_det set refund_invoice= '".get_auto_no("RI", "odr_det" , "refund_invoice")."', refund_date = now() where odr_det_idx=".$odr_det_idx;
	  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_det_idx = ".$odr_det_idx,0); 
	  $row_odr_det = mysql_fetch_array($result_odr_det);
  }
?>



<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/upload/file/<?=get_any("member","filelogo", "mem_type='0'")?>" width="75" height="18" alt=""></span>
				<span class="b2" lang="en">PARTStrike Co., Ltd</span>
			</li>
			<li class="cn">
				<span class="b1" lang="en">www.partstrike.com</span>
			</li>
		</ul>
	</div>
	
	<div class="order-info">
		<ul>
			<li class="b1"><strong>Refund Invoice No.</strong><span><?=$row_odr_det["refund_invoice"]?></span></li>
			<li class="b2"><strong>Date</strong><span><?=$row_odr_det["refund_date"]?></span></li>

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
	
	<div class="seller-info">
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
		<h2><img src="/kor/images/st_tit_<?if ($for_readonly=="Y"){?>commercial_invoice<?}elseif($for_readonly=="P"){?>packing_list<?}else{?>invoice<?}?>.gif" alt="Invoice"></h2>
		<span class="currency">( Currency : US$ ) </span>
		<?$for_readonly = $forgenl=="Y" ? "" : $for_readonly;?>
		<?echo GET_ODR_DET_LIST_V2(" and odr_idx=$odr_idx and odr_det_idx =$odr_det_idx" ,"19_1_04",$for_readonly); ?>			
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		<?if ($for_readonly=="P"){
					$odr = get_odr($odr_idx);
					$ship_weight=$odr[ship_weight];
					$weight_type=$odr[weight_type];
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
	
	<div class="btn-area t-rt">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>		
		<div class="f-rt">			
			<button type="button" onclick="check();"><img src="/kor/images/btn_refund.gif" alt="환불"></button>
		</div>
	</div>
</div>


<form name="f6" id="f6" method="post" enctype="multipart/form-data">		
	<input type="hidden" name="typ" value="refund">
	<input type="hidden" name="odr_idx" id="odr_19_1_04" value="<?=$odr_idx?>">
	<input type="hidden" name="odr_det_idx" id="det_19_1_04" value="<?=$odr_det_idx?>">
	<input type="hidden" name="odr_history_idx" id="history_19_1_04" value="<?=$odr_history_idx?>">
	<input type="hidden" name="mem_idx" value="<?=$row_odr["mem_idx"]?>">
	<input type="hidden" name="rel_idx" value="<?=$row_odr["rel_idx"]?>">
	<input type="hidden" name="sell_mem_idx" value="<?=$row_odr["sell_mem_idx"]?>">
	<input type="hidden" name="sell_rel_idx" value="<?=$row_odr["sell_rel_idx"]?>">
	<input type="hidden" name="tot_amt" value="<?=$tot_amt?>">
	<input type="hidden" name="charge_method" value="MyBank">
	
	<input type="hidden" name="invoice_no" value="<?=$row_odr_det["refund_invoice"]?>">
</form>

<SCRIPT LANGUAGE="JavaScript">
<!--


function check(){
		var f =  document.f6;				
		$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')");
		f.tot_amt.value = $("input[id^=tot_]").val();
		var formData = $("#f6").serialize(); 

		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){		
						openCommLayer("layer3","19_1_05","?forgenl=<?=$forgenl?>");	
					}else{
						alert(data);
					}
				}
		});
	}

-->
</SCRIPT>