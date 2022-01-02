<div id="order_detail">
	<div class="mDiv">
		<div class="ftitle"> <?php
			echo $title;
			if ($date_start !== '' && $date_end !== '')
				echo ' (วันที่ '.formatDateThai(dateChange($date_start, 2)).' - วันที่ '.formatDateThai(dateChange($date_end, 2)).')';
			else
				echo ' (วันที่ '.formatDateThai($get_date[0]['Date']).' - วันที่ '.formatDateThai($get_date[count($get_date) - 1]['Date']).')';
			?>
		</div>
	</div>
	<div class="main-table-box">
		<div class="bDiv">
			<table cellspacing="0" cellpadding="0" border="0">
				<?php $thai_month = array("0" => "", "1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม", "4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน", "7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม"); ?>
				<thead>
					<tr class="hDiv">
						<th><div class="text-center">ลำดับที่</div></th>
						<th><div class="text-center">รหัสสินค้า</div></th>
						<th><div class="text-center">ชื่อสินค้า</div></th>
						<th><div class="text-center">จำนวนที่ขายไป</div></th>
						<th><div class="text-center">ราคารวม</div></th>
					</tr>
				</thead>
				<tbody> <?php
					$erow 				= 1;
					$ODL_Amount 		= 0;
					$ODL_FullSumPrice 	= 0;
					foreach ($summary as $key => $values) {
						foreach ($values as $value) {
							$row['P_IDCode'] 			= $value->P_IDCode;
							$row['P_Name'] 				= $value->P_Name;
							$row['ODL_Amount'] 			= $value->ODL_Amount;
							$row['ODL_FullSumPrice']	= $value->ODL_FullSumPrice;
						} ?>
						<tr <?php if ($erow %2 === 0) { ?> class="erow" <?php } ?>>
							<td class="text-normal"><div class="text-left"><?php echo $erow; ?></div></td>
							<td class="text-normal"><div class="text-left"><?php echo $row['P_IDCode']; ?></div></td>
							<td class="text-normal"><div class="text-left"><?php echo $row['P_Name']; ?></div></td>
							<td class="text-numeri"><div class="text-right"><?php echo $row['ODL_Amount']; ?></div></td>
							<td class="text-numeri"><div class="text-right">฿<?php echo number_format($row['ODL_FullSumPrice'], 2); ?></div></td>
						</tr> <?php
						$erow 				+= 1;
						$ODL_Amount 		+= $row['ODL_Amount'];
						$ODL_FullSumPrice 	+= $row['ODL_FullSumPrice'];
					} ?>
				</tbody>
				<tfoot>
					<tr class="hDiv">
						<th class="text-normal" colspan="3"><div class="text-left">สินค้าที่ขายไปทั้งหมด</div></th>
						<th class="text-numeri"><div class="text-right"><?php echo $ODL_Amount; ?></div></th>
						<th class="text-numeri"><div class="text-right">฿<?php echo number_format($ODL_FullSumPrice, 2); ?></div></th>
					</tr>
					<tr class="hDiv">
						<?php $date_print = explode('-', date('Y-m-d')); ?>
						<th class="text-numeri" colspan="5"><div class="text-right">วันที่พิมพ์เอกสาร <?php echo (int)$date_print[2].' '.$thai_month[(int)$date_print[1]].' '.($date_print[0] + 543); ?></div></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>