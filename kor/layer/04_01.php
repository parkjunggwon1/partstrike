<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!--
	function del(tbl, idx){
//		if (confirm('정말 삭제하시겠습니까?'))
//		{
			$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: "tbl="+tbl+"&idx="+idx+"&typ=del",
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						$("#tr_"+idx).remove();
					}else{
						alert(data);
					}
				}
		});		
//		}
	}

	$("input[name^=odr_det_idx]").click(function(e){
		if($(this).hasClass("checked")==false){  //누르는 순간 체크 됨.
			//check 됐을때.
			if ($("#chked_cnt").val() == 0)
			{
				if ($(this).hasClass("endure"))
				{
					$("input[name^=odr_det_idx].stock").prop("disabled",true);
					$("#whole_part_type").val("E");
				}else{
					$("input[name^=odr_det_idx].endure").prop("disabled",true);
					$("#whole_part_type").val("S");
				}
			}			
			
			$("#chked_cnt").val(parseInt($("#chked_cnt").val())+1);
		}else{  //누르는 순간 체크 해제 됨.
		
			if ($("#chked_cnt").val() == 1)
			{
				$("input[name^=odr_det_idx].stock").prop("disabled",false);
				$("input[name^=odr_det_idx].endure").prop("disabled",false);
				$("#whole_part_type").val("");
			}			
			$("#chked_cnt").val(parseInt($("#chked_cnt").val())-1);
		}
		
	});
//-->
</SCRIPT>

<!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_off.png" alt="판매"></a><a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a></li>
		<li class="current"><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_on.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a>
</div>
<!-- //layer-tab -->


<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); 
$recordcnt = 1;
$searchand .= "and mem_idx = ".$_SESSION["MEM_IDX"]." and save_yn = 'Y'"; 			
//echo $searchand;

$cnt = QRY_CNT("odr",$searchand);				

if ($cnt == 0 ){?>
<div class="layer-file">
		<table>
			<tbody>
				<tr>		
					
					<td class="c-red2 w100 t-ct"><!--저장된 발주서가 없습니다.--></td>
				</tr>
			</tbody>
		</table>
	</div>	
<?}else{
	if (!$page){ $page = 1;}
	$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
	$result =QRY_ODR_LIST($recordcnt, $searchand, $page, "odr_idx desc");
	if($result){
		$row = mysql_fetch_array($result);
		$odr_idx= replace_out($row["odr_idx"]);	
	}
	?>
	<!-- //layer-left-menu -->
	<? $odr=get_odr($odr_idx);
		$sell_mem_idx = $odr[sell_mem_idx];
		$sell_rel_idx = $odr[sell_rel_idx];
		$ship_info= $odr[ship_info];
		$ship_account_no= $odr[ship_account_no];
		$insur_yn= $odr[insur_yn];
		$memo= $odr[memo];
	?>
	<form name="f" id="f">
		<input type="hidden" name="odr_idx" id="odr_idx_05_04" value="<?=$odr_idx?>">	
		<input type="hidden" name="typ" id="typ" value="">
		<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
		<input type="hidden" name="sell_rel_idx" id="sell_rel_idx" value="<?=$sell_rel_idx?>">
		<input type="hidden" name="session_mem_idx" id="session_mem_idx" value="<?=$session_mem_idx?>">
		<input type="hidden" name="session_rel_idx" id="session_rel_idx" value="<?=$session_rel_idx?>">
		<input type="hidden" name="chked_cnt" id="chked_cnt" value="0">
		<input type="hidden" name="new_odr_idx" id="new_odr_idx" value="">
		<input type="hidden" name="save_yn" id="save_yn" value="">
		<input type="hidden" name="whole_part_type" id="whole_part_type" value="">

		<!-- layer-content -->
		<div class="layer-content">
			<!-- layer-pagination -->
			<div class="layer-pagination">
					<? 
					$layerNum="layer";
					$loadPage = "04_01";
					$varNum = "?mn=02";			
					include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
			</div>
			<!-- //layer-pagination -->
			<?=GET_ODR_HISTORY_LIST("04_01", $odr_idx);?>
			<div class="btn-area t-rt">
			<button type="button" class="btn-dialog-0501"><img src="/kor/images/btn_order_add.gif" alt="발주 추가"></button>
			<button type="button" class="btn-order-confirm"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></button>
			<!--<button type="button" class="btn-dialog-save"><img src="/kor/images/btn_order_save.gif" alt="발주 저장"></button>-->
			</div>
		</div>
	</form>
		<!-- //layer-content -->
	<?}?>

