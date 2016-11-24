<? include "../inc/head.html" ?>
<?
	$mNum = "4";
	$sNum = "2";
?>
<body>
<div id="wrap">
	<? include "../inc/top.html" ?>

	<!--서브영역-->
	<div id="scontainer">
		<? include "../inc/lnb04.html" ?>
		<!--서브컨텐츠-->
		<div id="scontent">
			<!-- Svisual -->
			<div id="svisual">
				<div id="s04">
					<!--로케이션-->
					<p class="location"><img src="../img/201307/cnt/bu_home.gif" /> > 고객센터 ><span class="grey"> 리얼FAQ</span></p>
					<h2><img src="../img/201307/cnt/h2_0402.png" /></h2>
					<!--<span class="scr"><img src="../img/201307/cnt/sub_script.png" /></span>-->
				</div><!-- // Svisual -->
			</div><!-- // Svisual -->
			<div id="cnt">
				<div id="write">
					<table>
						<colgroup>
						<col width="140" />
						<col width="600" />
						</colgroup>
						<tr>
							<th>제목</th>
							<td><input name="company" type="type" class="text" style="width:95%;"></td>
						</tr>
						<tr>
							<th>내용</th>
							<td><textarea name="content" rows="20" style="width:95%;" wrap="on"></textarea></td>
						</tr>
						<tr>
							<th>첨부파일</th>
							<td><input name="company" type="file" class="text" style="width:90%;">
							<p>* 파일첨부는 최대 5M를 넘을 수 없습니다.<br />
							* 실행파일(*.exe),인터넷바로가기(*.lnk),아이콘(icon)은 첨부되지 않습니다. </p>
							</td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td><input name="company" type="password" class="text" style="width:100px;"></td>
						</tr>
					</table>
					<div class="write_btn">
					<A href="#"><img src="../img/201307/bbs/btn_write.gif" alt="글쓰기" /></A>
					<A href="qna.html"><img src="../img/201307/bbs/btn_cancel.gif" alt="취소" /></A>
					</div>

				</div><!-- //write-->
			</div><!--// cnt -->
		</div>	<!--//서브컨텐츠 scontent-->
	</div><!--//서브영역 scontainer-->    


<? include "../inc/footer.html" ?>
    
</div><!--// wrap -->
</body>
</html>
