<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<!-- layer-tab -->
<div class="layer-tab">
	<ul>
		<li class="current"><a href="#" class="view-sell"><img src="/kor/images/layer_tab_sell_on.png" alt="판매"></a></li>
		<li><a href="#" class="view-buy"><img src="/kor/images/layer_tab_buy_off.png" alt="구매"></a></li>
	</ul>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<!-- //layer-tab -->

<!-- layer-left-menu -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/layer/sell_menu.php"); ?>
<!-- //layer-left-menu -->

<!-- layer-content -->
<div class="layer-content">
	<!-- layer-pagination -->
	<div class="layer-pagination red">
		<ul>
			<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
			<li class="current"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
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
				<span class="date"></span>
				<strong class="status"><img src="/kor/images/img_icon_record.gif" alt="기록"></strong>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">불량통보</strong>
				<span class="etc">1st</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">불량통보</strong>
				<span class="etc">1st</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">불량통보</strong>
				<span class="etc">2nd</span>
			</li>
			<li>
				<span class="date">Day, Month, 2014</span>
				<strong class="status">불량통보</strong>
				<span class="etc">2nd</span>
			</li>
			<li class="c2">
				<span class="date">Day, Month, 2014</span>
				<strong class="status">종료</strong>
				<span class="etc"><span lang="ko">확인</span></span>
			</li>
		</ol>
	</div>
	<!-- //layer-step -->
	
	<!-- layer-file -->
	<div class="layer-file">
		<table>
			<tbody>
				<tr>
					<td rowspan="2" class="company"><img src="/kor/images/nation_title_uk.png" alt="United Kingdom"> <span class="name">DigitalDream Co., Ltd</span></td>
					<td rowspan="2" class="c-red2 w100 t-ct">구매자가 종료를 요청하였습니다.</td>
					<td class="file t-rt">
						<span class="c-blue" lang="ko">파일 / 사진 : </span>
						<a href="#">File1</a>, File2
						<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
						<span class="img-wrap"><img src="/kor/images/file_pt.gif" alt=""></span>
					</td>
				</tr>
				<tr>
					<td class="file-memo">Memo: <strong>XXXXXXXXXXXXXXXXXXXX</strong></td>
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
					<th scope="col" style="width:40px">No.</th>
					<th scope="col">Part No.</th>
					<th scope="col">Manufacture</th>
					<th scope="col">Package</th>
					<th scope="col">D/C</th>
					<th scope="col">RoHS</th>
					<th scope="col">O'ty</th>
					<th scope="col">Unit Price</th>
					<th scope="col">Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="9" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title01.gif" alt="Special Price Stock"></h3>
					</td>
				</tr>
				<tr>
					<td>377</td>
					<td>123456789123456789123456789123</td>
					<td>ManuManuManuManuManu</td>
					<td>PackaPacka</td>
					<td>NEW</td>
					<td>RoHS</td>
					<td>1,000,000</td>
					<td>$10,000.00</td>
					<td>$10,000.00</td>
				</tr>
				<tr class="bg-none">
					<td></td>
					<td colspan="8">
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
			</tbody>
		</table>
	</div>
	<!-- //layer-data -->
	
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<a href="#" class="btn-pop-21-6-02"><img src="/kor/images/btn_refuse.gif" alt="거절"></a>
		<a href="#" class="btn-pop-2115"><img src="/kor/images/btn_end.gif" alt="종료"></a>
	</div>
	<!-- //layer-btn -->
</div>
<!-- //layer-content -->