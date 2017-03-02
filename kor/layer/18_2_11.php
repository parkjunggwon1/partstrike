<?
/***************************************************************************************
*** MyBank - POP : 18_2_11
***************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--

function pay(){
		var f =  document.f;
		var formData = $("#f").serialize(); 
		openCommLayer("layer6","alert_pay_ok","?alert_msg="+encodeURIComponent('결제가 완료되었습니다.'));
		return;
		/*
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
				
					//var splData = data.split(":");
					if (trim(data) == "SUCCESS"){			
						<?if ($typ=="pay_access"){?>
							openCommLayer("layer3","18_2_12","?odr_idx=<?=$odr_idx?>&odr_det_idx=<?=$odr_det_idx?>&tot_amt=<?=$tot_amt?>");
						<?}else{?>
							//alert_msg("결제가 완료되었습니다.");
							//location.href='/kor/';						
						<?}?>
						
					}else if (trim(data) == "SUCCESS-Deposit")
					{	
						closeCommLayer("layer4");
						closeCommLayer("layer5");
						openCommLayer("layer","17_16","?mn=05&odr_idx=<?=$odr_idx?>");
					}else{
						alert(data);
					}
				}
		});		
		*/

	}
//회원가입비
function pay2(){
		var f =  document.f;
		var formData = $("#f").serialize(); 
		$.ajax({
				url: "/kor/proc/memfee_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
					//var splData = data.split(":");
					if (trim(data) == "SUCCESS"){	
						closeCommLayer("layer4")
						closeCommLayer("layer5")
						showajaxParam("#memfeeleftTop", "memfee1", "");
						showajaxParam("#memfeeleftBottom", "memfee2", "");
					}else{
						alert(data);
					}
				}
		});		

	}
//-->
</SCRIPT>
<?
	$summybank =  str_replace(",","",SumMyBank2($session_mem_idx, $session_rel_idx, 0)); //2016-05-27 : SumMyBank -> SumMyBank2 로 변경
	$tot_amt = str_replace(",","",$tot_amt);
	$balance = $summybank - $tot_amt;

	$odr = get_odr($odr_idx);
	$mem_idx = $odr[mem_idx];
	$rel_idx = $odr[rel_idx];
	$sell_mem_idx = $odr[sell_mem_idx];
	$sell_rel_idx = $odr[sell_rel_idx];
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
	<input type="hidden" name="deposit_yn" id="deposit_yn" value="<?=$deposit_yn?>">		

	
	<!-- //form1 -->
</form>
<?
	$odr = get_odr_det($odr_idx);

	//이미 다 계산 한 값 넘긴건데???
/*	if ($odr[part_type]=="2" && $odr[period]*1 >2){	 //지속 공급 가능 주문일 경우에(2주 이상만).
		if ($sell_mem_idx == $session_mem_idx){
			$tot_amt = $tot_amt / 10;
		}else{
			$pay_cnt = QRY_CNT("odr_history", "and odr_idx = $odr_idx and status=5"); 
			if ($pay_cnt >0) {   //해당 주문에 대해 계약금 결제를 한적이 있으므로 나머지 금액 결제
				$tot_amt = $tot_amt - $tot_amt / 10;
			}else{
				$tot_amt = $tot_amt / 10;
			}
		}
		$balance = $summybank - $tot_amt;
	}
*/
?>
<div class="layer-hd">
	<h1><span lang="en">My Bank</span></h1>
	<a href="#" class="btn-close btn-pop-3012"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	
	<table class="price-table1" lang="en" align="center">
		<tbody>
			<tr>
				<th scope="row"><span class="c-blue">My Bank</span> : </th>
				<td><span class="c-blue">$ <?=number_format($summybank,4)?></span></td>
			</tr>
			<tr>
				<th scope="row"><span class="c-red">(-) Total : </span></th>
				<td><span class="c-red">-$ <?=number_format($tot_amt,4)?></span></td>
			</tr>
			<tr class="lst">
				<td colspan="2"></td>
			</tr>
			<tr>
				<th scope="row"><span class="c-purple" lang="ko">잔액 : </span></th>
				<td><span class="c-purple">$ <?=number_format($balance,4)?></span></td>
			</tr>
		</tbody>
	</table>
	<div class="btn-area t-rt">
	<?if ($balance > 0){?>
		<a href="javascript:pay<?=$charge_type=="14"?"2":""?>();" ><img src="/kor/images/btn_payment.gif" alt="결제"></a><!--class="btn-dialog-18-2-12"-->
	<?}else{?>
		<img src="/kor/images/btn_payment_1.gif" alt="결제">
	<?}?>
	</div>
</div>

