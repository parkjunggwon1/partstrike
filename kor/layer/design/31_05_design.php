<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>

<div class="layer-hd">
	<h1>납기 확인</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
					
						<td class="company"><img src="/kor/images/nation_title2_<?=$buy_com_nation?>1.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
						<td class="w100 t-ct c-red">결제 완료 시점부터 선적 완료까지</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
		
		<!-- 위탁판매 -->
		<?if ($part_type == "2"){?>
		<div class="layer-pagination red">
					<ul>
						<li class="navi-prev"><a href="#"><img src="/kor/images/nav_btn_down.png" alt="prev"></a></li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">6</a></li>
						<li><a href="#">7</a></li>
						<li><a href="#">8</a></li>
						<li><a href="#">9</a></li>
						<li class="current"><a href="#">10</a></li>
						<li><a href="#">11</a></li>
						<li><a href="#">12</a></li>
						<li><a href="#">13</a></li>
						<li><a href="#">14</a></li>
						<li><a href="#">15</a></li>
						<li><a href="#">16</a></li>
						<li><a href="#">17</a></li>
						<li><a href="#">18</a></li>
						<li><a href="#">19</a></li>
						<li class="navi-next"><a href="#"><img src="/kor/images/nav_btn_up.png" alt="next"></a></li>
					</ul>
					<span class="c-red2" lang="en">WK</span>
		</div>
		<?}else{?>
		<!-- layer-pagination -->
		<div class="layer-pagination red">
			<ul>
				<li class="current"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">6</a></li>
				<li><a href="#">7</a></li>
			</ul>
			<span class="c-red2" lang="en">Days</span>
		</div>
		<!-- //layer-pagination -->		
		<?}?>
		<div class="layer-data">
			<table class="stock-list-table">
				<thead>
					<tr>
						<th scope="col">No. </th>
						<th scope="col">Part No.</th>
						<th scope="col">Manufacture</th>
						<th scope="col">Package</th>
						<th scope="col">D/C</th>
						<th scope="col">RoHS</th>
						<th scope="col">O'ty</th>
						<th scope="col">Unit Price</th>
						<th scope="col" lang="ko">발주수량</th>
						<th scope="col" lang="ko">공급수량</th>
						<th scope="col" lang="ko">납기</th>
					</tr>
				</thead>
				<?echo GET_ODR_DET_LIST("31_05",$part_type," and odr_det_idx=$odr_det_idx ");?>
				<tbody>
					<tr>
						<td colspan="11" class="title-box first">
							<h3 class="title"><img src="/kor/images/stock_title05.gif" alt="Special Price Stock"></h3>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td><input type="text" class="i-txt4" value="123456789123456789123456789123" style="width:184px"></td>
						<td><input type="text" class="i-txt4" value="ManuManuManuManuManu" style="width:146px"></td>
						<td><input type="text" class="i-txt4" value="PackaPacka" style="width:64px"></td>
						<td><input type="text" class="i-txt4" value="13" style="width:38px"></td>
						<td>
							<div class="select type6" lang="en" style="width:56px">
								<label>HF</label>
								<select>
									<option>HF</option>
									<option>HF</option>
								</select>
							</div>
						</td>
						<td>1,000,000</td>
						<td>$10,000.00</td>
						<td><span class="c-blue">1,000,000</span></td>
						<td><input type="text" class="i-txt4 c-red2" value="1,000,000" style="width:58px"></td>
						<td><input type="text" class="i-txt4 c-red2 t-ct" value="4" style="width:38px"> <span>Days</span></td>
					</tr>
				</tbody>z
			</table>
		</div>
		<!-- //위탁판매 -->
		
		
		<!-- 지속적 공급 -->
					
		<!-- layer-pagination -->
		
		<!-- //layer-pagination -->
		
		<div class="layer-data">
			<table class="stock-list-table">
				<thead>
					<tr>
						<th scope="col">No. </th>
						<th scope="col">Part No.</th>
						<th scope="col">Manufacture</th>
						<th scope="col">Package</th>
						<th scope="col">D/C</th>
						<th scope="col">RoHS</th>
						<th scope="col">O'ty</th>
						<th scope="col">Unit Price</th>
						<th scope="col" lang="ko">발주수량</th>
						<th scope="col" lang="ko">공급수량</th>
						<th scope="col" lang="ko">납기</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="11" class="title-box first">
							<h3 class="title"><img src="/kor/images/stock_title02.gif" alt="지속적 공급 가능한 Special Price Part"></h3>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td><input type="text" class="i-txt4" value="123456789123456789123456789123" style="width:184px"></td>
						<td><input type="text" class="i-txt4" value="ManuManuManuManuManu" style="width:146px"></td>
						<td><input type="text" class="i-txt4" value="PackaPacka" style="width:64px"></td>
						<td>NEW</td>
						<td>
							<div class="select type6" lang="en" style="width:56px">
								<label>HF</label>
								<select>
									<option>HF</option>
									<option>HF</option>
								</select>
							</div>
						</td>
						<td>1,000,000</td>
						<td>$10,000.00</td>
						<td><span class="c-blue">1,000,000</span></td>
						<td><input type="text" class="i-txt4 c-red2" value="1,000,000" style="width:58px"></td>
						<td><input type="text" class="i-txt4 c-red2 t-ct" value="4" style="width:38px"> <span>Days</span></td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //지속적 공급 -->
		
		
		<div class="btn-area t-rt">
			<button type="button" class="sell-mn01-3106"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
			<button type="button" class="btn-pop-0201"><img src="/kor/images/btn_delete2.gif" alt="삭제"></button>
		</div>
	</form>
</div>

