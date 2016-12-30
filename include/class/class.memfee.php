<?
function GF_GET_MEMFEE_LIST1(){
	global $viewpagecnt;
	if(!$_SESSION["MEM_IDX"]){ Page_Url("/kor/");}
	//$searchand=" and (a.charge_type=8 or a.charge_type=14) and a.rel_idx='".$_SESSION["MEM_IDX"]."' and a.mem_idx=b.mem_idx ";
	//$result =QRY_LIST(" mybank a, member b ","all","1",$searchand," a.reg_date DESC ");
	QRY_DELETE("memfee_temp"," and del_user_idx='".$_SESSION["MEM_IDX"]."' ");

?>	
<section class="box-type1">
	<div class="box-top">
		<h2>회원 가입비 <span lang="en">(Per 1 Year)</span></h2>
	</div>
	<form name="f3" method="post">
	<input type="hidden" name="typ" value="">
	<table class="stock-list-table">
		<thead>
			<tr>
			<th scope="col" class="th2" style="width:23px">No.</th>
			<th scope="col" class="th2 t-lt" lang="ko" style="width:85px">구분</th>
			<th scope="col" class="th2 t-lt" style="width:85px">User ID</th>
			<th scope="col" class="th2 t-lt" lang="ko">성명/직책</th>
			<th scope="col" class="th2 t-rt" style="width:85px">Amount</th>
			<th scope="col" class="th2" lang="ko">선택</th>
			</tr>
			</thead>
		<tbody>
			<?
			$searchand=" and (mem_idx='".$_SESSION["MEM_IDX"]."' or rel_idx='".$_SESSION["MEM_IDX"]."') ";
			$result =QRY_LIST(" member ","all","1",$searchand," mem_idx  ");
			?>
			<?
			$i=0;
			$k=0;
			while($row = mysql_fetch_array($result)){
				$i++;				
				$mem_idx= replace_out($row["mem_idx"]);
				$rel_idx= replace_out($row["rel_idx"]);
				$mem_id= cutbyte(replace_out($row["mem_id"]),15);
				$pos_nm_en = replace_out($row["pos_nm_en"]);
				//$amount= replace_out($row["amount"]);
				$mem_nm_en = replace_out($row["mem_nm_en"]);
				$amount_chk="";

				
				
				if($rel_idx!="0"){
					$gubun="직원";
					$amount = get_want("mybank","charge_amt"," and mem_idx='$mem_idx' and charge_type='14'");
					$end_date = get_want("mybank","end_date"," and mem_idx='$mem_idx' and charge_type='14'");
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
						$amount_chk="1";	//직원인데 가입비 안냈을경우
						$k = $k+1;
					}else{
						$amount_chk="2";	//직원인데 가입비 냇을경우
					}
					
				}else{
					$gubun="대표";
					$amount = get_want("mybank","charge_amt"," and mem_idx='$mem_idx' and charge_type='14'");
					if(!$amount){
						$amount= "1000";	
						echo "<input type='checkbox' name='mem_idx[]' value='$mem_idx' checked style='display:none;'>";
						$amount_chk="3";	//대표인데 가입비 안냈을경우
						$k = $k+1;
					}else{
						$amount= "1000";
						$amount_chk="4";	//대표인데 가입비 냈을경우
					}
					
				}

				if ($bgcolor == "background-color:#f7f7f7;" || $bgcolor=="") { 
					$bgcolor="background-color:#ffffff;";
				}else{
					$bgcolor ="background-color:#f7f7f7;";
				}
			?>
			<tr style="<?=$bgcolor?>">
				<td><?if($rel_idx!="0"){ ?><?=$i-1?><?}?></td>
				<td lang="ko" class="t-lt"><?=$gubun?></td>
				<td class="t-lt" style="width:85px"><?=$mem_id?></td>
				<td class="t-lt"><?=$mem_nm_en?>/<?=$pos_nm_en?></td>
				<td class="t-rt" style="width:85px">$<?=number_format($amount,2)?></td>
				<td>
				<label class="ipt-chk chk2">&nbsp;&nbsp;
				<? if($amount_chk=="1"){ ?><input name="mem_idx[]" type="checkbox" value="<?=$mem_idx?>" ><span></span>
				<? }else if($amount_chk=="2"){ ?><!--<img src="/kor/images/icon_v.png">--><!--<input name='tmp' class='checked' type='checkbox'>--><span><font color="red">가입완료</font></span>
				<? }else if($amount_chk=="3"){ ?><!--<img src="/kor/images/icon_vbox.png">--><input name='tmp' class='checked' type='checkbox'><span></span>
				<? }else if($amount_chk=="4"){ ?><!--<img src="/kor/images/icon_v.png">--><!--<input name='tmp' class='checked' type='checkbox'>--><span><font color="red">가입완료</font></span>
				<? }?>
				</label>
				</td>
			</tr>
			<?
			$ListNO--;		
			}
			//$year_date = date('Y-m-d', strtotime('1 years')); // 1년 전 일자

//echo $year_date;
			?>
		</tbody>					
	</table>
	</form>


	<div class="btn-area t-rt">
		<p class="f-lt c-red mr-a0">가입일 기준 월 변경 시 <span lang="en">US$10.00</span>씩 차감</p>
		<?if($k>0){?>
			<a href="javascript:check();"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장확인"></a>
		<?}else{?>
			<img src="/kor/images/btn_invoice_confirm_1.gif" alt="송장확인">
		<?}?>
	</div>
</section>
<?}?>

<?
function GF_GET_MEMFEE_LIST2($page){
	global $viewpagecnt;
?>	
<script type="text/javascript">
<!--
	$(document).ready(function(){		
		$(".pagination a.link").click(function(){
			showajaxParam("#memfeeleftBottom", "memfee2", "page="+$(this).attr("num"));
		});				
	 });
//-->
</script>

<section class="box-type1">
	<div class="box-top">
		<h2>내 회원 가입비</h2>
	</div>
	<table class="stock-list-table">
		<thead>
		<tr>	
			<th scope="col" class="th2" style="width:23px">No.</th>
			<th scope="col" class="th2" lang="ko" style="width:210px">기간</th>
			<th scope="col" class="th2 t-lt" style="width:85px">User ID</th>
			<th scope="col" class="th2 t-lt" lang="ko">성명/직책</th>
			<th scope="col" class="th2">&nbsp;</th>
		</thead>
		<tbody>
		<?
			if(!$page){$page=1;}
			$recordcnt=5;
			$cnt = QRY_CNT2("DISTINCT(invoice_no) "," mybank "," and (com_idx='".$_SESSION["REL_IDX"]."' or com_idx='".$_SESSION["MEM_IDX"]."') and charge_type='14'" );
			$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
			$searchand=" and (a.com_idx='".$_SESSION["REL_IDX"]."' or a.com_idx='".$_SESSION["MEM_IDX"]."')  and a.charge_type='14' and a.mem_idx=b.mem_idx ";
			$result =QRY_C_LIST_GROUP("a.*, b.mem_id,b.mem_nm_en,b.pos_nm_en"," mybank a, member b ",$recordcnt,$page,$searchand," a.invoice_no  order by a.mybank_idx desc");
			?>
			<?
			$ListNO=$cnt-(($page-1)*$recordcnt);
			$i=0;
			while($row = mysql_fetch_array($result)){
				$i++;		
				$mybank_idx= replace_out($row["mybank_idx"]);
				$mem_id= cutbyte(replace_out($row["mem_id"]),15);
				$rel_idx= replace_out($row["rel_idx"]);
				$mem_nm_en= replace_out($row["mem_nm_en"]);
				$pos_nm_en = replace_out($row["pos_nm_en"]);
				$invoice_no = replace_out($row["invoice_no"]);
				$reg_date = substr(replace_out($row["reg_date"]),0,10);
				$end_date = replace_out($row["end_date"]);
				//$amount= replace_out($row["amount"]);
				$amount_chk="";
				if ($bgcolor == "background-color:#f7f7f7;" || $bgcolor=="") { 
					$bgcolor="background-color:#ffffff;";
				}else{
					$bgcolor ="background-color:#f7f7f7;";
				}
			?>
			<tr style="<?=$bgcolor?>">
				<td><?=$ListNO?></td>
				<td class="c-red2" lang="en" style="letter-spacing:0"><?=substr($reg_date,0,4)?><span lang="ko">년</span> <?=substr($reg_date,5,2)?><span lang="ko">월</span> <?=substr($reg_date,8,2)?>일 ~ 
				<?=substr($end_date,0,4)?><span lang="ko">년</span> <?=substr($end_date,5,2)?><span lang="ko">월</span> <?=substr($reg_date,8,2)?><span lang="ko">일</span></td>
				<td class="t-lt" style="width:85px"><?=$mem_id?></td>
				<td class="t-lt"><?=$mem_nm_en?>/<?=$pos_nm_en?></td>
				<td class="t-rt pd-0"><a href="javascript: memfee_det(<?=$mybank_idx?>);"><img src="/kor/images/btn_record3.gif" alt="기록"></a></td>
			</tr>
			<?
				$ListNO--;
			}
			?>
			
		</tbody>					
	</table>
<div class="pagination">
				<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
			</div>
</section>

<?	}?>
