<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$("#orderDraft #this_mem_idx").change(function(){
			var ajaxpage, odr_type;
			if ($(this).parent().hasClass("sell") ==true)
			{
				ajaxpage = "odr_sell";
				odr_type = "S";
			}else{
				ajaxpage = "odr_buy";
				odr_type = "B";
			}
			var this_mem_idx = $(this).find("option:selected").val();
			showajaxParam("#orderDraft #"+ajaxpage, "sideodrlist", "odr_type="+odr_type+"&this_mem_idx="+this_mem_idx);
			ChangeBackgroundSide(ajaxpage);
		});

		ChangeBackgroundSide("odr_sell");
		ChangeBackgroundSide("odr_buy");

		$("#orderDraft .title-blck select").each(function(){
				if($(this).find("option").length==1){
					$(this).parent().removeClass("type2").addClass("type7");
				}
		});
		//$("#first_what_new_buy").val();
		var what_new_s = $("#first_what_new_S").val();
		var what_new_b = $("#first_what_new_B").val();

		if (what_new_b != "")
		{
			$("#order_buy").attr("href",what_new_b);
			//$("#order_buy").attr("src","/kor/images/btn_new_1.gif");
			$("#order_buy").children("img").attr("src","/kor/images/btn_new_new.gif");
		}
		else
		{
			$("#order_buy").removeAttr("href");
			//$("#order_buy").attr("src","/kor/images/btn_new_1.gif");
			$("#order_buy").children("img").attr("src","/kor/images/btn_new_1.gif");
		}

		if (what_new_s != "")
		{
			$("#order_sell").attr("href",what_new_s);
			//$("#order_buy").attr("src","/kor/images/btn_new_1.gif");
			$("#order_sell").children("img").attr("src","/kor/images/btn_new_new.gif");
		}
		else
		{
			$("#order_sell").removeAttr("href");
			//$("#order_buy").attr("src","/kor/images/btn_new_1.gif");
			$("#order_sell").children("img").attr("src","/kor/images/btn_new_1.gif");
		}
	});

	function ChangeBackgroundSide(ajaxpage){
			var bgcolor = ajaxpage =="odr_sell"?"#dce6f2":"#ffff99";
			var criteria_idx ="";
			var odr_det_idx_chk ="";
			$("#orderDraft #"+ajaxpage+" .stock-list-table .criteria").each(function(e){
				if (criteria_idx != $(this).attr("criteria_idx") || odr_det_idx_chk != $(this).attr("odr_det_idx_chk"))
				{
					if (bgcolor =="#ffffff")
					{
						//bgcolor = "#f7f7f7";
						bgcolor = ajaxpage =="odr_sell"?"#dce6f2":"#ffff99";
					}else{
						bgcolor ="#ffffff";
					}
					criteria_idx = $(this).attr("criteria_idx");
					odr_det_idx_chk = $(this).attr("odr_det_idx_chk");
					if(e>0){  //첫번째는 두고, 두번째부터 발주가 바뀔 때마다 간격조정						
						$("<tr><td colspan='15' style='padding-top:20px; background-color:#FFFFFF;'></td></tr>").insertBefore($(this).prev());
					}
				}
				$(this).css("background-color",bgcolor);
				if ($(this).prev().find("td").hasClass("title-box")==true)
				{
					$(this).prev().find("td").css("background-color",bgcolor);
				}
			});
		}

</script>
<section id="orderDraft" class="box-type2">
	<div class="title-top">
		<h2>발주서</h2>
	</div>
	<div class="title-blck first">
		<h3>판매</h3>
		<div class="select type2 sell">
			<?if (!$this_mem_idx){$this_mem_idx = $_SESSION["MEM_IDX"];}?>
			<?=GET_MyMember($this_mem_idx)?>						
		</div>
		<?=GET_WhatsNew("sell","whatsnew");?>
	</div>
	<div id="odr_sell"><?=GET_Order("S",$this_mem_idx) //class.record.php?></div>
	
	<div class="title-blck">
		<h3>구매</h3>
		<div class="select type2 buy">
			<?if (!$this_mem_idx){$this_mem_idx = $_SESSION["MEM_IDX"];}?>
			<?=GET_MyMember($this_mem_idx)?>						
		</div>
		<?=GET_WhatsNew("buy","whatsnew");//function.php?>		
	</div>
	<div id="odr_buy"><?=GET_Order("B",$this_mem_idx) //class.record.php?></div>
	<?include $_SERVER["DOCUMENT_ROOT"]."/kor/include/side_mybox.php";?>
</section>

