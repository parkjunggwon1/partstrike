<?
//************************************************************************************************
//*** 21_4_06 : Invoice - 불량통보(연구소 의뢰)
//**************************************************************************************************
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<?
//Request R&D 테스트 보낼때 seller/ buy용 송장 sheet
  
  $result_odr = QRY_ODR_VIEW($odr_idx);    
  $row_odr = mysql_fetch_array($result_odr);

  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_det_idx = ".$odr_det_idx,0); 
  $row_odr_det = mysql_fetch_array($result_odr_det);
 $row_ship = get_ship($row_odr["ship_idx"]);
 $tTy = $_SESSION["MEM_IDX"] == $row_odr["sell_mem_idx"] ? "S" : "B";

  if($row_odr_det["test".$tTy."_invoice"]==""){    
	  $sql = "update odr_det set test".$tTy."_invoice= '".get_auto_no("TFI", "odr_det" , "testS_invoice")."', test".$tTy."_date = now() where odr_det_idx=".$odr_det_idx;

	  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_det_idx = ".$odr_det_idx,0); 
	  $row_odr_det = mysql_fetch_array($result_odr_det);
  }

  $result_buyer = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"]),$row_odr_det["test".$tTy."_invoice"]);
  $row_buyer = mysql_fetch_array($result_buyer);

  $result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"]),$row_odr_det["test".$tTy."_invoice"]);
  $row_seller = mysql_fetch_array($result_seller);
	
  $result_parts = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",get_any("member", "min(mem_idx)", "mem_type = 0"),$row_odr_det["test".$tTy."_invoice"]); //사는 회사 정보
  $row_parts = mysql_fetch_array($result_parts);

 
?>


<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info" style="width:380px;">
	<?if ($for_readonly=="") { ?>
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/kor/images/parts_logo.png" width="75" height="18" alt=""></span>
				<span class="b2" lang="en">PARTStrike Co., Ltd</span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title2_1.png" alt="<?=GF_Common_GetSingleList("NA",$b_nation)?>"></span>
				<span lang="en">www.partstrike.com</span>
			</li>
		</ul>
	<?}else{?>
		<ul class="company-info pd-l30">			
				<?
				if ($row_seller["nation"]==$row_buyer["nation"])
				{
					$nation_val = $row_buyer["mem_nm"];
				}
				else
				{
					$nation_val = $row_buyer["mem_nm_en"];
				}
				?>
			<li>
				<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" width="75" height="18" alt=""></span>
				<span class="b2"><?=$nation_val?></span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title2_<?=$row_seller["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_seller["nation"])?>"></span>
				<span lang="en"><?=$row_seller["homepage"]?></span>
			</li>
			
		</ul>
		<ul class="contact-info">
			<li><?=$row_seller["addr_en"]?></li>
			<li><span class="tel">Tel : <?=$row_seller["tel"]?></span>Fax : <?=$row_seller["fax"]?> </li>
			<li><span class="tel">Contact : <?=$row_odr["rel_idx"]==0?$row_seller["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_odr["mem_idx"])?><br><?=get_any("member", "email", "mem_idx=".$row_odr["mem_idx"])?></li>
		</ul>
	<?}?>
	</div>
	
	<div class="order-info">
		<ul>
			<li class="b1"><strong>Test Fee Invoice No.</strong><span><?=$row_odr_det["test".$tTy."_invoice"]?></span></li>
			<li class="b2"><strong>Date</strong><span><?=$row_odr_det["test".$tTy."_date"]?></span></li>

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
			<ul class="company-info pd-l30">
				<?
				if ($row_seller["nation"]==$row_buyer["nation"])
				{
					$nation_val = $row_buyer["mem_nm"];
				}
				else
				{
					$nation_val = $row_buyer["mem_nm_en"];
				}
				?>
				<li>
					<span class="b1"><img src="/upload/file/<?=$row_buyer["filelogo"]?>" width="75" height="18" alt=""></span>
					<span class="b2" ><?=$nation_val?></span>
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
									$tel_nation = explode("-",$row_buyer["tel"]);
									$fax_nation = explode("-",$row_buyer["fax"]);

									$tel_buyer = str_replace($tel_nation[0]."-","0",$row_buyer["tel"]);
									$fax_buyer = str_replace($fax_nation[0]."-","0",$row_buyer["fax"]);
								?>
									<li><?=$row_buyer["mem_nm"]?></li>
									<li><?=$row_buyer["addr"]?></li>
									<li><span class="tel">Tel : <?=$tel_buyer?></span>Fax : <?=$fax_buyer?></li>
									<li>Contact : <?=$row_odr["rel_idx"]==0?$row_buyer["pos_nm"]:get_any("member", "mem_nm", "mem_idx=".$row_odr["mem_idx"])?> / <?=$row_odr["rel_idx"]==0?"CEO":get_any("member", "pos_nm", "mem_idx=".$row_odr["mem_idx"])?></li>
									<li><?=$row_buyer["email"]?><?=$testtt?></li>
								<?
								}
								else
								{								
									
								?>
									<li><?=$row_buyer["mem_nm_en"]?></li>
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
	
	<div class="seller-info" style="bottom:-8px">
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
						<span class="b1"><img src="/upload/file/<?=$row_seller["filelogo"]?>" alt="" width="75" height="18"></span>
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
		<h2><img src="/kor/images/st_tit_<?if ($for_readonly=="Y"){?>commercial_invoice<?}elseif($for_readonly=="P"){?>packing_list<?}else{?>invoice<?}?>.gif" alt="Invoice"></h2>
		<span class="currency">( Currency : US$ ) </span>
		<?echo GET_RCD_DET_LIST_V2(" and odr_idx=$odr_idx and odr_det_idx =$odr_det_idx" ,"21_4_06"); ?>			
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
			<?if ($forread!="Y"){ ?>
				<?if ($for_readonly!="Y"){ ?>
					<?	
						if ($for_readonly =="")
						{
							if ($row_seller["nation"]==$row_buyer["nation"] && $row_seller["nation"]==1)
							{ 
								echo get_bank_info($row_parts,"1");			
							}
							else
							{
								echo get_bank_info($row_parts,"-1");
							}			
						}			
						else
						{
							echo get_bank_info($row_parts,"-1");
						}
					?>
				<?}
			}
			else
			{
				echo get_bank_info($row_parts,"-1");
			}?>
			<?}?>
		</div>
	</div>
	
	<div class="etc-info2">
		<?if ($for_readonly!="P"){?>
		<div class="txt-area">
			<strong>CERTIFICATION and APPROVAL of INVOICE</strong>
			<p class="txt2" style="margin:0">I hereby certify that I as a member is well-informed with the PARTStrike’s  Treatments mentioned on the pages also will not violate any items mentioned  in the Treatment of PARTStrike and agrees to pay the above lists without any  complaints or argument. </p>
		</div>
		<?}?>
		<ul class="sign-area">
			<li><span>By :</span><strong class="sign"><img src="/upload/file/<?=$row_seller["filesign"]?>" width="180" height="21" alt=""></strong></li>
			<?
			//나라가 같을경우
			if ($row_seller["nation"]==$row_seller["nation"])
			{		
				$tel_nation = explode("-",$row_seller["tel"]);
				$fax_nation = explode("-",$row_seller["fax"]);

				$tel_buyer = str_replace($tel_nation[0]."-","0",$row_seller["tel"]);
				$fax_buyer = str_replace($fax_nation[0]."-","0",$row_seller["fax"]);
			?>
				<li><span>CEO : </span><strong><?=$row_seller["pos_nm"]?></strong></li>
				<li><span>Tel : </span><strong><?=$tel_buyer?></strong><span class="fax">Fax : </span><strong><?=$fax_buyer?></strong></li>
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
	
	<div class="btn-area t-rt">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
		
		<div class="f-rt">			
		<?
		$rnd_cnt = QRY_CNT("fty_history", "and odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and reason_ty='6'");
		if($rnd_cnt>0){
			$charge_type = "12";
		}else{
			$charge_type=$tTy=="S"?"13":"11";
		}
		if(QRY_CNT("mybank", "and odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and charge_type ='".$charge_type."' and charge_method = '2' and put_money_yn is null")==0){?>
			<button type="button" class="btn-pop-21-1-11" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" tot_amt="<?=$tot?>" fromLoadPage="21_4_06" charge_type="<?=$charge_type?>"><img src="/kor/images/btn_payment.gif" alt="결제"></button>
		<?}else{?>
		<button type="button" onclick="javascript:alert_msg('입금 확인 중입니다.');"><img src="/kor/images/btn_payment.gif" alt="결제" ></button>			
		<?}?>
		</div>
		
	</div>
</div>

