<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--

function pay(){
		var f =  document.f;
		var formData = $("#f").serialize(); 
		$.ajax({
				url: "/kor/proc/record_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
					//var splData = data.split(":");
					if (trim(data) == "SUCCESS"){			
						alert_msg("결제가 완료되었습니다.");
						location.href='/kor/';
					}else{
						alert(data);
					}
				}
		});		

	}
//-->
</SCRIPT>
<?  $summybank =  str_replace(",","",SumMyBank($session_mem_idx, $session_rel_idx));		
	$balance = $summybank - $tot_amt;
	$sell_mem_idx = get_any("odr", "sell_mem_idx" , "odr_idx = $odr_idx");
	$sell_rel_idx = get_any("odr", "sell_rel_idx" , "odr_idx = $odr_idx");
	
?>
<form name="f" id="f">
	<!-- form1 -->
	<input type="hidden" name="typ" id="typ" value="pay_compensation">
	<input type="hidden" name="mem_idx" id="mem_idx" value="<?=$session_mem_idx?>">
	<input type="hidden" name="rel_idx" id="rel_idx" value="<?=$session_rel_idx?>">	
	<input type="hidden" name="tot_amt" id="tot_amt" value="<?=$tot_amt?>">		
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">		
	<input type="hidden" name="sell_rel_idx" id="sell_mem_idx" value="<?=$sell_rel_idx?>">		
	<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
	<input type="hidden" name="odr_det_idx" id="odr_idx" value="<?=$odr_det_idx?>">		
	
	<!-- //form1 -->
</form>

<div class="layer-hd red">
	<h1><span lang="en">My Bank</span></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	
	<table class="price-table1" lang="en" align="center">
		<tbody>
			<tr>
				<th scope="row"><span class="c-purple">My Bank</span> : </th>
				<td><span class="c-blue">US$ <?=number_format($summybank,2)?></span></td>
			</tr>
			<tr>
				<th scope="row"><span class="c-red">(-)</span> Total Amount : </th>
				<td><span class="c-blue">US$ <?=number_format($tot_amt,2)?></span></td>
			</tr>
			<tr class="lst">
				<td colspan="2"></td>
			</tr>
			<tr>
				<th scope="row"><span class="c-red" lang="ko">잔액 : </span></th>
				<td><span class="c-red">US$ <?=number_format($balance,2)?></span></td>
			</tr>
		</tbody>
	</table>
	<div class="btn-area t-rt">
		<a href="javascript:pay();" ><img src="/kor/images/btn_payment.gif" alt="결제"></a><!--class="btn-dialog-18-2-12"-->
	</div>
</div>

