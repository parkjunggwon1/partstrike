<section class="box-type2">
	<div class="title-top">
		<h2>신용정보</h2>
	</div>
	<div class="title-blck first">
		<h3>발주서</h3>
		<a href="<?if ($fr=="M"){?>/kor/<?}else{?>javascript:frReturn('<?=$_REQUEST['rel_idx']?>','<?=$_REQUEST['mem_type']?>');<?}?>"><img src="/kor/images/btn_close02.gif" alt="닫기"></a>

		
	</div>
	<table class="stock-list-table">
		<thead>
			<tr>
				<th colspan="2" scope="col" class="th2" lang="ko">판매</th>
			</tr>
			<tr>
				<th scope="col" class="th3">Total</th>
				<th scope="col" class="th3 line-lt" lang="ko">이번달</th>
			</tr>
		</thead>
		<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side_statistics.php"); ?>
	</table>
</section>
<section class="box-type3 imgs-info">
	<table class="table-type1">
		<tbody>
			<tr>
				<th scope="row" class="t-rt" style="width:16%">사업자등록증</th>
				<td>
					<span class="img-wrap"><a href='/kor/images/file_pt.gif' rel='prettyPhoto'><img alt="" <?=get_noimg_photo($file_path, $filecerti1, "/kor/images/file_pt.gif")?>></a></span>				
				</td>
			</tr>
			<tr>
				<th scope="row" class="t-rt">증명서</th>
				<td>
					<span class="img-wrap"><?=$filecerti1==""?"<a href='/kor/images/file_pt.gif' rel='prettyPhoto'>":"<a href='".get_noimg($file_path, $filecerti1, "/kor/images/file_pt.gif")."' target='_blank' rel='prettyPhoto'>"?><img alt="" <?=get_noimg_photo($file_path, $filecerti1, "/kor/images/file_pt.gif")?>></a></span>
					<span class="img-wrap"><?=$filecerti2==""?"<a href='/kor/images/file_pt.gif' rel='prettyPhoto'>":"<a href='".get_noimg($file_path, $filecerti2, "/kor/images/file_pt.gif")."' target='_blank' rel='prettyPhoto'>"?><img alt="" <?=get_noimg_photo($file_path, $filecerti2, "/kor/images/file_pt.gif")?>></a></span>					
				</td>
			</tr>
			<tr>
				<th scope="row" class="t-rt">사무실/창고</th>
				<td>
					<span class="img-wrap"><?=$filestore1==""?"<a href='/kor/images/file_pt.gif' rel='prettyPhoto'>":"<a href='".get_noimg($file_path, $filestore1, "/kor/images/file_pt.gif")."' target='_blank' rel='prettyPhoto'>"?><img alt="" <?=get_noimg_photo($file_path, $filestore1, "/kor/images/file_pt.gif")?>></a></span>
					<span class="img-wrap"><?=$filestore2==""?"<a href='/kor/images/file_pt.gif' rel='prettyPhoto'>":"<a href='".get_noimg($file_path, $filestore2, "/kor/images/file_pt.gif")."' target='_blank' rel='prettyPhoto'>"?><img alt="" <?=get_noimg_photo($file_path, $filestore2, "/kor/images/file_pt.gif")?>></a></span>
					<span class="img-wrap"><?=$filestore3==""?"<a href='/kor/images/file_pt.gif' rel='prettyPhoto'>":"<a href='".get_noimg($file_path, $filestore3, "/kor/images/file_pt.gif")."' target='_blank' rel='prettyPhoto'>"?><img alt="" <?=get_noimg_photo($file_path, $filestore3, "/kor/images/file_pt.gif")?>></a></span>
					<span class="img-wrap"><?=$filestore4==""?"<a href='/kor/images/file_pt.gif' rel='prettyPhoto'>":"<a href='".get_noimg($file_path, $filestore4, "/kor/images/file_pt.gif")."' target='_blank' rel='prettyPhoto'>"?><img alt="" <?=get_noimg_photo($file_path, $filestore4, "/kor/images/file_pt.gif")?>></a></span>
				</td>
			</tr>
		</tbody>
	</table>
</section>
<link rel="stylesheet" href="/kor/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<script src="/kor/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false,theme: 'light_square'});
})
</script>