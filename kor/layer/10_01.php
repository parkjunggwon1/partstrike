<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>

ready();
$(".layer-pagination.red li").click(function(){
	var prevPage =$(".layer-pagination.red .current a").text();	
	var thisPage="";
	
	if ($(this).find("a").text() !="")
	{
		$(this).addClass("current");
		thisPage =$(this).find("a").text();
	}else{
		if($(this).hasClass("navi-prev")){
			thisPage = prevPage =="" ? 19: parseInt(prevPage) - 1;
		}else{
			thisPage = prevPage =="" ? 1: parseInt(prevPage) + 1;
		}		
	}
	if (thisPage <20 && thisPage > 0)
	{
			if ($(".layer-pagination.red .current a").text()!="")
			{
				$(".layer-pagination.red li").removeClass("current");		
			}
			$(".pagingli:eq("+(thisPage-1)+")").addClass("current");
			$("#period").val(thisPage);
	}

});


</script>

<div class="layer-hd">
	<h1>납기연장</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>

		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company"><img src="/kor/images/nation_title2_<?=$buy_com_nation?>1.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
						<td class="w100 t-ct c-red">자동 연장된 일주일의 마지막 날부터 선적 완료까지 </td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->	
		
		<!-- layer-pagination -->
		<div class="layer-pagination red">
			<ul>
				<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
				<?for ($i = 1; $i <20 ; $i++) {  
						echo "<li class='pagingli'><a href='#'>$i</a></li>";
					}
				?>
				<li class="navi-next"><a href="#"><img src="/kor/images/nav_btn_up.png" alt="next"></a></li>
			</ul>
			<span class="c-red2" lang="en">WK</span>
		</div>
		<!-- //layer-pagination -->
		
		<div class="layer-data">
			<table class="stock-list-table"  id="list_01_36">
			</table>
		</div>
		
		<hr class="dashline2">
		<p class="c-red2 t-ct">추가 요청 납기 : <input class="i-txt2 t-ct c-blue" style="width: 100px;" type="text" name="period" id="period"> <span lang="en">WK</span></p>
		<div class="btn-area t-rt">
			<button type="button" class="Delay" odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
		</div>
	</form>
</div>


<SCRIPT LANGUAGE="JavaScript">
<!--
$("#list_01_36").html($("#list_30_15").html());
$("#list_01_36 .yesinput").remove();
$("#list_01_36 .noinput:eq(0)").remove();
$("#list_01_36 .noinput").css("display","");

-->
</SCRIPT>