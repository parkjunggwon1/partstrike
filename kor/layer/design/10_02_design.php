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
			<li class="current"><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
			<li><a href="#">311</a></li>
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
				<strong class="status">납기 확인</strong>
				<span class="etc">10WK</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">발주서</strong>
				<span class="etc">PO14-PS00001A</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">송장</strong>
				<span class="etc">PO14-PS00001A</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제 완료</strong>
				<span class="etc">US$0,000.00</span>
				<span class="etc">My Bank</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">결제 완료</strong>
				<span class="etc">US$0,000.00</span>
				<span class="etc"><span lang="ko">신용카드</span></span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">지연</strong>
				<span class="etc">1WK</span>
			</li>
			<li class="c1">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">지연</strong>
				<span class="etc">1WK</span>
			</li>
		</ol>
	</div>
	<!-- //layer-step -->
	
	<!-- layer-file -->
	<div class="layer-file">
		<table>
			<tbody>
				<tr>
					<td class="c-red2 t-ct">판매자가 2주 더 연장 요청하였습니다. </td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- //layer-file -->
	
	<!-- layer-data -->
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
					<th scope="col">Unit Price</th>
					<th scope="col" lang="ko">발주수량</th>
					<th scope="col" lang="ko">공급수량</th>
					<th scope="col" lang="ko">납기</th>
					<th scope="col">Company</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="12" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title02.gif" alt="지속적 공급 가능한 Special Price Part"></h3>
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
					<td>$10,000.00</td>
					<td class="c-blue">1,000,000</td>
					<td class="c-red">1,000,000</td>
					<td class="c-red">11WK</td>
					<td class="c-blue">Abcdefghijklmno<br>12345678.co.Ltd </td>
				</tr>
				<tr class="bg-none">
					<td></td>
					<td colspan="11">
						<table class="detail-table">
							<tbody>
								<tr>
									<th scope="row" lang="en">Memo: </th>
									<td lang="en">XXXXXXXXXXXXXXXXXXXX</td>
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
		<a href="#" class="btn-pop-1003"><img src="/kor/images/btn_accept.gif" alt="수락"></a>
		<a href="#" class="btn-pop-1301"><img src="/kor/images/btn_order_cancel.gif" alt="발주 취소"></a>
	</div>
	<!-- //layer-btn -->
</div>
<!-- //layer-content -->