<?
include  $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.meminfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.partinfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.board.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.mybox.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.memfee.php";
/******************************************************************************************
**** 2016-03-30 : 오른쪽 영역만 새로고침 하기 위해 작성
******************************************************************************************/
?>
<!--section id="orderDraft" class="box-type2"-->
	<div class="title-top">
		<h2>발주서</h2>
	</div>
	<div class="title-blck first">
		<h3>판매</h3>
		<div class="select type2 sell">
			<?if (!$this_mem_idx){$this_mem_idx = $_SESSION["MEM_IDX"];}?>
			<?=GET_MyMember($this_mem_idx)?>						
		</div>
		<?=GET_WhatsNew("sell","whatsnew");?>
	</div>
	<div id="odr_sell"><?=GET_Order("S",$this_mem_idx)?></div>
	
	<div class="title-blck">
		<h3>구매</h3>
		<div class="select type2 buy">
			<?if (!$this_mem_idx){$this_mem_idx = $_SESSION["MEM_IDX"];}?>
			<?=GET_MyMember($this_mem_idx)?>						
		</div>
		<?=GET_WhatsNew("buy","whatsnew");//function.php?>		
	</div>
	<div id="odr_buy"><?=GET_Order("B",$this_mem_idx)//class.record.php?></div>
	<?include $_SERVER["DOCUMENT_ROOT"]."/kor/include/side_mybox.php";?>
<!--/section-->

