<?
/***************************************************************************************************
*** 수정 발주서(Purchase Order Amendment) : 12_07
*** 2016-04-15 : 수정발주서 번호(amend_no)를 매번 새로 생성(Log기록 때문)
*** 2016-04-18 : What's New 에서 Sheet 클릭 시 Log 호출을 위해 Sheet No.($sheets_no)를 넘겨준다.
*** 2016-11-21 : 닫기버튼 제거
***************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?
//수정 발주서 sheet
if($sheets_no){ //2016-04-18 : What's New 에서 Sheet 클릭 시 Log 호출을 위해 Sheet No.($sheets_no)를 넘겨준다.
	$odr_idx = get_any("odr", "max(odr_idx)", "odr_status=99 AND doc_no='$sheets_no'");
}
  $result_odr = QRY_ODR_VIEW($odr_idx);    
  $row_odr = mysql_fetch_array($result_odr);

  $result_buyer = QRY_ODR_MEMBER_VIEW($odr_idx, "idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"]));
  $row_buyer = mysql_fetch_array($result_buyer);

  $result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"]));
  $row_seller = mysql_fetch_array($result_seller);

  //if($row_odr["amend_no"]==""){ //기존에는 없을 때만 생성을 '무조건 새로 생성' 으로 변경 2016-04-15
	//판매자 or 구매자 여부 구분하여, '구매자'일때만 번호 생성하자 2016-04-15
	//if($row_odr["mem_idx"] == $_SESSION["MEM_IDX"] && !$sheets_no){
		//$sql = "update odr set amend_no = '".get_auto_no("POA", "odr" , "amend_no")."', amend_date = now()  where odr_idx=".$odr_idx;
		//$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$result_odr = QRY_ODR_VIEW($odr_idx);    
		$row_odr = mysql_fetch_array($result_odr);
	//} //2016-04-18 : 번호생성 자체를 없앰. odr_proc.php -> 'poano' 에서 생성
  //}

  $row_ship = get_ship($row_odr["ship_idx"]);
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
	</div>
	

	<div class="order-info">
		<ul>
			<li class="b1"><strong>Purchase Order Amendment No.</strong><span><?=$row_odr["amend_no"]?></span></li>
			<li class="b2"><strong>Date</strong><span><?=date("Y-m-d",strtotime( $row_odr["amend_date"] ))?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
		<?
		if ($row_ship["ship_info"]==5)
		{
			$ship_via = "Another";
			$ship_address = "Address";
		}
		else if ($row_ship["ship_info"]==6)
		{
			$ship_via = "Pick Up";
			$ship_address = "Address";
		}
		else
		{
			$ship_via = "<img src='/kor/images/icon_".strtolower(GF_Common_GetSingleList('DLVR',$row_ship['ship_info'])).".gif' alt='' height='10'>";
			$ship_address = $row_ship["ship_account_no"];
		}
		?>
			<li class="b3"><strong>Ship Via</strong>
				<span> 				
					<?=$ship_via?>		
				</span>
			</li>
			<li><strong>Account No.</strong><span><?=$ship_address?></span></li>
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
								
								if ($row_seller["nation"]==$delivery_addr["nation"])
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
									
								?>
									<li><?=$row_buyer["mem_nm"]?></li>
									<li><?=$row_buyer["addr"]?></li>
									<li><span class="tel">Tel : <?=preg_replace('/\+.+\-/', "0",$row_buyer["tel"])?></span>Fax : <?=preg_replace('/\+.+\-/', "0",$row_buyer["fax"])?></li>
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
						<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" alt="" width="46" height="17"></span>
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
				?>
					<li><?=$row_seller["addr"]?></li>
					<li><span class="tel">Tel : <?=preg_replace('/\+.+\-/', "0",$row_seller["tel"])?></span>Fax : <?=preg_replace('/\+.+\-/', "0",$row_seller["fax"])?> </li>
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
		<h2><img src="/kor/images/st_tit_purchase_order_amnd.gif" alt="Purchase Order  Amendment"></h2>
		<span class="currency">( Currency : US$ ) </span>
		<?echo GET_ODR_DET_LIST_V2(" and odr_idx=$odr_idx" ,"12_07",$for_readonly); ?>			
		
	</div>
	<!-- //order-table -->
	
	<div class="etc-info1">
		<div class="txt-area">
			<strong>Request from buyer</strong>
			<p class="txt1 c-blue"><?=$row_ship["memo"]?></p>
		</div>
	</div>
	
	<div class="etc-info2">
		<div class="txt-area">
			<strong>CERTIFICATION and CONFIRMATION of PURCHASE ORDER</strong>
			<p class="txt2">I hereby certify that I buyer will not violate any items that are mentioned in the Treatment of PARTStrike and is willing to make the Purchase Order perfectly accomplished by not making any cancellation without reason</p>
		</div>
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_seller["filesign"]?>" height="23" width="152px" alt=""></strong></li>
			<?
			//나라가 같을경우
			if ($row_seller["nation"]==$row_buyer["nation"])
			{								
			?>
				<li><span>CEO : </span><strong><?=$row_seller["pos_nm"]?></strong></li>
				<li><span>Tel : </span><strong><?=preg_replace('/\+.+\-/', "0",$row_seller["tel"])?></strong><span class="fax">Fax : </span><strong><?=preg_replace('/\+.+\-/', "0",$row_seller["fax"])?></strong></li>
			<?
			}
			else
			{								
			?>
				<li><span>CEO : </span><strong><?=$row_seller["pos_nm_en"]?></strong></li>
				<li><span>Tel : </span><strong><?=$row_seller["tel"]?></strong><span class="fax">Fax : </span><strong><?=$row_seller["fax"]?></strong></li>
			<?
			}
			?>
		</ul>
	</div>
	
	<div class="btn-area">
		
			<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
	<?if ($forread==""){?>
			<?if ($row_odr["sell_mem_idx"]!=$session_mem_idx){?>
				<button type="button" class="f-rt odrAmendConfirm" odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_fix_order.gif" alt="확정 발주서"></button>
			<?}else{?>				
				<button type="button" class="btn-invoice-3008 f-rt"  odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_invoice.gif" alt="송장"></button><!--btn-dialog-1210-->
			<?}
		}?>
	</div>
</div>

