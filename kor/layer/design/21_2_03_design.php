<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function shipping(){
		var f =  document.f;
		if (nullchk(f.delivery_no,"운송장 번호를 입력해주세요.")== false) return ;			
		f.typ.value="shipping";
		 f.target = "proc";
		 f.action = "/kor/proc/odr_proc.php";
		 f.submit();		
	}
	
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

		 $(".delimgbtn").click(function () {
					var f = document.f6;
					var no_val = $(this).prev().prev().attr("name").replace("file","");
					f.no.value = no_val;
					f.typ.value="imgfiledel";
					var formData = $("#f").serialize(); 
					$.ajax({
						url: "/kor/proc/odr_proc.php", 
						data: formData,
						encType:"multipart/form-data",
						success: function (data) {	
							if (trim(data) == "SUCCESS"){									
								$("#fileimg"+no_val).attr("src", "/kor/images/file_pt.gif");
							    $("#file_o"+no_val).val("");
							}else{
								alert(data);
							}
						}
				});		
            });
	 });
//-->
</SCRIPT>

<div class="layer-hd red">
	<h1>반품 선적 </h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<?$odr = get_odr($odr_idx);
	  $sell_mem_idx = $odr[sell_mem_idx];
	  $buy_mem_idx = $odr[mem_idx];
	  $buy_com_idx = $odr[rel_idx]==0 ? $odr[mem_idx] : $odr[rel_idx];
	  $result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
	  $row_mem = mysql_fetch_array($result_mem);
	  $buy_com_nation = $row_mem["nation"];
	  $buy_com_name = $row_mem["mem_nm_en"];
	?>

		<form name="f6" id="f"  method="post" enctype="multipart/form-data">
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="c-red2">운송회사 : <img src="/kor/images/icon_tnt.gif" alt=""> &nbsp;&nbsp;&nbsp;<span lang="en">Account No. : </span> <span lang="en" class="c-blue">123456789123456789</span></td>
						<td class="file-memo">Memo: <strong></strong></td>			
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
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
						<th scope="col">Amount</th>
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
										<td>중고부품</td>
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
							<img src="/kor/images/btn_shipping_info.gif" alt="선적정보">
						</td>
					</tr>
					<tr class="bg-none">
						<td>&nbsp;</td>
						<td colspan="10">
							<table class="detail-table mr-t0" align="center">
								<tbody>
									<tr>
										<td class="c-red2">운송회사 : <img src="/kor/images/icon_tnt.gif" alt=""> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;운송장번호: <input type="text" class="i-txt2 c-blue" value="XXXXXXXXX" style="width:96px"></td>						
									</tr>
									<tr>
										<td class="c-red2">반품 선적 서류 - <span lang="en">Download</span> : <a href="#" class="btn-view-sheet-18-1-05"><img src="/kor/images/btn_none_commercial_invoice.gif" alt="Non-Commercial Invoice"></a> <a href="#" class="btn-pop-3018"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a> <a href="#" class="btn-pop-18-1-08"><img src="/kor/images/btn_return_statment.gif" alt="반품 사유서"></a></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<button type="button"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
		</div>
	</form>
</div>

