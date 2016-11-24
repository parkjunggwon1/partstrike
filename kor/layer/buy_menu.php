<?
/***********************************************************************************************************************
*** What's New[구매자] 좌측 탭(책갈피) 메뉴
***********************************************************************************************************************/
if ($_SESSION["MEM_IDX"]==""){
	Page_Msg_Url("로그인이 필요합니다.","/kor/");
}

$mn = $_GET['mn']; ?>
<div class="layer-left-menu">
	<ul>
		<li class="buy-mn01<? if($mn=='01'){ ?> current this<? } ?>"><?=get_menu_view_buy("납기 확인","odr", 16)?></li>
		<!--<li class="buy-mn02<? if($mn=='02'){ ?> current this<? } ?>"><?=get_menu_view_buy("발주서 저장","odr", "save")?></li>-->
		<li class="buy-mn03-3010<? if($mn=='03'){ ?> current this<? } ?>"><?=get_menu_view_buy("송장","odr", 18)?></li>
		<li class="buy-mn04<? if($mn=='04'){ ?> current this<? } ?>"><?=get_menu_view_buy("도착","odr", 19)?></li>
		<li class="buy-mn05<? if($mn=='05'){ ?> current this<? } ?>"><?=get_menu_view_buy("지연","odr", 20)?></li>
		<li class="buy-mn06<? if($mn=='06'){ ?> current this<? } ?>"><?=get_menu_view_buy("납기 연장","odr", 4)?></li>
		<li class="buy-mn07<? if($mn=='07'){ ?> current this<? } ?>"><?=get_menu_view_buy("결제 완료","odr", 5)?></li>
		<li class="buy-mn08<? if($mn=='08'){ ?> current this<? } ?>"><?=get_menu_view_buy("선적 완료","odr", 21)?></li>
		<li class="buy-mn09<? if($mn=='09'){ ?> current this<? } ?>"><?=get_menu_view_buy("삭제","odr", 7)?></li>
		<li class="buy-mn10<? if($mn=='10'){ ?> current this<? } ?>"><?=get_menu_view_buy("취소","odr", 8)?></li>
		<li class="buy-mn11<? if($mn=='11'){ ?> current this<? } ?>"><?=get_menu_view_buy("거절","odr", 9)?></li>
		<li class="buy-mn12<? if($mn=='12'){ ?> current this<? } ?>"><?=get_menu_view_buy("수량 부족","odr", 10)?></li>
		<li class="buy-mn13<? if($mn=='13'){ ?> current this<? } ?>"><?=get_menu_view_buy("반품 방법","odr", 22)?></li>
		<li class="buy-mn14<? if($mn=='14'){ ?> current this<? } ?>"><?=get_menu_view_buy("추가 선적 완료","odr", 23)?></li>
		<li class="buy-mn15<? if($mn=='15'){ ?> current this<? } ?>"><?=get_menu_view_buy("수령","odr", 6)?></li>
		<li class="buy-mn16<? if($mn=='16'){ ?> current this<? } ?>"><?=get_menu_view_buy("환불","odr", 24)?></li>
	</ul>
	<ul class="menu2">
		<li class="buy-mn17<? if($mn=='17'){ ?> current this<? } ?>"><?=get_menu_view_buy("불량 통보","fty", 12)?></li>
		<li class="buy-mn18<? if($mn=='18'){ ?> current this<? } ?>"><?=get_menu_view_buy("동의서","fty", 13)?></li>
		<li class="buy-mn19<? if($mn=='19'){ ?> current this<? } ?>"><?=get_menu_view_buy("반품 선적 완료","fty", 25)?></li>
		<li class="buy-mn20<? if($mn=='20'){ ?> current this<? } ?>"><?=get_menu_view_buy("거절","fty", 26)?></li>
		<li class="buy-mn21<? if($mn=='21'){ ?> current this<? } ?>"><?=get_menu_view_buy("결제 완료","fty", 27)?></li>
		<li class="buy-mn22<? if($mn=='22'){ ?> current this<? } ?>"><?=get_menu_view_buy("결과 공지","fty", 14)?></li>
		<li class="buy-mn23<? if($mn=='23'){ ?> current this<? } ?>"><?=get_menu_view_buy("반품 방법","fty", 29)?></li>
		<li class="buy-mn24<? if($mn=='24'){ ?> current this<? } ?>"><?=get_menu_view_buy("수령","fty", 28)?></li>
		<li class="buy-mn25<? if($mn=='25'){ ?> current this<? } ?> last"><?=get_menu_view_buy("종료","fty", 30)?></li>
	</ul>
</div> 

<?function get_menu_view_buy($menu_name, $his_ty , $no){
	if ($no =="save"){
		$mcnt = GET_SAVE_CNT();
	}else{
		if ($no =="12" || $no =="13") {
			$searchand = " and buy_mem_idx = '".$_SESSION["MEM_IDX"]."'";
		}
		$mcnt = GET_MENU_CNT("buy", $no, $his_ty , $searchand);
	}
	$str = "<a";
	if($mcnt > 0 ) {		$str.=" href='#'";	}
	$str.= " >$menu_name<span class='count'>$mcnt</span></a>";
	return $str;
}?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(document).ready(function(){
		if($(".stock-list-table input[type=checkbox]").length==1){
			$(".stock-list-table input[type=checkbox]:eq(0)").addClass("checked").attr("checked","checked");
		}
		//$validyn 72시간 체크
		<?if ($validyn=="N"){?>
			$(".layer-left-menu, .layer-tab").click(function(e){e.stopPropagation();});
			$(".layer-tab .btn-close").hide();
		<?}?>
	});
	$("li[class^='buy-mn']").each(function(e){
			if ($(this).find(".count").html()=="0")
			{
				$(this).addClass("off");
			}
	});

	//0개인건 클릭 안되게 중지
	$("li[class^='buy-mn']").click(function(e){if ($(this).find(".count").html()=="0"){e.stopPropagation();}});

//-->
</SCRIPT>