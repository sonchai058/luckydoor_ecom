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
					$M_TName	= array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => '');
					$M_Sex 		= array('M' => 'ชาย', 'F' => 'หญิง');
					foreach ($query as $key => $value) { ?>
						<div class="form-field-box odd">
							<div class="form-header-box">ชื่อ-นามสกุล: </div>
							<div class="form-display-box"><?php echo $M_TName[$value['M_TName']].$value['M_flName']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">Firstname-lastname: </div>
							<div class="form-display-box"><?php echo $value['M_ucName']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">เพศ: </div>
							<div class="form-display-box"><?php echo $M_Sex[$value['M_Sex']]; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">เลขประจำตัวประชาชน: </div>
							<div class="form-display-box"><?php echo $value['M_npID']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">โทรศัพท์บ้าน: </div>
							<div class="form-display-box"><?php echo $value['M_HTel']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">โทรศัพ์มือถือ: </div>
							<div class="form-display-box"><?php echo $value['M_MTel']; ?></div>
						</div> 
						<div class="form-field-box odd">
							<div class="form-header-box">โทรสาร: </div>
							<div class="form-display-box"><?php echo $value['M_Fax']; ?></div>
						</div> 
						<div class="form-field-box even">
							<div class="form-header-box">อีเมล: </div>
							<div class="form-display-box"><a href="mailto:<?php echo $value['M_Email']; ?>"><?php echo $value['M_Email']; ?></a></div>
						</div> 
						<?php
							$address = $this->common_model->custom_query(
								" 	SELECT * FROM `$table` 
									LEFT JOIN `districts` 	ON `$table`.`District_ID` 	= `districts`.`District_ID` 
									LEFT JOIN `amphures` 	ON `$table`.`Amphur_ID` 	= `amphures`.`Amphur_ID` 
									LEFT JOIN `provinces` 	ON `$table`.`Province_ID` 	= `provinces`.`Province_ID` 
									WHERE `$field_key` = $field_id AND $field_allow = '1' 
									LIMIT 1 "
							);
							foreach ($address as $key => $value) {
								$address = 'เลขที่/ห้อง '.$value['M_hrNumber']; 
		                        if ($value['M_VilBuild'] 	!== '') 	$address .= ' หมู่บ้าน/อาคาร/คอนโด '.$value['M_VilBuild'];
		                        if ($value['M_VilNo'] 		!== '') 	$address .= ' หมู่ที่ '.$value['M_VilNo'];
		                        if ($value['M_LaneRoad'] 	!== '') 	$address .= ' ตรอก/ซอย '.$value['M_LaneRoad'];
		                        if ($value['M_Street'] 		!== '') 	$address .= ' ถนน'.$value['M_Street'];
		                        if ($value['Province_ID']	=== '1')	$address .= ' '.$value['District_Name'].' '.$value['Amphur_Name'].' '.$value['Province_Name'].' '.$value['Zipcode_Code'];
		                        else $address .= ' ตำบล'.$value['District_Name'].' อำเภอ'.$value['Amphur_Name'].' จังหวัด'.$value['Province_Name'].' '.$value['Zipcode_Code'];
							}
						?>
						<div class="form-field-box odd">
							<div class="form-header-box">ที่อยู่: </div>
							<div class="form-display-box"><?php echo $address; ?></div>
						</div> 

						<?php
					} ?>
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