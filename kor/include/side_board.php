
<script type="text/javascript">
<!--
	function asdf1(){
		showajax(".col-right", "side_order");
	}
	function asdf2(){
		var main="<?=$main?>";
		if (main=="y"){
			location.href = "/kor/";
		}
		showajax(".col-right", "side");
	}
//-->
</script>
<?if ($board_idx){
	plushit("board","bd_hit","bd_idx",$board_idx);
	$result = QRY_BOARD_VIEW($board_idx);
	$row = mysql_fetch_array($result);
	$idx = replace_out($row["bd_idx"]);	
	$title = replace_out($row["bd_title"]);
	$title_sub = replace_out($row["bd_title_sub"]);
	$name = replace_out($row["bd_mem_name"]);
	$mem_idx = replace_out($row["bd_mem_idx"]);
	$content = ($row["bd_content"]);
	$notice = replace_out($row["bd_notice"]);
	$file1 = replace_out($row["bd_file1"]);
	$file2 = replace_out($row["bd_file2"]);
	$file3 = replace_out($row["bd_file3"]);
	$file4 = replace_out($row["bd_file4"]);
	$file5 = replace_out($row["bd_file5"]);
	$hit = replace_out($row["bd_hit"]);
	$start_date = replace_out($row["bd_start_date"]);
	$end_date = replace_out($row["bd_end_date"]);
	$log_date = substr(replace_out($row["reg_date"]),0,10);
	$log_date = replace_out($row["reg_date"]);
	$ref = replace_out($row["bd_ref"]);
	$lev = replace_out($row["bd_lev"]);
	$step = replace_out($row["bd_step"]);
	$log_date = str_replace("-","-",substr(replace_out($row["reg_date"]),0,10));
	$date=date_create($log_date);
	$log_date_2=date_format($date,"d,M,Y");
	
	$gubun = replace_out($row["bd_gubun"]);

	switch ($gubun) {
		case "AA001";
			$title_text ="공지사항";	
			break;
		case "AA002";
			$title_text ="질의응답";	
			break;
		case "AA003";
			$title_text ="제안";	
			break;
	}
}

?>
<section id="board-con" class="box-type2">
	<div class="title-top">
		<h2><?=$title_text?></h2>
	</div>
	<div class="title-blck first">
		<h3>내용<?=$mem_idx?></h3>
		<?if($_SESSION["MEM_IDX"]){?>
		<a href="javascript:asdf1()"><img src="/kor/images/btn_oderform.gif" alt="발주서"></a>
		<?}else{?>
		<a href="javascript:asdf2()"><img src="/kor/images/btn_close02.gif" alt="닫기"></a>
		<?}?>﻿﻿
	</div>
	<div class="mr-tb15 con-section" lang="ko">
		<?=$content?>
	</div>
	<?
	$org_mem_idx=get_want("board","bd_mem_idx"," and bd_idx='$ref'");
	$result_reply =QRY_LIST("board","all",$page," and bd_ref='$idx' ", " bd_lev, reg_date ");	
	$result_reply;
	$cnt=mysql_num_rows($result_reply);
	while($row_reply = mysql_fetch_array($result_reply)){
		$comm_idx = replace_out($row_reply["bd_idx"]);
		$name = replace_out($row_reply["bd_mem_name"]);
		$title = replace_out($row_reply["bd_title"]);
		$comment = replace_out($row_reply["bd_content"]);
		$log_date = replace_out($row_reply["reg_date"]);
		$file1 = replace_out($row_reply["bd_file1"]);
		$file2 = replace_out($row_reply["bd_file2"]);
		$lev = replace_out($row_reply["bd_lev"]);
		$step = replace_out($row_reply["bd_step"]);
		$ref = replace_out($row["bd_ref"]);
		$i++;
		if ($step>0){
	?>
	<!--<div class="mr-tb15 con-section" lang="ko">
		<?if($step>0){?>&nbsp;<img src="/admin/img/ico_reply.gif">&nbsp;<?}?><span class="f-rt">[<?=$log_date_2?>]</span><strong><?=$name?> 님의 답변입니다 </strong><br>
		<?=$comment?><br>
		<?if($file1){?><a href="/include/filedownload.php?filename=<?=$file1?>&path=<?=$file_path?>"    target="_net" ><?=$file1?></a><br><?}?>
		<?if($file2){?><a href="/include/filedownload.php?filename=<?=$file2?>&path=<?=$file_path?>"    target="_net" ><?=$file2?></a><br><?}?>
		<?if($_SESSION["MEM_IDX"]==$mem_idx && $i==$cnt){?>
			<button type="button" href="#" class="msg-02 f-rt" idx="<?=$comm_idx?>" ref="<?=$ref?>" ref2="" lev="<?=$lev?>" step="<?=$step?>"  mode="AA002"><img src="/kor/images/btn_reply4.gif" alt="답변"></button>
		<?}?>
	</div>-->
	
	<? 
		//$mem_idx = replace_out($row_reply["bd_mem_idx"]);
		}
		$ListNO--;
	} ?>	
	<?if($_SESSION["MEM_IDX"]==$org_mem_idx && $mem_idx==0  && $step<6){?>
		<button type="button" href="#" class="msg-02 f-rt" idx="<?=$comm_idx?>" ref="<?=$ref?>" ref2="" lev="<?=$lev?>" step="<?=$step?>"  mode="AA002"><img src="/kor/images/btn_answer_go.gif" alt="회신"></button>
	<?}?>	
</section>
