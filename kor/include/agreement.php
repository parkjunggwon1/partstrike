<section id="Terms" class="box-type1">
	<div class="box-top">
		<h2>이용약관</h2>
	</div>
	<div class="terms-wrap">
		<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/terms_txt.php"); ?>	
	</div>
	<?if(!$_SESSION["MEM_IDX"]){?><div class="t-rt" style="padding-bottom:7px"><a href="javascript:joinusform();"><img src="/kor/images/btn_join.gif" alt="가입"></a></div><?}?>
</section>
