<script type="text/javascript">
<!--
	function memfee_det(idx){
		showajaxParam(".col-right", "side_memfee", "idx="+idx);
	}

	function check(){
		var f = document.f3;
		if ($("input[name^='mem_idx']:checked").length>0){ 
			f.target = "proc";
			f.typ.value = "temp_save";
			f.action = "/kor/proc/memfee_proc.php?<?=$param?>";
			f.encoding = "multipart/form-data";
			f.submit();			
		}else{
		}
	}

	function check2(){
		var f = document.f4;
		var memfee_id=f.memfee_id.value;
		//alert($("input[name^='charge_type']:checked").length);
		if ($("input[name^='charge_type']:checked").length>0){ 
			f.target = "proc";
			f.typ.value = "temp_add";
			f.action = "/kor/proc/memfee_proc.php?<?=$param?>";
			f.encoding = "multipart/form-data";
			f.submit();			
		}else{
			closeCommLayer("layer4")
			openCommLayer("layer5","23_77","?memfee_id="+memfee_id);
		}
	}
	
	function check3(){
		var f = document.f5;
		var typ="write";
		var memfee_id=f.memfee_id.value;
		var charge_type=f.charge_type.value;
		var tot_amt=f.tot_amt.value;
		openCommLayer("layer4","30_12","?typ="+typ+"&memfee_id="+memfee_id+"&charge_type="+charge_type+"&tot_amt="+tot_amt);
	}

	function check3_asdf(){
		var f = document.f5;
		f.target = "proc";
		f.typ.value = "write";
		f.action = "/kor/proc/memfee_proc.php?<?=$param?>";
		f.encoding = "multipart/form-data";
		f.submit();	
	}

	 function f_checkbox(str){
		 alert("asfasf");
		document.form.chkbox.checked = !str;
	}



//-->
</script>
<section id="memfeeleftTop" >				
</section>

<!-- stockManage -->
<section id="memfeeleftBottom" >				
</section>
<!--// stockManage -->
