<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/header.php"); ?>
	
	<!-- content -->
	<div id="partsContent" class="container">
		<div class="col-left">
		
			<section id="stockTop" class="box-type1">
				<form>
					<span><a href="#"><img src="/kor/images/btn_apply_form_down.gif" alt="등록 양식 Download"></a></span>
					<span class="op1"><label class="i-file">재고파일 <input type="file" onChange="javascript: document.getElementById('fileName').value = this.value"><input type="text" id="fileName" readonly><span></span></label></span>
					<span class="op2"><label class="ipt-chk chk2"><input type="checkbox"><span></span>덮어쓰기</label></span>
					<span class="op3"><label class="ipt-chk chk2"><input type="checkbox"><span></span>추가등록</label></span>
					<span class="op4"><button type="submit"><img src="/kor/images/btn_form_apply.gif" alt="등록"></button></span>
				</form>
			</section>
			
			<section id="stockManageTop" class="box-type1">
				<div class="box-top bg2">
					<h2>재고추가</h2>
				</div>
				<table class="stock-list-table">
					<thead>
						<tr>
							<th scope="col">Part No.</th>
							<th scope="col">Manufacturer</th>
							<th scope="col">Package</th>
							<th scope="col" style="width:60px">D/C</th>
							<th scope="col">RoHS</th>
							<th scope="col">Unit Price</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
							<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
							<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
							<td>254</td>
							<td>
								<div class="select type4" lang="en" style="width:60px">
									<label>RoHS</label>
									<select>
										<option lang="en">RoHS</option>
										<option lang="en">RoHS</option>
									</select>
								</div>
							</td>
							<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
							<td><button type="submit"><img src="/kor/images/btn_form_apply.gif" alt="등록"></button></td>
						</tr>
					</tbody>
				</table>
			</section>
			
			<!-- stockManage -->
			<section id="stockManage" class="box-type1">
				<form>
					<div class="box-top srch-box bg2">
						<div class="srch-block1"><label lang="en">Part No. <input type="text"></label><button type="submit"><img src="/kor/images/btn_srch2.gif" alt="검색"></button></div>
						<h2 class="srch-block2">재고편집</h2>
						<a href="#" class="srch-block3"><img src="/kor/images/btn_stock_list_down.gif" alt="재고목록 download"></a>
					</div>
					<table class="stock-list-table">
						<thead>
							<tr>
								<th scope="col">No. </th>
								<th scope="col">Part No.</th>
								<th scope="col">Manufacturer</th>
								<th scope="col">Package</th>
								<th scope="col" style="width:60px">D/C</th>
								<th scope="col">RoHS</th>
								<th scope="col">Unit Price</th>
								<th scope="col" lang="ko">제거</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>254</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>2</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>12</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>3</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>14</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>4</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>153</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>5</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>21</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>6</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>11</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>7</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>10</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>8</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>41</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>9</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>2</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>10</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>1</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>11</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>12</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>12</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>41</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>13</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>112</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>14</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>211</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>15</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>222</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>16</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>111</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
							<tr>
								<td>17</td>
								<td><input type="text" class="i-txt2" style="width:190px" value="123456789123456789123456789123"></td>
								<td><input type="text" class="i-txt2" style="width:155px" value="ManuManuManuManuManu"></td>
								<td><input type="text" class="i-txt2 w-50" style="width:76px" value="PackaPacka"></td>
								<td>211</td>
								<td>
									<div class="select type4" lang="en" style="width:60px">
										<label>RoHS</label>
										<select>
											<option lang="en">RoHS</option>
											<option lang="en">RoHS</option>
										</select>
									</div>
								</td>
								<td><input type="text" class="i-txt2" style="width:76px" value="$10,000.00"></td>
								<td><label class="ipt-chk chk3"><input type="checkbox"><span></span></label></td>
							</tr>
						</tbody>					
					</table>
					<div class="btn-area">
						<button type="submit" class="f-rt"><img src="/kor/images/btn_stock_save.gif" alt="저장"></button>
					</div>
					<div class="pagination">
						<ul>
							<li class="navi-prev"><a href="#">Prev</a></li>
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
							<li class="navi-next"><a href="#">Next</a></li>
						</ul>
					</div>
				</form>
			</section>
			<!--// stockManage -->
			
		</div>
		<div class="col-right">
			<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side_order.php"); ?>
		</div>
	</div>
	<!-- //content -->
	
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/footer.php"); ?>
	
