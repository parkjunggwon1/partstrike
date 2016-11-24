<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_off.png" alt="판매"></a><a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a></li>
		<li class="current"><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_on.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close.png" alt="close"></a>
</div>
<!-- //layer-tab -->

<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/buy_menu.php"); ?>
<!-- //layer-left-menu -->

<!-- layer-content -->
<div class="layer-content">
	<!-- layer-pagination -->
	<div class="layer-pagination">
		<ul>
			<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
			<li class="current"><a href="#" class="buy-mn02">1</a></li>
			<li><a href="#" class="buy-mn02-0513">2</a></li>
			<li><a href="#" class="buy-mn02-1206">3</a></li>
			<li><a href="#" class="buy-mn02-1101">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">6</a></li>
			<li><a href="#">7</a></li>
			<li><a href="#">8</a></li>
			<li><a href="#">9</a></li>
			<li><a href="#">10</a></li>
			<li><a href="#">11</a></li>
			<li><a href="#">12</a></li>
			<li><a href="#">13</a></li>
			<li><a href="#">14</a></li>
			<li><a href="#">15</a></li>
			<li><a href="#">16</a></li>
			<li><a href="#">17</a></li>
			<li><a href="#">18</a></li>
			<li><a href="#">19</a></li>
			<li><a href="#">20</a></li>
			<li class="navi-next"><a href="#"><img src="/kor/images/nav_btn_up.png" alt="next"></a></li>
		</ul>
	</div>
	<!-- //layer-pagination -->
	
	<!-- layer-step -->
	<div class="layer-step">
		<ol>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">납기</strong>
				<span class="etc">확인</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">납기확인</strong>
				<span class="etc">10WK</span>
			</li>
		</ol>
	</div>
	<!-- //layer-step -->
	
	<form>
	<!-- layer-data -->
	<div class="layer-data">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" style="width:50px"><span lang="ko">선적</span><br>Option</th>
					<th scope="col">No.</th>
					<th scope="col">Nation</th>
					<th scope="col">Part No.</th>
					<th scope="col">Manufacture</th>
					<th scope="col">Package</th>
					<th scope="col">D/C</th>
					<th scope="col">RoHS</th>
					<th scope="col">Unit Price</th>
					<th scope="col" lang="ko">발주수량</th>
					<th scope="col" lang="ko">공급수량</th>
					<th scope="col" lang="ko">납기</th>
					</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="12" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title02.gif" alt="지속적 공급 가능한 Special Price Part"></h3>
					</td>
				</tr>
				<tr>
					<td><label class="ipt-chk chk2"><input type="checkbox"><span></span></label></td>
					<td>377</td>
					<td><img src="/kor/images/nation_title2_uk.png" alt="United Kingdom"></td>
					<td>12345678912345678912<br>12345678912345678912</td>
					<td>ManuManuManuMan<br>ManuManuManuMan</td>
					<td>PackaPacka</td>
					<td>NEW</td>
					<td>RoHS</td>
					<td>$10,000.00</td>
					<td class="c-blue"><input type="text" class="i-txt2 c-blue t-ct" value="1,000,000" style="width:62px"></td>
					<td class="c-red">1,000,000</td>
					<td class="c-red">10WK</td>
				</tr>
				<tr class="bg-none">
					<td></td>
					<td></td>
					<td colspan="10">
						<table class="detail-table">
							<tbody>
								<tr>
									<th scope="row">선적정보:</th>
									<td>
										<span class="c-grey2">운송회사</span>
										<div class="select type4" lang="en" style="width:70px">
											<label class="c-blue">DHL</label>
											<select>
												<option>DHL</option>
												<option>DHL</option>
											</select>
										</div>
									</td>
									<th scope="row"><span lang="en">Account No.</span></th>
									<td><input type="text" class="i-txt2 c-blue" value="123456789" style="width:92px"></td>
								</tr>
								<tr>
									<td colspan="4" lang="en"><strong class="c-red">Memo</strong> <input type="text" class="i-txt2 c-blue" value="XXXXXXXXXXXXXXXXXXXX" style="width:323px"></td>
								</tr>
								<tr>
									<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox"><span></span> 운송보험</label></td>
								</tr>
								<tr>
									<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox"><span></span> 배송지 변경</label></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-data -->
	
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<button type="button" class="btn-dialog-0501"><img src="/kor/images/btn_order_add.gif" alt="발주 추가"></button>
		<button type="button" class="btn-order-confirm"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></button>
		<button type="button"><img src="/kor/images/btn_order_save.gif" alt="저장"></button>
	</div>
	<!-- //layer-btn -->
	
	</form>
</div>
<!-- //layer-content -->