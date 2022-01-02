<?php
	if (uri_seg(3) == 'order_doing_unannounce'	) $where = " AND `$field_allow` IN ('1','4'	) ";
	if (uri_seg(3) == 'order_doing_announced'	) $where = " AND `$field_allow` IN ('5','6'	) ";
	if (uri_seg(3) == 'order_history_success'	) $where = " AND `$field_allow` IN ('7'		) ";
	if (uri_seg(3) == 'order_history_cancel'	) $where = " AND `$field_allow` IN ('2','3'	) ";
	$query = $this->common_model->custom_query(" SELECT * FROM `$table` WHERE `$field_key` = $field_id {$where} LIMIT 1 ");
	if (count($query) > 0) { ?>
		<div id="order_detail"> <?php
			$pagination_data = array(
				'table' 		=> $table,
				'field_key' 	=> $field_key,
				'field_id' 		=> $field_id,
				'field_allow'	=> $field_allow
			);
			if (uri_seg(4) === 'view') {
				if (uri_seg(2) == 'control_cart' && uri_seg(4) != 'edit')
					$this->template->load('content/order_tab');
				$this->template->load('content/pagination', $pagination_data);
			}
			/*
			 * Load content here
			 */
			?>



			<div class="mDiv">
				<div class="ftitle"><?php echo $titles[0]; ?></div>
			</div>
			<div class="main-table-box">
				<div class="form-div"> <?php
					$OD_Status = array('1' => 'ปกติ', '2' => 'Pre-order');
					$OD_Allow = $this->order_status_model->getOnceWebMain();
					foreach ($query as $key => $value) {
						$order_address = rowArray($this->common_model->get_where_custom('order_address', 'OD_ID', $value['OD_ID']));
						if (uri_seg(3) == 'order_doing_unannounce') { ?>
							<div class="form-field-box odd">
								<div class="form-header-box">รหัสใบสั่งซื้อ: </div>
								<div class="form-display-box"><?php echo $value['OD_Code']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">วันที่สั่งซื้อ: </div>
								<div class="form-display-box"><?php echo formatDateThai($value['OD_DateTimeAdd']); ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">ชื่อ-นามสกุล: </div>
								<div class="form-display-box"><?php echo $order_address['OD_Name']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">เงินที่ต้องชำระ: </div>
								<div class="form-display-box">฿<?php echo number_format($value['OD_FullSumPrice'], 2); ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">เงินที่แจ้ง: </div>
								<div class="form-display-box">฿<?php echo number_format(0, 2); ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">รหัส EMS: </div>
								<div class="form-display-box"><?php echo $value['OD_EmsCode']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">สถานะ: </div>
								<div class="form-display-box"><?php echo $OD_Allow[$value['OD_Allow']]; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">การซื้อขาย / สั่งซื้อ: </div>
								<div class="form-display-box"><?php echo $OD_Status[$value['OD_Status']]; ?></div>
							</div> <?php
						}
						else if (uri_seg(3) == 'order_doing_announced') {
							$order_transfer = rowArray($this->common_model->get_where_custom('order_transfer', 'OD_ID', $value['OD_ID']));
							if (count($order_transfer) > 0)
								$banks 	= rowArray($this->common_model->get_where_custom('bank', 'B_ID', $order_transfer['B_ID']));
							else
								$banks 	= array('B_Img' => '', 'B_Name' => '');
							$OT_Payment = array('1' => 'โอนผ่านธนาคาร', '2' => 'ชำระผ่านบัตร', '3' => 'ชำระผ่านเคาเตอร์เซอร์วิส', '4' => 'อื่นๆ'); ?>
							<div class="form-field-box odd">
								<div class="form-header-box">รหัสใบสั่งซื้อ: </div>
								<div class="form-display-box"><?php echo $value['OD_Code']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">วันที่แจ้ง: </div>
								<div class="form-display-box"><?php echo formatDateThai($order_transfer['OT_DateTimeAdd']); ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">ชื่อ-นามสกุล: </div>
								<div class="form-display-box"><?php echo $order_address['OD_Name']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">เงินที่ต้องชำระ: </div>
								<div class="form-display-box">฿<?php echo number_format($value['OD_FullSumPrice'], 2); ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">เงินที่แจ้ง: </div>
								<div class="form-display-box"><span <?php if (count($order_transfer) > 0 && $order_transfer['OT_FullSumPrice'] > $value['OD_FullSumPrice']) { ?> style="color:red;font-weight:bold" <?php } ?>><?php if (count($order_transfer) > 0) echo '฿'.number_format($order_transfer['OT_FullSumPrice'], 2, '.', ','); if (count($order_transfer) > 0 && $value['OD_FullSumPrice'] > $order_transfer['OT_FullSumPrice']) echo ' <span style="color:red;font-style:italic">(โอนเงินไม่ครบ)</span>'; ?></span></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">ธนาคาร: </div>
								<div class="form-display-box"><?php if (count($order_transfer) > 0) { ?><img src="<?php echo base_url('assets/admin/images/bank/'.$banks['B_Img']); ?>" alt="<?php echo $banks['B_Name']; ?>" title="<?php echo $banks['B_Name']; ?>"><?php } ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">ช่องทางชำระเงิน: </div>
								<div class="form-display-box"><?php if (count($order_transfer) > 0) echo $OT_Payment[$order_transfer['OT_Payment']]; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">หมายเหตุ/รายละเอียด: </div>
								<div class="form-display-box"><?php if (count($order_transfer) > 0) echo $order_transfer['OT_Descript']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">หลักฐานการโอน: </div>
								<div class="form-display-box"><?php if (count($order_transfer) > 0) { ?><a class="fancybox" href="<?php echo base_url('assets/uploads/user_uploads_img/'.$order_transfer['OT_ImgAttach']); ?>">คลิกที่นี่</a><?php } ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">รหัส EMS: </div>
								<div class="form-display-box"><?php echo $value['OD_EmsCode']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">สถานะ: </div>
								<div class="form-display-box"><?php echo $OD_Allow[$value['OD_Allow']]; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">การซื้อขาย / สั่งซื้อ: </div>
								<div class="form-display-box"><?php echo $OD_Status[$value['OD_Status']]; ?></div>
							</div> <?php
						}
						else if (uri_seg(3) == 'order_history_success' || uri_seg(3) == 'order_history_cancel') {
							$order_transfer = rowArray($this->common_model->get_where_custom('order_transfer', 'OD_ID', $value['OD_ID']));
							if (count($order_transfer) > 0)
								$banks 	= rowArray($this->common_model->get_where_custom('bank', 'B_ID', $order_transfer['B_ID']));
							else
								$banks 	= array('B_Img' => '', 'B_Name' => '');
							$OT_Payment = array('1' => 'โอนผ่านธนาคาร', '2' => 'ชำระผ่านบัตร', '3' => 'ชำระผ่านเคาเตอร์เซอร์วิส', '4' => 'อื่นๆ'); ?>
							<div class="form-field-box odd">
								<div class="form-header-box">รหัสใบสั่งซื้อ: </div>
								<div class="form-display-box"><?php echo $value['OD_Code']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">วันที่สั่งซื้อ: </div>
								<div class="form-display-box"><?php echo formatDateThai($value['OD_DateTimeAdd']); ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">ชื่อ-นามสกุล: </div>
								<div class="form-display-box"><?php echo $order_address['OD_Name']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">เงินที่ต้องชำระ: </div>
								<div class="form-display-box">฿<?php echo number_format($value['OD_FullSumPrice'], 2); ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">เงินที่แจ้ง: </div>
								<div class="form-display-box"><span <?php if (count($order_transfer) > 0 && $order_transfer['OT_FullSumPrice'] > $value['OD_FullSumPrice']) { ?> style="color:red;font-weight:bold" <?php } ?>><?php if (count($order_transfer) > 0) echo '฿'.number_format($order_transfer['OT_FullSumPrice'], 2, '.', ','); if (count($order_transfer) > 0 && $value['OD_FullSumPrice'] > $order_transfer['OT_FullSumPrice']) echo ' <span style="color:red;font-style:italic">(โอนเงินไม่ครบ)</span>'; ?></span></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">ธนาคาร: </div>
								<div class="form-display-box"><?php if (count($order_transfer) > 0) { ?><img src="<?php echo base_url('assets/admin/images/bank/'.$banks['B_Img']); ?>" alt="<?php echo $banks['B_Name']; ?>" title="<?php echo $banks['B_Name']; ?>"><?php } ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">ช่องทางชำระเงิน: </div>
								<div class="form-display-box"><?php if (count($order_transfer) > 0) echo $OT_Payment[$order_transfer['OT_Payment']]; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">หมายเหตุ/รายละเอียด: </div>
								<div class="form-display-box"><?php if (count($order_transfer) > 0) echo $order_transfer['OT_Descript']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">หลักฐานการโอน: </div>
								<div class="form-display-box"><?php if (count($order_transfer) > 0) { ?><a class="fancybox" href="<?php echo base_url('assets/uploads/user_uploads_img/'.$order_transfer['OT_ImgAttach']); ?>">คลิกที่นี่</a><?php } ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">รหัส EMS: </div>
								<div class="form-display-box"><?php echo $value['OD_EmsCode']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">วันที่แจ้ง: </div>
								<div class="form-display-box"><?php echo formatDateThai($order_transfer['OT_DateTimeAdd']); ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">การซื้อขาย / สั่งซื้อ: </div>
								<div class="form-display-box"><?php echo $OD_Status[$value['OD_Status']]; ?></div>
							</div> <?php
						}
					} ?>
				</div>
			</div>

			<div class="mDiv">
				<div class="ftitle"><?php echo $titles[1]; ?></div>
			</div>
			<div class="main-table-box">
				<div class="bDiv">
					<table cellspacing="0" cellpadding="0" border="0">
						<thead>
							<tr class="hDiv">
								<th><div class="text-center">สินค้า</div></th>
								<th><div class="text-center">รายละเอียด / หมายเหตุ</div></th>
								<th><div class="text-center">จำนวน</div></th>
								<th><div class="text-center">ราคา</div></th>
								<th><div class="text-center">ราคารวม</div></th>
								<th><div class="text-center">ราคาสุทธิ</div></th>
							</tr>
						</thead>
						<tbody> <?php
							$lists = $this->common_model->custom_query(
								" 	SELECT * FROM `order_list`
									LEFT JOIN `product` ON `order_list`.`P_ID` = `product`.`P_ID`
									WHERE `$field_key` = $field_id AND `ODL_Allow` = '1'
									ORDER BY `ODL_DateTimeUpdate` ASC, `ODL_ID` ASC "
							);
							$erow = 1;
							foreach ($lists as $key => $value) { ?>
								<tr <?php if ($erow %2 === 0) { ?> class="erow" <?php } ?>>
									<td class="text-normal"><div class="text-left"><?php echo $value['P_IDCode'].' '.trim($value['P_Name']); ?></div></td>
									<td class="text-normal"><div class="text-left"><?php echo $value['ODL_Descript']; ?></div></td>
									<td class="text-numeri"><div class="text-right"><?php echo $value['ODL_Amount']; ?></div></td>
									<td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_Price'], 2); ?></div></td>
									<td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_SumPrice'], 2); ?></div></td>
									<td class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_FullSumPrice'], 2); ?></div></td>
								</tr> <?php
								$erow += 1;
							} ?>
						</tbody>
						<tfoot> <?php
							$sums = $this->common_model->custom_query(
								" 	SELECT
									SUM(`ODL_Amount`) AS ODL_Amount,
									SUM(`ODL_Price`) AS ODL_Price,
									SUM(`ODL_SumPrice`) AS ODL_SumPrice,
									SUM(`ODL_FullSumPrice`) AS ODL_FullSumPrice
									FROM `order_list`
									WHERE `$field_key` = $field_id AND `ODL_Allow` = '1' "
							);
							foreach ($sums as $key => $value) { ?>
								<tr class="hDiv">
									<th class="text-normal"><div class="text-left">รวมทั้งหมด</div></th>
									<th class="text-normal"><div class="text-left"></div></th>
									<th class="text-numeri"><div class="text-right"><?php echo $value['ODL_Amount']; ?></div></th>
									<th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_Price'], 2); ?></div></th>
									<th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_SumPrice'], 2); ?></div></th>
									<th class="text-numeri"><div class="text-right">฿<?php echo number_format($value['ODL_FullSumPrice'], 2); ?></div></th>
								</tr> <?php
							} ?>
						</tfoot>
					</table>
				</div>
			</div>

			<div class="mDiv">
				<div class="ftitle"><?php echo $titles[2]; ?></div>
			</div>
			<div class="main-table-box">
				<div class="form-div"> <?php
					$address = $this->common_model->custom_query(
						" 	SELECT * FROM `order_address`
							LEFT JOIN `districts`	ON `order_address`.`District_ID` 	= `districts`.`District_ID`
							LEFT JOIN `amphures` 	ON `order_address`.`Amphur_ID` 		= `amphures`.`Amphur_ID`
							LEFT JOIN `provinces` 	ON `order_address`.`Province_ID` 	= `provinces`.`Province_ID`
							WHERE `$field_key` = $field_id AND `$field_allow` = '1'
							LIMIT 1 "
					);
					if (uri_seg(4) === 'view') {
						foreach ($address as $key => $value) { ?>
							<div class="form-field-box odd">
								<div class="form-header-box">ชื่อ - นามสกุล: </div>
								<div class="form-display-box"><?php echo $value['OD_Name']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">โทรศัพท์: </div>
								<div class="form-display-box"><?php echo $value['OD_Tel']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">อีเมล: </div>
								<div class="form-display-box"><a href="mailto:<?php echo $value['OD_Email']; ?>"><?php echo $value['OD_Email']; ?></a></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">เลขที่ / ห้อง: </div>
								<div class="form-display-box"><?php echo $value['OD_hrNumber']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">หมู่บ้าน / อาคาร / คอนโด: </div>
								<div class="form-display-box"><?php echo $value['OD_VilBuild']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">หมู่ที่: </div>
								<div class="form-display-box"><?php echo $value['OD_VilNo']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">ตรอก / ซอย: </div>
								<div class="form-display-box"><?php echo $value['OD_LaneRoad']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">ถนน: </div>
								<div class="form-display-box"><?php echo $value['OD_Street']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">แขวง / ตำบล: </div>
								<div class="form-display-box"><?php echo $value['District_Name']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">เขต / อำเภอ: </div>
								<div class="form-display-box"><?php echo $value['Amphur_Name']; ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">จังหวัด: </div>
								<div class="form-display-box"><?php echo $value['Province_Name']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">รหัสไปรษณีย์: </div>
								<div class="form-display-box"><?php echo $value['Zipcode_Code']; ?></div>
							</div> <?php
						}
					}
					else if (uri_seg(4) === 'print') {
						foreach ($address as $key => $value) {
	                        $address = 'เลขที่/ห้อง '.$value['OD_hrNumber'];
	                        if ($value['OD_VilBuild']	!== '') 	$address .= ' หมู่บ้าน/อาคาร/คอนโด '.$value['OD_VilBuild'];
	                        if ($value['OD_VilNo'] 		!== '') 	$address .= ' หมู่ที่ '.$value['OD_VilNo'];
	                        if ($value['OD_LaneRoad'] 	!== '') 	$address .= ' ตรอก/ซอย '.$value['OD_LaneRoad'];
	                        if ($value['OD_Street'] 	!== '') 	$address .= ' ถนน'.$value['OD_Street'];
	                        if ($value['Province_ID'] 	=== '1') 	$address .= ' '.$value['District_Name'].' '.$value['Amphur_Name'].' '.$value['Province_Name'].' '.$value['Zipcode_Code'];
	                        else $address .= ' ตำบล'.$value['District_Name'].' อำเภอ'.$value['Amphur_Name'].' จังหวัด'.$value['Province_Name'].' '.$value['Zipcode_Code']; ?>
	                        <div class="form-field-box odd">
	                            <div class="form-display-box">ชื่อ - นามสกุล: <?php echo $value['OD_Name']; ?></div>
	                        </div>
	                        <div class="form-field-box even">
	                            <div class="form-display-box">ที่อยู่: <?php echo $address; ?></div>
	                        </div>
	                        <div class="form-field-box odd">
	                            <div class="form-display-box">โทรศัพท์: <?php echo $value['OD_Tel']; ?> &nbsp; อีเมล: <?php echo $value['OD_Email']; ?></div>
	                        </div> <?php
	                    }
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
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>