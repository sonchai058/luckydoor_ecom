<div id="order_detail">
	<div class="mDiv">
		<div class="ftitle"><?php echo $title; if ($date_start !== '' && $date_end !== '') echo ' (วันที่ '.formatDateThai(dateChange($date_start, 2)).' - วันที่ '.formatDateThai(dateChange($date_end, 2)).')'; ?></div>
	</div>
	<div class="main-table-box">
		<div class="bDiv">
			<table cellspacing="0" cellpadding="0" border="0">
				<?php $thai_month = array("0" => "", "1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม", "4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน", "7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม"); ?>
				<thead>
					<tr class="hDiv">
						<th><div class="text-center">ลำดับที่</div></th>
						<th><div class="text-center">วันที่เพิ่ม</div></th>
						<th><div class="text-center">วันที่แก้ไข</div></th>
						<!-- <th><div class="text-center">ผู้อัพเดท</div></th> -->
						<th><div class="text-center">รหัสใบสั่งซื้อ</div></th>
						<th><div class="text-center">ยอดการขาย</div></th>
					</tr>
				</thead>
				<tbody> <?php
					$erow = 1;
					foreach ($get_date as $key => $value) {
						$date_buffs = explode('-', $value['Date']);
						$date_addbf = explode('-', $value['DateAdd']);
						$date_value = (int)$date_buffs[2].' '.$thai_month[(int)$date_buffs[1]].' '.($date_buffs[0] + 543);
						$date_added = (int)$date_addbf[2].' '.$thai_month[(int)$date_addbf[1]].' '.($date_addbf[0] + 543); ?>
						<tr <?php if ($erow %2 === 0) { ?> class="erow" <?php } ?>>
							<td class="text-normal"><div class="text-left"><?php echo $erow; ?></div></td>
							<td class="text-normal"><div class="text-left"><?php echo $date_added; ?></div></td>
							<td class="text-normal"><div class="text-left"><?php echo $date_value; ?></div></td>
							<!-- <td class="text-normal"><div class="text-left"><?php echo $value['M_flName']; ?></div></td> -->
							<td class="text-normal"><div class="text-left"><?php echo $value['OD_Code']; ?></div></td>
							<td class="text-numeri"><div class="text-right">฿<?php echo number_format($price[$key], 2); ?></div></td>
						</tr> <?php
						$erow += 1;
					} ?>
				</tbody>
				<tfoot>
					<tr class="hDiv">
						<!-- <th class="text-normal" colspan="5"><div class="text-left">ยอดการขายทั้งหมด</div></th> -->
						<th class="text-normal" colspan="4"><div class="text-left">ยอดการขายทั้งหมด</div></th>
						<th class="text-numeri"><div class="text-right">฿<?php echo number_format($total, 2); ?></div></th>
					</tr>
					<tr class="hDiv">
						<?php $date_print = explode('-', date('Y-m-d')); ?>
						<!-- <th class="text-numeri" colspan="6"><div class="text-right">วันที่พิมพ์เอกสาร <?php echo (int)$date_print[2].' '.$thai_month[(int)$date_print[1]].' '.($date_print[0] + 543); ?></div></th> -->
						<th class="text-numeri" colspan="5"><div class="text-right">วันที่พิมพ์เอกสาร <?php echo (int)$date_print[2].' '.$thai_month[(int)$date_print[1]].' '.($date_print[0] + 543); ?></div></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>