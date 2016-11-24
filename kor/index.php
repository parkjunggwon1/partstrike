<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/header.php"); ?>	
<?include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.mybox.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.partinfo.php";?>
<? include ("inc_popup.php"); ?>
	<!-- content -->
	<div id="partsContent" class="container">
		<div class="col-left">			
			<?php 
			if ( $_SESSION["MEM_ID"]){  
				include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/main_stock.php");    //main_company
			}else{				
				include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/main_company.php"); 
			}
				?>				
		</div>
		<div class="col-right">
			<?
			if ( $_SESSION["MEM_ID"] &&$_SESSION["REL_IDX"]==0){
				
				 include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side_order.php"); 
			}else{
				$main = "y";
				include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side.php"); 
			}
			?>
		</div>
	</div>
	<!-- //content -->
<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/footer.php"); ?>