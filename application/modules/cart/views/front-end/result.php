<main>
    <?php
        $this->template->load('header/breadcrumb');
        $grand_total = 0;
    ?>
    <section>
    <style>
		.email-order-list	{ width: 100%; 					}
		.po-code 			{ color: #4078C0; 				}
		.po-status 			{ color: #BD2C00; 				}
		th 					{ background-color: #E6E6E6; 	}
	</style>
	<div class="row">
		<div class="columns small-12">

			<h4>การสั่งซื้อเสร็จสิ้น</h4>
			<p>
				<b>โอนเงินเข้าบัญชีธนาคาร</b><br>
				ธนาคาร ไทยพาณิชย์, เลขที่บัญชี: 468-0-03134-4 , ชื่อบัญชี: บจก. สินเพิ่มพูนค้าไม้, สาขา: บิ๊กซี หางดง2<br>
			</p>
			<p>แจ้งโอนเงิน <a href="http://luckydoor.co.th/member/transfercustom" target="_blank">คลิกที่นี่</a></p>
			<br>
			<h4>รายละเอียด</h4>
			<p>
				<table>
					<tr>
						<td>วันเวลาที่สั่งซื้อ: </td>
						<?php $day = date('d'); $month = date('m'); $year = date('Y') + 543; $hour = date('H'); $minute = date('i'); $second = date('s'); ?>
						<td><?php echo $day.'-'.$month.'-'.$year.' '.$hour.':'.$minute.':'.$second; ?></td>
					</tr>
					<tr>
						<td>รหัสใบสั่งซื้อ: </td>
						<td class="po-code"><?php echo $order['OD_Code']; ?></td>
					</tr>
					<tr>
						<td>สถานะใบสั่งซื้อ: </td>
						<td class="po-status"><?php echo $order['OD_Allow']; ?></td>
					</tr>
				</table>
			</p>
			<p>
				<b>ที่อยู่สำหรับจัดส่งสินค้า</b>
				<table>
					<tr>
						<td>ชื่อ-นามสกุล: </td>
						<td><?php echo $order_address['OD_Name']; ?></td>
					</tr>
					<tr>
						<td>ที่อยู่: </td>
						<td><?php echo $order_address['OD_Address']; ?></td>
					</tr>
					<tr>
						<td>เบอร์โทรศัพท์: </td>
						<td><?php echo $order_address['OD_Tel']; ?></td>
					</tr>
				</table>
			</p>
			<br>
			<p>
				<h4>รายการสินค้า</h4>
						<table class="table-cart" width="70%">
                            <thead>
                                <tr>
                                   	<th align="center">ลำดับที่</th>
									<th align="center">รูป</th>
									<th align="center">ชื่อ</th>
									<th align="center">ราคา</th>
									<th align="center">จำนวน</th>
									<th align="center">ราคารวม</th>
                                </tr>
                            </thead>
                            <tbody> <?php
						foreach ($order_list as $key => $value) { ?>
							<tr>
								<td align="center"><?php echo ($key + 1); ?></td>
								<td align="center"><img width="50" src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['P_Img']); ?>" alt="<?php echo $value['P_Name']; ?>" title="<?php echo $value['P_Name']; ?>"></td>
								<td align="left"><?php echo $value['P_IDCode'].' '.trim($value['P_Name']); ?></td>
								<td align="center"><?php echo number_format($value['ODL_Price'], 2, '.', ','); ?></td>
								<td align="center"><?php echo $value['ODL_Amount']; ?></td>
								<td align="right"><?php echo number_format($value['ODL_FullSumPrice'], 2, '.', ','); ?></td>
							</tr> <?php
						} ?>
					</tbody>
                           
                            <tfoot>
								<tr style="border-bottom: 0px;text-align:right">
									<th colspan="5" style="text-align:right">ยอดรวม</th>
									<th colspan="1" style="text-align:right"><?php echo number_format($order['OD_SumPrice'], 2, '.', ','); ?></th>
								</tr>
								<tr style="border-bottom: 0px">
									<th colspan="5" style="text-align:right">ขนส่งสินค้า</th>
									<?php $OD_Transfer = $order['OD_FullSumPrice']; if ($order['OD_FullSumPrice'] > $order['OD_SumPrice']) $OD_Transfer = $order['OD_FullSumPrice'] - $order['OD_SumPrice']; ?>
									<th colspan="1" style="text-align:right"><?php echo number_format($OD_Transfer, 2, '.', ','); ?></th>
								</tr>
								<tr style="border-bottom: 0px">
									<th colspan="5" style="text-align:right">ยอดสุทธิ</th>
									<th colspan="1" style="text-align:right"><?php echo number_format($order['OD_FullSumPrice'], 2, '.', ','); ?></th>
								</tr>
							</tfoot>
                        </table>

			</p>
			
		</div>
		
	</div>
	
    </section>
</main>



	