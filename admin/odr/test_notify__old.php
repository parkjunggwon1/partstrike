<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.other.php";

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">
	.text1{ font-family: "돋움";color:#494949;font-size: 9pt;line-height:30px;}
	.button1{ font-family: "돋움";color:#494949;border: 1pt solid #BEBEBE; background: #EAEAEA; font-size: 9pt;padding:5px 8px 5px 8px;cursor:hand;line-height:30px;}
</style>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script language=javascript src='/include/function.js'></script>
<script type="text/javascript">
<!--
	function close_it(lay_yn){
		if (lay_yn=="y"){
			parent.document.getElementById("popdiv").style.display="none";
		}
		if (lay_yn=="n"){
			self.close();
		}
		
	}

	function check(){
		var f =  document.f1;
	
	
		if ($("input[name=test_result]:checked").length==0){
				alert("결과를 선택하세요."); 
				$("input[name=test_result]:eq(0)").focus();
				return ;	
		}
		if (f.memo.value==""){alert("Comment를 작성하세요."); f.memo.focus();return ;		}
		

		var formData = $("#f1").serialize(); 
		$.ajax({
				url: "/kor/proc/record_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){								
						parent.check_search();
					}else{
						alert(data);
					}
				}
		});		



	}
	
//-->
</script>

<html>
 <head>
  <title> <?=$title?> </title>
 </head>
 <body style="margin:10 10 10 10;padding:10 10 10 10;" bgcolor="#ffffff">
 <table width="99%" border="1">
<form name="f1" id="f1">
<input type="hidden" name="typ" id="typ" value="testresult">
<input type="hidden" name="fty_history_idx" id="fty_history_idx" value="<?=$fty_history_idx?>">
<input type="hidden" name="ship_idx" id="ship_idx" value="<?=$ship_idx?>">
 <tr><td>* 반품 선적 서류</td>
	<td>
	<span  class="button1" onClick="javascript:alert('준비중입니다.');"  style="cursor:pointer;">Non-Commercial Invoice</span> <span  class="button1" onClick="javascript:alert('준비중입니다.');"  style="cursor:pointer;">Packing List</span> <span  class="button1" onClick="javascript:alert('준비중입니다.');"  style="cursor:pointer;">반품 사유서</span>
	</td>
 </tr>
<tr><td>* Test Result</td>
	<td>
		<input type="radio" name="test_result" value="P">Pass <input type="radio" name="test_result" value="F">Fail
	</td>
 </tr>
 <tr><td>* Result Comment</td>
	<td>
		<textarea name="memo" rows="20" cols="40"></textarea>
	</td>
 </tr>
 </table>
</form>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="50%" align="left">&nbsp;</td>
		<td width="50%" align="right"><span  class="button1" onClick="javascript:alert('준비중입니다.');" style="cursor:pointer;">미리보기</span> <span  class="button1" onClick="check();" style="cursor:pointer;">결과공지</span> <span  class="button1" onClick="close_it('y')" style="cursor:pointer;">닫기</span>&nbsp;</td>
	</tr>
	</table>
 </body>
</html>
