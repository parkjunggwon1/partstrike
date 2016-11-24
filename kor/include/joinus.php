<?

	if ($_SESSION["MEM_IDX"]!="" ||  $mode == "edit"){
		if ($_SESSION["MEM_IDX"]==""){
			$idx = $rel_idx;    //아직 회원 가입은 안되어있지만 이전 버튼 눌렀을 때에는 넘어온 rel_idx로 데이터를 불러온다.
			$typ ="edit";
		}else {
			$idx = $_SESSION["MEM_IDX"];
		}	

		$result = QRY_MEMBER_VIEW("idx",$idx);
		$row = mysql_fetch_array($result);
		$mem_pwd = replace_out($row["mem_pwd"]);
		$mem_id = replace_out($row["mem_id"]);
		$nation = replace_out($row["nation"]);	
		$mem_type = replace_out($row["mem_type"]);	
		$mem_nm = replace_out($row["mem_nm"]);	
		$mem_nm_en = replace_out($row["mem_nm_en"]);	
		$pos_nm = replace_out($row["pos_nm"]);
		$pos_nm_en = replace_out($row["pos_nm_en"]);
		$depart_nm = replace_out($row["depart_nm"]);
		$depart_nm_en = replace_out($row["depart_nm_en"]);
		$rel_nm = replace_out($row["rel_nm"]);
		$rel_nm_en = replace_out($row["rel_nm_en"]);
		$birthday = replace_out($row["birthday"]);
		$tel = replace_out($row["tel"]);
		$fax = replace_out($row["fax"]);
		$hp = replace_out($row["hp"]);
		$zipcode = replace_out($row["zipcode"]);
		$dosi = replace_out($row["dosi"]);
		$dosi_en = replace_out($row["dosi_en"]);
		$dositxt = replace_out($row["dositxt"]);
		$dositxt_en = replace_out($row["dositxt_en"]);
		$sigungu = replace_out($row["sigungu"]);
		$sigungu_en = replace_out($row["sigungu_en"]);
		$addr = replace_out($row["addr"]);
		$addr_en = replace_out($row["addr_en"]);
		$addr_det = replace_out($row["addr_det"]);
		$addr_det_en = replace_out($row["addr_det_en"]);
		$email = replace_out($row["email"]);
		$homepage = replace_out($row["homepage"]);
		$homepage_rel = replace_out($row["homepage_rel"]);
		$skypeId = replace_out($row["skypeId"]);
		if ($mem_birth)
		{ 
			$year = substr($mem_birth,0,4);
			$mon = substr($mem_birth,5,2);
			$day = substr($mem_birth,8,2);
		}
		$typ = "edit";
	}else{           
		$typ = "write";
	}
	
	$nation_number = get_any("code_group_detail","code_desc_mt", "grp_code ='NA' and code_depth =1 and use_yn='Y' and dtl_code='$nation'");

?>

<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".indivi").hide();		
		$("#bill_email").hide();	//세금계산서 이메일
		$("#delv_opt").hide();
		$(".roadname").hide(); //도로명주소
		
		 $('.no_hangul').css("ime-mode","disabled").keydown(function(event){ 		//한글만 입력 안되게.(.도 포함) 		 
		  if (event.which && (event.which != 229)) {			
		   } else { 
		   event.preventDefault(); 
		  } 
		 });
			 
		 $('.numfmt').css("ime-mode","disabled").keyup( function(event){   // 숫자 입력 하면 ,로 단위 끊어 표시하게.
				check_value(this);
		 });

		 $('.onlynum').css("ime-mode","disabled").keydown(function(event){ 		//숫자만 입력하게.(.도 포함) 				  
		  if (event.which && (event.which > 45 && event.which < 58 || event.which == 8 || event.which > 95 && event.which < 106)) {			
		   } else { 
		   event.preventDefault(); 
		  } 
		 });
		
		if($("#nation").children("option:selected").val()=="1"){
			setKorea('sel');
		}

		 $("input[name=mem_type]").click(function(){ 
			 if ($(this).hasClass("checked")==true)
			 {
				$("#f1 .box-top label").removeClass("c-yellow");
				$(this).prop("checked",false).removeClass("checked");
				$(".join-form-table input").attr("disabled",true);				
				$(".join-form-table input").val("");		
				$(".join-form-table select").each(function(){
					$(this).prev().text("");
					$(this).find("option:eq(0)").prop("selected",true);
				});				
				$("#checkspanid").html("");
				$("#checkspanpw").html("");
				$(".roadname_1").hide();
				chgnation(document.f1.nation);
				$(".join-form-table input").attr("disabled",true);
			 }
		 });


		 $("#f1 input[name=mem_type]").change(function(){
				$("#f1 .box-top label").removeClass("c-yellow");
				$(this).parent().addClass("c-yellow");
				
				$(".join-form-table input").val("");
				$(".join-form-table select").each(function(){
					$(this).prev().text("");
					$(this).find("option:eq(0)").prop("selected",true);
				});				
				$("#checkspanid").html("* <span lang='en'>ID</span>는 <span lang='en'>5~15</span>자 사이의 영문+숫자");
				$("#checkspanpw").html("");				
				
				$(".join-form-table input:lt(3)").attr("disabled",false);
				$(".join-form-table select:eq(0)").attr("disabled",false);
				chgnation(document.f1.nation);
				//$(".roadname_1").show();
				var part_type = $(this).val();
				switch(part_type){
					case("1"):
					case("2"):
						//alert("1,2");
					$("#sp_mem_id").html("회사");
					$("#sp_mem_nm").html("회사명");
					$("#sp_pos_nm").html("대표자");
					$(".indivi").hide();
					break;
					case("3"):
						$("#sp_mem_id").html("학교");
						$("#sp_mem_nm").html("학교명");
						$("#sp_pos_nm").html("대표자");
						$(".indivi").hide();
						//alert("3");
					break; 
					case("4"):
						$("#sp_mem_id").html("");
						$("#sp_mem_nm").html("성함");
						$("#sp_pos_nm").html("직책");
						$("#sp_depart_nm").html("부서");
						$("#sp_homepage_rel").html("회사홈페이지");
						$("#sp_rel_nm").html("회사이름");
						

						$(".indivi").show();
						//alert("4");
					break; 
					case ("5"):
						$("#sp_mem_id").html("");
						$("#sp_mem_nm").html("성함");
						$("#sp_pos_nm").html("학년");
						$("#sp_depart_nm").html("학과");
						$("#sp_homepage_rel").html("학번");
						$("#sp_rel_nm").html("학교이름");
						$(".indivi").show();
						//alert("5");
						break;
				} 
			});

			if (mem_idx=="")
			{
				$(".join-form-table input").attr("disabled",true);
				$("#nation").attr("disabled",true);
				$("#dosi_en").attr("disabled",true);
				$("#dosi").attr("disabled",true);
				$(".roadname_1").hide();
			}
			
			
		$("input").keyup(function(){
			if (MustChk() == true)
			{
				$("#joinForm1 .btn-area span:eq(0)").hide();
				$("#joinForm1 .btn-area span:eq(1)").show();
			}
			
		});

	$("input[lang=en]").css("ime-mode","disabled");			
	});

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
			data: "val="+val+"&typ="+typ+"&txt="+encodeURIComponent(txt)+"&rel_idx=0", 
			dataType : "text" ,
			async : false ,
			success: function(msg){ 
				var msg = (msg);
				if (msg=="0"){				
					$('#checkspan'+typ).html("사용 가능한 "+txt+"입니다.");
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

	function setKorea(val){				
			$(".roadname").show();
			$(".roadname_1").hide();
			$("#delv_opt").show();	//구로유통상가, W Tower
			$("#bill_email").show();	//세금계산서 이메일			
			
			//$("#zipcode").attr("disabled", true);
			$("#dosi_en").parent().hide().attr("disabled", false);
			$("#dosi").parent().hide().attr("disabled", false);
			if (val=="sel")
			{
				$("#dositxt_en").val($("#dosi_en option:selected").text()).removeClass("i-txt3").addClass("i-txt7").attr("onfocus","this.blur();");			
				$("#dositxt").val($("#dosi option:selected").text()).removeClass("i-txt3").addClass("i-txt7").attr("onfocus","this.blur();");			
				$("#dositxt_en").show().attr("readonly", true);
				$("#dositxt").show().attr("readonly", true);
			}
						
			$("#sigungu_en").removeClass("i-txt3").addClass("i-txt7").attr("onfocus","this.blur();");			
			$("#sigungu").removeClass("i-txt3").addClass("i-txt7").attr("onfocus","this.blur();");			
			$("#zipcode").removeClass("i-txt3").addClass("i-txt7").attr("onfocus","this.blur();");			
			$("#sigungu_en").attr("readonly", true);
			$("#sigungu").attr("readonly", true);
			$("#zipcode").attr("readonly", true);
			
			
	}
	function setOtherNation(){
			//$(".roadname_1").show();
			$(".roadname").hide();
			$("#delv_opt").hide();	//구로유통상가, W Tower
			$("#bill_email").hide();	//세금계산서 이메일			
			if($("#dosi_en option").length>1){     //한국 이외의 나라중에서 도시가 미리 입력이 되어 있는 경우
				$("#dosi_en").parent().show().attr("disabled", false);
				$("#dosi").parent().show().attr("disabled", false);
				$("#dositxt_en").hide();
				$("#dositxt").hide();
			}else{
				$("#dosi_en").parent().hide().attr("disabled", true);
				$("#dosi").parent().hide().attr("disabled", true);
				$("#dositxt_en").show().attr("readonly", false);
				$("#dositxt").show().attr("readonly", false);
			}			
			
			$("#dositxt_en").removeClass("i-txt7").addClass("i-txt3").attr("onfocus","");			
			$("#dositxt").removeClass("i-txt7").addClass("i-txt3").attr("onfocus","");			
			$("#sigungu_en").removeClass("i-txt7").addClass("i-txt3").attr("onfocus","");			
			$("#sigungu").removeClass("i-txt7").addClass("i-txt3").attr("onfocus","");		
			$("#zipcode").removeClass("i-txt7").addClass("i-txt3").attr("onfocus","");		
			$("#sigungu_en").attr("readonly", false);
			$("#sigungu").attr("readonly", false);
			$("#zipcode").attr("readonly", false);
	}

	function checkpwsame(){
		var f =  document.f1;
		if (trim(f.mem_pwd.value)!=trim(f.mem_pwd2.value) ){
			$('#checkspanpw').html("비밀 번호를 같게 입력하세요.");
			$('#checkspanpw').fadeOut().fadeIn(200);
		}else{
			$('#checkspanpw').html("");
		}
	}
	function chgnation(obj){
		
		
		$("#addr").val("");
		$("#addr_en").val("");

		$("#sp_addr").html("");
		$("#sp_addr_en").html("");
		$("#real_doen_val").val("");
		$("#real_dokr_val").val("");
		$(".post_val").empty();
		
		$("#return_val").val("");

		$("#zipcode").val("");
		$("#zipcode").css("background-color",'');
		$("#zipcode").attr("readonly",false);

		$("#sp_addr_en").html($("#nation").children("option:selected").text());
	
		if (obj.value=="48" || obj.value=="73" || obj.value=="2" || obj.value=="134" || obj.value=="142" || obj.value=="1" || obj.value=="241" || obj.value=="257" || obj.value=="258")
		{
			$(".sel_required").html("*");
		}
		else
		{
			$(".sel_required").html("");
		}
				
		if (obj.value=="")
		{
			$("#nation").parent().attr("lang","ko");
			$(".join-form-table input,select").attr("disabled",true);
			$(".join-form-table input:lt(3)").attr("disabled",false);
			$(".join-form-table select:eq(0)").attr("disabled",false);
			
		}else{
			$("#nation").parent().attr("lang","en");
			$(".join-form-table input,select").attr("disabled",false);
			
		}
		
		$("#nation").val(obj.value).attr("selected", "selected");
		$("#nation").siblings("label").text($("#nation").children("option:selected").text());
		if (obj.value=="")
		{
			$("input[name=nation_nm]").val("");	
		}else{
			$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "STC",
					actidx : obj.value
			},
				dataType : "html" ,
				async : false ,
				success: function(data){ 
					$("input[name=nation_nm]").val(data);
					
				}
			});		
		}
		
		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "NPT",
					actidx : obj.value
			},
				dataType : "text" ,
				async : false ,
				success: function(data){ 
					$(".post_val").empty();
					//alert($.trim(data));
					if ($.trim(data)!="")
					{
						if ($.trim(data)=="AUS" || $.trim(data)=="CAN" || $.trim(data)=="CHN" || $.trim(data)=="IND" || $.trim(data)=="JPN" || $.trim(data)=="KOR" || $.trim(data)=="TWN" || $.trim(data)=="USA" || $.trim(data)=="GBR")
						{
							
						}
						else
						{
							$(".post_val").append("<input type='checkbox' name='zipcode_no' id='zipcode_no' value='1' onclick='javascript:no_post(this.value)';><span></span>우편번호없음");
						}
					}										
					
				}
		});	

		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "SDA",
				lang : "" , //language
				actidx : obj.value
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
			var $data = $(data);
			$("#dosi").empty();
			$("#dosi").append($($data.html()));
			$("#dosi").siblings("label").text("모국어");
			$("#sigungu,#sigungu_en").val("");
			$("#addr_det,#addr_det_en").val("");
			$("input[name=zipcode]").val("");
			
				$.ajax({ 
					type: "GET", 
					url: "/ajax/proc_ajax.php", 
					data: { actty : "SDA",
							lang : "_en" , //language
							actidx : obj.value
					},
						dataType : "html" ,
						async : false ,
						success: function(data){ 
							var $data = $(data);
							$("#dosi_en").empty();
							$("#dosi_en").append($($data.html()));
							$("#dosi_en").siblings("label").text("English");							
							//$("#sigungu").siblings("label").text("모국어");
							//$("#sigungu_en").siblings("label").text("English");
							//$("#addr").val($("#nation").children("option:selected").text());
							$("#addr_en").val($("#nation").children("option:selected").text());
							//$("#sp_addr u").html($("#nation").children("option:selected").text());
							$("#sp_addr_en u").html($("#nation").children("option:selected").text());
							$("#sp_addr_en").siblings("span").hide();
							 if($("#dosi_en option").length==1){   //도/시가 등록된게 없으면 텍스트 박스로 대체
								$("#dosi_en").parent().hide().next().val("").show();
								$("#dosi").parent().hide().next().val("").show();
							 }else{
								$("#dosi_en").parent().show().next().val("").hide();
								$("#dosi").parent().show().next().val("").hide();
							 }

						}
					});
			}
		});

		if(obj.value== "1"){	//한국일때...
			setKorea('sel');
		}else{
			setOtherNation();
		}
	
	}
	function chgdosi(obj){		
				
		var nation_code;
		$("#dosi").val(obj.value).attr("selected", "selected");
		$("#dosi_en").val(obj.value).attr("selected", "selected");
        $("#dosi").siblings("label").text($("#dosi").children("option:selected").text());
		$("#dosi_en").siblings("label").text($("#dosi_en").children("option:selected").text());
		$("#sigungu,#sigungu_en").val("");
		$("#sp_addr_en").siblings("span").show();

		$.ajax({ 
		type: "GET", 
		url: "/ajax/proc_ajax.php", 
		data: { actty : "SA",
				lang : "" , //language
				actidx : obj.value
		},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
			var $data = $(data);
			$("#sigungu").empty();
			$("#sigungu").append($($data.html()));
			$("#sigungu").siblings("label").text("모국어");
				$.ajax({ 
					type: "GET", 
					url: "/ajax/proc_ajax.php", 
					data: { actty : "SA",
							lang : "_en" , //language
							actidx : obj.value
					},
						dataType : "html" ,
						async : false ,
						success: function(data){ 
							var $data = $(data);
							$("#sigungu_en").empty();
							$("#sigungu_en").append($($data.html()));
							$("#sigungu_en").siblings("label").text("English");

							$("#real_dokr_val").val($("#dosi").children("option:selected").text());
							$("#real_doen_val").val($("#dosi_en").children("option:selected").text());
							
							$("#addr_en").val($("#dosi_en").children("option:selected").text()+", "+$("#zipcode").val()+", "+$("#nation").children("option:selected").text()+".");						
							$("#sp_addr_en").html($("#dosi_en").children("option:selected").text()+", "+$("#zipcode").val()+", "+$("#nation").children("option:selected").text()+".");
							nation_code = $("#nation").children("option:selected").val();
							if (nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241")
							{
								$("#addr").val("["+$("#zipcode").val()+"] "+ $("#dosi").children("option:selected").text());
								$("#sp_addr").html("["+$("#zipcode").val()+"] "+ $("#dosi").children("option:selected").text());
							}else{
								$("#addr").val("["+$("#zipcode").val()+ "] " + $("#dosi").children("option:selected").text()+", ");
								$("#sp_addr").html("["+$("#zipcode").val()+"] "+$("#dosi").children("option:selected").text());

							}
							
						}
					});
			}
		});
	}

	function chgsigungu(obj,enty){
		
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var nation_code = $("#nation").children("option:selected").val();
		var nation_val=$("#nation").children("option:selected").text();		
		
		var post_val="";
		var post_val_en="";
		if (check_val==true)
		{
			post_val="";
			post_val_en="";
		}
		else
		{
			if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
			else
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
		}
		var do_en_val=$("#real_doen_val").val();
		var do_kr_val=$("#real_dokr_val").val();
		var sigun_en_val=$("#sigungu_en").val();
		var sigun_kr_val=$("#sigungu").val();
		var detail_en_addr=$("#addr_det_en").val();
		var detail_kr_addr=$("#addr_det").val();

		$("#sp_addr_en").siblings("span").show();
		
		if (enty=="_en")
		{
			var en_val = obj.value;
			var kr_val = sigun_kr_val;						
		}
		else
		{
			var en_val = sigun_en_val;
			var kr_val = obj.value;
		}

				
		if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
		{
			
			$("#addr").val(post_val+" "+do_kr_val+" "+kr_val+" "+detail_kr_addr);
			$("#addr_en").val(detail_en_addr+" "+en_val+" "+do_en_val+", "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+" "+do_kr_val+" "+kr_val+" "+detail_kr_addr);
			$("#sp_addr_en").html(detail_en_addr+" "+en_val+" "+do_en_val+", "+post_val_en+" "+nation_val);

		}else{
			
			$("#addr").val(post_val+detail_kr_addr+" "+kr_val+" "+do_kr_val);
			$("#addr_en").val(detail_en_addr+" "+en_val+" "+do_en_val+", "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+detail_kr_addr+" "+kr_val+" "+do_kr_val);
			$("#sp_addr_en").html(detail_en_addr+" "+en_val+" "+do_en_val+", "+post_val_en+" "+nation_val);
		}
	}

	function chgdositxt(obj,enty){		
		
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var nation_code = $("#nation").children("option:selected").val();
		var nation_val=$("#nation").children("option:selected").text();		
		
		var post_val="";
		var post_val_en="";
		if (check_val==true)
		{
			post_val="";
			post_val_en="";
		}
		else
		{
			if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
			else
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
		}
		var do_en_val=$("#real_doen_val").val();
		var do_kr_val=$("#real_dokr_val").val();
		var sigun_en_val=$("#sigungu_en").val();
		var sigun_kr_val=$("#sigungu").val();
		var detail_en_addr=$("#addr_det_en").val();
		var detail_kr_addr=$("#addr_det").val();

		$("#sp_addr_en").siblings("span").show();
		
		if (enty=="_en")
		{
			$("#real_doen_val").val(obj.value);
			var en_val = obj.value;
			var kr_val = do_kr_val;
		}
		else
		{
			$("#real_dokr_val").val(obj.value);
			var en_val = do_en_val;
			var kr_val = obj.value;
		}
		
		if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
		{
			$("#addr").val(post_val+" "+kr_val+" "+sigun_kr_val+" "+detail_kr_addr);
			$("#addr_en").val(detail_en_addr+" "+sigun_en_val+" "+en_val+", "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+" "+kr_val+" "+sigun_kr_val+" "+detail_kr_addr);
			$("#sp_addr_en").html(detail_en_addr+" "+sigun_en_val+" "+en_val+", "+post_val_en+" "+nation_val);

		}else{			
			$("#addr").val(post_val+detail_kr_addr+" "+sigun_kr_val+" "+kr_val);
			$("#addr_en").val(detail_en_addr+" "+sigun_en_val+" "+en_val+", "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+detail_kr_addr+" "+sigun_kr_val+" "+kr_val);
			$("#sp_addr_en").html(detail_en_addr+" "+sigun_en_val+" "+en_val+", "+post_val_en+" "+nation_val);
		}
	}
	function check(){
		var f =  document.f1;
		if (trim(f.typ.value)=="write"){
			checkid('id',f.mem_id.value,'아이디');			
			if (checkvalid!=true){
				alert("아이디를 확인하세요");
				f.mem_id.focus();
				return;
			}			

			if (nullchk(f.mem_pwd,"비밀번호를 입력하세요.")== false) return ;		
			if (nullchk(f.mem_pwd2,"비밀번호와 같게 입력하세요.")== false) return ;		
		}

		if (trim(f.mem_pwd.value)!=trim(f.mem_pwd2.value) ){
			alert("비밀번호와 같게 입력하세요.");
			f.mem_pwd2.value="";
			f.mem_pwd2.focus();
			return;
		}
		if (nullchk(f.nation,"국가명을 선택하세요.")== false) return ;		
		if (nullchk(f.mem_nm_en,"회사명(English)을 입력하세요.")== false) return ;		
		if (nullchk(f.mem_nm,"회사명을 입력하세요.")== false) return ;		
		if (nullchk(f.pos_nm_en,"대표자(English)를 입력하세요.")== false) return ;		
		if (nullchk(f.pos_nm,"대표자를 입력하세요.")== false) return ;		
		if (nullchk(f.tel,"전화번호를 입력하세요.")== false) return ;
		
		if (nullchk(f.zipcode,"우편번호를 입력하세요.")== false) return ;
		//if (nullchk(f.dosi_en,"도/시(English)를 선택하세요.")== false) return ;
		//if (nullchk(f.dosi,"도/시를 선택하세요.")== false) return ;
		//if (nullchk(f.sigungu_en,"시군구(English)를 선택하세요.")== false) return ;
		if (nullchk(f.sigungu,"시군구를 선택하세요.")== false) return ;
		if (nullchk(f.addr_en,"상세주소(English)를 입력하세요.")== false) return ;
		if (nullchk(f.addr,"상세주소를 입력하세요.")== false) return ;
		if (nullchk(f.email,"이메일을 입력하세요.")== false) return ;
		var mem_ty = $("input[name=mem_type]:checked").val();
		if ($("input[name=mem_type]:checked").length==0){mem_ty="0";}
		$("#dosi_en").attr("disabled", false);
		$("#dosi").attr("disabled", false);
		$("#sigungu_en").attr("disabled", false);
		$("#sigungu").attr("disabled", false);
		var formData = $("#f1").serialize(); 
		$.ajax({
				url: "/kor/proc/member_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
					var splData = data.split(":");
					//alert(data);
					if (trim(splData[0]) == "SUCCESS"){
						showajaxParam(".col-left", "joinus2", "rel_idx="+trim(splData[1])+"&mem_type="+mem_ty);
						showajaxParam("#joinForm2", "mem", "rel_idx="+trim(splData[1])+"&mem_type="+mem_ty);
						showajaxParam("#section2", "impship", "rel_idx="+trim(splData[1]));
						showajaxParam("#section3", "agency", "rel_idx="+trim(splData[1]));
						
					}else{
						alert(data);
					}
				}
		});		
	}

	function MustChk()
	{		
		var f =  document.f1;
		if(f.mem_id.value==""){ return "mem_id";}
		if(f.mem_pwd.value==""){ return "mem_pwd";}
		if(f.mem_pwd2.value==""){ return "mem_pwd2";}
		if(f.nation.value==""){ return "nation";}
		if(f.mem_nm_en.value==""){ return "mem_nm_en";}
		if(f.pos_nm_en.value==""){ return "pos_nm_en";}
		if(f.tel.value==""){ return "tel";}
		if(f.zipcode.value==""){ return "zipcode";}
		if(f.dosi_en.value=="" && f.dositxt_en.value==""){ return "dosi_en";}
		if(f.sigungu_en.value==""){ return "sigungu_en";}
		if(f.addr.value==""){ return "addr";}
		if(f.email.value==""){ return "email";}
		return true;
	}
	function find_zip_spc_road(ty)
	{		
		if ($("#spcroad"+ty).prop("checked") == false)
		{
			var postnew="";
			var addr1 = "";
			var addr_en = "";			
			$("#spcroad"+ty).prop("checked",false).removeClass("checked");

			$("#dositxt").val("");
			$("#dositxt_en").val("");
			$("#real_doen_val").val("");
			$("#real_dokr_val").val("");
			$("#addr").val("");
			$("#addr_en").val("South Korea");

			$("#sp_addr").html("");
			$("#sp_addr_en").html("South Korea");

		}else{
			if (ty =="1")
			{			
				
				var postnew="08217";
				var ad1 ="서울시 구로구";
				var ad2 = "경인로53길 15 중앙유통단지";
				var addr1 = ad1+" "+ad2;
				var ade1 = "Chungang Circulation Complex 15 Gyeonginro53gil";
				var ade2 = " Guro-Gu Seoul";
				var addr_en = ade1+ade2;			
				$("#spcroad2").prop("checked",false).removeClass("checked");
				

				$("#addr").val("["+postnew+"] "+ad1+" "+ad2);
				$("#addr_en").val(addr_en + ", " + postnew + ", South Korea");

				$("#sp_addr").html("["+postnew+"] "+ad1+" "+ad2);
				$("#sp_addr_en").html(addr_en + ", " + postnew + ", South Korea");

				$("#dositxt").val("서울시");
				$("#dositxt_en").val("Seoul");
				$("#real_doen_val").val("Seoul");
				$("#real_dokr_val").val("서울시");
			}else{
				var postnew="08215";
				var ad1 ="서울시 구로구";
				var ad2 = "경인로53길 90 STX W-Tower";
				var addr1 = ad1+" "+ad2;
				var ade1 = "STX W-Tower 90 Gyeonginro53gil";
				var ade2 = " Guro-Gu Seoul";
				var addr_en = ade1+ade2;	
				$("#spcroad1").prop("checked",false).removeClass("checked");
				

				$("#addr").val("["+postnew+"] "+ad1+" "+ad2);
				$("#addr_en").val(addr_en + ", " + postnew + ", South Korea");

				$("#sp_addr").html("["+postnew+"] "+ad1+" "+ad2);
				$("#sp_addr_en").html(addr_en + ", " + postnew + ", South Korea");

				$("#dositxt").val("서울시");
				$("#dositxt_en").val("Seoul");
				$("#real_doen_val").val("Seoul");
				$("#real_dokr_val").val("서울시");
				
			}
		}
		
			var $of = $("#joinForm1");
			var sigungu = addr1.split(" ");
			$of.find("input[name=zipcode]").val(postnew);						
			$of.find("input[name=addr]").val((postnew==""?"South Korea":"("+postnew+") ")+addr1);
			$of.find("#sp_addr u").html((postnew==""?"South Korea":"("+postnew+") ")+addr1);					
			$of.find("#sigungu").val(sigungu[1]);										
			var sigungu_en = addr_en.split(" ");
			var nation = $("#nation").children("option:selected").text();
			$of.find("input[name=addr_en]").val(addr_en+" "+postnew+" "+nation);
			$of.find("#sp_addr_en u").html(addr_en+" "+postnew+" "+nation);
			$of.find("#sigungu_en").val(sigungu_en[sigungu_en.length-2]);
			var code = "3";				
			$("#dosi").siblings("label").text($("#dosi option[value="+code+"]").html());
			$("#dosi_en").siblings("label").text($("#dosi_en option[value="+code+"]").html());
			$("#dosi option").attr("selected",false);
			$("#dosi option[value="+code+"]").attr("selected",true);
			$("#dosi_en option").attr("selected",false);
			$("#dosi_en option[value="+code+"]").attr("selected",true);
			$("#sp_addr_en").siblings("span").show();
			$("#addr_det_en").val(ade1);
			$("#addr_det").val(ad2);			
			$of.find("input[name=addr_det]").focus();							
			setKorea('chk');
	}

	var select = $("select");
    select.change(function(){
        var select_name = $(this).children("option:selected").text();
        $(this).siblings("label").text(select_name);
		
		if (MustChk() == true)
			{	
				$("#joinForm1 .btn-area span:eq(0)").hide();
				$("#joinForm1 .btn-area span:eq(1)").show();
			}
    });

	function post_num_val(str)
	{		
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var nation_code = $("#nation").children("option:selected").val();
		var nation_val=$("#nation").children("option:selected").text();		
		
		var post_val="";
		var post_val_en="";
		if (check_val==true)
		{
			post_val="";
			post_val_en="";
		}
		else
		{
			if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
			else
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
		}
		var do_en_val=$("#real_doen_val").val();
		var do_kr_val=$("#real_dokr_val").val();
		var sigun_en_val=$("#sigungu_en").val();
		var sigun_kr_val=$("#sigungu").val();
		var detail_en_addr=$("#addr_det_en").val();
		var detail_kr_addr=$("#addr_det").val();

		if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
		{
			$("#addr").val(post_val+" "+do_kr_val+" "+sigun_kr_val+" "+detail_kr_addr);
			$("#addr_en").val(detail_en_addr+" "+sigun_en_val+" "+do_en_val+" "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+", "+do_kr_val+" "+sigun_kr_val+" "+detail_kr_addr);
			$("#sp_addr_en").html(detail_en_addr+" "+sigun_en_val+" "+do_en_val+" "+post_val_en+" "+nation_val);

		}else{
			$("#addr").val(post_val+detail_kr_addr+" "+sigun_kr_val+" "+do_kr_val);
			$("#addr_en").val(detail_en_addr+" "+sigun_en_val+" "+do_en_val+" "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+detail_kr_addr+" "+sigun_kr_val+" "+do_kr_val);
			$("#sp_addr_en").html(detail_en_addr+" "+sigun_en_val+" "+do_en_val+" "+post_val_en+" "+nation_val);
		}
	}

	function detail_val(str,enty)
	{
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var nation_code = $("#nation").children("option:selected").val();
		var nation_val=$("#nation").children("option:selected").text();		
		
		var post_val="";
		var post_val_en="";
		if (check_val==true)
		{
			post_val="";
			post_val_en="";
		}
		else
		{
			if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
			else
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
		}
		var do_en_val=$("#real_doen_val").val();
		var do_kr_val=$("#real_dokr_val").val();
		var sigun_en_val=$("#sigungu_en").val();
		var sigun_kr_val=$("#sigungu").val();
		var detail_en_addr=$("#addr_det_en").val();
		var detail_kr_addr=$("#addr_det").val();
		
		if (enty=="_en")
		{			
			var en_val = str.value;
			var kr_val = detail_kr_addr;
		}
		else
		{
			var en_val = detail_en_addr;
			var kr_val = str.value;
		}

		if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
		{
			$("#addr").val(post_val+" "+do_kr_val+" "+sigun_kr_val+" "+kr_val);
			$("#addr_en").val(en_val+" "+sigun_en_val+" "+do_en_val+", "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+" "+do_kr_val+" "+sigun_kr_val+" "+kr_val);
			$("#sp_addr_en").html(en_val+" "+sigun_en_val+" "+do_en_val+", "+post_val_en+" "+nation_val);

		}else{
			$("#addr").val(post_val+kr_val+" "+sigun_kr_val+" "+do_kr_val);
			$("#addr_en").val(en_val+" "+sigun_en_val+" "+do_en_val+", "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+kr_val+" "+sigun_kr_val+" "+do_kr_val);
			$("#sp_addr_en").html(en_val+" "+sigun_en_val+" "+do_en_val+", "+post_val_en+" "+nation_val);
		}
	}

	function no_post(str)
	{
		var check_val = $("input:checkbox[id='zipcode_no']").is(":checked");
		var nation_code = $("#nation").children("option:selected").val();
		var nation_val=$("#nation").children("option:selected").text();		
	
		var post_val="";
		var post_val_en="";
		if (check_val==true)
		{
			post_val="";
			post_val_en="";

			$("#zipcode").attr("readonly",true);
			$("#zipcode").css("background-color",'rgb(235, 235, 228)');
			$("#zipcode").val(" ");
		}
		else
		{
			$("#zipcode").val("");
			$("#zipcode").css("background-color",'');
			$("#zipcode").attr("readonly",false);

			if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
			else
			{
				post_val="["+$("#zipcode").val()+"] ";
				post_val_en=""+$("#zipcode").val()+", ";
			}
		}
		var do_en_val=$("#real_doen_val").val();
		var do_kr_val=$("#real_dokr_val").val();
		var sigun_en_val=$("#sigungu_en").val();
		var sigun_kr_val=$("#sigungu").val();
		var detail_en_addr=$("#addr_det_en").val();
		var detail_kr_addr=$("#addr_det").val();
	
		if ((nation_code =="1" || nation_code =="2" || nation_code =="142" || nation_code =="241"))
		{
			$("#addr").val(post_val+" "+do_kr_val+" "+sigun_kr_val+" "+$("#addr_det").val());
			$("#addr_en").val(do_en_val+" "+sigun_en_val+" "+$("#addr_det_en").val()+", "+nation_val+" "+post_val_en);

			$("#sp_addr").html(post_val+" "+do_kr_val+" "+sigun_kr_val+" "+$("#addr_det").val());
			$("#sp_addr_en").html(do_en_val+" "+sigun_en_val+" "+$("#addr_det_en").val()+", "+nation_val+" "+post_val_en);

		}else{
			$("#addr").val(post_val+$("#addr_det").val()+" "+sigun_kr_val+" "+do_kr_val);
			$("#addr_en").val($("#addr_det_en").val()+" "+sigun_en_val+" "+do_en_val+" "+post_val_en+" "+nation_val);

			$("#sp_addr").html(post_val+$("#addr_det").val()+" "+sigun_kr_val+" "+do_kr_val);
			$("#sp_addr_en").html($("#addr_det_en").val()+" "+sigun_en_val+" "+do_en_val+" "+post_val_en+" "+nation_val);
		}
		
	}

	function return_address()
	{

		var return_value=$("#return_val").val();
		var zipcode_val="";
		var dosi_val="";
		var sigun_val="";
		var detail_val="";

		zipcode_val=$("#zipcode").val();
		dosi_val=$("#real_dokr_val").val();
		sigun_val=$("#sigungu").val();
		detail_val=$("#addr_det").val();
		
		//alert(return_value);
		if (return_value=="on" || return_value=="")
		{	
			$("#return_val").val("off");			

			$("#addr").val("["+zipcode_val+"] "+dosi_val+" "+sigun_val+" "+detail_val);
			$("#sp_addr").html("["+zipcode_val+"] "+dosi_val+" "+sigun_val+" "+detail_val);
		}
		else
		{		
			$("#return_val").val("on");

			$("#addr").val("["+zipcode_val+"] "+detail_val+" "+sigun_val+" "+dosi_val);
			$("#sp_addr").html("["+zipcode_val+"] "+detail_val+" "+sigun_val+" "+dosi_val);
		}
				
	}

</SCRIPT>


<section id="joinForm1" class="box-type1">
				<form name="f1" id="f1">
				<input type="hidden" name="typ" value="<?=$typ?>">
				<input type="hidden" name="idx" value="<?=$idx?>">
				
					<div class="box-top option">
						<label class="ipt-rd rd4 <?php if ($mem_type=="1"){echo "c-yellow";}?>"><input type="radio" <?if (($_SESSION["MEM_IDX"]!="" ||  $mode == "edit") && ($mem_type =="3" || $mem_type =="4" || $mem_type =="5")){?> readonly disabled<?}?> name="mem_type" value="1" <?if($mem_type=="1"){echo "checked class='checked'";}?>><span></span>유통회사</label>
						<label class="ipt-rd rd4 <?php if ($mem_type=="2"){echo "c-yellow";}?>"><input type="radio" <?if (($_SESSION["MEM_IDX"]!="" ||  $mode == "edit") && ($mem_type =="3" || $mem_type =="4" || $mem_type =="5")){?> readonly disabled<?}?> name="mem_type" value="2" <?if($mem_type=="2"){echo "checked class='checked'";}?>><span></span>제조회사</label>
						<label class="ipt-rd rd4 <?php if ($mem_type=="3"){echo "c-yellow";}?>"><input type="radio" <?if (($_SESSION["MEM_IDX"]!="" ||  $mode == "edit") && ($mem_type !="4")){?> readonly disabled<?}?> name="mem_type" value="3" <?if($mem_type=="3"){echo "checked class='checked'";}?>><span></span>교육기관</label>
						<label class="ipt-rd rd4 <?php if ($mem_type=="4"){echo "c-yellow";}?>"><input type="radio" <?if (($_SESSION["MEM_IDX"]!="" ||  $mode == "edit") && ($mem_type =="1" || $mem_type =="2" || $mem_type =="3")){?> readonly disabled<?}?> name="mem_type" value="4" <?if($mem_type=="4"){echo "checked class='checked'";}?>><span></span>개인</label>
						<label class="ipt-rd rd4 <?php if ($mem_type=="5"){echo "c-yellow";}?>"><input type="radio" <?if (($_SESSION["MEM_IDX"]!="" ||  $mode == "edit")&& ($mem_type =="1" || $mem_type =="2" || $mem_type =="3")){?> readonly disabled<?}?> name="mem_type" value="5" <?if($mem_type=="5"){echo "checked class='checked'";}?>><span></span>학생</label>
					</div>
					<table class="join-form-table" >
						<colgroup>
							<col style="width:141px">
							<col style="width:215px">
							<col style="width:25px">
							<col style="width:230px">
							<col style="">
						</colgroup>
						<tbody>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> <span class="variable" id="sp_mem_id">회사</span> <span lang="en">ID</span></th>
								<td><input type="text" name="mem_id" lang="en"  class="i-txt3 c-blue" onkeyup="this.value=this.value.replace(/[^(a-zA-Z0-9\s)]/g,'')" maxlength="15" <?if ($typ=="write"){?>onblur="checkid('id',this.value,'아이디');"<?}?> value="<?=$mem_id?>" <?=$typ=="edit"?"readonly":""?>></td>
								<td>&nbsp;</td>
								<td colspan="2"><?if ($typ=="write"){?><span id="checkspanid">* <span lang="en">ID</span>는 <span lang="en">5~15</span>자 사이의 영문+숫자</span><?}?></td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> <span lang="en">Password</span></th>
								<td><input type="password" lang="en" name= "mem_pwd" class="i-txt3 c-blue"></td>
								<td>&nbsp;</td>
								<td colspan="2"><span id="checkspanpw"><?if ($typ=="edit"){?>* <span lang="en">Password</span> 변경시에만 입력<?}?></span></td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> <span lang="en">Password</span> 재 입력</th>
								<td><input type="password" lang="en" name="mem_pwd2" class="i-txt3 c-blue" onblur="checkpwsame();"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> <span lang="ko">국가</span></th>
								<td>
									<div class="select type5" lang="en">
										<label lang="en"><?=($nation)?GF_Common_GetSingleList("NA",$nation):"Nation"?></label>
										<?=GF_Common_SetComboList("nation", "NA", "", 1, "True",  "", $nation , "onchange='chgnation(this);'");?>
									</div>
								</td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> <span class="variable" id="sp_mem_nm">회사명</span></th>
								<td><input type="text" class="i-txt3 c-blue" placeholder="English" name="mem_nm_en" lang="en"  value="<?=$mem_nm_en?>"></td>
								<td class="t-ct">/</td>
								<td colspan="2"><input type="text" class="i-txt3 c-blue" placeholder="모국어" lang="ko" name="mem_nm"  value="<?=$mem_nm?>"></td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> <span class="variable" id="sp_pos_nm">대표자</span></th>
								<td><input type="text" class="i-txt3 c-blue" placeholder="English" name="pos_nm_en" lang="en"  value="<?=$pos_nm_en?>"></td>
								<td class="t-ct">/</td>
								<td colspan="2"><input type="text" class="i-txt3 c-blue" placeholder="모국어" lang="ko" name="pos_nm" value="<?=$pos_nm?>"></td>
							</tr>
							<tr class="indivi">
								<th scope="row"> <span lang="variable" id="sp_depart_nm">부서</span></th>
								<td><input type="text" class="i-txt3 c-blue" name="depart_nm" value="<?=$depart_nm?>"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr class="indivi">
								<th scope="row"> <span lang="variable" id="sp_homepage_rel">회사홈페이지</span></th>
								<td><input type="text" class="i-txt3 c-blue" lang="en" name="homepage_rel" value="<?=$homepage_rel?>"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>

							<tr class="indivi">
								<th scope="row"><strong class="c-red">*</strong> <span lang="variable" id="sp_rel_nm">회사이름</span></th>
								<td><input type="text" class="i-txt3 c-blue" name="rel_nm" value="<?=$rel_nm?>"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr class="indivi">
								<th scope="row"><strong class="c-red">*</strong> <span lang="variable" id="sp_birthday">생일</span></th>
								<td><input type="text" class="i-txt3 c-blue" lang="en" name="birthday" value="<?=$birthday?>"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> <span lang="en">Tel</span></th>
								<td><input type="text" class="i-txt3 c-blue" lang="en" name="nation_nm" style="width:37px;"  maxlength="5" value="+<?=$nation_number?>-" readonly>&nbsp<input type="text" class="i-txt3 c-blue onlynum" lang="en" name="tel" style="width:173px;" value="<?=preg_replace('/\+.+\-/', "",$tel)?>"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th scope="row"><span lang="en">Fax</span></th>
								<td><input type="text" class="i-txt3 c-blue" lang="en" name="nation_nm" style="width:37px;" maxlength="5" value="+<?=$nation_number?>-" readonly>&nbsp<input type="text" class="i-txt3 c-blue onlynum" lang="en" name="fax" style="width:173px;" value="<?=preg_replace('/\+.+\-/', "",$fax)?>"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th scope="row">휴대전화</th>
								<td><input type="text" class="i-txt3 c-blue" lang="en" name="nation_nm" style="width:37px;" maxlength="5" value="+<?=$nation_number?>-" readonly>&nbsp<input type="text" class="i-txt3 c-blue onlynum" lang="en" name="hp" style="width:173px;" value="<?=preg_replace('/\+.+\-/', "",$hp)?>"></td>								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> 우편번호</th>
								<td><input type="text" class="i-txt3 c-blue onlynum" lang="en" onkeyup="javascript:post_num_val(this.value);" name="zipcode" id="zipcode" value="<?=$zipcode?>"> </td>
								<td colspan="3"> <span class="c-red">&nbsp;&nbsp;
								<span class="roadname_1" style="display:<?if ( $nation=="1"){echo "none";}?>;"><img src="/kor/images/btn_roadname_1.gif" border=0 align=absmiddle alt="도로명주소"></span>
								<button type="button" onclick="openCommLayer('layer4','layerZipNew','?frm_name=joinForm1&frm_zip1=zipcode&frm_addr1=addr&frm_addr2=addr_det&frm_addr_en=addr_en');" class="roadname" style="display:<?if ($nation!="1"){echo "none";}?>;"><img src="/kor/images/btn_roadname.gif" border=0 align=absmiddle alt="도로명주소"></button>
								<label class="ipt-chk chk2 c-blue post_val"></label><br>
								</span></td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red sel_required">*</strong> 도/시</th>
								<td>
									<div class="select type5" lang="en" style="display:<?=($dosi_en!=""|| ($dosi_en=="" && $dositxt_en=="") && $nation!="1")?"":"none"?>;">
										<label class="c-blue"><?=($dosi_en)?GF_Common_GetSingleList_LANG("NA",$dosi_en,"_en"):"English"?></label>
										<?=GF_Common_SetComboList("dosi_en", "NA", $nation, 2, "True",  "", $dosi_en , "onchange='chgdosi(this);'".(($nation == "1") ? " disabled":"") ,"_en");?>
										<?//=GF_Common_SetComboList("dosi_en", "NA", $nation, 2, "True",  "do/si", $dosi_en , "onchange='chgdosi(this);'","_en");?>
									</div>
								<input type="text" onkeyup="chgdositxt(this,'_en');" class="i-txt<?=($nation == "1") ? "7":"3"?> c-blue no_hangul" placeholder="English" name="dositxt_en" id="dositxt_en" value="<?=$dositxt_en?>" lang="en" style="display:<?=($dositxt_en!="" || $nation =="1")?"":"none"?>;">
								<input type="hidden" id="real_doen_val" value="" />
									</td>
								<td class="t-ct">/</td>
								<td><div class="select type5" style="display:<?=($dosi!=""|| ($dosi=="" && $dositxt=="")&& $nation!="1")?"":"none"?>;" >
									<label class="c-blue"><?=($dosi)?GF_Common_GetSingleList_LANG("NA",$dosi,""):"모국어"?></label>
									<?=GF_Common_SetComboList("dosi", "NA", $nation, 2, "True",  "", $dosi , "onchange='chgdosi(this);'".(($nation == "1") ? " disabled":"") );?>
									<?//=GF_Common_SetComboList("dosi", "NA", $nation, 2, "True",  "도/시", $dosi , "onchange='chgdosi(this);'");?>
								</div>
								<input type="text" onkeyup="chgdositxt(this,'');" class="i-txt<?=($nation == "1") ? "7":"3"?> c-blue" placeholder="모국어" name="dositxt" id="dositxt" value="<?=$dositxt?>" style="display:<?=($dositxt!="" || $nation =="1") ?"":"none"?>;" lang="ko">
								<input type="hidden" id="real_dokr_val" value="<?=($dosi)?GF_Common_GetSingleList_LANG("NA",$dosi,""):"모국어"?>" />
								</td>
								<td rowspan="2">
									<div id="delv_opt">
									<label class="ipt-chk chk2 c-blue"><input type="checkbox" name="spcroad" id="spcroad1" value="1" onclick="find_zip_spc_road(1)";><span></span>구로중앙유통</label><br>
									<label class="ipt-chk chk2 c-blue"><input type="checkbox" name="spcroad" id="spcroad2" value="2" onclick="find_zip_spc_road(2)";><span></span>구로 STX W Tower</label>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red sel_required">*</strong>  시/군/구</th>
								<td><input type="text" onkeyup="chgsigungu(this,'_en');" class="i-txt<?=($nation == "1") ? "7":"3"?> c-blue no_hangul" placeholder="English" name="sigungu_en" id="sigungu_en" value="<?=$sigungu_en?>" <?=($nation == "1") ? " readonly":""?> lang="en">
								<td class="t-ct">/</td>
								<td><input type="text" onkeyup="chgsigungu(this,'');" class="i-txt<?=($nation == "1") ? "7":"3"?> c-blue" placeholder="모국어" name="sigungu" id="sigungu" value="<?=$sigungu?>" <?=($nation == "1") ? " readonly":""?> lang="ko"></td>
								<!--<td>
									<div class="select type5" lang="en">
										<label><?=($sigungu_en)?GF_Common_GetSingleList_LANG("NA",$sigungu_en,"_en"):"English"?></label>
										<?=GF_Common_SetComboList("sigungu_en", "NA", $dosi_en, 3, "True",  "", $sigungu_en , "onchange='chgsigungu(this);'" ,"_en" );?>
										<?//=GF_Common_SetComboList("sigungu_en", "NA", $dosi_en, 3, "True",  "si/gun/gu", $sigungu_en , "onchange='chgsigungu(this);'" ,"_en" );?>
										<input type="text" class="i-txt3" placeholder="English" name="addr_det_en" value="<?=$addr_det_en?>" style="width:308px;" lang="en">&nbsp

									</div></td>
								<td class="t-ct">/</td>
								<td><div class="select type5">
										<!--<label><?=($sigungu)?GF_Common_GetSingleList_LANG("NA",$sigungu,""):"모국어"?></label>
										<?=GF_Common_SetComboList("sigungu", "NA",  $dosi, 3, "True",  "", $sigungu , "onchange='chgsigungu(this);'");?>
										<?//=GF_Common_SetComboList("sigungu", "NA",  $dosi, 3, "True",  "시/군/구", $sigungu , "onchange='chgsigungu(this);'");?>
										<input type="text" class="i-txt3" placeholder="English" name="addr_det_en" value="<?=$addr_det_en?>" style="width:308px;" lang="en">&nbsp
								</div></td>-->
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong>  상세주소</th>
								<td colspan="4"><input type="text" onkeyup="javascript:detail_val(this,'_en');" class="i-txt3 c-blue no_hangul" placeholder="English" id="addr_det_en" name="addr_det_en" value="<?=$addr_det_en?>" style="width:300px;" lang="en">&nbsp; / &nbsp;<input type="text" onkeyup="javascript:detail_val(this,'');" class="i-txt3 c-blue" placeholder="모국어" lang="ko" id="addr_det" name="addr_det" value="<?=$addr_det?>" style="width:300px"></td>
							</tr>
							<tr>
								<th rowspan="2" scope="row"><strong class="c-red">*</strong>  주소</th>
								<td colspan="4" lang="en"><input type="hidden" class="i-txt3 c-blue" placeholder="English" name="addr_en" id="addr_en" value="<?=$addr_en?>" style="width:308px" lang="en"><span class="c-blue" style="width:508px" id="sp_addr_en"><u><?=$addr_en?></u></span></td>
							</tr>
							<tr>
								<td colspan="4" lang="en"><input type="hidden" class="i-txt3 c-blue" placeholder="모국어"  name="addr" id="addr" value="<?=$addr?>" style="width:308px"><span class="c-blue"  id="sp_addr" style="width:508px" ><u><?=$addr?></u></span>&nbsp&nbsp<img width="15px" style="cursor:pointer;" src="/kor/images/address_change.png" onclick="javascript:return_address();"/><input type="hidden" id="return_val" name="return_val" value="on"></td>
							</tr>
							<tr>
								<th scope="row"><strong class="c-red">*</strong> <span lang="en">E-mail</span></th>
								<td><input type="text" class="i-txt3 c-blue" lang="en" name="email" value="<?=$email?>"></td>
								<td></td>
								<td colspan="2">
									<div id="bill_email">
									전자세금계산서 <span lang="en">E-Mail</span> <input type="text" class="i-txt3 c-blue" lang="en" name="" value="">
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row">홈페이지</th>
								<td><input type="text" class="i-txt3 c-blue" lang="en" name="homepage" value="<?=$homepage?>"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th scope="row"><span lang="en">Skype ID</span></th>
								<td><input type="text" class="i-txt3 c-blue" lang="en" name="skypeId" value="<?=$skypeId?>"></td>
								<td>&nbsp;</td>
								<td colspan="2">&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<div class="btn-area">						
						<span style="display:<?if ($typ=="edit"){?>none<?}?>;"><img src="/kor/images/btn_next_step_1.gif" alt="저장 후 다음단계"></span>
						<span style="display:<?if ($typ=="write"){?>none<?}?>;"><img src="/kor/images/btn_next_step.gif" alt="저장 후 다음단계" style="cursor:pointer;" onclick="check();"  ></span>
					</div>
				</form> 
			</section>			