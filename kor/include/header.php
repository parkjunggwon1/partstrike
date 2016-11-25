<?
	session_start();
	ob_start();

	// 자바스크립트에서 go(-1) 함수를 쓰면 폼값이 사라질때 해당 폼의 상단에 사용하면
	// 캐쉬의 내용을 가져옴. 완전한지는 검증되지 않음
	@header("Content-Type: text/html; charset=utf-8");
	$gmnow = gmdate("D, d M Y H:i:s") . " GMT";
	@header("Expires: 0"); // rfc2616 - Section 14.21
	@header("Last-Modified: " . $gmnow);
	@header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	@header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
	@header("Pragma: no-cache"); // HTTP/1.0
	include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";


?>

<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=1360px, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>PARTStrike</title>
<link rel="stylesheet" href="/kor/css/site.css">
<link rel="stylesheet" href="/kor/css/content.css">
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/kor/js/common.js"></script>
<script src="/include/function.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!--
	var com_idx = "<?=$session_com_idx?>";
	var mem_idx = "<?=$_SESSION["MEM_IDX"]?>";
	
//-->
</SCRIPT>
<script src="/kor/js/menu.js"></script>
<!--[if lt IE 9]>
<script src="/kor/js/html5shiv.min.js"></script>
<![endif]-->
<!--[if lt IE 8]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
<![endif]-->


</head>

<body>
<div id="partsWrap">
<!-- header -->
<header id="partsHeader" class="container">
	<h1 class="top-logo"><a href="/"><img src="/kor/images/top_logo.png" alt=""></a></h1>
	<nav id="gnb" class="gnb-wrap">
		<ul<? if ($_SESSION["MEM_IDX"]){ echo ' class="logon"'; }?>>
			<li class="m1"><a href="javascript:;"><img src="/kor/images/top_menu01.png" alt=""></a>
				<div class="gnb2">
					<ul>
						<li id="S"><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:if(chkLogin()){order('S');}"<?}?>>판매</a></li>
						<li id="B"><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:if(chkLogin()){order('B');}"<?}?>>구매</a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:if(chkLogin()){mybox();}"<?}?>><span lang="en">MyBox</span></a></li>
					</ul>
				</div>
			</li>					
			<li class="m2"><a href="javascript:;"><img src="/kor/images/top_menu02.png" alt=""></a>
				<div class="gnb2">
					<ul>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:if(chkLogin()){record('S');}"<?}?>>판매</a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:if(chkLogin()){record('B');}"<?}?>>구매</a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:if(chkLogin()){remit('C');}"<?}?>>My Bank</a></li>
					</ul>
				</div>
			</li>
			<li class="m3"><a href="javascript:;"><img src="/kor/images/top_menu03.png" alt=""></a>
				<div class="gnb2">
					<ul>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:partreg('1');"<?}?>><span lang="en">Special Price Stock</span></a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:partreg('2');"<?}?>>지속적 공급 가능한<br><span lang="en">Special Price Part</span></a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:partreg('3');"<?}?>><span lang="en">Stock</span> (소량)</a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:partreg('4');"<?}?>><span lang="en">Stock</span> (포장단위)</a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:partreg('5');"<?}?>>제조회사 위탁판매 <span lang="en">Stock</span></a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:partreg('6');"<?}?>>해외 위탁판매 <span lang="en">Stock</span></a></li>
					</ul>
				</div>
			</li>
			<li class="m4"><a href="javascript:<?if ($_SESSION["MEM_IDX"]){?>turnkeyreg()<?}?>;"><img src="/kor/images/top_menu04.png" <?if (!$_SESSION["MEM_IDX"]){?>style="cursor:default;"<?}?> alt=""></a></li>
			<li class="m5"><a href="javascript:;"><img src="/kor/images/top_menu05.png" alt=""></a>
				<div class="gnb2">
					<ul>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:editmyinfo('<?=$_SESSION["REL_IDX"]?>');"<?}?>>내 정보 수정</a></li>
						<li><a href="javascript:agent();">제조회사 / 대리점 정보</a></li>
						<li><a href="javascript:lab();">연구소</a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:board('AA002');"<?}?>>질의 응답</a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:board('AA003');"<?}?>>제안</a></li>
					</ul>
				</div>
			</li>

			<li class="m6"><a href="javascript:;"><img src="/kor/images/top_menu06.png" alt=""></a>
				<div class="gnb2">
					<ul>
						<li><a href="javascript:board('AA001');">공지사항</a></li>
						<li><a href="javascript:agreement();">이용약관</a></li>
						<li><a href="javascript:guide();">이용방법</a></li>
						<li><a <?if ($_SESSION["MEM_IDX"]){?>href="javascript:memfee();"<?}?>">회원 가입비</a></li>
						<li><a href="javascript:contact();">연락처</a></li>
					</ul>
				</div>
			</li>
		</ul>
	</nav>
	<ul class="select-nation">
		<li><a href="#" target="_blank"><img src="/kor/images/flag_un.png" alt="영어"></a></li>
        <li><a href="#" target="_blank"><img src="/kor/images/flag-ch.png" alt="중국어"></a></li>
		<li><a href="#" target="_blank"><img src="/kor/images/flag_jp.png" alt="일본어"></a></li>		
	</ul>
	<section id="topSrch" class="top-box1">
		<h2 class="hidden">검색</h2>
		<form id="ftop_sch">
		<input type="hidden" name="actty" value="">
		<input type="hidden" id="sel_nation" name="sel_nation" value="">
		<input type="hidden" id="sel_manufacturer" name="sel_manufacturer" value="">
		<input type="hidden" name="both" value="N">
		<input type="hidden" name="page" value="1">
		<input type="hidden" name="part_type" value="">

			<table>
				<tbody>
					<tr>
						<th scope="row" lang="en">Part No.</th>
						<td><input type="text" name="top_part_no" class="w100 onlyEngNum" style="ime-mode:disabled"  onKeyPress="check_key(main_srch);" ></td>
					</tr>
					<tr>
						<th scope="row" lang="en">Manufacturer</th>
						<td><input type="text" name="top_manufacturer" style="ime-mode:disabled" class="w100 onlyEngNum"  onKeyPress="check_key(main_srch);" ></td>
					</tr>
					<tr>
						<th scope="row">요청수량</th>
						<td><input type="text" class="w50 onlynum numfmt" name="top_qty" style="ime-mode:disabled" onKeyPress="check_key(main_srch);" maxlength="10" >
							<label class="<?=($_SESSION["MEM_IDX"]=="") ?"":"ipt-chk"?> chk1">
								<input type="checkbox" name="area" <?=($_SESSION["MEM_IDX"]=="") ? "disabled style='border-color:#ff8080;'":""?>  >
								<span></span><img src="/kor/images/top_srch_chck<?=($_SESSION["MEM_IDX"]=="") ?"02":""?>.gif" alt="근접지역"></label></td>
					</tr>
					<tr>
						<th scope="row">제조년~</th>
						<td class="chk2">
							<div class="select" lang="en">
								<label for="yr">N/A</label>
								<select id="yr" name="dc">
								<option lang='en' value=''>N/A</option>
								<?
								for($i=date('Y');$i>=date('Y')-9;$i--){
									echo "<option lang='en' value='$i' ".($i==$year?"selected":"").">$i</option>";
								}?>
								</select>
							</div>
							<label class="ipt-chk" lang="en">
								<input type="checkbox" name="top_rhtype" value="RoHS">
								<span></span>RoHS</label>
							<label class="ipt-chk" lang="en">
								<input type="checkbox" name="top_rhtype" value="HF">
								<span></span>HF</label></td>
					</tr>
				</tbody>
			</table>
			<img src="/kor/images/top_btn_srch.gif" class="main_srch" alt="검색" style="cursor:pointer;">
		</form>
	</section>
	<?
		if($_SESSION["MEM_IDX"]==""){
	?>

<script type="text/javascript">
<!--	
	
	function check_login(){
		var f=document.f;
		var mem_ty = $("input[name=top_mem_type]:checked").val();

		if (nullchk(f.rel_id,(mem_ty=="3"?"학교":"회사")+"아이디를 입력하세요.")== false) return ;
		if (nullchk(f.mem_pwd,"비밀번호를 입력하세요.")== false) return ;		
		f.target = "proc";
		f.action = "/kor/proc/member_proc.php";
		f.submit();		
	}

	 $(document).ready(function(){
		 if ($("input[name=top_mem_type]:checked").length==0){
			 $("#topLogin input[type=text],input[type=password]").attr("disabled",true);}
		 
		 $("input[name=top_mem_type]").click(function(){
			 
			 if ($(this).hasClass("checked")==true)
			 {
				$(".chk-list label").removeClass("c-yellow");
				$(this).prop("checked",false).removeClass("checked");
				$("#topLogin input[type=text],input[type=password]").attr("disabled",true);
				$("input[name=rel_id],input[name=mem_id],input[name=mem_pwd]").val("");
			 }
		 });
		 $("input[name=top_mem_type]").change(function(){		
				$("input[name=rel_id],input[name=mem_id],input[name=mem_pwd]").val("");
				$("#topLogin input[type=text],input[type=password]").attr("disabled",false);
				$(".chk-list label").removeClass("c-yellow");
				$(this).parent().addClass("c-yellow");
				$("input[name=rel_id_ck]").prop("checked",false).removeClass("checked");
				$("input[name=mem_id_ck]").prop("checked",false).removeClass("checked");
				$("input[name=mem_pwd_ck]").prop("checked",false).removeClass("checked");
				if ($(this).val() == "3")
				{
					$("#f .variable").each(function(){
						$(this).text($(this).text().replace(/회사/gi,"학교")); 
						$(this).text($(this).text().replace(/직원/gi,"학생")); 
					});
				}else if ($(this).val() == "1" || $(this).val() == "2" )
				{
					$("#f .variable").each(function(){
						$(this).text($(this).text().replace(/학교/gi,"회사")); 
						$(this).text($(this).text().replace(/학생/gi,"직원")); 
					});
				}
				var hid_info = $("#hidden_savd_info").val().split("//");
				if (($(this).val()==hid_info[0]) || ($(this).val() == $("#hidden_com_type").val() && hid_info[0]=="6"))
				{
					$("input[name=rel_id]").val(hid_info[1]);
					$("input[name=mem_id]").val(hid_info[2]);
					$("input[name=mem_pwd]").val(hid_info[3]);
					if ($("input[name=rel_id]").val()!=""){$("input[name=rel_id_ck]").prop("checked",true).addClass("checked");}
					if ($("input[name=mem_id]").val()!=""){$("input[name=mem_id_ck]").prop("checked",true).addClass("checked");}
					if ($("input[name=mem_pwd]").val()!=""){$("input[name=mem_pwd_ck]").prop("checked",true).addClass("checked");}					
				}
			});
	});

	
//-->
</script>


	<section id="topLogin" class="top-box2">
		<h2 class="hidden">로그인</h2>
		<form name="f" id="f" method="post">
		<input type="hidden" id="hidden_savd_info" name="hidden_savd_info" value="<?=$_COOKIE["mem_type_savd"]?>//<?=$_COOKIE["rel_id_savd"]?>//<?=$_COOKIE["mem_id_savd"]?>//<?=$_COOKIE["mem_pwd_savd"]?>">
		<input type="hidden" id="hidden_com_type" value="<?if ($_COOKIE["rel_id_savd"] || $_COOKIE["mem_id_savd"]){echo get_any("member", "mem_type", "mem_id='".$_COOKIE["rel_id_savd"]."' or mem_id='". $_COOKIE["mem_id_savd"]."'" );}?>">
		<input type="hidden" name="typ" value="login">
		<div class="chk-list">
			<ul>
				<li>
					<label class="ipt-rd <?php if ($_COOKIE["mem_type_savd"] =="1" || $_COOKIE["mem_type_savd"] =="6" ){echo "c-yellow";}?>">
						<input type="radio" name="top_mem_type" <?php if ($_COOKIE["mem_type_savd"] =="1" || $_COOKIE["mem_type_savd"] =="6"){echo "checked class='checked'";}?>  value="1">
						<span></span>유통회사</label>
				</li>
				<li>
					<label class="ipt-rd <?php if ($_COOKIE["mem_type_savd"] =="2"){echo "c-yellow";}?>">
						<input type="radio" name="top_mem_type" <?php if ($_COOKIE["mem_type_savd"] =="2"){echo "checked class='checked'";}?> value="2">
						<span></span>제조회사</label>
				</li>
				<li>
					<label class="ipt-rd <?php if ($_COOKIE["mem_type_savd"] =="3"){echo "c-yellow";}?>">
						<input type="radio" name="top_mem_type" <?php if ($_COOKIE["mem_type_savd"] =="3"){echo "checked class='checked'";}?>  value="3">
						<span></span>교육기관</label>
				</li>
				<li>
					<label class="ipt-rd <?php if ($_COOKIE["mem_type_savd"] =="4"){echo "c-yellow";}?>">
						<input type="radio" name="top_mem_type">
						<span></span>개인</label>
				</li>
				<li>
					<label class="ipt-rd <?php if ($_COOKIE["mem_type_savd"] =="5"){echo "c-yellow";}?>">
						<input type="radio" name="top_mem_type">
						<span></span>학생</label>
				</li>
			</ul>
		</div>
			<table>
				<tbody>
					<tr>
						<th scope="row"><span class="variable">회사</span> <span lang="en">ID</span></th>
						<td><input type="text" name="rel_id" style="ime-mode:disabled" value="<?=$_COOKIE["rel_id_savd"]?>">
							<label class="ipt-chk">
								<input type="checkbox" name="rel_id_ck" value=
			"o" <?if(isset($_COOKIE["rel_id_savd"])){echo "checked class='checked'";}?>>
								<span></span></label></td>
					</tr>
					<tr>
						<th scope="row"><span class="variable">직원</span> <span lang="en">ID</span></th>
						<td><input type="text" name="mem_id" style="ime-mode:disabled"  value="<?=$_COOKIE["mem_id_savd"]?>">
							<label class="ipt-chk">
								<input type="checkbox" name="mem_id_ck"  value=
			"o" <?if(isset($_COOKIE["mem_id_savd"])){echo "checked class='checked'";}?>>
								<span></span></label></td>
					</tr>
					<tr>
						<th scope="row" lang="en">Password</th>
						<td><input type="password" name="mem_pwd" value="<?=$_COOKIE["mem_pwd_savd"]?>" onKeyPress="check_key(check_login);" >
							<label class="ipt-chk">
								<input type="checkbox" name="mem_pwd_ck"  value=
			"o" <?if(isset($_COOKIE["mem_pwd_savd"])){echo "checked class='checked'";}?>>
								<span></span></label></td>
					</tr>
				</tbody>
			</table>
			<a href="javascript:check_login();"><img src="/kor/images/top_btn_login.gif" alt="Login"></a>
		</form>
			
		<div class="bt-btn"><a href="javascript:joinus();"><img src="/kor/images/top_btn_join.gif" alt="회원가입"></a></div>
	</section>
	<?
		}else{			
			$mem = get_mem($session_com_idx);
		?>
	<div class="top-logo2 c-blue"><img src="<?=$file_path.$mem[filelogo]?>" width="75" height="18" alt="<?=$mem[mem_nm]?>"> <?=$mem[mem_nm]?></div>
	<section id="topMyinfo" class="top-box2">
		<h2 class="hidden">로그인</h2>
		<div class="info1 clear"><?=$_SESSION["MEM_NM"]?> <?=$_SESSION["REL_IDX"]>0?"/ ".$_SESSION["POS_NM"]:""?>
<img src="/kor/images/top_btn_logout.gif" class="btn-logout" alt="logout" onClick="mem_logout();" style="cursor:pointer;">
		</div>
		<div class="info2">
			<table>
				<tbody>
					<tr>
						<th scope="row">보증금</th>
						<td lang="en">$<?=GetDeposit($_SESSION["MEM_IDX"], $_SESSION["REL_IDX"], "8")?></td>
					</tr>
					<tr>
						<th scope="row">계약금</th>
						<td lang="en">$<?=GetDeposit($_SESSION["MEM_IDX"], $_SESSION["REL_IDX"], "2,6")?></td>
					</tr>
					<tr>
						<th scope="row" lang="en">My Bank</th>
						<td lang="en">$<?=SumMyBank2($_SESSION["MEM_IDX"], $_SESSION["REL_IDX"])?>
							<span lang="en" class="c-red">($<?=SumBankHold($_SESSION["MEM_IDX"], $_SESSION["REL_IDX"]);?>)</span>
							<img src="/kor/images/top_btn_remittance.gif" alt="remittance" class="btn-remittance" style="cursor:pointer;"></td>
					</tr>
					<tr>
						<th scope="row">재고품목</th>
						<td lang="en"><?=stock_cnt($_SESSION["MEM_IDX"], $_SESSION["REL_IDX"])?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="info3 clear"> <img src="/kor/images/nation_title_<?=$mem[nation]?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <strong>가입일 : </strong><?=get_any("member", "DATE_FORMAT(reg_date, '<span lang=en>%Y</span>년 <span lang=en>%m</span>월 <span lang=en>%d</span>일')","mem_idx=".($_SESSION["REL_IDX"]>0?$_SESSION["REL_IDX"]:$_SESSION["MEM_IDX"]))?> <a href="#" class="msg-03">
		<?$msg_cnt= QRY_CNT("board"," and bd_gubun='EE001' and (bd_send_idx='$session_mem_idx') and bd_send_result='0'" );?>
		<?if($msg_cnt){?>
		<img src="/kor/images/top_btn_mail_new.png" alt="mail">
		<?}else{?>
		<img src="/kor/images/top_btn_mail.png" alt="mail">
		<?}?>
		</a> </div>
		<div class="info4 clear"> <span><span lang="en"><!--<?=$_SESSION["MEM_NM_EN"]?></span> <?=$_SESSION["REL_IDX"]>0?"/ ".$_SESSION["POS_NM_EN"]:""?><br>--><?=get_manager($mem[nation])?></span> 
		<a href="#" class="msg-02"  mode='EE001'><img src="/kor/images/top_btn_mail2.png" alt="mail"></a> </div>
	</section>
		<script type="text/javascript">		
			$(document).ready(function(){
				//procReady(<?=$session_mem_idx?>);
			});
		</script>

	<? } ?>	
</header>
<iframe name="proc" id="proc" src="" width="300" height="50" frameborder="0" style="display:none;"></iframe>
<form name="ftop" id="ftop">
<input name="typ" type="hidden" value="">
<input name="part_idx" type="hidden" value="">
<input name="part_type" type="hidden" value="">
<input name="session_mem_idx" id="session_mem_idx" type="hidden" value="<?=$session_mem_idx?>">
<input name="session_rel_idx" id="session_rel_idx" type="hidden" value="<?=$session_rel_idx?>">
<input name="work" type="hidden" value="">
</form>
<!-- //header -->