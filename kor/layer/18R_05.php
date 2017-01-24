<?
/*********************************************************************************************
*** 거절, 회신서, 답변서 : 18R_05
*********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>
<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script>
	 CKEDITOR.replace('editor1',{ 
		language : 'kor' ,
		width:'898', 										
		height:'150',
   }); 
	//이미지 업로드창 : 기본값을 '업로드 탭'으로..2016-02-19 by ccolle..
	CKEDITOR.on('dialogDefinition', function(ev) {
		var dialogName = ev.data.name;
		var dialogDefinition = ev.data.definition;
		if (dialogName == 'image'){
			dialogDefinition.onShow = function() {
				this.selectPage('Upload');
			};
		}
	});
</script>

<?
  $odr = get_odr($odr_idx);
  $sell_mem_idx = $odr[sell_mem_idx];
  $buy_mem_idx = $odr[mem_idx];
  if ($fault_method == "3") { //수량부족
	  $status = "10";
	  $status_name= "수량부족";
  }else{  //거절
	  $status = "9";
	  $status_name = "거절";
  }
  $refuse_num = QRY_CNT("odr_history", "and odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and status= $status and reg_mem_idx = $session_mem_idx");
?>

<div class="layer-hd">
	<h1><?=$sell_mem_idx==$session_mem_idx?"회신서":($refuse_num ==0?$status_name:"답변서")?>(18R_05)</h1>
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
	<input type="hidden" name="fault_quantity" value="<?=$fault_quantity;?>">
	<input type="hidden" name="fault_yn" value="Y">
	<input type="hidden" name="etc1" value="<?=ordinal($refuse_num+1)?>">
	<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
	<input type="hidden" name="no" value="">
	<input type="hidden" name="odr_history_idx" value="">
	<?=layerInvListData("18R_05", $odr_idx, $odr_det_idx)?>
		<div class="layer-data">
			<table class="stock-list-table" id="list_18R_05">
				<tr  class="bg-none">
					<td colspan="13" class="t-ct">
						<hr class="dashline2">
					</td>
				</tr>
				<tr  class="bg-none">
					<td colspan="9" class="t-lt">
						<strong class="c-black" Style="font-family:'굴림', sans-serif;">제목&nbsp;:&nbsp;&nbsp;</strong> <input type="text" name="title" class="i-txt5" value="" lang="kor" style="width:400px">
					</td>
					<td colspan="4" class="t-rt">
						<div class="re-select-box">
							<strong>선택 :</strong>
							<input type="hidden" name="fault_quantity" value="<?=$fault_quantity?>">
							<?if ($status =="9"){?>
							<label class="ipt-rd rd2"><input type="radio" name="fault_select" value="1"><span></span> 교환</label>
							<label class="ipt-rd rd2"><input type="radio" name="fault_select" value="2"><span></span> 반품</label>
							<?}else{ //status = 10 : 수량부족?>
							<input type="hidden" name="etc2" value="<?=$fault_quantity?>EA">
							<label class="ipt-rd rd2"><input type="radio" name="fault_select" value="3"><span></span> 추가선적</label>
							<label class="ipt-rd rd2"><input type="radio" name="fault_select" value="4"><span></span> 환불</label>
							<?}?>
						</div>
					</td>
				</tr>
				<tr  class="bg-none">
					<td colspan="13" class="edit-col">
						<textarea id="editor1" name="memo" rows="12" cols="140" class="ckeditor"></textarea>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="btn-area t-rt" Style="margin:15px 0 15px 0;">
			<?if ($sell_mem_idx == $session_mem_idx){?>
				<button type="button" onclick="check()"><img src="/kor/images/btn_answer_go.gif" alt="회신"></button>
			<?}else{
				if ($refuse_num == 0 ){?> 
				<button type="button" onclick="check()"><img src="/kor/images/btn_reply_request.gif" alt="회신요청"></button>	
				<?}else{?>
						<button type="button" onclick="check()"><img src="/kor/images/btn_reply4.gif" alt="답변"></button>
						<button type="button" class="btn-dialog-3021"><img src="/kor/images/btn_receipt.gif" alt="수령"></button>
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
		 $("#data_18R_05 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
		/**
		 $("input[type=file]").change(function(){	
			 if ($(this).val()){
				 var f =  document.f6; 
				 f.typ.value="imgfileup";
				 f.no.value = $(this).attr("name").replace("file","");
				 f.target = "proc";
				 f.action = "/kor/proc/odr_proc.php";
				 f.submit();						 
			 }
		 });
		 **/
	});

	function check(){
		var f =  document.f6;				
		//if (nullchk(f.title,"Memo 제목을 입력해 주세요.")== false) return ;			
		$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')");
		f.typ.value="refuse";
		f.target = "proc";
		f.action = "/kor/proc/odr_proc.php";
		f.submit();	
		alert_msg("<?=$sell_mem_idx == $session_mem_idx?"회신":($refuse_num==0?"회신요청":"답변");?> 하였습니다.");
		//location.href="/kor/";
		/**
		var formData = $("#f6").serialize(); 
		alert(formData);
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){		
						alert_msg("<?=$sell_mem_idx == $session_mem_idx?"회신":($refuse_num==0?"회신요청":"답변");?> 하였습니다.");
						location.href="/kor/";
					}else{
						alert(data);
					}
				}
		});
		**/
	}

-->
</SCRIPT>