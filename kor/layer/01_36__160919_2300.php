<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/include/function.js"></script>
<script>ready();</script>
<div class="layer-hd">
	<h1>도착</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<?
$buy_rel_idx = get_any("odr", "rel_idx", "odr_idx = $odr_idx");
$buy_com_idx = $buy_rel_idx == 0 ? get_any("odr", "mem_idx", "odr_idx = $odr_idx") : $buy_rel_idx;
$result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
$row_mem = mysql_fetch_array($result_mem);
$buy_com_nation = $row_mem["nation"];
$buy_com_name = $row_mem["mem_nm_en"];					
?>
<div class="layer-content">
	<form name="f" id="f">
	<input type="hidden" name="typ" id="typ" value="arrival">
	<input id="odr_idx_30_10" name="odr_idx" value="<?=$odr_idx?>" type="hidden">
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company">
							<img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>">
							<span class="name"><?=$buy_com_name?></span>
						</td>
						<td class="t-rt c-red2">추가 공급 가능 수량: <input type="text" class="i-txt2 c-blue t-rt onlynum numfmt" onfocus="if(this.value=='0'){this.value=''}" onblur="if(this.value==''){this.value='0'}" name="addcapa" id="addcapa" value="0" style="width:90px"> <span lang="en">EA</span></td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
		<div class="layer-data">
			<table class="stock-list-table" id="list_01_36">
			</table>
			<table class="stock-list-table">
			<tr  class="bg-none">
						<td></td>
						<td colspan="10">
							<table class="detail-table mr-t0">
								<tbody>
									
									<tr>
										<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox"><span></span> 부가세 : <input type="text" class="i-txt5 t-rt onlynum numfmt" value="" style="width:30px"> %</label></td>
									</tr>
									<tr>
										<td colspan="4">
										<?$assign = get_any("assign", "o_company_idx", "rel_idx = (SELECT case when sell_rel_idx = 0 then sell_mem_idx else sell_rel_idx end as com_idx FROM `odr` WHERE odr_idx =$odr_idx) and assign_type = 1");
										if ($assign) { ?>
											<label class="ipt-chk chk2 c-red"><input type="checkbox" class="btn-pop-1504 checked" loadPage="01_36" checked odr_idx="<?=$odr_idx?>" name="appint" value="Y"><span></span> 판매자 지정 운송회사 <span id="appoint"> : <img src='/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$assign))?>.gif' height='15'></span></label>
										<?}else{?>
										<label class="ipt-chk chk2"><input type="checkbox" class="btn-pop-1504" loadPage="01_36" odr_idx="<?=$odr_idx?>" name="appint" value="Y"><span></span> 판매자 지정 운송회사 <span id="appoint"></span></label>
										<?}?>

									</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<button type="button" class="arrival"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
		</div>
	</form>
</div>

<SCRIPT LANGUAGE="JavaScript">
<!--
$("#list_01_36").html($("#list_30_15").html());
$("#list_01_36 .noinput").remove();
$("#list_01_36 .yesinput").css("display","");
$("#list_01_36 input[name=memo]").val("");

-->
</SCRIPT>