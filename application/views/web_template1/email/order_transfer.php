<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title> <?php
	if ($document_type === 'html' && $document_type !== 'pdf') { ?>
		<style>
			.email-order-list	{ width: 100%; 					}
			.po-code 			{ color: #4078C0; 				}
			.po-status 			{ color: #BD2C00; 				}
			th 					{ background-color: #E6E6E6; 	}
		</style> <?php
	} ?>
</head>
<body>
	<p>
		<table>
			<tr>
				<td>รหัสใบสั่งซื้อ: </td>
				<td class="po-code"><?php echo $OD_Code; ?></td>
			</tr>
			<tr>
				<td>ชื่อธนาคาร: </td>
				<td><?php echo $B_Name; ?></td>
			</tr>
			<tr>
				<td>ช่องทางชำระเงิน: </td>
				<td><?php echo $OT_Payment; ?></td>
			</tr>
			<tr>
				<td>วันเวลาที่โอนเงิน: </td>
				<?php
					$day 	= date('d', strtotime($OT_DateTimeUpdate));
					$month 	= date('m', strtotime($OT_DateTimeUpdate));
					$year 	= date('Y', strtotime($OT_DateTimeUpdate));
					$hour 	= date('H', strtotime($OT_DateTimeUpdate));
					$minute	= date('i', strtotime($OT_DateTimeUpdate));
					$second = date('s', strtotime($OT_DateTimeUpdate));
				?>
				<td><?php echo $day.'-'.$month.'-'.($year + 543).' '.$hour.':'.$minute.':'.$second; ?></td>
			</tr>
			<tr>
				<td>จำนวนเงิน: </td>
				<td><?php echo number_format($OT_FullSumPrice, 2, '.', ','); ?></td>
			</tr>
		</table>
	</p>
	<p>** ขณะนี้ได้รับข้อมูลการโอนเงินของท่านเรียบร้อยแล้ว ทางเราจะรีบตรวจสอบและส่งอีเมลแจ้งให้ทราบอีกครั้งหนึ่ง ขอบคุณค่ะ</p> <?php
	if ($document_type === 'html' && $document_type !== 'pdf') { ?>
		<p><a href="<?php echo base_url('cart/ordertransferprint/'.$OD_ID); ?>" target="_blank">คลิกที่นี่</a> เพื่อดาวน์โหลดเอกสารแนบ</p> <?php
	} ?>
</body>
</html>