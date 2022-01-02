<?php
	$site 		= $this->webinfo_model->getOnceWebMain();
	$success 	= array('7' => 'ส่งสินค้าแล้ว');
	$primary 	= array('5' => 'โอนเงินแล้ว', '6' => 'รอส่งสินค้า');
	$secondary 	= array('1' => 'ปกติ', '4' => 'รอโอนเงิน');
	$warning 	= array('2' => 'ระงับ');
	$alert 		= array('3' => 'ยกเลิก');
?>
<main>
	<?php $this->template->load('header/breadcrumb'); ?>
	<section>
		<div class="row">
			<?php $this->load->view('front-end/section'); ?>
			<div class="small-12 medium-expand columns">
				<div class="wrapper-orderstatus-title">
					<h1><?php echo $title; ?></h1>
					<?php echo $title; ?>
				</div> <?php
				if (!empty($order_data)) { ?>
					<h3>รายการที่ดำเนินการอยู่</h3>
					<table class="table-order scroll">
						<thead>
							<tr>
								<th class="width-10">รายการสั่งซื้อ</th>
								<th class="width-15">วัน / เดือน / ปี</th>
								<th class="width-15">ยอดสุทธิ</th>
								<th class="width-15">สถานะ</th>
								<th class="width-15">หมายเลขพัสดุ</th>
								<th class="width-5"></th>
							</tr>
						</thead>
						<tbody> <?php
							foreach ($order_data as $key => $value) { ?>
								<tr>
									<td># <?php echo $value['OD_Code']; ?></td>
									<td><?php echo date('d/m/Y', strtotime($value['OD_DateTimeUpdate'])); ?></td>
									<td>฿<?php echo number_format($value['OD_FullSumPrice'], 2, '.', ','); ?></td>
									<td><span class="<?php if (in_array($order_status[$key], $success)) echo 'success'; else if (in_array($order_status[$key], $primary)) echo 'primary'; else if (in_array($order_status[$key], $secondary)) echo 'secondary'; else if (in_array($order_status[$key], $warning)) echo 'warning'; else if (in_array($order_status[$key], $alert)) echo 'alert'; ?> order-badge"><?php echo $order_status[$key]; ?></span></td>
									<td> <?php
										// if (in_array($order_status[$key], $secondary)) {
										if ($order_status[$key] === 'รอโอนเงิน') { ?>
											<a class="btn-history-transfer" href="<?php echo base_url('member/transfer/'.$value['OD_ID']); ?>">แจ้งโอนเงิน</a> <?php
										}
										else if (in_array($order_status[$key], $primary) || in_array($order_status[$key], $success))
											echo $value['OD_EmsCode']; ?>
									</td>
									<td><a class="btn-history-detail" href="<?php echo base_url('member/historydetail/'.$value['OD_ID']); ?>">ดูข้อมูล</a></td>
								</tr> <?php
							} ?>
						</tbody>
					</table>
				<br> <?php
				}
				else if (!empty($order_history)) { ?>
					<h3>ประวัติการซื้อ / สั่งซื้อ</h3>
					<table class="table-order scroll">
						<thead>
							<tr>
								<th class="width-10">รายการสั่งซื้อ</th>
								<th class="width-15">วัน / เดือน / ปี</th>
								<th class="width-15">ยอดสุทธิ</th>
								<th class="width-15">สถานะ</th>
								<th class="width-15">หมายเลขพัสดุ</th>
								<th class="width-5"></th>
							</tr>
						</thead>
						<tbody> <?php
							foreach ($order_history as $key => $value) { ?>
								<tr>
									<td># <?php echo $value['OD_Code']; ?></td>
									<td><?php echo date('d/m/Y', strtotime($value['OD_DateTimeUpdate'])); ?></td>
									<td>฿<?php echo number_format($value['OD_FullSumPrice'], 2, '.', ','); ?></td>
									<td><span class="<?php if (in_array($order_status_history[$key], $success)) echo 'success'; else if (in_array($order_status_history[$key], $primary)) echo 'primary'; else if (in_array($order_status_history[$key], $secondary)) echo 'secondary'; else if (in_array($order_status_history[$key], $warning)) echo 'warning'; else if (in_array($order_status_history[$key], $alert)) echo 'alert'; ?> order-badge"><?php echo $order_status_history[$key]; ?></span></td>
									<td><?php if (in_array($order_status_history[$key], $primary) || in_array($order_status_history[$key], $success)) echo $value['OD_EmsCode']; ?></td>
									<td><a class="btn-history-detail" href="<?php echo base_url('member/historydetail/'.$value['OD_ID']); ?>">ดูข้อมูล</a></td>
								</tr> <?php
							} ?>
						</tbody>
					</table>
				<br> <?php
				}
				// else if (empty($order_data)) { ?>
					<!-- <h3>รายการที่ดำเนินการอยู่</h3> -->
					<!-- <blockquote><cite>ไม่มีรายการที่ดำเนินการอยู่</cite></blockquote> -->
					<!-- <br>  -->
					<?php
				// }
				// else if (empty($order_history)) { ?>
					<!-- <h3>ประวัติการซื้อ / สั่งซื้อ</h3> -->
					<!-- <blockquote><cite>ยังไม่มีประวัติการซื้อ / สั่งซื้อ</cite></blockquote> -->
					<!-- <br>  -->
					<?php
				// } ?>
			</div>
		</div>
	</section>
</main>