<?php 
	$query = $this->common_model->custom_query(" SELECT * FROM `product_stock` LEFT JOIN `admin` ON `product_stock`.`PS_UserUpdate` = `admin`.`M_ID` WHERE `P_ID` = '$P_ID' ORDER BY `PS_ID` DESC ");
	if (count($query) > 0) { ?>
		<div id="order_detail"> <?php
			$frst_val = 0;
			$prev_val = 0;
			$next_val = 0;
			$last_val = 0;
			$lasts = $this->common_model->custom_query(" SELECT `P_ID` FROM `product_stock` WHERE `P_ID` = (SELECT MIN(`P_ID`) FROM `product_stock`) ");
			$nexts = $this->common_model->custom_query(" SELECT `P_ID` FROM `product_stock` WHERE `P_ID` = (SELECT MAX(`P_ID`) FROM `product_stock` WHERE `P_ID` < $P_ID) ");
			$prevs = $this->common_model->custom_query(" SELECT `P_ID` FROM `product_stock` WHERE `P_ID` = (SELECT MIN(`P_ID`) FROM `product_stock` WHERE `P_ID` > $P_ID) ");
			$frsts = $this->common_model->custom_query(" SELECT `P_ID` FROM `product_stock` WHERE `P_ID` = (SELECT MAX(`P_ID`) FROM `product_stock`) ");
			if (count($frsts) > 0) { $frst_row = rowArray($frsts); $frst_val = $frst_row['P_ID']; }
			if (count($prevs) > 0) { $prev_row = rowArray($prevs); $prev_val = $prev_row['P_ID']; }
			if (count($nexts) > 0) { $next_row = rowArray($nexts); $next_val = $next_row['P_ID']; }
			if (count($lasts) > 0) { $last_row = rowArray($lasts); $last_val = $last_row['P_ID']; }
			$cancel_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/stock_report');
			$first_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/'.uri_seg(4).'/'.$frst_val);
			$previous_button 	= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/'.uri_seg(4).'/'.$prev_val);
			$next_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/'.uri_seg(4).'/'.$next_val);
			$last_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/'.uri_seg(4).'/'.$last_val);
			$print_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/print/'.uri_seg(5));
			if (uri_seg(4) === 'view') { ?>
				<div class="pDiv">
					<div class="form-button-box">
						<input type="button" value="กลับไปยังรายการ" class="cancel-button">
					</div>
					<div class="form-button-box"> <?php
						if (count($frsts) > 0 && $P_ID !== $frst_val) { ?>
							<input type="button" value="<< First" class="first-button"> <?php
						}
						if (count($prevs) > 0) { ?>
							<input type="button" value=" < Prev " class="previous-button"> <?php
						} 
						if (count($nexts) > 0) { ?>
							<input type="button" value=" Next > " class="next-button"> <?php
						} 
						if (count($lasts) > 0 && $P_ID !== $last_val) { ?>
							<input type="button" value="Last  >>" class="last-button"> <?php
						} ?>
					</div>
					<div class="form-button-box">
						<button class="print-button"><i class="fa fa-print"></i> PDF</button>
					</div>
				</div> <?php
			}
			/* 
			 * Load content here 
			 */
			?>



			<div class="mDiv">
				<?php 
					$product = rowArray($query);
					$P_Name_IDCode = rowArray($this->common_model->get_where_custom('product', 'P_ID', $product['P_ID']));
				?>
				<div class="ftitle"><?php echo $title.'&nbsp;'.$P_Name_IDCode['P_Name'].' ('.$P_Name_IDCode['P_IDCode'].')'; ?></div>
			</div>
			<div class="main-table-box">
				<div class="bDiv">
					<table cellspacing="0" cellpadding="0" border="0">
						<thead>
							<tr class="hDiv">
								<th><div class="text-center">วันเวลาที่อัพเดท</div></th>
								<th><div class="text-center">การเปลี่ยนจำนวน</div></th>
								<th><div class="text-center">จำนวนคงเหลือ</div></th>
								<th><div class="text-center">การเปลี่ยนราคา</div></th>
								<th><div class="text-center">ราคาล่าสุด</div></th>
								<th><div class="text-center">ผู้อัพเดท</div></th>
							</tr>
						</thead>
						<tbody> <?php
							$erow = 1; 
							foreach ($query as $key => $value) { ?>
								<tr <?php if ($erow %2 === 0) { ?> class="erow" <?php } ?>>
									<td class="text-middle">
										<div class="text-center"><?php echo $value['PS_DateTimeUpdate']; ?></div>
									</td>
									<td class="text-numeri">
										<div class="text-right">
											<?php 
												if (uri_seg(4) === 'view') {
													if ($value['PS_Amount_Log'] == 0)
											            echo number_format($value['PS_Amount_Log']);
											        else if ($value['PS_Amount_Log'] == $value['PS_Amount'])
											            echo '<i class="fa fa-plus" style="color:green;font-size:0.7em"></i> '.number_format($value['PS_Amount_Log']);
											        else if ($value['PS_Amount_Log'] > $value['PS_Amount'])
											            echo '<i class="fa fa-plus" style="color:green;font-size:0.7em"></i> '.number_format($value['PS_Amount_Log']);
											        else if ($value['PS_Amount_Log'] < $value['PS_Amount'])
											            echo '<i class="fa fa-minus" style="color:red;font-size:0.7em"></i> '.number_format($value['PS_Amount_Log']);
											        else
											            echo number_format($value['PS_Amount_Log']); 
												}
												else if (uri_seg(4) === 'print') {
													if ($value['PS_Amount_Log'] == 0)
											            echo number_format($value['PS_Amount_Log']);
											        else if ($value['PS_Amount_Log'] == $value['PS_Amount'])
											            echo '+ '.number_format($value['PS_Amount_Log']);
											        else if ($value['PS_Amount_Log'] > $value['PS_Amount'])
											            echo '+ '.number_format($value['PS_Amount_Log']);
											        else if ($value['PS_Amount_Log'] < $value['PS_Amount'])
											            echo '- '.number_format($value['PS_Amount_Log']);
											        else
											            echo number_format($value['PS_Amount_Log']); 
												}
											?>
										</div>
									</td>
									<td class="text-numeri">
										<div class="text-right"><?php echo number_format($value['PS_Amount']); ?></div>
									</td>
									<td class="text-numeri">
										<div class="text-right">
											<?php 
												if (uri_seg(4) === 'view') {
													if ($value['PS_FullSumPrice_Log'] == 0)
											            echo number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');
											        else if ($value['PS_FullSumPrice_Log'] == $value['PS_FullSumPrice'])
											            echo '<i class="fa fa-plus" style="color:green;font-size:0.7em"></i> '.number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');
											        else if ($value['PS_FullSumPrice_Log'] > $value['PS_FullSumPrice'])
											            echo '<i class="fa fa-plus" style="color:green;font-size:0.7em"></i> '.number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');
											        else if ($value['PS_FullSumPrice_Log'] < $value['PS_FullSumPrice'])
											            echo '<i class="fa fa-minus" style="color:red;font-size:0.7em"></i> '.number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');
											        else
											            echo number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');  
												}
												else if (uri_seg(4) === 'print') {
													if ($value['PS_FullSumPrice_Log'] == 0)
											            echo number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');
											        else if ($value['PS_FullSumPrice_Log'] == $value['PS_FullSumPrice'])
											            echo '+ '.number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');
											        else if ($value['PS_FullSumPrice_Log'] > $value['PS_FullSumPrice'])
											            echo '+ '.number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');
											        else if ($value['PS_FullSumPrice_Log'] < $value['PS_FullSumPrice'])
											            echo '- '.number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');
											        else
											            echo number_format($value['PS_FullSumPrice_Log'], 2, '.', ',');  
												}
											?>
										</div>
									</td>
									<td class="text-numeri">
										<div class="text-right"><?php echo number_format($value['PS_FullSumPrice'], 2, '.', ','); ?></div>
									</td>
									<td class="text-normal">
										<div class="text-left"><?php echo $value['M_flName']; ?></div>
									</td>
								</tr> <?php
								$erow += 1; 
							} ?>
						</tbody>
						<tfoot>
							<tr class="hDiv">
								<th><div class="text-center">วันเวลาที่อัพเดท</div></th>
								<th><div class="text-center">การเปลี่ยนจำนวน</div></th>
								<th><div class="text-center">จำนวนคงเหลือ</div></th>
								<th><div class="text-center">การเปลี่ยนราคา</div></th>
								<th><div class="text-center">ราคาล่าสุด</div></th>
								<th><div class="text-center">ผู้อัพเดท</div></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>



			<?php
			/* 
			 * End content here 
			 */
			if (uri_seg(4) === 'view') { ?>
				<div class="pDiv">
					<div class="form-button-box">
						<input type="button" value="กลับไปยังรายการ" class="cancel-button">
					</div>
					<div class="form-button-box"> <?php
						if (count($frsts) > 0 && $P_ID !== $frst_val) { ?>
							<input type="button" value="<< First" class="first-button"> <?php
						}
						if (count($prevs) > 0) { ?>
							<input type="button" value=" < Prev " class="previous-button"> <?php
						} 
						if (count($nexts) > 0) { ?>
							<input type="button" value=" Next > " class="next-button"> <?php
						} 
						if (count($lasts) > 0 && $P_ID !== $last_val) { ?>
							<input type="button" value="Last  >>" class="last-button"> <?php
						} ?>
					</div>
					<div class="form-button-box">
						<button class="print-button"><i class="fa fa-print"></i> PDF</button>
					</div>
				</div> <?php
			} ?>
		</div> <?php
	}
	else redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
?>
<script>
	$(document).ready(function() {
  		$(".cancel-button").click(function() {
  			$(location).prop("href", "<?php echo $cancel_button; ?>");
  		});
  		$(".first-button").click(function() {
  			$(location).prop("href", "<?php echo $first_button; ?>");
  		});
  		$(".previous-button").click(function() {
  			$(location).prop("href", "<?php echo $previous_button; ?>");
  		});
  		$(".next-button").click(function() {
  			$(location).prop("href", "<?php echo $next_button; ?>");
  		});
  		$(".last-button").click(function() {
  			$(location).prop("href", "<?php echo $last_button; ?>");
  		});
  		$(".print-button").click(function() {
  			window.open("<?php echo $print_button; ?>", "_blank");
  			exit();
  		});
	});
</script>