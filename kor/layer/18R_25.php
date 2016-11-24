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
			<li><a href="#" class="buy-mn08">1</a></li>
			<li><a href="#" class="buy-mn08-18r-01">2</a></li>
			<li class="current"><a href="#" class="buy-mn08-18r-25">3</a></li>
			<li><a href="#">4</a></li>
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
				<strong class="status">발주서</strong>
				<span class="etc">PO14-PS00001A</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">송장</strong>
				<span class="etc">EI14-PS00003A</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제완료</strong>
				<span class="etc">US$0,000.00</span>
				<span class="etc"><span lang="ko">은행송금</span></span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">선적완료</strong>
				<span class="etc"><img src="/kor/images/icon_dhl.gif" alt="DHL"><br>-XXXXXXXXX</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">1st</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">1st</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">2nd</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">2nd</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">거절</strong>
				<span class="etc">3rd-<span lang="ko">교환</span></span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">반품방법</strong>
				<span class="etc"><span lang="ko">반품포기</span></span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">반품<br>선적 완료</strong>
				<span class="etc"><span lang="ko">반품포기</span></span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">선적완료</strong>
				<span class="etc"><img src="/kor/images/icon_dhl.gif" alt="DHL"><br>-XXXXXXXXX</span>
			</li>
		</ol>
	</div>
	<!-- //layer-step -->

	<!-- layer-file -->
	<div class="layer-file">
		<table>
			<tbody>
				<tr>
					<td class="c-red2" colspan="2">운송회사 : <img src="/kor/images/icon_dhl.gif" alt=""> &nbsp;&nbsp;&nbsp;운송장번호: <span lang="en" class="c-blue">XXXXXXXXX</span></td>					
				</tr>
				<tr>
					<td><div class="re-select"><strong>선택</strong><em>교환</em></div></td>
					<td class="c-red2 t-rt">선적서류- <span lang="en">Download</span> : <a href="#" class="btn-view-sheet-3017"><img src="/kor/images/btn_commercial_invoice.gif" alt="Commercial Invoice"></a> <a href="#" class="btn-pop-3018"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a></td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-file -->
	
	<form>
	<!-- layer-data -->
	<div class="layer-data">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" style="width:50px"><!--<span lang="ko">선적</span><br>-->Option</th>
					<th scope="col">No.</th>
					<th scope="col">Nation</th>
					<th scope="col">Part No.</th>
					<th scope="col">Manufacture</th>
					<th scope="col">Package</th>
					<th scope="col">D/C</th>
					<th scope="col">RoHS</th>
					<th scope="col">Unit Price</th>
					<th scope="col" lang="ko">교환수량</th>
					<th scope="col" lang="ko">납기</th>
					<th scope="col">Company</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="12" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
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
					<td class="c-red">1,000,000</td>
					<td>Stock</td>
					<td class="c-blue">Abcdefghijklmno<br>12345678.co.Ltd </td>
				</tr>
				<tr class="bg-none">
					<td></td>
					<td></td>
					<td colspan="10">
						<table class="detail-table">
							<tbody>
								<tr>
									<th scope="row" style="width:70px">부품상태  : </th>
									<td><span lang="en">NEW &amp; Original </span></td>
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
			</tbody>
		</table>
	</div>
	<!-- //layer-data -->
	
	<hr class="dashline2">
	
	<p class="c-red2 t-ct mr-tb15">
		<img src="/kor/images/btn_notice.gif" alt="공지"><br><br>
		문제가 있는/문제가 없는 제품의 체크박스를 선택하고 진행을 원하는 버튼을 선택하십시오.
	</p>
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<button type="button"><img src="/kor/images/btn_lack.gif" alt="수량부족"></button>
		<button type="button"><img src="/kor/images/btn_refuse.gif" alt="거절"></button>
		<button type="button" class="btn-dialog-3021"><img src="/kor/images/btn_receipt.gif" alt="수령"></button>
	</div>
	<!-- //layer-btn -->
	
	</form>
</div>
<!-- //layer-content -->