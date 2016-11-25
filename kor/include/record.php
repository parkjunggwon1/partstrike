<script src="/kor/js/common.js"></script>
<SCRIPT LANGUAGE="JavaScript">

	$(document).ready(function(){
		$(".myrecord").click(function(){
			document.fr.page.value = "1";
			 myrecord();				
		});
		$(".main tbody:last tr:last").remove();
		$("#this_mem_idx").change(function(){
			$(".myrecord").click();
		});		
		myrecord();
	 });

	 function rcdClick(){
			$(".recordbt").click(function(){
				var $this = $(this).parents("tr").prev().find(".layer-step");
				var backgound = ($("#odr_type").val()=="S")?"#dce6f2":"#ffff99";
				
				if ($this.css("display")=="none")
				{
					$(this).parents("tbody").addClass("record-on");
					 $this.css("display","");	
					 $(this).parent().parent().next().find("img.badness").show();
					 $(this).parents("tr").css("background-color",backgound);
					 $(this).parents("tr").next().css("background-color",backgound);
					$(this).parent().parent().next().find(".company_div").hide();
					 
				}else{					
					$(this).parents("tbody").removeClass("record-on");
					$this.css("display","none");
					$(this).parent().parent().next().find("img.badness").hide();
					$(this).parents("tr").css("background-color","#ffffff");
					$(this).parents("tr").next().css("background-color","#ffffff");
					$(this).parent().parent().next().find(".company_div").show();
					
				}
				if ($(this).find("img").attr("src").indexOf("record2")>0)
				{
					$(this).find("img").attr("src", "/kor/images/btn_record.gif");
				}else{
					$(this).find("img").attr("src", "/kor/images/btn_record2.gif");
				}
			});
			$(".pagination a.link").click(function(){
				document.fr.page.value = $(this).attr("num");
				myrecord();					
			});		
		}

		function myrecord(){
		var f = document.fr;
		var odr_type = $("#odr_type").val();
		var part_no = f.part_no.value;
		var page = f.page.value;
		var yr = $("#fr #yr option:selected").val();
		var mon = $("#mon option:selected").val();

		var this_mem_idx =$("#this_mem_idx option:selected").val();
		showajaxParam("#recordlist", "recordlist", "odr_type="+odr_type+"&part_no="+part_no+"&yr="+yr+"&mon="+mon+"&this_mem_idx="+this_mem_idx+"&page="+page);
		rcdClick();
	 }



	
	
</SCRIPT>


<!-- mybankSrch -->
			<section id="mybankSrch" class="box-type6">
				<form name="fr" id="fr" class="clear" onsubmit="return false;">
				<input type="hidden" name="odr_type" id = "odr_type" value="<?=$odr_type?>">
				<input type="hidden" name="page" id = "page" value="<?=$page==""?"1":$page?>">
					<table>
						<tbody>
							<tr>
								<th scope="row" lang="en">Part No.</th>
								<td colspan="3"><input class="w100 onlyEngNum" name="part_no" type="text" style="ime-mode:disabled" maxlength="30" onkeypress="check_key(myrecord);" ></td>
							</tr>
							<?if (!$yr){ $yr = "N/A";}
							 if (!$mon){ $mon = "N/A";}
							 ?>
							<tr>
								<th scope="row">년도</th>
								<td>
									<div class="select" lang="en">
										<label for="yr"><?=$yr?></label>
										<select  name="yr"  id="yr">
											<option lang='en' <?=($yr=="N/A"?"selected":"")?>>N/A</option>
											<?for ( $i = date("Y") ; $i >= 2015; $i -- ){
												echo "<option lang='en' ".(($i==$yr)?"selected":"").">$i</option>";
											}?>
										</select>
									</div>
								</td>
								<th scope="row">월</th>
								<td>
									<div class="select" lang="en">
										<label for="mon"><?=$mon=="N/A"?"N/A":$mon*1?></label>
										<select name="mon" id="mon">
										<option lang='en' <?=($mon=="N/A"?"selected":"")?>>N/A</option>
											<?for ( $i = 1 ; $i <= 12; $i ++ ){
												echo "<option lang='en' ".(($i==$mon)?"selected":"").">$i</option>";
											}?>
										</select>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<button type="button" class="myrecord"><img src="/kor/images/btn_srch5.gif" alt="검색"></button>
				</form>
			</section>
			<!-- //mybankSrch -->						
			<!-- table -->
			<section class="box-type1">
			<div class="top-right-box">
					<div class="select type2">
						<?if (!$this_mem_idx){$this_mem_idx = $_SESSION["MEM_IDX"];}?>
						<?=GET_MyMember($this_mem_idx)?>						
					</div>
			</div>
			<div id = "recordlist">
				<?=GF_GET_RECORD_LIST($odr_type, $part_no,$yr,$mon,$this_mem_idx,$page);?>				
				<?=GF_GET_TURNKEY_RCD_LIST($odr_type, $part_no,$yr,$mon,$this_mem_idx,$page);?>	
			</div>
			</section>
			<!--// table -->
			