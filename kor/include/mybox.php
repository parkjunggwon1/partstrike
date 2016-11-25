			<!-- table -->
			<section class="box-type1">
				<div class="hd-type-wrap">
					<table class="stock-list-table bg-type3">
						<thead>
							<tr>
								<th scope="col" style="width:23px">No.</th>
								<th scope="col" style="width:80px">Nation</th>
								<th scope="col" class="t-lt">Part No.</th>
								<th scope="col" class="t-lt" style="width: 75px;">Manufacturer</th>
								<th scope="col" style="width: 81px;">Package</th>
								<th scope="col" style="width: 36px;">D/C</th>
								<th scope="col" style="width: 40px;">RoHS</th>
								<th scope="col" class="t-rt" style="width:62px">O'ty</th>
								<th scope="col" class="t-rt" style="width:62px">Unit Price</th>
								<th scope="col" class="pd-0" style="width:60px" lang="ko">납기</th>
								<th scope="col" class="pd-0" style="width:53px">&nbsp;</th>
							</tr>
						</thead>
						<?	
								echo GET_MYBOX_PART("Y",$i, 1, "main","10");
						?>
					</table>
				</div>
				
						<?
					//	echo GET_MYBOX_TURNKEY();
						?>
			
			</section>
			<!--// table -->
