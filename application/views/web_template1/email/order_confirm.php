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
				<td>วันเวลาที่สั่งซื้อ: </td>
				<?php
					$day 	= date('d', strtotime($OD_DateTimeAdd));
					$month 	= date('m', strtotime($OD_DateTimeAdd));
					$year 	= date('Y', strtotime($OD_DateTimeAdd));
					$hour 	= date('H', strtotime($OD_DateTimeAdd));
					$minute	= date('i', strtotime($OD_DateTimeAdd));
					$second = date('s', strtotime($OD_DateTimeAdd));
				?>
				<td><?php echo $day.'-'.$month.'-'.($year + 543).' '.$hour.':'.$minute.':'.$second; ?></td>
			</tr>
			<tr>
				<td>รหัสใบสั่งซื้อ: </td>
				<td class="po-code"><?php echo $OD_Code; ?></td>
			</tr>
			<tr>
				<td>ยอดสุทธิ: </td>
				<td><?php echo number_format($OD_FullSumPrice, 2, '.', ','); ?></td>
			</tr>
		</table>
	</p>
	<p>แจ้งโอนเงิน <a href="http://luckydoor.co.th/member/transfercustom" target="_blank">คลิกที่นี่</a></p>
	<p>
		<b>โอนเงินเข้าบัญชีดังต่อไปนี้</b><br>
		ธนาคาร ไทยพาณิชย์, เลขที่บัญชี: 468-0-03134-4 , ชื่อบัญชี: บจก. สินเพิ่มพูนค้าไม้, สาขา: บิ๊กซี หางดง2<br>
	</p>
	<p>
		** หมายเหตุ: **<br>
		- โปรดโอนเงินให้ครบตามยอดสุทธิที่แจ้งไว้ในอีเมล<br>
		- หากท่านโอนเงินแล้ว โปรดแจ้งชำระเงินที่เว็บไซต์ภายใน 2 วันนับจากวันที่ท่านได้รับอีเมลฉบับนี้<br>
		- หากท่านไม่แจ้งโอนเงิน ภายในวันเวลาที่กำหนด รายการสั่งซื้อสินค้าของท่านจะถูกยกเลิกทันที ขอบคุณค่ะ<br>
	</p> <?php
	if ($document_type === 'html' && $document_type !== 'pdf') { ?>
		<p><a href="<?php echo base_url('cart/orderconfirmprint/'.$OD_ID); ?>" target="_blank">คลิกที่นี่</a> เพื่อดาวน์โหลดเอกสารแนบ</p> <?php
	} ?>
</body>
</html>