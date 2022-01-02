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
				<td>หมายเลขสิ่งของฝากส่งทางไปรษณีย์: </td>
				<td><?php echo $OD_EmsCode; ?></td>
			</tr>
			<tr>
				<td>สถานะใบสั่งซื้อ: </td>
				<td class="po-status"><?php echo $OD_Allow; ?></td>
			</tr>
		</table>
	</p>
	<p>** ท่านสามารถนำหมายเลขสิ่งของฝากส่งทางไปรษณีย์ ไปตรวจสอบได้ที่เว็บไซต์ของไปรษณีย์ไทย โดย<a href="http://track.thailandpost.co.th/" target="_blank">คลิกที่นี่</a></p> <?php
	if ($document_type === 'html' && $document_type !== 'pdf') { ?>
		<p><a href="<?php echo base_url('cart/ordercodeprint/'.$order['OD_ID']); ?>" target="_blank">คลิกที่นี่</a> เพื่อดาวน์โหลดเอกสารแนบ</p> <?php
	} ?>
</body>
</html>