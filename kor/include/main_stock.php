<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function(){
	$("select[name^=opt]").change(function(e){
		main_srch();
		slideup();
		
	});


});

function slideup(){
	$(".ctr-up").click(function(e){
		var part_type = $(this).attr("part_type");
		$("#page_"+part_type).val("1");
		$("#tbd_"+part_type).find("tr:gt(5)").slideUp().remove();
	});
}

	function slidedown(part_type){	
		
		var page = parseInt($("#page_"+part_type).val())+1;		
		$("#ftop_sch input[name=page]").val(page);
		$("#ftop_sch input[name=part_type]").val(part_type);
		$("#ftop_sch input[name=page]").val(page);
		$("#ftop_sch input[name=actty]").val("mainpartlist");
		var formData = $("#ftop_sch").serialize(); 
		$.ajax({
				url: "/ajax/proc_ajax.php", 
				data: formData,
				success: function (data) {
				$("#page_"+part_type).val(page);
				$("#tbd_"+part_type).append($(data).slideDown(300));
				slideup();
				}
		});
	}

	
	
//-->
</SCRIPT>
<section id="stockList" class="box-type1">
	<div class="stock-list-wrap hd-type-wrap">
	<table class="stock-list-table" style="table-layout:fixed">
		<?=GET_MAIN_TITLE();?>		
		<?	for ($i = 1; $i<=6; $i++){
				echo GET_MAIN_LIST("Y",$i, 1, "");
		}?>
	</table>
	</div>
</section>


<?function GET_MAIN_TITLE(){?>
	<thead>
			<tr>
				<th scope="col" style="width:30px">No.</th>
				<th scope="col" style="width:80px">
					<div class="select type3 opt1" style="width:75px;display:;">
						<label for="opt1">Nation</label>
						<?//=GF_Common_SetComboListSrch("opt1","NA", "", "1", TRUE, "Nation", "", "and dtl_code in (0)",$lang="")?>
					</div>
					<div class="select type3 opt1" style="width:75px;display:none;">
						<label for="opt1">City/Province</label>
						<?//=GF_Common_SetComboListSrch("opt1","NA", $_SESSION["NATION"] , "2", TRUE, "City", "", "","and dtl_code in (0)",$lang="_en")?>
					</div>
				</th>
				<th scope="col" class="t-lt">Part No.</th>
				<th scope="col" class="t-lt" style="width:130px">
					<div class="select type3 opt2" style="width:100%; margin-left:0px">
						<label for="opt2">Manufacturer</label>
						<?//=GF_MANUFACTURER("opt2", TRUE, "Manufacturer", "","")?>
					</div>
				</th>
				<th scope="col" style="width:80px">Package</th>
				<th scope="col" style="width:36px">D/C</th>
				<th scope="col" style="width:36px">RoHS</th>
				<th scope="col" class="t-rt" style="width:60px">O'ty</th>
				<th scope="col" class="t-rt" style="width:61px">Unit Price</th>
				<th scope="col" class="t-ct" style="width:56px" lang="ko">납기</th>
				<th scope="col" style="width:52px">&nbsp;</th>
			</tr>
		</thead>

<?}?>