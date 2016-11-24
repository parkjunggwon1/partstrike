<?
/*****************************************************************************************************
*** What's New : 수령(30_23) - 구매자용
*****************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li class="current"><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_off.png" alt="판매"></a></li>
		<li><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_on.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a>
</div>
<!-- //layer-tab -->

<!-- 30_22 수령 페이지를 보고, 구매자용도 수령 페이지 만듬. (아직 confirm_yn = 'N'일때)
<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); 
$recordcnt = 1;
$searchand .= "and buy_mem_idx = ".$_SESSION["MEM_IDX"]." and status = $status and confirm_yn='N' "; 			
$cnt = get_any("odr_history" , "count(distinct(odr_idx))", "1=1 ".$searchand);
//echo $cnt;
//$cnt = QRY_CNT("odr_history",$searchand);				
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

	$result =QRY_ODR_DIST_LIST($recordcnt, $searchand, $page, "odr_history_idx desc");
	//echo $searchand;
	if($result){
		$row = mysql_fetch_array($result);
		$odr_idx= replace_out($row["odr_idx"]);	
	}
	?>
	<!-- //layer-left-menu -->

	<!-- layer-content -->
	<div class="layer-content">
		<!-- layer-pagination -->
		<div class="layer-pagination">
				<? 
				$layerNum="layer";
				$loadPage = "30_23";
				$varNum = "?mn=15&status=$status";			
				include $_SERVER["DOCUMENT_ROOT"]."/include/paging3.php"; ?>								
		</div>
		<!-- //layer-pagination -->
	<?=GET_ODR_HISTORY_LIST("30_23", $odr_idx)?>

</div>
<!-- //layer-content -->
<?}?>