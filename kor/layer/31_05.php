<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>
ready();
var date_sel = "";
$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
$(".layer-pagination2.red li, .layer-pagination2.bk li").click(function(){
	var prevPage =$(".layer-pagination2.red .current a").text();	
	var thisPage="";
	var supp = parseInt($("#supply_quantity").val());
	var qty = parseInt($("#31_05_qty").val().replace(/,/g, ''));
	date_sel="true";
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
		//지속적..
		if ($(".layer-pagination2.red .current a, .layer-pagination2.bk .current a").text()!="")
		{
			$(".layer-pagination2 li").removeClass("current");		
		}
		$(".pagingli_1:eq("+(thisPage-1)+")").addClass("current");
		$("#period").val(thisPage);
		if(supp > 0)
		{
			$(".btn-area span").hide();
			//$(".btn-area button:eq(0)").show();
			$("#31-05-smt").show();			
		}
		else
		{						
			$(".btn-area span").show();
			//$(".btn-area button:eq(0)").show();
			$("#31-05-smt").hide();
		}
		
	}

});

$("input[name=supply_quantity]").keyup(function(e){
	maskoff();
	var supp = parseInt($(this).val());
	var qty = parseInt($("#31_05_qty").val().replace(/,/g, ''));

	if (date_sel=="true")
	{
		if ($("#31_05_qty").val()!="I")
		{

			if ($(this).val() !="")
			{
				if(supp > qty)
				{
					$(this).val("");	
					$(".btn-area span").show();
					//$(".btn-area button:eq(0)").show();
					$("#31-05-smt").hide();					
				}
				else
				{
					$(".btn-area span").hide();
					//$(".btn-area button:eq(0)").show();
					$("#31-05-smt").show();								
				}
			}
			else
			{
				$(".btn-area span").show();
				//$(".btn-area button:eq(0)").show();
				$("#31-05-smt").hide();		
			}
			
		}
		else
		{
			if(supp > 0)
			{
				$(".btn-area span").hide();
				//$(".btn-area button:eq(0)").show();
				$("#31-05-smt").show();	
			}
			else
			{
				$(".btn-area span").show();
				//$(".btn-area button:eq(0)").show();
				$("#31-05-smt").hide();	
			}
		}
	}
	
	maskon();
});


</script>

<div class="layer-hd">
	<h1>납기 확인</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>

	<input type="hidden" id="odr_det_idx_31_05" name="odr_det_idx_31_05" value="<?=$odr_det_idx?>">
	<input type="hidden" id="part_type_31_05" name="part_type_31_05" value="<?=$part_type?>">

		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company" ><img src="/kor/images/nation_title_<?=$buy_com_nation?>1.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
						<td class=" t-ct c-red" style="width:33%;font-size:14px;">결제 완료 시점부터 선적 완료까지</td>
						
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
		
		<!-- 지속적... -->
		<?if ($part_type == "2"){?>
		<div class="layer-pagination2 red" style="text-align: right;">
			<ul>
				<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
				<?for ($i = 1; $i <19 ; $i++) { 
						if($i<3){
							echo "<li class='pagingli_1 bk' style='padding:1px;'><a href='#'>$i</a></li>";
						}else{
							echo "<li class='pagingli_1' style='padding:1px;'><a href='#'>$i</a></li>";
						}
					}
				?>
				<li class="navi-next"><a href="#"><img src="/kor/images/nav_btn_up.png" alt="next"></a></li>
				<li class="c-red2" lang="en">WK</li>
			</ul>
			
		</div>
		<?}else{	//-- 그 외-----------?>
		<!-- layer-pagination2 -->
		<div class="layer-pagination2 bk" style="text-align: right;">
			<ul>
			<?for ($i = 1; $i <=7 ; $i++) {  
					echo "<li class='pagingli_1' style='padding:1px;'><a href='#'>$i</a></li>";
				}
			?>
				<li class="c-red2" lang="en"><font style="font-size:14px">Days</font></li>
			</ul>
		</div>
		<!-- //layer-pagination2 -->		
		<?}?>
		<div class="layer-data">
			<table class="stock-list-table">
				<thead>
					<tr>
						<th scope="col" class="t-no">No.</th>
						<th scope="col" class="t-lt" style="width:210px;">Part No.</th>
						<th scope="col" class="t-lt">Manufacturer</th>
						<th scope="col" class="t-Package">Package</th>
						<th scope="col" class="t-dc">D/C</th>
						<th scope="col" class="t-rohs">RoHS</th>
						<th scope="col" class="t-oty" style="width:60px;">O'ty</th>
						<th scope="col" class="t-unitprice">Unit Price</th>
						<th scope="col" class="delivery t-orderoty" lang="ko" style="width:60px;">발주수량</th>
						<th scope="col" lang="ko" class="t-supplyoty">공급수량</th>
						<th scope="col" lang="ko" style="width:75px;">납기</th>
					</tr>
				</thead>
				<?echo GET_ODR_DET_LIST("31_05",$part_type," and odr_det_idx=$odr_det_idx ");?>
			</table>
		</div>
	
		
		<div class="btn-area t-rt">
			<span><img src="/kor/images/btn_transmit_1.gif" alt="전송"></span>
			<button type="button" id="31-05-smt" class="sell-mn01-3106" style="display:none;"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
			<button type="button" class="btn-pop-0201"><img src="/kor/images/btn_delete2.gif" alt="삭제"></button>
		</div>
	</form>
</div>

