<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>

<?$odr = get_odr($odr_idx);
  $sell_mem_idx = $odr[sell_mem_idx];
  $buy_mem_idx = $odr[mem_idx];
  if ($fault_method == "3") { //수량부족
	  $status = "10";
	  $status_name= "수량부족";
  }else{  //거절
	  $status = "9";
	  $status_name = "거절";
  }
  $refuse_num = QRY_CNT("odr_history", "and odr_idx = $odr_idx and status= $status and reg_mem_idx = $session_mem_idx");
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
	<input type="hidden" name="status" value="<?=$status?>">
	<input type="hidden" name="status_name" value="<?=$status_name?>">
	<input type="hidden" name="fault_yn" value="Y">
	<input type="hidden" name="etc1" value="<?=ordinal($refuse_num+1)?>">
	<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
	<input type="hidden" name="no" value="">
	<input type="hidden" name="odr_history_idx" value="">
	<?=layerInvListData("18R_06", $odr_idx)?>
		<div class="layer-data">
			<table class="stock-list-table">
				<thead>
					<tr>
						<th scope="col">No.</th>
						<th scope="col">Nation</th>
						<th scope="col">Part No.</th>
						<th scope="col">Manufacture</th>
						<th scope="col">Package</th>
						<th scope="col">D/C</th>
						<th scope="col">RoHS</th>
						<th scope="col">O'ty</th>
						<th scope="col">Unit Price</th>
						<th scope="col" lang="ko">Amount</th>
						<th scope="col">Company</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="11" class="title-box first">
							<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
						</td>
					</tr>
					<tr>
						<td>377</td>
						<td><img src="/kor/images/nation_title2_uk.png" alt="United Kingdom"></td>
						<td>12345678912345678912<br>12345678912345678912</td>
						<td>ManuManuManuMan<br>ManuManuManuMan</td>
						<td>PackaPacka</td>
						<td>NEW</td>
						<td>RoHS</td>
						<td>1,000,000</td>
						<td>$10,000.00</td>
						<td>$10,000.00</td>
						<td class="c-blue">Abcdefghijklmno<br>12345678.co.Ltd </td>
					</tr>
					<tr class="bg-none">
						<td>&nbsp;</td>
						<td colspan="10">
							<table class="detail-table">
								<tbody>
									<tr>
										<th scope="row" style="width:70px">부품상태  : </th>
										<td><span lang="en">NEW &amp; Original</span></td>
										<th scope="row" style="width:70px">포장상태 : </th>
										<td><span lang="en">Original / Tube</span></td>
									</tr>
									<tr>
										<td colspan="4" lang="en"><strong class="c-red">Memo: </strong>XXXXXXXXXXXXXXXXXXXX</td>
									</tr>
									<tr>
										<td colspan="4">
											<strong class="c-red">라벨/부품사진:</strong>
											<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
											<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
											<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="11" class="t-ct">
							<hr class="dashline2">
							<img src="/kor/images/btn_reply3.gif" alt="답변">
						</td>
					</tr>
					<tr class="bg-none">
						<td>&nbsp;</td>
						<td colspan="10">
							<table class="detail-table mr-t0">
								<tbody>
									<tr>
										<td style="width:420px"><label class="i-file c-red2">파일 / 사진 : <input onchange="javascript: document.getElementById('fileName').value = this.value" type="file"><input id="fileName" type="text" class="i-txt2" readonly><span></span></label></td>
										<td>
											<strong class="c-blue" lang="en">File1, File2</strong>
											<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
											<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
										</td>
									</tr>
									<tr>
										<td colspan="2" lang="en"><strong class="c-red">Memo: </strong> <input type="text" class="i-txt2 c-blue" value="XXXXXXXXXXXXXXXXXXXX" style="width:200px"></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<button type="button"><img src="/kor/images/btn_reply_request.gif" alt="회신요청"></button>
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
				 f.action = "/kor/proc/odr_proc.php";
				 f.submit();						 
			 }
		 });
	});

	function check(){
		var f =  document.f6;
		if (nullchk(f.memo,"Memo 내용을 입력해 주세요.")== false) return ;			
		f.typ.value="refuse";
		var formData = $("#f6").serialize(); 
		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){		
						alert("<?=$sell_mem_idx == $session_mem_idx?"회신":($refuse_num==0?"회신요청":"답변");?> 하였습니다.");
						location.href="/kor/";
					}else{
						alert(data);
					}
				}
		});		
	}

-->
</SCRIPT>