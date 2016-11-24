<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>

<?
	  $odr_idx =get_any("odr_det","odr_idx", "odr_det_idx=$odr_det_idx");
	  $odr = get_odr($odr_idx);
	  $sell_mem_idx = $odr[sell_mem_idx];
	  $buy_mem_idx = $odr[mem_idx];
	  $status = "12";
	  $status_name= "불량 통보";
      $refuse_num = QRY_CNT("fty_history", "and odr_det_idx = $odr_det_idx and status= $status and reg_mem_idx = $session_mem_idx and confirm_yn <> 'F'");
 
?>


<div class="layer-hd red">
	<h1><?=$sell_mem_idx==$session_mem_idx?"회신서":($refuse_num ==0?$status_name:"답변서")?></h1>
	<span class="caution">제한 <?=5-$refuse_num?>회</span>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="f6" id="f6" method="post" enctype="multipart/form-data">		
	<input type="hidden" name="typ" value="imgfileup">
	<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
	<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
	<input type="hidden" name="status" value="<?=$status?>">
	<input type="hidden" name="status_name" value="<?=$status_name?>">
	<input type="hidden" name="fault_yn" value="Y">
	<input type="hidden" name="etc1" value="<?=ordinal($refuse_num+1)?>">
	<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
	<input type="hidden" name="no" value="">
	<input type="hidden" name="fty_history_idx" value="">
	<?=layerListData("21_04", $odr_idx, $odr_det_idx , "fty")?>
		<div class="layer-data">
			<table class="stock-list-table">
				<tbody>
					<tr>
						<td colspan="11" class="t-ct">
							<hr class="dashline2">
							<?if ($sell_mem_idx == $session_mem_idx){?><img src="/kor/images/btn_reply2.gif" alt="회신"><?}else{?>
							<img src="/kor/images/btn_reply3.gif" alt="답변"><?}?>
						</td>
					</tr>
					<tr class="bg-none">
						<td>&nbsp;</td>
						<td colspan="10">
							<table class="detail-table mr-t0">
								<tbody>
									<tr>
										<td><label class="i-file c-red2">
										파일 / 사진1 : <input name="file1" onchange="javascript: document.getElementById('file_o1').value = this.value" name="" type="file">
													   <input id="file_o1" name="file_o1" type="text" class="i-txt2" readonly><span></span></label><label class="i-file c-red2"><br><br>
										파일 / 사진2 : <input  name="file2" onchange="javascript: document.getElementById('file_o2').value = this.value" type="file">
													   <input id="file_o2" name="file_o2" type="text" class="i-txt2" readonly><span></span></label></td>
										<td>
											<strong class="c-blue" lang="en">File1, File2</strong>
											<span class="img-wrap"><img src="/kor/images/file_pt.gif" id="fileimg1" alt="" width="72" height="58"></span>
											<span class="img-wrap"><img src="/kor/images/file_pt.gif" id="fileimg2" alt="" width="72" height="58"></span>
										</td>
									</tr>
									<tr>
										<td colspan="2" lang="en"><strong class="c-black">Memo: </strong> <input type="text" name="memo" class="i-txt5" value="" style="width:200px"></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<?if ($sell_mem_idx == $session_mem_idx){?>
				<button type="button" class="btn-view-sheet-21-4-01"><img src="/kor/images/btn_lab_request.gif" alt="연구소 의뢰"></button>
				<button type="button" class="btn-view-sheet-21-1-01"><img src="/kor/images/btn_agree.gif" alt="동의"></button>
				<button type="button" onclick="check()"><img src="/kor/images/btn_answer_go.gif" alt="회신"></button>
			<?}else{
				if ($refuse_num == 0 ){?> 
				<button type="button" onclick="check()"><img src="/kor/images/btn_reply_request.gif" alt="회신요청"></button>	
				<?}else{
						// 최근 status가 불량통보(12)라면 구매자 책임. 최근 status가 동의서(13)라면 판매자 책임. 21-3-01(구매자 책임에 동의) 21-1-01(판매자 책임에 동의)
						$recent_status = get_any("fty_history","status", "fty_history_idx =(SELECT max(fty_history_idx) FROM `fty_history` where odr_det_idx = $odr_det_idx)");
						// 1번 거절한 경험이 있으면 연구소 의뢰 / 답변 / 종료 모두 disabled.
						$refuse_exp = QRY_CNT("fty_history","and status=26 and reason_ty = 6 and reg_mem_idx = '".$_SESSION["MEM_IDX"]."'")==0? "N":"Y";						
					  ?><?if ($refuse_exp=="Y"){?>
							<img src="/kor/images/btn_lab_request_1.gif" alt="연구소 의뢰">
					  <?}else{?>
						<button type="button"><img src="/kor/images/btn_lab_request.gif" alt="연구소 의뢰"></button>
					  <?}?>
						<?if ($refuse_num<5){
							if ($recent_status=="12"){  //최근 status가 불량통보
								$agree_sheet= "21-3-01";
							}elseif ($recent_status =="26" || ($refuse_exp=="Y" && $_SESSION["MEM_IDX"]==$buy_mem_idx)){  // 최근 status가 거절F (판매자가 거절 한 것이므로 구매자 책임에 동의) 이거나 구매자가 연구소의뢰 2번 거부시 구매자 책임에 동의
								$agree_sheet= "21-3-01";
								$refuse_yn = "Y";
							}elseif ($recent_status == "13" && $refuse_exp!="Y"){ //최근 status 가 동의서
								$agree_sheet= "21-1-01";
							}
						?>
							<button type="button" class="btn-view-sheet-<?=$agree_sheet?>"><img src="/kor/images/btn_agree.gif" alt="동의"></button>						
							<?if ($refuse_yn =="Y" || $refuse_exp =="Y"){?>
								<img src="/kor/images/btn_reply4_1.gif" alt="답변">
								<img src="/kor/images/btn_end_1.gif" alt="종료">
							<?}else{?>
								<button type="button" onclick="check()"><img src="/kor/images/btn_reply4.gif" alt="답변"></button>
								<button type="button" class="btn-pop-2113" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_end.gif" alt="종료"></button>
							<?}?>
						<?}?>
				<?}?>
			<?}?>
		</div>
	</form>
</div>




<SCRIPT LANGUAGE="JavaScript">
<!--

 $(document).ready(function(){
		 $(".editimgbtn").click(function () {
                $(this).prev().click();
            });
		 $("input[type=file]").change(function(){	
			 if ($(this).val()){
				 var f =  document.f6; 
				 f.typ.value="imgfileup";
				 f.no.value = $(this).attr("name").replace("file","");
				 f.target = "proc";
				 f.action = "/kor/proc/record_proc.php";
				 f.submit();						 
			 }
		 });
	});

	function check(){
		var f =  document.f6;
		if (nullchk(f.memo,"Memo 내용을 입력해 주세요.")== false) return ;			
		f.typ.value="notify";
		var formData = $("#f6").serialize(); 
		$.ajax({
				url: "/kor/proc/record_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){		
						alert_msg("<?=$sell_mem_idx == $session_mem_idx?"회신":($refuse_num==0?"회신요청":"답변");?> 하였습니다.");
						<?if ($refuse_num ==0) {?>
							location.href="/kor/";
//							closeCommLayer("layer3");
//							$(".myrecord").click();
						<?}else{?>
							location.href="/kor/";
						<?}?>
					}else{
						alert_msg(data);
					}
				}
		});		
	}

-->
</SCRIPT>