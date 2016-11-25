<?
//TEST시 필요한 파라메터
//$rel_idx = 22;
//$mem_type = 1;


  if ($typ==""){$typ="write";}
?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script language=javascript src='/include/function.js'></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	var typ = "<?=$typ?>";
	if (typ=="write"){
		var checkvalid = false;
	}
	var checkstrid = "";
	function checkid(typ,val,txt){
		//"/ajax/checkid.asp?id="+id
		$('#checkspan'+typ).html("");
		//alert("val="+val+"&typ="+typ+"&txt="+txt+"&m_idx=<?=$idx?>")
		$.ajax({ 
			type: "GET", 
			url: "/ajax/check.php", 
			data: "val="+val+"&typ="+typ+"&txt="+encodeURIComponent(txt)+"&rel_idx="+$("#rel_idx").val(), 
			dataType : "text" ,
			async : false ,
			success: function(msg){ 
				var msg = (msg);
				if (msg=="0"){				
					$('#checkspan'+typ).html("사용 가능한 "+txt+"입니다");
					$('#checkspan'+typ).fadeOut().fadeIn(200);
					if(typ=='id') checkvalid = true;
				}else{				
					$('#checkspan'+typ).html(msg);
					$('#checkspan'+typ).fadeOut().fadeIn(200);	
					if(typ=='id') checkvalid = false; checkstrid=msg;
				}
			}
		});
	}

	function join(){   // 가입버튼 클릭시
		//f5 form을 넘기되 저장이 되지 않은 f4, f6의 비공개 체크항목도 함께 넘겨서 저장한다.
		var f =  document.f5;
		var f2 = document.f4;		
		
		if (nullchk(f2.bank_user_name,"수취인성명을 입력해주세요.")== false) return ;			
		if (nullchk(f2.bank_name,"은행명을 입력해주세요.")== false) return ;			
		if (nullchk(f2.bank_account,"계좌번호를 입력해주세요.")== false) return ;
		f.bank_user_name.value = f2.bank_user_name.value;
		f.bank_name.value = f2.bank_name.value;
		f.bank_account.value = f2.bank_account.value;
		if ($("#hid_nation").val()!="1")
		{
			f.bank_addr.value = f2.bank_addr.value;
			f.bank_tel.value = f2.bank_tel.value;
			f.swift_code.value = f2.swift_code.value;
			f.rout_no.value = f2.rout_no.value;
			f.iban_code.value = f2.iban_code.value;
		}


//		f.certi1open_yn.value = (document.f6.certi1open_yn.checked==true)?"N":"Y";
//		f.certi2open_yn.value = (document.f6.certi2open_yn.checked==true)?"N":"Y";
		
		var ok = true;
		$("#f5 select[name*=company_idx2] option:selected").each(function(){
			if($(this).val()){
				var $input = $(this).parent().parent().parent().next().find("input");
				if ($input.val() =="")
				{
					alert_msg("운임을 입력해 주세요.");
					$input.focus();
					ok = false;
					return false;
				}

			}
		});
		if (ok == true)
		{
			$("#f5 input[type=text]").each(function(){
				if ($(this).val())
				{
					if($(this).parent().prev().find("select option:selected").val()== ""){
						alert_msg("운송회사를 선택해 주세요.");
						$(this).parent().prev().find("label").focus();
						ok = false;
						return false;
					}
				}
			});
			if (ok == true)
			{
				maskoff();
				 var f =  document.f5; 
				 f.target = "proc";
				 f.action = "/kor/proc/member_proc.php";
				 f.submit();		
			}
		}
	}

	function check(){		
		var f =  document.f1;
		if (trim(f.typ.value)=="write"){
			checkid('id',f.mem_id.value,'아이디');			
			if (checkvalid!=true){
				alert_msg("아이디를 확인하세요");
				f.mem_id.focus();
				return;
			}	
			if (nullchk(f.mem_pwd,"비밀번호를 입력하세요.")== false) return ;			
			if (nullchk(f.mem_pwd2,"비밀번호와 같게 입력하세요.")== false) return ;		
		}
		
		
		if (trim(f.mem_pwd.value)!=trim(f.mem_pwd2.value) ){
			alert_msg("비밀번호와 같게 입력하세요.");
			f.mem_pwd2.value="";f
			f.mem_pwd2.focus();
			return;
		}
		if (nullchk(f.mem_nm_en,"성명(English)을 입력하세요.")== false) return ;		
		if (nullchk(f.mem_nm,"성명을 입력하세요.")== false) return ;		
		if (nullchk(f.pos_nm_en,"직책(English)을 입력하세요.")== false) return ;		
		if (nullchk(f.pos_nm,"직책을 입력하세요.")== false) return ;		
		if (nullchk(f.depart_nm_en,"부서(English)를 입력하세요.")== false) return ;		
		if (nullchk(f.depart_nm,"부서를 입력하세요.")== false) return ;		
		if (nullchk(f.tel,"전화번호를 입력하세요.")== false) return ;		
		if (nullchk(f.email,"이메일을 입력하세요.")== false) return ;

		var formData = $("#f1").serialize(); 
		$.ajax({
				url: "/kor/proc/member_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
					var splData = data.split(":");
					if (trim(splData[0]) == "SUCCESS"){		
						alert_msg("성공적으로 저장하였습니다.");
						showajaxParam("#joinForm2", "mem","rel_idx="+$("#rel_idx").val()+"&mem_type="+$("#mem_type").val());
						showajaxParam("#section3", "agency", "rel_idx="+$("#rel_idx").val());
						ready();
						
					}else{
						alert(data);
					}
				}
		});		
	}
	function check_impship(){
		var f =  document.f2;
		if (nullchk(f.company_idx,"운송회사를 선택하세요.")== false) return ;		
		if (nullchk(f.account_no,"Account No를 입력하세요.")== false) return ;		
		var formData = $("#f2").serialize(); 
		$.ajax({
				url: "/kor/proc/member_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
					var splData = data.split(":");
					if (trim(splData[0]) == "SUCCESS"){							
						alert_msg("성공적으로 저장하였습니다.");
						showajaxParam("#section2", "impship", "rel_idx="+$("#rel_idx").val());
						ready();

					}else{
						alert_msg(data);
					}
				}
		});		

	}
	function check_agency(){
		var f =  document.f3;
		if (nullchk(f.agency_name,"제조회사를 입력하세요.")== false) return ;		
		if (nullchk(f.mem_idx,"담당<?=get_variable_name($mem_type,"직원")?>을 선택하세요.")== false) return ;		
		var formData = $("#f3").serialize(); 
		$.ajax({
				url: "/kor/proc/member_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
					var splData = data.split(":");
					if (trim(splData[0]) == "SUCCESS"){								
						alert_msg("성공적으로 저장하였습니다.");
						showajaxParam("#section3", "agency", "rel_idx="+$("#rel_idx").val());
						ready();
					}else{
						alert_msg(trim(data));
					}
				}
		});		

	}
	function del(tbl, idx){
		//if (confirm('정말 삭제하시겠습니까?'))
		//{
			$.ajax({
				url: "/kor/proc/member_proc.php", 
				data: "tbl="+tbl+"&idx="+idx+"&typ=del",
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){		
						if (tbl =="impship")
						{
							showajaxParam("#section2", "impship", "rel_idx="+$("#rel_idx").val());
						}else if(tbl =="member")
						{
							showajaxParam("#joinForm2", "mem","rel_idx="+$("#rel_idx").val()+"&mem_type="+$("#mem_type").val());
						}else if(tbl =="agency")
						{
							showajaxParam("#section3", "agency", "rel_idx="+$("#rel_idx").val());
						}
						ready();
					}else{
						//alert(data);
					}
				}
		});		
		//}
	}

	function edit(tbl,idx){
		switch(tbl){
		case "member":
			showajaxParam("#joinForm2", "mem", "rel_idx=<?=$rel_idx?>&mem_type=<?=$mem_type?>&idx="+idx);	
			inputChk();
			if (MustChk() == true)
			{
				$(".join-form-table").next().find("span:eq(0)").hide();
				$(".join-form-table").next().find("span:eq(1)").show();
			}else{
				$(".join-form-table").next().find("span:eq(0)").show();
				$(".join-form-table").next().find("span:eq(1)").hide();

			}
		break;
		case "impship":
			showajaxParam("#section2", "impship", "rel_idx="+$("#rel_idx").val()+"&idx="+idx);
			$("#f2 .option-table").find("td:last span:eq(0)").hide();
			$("#f2 .option-table").find("td:last span:eq(1)").show();			
		break; 
		case"agency":
			showajaxParam("#section3", "agency", "rel_idx="+$("#rel_idx").val()+"&idx="+idx);
			$("#f3 .option-table").find("td:last span:eq(0)").hide();
			$("#f3 .option-table").find("td:last span:eq(1)").show();
			if ($("#f3 .option-table #idx option:selected").val()=="")
			{
				$("#f3 .option-table #idx option:eq(1)").attr("selected","selected");
				$("#f3 .option-table #idx").prev().text($("#f3 .option-table #idx option:eq(1)").text());
				$("#f3 .option-table #agency_name").show();
				$("#f3 .option-table #idx").parent().hide();
			}
		break; 
		default:
		break;
		} 
		ready();
	}

	
	function fileChange(){
		 $("input[type=file]").change(function(){	
			
			 if ($(this).val()){
				 var f =  document.f6; 
				 f.typ.value="imgfileup";
				 f.no.value = $(this).attr("name").replace("file","");
				 f.target = "ifrm";
				 f.action = "/kor/proc/member_proc.php";
				 f.submit();
				
			 }
		 });
	}

	 $(document).ready(function(){
		 $(".img-wrap").click(function () {
                $(this).next().next().click();
            });

		fileChange();

		$(".arrow_top").click(function(){
			$(this).parent().parent().next().find(".img-cntrl-wrap").show();
			fileChange()
		});
		 $(".arrow_bottom").click(function(){
			$(this).parent().hide();
		});
		 $(".delimgbtn,.arrow_bottom").click(function () {
				var $this = $(this);
               // if (confirm('정말 삭제하시겠습니까?'))
               // {
					var f = document.f6;
					var no_val = $this.parent().find("input[type=file]").attr("name").replace("file","");
					f.no.value = no_val;
					f.typ.value="imgfiledel";
					var formData = $("#f6").serialize(); 
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: formData,
						encType:"multipart/form-data",
						success: function (data) {	
							if (trim(data) == "SUCCESS"){									
								$("#fileimg"+no_val).attr("src", "/kor/images/file_pt.gif");
							    $("#file_o"+no_val).val("");
								if (no_val >=4)
								{
									$(this).parent().hide();
								}
								
							}else{
								alert(data);
							}
						}
					});		
                //}
            });
		/**
		//--- 국제 배송업체 변경 --------------------------------
		 $("#t_company").change(function(){
			 chk_nation();
		 });
		//--- 국제 배송비 입력 ------------------------------------------
		$('#n_charge').keyup(function(){
			chk_nation();
		});
		**/
		inputChk();
		
		$("input[lang=en]").css("ime-mode","disabled");	

		$(".editimgbtn,.delimgbtn").hide();
		$( ".img-cntrl-wrap" ).hover(
		  function() {
				$(this).find(".editimgbtn,.delimgbtn").show();		
		  }, function() {
			    $(this).find(".editimgbtn,.delimgbtn").hide();		
		});		
	});

	function inputChk(){
			$(".join-form-table input:text").keyup(function(){
				if (MustChk() == true)
				{
					$(".join-form-table").next().find("span:eq(0)").hide();
					$(".join-form-table").next().find("span:eq(1)").show();
				}else{
					$(".join-form-table").next().find("span:eq(1)").hide();
					$(".join-form-table").next().find("span:eq(0)").show();
					

				}
			});

		if ($("#hid_nation").val()=="")
		{
		}else{
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "STC",
					actidx : $("#hid_nation").val()
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					$("input[name=tel]").val($("input[name=tel]").val()==""?data:$("input[name=tel]").val());
					$("input[name=fax]").val($("input[name=fax]").val()==""?data:$("input[name=fax]").val());
					$("input[name=hp]").val($("input[name=hp]").val()==""?data:$("input[name=hp]").val());
				}
			});		
		}
	}

	function MustChk()
	{		
		var f =  document.f1;
		if(f.mem_id.value==""){ return "mem_id";}
		if(f.mem_nm_en.value==""){ return "mem_nm_en";}
		if(f.pos_nm_en.value==""){ return "pos_nm_en";}
		if(f.depart_nm_en.value==""){ return "depart_nm_en";}
		if(f.tel.value==""){ return "tel";}
		if(f.email.value==""){ return "email";}
		return true;
	}
	//--- [국제] 배송비 '추가' 활성 ----------------------------------------------------------------------------------------------------------
	function chk_nation(){
		var nation_ok = false, charge_ok = true, comp_ok = true;
		//국가
		sel_nation = $("input[name^=nation]:checked");
		if(sel_nation.length>0){
			nation_ok = true;
		}
		//운송업체
		$t_company = $('select[name="t_company[]"]');
		$t_company.each(function(e){
			if($(this).val().length<1) comp_ok = false;
		});
		//운임
		$n_charge = $('input[name="n_charge[]"]');
		$n_charge.each(function(e){
			if($(this).val().length<1) charge_ok = false;
		});
		//버튼 활성 여부
		if(nation_ok && charge_ok && comp_ok){
			$('#nation_add').css("cursor","pointer").addClass("btn-nation-add").attr("src","/kor/images/btn_stock_save.gif");
		}else{
			$('#nation_add').css("cursor","").removeClass("btn-nation-add").attr("src","/kor/images/btn_stock_save_1.gif");
		}
	}
	//국제배송 배송업체, 배송비 입력칸 추가
	function add_dlvr(){
		var n_charge = $('input[name="n_charge[]"]');
		$.ajax({
			url: "/kor/proc/member_proc.php", 
			data: "typ=dlvr_co",
			encType:"multipart/form-data",
			dataType : "html",
			async : false,
			success: function (data) {
				$("#DLVR_CO").append(data);
			}
		});
		//갯수 체크
		if(n_charge.length >= 3){
			$("#add_ncharge").remove();
		}
		chk_nation();
	}
	//국제 배송업체 삭제
	$(".box-type1").on("click", '#remove_dlvr', function(){
		var n_charge = $('input[name="n_charge[]"]');
		$(this).parent().remove();
		//갯수가 줄면 '+' 표시 다시 보이게
		if(n_charge.length == 4){
			var html = "<button type=\"button\" name=\"add_ncharge\" id=\"add_ncharge\" class=\"c-red\" style=\"margin-left:5px;\" OnClick=\"add_dlvr();\">+</button>";
			$('#dlvr_co_first').append(html);
		}
		chk_nation();
	});
	//--- 국제배송비 배송업체 변경
	$(".box-type1").on("change", 'select[name="t_company[]"]', function(){
		chk_nation();
	});
	//--- 국제 배송비 입력 ------------------------------------------
	$(".box-type1").on("keyup", 'input[name="n_charge[]"]', function(){
		chk_nation();
	});
	//--- '국제 배송비' 추가버튼 클릭 -------------------------------------------
	$(".box-type1").on("click", ".btn-nation-add", function(){
		maskoff();
		$chked_nation = $("input[name^=nation]:checked");
		$t_company = $('select[name="t_company[]"]');
		$n_charge = $('input[name="n_charge[]"]');
		var ch_nation_idx = [], ch_company = [], ch_charge = [];
		//국가
		$chked_nation.each(function(e){
					ch_nation_idx.push($(this).val());
		});
		//배송업체
		$t_company.each(function(e){
					ch_company.push($(this).val());
		});
		//배송비
		$n_charge.each(function(e){
					ch_charge.push($(this).val());
		});

		$.ajax({
			url: "/kor/proc/member_proc.php", 
			//data: "typ=inter_shipping&rel_idx=<?=$rel_idx;?>&trade_type=0&f_dest_idx="+ch_nation_idx+"&t_company_idx="+$("#t_company").val()+"&f_charge="+$("#n_charge").val(),
			//2016-07-17 배송업체, 배송비 배열로 넘김
			data: "typ=inter_shipping&rel_idx=<?=$rel_idx;?>&trade_type=0&f_dest_idx="+ch_nation_idx+"&t_company_idx="+ch_company+"&f_charge="+ch_charge,
			encType:"multipart/form-data",
			dataType : "json" ,
			async : false ,
			success: function (data) {
				if(data.err == "OK"){
					//입력화면 뿌리기
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=nation_list&rel_idx=<?=$rel_idx?>&o_company_idx=<?=o_company_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLVR_NA").html(data);
						}
					});
					//등록 Data 뿌리기
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=freight_nation&rel_idx=<?=$rel_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLVR").html(data);
						}
					});
				}
			}
		});
	});
	//--- 등록내용 수정 --------------------------------------------------------------------------------------------------------------------
	$(".box-type1").on("click", ".edit_f", function(){
		var idx = $(this).attr("idx");
		var trade_type = $(this).attr("trade_type");
		$.ajax({
			url: "/kor/proc/member_proc.php", 
			data: "typ=edit_freight&rel_idx=<?=$rel_idx?>&trade_type="+trade_type+"&idx="+idx,
			encType:"multipart/form-data",
			dataType : "html",
			async : false,
			success: function (data) {
				$("#saved_"+idx).html(data);
			}
		});
	});
	//등록내용 수정폼에서 배송비 입력칸 추가
	function add_edlvr(idx){
		var e_charge = $('input[name="e_charge[]"]');
		$.ajax({
			url: "/kor/proc/member_proc.php", 
			data: "typ=edlvr_co&idx="+idx,
			encType:"multipart/form-data",
			dataType : "html",
			async : false,
			success: function (data) {
				$("#DLVR_CO_"+idx).append(data);
			}
		});
		//갯수 체크
		if(e_charge.length >= 3){
			$("#add_echarge").remove();
		}
		//chk_nation();
	}
	//등록내용 수정폼에서 운송회사 삭제
	$(".box-type1").on("click", '#remove_edlvr', function(){
		var e_charge = $('input[name="e_charge[]"]');
		var idx= $(this).attr("idx");
		$(this).parent().remove();
		//갯수가 줄면 '+' 표시 다시 보이게
		if(e_charge.length == 4){
			var html = "<button type=\"button\" name=\"add_echarge\" id=\"add_echarge\" class=\"c-red\" style=\"margin-left:5px;\" OnClick=\"add_edlvr("+idx+");\">+</button>";
			$('#edlvr_co_first').append(html);
		}
		chk_nation();
	});
	//--- 국제배송비 수정내용 저장 --------------------------------------------------------------------------------------------------------------------
	$(".box-type1").on("click", ".edit_s", function(){
		maskoff();
		var idx = $(this).attr("idx");
		var trade_type = $(this).attr("trade_type");
		$chked_nation = $("input[name^=e_nation]:checked");
		$t_company = $('select[name="e_company[]"]');
		$n_charge = $('input[name="e_charge[]"]');
		var ch_nation_idx = [], ch_company = [], ch_charge = [];
		//국가
		$chked_nation.each(function(e){
					ch_nation_idx.push($(this).val());
		});
		//배송업체
		$t_company.each(function(e){
					ch_company.push($(this).val());
		});
		//배송비
		$n_charge.each(function(e){
					ch_charge.push($(this).val());
		});

		$.ajax({
			url: "/kor/proc/member_proc.php", 
			data: "typ=ud_freight&idx="+idx+"&rel_idx=<?=$rel_idx;?>&trade_type="+trade_type+"&f_dest_idx="+ch_nation_idx+"&t_company_idx="+ch_company+"&f_charge="+ch_charge,
			encType:"multipart/form-data",
			dataType : "json" ,
			async : false ,
			success: function (data) {
				if(data.err == "OK"){
					//등록 Data 뿌리기
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=freight_nation&rel_idx=<?=$rel_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLVR").html(data);
							$("#DLVR_CO_"+idx).focus();
						}
					});
				}else{
					alert(data.err);
				}
			}//end of success
		});//end of ajax
	});
	//--- 등록내용 삭제 --------------------------------------------------------------------------------------------------------------------
	function del_freight(trade_type,idx){
		$.ajax({
			url: "/kor/proc/member_proc.php", 
			data: "typ=del_freight&rel_idx=<?=$rel_idx?>&trade_type="+trade_type+"&idx="+idx,
			encType:"multipart/form-data",
			dataType : "html",
			async : false,
			success: function (data) {
				if(trade_type==0){
					//입력화면(국가) 갱신
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=nation_list&rel_idx=<?=$rel_idx?>&o_company_idx=<?=o_company_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLVR_NA").html(data);
						}
					});
					//등록국가 갱신
					$("#DLVR").html(data);
				}else{
					//입력화면(도시) 갱신
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=citi_list&rel_idx=<?=$rel_idx?>&i_company_idx=<?=i_company_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLDO_CT").html(data);
						}
					});
					//등록 도시 갱신
					$("#DLDO").html(data);
				}
			}
		});
	}
	//*** 국내 배송비 '추가' 활성 *********************************************************************************
	function chk_citi(){
		var citi_ok = false, charge_ok = true, comp_ok = true;
		//도시
		sel_citi = $("input[name^=citi]:checked");
		if(sel_citi.length>0){
			citi_ok = true;
		}
		//운송업체
		$c_company = $('select[name="c_company[]"]');
		$c_company.each(function(e){
			if($(this).val().length<1) comp_ok = false;
		});
		//운임
		$c_charge = $('input[name="c_charge[]"]');
		$c_charge.each(function(e){
			if($(this).val().length<1) charge_ok = false;
		});

		/**
		//운송업체
		if(($("#c_company option:selected").val()).length > 0) comp_ok = true;
		//운임
		if(($("#c_charge").val()).length > 0) charge_ok = true;
		**/

		if(citi_ok && charge_ok && comp_ok){
			$('#citi_add').css("cursor","pointer").addClass("btn-citi-add").attr("src","/kor/images/btn_stock_save.gif");
		}else{
			$('#citi_add').css("cursor","").removeClass("btn-citi-add").attr("src","/kor/images/btn_stock_save_1.gif");
		}
	}
	//국내 배송업체 삭제
	$(".box-type1").on("click", '#remove_dldo', function(){
		//var n_charge = $('input[name="n_charge[]"]');
		$(this).parent().remove();
		/**
		if(n_charge.length == 4){
			var html = "<button type=\"button\" name=\"add_ncharge\" id=\"add_ncharge\" class=\"c-red\" style=\"margin-left:5px;\" OnClick=\"add_dlvr();\">+</button>";
			$('#dlvr_co_first').append(html);
		}
		**/
		chk_citi();
	});
	//국내배송 배송업체, 배송비 입력칸 추가
	function add_dldo(rel_idx){
		$.ajax({
			url: "/kor/proc/member_proc.php", 
			data: "typ=dldo_co&rel_idx="+rel_idx,
			encType:"multipart/form-data",
			dataType : "html",
			async : false,
			success: function (data) {
				$("#DLDO_CO").append(data);
			}
		});
		var html = "<br>$ <input type=\"text\" name=\"c_charge[]\" id=\"c_charge[]\" class=\"i-txt3 c-red onlynum numfmt\" style=\"width:48px\">";
		$("#DLDO_CH").append(html);
		chk_citi();
	}
	//수정폼 - 배송업체 추가
	function add_edldo(idx){
		$.ajax({
			url: "/kor/proc/member_proc.php", 
			data: "typ=edldo_co&rel_idx=<?=$rel_idx?>",
			encType:"multipart/form-data",
			dataType : "html",
			async : false,
			success: function (data) {
				$("#DLDO_CO_"+idx).append(data);
			}
		});
		//var html = "<br>$ <input type=\"text\" name=\"c_charge[]\" id=\"c_charge[]\" class=\"i-txt3 c-red onlynum numfmt\" style=\"width:48px\">";
		//$("#DLDO_CH").append(html);
		chk_citi();
	}
	//--- 국내배송비 수정내용 저장 --------------------------------------------------------------------------------------------------------------------
	$(".box-type1").on("click", ".edit_sd", function(){
		maskoff();
		var idx = $(this).attr("idx");
		var trade_type = $(this).attr("trade_type");
		$chked_nation = $("input[name^=d_citi]:checked");
		$t_company = $('select[name="d_company[]"]');
		$n_charge = $('input[name="d_charge[]"]');
		var ch_nation_idx = [], ch_company = [], ch_charge = [];
		//도시
		$chked_nation.each(function(e){
					ch_nation_idx.push($(this).val());
		});
		//배송업체
		$t_company.each(function(e){
					ch_company.push($(this).val());
		});
		//배송비
		$n_charge.each(function(e){
					ch_charge.push($(this).val());
		});

		$.ajax({
			url: "/kor/proc/member_proc.php", 
			data: "typ=ud_freight&idx="+idx+"&rel_idx=<?=$rel_idx;?>&trade_type="+trade_type+"&f_dest_idx="+ch_nation_idx+"&t_company_idx="+ch_company+"&f_charge="+ch_charge,
			encType:"multipart/form-data",
			dataType : "json" ,
			async : false ,
			success: function (data) {
				if(data.err == "OK"){
					//입력화면 뿌리기
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=citi_list&rel_idx=<?=$rel_idx?>&i_company_idx=<?=i_company_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLDO_CT").html(data);
						}
					});
					//등록 Data 뿌리기
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=freight_citi&rel_idx=<?=$rel_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLDO").html(data);
						}
					});
				}else{
					alert(data.err);
				}
			}//end of success
		});//end of ajax
	});
	//--- 국내배송비 배송업체 변경
	$(".box-type1").on("change", 'select[name="c_company[]"]', function(){
		chk_citi();
	});
	//--- 국내 배송비 입력 ------------------------------------------
	$(".box-type1").on("keyup", 'input[name="c_charge[]"]', function(){
		chk_citi();
	});
	//--- '국내 배송비' 추가버튼 클릭 -------------------------------------------
	$(".box-type1").on("click", ".btn-citi-add", function(){
		$chked_citi = $("input[name^=citi]:checked");
		$c_company = $('select[name="c_company[]"]');
		$c_charge = $('input[name="c_charge[]"]');
		var ch_citi_idx = [], ch_company = [], ch_charge = [];
		$chked_citi.each(function(e){
					ch_citi_idx.push($(this).val());
		});
		//배송업체
		$c_company.each(function(e){
					ch_company.push($(this).val());
		});
		//배송비
		$c_charge.each(function(e){
					ch_charge.push($(this).val());
		});
		$.ajax({
			url: "/kor/proc/member_proc.php", 
			//data: "typ=inter_shipping&rel_idx=<?=$rel_idx;?>&trade_type=1&f_dest_idx="+ch_citi_idx+"&t_company_idx="+$("#c_company").val()+"&f_charge="+$("#c_charge").val(),
			data: "typ=inter_shipping&rel_idx=<?=$rel_idx;?>&trade_type=1&f_dest_idx="+ch_citi_idx+"&t_company_idx="+ch_company+"&f_charge="+ch_charge,
			encType:"multipart/form-data",
			dataType : "json" ,
			async : false ,
			success: function (data) {
				if(data.err == "OK"){
					//입력화면 뿌리기
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=citi_list&rel_idx=<?=$rel_idx?>&i_company_idx=<?=i_company_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLDO_CT").html(data);
						}
					});
					//등록 Data 뿌리기
					$.ajax({
						url: "/kor/proc/member_proc.php", 
						data: "typ=freight_citi&rel_idx=<?=$rel_idx?>",
						encType:"multipart/form-data",
						dataType : "html",
						async : false,
						success: function (data) {
							$("#DLDO").html(data);
						}
					});
				}
			}
		});
	});

//-->
</SCRIPT>
			<!-- form1 : section 안으로 넣음 (class.meminfo 의 GF_GET_MEM_DATA)-->
			<section id="joinForm2" class="box-type1"></section>
			<!-- form2 : section 안으로 넣음 (GF_GET_IMPSHIP_DATA)-->
			<section id="section2" class="box-type1"></section>
			<!-- form3 : section 안으로 넣음 (GF_GET_AGENCY_DATA)-->
			<section id="section3" class="box-type1"></section>
			
			<?if ($rel_idx){
				$result_f6 = QRY_MEMBER_VIEW("idx",$rel_idx);
				$row_f6 = mysql_fetch_array($result_f6);
				$bank_name= replace_out($row_f6["bank_name"]);
				$bank_account= replace_out($row_f6["bank_account"]);
				$bank_user_name= replace_out($row_f6["bank_user_name"]);
				$bank_addr= replace_out($row_f6["bank_addr"]);
				$bank_tel= replace_out($row_f6["bank_tel"]);
				$swift_code= replace_out($row_f6["swift_code"]);
				$rout_no= replace_out($row_f6["rout_no"]);
				$iban_code= replace_out($row_f6["iban_code"]);
			}
			?>
			<!-- form4 -->
			<section id="bank-info" class="box-type1">
			<form name="f4" id="f4">
			<input type="hidden" name="rel_idx" value="<?=$rel_idx?>">
				<div class="box-top">
					<h2>은행정보</h2>
				</div>
				<table>
					<tbody>
						<?if ($_SESSION["NATION"]=="1"){?>
						<tr>
							<th scope="row"><strong class="c-red">*</strong>수취인 성명</th>
							<td><input type="text" class="i-txt3 c-blue" name="bank_user_name" value="<?=$bank_user_name?>" lang="ko"></td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong>은행명</th>
							<td><input type="text" class="i-txt3 c-blue" name="bank_name" value="<?=$bank_name?>" lang="ko"></td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong>계좌번호</th>
							<td><input type="text" class="i-txt3 c-blue" name="bank_account" value="<?=$bank_account?>" lang="ko"></td>
						</tr>
						<?}else{?>
						<tr>
							<th scope="row"><span lang="en"><strong class="c-red">*</strong>Beneficiary Name</span></th>
							<td><input type="text" class="i-txt3 c-blue" name="bank_user_name" value="<?=$bank_user_name?>" lang="en"></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en"><strong class="c-red">*</strong>Bank Name</span></th>
							<td><input type="text" class="i-txt3 c-blue" name="bank_name" value="<?=$bank_name?>" lang="en"></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en"><strong class="c-red">*</strong>Account No.</span></th>
							<td><input type="text" class="i-txt3 c-blue" name="bank_account" value="<?=$bank_account?>" lang="en"></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en"><strong class="c-red">*</strong>Bank Address</span></th>
							<td><input type="text" class="i-txt3 c-blue" name="bank_addr" value="<?=$bank_addr?>" lang="en"></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en"><strong class="c-red">*</strong>Bank Phone No.</span></th>
							<td><input type="text" class="i-txt3 c-blue" name="bank_tel" value="<?=$bank_tel?>" lang="en"></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">Swift (BIC) Code</span></th>
							<td><input type="text" class="i-txt3 c-blue" name="swift_code" value="<?=$swift_code?>" lang="en"></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">ABA (Routing) No.</span></th>
							<td><img src="/kor/images/bank_usa_ipt.gif" alt=""><input type="text" class="i-txt3 c-blue" name="rout_no" value="<?=$rout_no?>" style="width:169px" lang="en"></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">IBAN Code</span></th>
							<td><img src="/kor/images/bank_eu_ipt.gif" alt=""><input type="text" class="i-txt3 c-blue" name="iban_code" value="<?=$iban_code?>" style="width:169px" lang="en"></td>
						</tr>
						<?}?>
					</tbody>
				</table>
				<!-- //form4 -->
			</form>
			</section>		
			
			<section id="relatedCheck" class="box-type1">
			<form name="f5" id="f5"   method="post" enctype="multipart/form-data">
			<input type="hidden" name="typ" value="join">
			<input type="hidden" name="bank_user_name" value="">
			<input type="hidden" name="bank_name" value="">
			<input type="hidden" name="bank_account" value="">
			<input type="hidden" name="bank_addr" value="">
			<input type="hidden" name="bank_tel" value="">
			<input type="hidden" name="swift_code" value="">
			<input type="hidden" name="rout_no" value="">
			<input type="hidden" name="iban_code" value="">
			<input type="hidden" name="rel_idx" value="<?=$rel_idx?>">
			<!-- form5 -->
				<div class="box-top bg2">
				<? $cnt_ty1 = QRY_CNT("assign", "and rel_idx = $rel_idx and assign_type =1");
				   $cnt_ty2 = QRY_CNT("assign", "and rel_idx = $rel_idx and assign_type =2");?>
					<h2>
					<label class="ipt-chk chk4 c-yellow" lang="ko">
					<input name="ch_ty" type="checkbox" value="관련<?=get_variable_name($mem_type,"회사")?>만 기입" <?if ($cnt_ty1 >0 || $cnt_ty2 >0){echo "checked class='checked'";}?>>
					<span></span>관련<?=get_variable_name($mem_type,"회사")?>만 기입</label>
					</h2>
				</div>
				<table class="stock-list-table bgno">
					<thead>
						<tr>
							<th scope="col" colspan="2">
							<label class="ipt-chk chk4 c-yellow" lang="ko">
								<input name="ch_ty1" type="checkbox" value="판매자 지정 운임" <? if ($cnt_ty1 >0){echo "checked class='checked'";}?>>
								<span></span>판매자 지정 운송회사</label>
							</th>
						</tr>
						<tr>
							<th scope="col" class="th2 c-grey"><span lang="ko">국제 무역</span></th>
							<th scope="col" class="th2 c-grey line-lt"><span lang="ko">국내거래</span></th>
						</tr>
					</thead>
					<tbody class="tp15">
						<tr>
							<?=GF_GET_ASSIGN_DATA($rel_idx,1)//2nd parm : assign_type ?>
						</tr>
					</tbody>
				</table>
				<table class="stock-list-table bgno">
					<thead>
						<tr>
							<th scope="col" colspan="4">
								<label class="ipt-chk chk4 c-yellow" lang="ko">
								<input name="ch_ty2" type="checkbox" value="판매자 지정 운임" <? if ($cnt_ty2 >0){echo "checked class='checked'";}?>>
								<span></span>판매자 지정 운임</label>
							</th>
						</tr>
						<tr>
							<th scope="col" class="th2" colspan="4"><span lang="ko">국제 무역</span></th>
						</tr>
						<tr>
							<th scope="col" class="th3" style="width:58%"><span lang="ko">국가</span></th>
							<th scope="col" class="th3" style="width:20%"><span lang="ko">운송회사</span></th>
							<th scope="col" class="th3" style="width:12%"><span lang="ko">운임</span></th>
							<th scope="col" class="th3" style="width:10%"><span lang="ko">&nbsp;</span></th>
						</tr>
						<!-------------------------------------------------------------------- 국제배송비 ------------------------------------------------------------->
						<tbody id="DLVR_NA">
						<tr>
							<td class="t-lt">
								<ul class="related-nation-list">
									<? //국가명 반복(추가된것 제외)
									$result = QRY_FREIGHT_NATION2($rel_idx);
									for ($i=0; $row = mysql_fetch_array($result); $i++) {
										$nation = $row["code_desc"];
										$na_code = $row["dtl_code"];
										$saved_cnt = QRY_CNT("freight_charge"," and (f_dest_idx='$na_code' or f_dest_idx LIKE '$na_code,%' or f_dest_idx LIKE '%,$na_code,%' or f_dest_idx LIKE '%,$na_code' or f_dest_idx LIKE '$na_code,%') ");  //기 등록여부
									?>
									<li>
										<label class="ipt-chk chk2" lang="en">
											<input name="nation[]" type="checkbox" value="<?=$na_code;?>" <?=$saved_cnt>0? "disabled":"";?> onClick="chk_nation();">
											<span></span><?=$nation;?>
										</label>
									</li>
									<? } ?>
								</ul>
							</td>
							<td id="DLVR_CO" colspan="2" class="t-lt">
								<div id="dlvr_co_first" style="width:220px; margin-left:30px;" class="t-lt">
								<div class="select type8" lang="en" style="width:120px">
									<label class="c-blue"><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"";?></label>
									<?=GF_Common_SetComboList("t_company[]", "DLVR", "", 1, "True",  "", $o_company_idx , "");?>
								</div>&nbsp;
								$ <input type="text" name="n_charge[]" id="n_charge[]" class="i-txt3 c-blue onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
								<button type="button" name="add_ncharge" id="add_ncharge" class="c-red" style="margin-left:5px;" OnClick="add_dlvr();">+</button>
								</div>
							</td>
							<td>
								<img src="/kor/images/btn_stock_save_1.gif" id="nation_add">
							</td>
						</tr>
						</tbody>
						<tbody id="DLVR" class="tp15">
							<?=GF_GET_ASSIGN_DATA2($rel_idx,0); //class.meminfo.php?>
						</tbody>
						<!-------------------------------------------------------------------- 국내배송비 ------------------------------------------------------------->
						<tr>
							<th scope="col" class="th2 line-lt" colspan="4"><span lang="ko">국내거래</span></th>
						</tr>
						<tr>
							<th scope="col" class="th3" style="width:58%"><span lang="ko">도시</span></th>
							<th scope="col" class="th3" style="width:20%"><span lang="ko">운송회사</span></th>
							<th scope="col" class="th3" style="width:12%"><span lang="ko">운임</span></th>
							<th scope="col" class="th3" style="width:10%"><span lang="ko">+/-</span></th>
						</tr>
					</thead>
						<tbody id="DLDO_CT">
						<tr>
							<td class="t-lt">
								<ul class="related-nation-list">
									<? //도시명 반복(추가된것 제외)
									$na_code = get_any("member", "nation","mem_idx='$rel_idx'");
									$result = QRY_FREIGHT_CITY2($rel_idx, $na_code);
									for ($i=0; $row = mysql_fetch_array($result); $i++) {
										$citi = $row["code_desc"];
										$ct_code = $row["dtl_code"];
										$saved_cnt = QRY_CNT("freight_charge"," and (f_dest_idx='$ct_code' or f_dest_idx LIKE '%,$ct_code,%' or f_dest_idx LIKE '%,$ct_code' or f_dest_idx LIKE '$ct_code,%') ");  //기 등록여부
									?>
									<li>
										<label class="ipt-chk chk2" lang="ko">
											<input name="citi[]" type="checkbox" value="<?=$ct_code;?>" <?=$saved_cnt>0? "disabled":"";?> onClick="chk_citi();">
											<span></span><?=$citi;?>
										</label>
									</li>
									<? } ?>
								</ul>
							</td>
							<td id="DLDO_CO" colspan="2" class="t-rt">
								<div id="dldo_co_first" style="width:220px; margin-left:30px;" class="t-lt">
									<div class="select type8" lang="en" style="width:142px">									
										<label class="c-blue"><?=($i_company_idx)?GF_Common_GetSingleList("DLDO",$i_company_idx):"";?></label>
										<?=GF_Common_SetComboList("c_company[]", "DLDO", get_any("member", "nation", "mem_idx=$rel_idx"), 2, "True",  "", $i_company_idx , "");?>
									</div>
									$ <input type="text" name="c_charge[]" id="c_charge[]" class="i-txt3 c-blue onlynum numfmt" value="<?=$o_cost?>" style="width:48px">
									&nbsp;<button type="button" name="add_ncharge" id="add_ncharge" class="c-red" OnClick="add_dldo(<?=get_any("member", "nation", "mem_idx=$rel_idx");?>);">+</button>
								</div>
							</td>
							<td>
								<img src="/kor/images/btn_stock_save_1.gif" id="citi_add">
							</td>
						</tr>
						</tbody>
						<tbody id="DLDO" class="tp15">
							<?=GF_GET_ASSIGN_DATA2($rel_idx,1); //class.meminfo.php?>
						</tbody>
				</table>
				<!-- //form5 -->
			</form>

			</section>
			
			
			<section id="Terms" class="box-type1">
			<form name="f6" id="f6"  method="post" enctype="multipart/form-data">
			<input type="hidden" name="rel_idx" value="<?=$rel_idx?>">			
			<input type="hidden" name="typ" value="imgfileup">
			<input type="hidden" name="no" value="">
			<!-- form6 -->
				<div class="box-top">
					<h2><?=get_variable_name($mem_type,"회사")?>정보 첨부2</h2>
				</div>
                <div class="terms-wrap">
				<table class="company-info-img">
					<tbody>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> <?=get_variable_name($mem_type,"회사")?> <span lang="en">Logo</span></th>
							<?=fnFileRender(1,1,"","",$row_f6, true)?>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> 사인(대표자)</th>
							<?=fnFileRender(2,2,"","",$row_f6, true)?>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</body>
				</table>

				<table class="company-info-img">
					<tbody>
						<tr>
						<tr>
							<th scope="row"><strong class="c-red">*</strong> 사업자등록증</th>
							<?=fnFileRender(3,3,"","",$row_f6, true)?>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th scope="row">증명서</th>
							<?=fnFileRender(4,7,"","",$row_f6, true, true)?>
						</tr>
						<tr>
							<th scope="row"><?=get_variable_name($mem_type,"사무실/창고")?></th>
							<?=fnFileRender(8,11,"","",$row_f6, true, true)?>
						</tr>
					</tbody>
				</table>   
                </div>             
				<div class="btn-area t-rt" style="padding-bottom:7px;">
					<button type="button" onclick="join();"><img src="/kor/images/btn_<?=($_SESSION["MEM_IDX"])?"save":"join"?>.gif"></button>
				</div>
				<!-- //form6 -->
			</form>
			</section>
			

			<iframe name="ifrm" id="ifrm" src="" width="0" height="0" frameborder="1" style="display:none;"></iframe>
			<?function fnFileRender($start,$end, $colspan ,$label,$row, $no_btn=false, $view_arrow=false){
					for ($i = $start;$i<= $end; $i++){
							$column_nm = getColumn_nm($i);	
							if ($row){
								$fileonly = replace_out($row["file".$column_nm]);
								$file_path = "/upload/file/";
								$filename = replace_out($row["file".$column_nm]);
								$certiopen_yn = replace_out($row["certi".($i-3)."open_yn"]);
							}							
							if ($fileonly==""){$filename = "";}
						?>
						<td>
						<div class="img-cntrl-wrap" <?if ($i>=4 && !$filename && $i!=$start){?>style="display:none;"<?}?>>
							<?
							switch(substr($column_nm,0,4)) {
							   case "logo":
								   $imgwsize = "75";
								   $imghsize = "18";
							   break;
							   case "sign":
								   $imgwsize = "150";
								   $imghsize = "36";								   
							   break;
							   case "reg_":
							   case "cert":
								   $imgwsize = "80";
								   $imghsize = "113";								   
							   break;
							   case "stor":
								   $imgwsize = "80";
								   $imghsize = "61";								   
							   break;
							}

							if($no_btn){
							?>
							<span class="img-wrap <?=substr($column_nm,0,4)?>"><img alt="" id="fileimg<?=$i?>" <?=get_noimg_photo($file_path, $filename, "/kor/images/file_pt.gif")?> width="<?=$imgwsize?>" height="<?=$imghsize?>" ></span>
							<input name="file_o<?=$i?>" id="file_o<?=$i?>" type="hidden" value="<?=$fileonly?>">
							<input name="file<?=$i?>" id="file<?=$i?>" type="file" style="width:1px;height:1px;background-color:#fff;border:none">
							<?if ($i != $end){?><a href="javascript:;" class="arrow_top">+</a><?}?>
							<?if ($i != $start){?><a href="javascript:;" class="arrow_bottom">-</a><?}?>
							<?
							}else{
							?>
							<span class="img-wrap"><img alt="" id="fileimg<?=$i?>" <?=get_noimg_photo($file_path, $filename, "/kor/images/file_pt.gif")?> width="<?=$imgwsize?>" height="<?=$imghsize?>" ></span>
							<input name="file_o<?=$i?>" id="file_o<?=$i?>" type="hidden" value="<?=$fileonly?>">
							<input name="file<?=$i?>" id="file<?=$i?>" type="file" style="display:none;">
							<button type="button" class="editimgbtn"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
							<button type="button" class="delimgbtn"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
							<?
							}
							?>
						</div>									
						<?if ($label){?><label class="ipt-chk chk2"><input type="checkbox" name="certi<?=($i-3)?>open_yn" <?if ($certiopen_yn=="N"){echo "checked class='checked'";}?>><span></span>비공개</label><?}?>
						</td>									
					<?}
				}?>