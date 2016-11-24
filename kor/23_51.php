<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/header.php"); ?>
	
	<!-- content -->
	<div id="partsContent" class="container">
		<div class="col-left">
			<section class="box-type1">
				<div class="hd-type-wrap">
					<table class="stock-list-table board-list">
						<thead>
							<tr>
								<th scope="col" lang="en" style="width:50px">No.</th>
								<th scope="col" lang="en" style="width:120px">Nation</th>
								<th scope="col" lang="en" class="t-lt">Subject</th>
								<th scope="col" lang="en" style="width:100px">Date</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>215</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>214</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>213</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>212</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>211</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>210</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>209</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>208</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>207</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a><a href="#" class="c-blue">[Reply] </a></td>
								<td>2015.06.22</td>
							</tr>
							<tr>
								<td>206</td>
								<td><img src="/kor/images/nation_title2_uk.png" alt="United Kimgdom"></td>
								<td class="t-lt"><a href="#">Enter question and answer content.</a></td>
								<td>2015.06.22</td>
							</tr>
						</tbody>
					</table>
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
			</section>
			
			<section class="box-type1 write-form">
				<div class="box-top">
					<h2>글쓰기</h2>
				</div>
				<form>
					<p class="panel1"><label class="ipt-chk chk4 f-rt" lang="ko"><input type="checkbox"><span></span>비공개</label>
						질문사항이 있다면, 게시판에 모국어로 글을 남겨주시기 바랍니다.</p>
					<table>
						<tbody>
							<tr>
								<th scope="row">제목 : </th>
								<td colspan="2"><input type="text" class="i-txt5" style="width:222px"></td>
							</tr>
							<tr>
								<td colspan="3" class="edit-col">
									<img src="/kor/images/editor.jpg" alt="">
								</td>
							</tr>
							<tr>
								<th scope="row">파일 / 사진 :</th>
								<td style="width:350px">
									<label class="i-file"><input onchange="javascript: document.getElementById('fileName').value = this.value" type="file"><input id="fileName" type="text" readonly><span></span></label>
								</td>
								<td lang="en">
									<a href="#" class="c-blue">File1</a>, <a href="#" class="c-blue">File2</a>
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
									<span class="img-wrap"><img alt="" src="/kor/images/file_pt.gif"></span>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="btn-area t-rt">
						<button type="submit"><img src="/kor/images/btn_apply.gif" alt="등록"></button>
						<button type="reset"><img src="/kor/images/btn_cancel.gif" alt="취소"></button>
					</div>
				</form>
			</section>
		</div>
		<div class="col-right">
			<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side_order.php"); ?>
		</div>
	</div>
	<!-- //content -->
	
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/footer.php"); ?>
	
