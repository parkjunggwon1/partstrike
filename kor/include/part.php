
<SCRIPT LANGUAGE="JavaScript">
<!--
	function writeproc(){
		var f =  document.f1;
		if ($("#fileName").val()==""){
			alert_msg("파일 찾아보기를 클릭해서 업로드할 재고파일을 선택해 주세요.");
		}
		else{
			f.target="proc";
			f.action = "/include/Excel_proc.php?<?=$param?>";
			f.encoding = "multipart/form-data";
			f.submit();
		}
	}
	
	function check(){
		var f =  document.f2;
		if (nullchk(f.part_no,"Part No를 입력하세요.")== false) return ;		
		if (nullchk(f.manufacturer,"Manufacturer를 입력하세요.")== false) return ;		
		if (nullchk(f.package,"Package를 입력하세요.")== false) return ;		
		if (nullchk(f.dc,"제조년을 입력하세요.")== false) return ;		
		//if (nullchk(f.quantity,"수량을 입력하세요.")== false) return ;		
		if (nullchk(f.price,"가격을 입력하세요.")== false) return ;		
		maskoff();

		var formData = $("#f2").serialize(); 
		$.ajax({
				url: "/kor/proc/part_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
					var splData = data.split(":");
					if (trim(splData[0]) == "SUCCESS"){								
						showajaxParam("#f3 #partlist", "partlist", "part_type="+$("#part_type").val());
						$("#f2 input[type=text]").val("");
						$("#rhtype option:eq(0)").attr("selected", "selected")
							.parent().prev().html("RoHS");
						$("#f2 input[name=part_no]").focus();						
						$("#f2 .reg button").hide();
						$("#f2 .reg span").show();
						if ($("#f2 input[name=part_type]").val()=="2")
						{
							$("#f2 input[name=dc]").val("NEW ");						
							$("#f2 input[name=quantity_tmp]").val("I");						
						}
						ready();
					}else{
						alert_msg(data);
					}
				}
		});		
	}

	 function del(){
		var f = document.f3;
		if ($("input[name^='delchk']:checked").length>0) //선택한 항목이 있으면 삭제
		{			
		//	if (confirm("선택하신 데이터는 제거됩니다. 계속 진행 하시겠습니까?")==true){
				maskoff();
				f.target = "proc";
				f.typ.value = "alldel";
				f.action = "/kor/proc/part_proc.php?<?=$param?>";
				f.encoding = "multipart/form-data";
				f.submit();			
		//	}
		}else{   //선택한 항목이 없으면 전체 수정
				maskoff();
				f.target = "proc";
				f.typ.value = "edit";
				f.action = "/kor/proc/part_proc.php?<?=$param?>";
				f.encoding = "multipart/form-data";
				f.submit();			
		}
	}

	function partno_sch(){
		var f =  document.f3;
		showajaxParam("#f3 #partlist", "partlist", "page=1&part_type="+$("#part_type").val()+"&part_no="+f.srch_part_no.value);
		ready();
		$(".pagination a.link").click(function(){
				showajaxParam("#f3 #partlist", "partlist", "page="+$(this).attr("num")+"&part_type="+$("#part_type").val()+"&part_no="+f.srch_part_no.value);
			});


	}

	function excelDown(){
		document.proc.location.href="/include/Excel_download.php?part_type="+$("#part_type").val();
	}

	$("input[name=regtype]").click(function(e){
		if ($("#fileName").val())
		{
			$("#stockTop .op4 img:eq(0)").hide();
			$("#stockTop .op4 button").show();
		}
		
	});
	$("input[name=file1]").on("change",function(e){
			if($("input[name=regtype]:checked").length==1){
				$("#stockTop .op4 img:eq(0)").hide();
				$("#stockTop .op4 button").show();
			}
	
	});

	$("#f2 input:text").keyup(function(){
		var f =  document.f2;
		//var f =  $("#f2");
		//if (f.part_no.value!="" &&f.manufacturer.value!="" &&f.package.value!="" &&f.dc.value!="" &&f.price.value!="")
		if (f.part_no.value != "" && f.manufacturer.value != "" && f.dc.value != "" && f.price.value != "" && f.price.value!=0)
		{
			$("#f2 .reg span").hide();
			$("#f2 .reg button").show();
		}else{
			$("#f2 .reg span").show();
			$("#f2 .reg button").hide();
		}
	});

	function check_key_partno(){
		if(window.event.keyCode==13){			
			partno_sch();
			
		}
	}
//-->
</SCRIPT>

			
			<section id="stockTop" class="box-type1">
				<form name="f1" method="post" onsubmit="return false;">					
					<input type="hidden" id="part_type" name="part_type" value="<?=$part_type?>">
					<span style="padding-left:6px"><a href="/include/filedownload.php?filename=parts_sample<?=($part_type=="2"?"2":"1")?>.xls&path=/upload/xls/"  target="proc" ><img src="/kor/images/btn_apply_form_down.gif" alt="등록 양식 Download"></a></span>
					<span class="op1"><label class="i-file">재고파일 <input type="file" name="file1" onChange="javascript: document.getElementById('fileName').value = this.value"><input type="text" id="fileName" readonly><span></span></label></span>
					<span class="op2" style="display:none;"><label class="rd"><input type="radio" name="regtype" value="1"><span></span>덮어쓰기</label></span>
					<span class="op3"  style="display:none;"><label class="rd"><input type="radio" name="regtype" value="2" class="checked" checked><span></span>추가등록</label></span>
					<span class="op4">
					<img src="/kor/images/btn_form_apply_1.gif" alt="등록">
					<button style="display:none;" type="button" onclick="writeproc();"><img src="/kor/images/btn_form_apply.gif" alt="등록"></button></span>
				</form>
			</section>
			
			<section id="stockManageTop" class="box-type1">
				<form name="f2" id="f2" method="post">
				<input type="hidden" name="typ" value="write">
				<input type="hidden" name="part_type" value="<?=$part_type?>">
				<div class="box-top bg2">
					<h2>재고추가</h2>
				</div>
				<table class="stock-list-table">
					<thead>
						<tr>
							<th scope="col" class="t-lt">Part No.</th>
							<th scope="col" class="t-lt">Manufacturer</th>
							<th scope="col">Package</th>
							<th scope="col">D/C</th>
							<th scope="col">RoHS</th>
							<th scope="col" class="t-rt">Q'ty</th>
							<th scope="col" class="t-rt">Unit Price</th>
							<th scope="col" style="width:50px"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="pd-0 t-lt"><input type="text" name= "part_no" class="i-txt2 t-lt" style="width:190px;ime-mode:disabled" maxlength="24" value=""></td>
							<td class="t-lt"><input type="text" name= "manufacturer" class="i-txt2 t-lt" style="width:155px; ime-mode:disabled" maxlength="20" value=""></td>
							<td><input type="text" name= "package" class="i-txt2 w-50 t-ct" style="width:76px; ime-mode:disabled" maxlength="10" value=""></td>
							<td><input type="text" name= "dc" class="i-txt<?=$part_type=="2"?"6":"2"?> onlynum" maxlength="4" style="width:45px" value="<?if ($part_type=="2"){?>NEW <?}?>"></td>
							<td>
								<div class="select type4" lang="en" style="width:60px">
									<label>None</label>
									<select id="rhtype" name="rhtype">
										<option lang="en" value="">None</option>
										<option lang="en" value="RoHS">RoHS</option>
										<option lang="en" value="HF">HF</option>
									</select>
								</div>
							</td>
							
							<td class="t-rt"><?if ($part_type==2){?><input type="text" class="i-txt6 onlynum numfmt t-rt" name="quantity_tmp" style="width:66px" maxlength="11" value="I"><?}else{?><input type="text" class="i-txt2 onlynum numfmt t-rt" name="quantity" style="width:66px" maxlength="10" value=""><?}?></td>
							
							<td class="t-rt"><input type="text" class="i-txt2 onlynum numfmt t-rt" name="price" style="width:76px" maxlength="9" value=""></td>
							<td class="pd-0 reg">
							<span><img src="/kor/images/btn_form_apply_1.gif" alt="등록"></span>
							<button style="display:none;" type="button" onclick="check();"><img src="/kor/images/btn_form_apply.gif" alt="등록"></button></td>
						</tr>
					</tbody>
				</table>
				</form>
			</section>
			
			<!-- stockManage -->
			<section id="stockManage" class="box-type1">
				<form name="f3" id="f3" method="post" onsubmit="return false;">
					<input type="hidden" name="part_type" value="<?=$part_type?>">
					<input type="hidden" name="typ" value="">
					<div class="box-top srch-box bg2">
						<div class="srch-block1" style="right:11px;"><label lang="en">Part No. <input type="text" class="onlyEngNum" style="ime-mode:disabled" maxlength="30" onkeypress="check_key_partno(partno_sch);" name="srch_part_no" value="<?=$part_no?>" ></label><button type="button" onclick="partno_sch();"><img src="/kor/images/btn_srch2.gif" alt="검색"></button></div>
						<h2 class="srch-block2">재고편집</h2>
						<a href="javascript:excelDown();" class="srch-block3"><img src="/kor/images/btn_stock_list_down.gif" alt="재고목록 download"></a>
					</div>
					<div id="partlist"></div>
					
				</form>
			</section>
			<!--// stockManage -->
			<script>
				$(document).ready(function(){
				//	$(".layer2-section").addClass("open");
				//	$("body").addClass("open-layer");
				//	$("#layerPop2").load("/kor/layer/layerPop.php");

				$("input[name=price]").keydown(function(e){
					if($(this).val()==""){
						$(this).val("$");
					}else if($(this).val()=="$"){
						$(this).val("");
					}

					
				});

				})
			</script>