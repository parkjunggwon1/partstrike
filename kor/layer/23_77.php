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

 $invoice_no=get_auto_no("MFI", "mybank" , "invoice_no");
// $invoice_date = date("Y-m-d"); 
 $invoice_date = date("d,M,Y"); 

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
				<span lang="en"><img src="/kor/images/nation_title2_<?=$row_parts["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_parts["nation"])?>"> <?=$row_parts["homepage"]?> </span>				 
			</li>
		</ul>
		<ul class="contact-info">
			<li><?=$row_parts["addr_det_en"]?> <?=$row_parts["addr_en"]?></li>
			<li><span class="tel">Tel : <?=$row_parts["tel"]?></span>Fax : <?=$row_parts["fax"]?></li>
			<li><span class="tel">Contact : <?=$row_parts["rel_idx"]==0?$row_buyer["pos_nm_en"]:get_any("member", "mem_nm_en", "mem_idx=".$row_parts["mem_idx"])?> / <?=$row_parts["rel_idx"]==0?"CEO":get_any("member", "pos_nm_en", "mem_idx=".$row_parts["mem_idx"])?><br><?=get_manage_email($row_buyer["nation"])?></li>
		</ul>
	</div>
	<div class="order-info">
		<ul>			
			<li class="b1"><strong>
				Membership Fee Invoice No.</strong><span><?=$invoice_no?></span>
			</li>
			<li class="b2"><strong>Date</strong><span><?=$invoice_date?></span></li>
			<li><strong>Page</strong><span>1</span></li>
		</ul>
		<ul>
			<li class="b3"><strong>Ship Via</strong><span></span></li>
			<li><strong>Account No.</strong><span></span></li>
			<li class="b2"><strong>Transport insurance</strong><span></span></li>
		</ul>
		<ul>
			<li class="b1"><strong>Payment Term</strong><span>CBD</span></li>
			<li><img src="/kor/images/nation_title_<?=$row_parts["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_parts["nation"])?>" class="country"><strong>Incoterms</strong><span>EXW-</span></li>
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
					<span class="b1"><img src="/kor/images/nation_title2_<?=$row_buyer["nation"]?>.png" alt="<?=GF_Common_GetSingleList("NA",$row_buyer["nation"])?>"></span>
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
	<form name="f5" method="post">
	<input type="hidden" name="typ" value="">
	<input type="hidden" name="memfee_id" value="<?=$memfee_id?>">
	<input type="hidden" name="charge_type" value="14">
	<div class="order-table">
		<h2><img src="/kor/images/st_tit_invoice.gif"></h2>
		<span class="currency">( Currency : US$ ) </span>
		<!---real-->
		<table>
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col">User Name.</th>
					<th scope="col">Description</th>
					<th scope="col">Name/Job Title</th>
					<th scope="col">Unit Price</th>
					<th scope="col">Amount</th>
				</tr>
			</thead>
			<tbody>
			<?
				$searchand = " and a.memfee_id='$memfee_id' and a.mem_idx=b.mem_idx";
				$result =QRY_LIST("memfee_temp a, member b","all",1,$searchand," charge_type ASC, a.mem_idx ASC");
				$tot = 0;
				while($row = mysql_fetch_array($result)){
						$i++;				
						$memfee_id= replace_out($row["a.part_idx"]);
						$user_idx= replace_out($row["user_idx"]);
						$rel_idx= replace_out($row["rel_idx"]);
						$mem_idx= replace_out($row["mem_idx"]);
						$charge_type= replace_out($row["charge_type"]);
						$reg_date= replace_out($row["reg_date"]);
						$mem_nm_en= replace_out($row["mem_nm_en"]);
						$pos_nm_en= replace_out($row["pos_nm_en"]);



						$mybank_idx = get_want("mybank","mybank_idx"," and mem_idx='$mem_idx' and charge_type='$charge_type'");
						if(!$mybank_idx){
							if($rel_idx!="0"){
								$amount = get_want("mybank","charge_amt"," and mem_idx='$mem_idx' and charge_type='$charge_type'");
								$end_date = get_want("mybank","end_date"," and mem_idx='$mem_idx' and charge_type='$charge_type'");
								if($end_date){
									$nowdate = date("Y-m");	
									$end_date = substr($end_date,0,7);

									$a = substr($end_date,0,4)*12 + substr($end_date,5,2); 
									$b = substr($nowdate,0,4)*12 + substr($nowdate,5,2); 
									$c = ($b-$a)*(-1); 
								}else{
									$c=12;
								}
								if(!$amount){
									$amount= 10*$c;
									
								}
								$description="Staff";
							}else{
								$amount = get_want("mybank","charge_amt"," and mem_idx='$mem_idx' and charge_type='$charge_type'");
								if(!$amount){
									$amount= "1000";	
								}
								$description="Representer";
								$pos_nm_en="CEO";
							}
							
							$tot = $tot+$amount;
						?>
							<tr>
								<td><?=$i?></td>
								<td><?=$mem_nm_en?></td>
								<td><?=$description?></td>
								<td><?=$mem_nm_en?> (<?=$pos_nm_en?>)</td>
								<td>$<?=number_format($amount,2)?></td>
								<td>$<?=number_format($amount,2)?></td>
							</tr>
						<?
						}
				}
			?>
			</tbody>
			</table>	
			<ul class="total-price">
				<li class="sub"><strong>Sub Total :</strong><span>$<?=number_format($tot,2)?>				
				<input type="hidden" name="tot" id="tot_<?=$odr_idx?>" value="<?=$tot?>"></span></li>
				<li class="total"><strong>Total :</strong><span>$<?=number_format($tot,2)?></span></li>
			</ul>			
	</div>
	<input type="hidden" name="tot_amt" value="<?=$tot?>">
	</form>
	<!-- //order-table -->
	
	<div class="etc-info1">
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
	
	<div class="btn-area">
		<button type="button" class="f-lt"><img src="/kor/images/btn_print.gif" alt="인쇄"></button>
		<button type="button" class="f-rt" onclick="check3();"><img src="/kor/images/btn_payment.gif" alt="결제"></button>
	</div>
</div>
