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
					$OD_Status 	= array('1' => 'ปกติ', '2' => 'Pre-order');
					$OD_Allow 	= $this->order_status_model->getOnceWebMain();
					$OT_Payment = array('1' => 'โอนผ่านธนาคาร', '2' => 'ชำระผ่านบัตร', '3' => 'ชำระผ่านเคาเตอร์เซอร์วิส', '4' => 'อื่นๆ');
					foreach ($query as $key => $value) {
						$transfer 	= rowArray($this->common_model->get_where_custom('order_transfer', 	'OD_ID', 	$value['OD_ID']));
						if (count($transfer) > 0)
							$banks 	= rowArray($this->common_model->get_where_custom('bank', 			'B_ID', 	$transfer['B_ID']));
						else
							$banks 	= array('B_Img' => '', 'B_Name' => ''); ?>
						<div class="form-field-box odd">
							<div class="form-header-box">รหัสใบสั่งซื้อ: </div>
							<div class="form-display-box"><?php echo $value['OD_Code']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">รหัส EMS: </div>
							<div class="form-display-box"><?php echo $value['OD_EmsCode']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">ธนาคาร: </div>
							<div class="form-display-box"><?php if (count($transfer) > 0) { ?><img src="<?php echo base_url('assets/admin/images/bank/'.$banks['B_Img']); ?>" alt="<?php echo $banks['B_Name']; ?>" title="<?php echo $banks['B_Name']; ?>"><?php } ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">ช่องทางชำระเงิน: </div>
							<div class="form-display-box"><?php if (count($transfer) > 0) echo $OT_Payment[$transfer['OT_Payment']]; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">หมายเหตุ/รายละเอียด: </div>
							<div class="form-display-box"><?php if (count($transfer) > 0) echo $transfer['OT_Descript']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">เงินที่ต้องชำระ: </div>
							<div class="form-display-box">฿<?php echo number_format($value['OD_FullSumPrice'], 2, '.', ','); ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">เงินที่แจ้ง: </div>
							<div class="form-display-box"><span <?php if (count($transfer) > 0 && $transfer['OT_FullSumPrice'] > $value['OD_FullSumPrice']) { ?> style="color:red;font-weight:bold" <?php } ?>><?php if (count($transfer) > 0) echo '฿'.number_format($transfer['OT_FullSumPrice'], 2, '.', ','); if (count($transfer) > 0 && $value['OD_FullSumPrice'] > $transfer['OT_FullSumPrice']) echo ' <span style="color:red;font-style:italic">(โอนเงินไม่ครบ)</span>'; ?></span></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">วันที่แจ้ง: </div>
							<div class="form-display-box"><?php if (count($transfer) > 0) echo formatDateThai($transfer['OT_DateTimeAdd']).' '.date('H:i:s', strtotime($transfer['OT_DateTimeAdd'])); ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">สถานะ: </div>
							<div class="form-display-box"><?php echo $OD_Allow[$value['OD_Allow']]; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">หลักฐานการโอน: </div>
							<div class="form-display-box"><?php if (count($transfer) > 0) { ?><a class="fancybox" href="<?php echo base_url('assets/uploads/user_uploads_img/'.$transfer['OT_ImgAttach']); ?>">คลิกที่นี่</a><?php } ?></div>
						</div> <?php
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