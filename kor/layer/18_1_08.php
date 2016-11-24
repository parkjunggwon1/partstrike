<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
	$ship = get_ship($ship_idx);
?>
<div class="layer-hd <?if ($ship_type=="2"){echo "red";}?>">
	<h1>내용</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form class="t-ct" id="f5" name="f5">
		<input type="hidden" name="ship_idx" value="<?=$ship_idx?>">
		<input type="hidden" name="typ" value="updror">		
		<div lang="en">RMA No. : <strong class="c-red"><?=str_replace("NCI","RMA",$ship[invoice_no])?></strong></div>
		<table class="detail-table mr-t0" align="center">
			<tbody>
				<tr>
					<th scope="row">수신 :</th>
					<td><input type="text" class="i-txt2 c-blue" id="recv" name="recv" value="<?=$ship[recv]?>" style="width:262px"></td>
				</tr>
				<tr>
					<th scope="row">참조  :</th>
					<td><input type="text" class="i-txt2 c-blue" id="refer" name="refer" value="<?=$ship[refer]?>" style="width:262px"></td>
				</tr>
				<tr>
					<th scope="row">내용  :</th>
					<td><input type="text" class="i-txt2 c-blue" id="content" name="content" value="<?=$ship[content]?>" style="width:262px"></td>
				</tr>
			</tbody>		
		</table>
		<div class="btn-area t-rt">
			<button type="button" class="btn-view-sheet-18-1-09"><img src="/kor/images/btn_return_statment.gif" alt="반품 사유서"></button>
		</div>
	</form>
</div>

