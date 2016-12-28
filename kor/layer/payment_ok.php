<?
/***************************************************************************************
*** 결제완료 페이지 팝업 - POP : payment_ok
***************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

$odr_his=get_odr_history2($odr_idx);
$pay_type = $odr_his[etc1];
//$total_price = $odr_his[etc2];
$buyer_idx = $odr_his[buy_mem_idx];
$seller_idx = $odr_his[sell_mem_idx];

$buyer_nation = get_any("member","nation","mem_idx=$buyer_idx");
$seller_nation = get_any("member","nation","mem_idx=$seller_idx");

//$total_price = str_replace("$", "", $total_price);

$ship_idx = get_any("ship","delivery_addr_idx","odr_idx='$odr_idx'");
$sub_price = get_any("odr_det","sum(supply_quantity*odr_price)","odr_idx='$odr_idx'");

if($ship_idx == 0 || $ship_idx == "")
{
	$ship_nation = get_any("member","nation","mem_idx=$buyer_idx");
}
else
{
	$ship_nation = get_any("delivery_addr","nation","delivery_addr_idx=$ship_idx");
}	

$vat_price = get_any("ship" ,"tax", "odr_idx=$odr_idx ");	//부가세

if($vat_price==0)
{
	$vat_price = get_any("tax" ,"tax_percent", "nation=$ship_nation ");	//부가세
}

$vat_val = $vat_price/100;
$vat_plus =  $sub_price*$vat_val;
$total_price = $sub_price+$vat_plus;
$vat_plus =  round_down($vat_plus,4);

$sub_price = round_down($sub_price,4);
$total_price = round_down($total_price,4);
	
?>
<form name="f" id="f">
	<!-- form1 -->
	<input type="hidden" name="typ" id="typ" value="<?=$typ?>">
	<input type="hidden" name="memfee_id" id="memfee_id" value="<?=$memfee_id?>">
	<input type="hidden" name="mem_idx" id="mem_idx" value="<?=$mem_idx?>">
	<input type="hidden" name="rel_idx" id="rel_idx" value="<?=$rel_idx?>">	
	<input type="hidden" name="tot_amt" id="tot_amt" value="<?=$tot_amt?>">		
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$session_mem_idx?>">		
	<input type="hidden" name="sell_rel_idx" id="sell_mem_idx" value="<?=$session_rel_idx?>">		
	<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
	<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">		
	<input type="hidden" name="charge_method" id="charge_method" value="MyBank">		
	<input type="hidden" name="alert_msg" id="alert_msg" value="결제가 완료되었습니다.">		

	
	<!-- //form1 -->
</form>

<div class="layer-hd">
	<h1><span lang="en" ><?=$pay_type?></span></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	
	<table class="price-table1" lang="en" align="center">
		<tbody>
			<?
			if ($buyer_nation == $seller_nation)
			{
			?>
				<tr>
					<th scope="row"><span >Sub Total</span> : </th>
					<td><span >$<?=number_format($sub_price,4)?></span></td>
				</tr>
				<tr>
					<th scope="row"><span ></span> VAT : </th>
					<td><span >$<?=number_format($vat_plus,4)?></span></td>
				</tr>
				<tr class="lst">
					<td colspan="2"></td>
				</tr>
			<?
			}
			?>			
			<tr>
				<th scope="row"><span class="c-blue">Total : </span></th>
				<td><span class="c-blue">$<?=number_format($total_price,4)?></span></td>
			</tr>
		</tbody>
	</table>
	<div class="btn-area t-rt">
		<button class="btn-close" type="button"><img alt="확인" src="/kor/images/btn_ok.gif"></button>
	</div>
</div>

