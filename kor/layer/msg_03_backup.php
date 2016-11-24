<?
include  $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";

?>
<style type="text/css">
	.re {color:#000; font-weight:bold}
	.nonre {color:#000; font-weight:bold}
</style>
<div class="layer-hd">
	<h1><span lang="en">Message</span></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<div class="msg-content">
		<table class="stock-list-table board-list">
			<thead>
				<tr>
					<th scope="col" lang="en" style="width:70px">No.</th>
					<th scope="col" lang="en" class="t-lt">Subject</th>
					<th scope="col" lang="en" style="width:100px">Date</th>
				</tr>
			</thead>
			<tbody>
				<!--일반게시글 시작-->
				<?
				$mode = "EE001";
				if ($strsearch){
					$searchand = $searchand." and bd_title like '%$strsearch%'";
				}
				$searchand = $searchand." and (bd_mem_idx='$session_mem_idx' or bd_send_idx='$session_mem_idx')";

				$searchand = $searchand." and bd_gubun='$mode'";
				$searchand = $searchand." and bd_lev='0'";	

				$cnt = QRY_CNT("board",$searchand);
				$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
				$resultno =QRY_BOARD_LISTNO(10,$searchand);
				$searchand = $searchand." and bd_notice!='Y'";
				$result =QRY_BOARD_LIST($recordcnt,$searchand,$page);


				if ($cnt==0){
				?>
				<tr>
					<td colspan="5"></td>
				</tr>
				<?
				}
				$ListNO=$cnt-(($page-1)*$recordcnt);
				$i=0;
				while($row = mysql_fetch_array($result)){
					$i=$i+1;	
					$idx = replace_out($row["bd_idx"]);
					$title = replace_out($row["bd_title"]);
					$name = replace_out($row["bd_mem_name"]);
					$comment_num = replace_out($row["bd_comment_num"]);
					$hit = replace_out($row["bd_hit"]);
					$log_date = str_replace("-",".",substr(replace_out($row["reg_date"]),0,10));
					$content = replace_out($row["bd_content"]);
					$file1 = replace_out($row["bd_file1"]);
					$file2 = replace_out($row["bd_file2"]);
					$comment_html="";
					if($comment_num>0){
						$comment_html = "<span class=' c-blue ' >[Reply]</span>";
					}
					$send_result = replace_out($row["bd_send_result"]);
					if ($bgcolor == "background-color:#f7f7f7;" || $bgcolor=="") { 
						$bgcolor="background-color:#ffffff;";
					}else{
						$bgcolor ="background-color:#f7f7f7;";
					}
				?>
				<tr style="<?=$bgcolor?>">
					<td><?=$ListNO?></td>
					<td class="t-lt"><a href="#" class="<?if($send_result==0){?>re<?}?> open-msg "  idx='<?=$idx?>'>
					<?=$title?> <?=$comment_html?></a>
					</td>
					<td><?=$log_date?></td>
				</tr>
				<tr class="msg-wrap">
					<td colspan="3">
						<table>
							<tr>
								<td colspan="3" class="msg-body">
									<div class="msg-con">
										<?=$content?>
									</div>
									<div class="msg-file">
										<?if($file1){?><a href="/include/filedownload.php?filename=<?=$file1?>&path=<?=$file_path?>"    target="_net" ><?=$file1?></a> <?}?>
										<?if($file2){?><a href="/include/filedownload.php?filename=<?=$file2?>&path=<?=$file_path?>"    target="_net" ><?=$file2?></a><?}?>
									</div>
								</td>
							</tr>
							<!-- reply -->
							<?
						
							$result_reply =QRY_LIST("board","all",$page," and bd_ref='$idx' ", " bd_idx ");	
							while($row_reply = mysql_fetch_array($result_reply)){
								$k=$k+1;
								$comm_idx = replace_out($row_reply["bd_idx"]);
								$comm_name = replace_out($row_reply["bd_mem_name"]);
								$comm_mem_idx = replace_out($row_reply["bd_mem_idx"]);
								$comm_title = replace_out($row_reply["bd_title"]);
								$comm_comment = replace_out($row_reply["bd_content"]);
								$comm_log_date = replace_out($row_reply["reg_date"]);
								$comm_file1 = replace_out($row_reply["bd_file1"]);
								$comm_file2 = replace_out($row_reply["bd_file2"]);
								$comm_lev = replace_out($row_reply["bd_lev"]);
								$comm_step = replace_out($row_reply["bd_step"]);
								$logo = get_want("member","filelogo"," and mem_idx='$comm_mem_idx' ");
							?>
							<tr class="msg-rp">
								<td class="t-rt" style="width:70px"><img src="/kor/images/icon_reply.gif" alt="reply"></td>
								<td class="t-lt"><?=$comm_title?></td>
								<td style="width:150px"><?=$comm_log_date?></td>
							</tr>
							<tr>
								<td class="reply-logo"><?if($logo){?><img src="/upload/file/<?=$logo?>" alt="" width="60"><?}?></td>
								<td colspan="2">
									<div class="msg-con">
										<?=$comm_comment?>
									</div>
									<div class="msg-file">
										<?if($comm_file1){?><a href="/include/filedownload.php?filename=<?=$comm_file1?>&path=<?=$file_path?>"    target="_net" ><?=$comm_file1?></a> <?}?>
										<?if($comm_file2){?><a href="/include/filedownload.php?filename=<?=$comm_file2?>&path=<?=$file_path?>"    target="_net" ><?=$comm_file2?></a><?}?>	
										<?if($comment_num==$k and $session_mem_idx!=$comm_mem_idx){?>
											<button type="button" href="#" class="msg-02 f-rt" ref="<?=$idx?>" ref2="<?=$comm_idx?>" lev="<?=$comm_lev?>" step="<?=$comm_step?>"><img src="/kor/images/btn_reply4.gif" alt="쓰기"></button>
										<?}?>
									</div>
								</td>
							</tr>
							<? 
							} 
							?>
							<!-- //reply -->
							
						</table>						
					</td>
				</tr>
				<? 
					$ListNO--;
				} 
				?>
			</tbody>
		</table>
		<div class="btn-area t-rt">
			<!--<a href="#" class="msg-02"><img src="/kor/images/btn_write.gif" alt="글쓰기"></a>-->
		</div>
		<div class="pagination">
			<? 
			$layerNum="layer3";
			$loadPage = "message_03";
			$varNum = "?";			
			include $_SERVER["DOCUMENT_ROOT"]."/include/paging4.php"; ?>		
		</div>
	</div>
</div>

<iframe name="proc" id="proc" width="0" height="0" frameborder="0"></iframe>
