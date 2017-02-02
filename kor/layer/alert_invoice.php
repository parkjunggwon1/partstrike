<?
/*********************************************************************************************
** [사용자정의 메세지창] 타이틀, 메세지, 버튼이미지명 pram 받고, 닫기(X) 클릭 시 단순 닫기
** 호출하는 화면 : 31_05(판매자 납기 답변)
** menu.js : layer6, alert3(title,msg,btn,btncss,close_yn)
** 2016-04-07 : 닫기 버튼에 class 추가하여, 이번트처리 각각 다르게
**********************************************************************************************/

@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.odr.php";
//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')"); 버튼 클릭시 한번 이상 안눌리게.
if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}

$sql = "select * from odr left join odr_history on odr_history.odr_idx = odr.odr_idx and `status` = 21 where odr.odr_idx = '".$odr_idx."'";
$conn = dbconn();	
$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());	
while($row = mysql_fetch_array($result)){
	$odr_no = $row["odr_no"];
	$invoice_no = $row["invoice_no"];
	$etc1 = $row["etc1"];
	$etc2 = $row["etc2"];
	$status_name = $row["status_name"];
}

$result_odr = QRY_ODR_VIEW($odr_idx);    
$row_odr = mysql_fetch_array($result_odr);
$result_odr_det =QRY_ODR_DET_LIST(0,"and odr_idx = ".$odr_idx,0); 
$row_odr_det = mysql_fetch_array($result_odr_det);
$pay_cnt =QRY_CNT("odr_history", "and odr_idx = $odr_idx and status = 5"); 

$sell_nation_idx = get_any("member", "nation", "mem_idx ='".$row_odr['sell_mem_idx']."'");
$buy_nation_idx = get_any("member", "nation", "mem_idx = '".$row_odr['mem_idx']."'");

if($row_odr_det["part_type"] == 2 &&  $row_odr_det["period"] *1 > 2 && $pay_cnt<2) {
	$down_yn ="Y";
}

$I_chr =  "CI";
$p_chr =  "PL";

if ($down_yn =="Y"){ //----- 계약금
	$invoice_no = get_auto_no($I_chr, "mybank" , "invoice_no");
	$odr_val = get_auto_no($p_chr, "mybank" , "invoice_no");
	
}else{	//---- 계약금 아닌경우

	if($row_odr_det["part_type"] == 2){
		$invoice_val = get_auto_no("EI", "odr" , "invoice_no");
		$odr_val = get_auto_no("EI", "odr" , "invoice_no");
	}else{
		$invoice_val = $row_odr["invoice_no"]==""?str_replace("EI", $I_chr, get_auto_no("EI", "odr" , "invoice_no")):str_replace("EI", $I_chr,$row_odr["invoice_no"]);
		$odr_val = $row_odr["invoice_no"]==""?str_replace("EI", $p_chr, get_auto_no("EI", "odr" , "invoice_no")):str_replace("EI", $p_chr,$row_odr["invoice_no"]);
	}
}
$ship_idx = get_any("ship","delivery_addr_idx","odr_idx=$odr_idx");

if($ship_idx == 0 || $ship_idx == "")
{
	$ship_nation = get_any("member","nation","mem_idx='".$row_odr['mem_idx']."'");
}
else
{
	$ship_nation = get_any("delivery_addr","nation","delivery_addr_idx=$ship_idx");
}	

?>	

<div class="layer-content" style="padding:0;width:100%;padding-left: 90px;padding-top: 30px;">	
	<a href="#" class="btn-close" style="position: absolute;right: 10px;top: 1px;padding: 5px;text-decoration:underline;"><img src="/kor/images/btn_layer_close.png" alt="close"></a>
	<?if ($sell_nation_idx != $ship_nation){?>
	<span>Commercial Invoice : <a href="#" class="btn-view-sheet-3011" for_readonly="Y" style="color:#00759e;text-decoration:underline;"><?=$invoice_val?></a></span><br>
	<span>Packing List : <a href="#" class="btn-view-sheet-3011" for_readonly="P" style="color:#00759e;text-decoration:underline;"><?=$odr_val?></a></span><br>
	<?}?>
	<?
	if ($etc2=="DHL" || $etc2=="UPS" || $etc2=="Fedex" || $etc2=="TNT")
	{	
	?>	
		<span><img src="/kor/images/icon_<?=strtolower($etc2)?>.gif" height="15">-<a href="#" style="color:#00759e;cursor: default;"><?=$etc1?></a></span><br>		
		<?
		$result =QRY_ODR_DET_LIST(0,"and odr_idx=".$odr_idx."",0,"","asc");
		while($row = mysql_fetch_array($result))
		{

		?>
		<div>Part No. - 
		<?					
				for ($i = 1;$i <= 3; $i++ ){
					$file = replace_out($row["file$i"]);		

				if ($file){
		?>
				<span><img <?=get_noimg_photo($file_path, $file, "/kor/images/file_pt.gif")?> height="15"></span>
				
				
		<?
				}
			}
		?>
		</div> 
		<?
		}
		?>	
	<?}else{?>
		<span><?=$etc2?>-<a href="#" style="color:#00759e;cursor: default;"><?=$etc1?></a></span>
	<?}?>
	
	<!--<span><?=$etc2?>-<a href="#" style="color:#00759e;text-decoration:underline;"><?=$etc1?></a></span>-->
	</div>
	<div class="btn-area t-rt"> <!-- periodreq-->
	
	</div>
</div>