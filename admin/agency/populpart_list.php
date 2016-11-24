<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];
$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];


include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><!--메뉴-->
		<?
		  include $_SERVER["DOCUMENT_ROOT"]."/admin/include/lm.php";
		?>

		</td>
		<td valign="top">
		<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#8e9194">
			<tr>
				<td align="center" bgcolor="#63676a">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="6" valign="top"><img src="/admin/img/t_01.gif" width="6" height="6" /></td>
						<td background="/admin/img/t_05.gif"></td>
						<td width="6" align="right" valign="top"><img src="/admin/img/t_02.gif" width="6" height="6" /></td>
					</tr>
					<tr>
						<td background="/admin/img/t_07.gif"></td>
						<td align="left" valign="top" bgcolor="#FFFFFF">
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" />   <?=$title_text?></td>
								<td width="100" height="35" class="rtitle01" align="center"></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						
						<!--오른쪽 시작-->
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="typaaa" value="한글">
						<h3>&nbsp;▶▶ Total ◀◀</h3>
						<table width="30%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" >No</td>
								<td width="150" align="center" class="btitle01">PartNo</td>
								<td  width="200" align="center" class="btitle01">Price</td>			
							</tr>
						</table>						
						<!--일반게시글 시작-->
						<?populpart("T");?>
						<br>
						<h3>&nbsp;▶▶ 이번 달 ◀◀</h3>
						<table width="30%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" >No</td>
								<td width="150" align="center" class="btitle01">PartNo</td>
								<td  width="200" align="center" class="btitle01">Price</td>			
							</tr>
						</table>						
						<?populpart("M");?>
						</form>
						<br>
						<!--오른쪽 끝-->
						<br>
						<table width="30%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<Td width=120>&nbsp;</td>
								<td height="40" align="center">
								
								</td>
								<td width="120" align="right"><span class="btn1"><a href="javascript:check();" >등록</a></span>
								</td>
							</tr>
						</table>
						</td>
						<td background="/admin/img/t_08.gif"></td>
					</tr>
					<tr>
						<td><img src="/admin/img/t_03.gif" width="6" height="6" /></td>
						<td background="/admin/img/t_06.gif"></td>
						<td align="right"><img src="/admin/img/t_04.gif" width="6" height="6" /></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/footer.php";

function populpart($period){
	$sql = "select * from populpart where period = '$period' order by sort";
	$conn = dbconn();	
	mysql_query( "SET NAMES utf8");	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

		while($row = mysql_fetch_array($result)){
			$idx = replace_out($row["populpart_idx"]);
			$sort = replace_out($row["sort"]);
			$partno = replace_out($row["partno"]);
			$price = replace_out($row["price"]);
		?>
		
		<table width="30%" border="0" cellspacing="0" cellpadding="0">
			<tr height="30" >
				<td width="60" align="center"><?=$sort?><input type="hidden" name="<?=$period?>_popul_idx[]" value="<?=$idx?>"></td>	
				<td  width="150" align="center"><input type="text" name="<?=$period?>_partno[]" value="<?=$partno?>" size="30" style="line-height:14px;" maxlength="30"></a></td>
				<td width="200" align="center"><input type="text" name="<?=$period?>_price[]" value="<?=$price?>" size="15" style="line-height:14px;" ></td>
			</tr>
			<tr>
				<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
			</tr>
		</table>
		<? 
			$ListNO++;
		} 
	}
?>
<iframe name="proc" id="proc" src="" width="300" height="300" frameborder="0" style="display:none;"></iframe>
<SCRIPT LANGUAGE="JavaScript">
<!--
function check(){
	var f= document.f;
	f.target = "proc";
	f.typ.value = "edit";
	f.action = "populpart_proc.php";
	f.encoding = "multipart/form-data";
	f.submit();			
}
//-->
</SCRIPT>