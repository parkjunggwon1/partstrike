<?
/*******************************************************************************************
**** 송장(Commercial Invoice) 30_17
**** //2016-04-25 : 30_09 에서 공용으로 사용하던것을 분리
*******************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/kor/js/jquery.maskMoney.js"></script>
<script src="/kor/js/print-div-jquery.js"></script>
<script src="/include/function.js"></script>
<script src="/kor/js/common.js"></script>
<link rel="stylesheet" href="/kor/css/site.css">
<SCRIPT LANGUAGE="JavaScript">
//-- Amount 계산
function calcu_amount(){
	//maskoff();
	var odr_det_idx = $("input[name^=odr_det_3017]");
	var num, ord_qty, unit_price, am_sum=0;
	//반복....
	odr_det_idx.each(function(e){
		num = $(this).val();

		$("#unit_price_"+num).maskMoney({prefix:'$', allowNegative: false, thousands:',', decimal:'.', affixesStay: true});

		ord_qty = $("#odr_qty_"+num).val().replace(/,/gi,"");
		unit_price = $("#unit_price_"+num).val().replace("$","").replace(/,/gi,"");

		amount = ord_qty * unit_price;
		am_sum += amount;
		$("#amount_"+num).val(amount);
		$("#amount_"+num).maskMoney({prefix:'$', allowNegative: false, thousands:',', decimal:'.', affixesStay: true});
		$("#amount_"+num).focus();
		//$("#amount_"+num).number(true,2);
	});
	//Sub Total
	$("#sub_total").html("<input type='text' class='i-txt0 t-rt' id='ip_subtot' value='"+am_sum+"'>");
	$("#ip_subtot").maskMoney({prefix:'$', allowNegative: false, thousands:',', decimal:'.', affixesStay: true});
	$("#ip_subtot").focus();
	//Total
	$("#g_total").html("<input type='text' class='i-txt99 t-rt' id='ip_gtot' value='"+am_sum+"'>");
	$("#ip_gtot").maskMoney({prefix:'$', allowNegative: false, thousands:',', decimal:'.', affixesStay: true});
	$("#ip_gtot").focus();

	$(".order-table").focus();
}
$(document).ready(function(){
	$('.numprice').css("ime-mode","disabled").blur( function(event){   // 숫자 입력 하면 ,로 단위 끊어 표시하게.
		calcu_amount();
	});
	$("#print_3017").click(function(){
		var num;
		$("input[name^=odr_det_3017]").each(function(e){
			num = $(this).val();
			$("#odr_qty_"+num).removeClass("i-txt2").addClass("i-txt0");
			$("#unit_price_"+num).removeClass("i-txt2").addClass("i-txt0");
		});
		//프린트
		/**
		styleSheets = [];
		styleSheets.push("http://"+window.location.host+'/kor/css/site.css');
		styleSheets.push("http://"+window.location.host+'/kor/css/sheet_print.css');
		title = "Commercial Invoice";
		print_div("layerPop5",styleSheets, title);
		**/
	});
	$(".order-table").focus(function(){
		var num;
		$("input[name^=odr_det_3017]").each(function(e){
			num = $(this).val();
			$("#odr_qty_"+num).removeClass("i-txt0").addClass("i-txt2");
			$("#unit_price_"+num).removeClass("i-txt0").addClass("i-txt2");
		});
	});
	calcu_amount();
});
</SCRIPT>
<?
if($sheets_no){ //2016-04-18 : What's New 에서 Sheet 클릭 시 Log 호출을 위해 Sheet No.($sheets_no)를 넘겨준다.
	$odr_idx = get_any("odr", "max(odr_idx)", "odr_status=99 AND doc_no='$sheets_no'");
}
$result_odr = QRY_ODR_VIEW($odr_idx);    
$row_odr = mysql_fetch_array($result_odr);

$result_odr_det =QRY_ODR_DET_LIST(0,"and odr_idx = ".$odr_idx,0); 
$row_odr_det = mysql_fetch_array($result_odr_det);

$row_ship = get_ship($row_odr["ship_idx"]);

$result_buyer = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"]));
$row_buyer = mysql_fetch_array($result_buyer);

$result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"]));
$row_seller = mysql_fetch_array($result_seller);

$pay_cnt =QRY_CNT("odr_history", "and odr_idx = $odr_idx and status = 5"); 
if($row_odr_det["part_type"] == 2 &&  $row_odr_det["period"] *1 > 2 && $pay_cnt<2) {
	$down_yn ="Y";
}

?>
<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">	
	<div class="top-info" style="width:380px;">
	<?if ($for_readonly=="") { ?>
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/upload/file/<?=get_any("member","filelogo", "mem_type='0'")?>" width="75" height="18" alt=""></span>
				<span class="b2" lang="en">PARTStrike Co., Ltd</span>
			</li>
			<li class="cn">
				<span class="b1" lang="en">www.partstrike.com</span>
			</li>
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
		<ul class="contact-info" style="width:370px;">
			<li><?=$row_seller["addr_det_en"]?> <?=$row_seller["addr_en"]?></li>
			<li><span class="tel">Tel : <?=$row_seller["tel"]?></span>Fax : <?=$row_seller["fax"]?> </li>
			<li><span class="tel">Contact : <?=$row_odr["rel_idx"]==0?$row_seller["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?></li>
		</ul>
	<?}?>
	</div>
	<div class="order-info">
		<ul>
			<li class="b1"><strong>
			<?if ($for_readonly=="Y"){?>Commercial Invoice<?
			 $chr =  "CI";
			}elseif ($for_readonly=="P"){?>Packing List<?
				$chr =  "PL";
			}
			elseif ($down_yn =="Y"){?>Down Payment Invoice<?
				$chr = "DPI";
			}else{?>Escrow Invoice<?
				$chr =  "EI";
			}
			?> No.</strong><span>

			<?if ($down_yn =="Y"){
				echo get_auto_no($chr, "mybank" , "invoice_no");
			}else{?>
			<?=$row_odr["invoice_no"]==""?str_replace("EI", $chr, get_auto_no("EI", "odr" , "invoice_no")):str_replace("EI", $chr,$row_odr["invoice_no"])?>
			<?}?>
			
			</span></li>
			<li class="b2"><strong>Date</strong><span><?=$row_odr["reg_date_fmt"]?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<?
			if ($row_ship["ship_info"] == "5" || $row_ship["ship_info"] == "6"){
				if($row_ship["ship_info"] == "5")
				{
					$ship_via = "Others";
				}
				elseif($row_ship["ship_info"] == "6")
				{
					$ship_via = "Pick Up";
				}								
			?>
				<li class="b3"><strong>Ship Via </strong><span><?=$ship_via?></span></li>
				<li><strong>Account No.</strong><span>Address</span></li>
			<?
			}
			else
			{
			?>
				<li class="b3"><strong>Ship Via </strong><span> <?if ($row_ship["ship_info"]){?><img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship["ship_info"]))?>.gif" alt="" height="10"><?}else{echo "&nbsp;";}?></span></li>
				<li><strong>Account No.</strong><span><?=$row_ship["ship_account_no"]?></span></li>
			<?
			}
			?>			
			<li class="b2"><strong>Transport insurance</strong><span><?=$row_ship["insur_yn"]=="o"?"Yes":"No"?></span></li>
		</ul>
		<ul>
			<li class="b1"><strong>Payment Term</strong><span>CBD</span></li>
			<li><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="china" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
		</ul>
	</div>
	

	<?if ($for_readonly!="") { ?>

	<div class="buyer-info ship-info" style="margin-top:6px">
		<h2><img src="/kor/images/txt_shipto.gif" alt="ship to"></h2>
		<div class="info-wrap">
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
			<?if ($row_ship["delivery_addr_idx"]){// 배송지 변경한 건
			$delivery_addr=get_delivery_addr($row_ship["delivery_addr_idx"]);
			?>
				<li><?=$delivery_addr["addr"]?></li>
				<li><span class="tel">Tel : <?=$delivery_addr["tel"]?></span>Fax : <?=$delivery_addr["fax"]?></li>
				<li>Contact : <?=$delivery_addr["manager"]?> / <?=$delivery_addr["pos_nm"]?></li>
				<li><?=$delivery_addr["email"]?></li>
			<?}else{?>
				<li><?=$row_buyer["addr_det_en"]?> <?=$row_buyer["addr_en"]?></li>
				<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?></li>
				<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?></li>
				<li><?=$row_buyer["email"]?></li>
			<?}?>
			</ul>
		</div>
	</div>
	
	<div class="seller-info" style="bottom:-7px">
		<h2><img src="/kor/images/txt_billto.gif" alt="bill to"></h2>
		<div class="info-wrap">
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
				<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?></li>
				<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?></li>
				<li><?=$row_buyer["email"]?></li>
			</ul>
		</div>
	</div>
	<?}else{?>

	<div class="buyer-info">
		<h2><img src="/kor/images/txt_buyer.gif" alt="buyer"></h2>
		<div class="info-wrap">
			<ul class="company-info pd-l20">
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="75" height="18" alt=""></span>
					<span class="b2" lang="en"><?=$row_buyer["mem_nm_en"]?></span>
				</li>
				<li>
					<span class="b1"><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"></span>
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
	
	<div class="seller-info" style="bottom:-8px">
		<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$row_seller["mem_idx"]?>">
		<h2><img src="/kor/images/txt_seller.gif" alt="seller"></h2>
		<div class="info-wrap">
			<ul class="company-info">
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" alt="" width="75" height="18"></span>
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
	<?}?>
	<!-- order-table -->
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_<?if ($for_readonly=="Y"){?>commercial_invoice<?}elseif($for_readonly=="P"){?>packing_list<?}else{?>invoice<?}?>.gif" alt="Invoice"></h2>
		<span class="currency">( Currency : US$ )</span>
		<?
		//echo GET_ODR_DET_LIST_V2(" and odr_idx=$odr_idx ",$loadPage, $for_readonly); 
		echo GET_ODR_DET_LIST_V2(" and odr_idx=$odr_idx ","30_17", $for_readonly); //2016-04-25
		?>
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
			<?if ($for_readonly!="Y"){?>
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
		<button type="button" class="f-lt" id="print_3017"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
		<!--button type="button" id="print_3017"><img src="/kor/images/btn_print.gif" alt="인쇄"></button-->
		<?if($forread==""){
		 if ($row_odr["sell_mem_idx"]!=$session_mem_idx && $for_readonly ==""){   //구매자가 송장을 확인 할 때 ?>
		<div class="f-rt" odr_det_idx="" odr_idx="<?=$odr_idx?>">
			<?
			if (!$charge_type) { $charge_type = "3";}			
			if(QRY_CNT("mybank", "and odr_idx = $odr_idx and charge_type ='".$charge_type."' and charge_method = '2' and put_money_yn is null")==0){?>
			<button type="button" class="btn-dialog-0901"><img src="/kor/images/btn_order_edit.gif" alt="발주서 수정"></button>
			<!--<button type="button" class="btn-dialog-18-2-14"><img src="/kor/images/btn_refund.gif" alt="환불"></button>-->
			<button type="button" class="btn-pop-3012" odr_idx="<?=$row_odr["odr_idx"]?>" odr_det_idx="<?=$row_odr["odr_det_idx"]?>" tot_amt="<?=$tot_amt?>" fromLoadPage="<?=$LoadPage?>"  deposit_yn="<?=$_SESSION["DEPOSIT"]=="N"?"Y":""?>" charge_type="<?=$charge_type?>"><img src="/kor/images/btn_payment.gif" alt="결제"></button>
			<?}else{ //입금확인중?>
				<button type="button" onclick="javascript:alert_msg('입금 확인 중입니다.');"><img src="/kor/images/btn_payment.gif" alt="결제" ></button>			
			<?}?>
		</div>
		<?}else{
			if ($for_readonly !="Y" && $for_readonly !="P"){    //서류 확인이 아닐 경우
					//판매자가 송장을 확인 할때는 2가지 경우
					if($for_downpay_fr_seller){  //구매자가 계약금을 지불 하여 판매자도 계약금을 결제 할때?>

						<?if(QRY_CNT("mybank", "and odr_idx = $odr_idx and charge_type ='".$charge_type."' and charge_method = '2' and put_money_yn is null")==0){?>
							<button type="button" class="f-rt btn-pop-3012" odr_idx="<?=$row_odr["odr_idx"]?>" odr_det_idx="<?=$row_odr["odr_det_idx"]?>" tot_amt="<?=$tot_amt?>" fromLoadPage="<?=$LoadPage?>" deposit_yn="" charge_type="<?=$charge_type?>"><img src="/kor/images/btn_payment.gif" alt="결제"></button>	
							<?}else{?>
							<button type="button" class="f-rt"onclick="javascript:alert_msg('입금 확인 중입니다.');"><img src="/kor/images/btn_payment.gif" alt="결제" ></button>		
							<?}?>
				<?}else{    //확정 송장을 내어 구매자로 하여금 계약금 지불을 하도록 하려 할때
					?>				
					<button type="button" class="f-rt buy-mn03<?if($row_odr_det["part_type"]=="2"&& $row_odr_det["$period"]*1 > 2){?>_0115<?}?>"><img src="/kor/images/btn_fix_invoice.gif" alt="확정송장"></button>
				<?	}	
			}
		}
		}
		?>
	</div>
</div>

