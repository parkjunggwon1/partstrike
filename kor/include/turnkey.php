<SCRIPT LANGUAGE="JavaScript">
<!--
	function writeproc(){
		var f =  document.f1;
		if ($("#fileName").val()==""){
			alert("파일 찾아보기를 클릭해서 업로드할 턴키파일을 선택해 주세요.");
		}
		else if($("#price").val()==""){
			alert("가격을 입력해 주세요.");
			$("#price").focus();

		}else{
			f.target="proc";
			f.action = "/include/Excel_proc.php?<?=$param?>";
			f.encoding = "multipart/form-data";
			f.submit();
		}
	}

	function showtr(turnkey){
			 if ($("#subtr_"+turnkey).css("display")=="none")
			 {
		 			$(".subtr").hide();
					$("#subtr_"+turnkey).fadeIn(200);					
					$("#turnkeyManageTop #maintr_"+turnkey).find("span.del").show();
					$("#turnkeyManageTop #maintr_"+turnkey).find("button.del").hide();
					
			 }else{
					$(".subtr").hide();
					$("#turnkeyManageTop #maintr_"+turnkey).find("span.del").hide();
					$("#turnkeyManageTop #maintr_"+turnkey).find("button.del").show();
			 }			
			}	
	 function delturnkey(turnkey_idx){
		//	if (confirm('해당 턴키및 세부 내역을 모두 삭제하시겠습니까?'))
		//	{
			alert_del_extra("삭제" ,"턴키 품목 전부를 삭제하시겠습니까?","btn_ok", turnkey_idx);				
		//	}
	 }

	 function del_delv(turnkey_idx){
			var f = eval('document.form_'+turnkey_idx);
			f.target = "proc";
			f.typ.value = "delturnkey";
			f.action = "/kor/proc/part_proc.php?turnkey_idx="+turnkey_idx+"&part_type=7";
			f.encoding = "multipart/form-data";
			f.submit();
			closeCommLayer("layer6");
	 }



	  function del(turnkey_idx){
		var f = eval('document.form_'+turnkey_idx);
		//alert(f.typ.value);
		if ($("#form_"+turnkey_idx+" input[name^='delchk']:checked").length>0) //선택한 항목이 있으면 삭제
		{			
			//if (confirm("선택하신 데이터는 제거됩니다. 계속 진행 하시겠습니까?")==true){
				maskoff();
				f.target = "proc";
				f.price.value = $("input[name=price_"+turnkey_idx+"]").val();
				f.typ.value = "alldel";
				f.action = "/kor/proc/part_proc.php?<?=$param?>";
				f.encoding = "multipart/form-data";
				f.submit();			
			//}
		}else{   //선택한 항목이 없으면 전체 수정
				maskoff();
				f.target = "proc";
				f.price.value = $("input[name=price_"+turnkey_idx+"]").val().replace("$","");
				f.typ.value = "edit";
				f.action = "/kor/proc/part_proc.php?<?=$param?>";
				f.encoding = "multipart/form-data";
				f.submit();			
		}
	}

	function part_sch(){
		var f =  document.f3;
		showajaxParam("#stockManage", "turnkeylist", "page=1&part_type=7&part_no="+f.srch_part_no.value);
		ready();
		$(".pagination a.link").click(function(){
				showajaxParam("#stockManage", "turnkeylist", "page="+$(this).attr("num")+"&part_no="+f.srch_part_no.value);
			});
	}



	function excelDown(turnkey_idx){
		document.proc.location.href="/include/Excel_download.php?part_type=7&turnkey_idx="+turnkey_idx;
	}

	function turnkey_det(turnkey_idx){
		showajaxParam(".col-right", "side_turnkey", "turnkey_idx="+turnkey_idx);
	}

	$(document).ready(function(){
		$("input[name=price]").keydown(function(e){
			if($(this).val()==""){
				$(this).val("$");
			}else if($(this).val()=="$"){
				$(this).val("");
			}

			if ($("#fileName").val()!="")
			{
				$("#stockTop span.reg").hide();
				$("#stockTop button.reg").show();
			}
		});

	$("input[name=price]").keyup(function(e){
		if($(this).val()==""){
				$("#stockTop span.reg").show();
				$("#stockTop button.reg").hide();
		}
	});
		

		$("input[name=file1]").on("change",function(){		
			if($("input[name=price]").val()!=""){
				$("#stockTop span.reg").hide();
				$("#stockTop button.reg").show();
			}
		});

	});
	//-->
	</SCRIPT>
			<section id="stockTop" class="box-type1">
				<form name="f1" method="post">			
				<input type="hidden" id="part_type" name="part_type" value="7">
					<span style="padding-left:6px"><a href="/include/filedownload.php?filename=parts_sample3.xls&path=/upload/xls/"    target="proc" ><img src="/kor/images/btn_apply_form_down.gif" alt="등록 양식 Download"></a></span>
					<span class="op1" style="padding-right:15px"><label class="i-file">턴키 파일 <input type="file" name="file1" onChange="javascript: document.getElementById('fileName').value = this.value"><input type="text" id="fileName" readonly><span></span></label></span>
					<span class="op4"><label class="c-red " lang="en">Price </label><label class="c-blue"></label><input type="text" style="width:105px" class="i-txt2 c-red t-rt onlynum numfmt" maxlength="11" name="price" id="price" value="" placeholder=""> 
					<span class="reg"><img src="/kor/images/btn_form_apply_1.gif" alt="등록"></span>
					<button type="button" class="reg" style="display:none;" onclick="writeproc();"><img src="/kor/images/btn_form_apply.gif" alt="등록"></button></span>
				</form>
			</section>
			
			<section id="turnkeyManageTop" class="box-type1">				
			</section>
			
			<!-- stockManage -->
			<section id="stockManage" class="box-type1">				
			</section>
			<!--// stockManage -->
			
		</div>
	