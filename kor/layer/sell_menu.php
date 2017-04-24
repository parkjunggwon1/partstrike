<?
if ($_SESSION["MEM_IDX"]==""){
	Page_Msg_Url("로그인이 필요합니다.","/kor/");
}
$mn = $_GET['mn']; ?>
<div class="layer-left-menu">
	<ul>
		<li class="sell-mn01<? if($mn=='01'){ ?> current this<? } ?>"><?=get_menu_view_sell("납기","odr", 1)?></li>
		<li class="sell-mn02<? if($mn=='02'){ ?> current this<? } ?>"><?=get_menu_view_sell("발주서","odr", 2)?></li>
		<li class="sell-mn03<? if($mn=='03'){ ?> current this<? } ?>"><?=get_menu_view_sell("수정 발주서","odr", 3)?></li>
		<li class="sell-mn04<? if($mn=='04'){ ?> current this<? } ?>"><?=get_menu_view_sell("납기 연장","odr", 4)?></li>
		<li class="sell-mn05<? if($mn=='05'){ ?> current this<? } ?>"><?=get_menu_view_sell("결제 완료","odr", 5)?></li>		
		<li class="sell-mn06<? if($mn=='06'){ ?> current this<? } ?>"><?=get_menu_view_sell("수령","odr", 6)?></li>
		<li class="sell-mn07<? if($mn=='07'){ ?> current this<? } ?>"><?=get_menu_view_sell("삭제","odr", 7)?></li>
		<li class="sell-mn08-1302<? if($mn=='08'){ ?> current this<? } ?>"><?=get_menu_view_sell("취소","odr", 8)?></li>
		<li class="sell-mn09<? if($mn=='09'){ ?> current this<? } ?>"><?=get_menu_view_sell("거절","odr", 9)?></li>
		<li class="sell-mn10<? if($mn=='10'){ ?> current this<? } ?>"><?=get_menu_view_sell("수량 부족","odr", 10)?></li>
		<li class="sell-mn11<? if($mn=='11'){ ?> current this<? } ?>"><?=get_menu_view_sell("반품 선적 완료","odr", 11)?></li>
	</ul>
	<ul class="menu2"><strong></strong>
		<li class="sell-mn12<? if($mn=='12'){ ?> current this<? } ?>"><?=get_menu_view_sell("불량 통보","fty", 12)?></li>
		<li class="sell-mn13<? if($mn=='13'){ ?> current this<? } ?>"><?=get_menu_view_sell("동의서","fty",13)?></li>
		<li class="sell-mn14<? if($mn=='14'){ ?> current this<? } ?>"><?=get_menu_view_sell("반품 선적 완료","fty",25)?></li>
		<li class="sell-mn15<? if($mn=='15'){ ?> current this<? } ?>"><?=get_menu_view_sell("거절","fty",26)?></li>
		<li class="sell-mn16<? if($mn=='16'){ ?> current this<? } ?>"><?=get_menu_view_sell("결제 완료","fty",27)?></li>
		<li class="sell-mn17<? if($mn=='17'){ ?> current this<? } ?>"><?=get_menu_view_sell("결과 공지","fty",14)?></li>
		<li class="sell-mn18<? if($mn=='18'){ ?> current this<? } ?>"><?=get_menu_view_sell("수령","fty",28)?></li>
		<li class="sell-mn19<? if($mn=='19'){ ?> current this<? } ?> last"><?=get_menu_view_sell("종료","fty",30)?></li>
	</ul>
</div>
<?function get_menu_view_sell($menu_name, $his_ty ,$no){
	$mcnt = GET_MENU_CNT("sell", $no, $his_ty , $searchand);
	$str = "<a";
	if($mcnt > 0 ) {		$str.=" href='#'";	}
	$str.= " >$menu_name<span class='count'>$mcnt</span></a>";
	return $str;
}?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(document).ready(function(){
		//$validyn
		<?if ($validyn=="N"){?>
			//$validyn 72시간 체크		
			$(".layer-left-menu, .layer-tab").click(function(e){e.stopPropagation();});
			$(".layer-tab .btn-close").hide();
		<?}?>
	});
	$("li[class^='sell-mn']").each(function(e){
			if ($(this).find(".count").html()=="0")
			{
				$(this).addClass("off");
			}
	});
	//0개인건 클릭 안되게 중지
	$("li[class^='sell-mn']").click(function(e){if ($(this).find(".count").html()=="0"){e.stopPropagation();}});


//-->
</SCRIPT>