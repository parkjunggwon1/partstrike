<?
/*********************************************************************************************
*** 거절, 회신서, 답변서 : 18R_05
*********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

$fault_sel = get_any("odr_history", "fault_select", "odr_det_idx = $odr_det_idx"); 

if ($fault_sel=="1")
{
	$fault_chk = "2";
}
else if ($fault_sel=="2")
{
	$fault_chk = "1";
}
else if ($fault_sel=="3")
{
	$fault_chk = "4";
}
else if ($fault_sel=="4")
{
	$fault_chk = "3";
}
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

	$("body").on("click","#fault_select<?=$fault_chk?>",function(){
		$("#fault_select<?=$fault_chk?>").attr("class","checked");

		if($("#fault_select<?=$fault_chk?>").prop("checked") == true){
			$("#fault_select<?=$fault_chk?>").addClass('checked');
		}
		else if($("#fault_select<?=$fault_chk?>").prop("checked") == false){
			$("#fault_select<?=$fault_chk?>").removeClass('checked');
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

  $det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
  if (!$fault_quantity || $fault_quantity=="undefined")
  {
  	$fault_quantity = get_any("odr_det", "fault_quantity", "odr_det_idx = $odr_det_idx");  //odr_det 부족수량
  }
  
?>

<div class="layer-hd">
	<h1><?=$sell_mem_idx==$session_mem_idx?"회신서":($refuse_num ==0?$status_name:"답변서")?>(18R_05)</h1>
	<span class="caution">제한 <?=5-$refuse_num?>회</span>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="f6" id="f6" method="post" enctype="multipart/form-data">		
	<input type="hidden" name="typ" value="imgfileup">
	<input type="hidden" id="odr_idx" name="odr_idx" value="<?=$odr_idx?>">
	<input type="hidden" id="odr_det_idx" name="odr_det_idx" value="<?=$odr_det_idx?>">
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
						<strong class="c-black" Style="font-family:'굴림', sans-serif;">제목&nbsp;:&nbsp;&nbsp;</strong> <input type="text" id="title" name="title" class="i-txt5" value="" lang="kor" style="width:400px">
					</td>
					<td colspan="4" class="t-rt">
						<div class="re-select-box">
							<strong>선택 :</strong>
							<input type="hidden" name="fault_quantity" value="<?=$fault_quantity?>">
							<?if ($status =="9"){?>
							<label class="ipt-rd rd2 fault_sel" ><input type="radio" id="fault_select1" idx='1' name="fault_select" value="1"><span></span> 교환</label>
							<label class="ipt-rd rd2 fault_sel" ><input type="radio" id="fault_select2" idx='2' name="fault_select" value="2"><span></span> 반품</label>
							<?}else{ //status = 10 : 수량부족?>
							<input type="hidden" name="etc2" value="<?=$fault_quantity?>EA">
							<label class="ipt-rd rd2 fault_sel" ><input type="radio" id="fault_select3" idx='3' name="fault_select" value="3" <?if ($fault_sel=="4"){ echo "disabled='disabled'";}?> ><span></span> 추가선적</label>
							<label class="ipt-rd rd2 fault_sel" ><input type="radio" id="fault_select4" idx='4' name="fault_select" value="4" <?if ($fault_sel=="3"){ echo "disabled='disabled'";}?> ><span></span> 환불</label>
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
				<button class="btn_answer" type="button" style="cursor: default;"><img src="/kor/images/btn_answer_go_1.gif" alt="회신"></button>
			<?}else{
				if ($refuse_num == 0 ){?> 
				<button type="button" onclick="check()"><img src="/kor/images/btn_reply_request.gif" alt="회신요청"></button>	
				<?}else{?>
						<button class="btn_answer2" type="button" style="cursor: default;"><img src="/kor/images/btn_reply4_1.gif" alt="답변"></button>
						<button type="button" class="btn-dialog-3021"><img src="/kor/images/btn_receipt.gif" alt="수령"></button>
				<?}?>
			<?}?>
		</div>
		<input type="hidden" id="det_cnt_18R05" name="det_cnt_18R05" value="<?=$det_cnt?>" />
	</form>
</div>


<SCRIPT LANGUAGE="JavaScript">
<!--

 $(document).ready(function(){
 		$("#title").keyup(function (e){  		
			
			if ($("#title").val())
			{				
				$(".btn_answer").css("cursor","pointer");
				$(".btn_answer").attr("onclick","check();")
				$(".btn_answer").children("img").attr("src","/kor/images/btn_answer_go.gif");

				$(".btn_answer2").css("cursor","pointer");
				$(".btn_answer2").attr("onclick","check();")
				$(".btn_answer2").children("img").attr("src","/kor/images/btn_reply4.gif");
			}
			else
			{
				$(".btn_answer").css("cursor","default");
				$(".btn_answer").attr("onclick","");
				$(".btn_answer").children("img").attr("src","/kor/images/btn_answer_go_1.gif");

				$(".btn_answer2").css("cursor","default");
				$(".btn_answer2").attr("onclick","");
				$(".btn_answer2").children("img").attr("src","/kor/images/btn_reply4_1.gif");
			}
			
		});

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
		var det_cnt = $("#det_cnt_18R05").val();
		var det_idx = $("#odr_det_idx").val();
		
		if(det_cnt > 1){ //1개 이상부터...
			//복제하고, 전체처럼 proc
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php?det_idx="+det_idx, 
				data: { actty : "ODRCP", //주문 복제
						odr_idx : $("#odr_idx").val()
						},
				dataType : "html" ,
				async : false ,
				success: function(data){
					$("#odr_idx").val(trim(data));					
				}
			});
		}

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