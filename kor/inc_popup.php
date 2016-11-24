<? include ("../sql/sql.other.php"); ?>
<SCRIPT LANGUAGE="JavaScript">
	
 function notice_getCookie( name ) {
     var nameOfCookie = name + "=";
     var x = 0;
     while ( x <= document.cookie.length ) {
         var y = (x+nameOfCookie.length);
         if ( document.cookie.substring( x, y ) == nameOfCookie ) {
             if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
                 endOfCookie = document.cookie.length;
             return unescape( document.cookie.substring( y, endOfCookie ) );
         }
         x = document.cookie.indexOf( " ", x ) + 1;
         if ( x == 0 )  break;
     }
     return "";
 }
 
</script>
<?
$searchand = " and  use_yn='y' ";
$cnt = QRY_CNT("popup",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$result =QRY_POPUP_LIST($recordcnt,$searchand,$page);
while($row = mysql_fetch_array($result)){
	$idx = replace_out($row["idx"]);
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
	$start_date = replace_out($row["start_date"]);
	$end_date = replace_out($row["end_date"]);
	$start_time = replace_out($row["start_time"]);
	$end_time = replace_out($row["end_time"]);
	$nowdate = date("Y-m-d-H");	
if($start_date."-".$start_time<=$nowdate and $end_date."-".$end_time>=$nowdate){

		If ($lay_yn=="n") {
?>
<script type="text/javascript">
		<!--
			 if ( notice_getCookie("popupview<?=$idx?>") != "done" ) {
				window.open("popup.php?idx=<?=$idx?>","_new<?=$idx?>","left=<?=$p_left?>,top=<?=$p_top?>,scrollbars=<?=$scr_yn?>,resizable=no,copyhistory=no,width=<?=$p_wid+10?>,height=<?=$p_hei+50?>");
			}
		//-->
		</script>
<?
		}	Else{	
?>
		
		<!---------------------현재팝업보기 div----------------------------------->
		<div name="popdiv<?=$idx?>" id="popdiv<?=$idx?>" style="display:;position:absolute; z-index:9999; filter:alpha(opacity=100);top:<?=$p_top?>px;left:<?=$p_left?>px;width:<?=$p_wid?>px;height:<?=$p_hei?>px;">
		<iframe name="popifr<?=$idx?>" id="popifr<?=$idx?>" src=""style="display:;position:absolute;z-index:1;width:<?=$p_wid?>px;height:<?=$p_hei?>px;" frameborder="0" scrolling="<?=$scr_yn?>"></iframe>
		</div>
		<!---------------------현재팝업보기 div end------------------------------->
		<script type="text/javascript">
		<!-- 
			 if ( notice_getCookie("popupview<?=$idx?>") != "done" ) {
				document.getElementById("popifr<?=$idx?>").src="popup.php?idx=<?=$idx?>";
				document.getElementById("popdiv<?=$idx?>").style.display="";
			}else{
				document.getElementById("popdiv<?=$idx?>").style.display="none";
			}
			
		//-->
		</script>
<?
			}	
		}
}
?>
