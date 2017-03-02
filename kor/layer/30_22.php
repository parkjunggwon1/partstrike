<?
/*****************************************************************************************************
*** What's New : 수령(30_22) - 판매자용
*****************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.record.php";
?>
<!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li class="current"><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_on.png" alt="판매"></a></li>
		<li><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_off.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<!-- //layer-tab -->
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$("#layerPop .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	});
	function show_msg(idx){
		$("#msg_cont_"+idx).toggle("fast");
	}
</SCRIPT>
<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/sell_menu.php"); 
$recordcnt = 1;
$searchand .= "and sell_mem_idx = ".$_SESSION["MEM_IDX"]." and status = $status and confirm_yn='N' "; 			

$cnt = QRY_CNT("odr_history",$searchand);				
if ($cnt == 0 ){?>
<div class="layer-file">
		<table>
			<tbody>
				<tr>		
					
					<td class="c-red2 w100 t-ct"><!--수령 내역이 없습니다.--></td>
				</tr>
			</tbody>
		</table>
	</div>	
<?}else{
	if (!$page){ $page = 1;}
	$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
	$result =QRY_ODR_HISTORY_LIST($recordcnt, $searchand, $page, "odr_history_idx desc");
	if($result){
		$row = mysql_fetch_array($result);
		$odr_idx= replace_out($row["odr_idx"]);	
		//2016-05-18 : odr_det_idx
		$odr_det_idx= replace_out($row["odr_det_idx"]);
		$fault_yn = replace_out($row["fault_yn"]);
		//2016-05-20
		$det_cnt = QRY_CNT("odr_det", "and odr_idx= $odr_idx");
	}

	?>
	<!-- //layer-left-menu -->

	<!-- layer-content -->
	<div class="layer-content">
		<!-- layer-pagination -->
		<div class="layer-pagination">
				<? 
				$layerNum="layer";
				$loadPage = "30_22";
				$varNum = "?mn=0$status&status=$status";			
				include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
		</div>
		<input type="hidden" name="det_cnt" id="det_cnt_3022" value="<?=$det_cnt?>">
		<!-- //layer-pagination -->
	<? //2016-05-18 : history에 odr_det_idx(개별) 유무에 따라 다르게 호출
		//echo "Layer:30_22 / odr_idx:".$odr_idx." / odr_det_idx:".$odr_det_idx."<br>";
		if($odr_det_idx>0){  // 개별 History -------------------------------------------
			//fault 수령은 별도처리 필요
			if($fault_yn == "Y"){
				//echo GET_ODR_HISTORY_LIST("30_20_F", $odr_idx, $odr_det_idx);
				echo GET_ODR_HISTORY_LIST("30_22_F", $odr_idx, $odr_det_idx);
			}else{
				echo GET_ODR_HISTORY_LIST("30_22", $odr_idx, $odr_det_idx);				
			}
		}else{  //------------- odr 단위 History -----------------------------------------
			echo GET_ODR_HISTORY_LIST("30_22", $odr_idx);

		}
	?>
	<?//=GET_ODR_HISTORY_LIST("30_22", $odr_idx)  //JSJ?>

</div>
<!-- //layer-content -->
<?}?>