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

  $row_ship = get_ship($row_odr_det["ship_idx"]);

 if($row_odr_det["refund_invoice"]==""){ 
	  $sql = "update odr_det set refund_invoice= '".get_auto_no("RI", "odr_det" , "refund_invoice")."', refund_date = now() where odr_det_idx=".$odr_det_idx;
	  $result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	  $result_odr_det =QRY_ODR_DET_LIST(0,"and odr_det_idx = ".$odr_det_idx,0); 
	  $row_odr_det = mysql_fetch_array($result_odr_det);
  }

  $result_buyer = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["rel_idx"]==0?$row_odr["mem_idx"]:$row_odr["rel_idx"]),$row_odr_det["refund_invoice"]);
  $row_buyer = mysql_fetch_array($result_buyer);

  $result_seller = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",($row_odr["sell_rel_idx"]==0?$row_odr["sell_mem_idx"]:$row_odr["sell_rel_idx"]),$row_odr_det["refund_invoice"]);
  $row_seller = mysql_fetch_array($result_seller);


	$result_parts = QRY_ODR_MEMBER_VIEW($odr_idx,"idx",get_any("member", "min(mem_idx)", "mem_type = 0"),$row_odr_det["refund_invoice"]); //파츠 회사 정보
	$row_parts = mysql_fetch_array($result_parts);

$sql_ship = "select * from ship where ship_idx =".$row_odr_det['ship_idx'];

$ship_result = mysql_query($sql_ship,$conn) or die ("SQL Error : ". mysql_error());
$ship_row = mysql_fetch_object($ship_result);

?>



<div class="sheet-img"><img src="/kor/images/sheet_bg.jpg" alt=""></div>
<div class="sheet-wrap">
	<div class="top-info">
		<ul class="company-info">
			<li>
				<span class="b1"><img src="/kor/images/parts_logo.png" width="75" height="18" alt=""></span>
				<span class="b2" lang="en"><?=$row_parts["mem_nm_en"]?></span>
			</li>
			<li>
				<span class="b1"><img src="/kor/images/nation_title2_1.png"></span>
				<span lang="en"><?=$row_parts["homepage"]?></span>
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
			<li class="b3"><strong>Ship Via</strong><span><img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship_row->ship_info))?>.gif" alt="" height="10"></span></li>
			<li><strong>Account No.</strong><span><?=$ship_row->ship_account_no?></span></li>
			<li class="b2"><strong>Transport insurance</strong><span><?if ($ship_row->insur_yn=="Y"){echo "Y";}else{echo "N";}?></span></li>
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
		<?if ($read_chk!="Y"){?>
		<div class="f-rt">			
			<button type="button" onclick="check();"><img src="/kor/images/btn_refund.gif" alt="환불"></button>
		</div>
		<?}?>
	</div>
</div>
<?
$fault_select = get_any("odr_history", "fault_select", "odr_idx=$odr_idx AND odr_det_idx=$odr_det_idx AND status=11");
?>
<form name="f6" id="f6" method="post" enctype="multipart/form-data">		
	<input type="hidden" name="typ" value="refund2">
	<input type="hidden" name="odr_idx" id="odr_19_1_04" value="<?=$odr_idx?>">
	<input type="hidden" name="odr_det_idx" id="det_19_1_04" value="<?=$odr_det_idx?>">
	<input type="hidden" name="odr_history_idx" id="history_19_1_04" value="<?=$odr_history_idx?>">
	<input type="hidden" name="mem_idx" value="<?=$row_odr["mem_idx"]?>">
	<input type="hidden" name="rel_idx" value="<?=$row_odr["rel_idx"]?>">
	<input type="hidden" name="sell_mem_idx" value="<?=$row_odr["sell_mem_idx"]?>">
	<input type="hidden" name="sell_rel_idx" value="<?=$row_odr["sell_rel_idx"]?>">
	<input type="hidden" name="tot_amt" value="<?=$tot_amt?>">
	<input type="hidden" name="fault_select" value="<?=$fault_select?>">
	<input type="hidden" name="charge_method" value="MyBank">
	
	<input type="hidden" name="invoice_no" value="<?=$row_odr_det["refund_invoice"]?>">
</form>

<SCRIPT LANGUAGE="JavaScript">
<!--


function check(){
		var f =  document.f6;				
		//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')");
		f.tot_amt.value = $("input[id^=tot_]").val();
		

		var odr_idx = $("#odr_19_1_04").val();
		var det_idx = $("#det_19_1_04").val();
		var odr_history_idx = $("#history_19_1_04").val();
		var formData = $("#f6").serialize();
		/*
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){		
						//openCommLayer("layer3","19_1_05","?forgenl=<?=$forgenl?>");	
						openCommLayer("layer3","19_1_05","?forgenl=<?=$forgenl?>&odr_idx="+odr_idx+"&odr_det_idx="+det_idx+"&odr_history_idx="+odr_history_idx);
					}else{
						alert(data);
					}
				}
		});*/
		openCommLayer("layer3","19_1_05","?forgenl=<?=$forgenl?>&"+formData+"&odr_det_idx="+det_idx+"&odr_history_idx="+odr_history_idx);
		//openCommLayer("layer3","19_1_05","?forgenl=<?=$forgenl?>&odr_idx="+odr_idx+"&odr_det_idx="+det_idx+"&odr_history_idx="+odr_history_idx);

	}

-->
</SCRIPT>