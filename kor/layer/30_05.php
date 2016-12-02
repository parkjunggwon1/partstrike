<?

/******************************************************************************************
*** 발주서(Puarchase Order)30_05
*** 2016-05-27 : price 를 odr_det 의 odr_price 로 변경 GET_ODR_DET_LIST_V2
******************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?
if($sheets_no){ //2016-05-19 : What's New 에서 Sheet 클릭 시 Log 호출을 위해 Sheet No.($sheets_no)를 넘겨준다.
	$odr_idx = get_any("odr", "max(odr_idx)", "odr_status=99 AND doc_no='$sheets_no'");
}

  $result_odr = QRY_ODR_VIEW($odr_idx);    
  $row_odr = mysql_fetch_array($result_odr);

  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_idx = ".$odr_idx,0); 
  $row_odr_det = mysql_fetch_array($result_odr_det);

  $row_ship = get_ship($row_odr["ship_idx"]);

  $result_buyer = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"])); //사는 회사 정보
  $row_buyer = mysql_fetch_array($result_buyer);

  $result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"])); //파는 회사 정보
  $row_seller = mysql_fetch_array($result_seller);

  $nation_name = get_any("code_group_detail","code_desc", "grp_code ='NA' and code_depth =1 and use_yn='Y' and dtl_code='$row_buyer[nation]'");

  if ($row_seller["nation"]==$row_buyer["nation"])
  {
	$nation_val=$row_buyer["mem_nm"];

  }
  else
  {
	$nation_val=$row_buyer["mem_nm_en"];
  }


?>
<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="75" height="18" alt=""></span>
				<span class="b2" ><?=$nation_val?></span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"></span>
				<span ><?=$row_buyer["homepage"]?></span>
			</li>
		</ul>
	</div>
	
	<div class="order-info">		
		<ul>
			<li class="b1"><strong>Purchase Order No.</strong><span><?=$row_odr["odr_no"]?></span></li>
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
			<li><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
		</ul>
	</div>
	
	<div class="buyer-info">
		<h2><img src="/kor/images/txt_buyer.gif" alt="buyer"></h2>
		<div class="info-wrap">
			<table>
				<tbody>
					<tr>
						<th scope="row">Ship to :</th>
						<td>
							<?
							if ($row_ship["delivery_addr_idx"])
							{
								$change_color = "style='color:#00759e;'";
							}
							else
							{
								$change_color = "";
							}
							?>
							<ul class="contact-info" <?=$change_color?>>
								<?if ($row_ship["delivery_addr_idx"]){// 배송지 변경한 건
								$delivery_addr=get_delivery_addr($row_ship["delivery_addr_idx"]);				
								
								$tel_nation = explode("-",$delivery_addr["tel"]);
								$fax_nation = explode("-",$delivery_addr["fax"]);
								
								if ($row_seller["nation"]==$row_buyer["nation"])
								{
									$tel = str_replace($tel_nation[0]."-","0",$delivery_addr["tel"]);
									$fax = str_replace($fax_nation[0]."-","0",$delivery_addr["fax"]);
								}
								else
								{
									$tel = $delivery_addr["tel"];
									$fax = $delivery_addr["fax"];
								}
								
								?>
									<li><?=$delivery_addr["com_name"]?></li>
									<li><?=$delivery_addr["addr"]?></li>
									<li><span class="tel">Tel : <?=$tel?></span>Fax : <?=$fax?></li>
									<li>Contact : <?=$delivery_addr["manager"]?> / <?=$delivery_addr["pos_nm"]?></li>
									<li><?=$delivery_addr["email"]?></li>
								<?}else{?>
									<?
									//나라가 같을경우
									if ($row_seller["nation"]==$row_buyer["nation"])
									{
										$tel_nation = explode("-",$row_buyer["tel"]);
										$fax_nation = explode("-",$row_buyer["fax"]);

										$tel_buyer = str_replace($tel_nation[0]."-","0",$row_buyer["tel"]);
										$fax_buyer = str_replace($fax_nation[0]."-","0",$row_buyer["fax"]);
									?>
										<li><?=$row_buyer["mem_nm"]?></li>
										<li><?=$row_buyer["addr"]?></li>
										<li><span class="tel">Tel : <?=$tel_buyer?></span>Fax : <?=$fax_buyer?></li>
										<li>Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm"]:get_any("member", "mem_nm", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm", "mem_idx=".$row_odr["mem_idx"])?></li>
										<li><?=$row_buyer["email"]?></li>
									<?
									}
									else
									{
									?>
										<li><?=$row_buyer["mem_nm_en"]?></li>
										<li><?=$row_buyer["addr_en"]?></li>
										<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?></li>
										<li>Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?></li>
										<li><?=$row_buyer["email"]?></li>

									<?
									}
									?>
								<?}?>
							</ul>
						</td>
					</tr>
					<tr>
						<th scope="row">Bill to :</th>
						<td>
							<ul class="contact-info">
								<?
								//나라가 같을경우
								if ($row_seller["nation"]==$row_buyer["nation"])
								{		
									$tel_nation = explode("-",$row_buyer["tel"]);
									$fax_nation = explode("-",$row_buyer["fax"]);

									$tel_buyer = str_replace($tel_nation[0]."-","0",$row_buyer["tel"]);
									$fax_buyer = str_replace($fax_nation[0]."-","0",$row_buyer["fax"]);
								?>
									<li><?=$row_buyer["mem_nm"]?></li>
									<li><?=$row_buyer["addr"]?> </li>
									<li><span class="tel">Tel : <?=$tel_buyer?></span>Fax : <?=$fax_buyer?></li>
									<li>Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm"]:get_any("member", "mem_nm", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm", "mem_idx=".$row_odr["mem_idx"])?></li>
									<li><?=$row_buyer["email"]?><?=$testtt?></li>
								<?
								}
								else
								{								
									
								?>
									<li><?=$row_buyer["mem_nm_en"]?>, <?=$delivery_addr["zipcode"]?>, <?=$nation_name?></li>
									<li><?=$row_buyer["addr_en"]?></li>
									<li><span class="tel">Tel : <?=$row_buyer["tel"]?></span>Fax : <?=$row_buyer["fax"]?></li>
									<li>Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?></li>
									<li><?=$row_buyer["email"]?><?=$testtt?></li>
								<?
								}
								?>
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
				<?
				//나라가 같을경우
				if ($row_seller["nation"]==$row_buyer["nation"])
				{							
				?>
					<li>
						<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" alt="" width="75" height="18"></span>
						<span class="b2" ><?=$row_seller["mem_nm"]?></span>
					</li>
					<li>
						<span class="b1"><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_seller["nation"])?>"></span>
						<span ><?=$row_seller["homepage"]?></span>
					</li>
				<?
				}
				else
				{
				?>
					<li>
						<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" alt="" width="46" height="17"></span>
						<span class="b2" ><?=$row_seller["mem_nm_en"]?></span>
					</li>
					<li>
						<span class="b1"><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_seller["nation"])?>"></span>
						<span ><?=$row_seller["homepage"]?></span>
					</li>
				<?
				}
				?>
			</ul>
			<ul class="contact-info">
				<?
				//나라가 같을경우
				if ($row_seller["nation"]==$row_buyer["nation"])
				{		
					$tel_nation = explode("-",$row_seller["tel"]);
					$fax_nation = explode("-",$row_seller["fax"]);

					$tel_seller = str_replace($tel_nation[0]."-","0",$row_seller["tel"]);
					$fax_seller = str_replace($fax_nation[0]."-","0",$row_seller["fax"]);
				?>
					<li><?=$row_seller["addr"]?></li>
					<li><span class="tel">Tel : <?=$tel_seller?></span>Fax : <?=$fax_seller?> </li>
					<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_seller["pos_nm"]:get_any("member", "mem_nm", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm", "mem_idx=".$row_odr["sell_mem_idx"])?> </li>
					<li><?=$row_seller["email"]?></li>
				<?
				}
				else
				{								
				?>
					<li><?=$row_seller["addr_en"]?></li>
					<li><span class="tel">Tel : <?=$row_seller["tel"]?></span>Fax : <?=$row_seller["fax"]?> </li>
					<li>Contact : <?=$row_odr["sell_rel_idx"]==0?$row_seller["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> / <?=$row_odr["sell_rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["sell_mem_idx"])?> </li>
					<li><?=$row_seller["email"]?></li>

				<?
				}
				?>
			</ul>
		</div>
	</div>
	
	<!-- order-table -->
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_purchase_order.gif" alt="Purchase Order"></h2>
		<span class="currency">( Currency : US$ ) </span>		
		<?echo GET_ODR_DET_LIST_V2(" and odr_idx=$odr_idx " ,"30_05"); ?>
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		<div class="txt-area">
			<strong>Request from buyer</strong>
			<p class="txt1 c-blue" style="margin:0;padding-top:5px;"><?=$row_ship["memo"]?></p>
		</div>
	</div>
	
	<div class="etc-info2">
		<div class="txt-area">
			<strong>CERTIFICATION and CONFIRMATION of PURCHASE ORDER</strong>
			<p class="txt2" style="margin:0">I hereby certify that I buyer will not violate any items that are mentioned in the Treatment of PARTStrike and is willing to make the Purchase Order perfectly accomplished by not making any cancellation without reason</p>
		</div>
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_buyer["filesign"]?>" height="21" width="180" alt=""></strong></li>
			
			<?
			//나라가 같을경우
			if ($row_seller["nation"]==$row_buyer["nation"])
			{								
				$tel_nation = explode("-",$row_buyer["tel"]);
				$fax_nation = explode("-",$row_buyer["fax"]);

				$tel_buyer = str_replace($tel_nation[0]."-","0",$row_buyer["tel"]);
				$fax_buyer = str_replace($fax_nation[0]."-","0",$row_buyer["fax"]);
			?>
				<li><span>CEO : </span><strong><?=$row_buyer["pos_nm"]?></strong></li>
				<li><span>Tel : </span><strong><?=$tel_buyer?></strong><span class="fax">Fax : </span><strong><?=$fax_buyer?></strong></li>
			<?
			}
			else
			{								
			?>
				<li><span>CEO : </span><strong><?=$row_buyer["pos_nm_en"]?></strong></li>
				<li><span>Tel : </span><strong><?=$row_buyer["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_buyer["fax"]?></strong></li>
			<?
			}
			?>

		</ul>
	</div>
	<input type="hidden" name="odr_idx" id="odr_idx_30_05" value="<?=$odr_idx?>">

	<div class="btn-area">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
		<?
		if($forread==""){		
			if ($row_odr["sell_mem_idx"]!=$session_mem_idx){?>
				<button type="button" class="f-rt orderConfirm"><img src="/kor/images/btn_fix_order.gif" alt="확정 발주서"></button>
			<?}else{?>				
				<button type="button" class="btn-invoice-3008 f-rt"  odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_invoice.gif" alt="송장"></button>
			<?}
		}?>
	</div>
</div>

