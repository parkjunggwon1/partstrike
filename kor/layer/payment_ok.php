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


$odr_his2=get_odr_history($odr_history_idx);

$charge_ty = $odr_his2[charge_ty];
$etc2_val = $odr_his2[etc2];

$buyer_nation = get_any("member","nation","mem_idx=$buyer_idx");
$seller_nation = get_any("member","nation","mem_idx=$seller_idx");

//$total_price = str_replace("$", "", $total_price);

$ship_idx = get_any("ship","delivery_addr_idx","odr_idx='$odr_idx'");
$sub_price = get_any("odr_det","sum(supply_quantity*odr_price)","odr_idx='$odr_idx'");

$part_type = get_any("odr_det","max(part_type)","odr_idx='$odr_idx'");

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
$down_payment =  $sub_price*0.1;
$total_price = $sub_price+$vat_plus;
$first_price = $total_price/10;
$vat_plus =  round_down($vat_plus,4);

$sub_price = round_down($sub_price,4);
$total_price = round_down($total_price,4);
$first_price = round_down($first_price,4);
	
$tax_name = get_any("tax", "tax_name", "nation=$seller_nation");

$po_no = get_any("odr", "odr_no", "odr_idx='$odr_idx'");
$po_cancel = QRY_CNT("odr", "and odr_no='$po_no' and odr_status=8");

?>


<div class="layer-hd" style="background: #fff;border: 0px;color: red;">
	<h1><span lang="en" ><?=$pay_type?></span></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a>
</div>
<div class="layer-content" style="border-top:0">
	
	<table class="price-table1" lang="en" align="center">
		<tbody>
			<?
				if( ($down_payment == (int)$down_payment) )
				{					
					$down_payment = number_format($down_payment,2);					
				}
				else {
					$down_payment = round_down($down_payment,4);	
				}

				if( ($vat_plus == (int)$vat_plus) )
				{					
					$vat_plus = number_format($vat_plus,2);					
				}
				else {
					$vat_plus = round_down($vat_plus,4);	
				}

				if( ($sub_price == (int)$sub_price) )
				{					
					$sub_price = number_format($sub_price,2);					
				}
				else {
					$sub_price = round_down($sub_price,4);	
				}

				if( (str_replace("$","",$etc2_val) == (int)str_replace("$","",$etc2_val)) )
				{					

					$etc2_val = "$".number_format(str_replace("$","",$etc2_val),2);					
				}
				else {
					$etc2_val = "$".round_down(str_replace("$","",$etc2_val),4);	
				}
				
				//지속적(납기3주이상)--------------------------------------
				if ($part_type == 2) 
				{ 
					if ($charge_ty=="F")
					{

				?>
						<tr>
							<th scope="row"><span >Sub Total</span> : </th>
							<td><span ><?=$etc2_val?></span></td>
						</tr>
						<tr>
							<th scope="row"><span >Down Payment</span> : </th>
							<td><span class="c-red">-$<?=$down_payment?></span></td>
						</tr>
						<tr>
							<th scope="row"><span ><?=$tax_name?></span> : </th>
							<td><span >$<?=$vat_plus?></span></td>
						</tr>
						<tr class="lst">
							<td colspan="2"></td>
						</tr>
						<tr>
							<th scope="row"><span class="c-blue">Total : </span></th>
							<td><span class="c-blue"><?=$etc2_val?></span></td>
						</tr>
					
				<?
					}
					else
					{
				?>
						<tr>
							<th scope="row"><span >Down Payment</span> : </th>
							<td><span ><?=$etc2_val?></span></td>
						</tr>
						<tr>
							<th scope="row"><span ></span> Total : </th>
							<td><span ><?=$etc2_val?></span></td>
						</tr>
				<?
					}
				}
				else
				{
					if ($buyer_nation == $seller_nation)
					{
					?>
						<tr>
							<th scope="row"><span >Sub Total</span> : </th>
							<td><span >$<?=$sub_price?></span></td>
						</tr>
						<tr>
							<th scope="row"><span ></span> VAT : </th>
							<td><span >$<?=$vat_plus?></span></td>
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
				<?
				}

				$invoice_no_real = get_any("odr","invoice_no","odr_idx='$odr_idx'");
				?>
				<tr>
					
				</tr>
				<?if ($po_cancel>0){?>				
				<tr>
					<td colspan="2" style="padding-right:0;">
					<div class="layer-hd" style="background: #fff;border: 0px;">
						<span class="c-red" style="font-size:12px;"><a class="c-red" href='javascript:openCommLayer("layer5","30_09","?odr_idx=<?=$odr_idx?>&odr_history_idx=<?=$odr_his2[odr_history_idx]?>&forread=Y")'><?=$invoice_no_real?></a></span>
					</div>
					</td>
				</tr>				
				<?}?>
		</tbody>
	</table>
	<div class="btn-area t-rt">
		
	</div>
</div>

