<?php
	$query = $this->common_model->custom_query(" SELECT * FROM `$table` WHERE `$field_key` = $field_id AND `$field_allow` != '3' LIMIT 1 ");
	if (count($query) > 0) { ?>
		<div id="order_detail"> <?php
			$pagination_data = array(
				'table' 		=> $table,
				'field_key' 	=> $field_key,
				'field_id' 		=> $field_id,
				'field_allow'	=> $field_allow
			);
			if (uri_seg(4) === 'view') $this->template->load('content/pagination', $pagination_data);
			/*
			 * Load content here
			 */
			?>



			<div class="mDiv">
				<div class="ftitle"><?php echo $titles[0]; ?></div>
			</div>
			<div class="main-table-box">
				<div class="form-div"> <?php
					foreach ($query as $key => $value) { ?>
						<div class="form-field-box odd">
							<div class="form-header-box">ชื่อสินค้า: </div>
							<div class="form-display-box"><?php echo $value['P_Name'].' ('.$value['P_IDCode'].')'; ?></div>
						</div>
						<?php
							$product_price = $this->common_model->custom_query(
								" 	SELECT * FROM `product_stock`
									WHERE `$field_key` = $field_id
									ORDER BY PS_ID DESC
									LIMIT 1 "
							);
							if (count($product_price) > 0)
								$price = rowArray($product_price);
							else
								$price['PS_FullSumPrice'] = 0;
						?>
						<div class="form-field-box even">
							<div class="form-header-box">ราคา (ล่าสุด): </div>
							<div class="form-display-box">฿<?php echo number_format($price['PS_FullSumPrice'], 2, '.', ','); ?></div>
						</div>
						<?php
							$product_amount = $this->common_model->custom_query(
								" 	SELECT * FROM `product_stock` WHERE `$field_key` = $field_id AND `PS_Allow` = '1' "
							);
							if (count($product_amount) > 0)
								$amount = rowArray($product_amount);
							else
								$amount['PS_Amount'] = 0;
						?>
						<div class="form-field-box odd">
							<div class="form-header-box">จำนวน: </div>
							<div class="form-display-box"><?php echo number_format($amount['PS_Amount']); ?></div>
						</div>
						<?php
							$category = $this->common_model->custom_query(
								" 	SELECT * FROM `$table`
									LEFT JOIN `category` ON `$table`.`C_ID` = `category`.`C_ID`
									WHERE `$field_key` = $field_id AND $field_allow = '1'
									LIMIT 1 "
							);
							foreach ($category as $key => $value) { $category = $value['C_Name']; }
						?>
						<div class="form-field-box even">
							<div class="form-header-box">หมวดหมู่สินค้า: </div>
							<div class="form-display-box"><?php echo $category; ?></div>
						</div>
						<?php
							$product_type = $this->common_model->custom_query(
								" 	SELECT * FROM `$table`
									LEFT JOIN `product_type` ON `$table`.`PT_ID` = `product_type`.`PT_ID`
									WHERE `$field_key` = $field_id AND $field_allow = '1'
									LIMIT 1 "
							);
							foreach ($product_type as $key => $value) { $product_type = $value['PT_Name']; }
						?>
						<div class="form-field-box odd">
							<div class="form-header-box">ชนิดสินค้า: </div>
							<div class="form-display-box"><?php echo $product_type; ?></div>
						</div>
						<?php
							$product_unit = $this->common_model->custom_query(
								" 	SELECT * FROM `$table`
									LEFT JOIN `product_unit` ON `$table`.`PU_ID` = `product_unit`.`PU_ID`
									WHERE `$field_key` = $field_id AND $field_allow = '1'
									LIMIT 1 "
							);
							foreach ($product_unit as $key => $value) { $product_unit = $value['PU_Name']; }
						?>
						<div class="form-field-box even">
							<div class="form-header-box">หน่วยนับสินค้า: </div>
							<div class="form-display-box"><?php echo $product_unit; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">น้ำหนักสินค้า: </div>
							<div class="form-display-box"><?php echo number_format($value['P_Weight'], 2, '.', ',').' (กก.)'; ?></div>
						</div>
						<?php
							$product_color = '';
							$colors = $this->common_model->custom_query(
								" 	SELECT * FROM `product_color`
									WHERE `PC_ID` IN ({$value['P_Color']})
									AND `PC_Allow` != '3'	"
							);
							foreach ($colors as $key => $color) {
								$product_color .= $color['PC_Name'].', ';
							}
							$product_color = trim(rtrim($product_color, ', '));
						?>
						<div class="form-field-box even">
							<div class="form-header-box">สีของสินค้า: </div>
							<div class="form-display-box"><?php echo $product_color; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">ขนาด / รูปทรงสินค้า: </div>
							<div class="form-display-box"><?php echo $value['P_Size']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">ไตเติ้ล / เรื่องย่อ: </div>
							<div class="form-display-box"><?php echo $value['P_Title']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">รายละเอียด: </div>
							<div class="form-display-box"><?php echo $value['P_Detail']; ?></div>
						</div>

						<?php
					} ?>
				</div>
			</div> <?php
			$promotion = $this->common_model->custom_query(
				" 	SELECT * FROM `product_price`
					WHERE `$field_key` = $field_id
					ORDER BY PP_ID DESC "
			);
			if (count($promotion) > 0) { ?>
				<div class="mDiv">
					<div class="ftitle"><?php echo $titles[1]; ?></div>
				</div>
				<div class="main-table-box">
					<div class="bDiv">
						<table cellspacing="0" cellpadding="0" border="0">
							<thead>
								<tr class="hDiv">
									<th><div class="text-center">ชื่อโปรโมชั่น</div></th>
									<th><div class="text-center">ราคาต่อหน่วย</div></th>
									<th><div class="text-center">ราคารวม</div></th>
									<th><div class="text-center">ราคาเต็มแบบไม่คิดส่วนลด</div></th>
									<th><div class="text-center">วันเวลาที่เริ่ม</div></th>
									<th><div class="text-center">วันเวลาที่สิ้นสุด</div></th>
								</tr>
							</thead>
							<tbody> <?php
								$erow = 1;
								foreach ($promotion as $key => $value) { ?>
									<tr <?php if ($erow %2 === 0) { ?> class="erow" <?php } ?>>
										<td class="text-normal"><div class="text-left"><?php echo $value['PP_Name']; ?></div></td>
										<td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['PP_Price'], 2, '.', ','); ?></div></td>
										<td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['PP_SumPrice'], 2, '.', ','); ?></div></td>
										<td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['PP_FullSumPrice'], 2, '.', ','); ?></div></td>
										<td class="text-middle"><div class="text-center"><?php echo $value['PP_StartDate']; ?></div></td>
										<td class="text-middle"><div class="text-center"><?php echo $value['PP_EndDate']; ?></div></td>
									</tr> <?php
									$erow += 1;
								} ?>
							</tbody>
							<tfoot> <?php
								$sums = $this->common_model->custom_query(
									" 	SELECT
										SUM(`PP_Price`) 		AS `PP_Price`,
										SUM(`PP_SumPrice`) 		AS `PP_SumPrice`,
										SUM(`PP_FullSumPrice`) 	AS `PP_FullSumPrice`
										FROM `product_price`
										WHERE `$field_key` = $field_id AND `PP_Allow` = '1' "
								);
								foreach ($sums as $key => $value) { ?>
									<tr class="hDiv">
										<th class="text-normal"><div class="text-left"></div></th>
										<th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['PP_Price'], 2, '.', ','); ?></div></th>
										<th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['PP_SumPrice'], 2, '.', ','); ?></div></th>
										<th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['PP_FullSumPrice'], 2, '.', ','); ?></div></th>
										<th class="text-middle"><div class="text-center"></div></th>
										<th class="text-middle"><div class="text-center"></div></th>
									</tr> <?php
								} ?>
							</tfoot>
						</table>
					</div>
				</div> <?php
			} ?>



			<?php
			/*
			 * End content here
			 */
			if (uri_seg(4) === 'view') $this->template->load('content/pagination', $pagination_data); ?>
		</div> <?php
	}
	else redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
?>