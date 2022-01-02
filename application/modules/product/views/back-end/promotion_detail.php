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
					foreach ($query as $key => $value) {
						$P_ID = $value['P_ID'];
						$product = $this->common_model->custom_query(
							" 	SELECT * FROM `product`
								LEFT JOIN `category` 		ON `product`.`C_ID` 	= `category`.`C_ID`
								LEFT JOIN `product_type` 	ON `product`.`PT_ID` 	= `product_type`.`PT_ID`
								LEFT JOIN `product_unit` 	ON `product`.`PU_ID` 	= `product_unit`.`PU_ID`
								WHERE `product`.`P_ID` = $P_ID
								ORDER BY `product`.`P_ID` DESC
								LIMIT 1 "
						);
						if (count($product) > 0)
							$rows = rowArray($product);
						else {
							$rows['P_Name'] 	= '';
							$rows['P_IDCode'] 	= '';
							$rows['C_Name'] 	= '';
							$rows['PT_Name'] 	= '';
							$rows['PU_Name'] 	= '';
							$rows['P_Weight'] 	= '';
							$rows['P_Size'] 	= '';
							$rows['P_Title'] 	= '';
							$rows['P_Detail'] 	= '';
						} ?>
						<div class="form-field-box odd">
							<div class="form-header-box">ชื่อสินค้า: </div>
							<div class="form-display-box"><?php echo $rows['P_Name'].' ('.$rows['P_IDCode'].')'; ?></div>
						</div>
						<?php
							$product_price = $this->common_model->custom_query(
								" 	SELECT `PS_FullSumPrice` FROM `product_stock`
									WHERE `P_ID` = $P_ID AND `PS_Allow` = '1'
									ORDER BY PS_ID DESC
									LIMIT 1 "
							);
							if (count($product_price) > 0) $price = rowArray($product_price); else $price['PS_FullSumPrice'] = 0;
						?>
						<div class="form-field-box even">
							<div class="form-header-box">ราคา (ล่าสุด): </div>
							<div class="form-display-box">฿<?php echo number_format($price['PS_FullSumPrice'], 2, '.', ','); ?></div>
						</div>
						<?php
							$product_amount = $this->common_model->custom_query(
								" 	SELECT `PS_Amount` FROM `product_stock`
									WHERE `P_ID` = $P_ID AND `PS_Allow` = '1'
									ORDER BY PS_ID DESC
									LIMIT 1 "
							);
							if (count($product_amount) > 0) $amount = rowArray($product_amount); else $amount['PS_Amount'] = 0;
						?>
						<div class="form-field-box odd">
							<div class="form-header-box">จำนวน: </div>
							<div class="form-display-box"><?php echo number_format($amount['PS_Amount']); ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">หมวดหมู่สินค้า: </div>
							<div class="form-display-box"><?php echo $rows['C_Name']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">ชนิดสินค้า: </div>
							<div class="form-display-box"><?php echo $rows['PT_Name']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">หน่วยนับสินค้า: </div>
							<div class="form-display-box"><?php echo $rows['PU_Name']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">น้ำหนักสินค้า: </div>
							<div class="form-display-box"><?php echo number_format($rows['P_Weight'], 2, '.', ',').' (กก.)'; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">ขนาด / รูปทรงสินค้า: </div>
							<div class="form-display-box"><?php echo $rows['P_Size']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">ไตเติ้ล / เรื่องย่อ: </div>
							<div class="form-display-box"><?php echo $rows['P_Title']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">รายละเอียด: </div>
							<div class="form-display-box"><?php echo $rows['P_Detail']; ?></div>
						</div>

						<?php
					} ?>
				</div>
			</div>

			<div class="mDiv">
				<div class="ftitle"><?php echo $titles[1]; ?></div>
			</div>
			<div class="main-table-box">
				<div class="form-div">
					<div class="form-field-box odd">
						<div class="form-header-box">ชื่อโปรโมชั่น: </div>
						<div class="form-display-box"><?php echo $value['PP_Name']; ?></div>
					</div>
					<div class="form-field-box even">
						<div class="form-header-box">ราคาต่อหน่วย: </div>
						<div class="form-display-box">฿<?php echo number_format($value['PP_Price'], 2, '.', ','); ?></div>
					</div>
					<div class="form-field-box odd">
						<div class="form-header-box">ราคารวม: </div>
						<div class="form-display-box">฿<?php echo number_format($value['PP_SumPrice'], 2, '.', ','); ?></div>
					</div>
					<div class="form-field-box even">
						<div class="form-header-box">ราคาเต็มแบบไม่คิดส่วนลด: </div>
						<div class="form-display-box">฿<?php echo number_format($value['PP_FullSumPrice'], 2, '.', ','); ?></div>
					</div>
					<div class="form-field-box odd">
						<div class="form-header-box">วันเวลาที่เริ่ม: </div>
						<div class="form-display-box"><?php echo $value['PP_StartDate']; ?></div>
					</div>
					<div class="form-field-box even">
						<div class="form-header-box">วันเวลาที่สิ้นสุด: </div>
						<div class="form-display-box"><?php echo $value['PP_EndDate']; ?></div>
					</div>
					<div class="form-field-box odd">
						<div class="form-header-box">คำอธิบาย: </div>
						<div class="form-display-box"><?php echo $value['PP_Title']; ?></div>
					</div>
					<div class="form-field-box even">
						<div class="form-header-box">รายละเอียด: </div>
						<div class="form-display-box"><?php echo $value['PP_Descript']; ?></div>
					</div>
					<div class="form-field-box odd">
						<div class="form-header-box">หมายเหตุ: </div>
						<div class="form-display-box"><?php echo $value['PP_Remark']; ?></div>
					</div>
				</div>
			</div>



			<?php
			/*
			 * End content here
			 */
			if (uri_seg(4) === 'view') $this->template->load('content/pagination', $pagination_data); ?>
		</div> <?php
	}
	else redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
?>