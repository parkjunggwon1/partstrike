<?
$recordcnt=20;
$viewpagecnt =	10;

if (!$page or $typ=="write")	$page = 1;

if ($strsearch){
	$searchand = $searchand." and $search like '%$strsearch%'";
}
$searchand = $searchand." and bd_gubun='$mode'";
$cnt = QRY_CNT("board",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$resultno =QRY_BOARD_LISTNO(10,$searchand);
$searchand = $searchand." and bd_notice!='Y'";
$result =QRY_BOARD_LIST($recordcnt,$searchand,$page);

?>
<div class="f-rt"><a href="#"><img src="/kor/images/btn_blacklist.png" alt="Black List"></a></div>
			
<section class="box-type7 srch1">
	<form>
		<table>
			<tbody>
				<tr>
					<th scope="row">단어</th>
					<td>
						<input type="text" style="width:205px" lang="ko" name="strsearch" value="<?=$strsearch?>" onKeyPress="check_key(check_search);">
					</td>
					<td><button type="submit"><img src="/kor/images/btn_srch6.gif" alt="검색" onclick="check_search();"></button></td>
				</tr>
			</tbody>
		</table>
	</form>
</section>

<section class="box-type1">
	<div class="hd-type-wrap">
		<table class="stock-list-table board-list">
			<thead>
				<tr>
					<th scope="col" lang="en" style="width:50px">No.</th>
					<th scope="col" lang="en" class="t-lt">Subject</th>
					<th scope="col" lang="en" style="width:100px">Date</th>
				</tr>
			</thead>
			<tbody>
				<?
				while($rowno = mysql_fetch_array($resultno)){
					$idx = replace_out($rowno["bd_idx"]);
					$title = replace_out($rowno["bd_title"]);
					$name = replace_out($rowno["bd_mem_name"]);
					$comment_num = replace_out($rowno["bd_comment_num"]);
					$hit = replace_out($rowno["bd_hit"]);
					$log_date = str_replace("-",".",substr(replace_out($rowno["reg_date"]),2,8));

					//$newimg = "";
					//if( strtotime(date("Y-m-d"))-strtotime($log_date)<=432000){
					//	$newimg="<img src='/images/common/icon_new01.gif'/>";
					//}
				?>	
				<tr>
					<td>[NOTICE]</td>
					<td class="t-lt"><a href="<?=$view_url?>?<?=$param?>&work=view&idx=<?=$idx?>"><?=$title?> <?=get_comment($comment_num)?></a></td>
					<td><?=$log_date?></td>
				</tr>
				<? } ?>
				<!--일반게시글 시작-->
				<?
				if ($cnt==0){
				?>
				<tr>
					<td colspan="5">등록된 자료가 없습니다.</td>
				</tr>
				<?
				}
				$ListNO=$cnt-(($page-1)*$recordcnt);
				$i=0;
				while($row = mysql_fetch_array($result)){
					$i=$i+1;	
					$idx = replace_out($row["bd_idx"]);
					$mode = replace_out($row["bd_gubun"]);
					$title = replace_out($row["bd_title"]);
					$name = replace_out($row["bd_mem_name"]);
					$comment_num = replace_out($row["bd_comment_num"]);
					$hit = replace_out($row["bd_hit"]);
					$log_date = str_replace("-","-",substr(replace_out($row["reg_date"]),0,10));
					$content = replace_out($row["bd_content"]);
				?>
				<tr>
					<td><?=$ListNO?></td>
					<td class="t-lt"><a href="<?=$view_url?>?<?=$param?>&work=view&idx=<?=$idx?>"><?=$title?> <?=get_comment($comment_num)?></a></td>
					<td><?=$log_date?></td>
				</tr>
				<? 
					$ListNO--;
				} 
				?>
			</tbody>
		</table>
	</div>
	<div class="pagination">
		<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
	</div>
</section>