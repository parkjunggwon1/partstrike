<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.other.php";

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">
	body{background: #ffffff; }
	.text1{ font-family: "돋움";color:#494949;font-size: 9pt;line-height:30px;}
	.button1{ font-family: "돋움";color:#494949;border: 1pt solid #BEBEBE; background: #ffffff; font-size: 9pt;padding:5px 8px 5px 8px;cursor:hand;line-height:30px;}
</style>
<script type="text/javascript">
<!--
	var d = new Date();

//	alert(d.getHours());
	
	 // 쿠키를 만듭니다. 아래 closeWin() 함수에서 호출됩니다
	function setCookie( name, value, expiredays ){
		var todayDate = new Date();
		todayDate.setDate(todayDate.getDate() + expiredays);
		document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
	}

	function close_it(lay_yn){
		var idx = "<?=$idx?>";
		var d = new Date();

		var gHours = 24 - d.getHours();


				
		 // 체크후 닫기버튼을 눌렀을때 쿠키를 만들고 창을 닫습니다
		if ( document.all.endtoday.checked ){
		
			setCookie(("popupview"+idx), "done" , gHours);  // 오른쪽 숫자는 쿠키를 유지할 기간을 설정합니다
			
		}
		if (lay_yn=="y"){
			parent.document.getElementById("popdiv"+idx).style.display="none";
		}
		if (lay_yn=="n"){
			self.close();
		}		
	}
//-->
</script>

<?
if ($idx){
	$result = QRY_POPUP_VIEW($idx);
	$row = mysql_fetch_array($result);
	$title=replace_out($row["title"]);
	$content=replace_out($row["content"]);
	$log_date=replace_out($row["log_date"]);
	$p_top = replace_out($row["p_top"]); 
	$p_left = replace_out($row["p_left"]);   
	$p_wid = replace_out($row["p_wid"]);   
	$p_hei = replace_out($row["p_hei"]);     
	$lay_yn = replace_out($row["lay_yn"]);    
	$img_yn = replace_out($row["img_yn"]);  
	$scr_yn = replace_out($row["scr_yn"]);   
	$use_yn = replace_out($row["use_yn"]);    
	$url1 = replace_out($row["url1"]);
	$file1 = replace_out($row["file1"]);
	$typ = "edit";
}
//If content<>"" then
//content = Replace(content,"&lt;","<")
//content = Replace(content,"&gt;",">")

//content = Replace(content,"<P>","")
//content = Replace(content,"</P>","")
//End if

?><html>
 <head>
  <title> <?=$title?> </title>
 </head>
 <body style="margin:0 0 0 0;padding:0 0 0 0;">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td>
	<?If ($img_yn=="y" and $file1!=""){
		If ($url1!=""){ 
	?>		<a href="<?=$url1?>" target="_new">
		<?}?>
		<img src="<?=$file_path?><?=$file1?>" border="0" <?If ($p_wid!="" Or $p_wid!="0") {?> width="<?=$p_wid?>"<?}?> <?If ($p_hei!="" or $p_hei!="0") {?> height="<?=$p_hei?>"<?}?>>
		<?If ($url1!="") {?></a><?}?>
	<?}?>		
	<?
	If ($img_yn=="n") {
		echo $content;
	}
	?>
	</td>
 </tr>
  <tr>
	<td align="center" height="27">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="70%" align="left">&nbsp;<label><input type="checkbox" name="endtoday" value=""><span  class="text1">오늘 하루 이창을 열지않음</span></label></td>
		<td width="30%" align="right"><span  class="button1" onclick="close_it('<?=$lay_yn?>')" style="cursor:pointer;">닫기</span>&nbsp;</td>
	</tr>
	</table></td>
 </tr> 
 </table>

	
 </body>
</html>