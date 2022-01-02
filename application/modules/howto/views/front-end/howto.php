<main>
	<?php $this->template->load('header/breadcrumb'); ?>

	<section>
		<div class="row">
			<?php $this->load->view('front-end/sidebar'); ?>

			<div class="small-12 medium-expand columns">
				<div class="wrapper-h2p-title">
					<h2 class="text-title">วิธีการชำระเงิน</h2>
					<h4>Luckydoor มีวิธีการชำระเงินแบบใดบ้าง</h4>
				</div>
				<h4><i class="fa fa-angle-double-right"></i> บริการรับชำระด้วยบัตรเครดิตออนไลน์ (PAYSBUY Direct)</h4>
				<ol class="h2p-list">
					<li><a  target="_blank" href="https://www.paysbuy.com/help-detail-40.aspx"><i class="fa fa-dot-circle-o"></i> ตัวอย่างการชำระเงินผ่านบัตรเครดิต</a></li>
				</ol>
				<br>

<!-- 				<h4><i class="fa fa-angle-double-right"></i> บริการรับชำระด้วยเงินสดที่เคาน์เตอร์ / ตู้ ATM</h4>
					<ol class="h2p-list">
						<li><i class="fa fa-dot-circle-o"></i> <a href="#!">ตัวอย่างการชำระเงินผ่าน / บิ๊กซี / เทสโก้ โลตัส / Cen Pay / จัสท์เพย์ / เอ็มเปย์ / กรุงศรี ATM / ไทยพาณิชย์ / กรุงไทย</a></li>
						<li><a href="#!"><i class="fa fa-dot-circle-o"></i> ตัวอย่างการชำระเงินผ่านตู้เอทีเอ็ม ธนาคารกรุงศรีอยุธยา</a></li>
					</ol>
				<br> -->

				<h4><i class="fa fa-angle-double-right"></i> บริการรับชำระด้วยบัญชีธนาคารออนไลน์</h4>
				<ol class="h2p-list">
					<!-- <li><a target="_blank" href="http://www.scb.co.th/th/personal-banking/bill-payment-top-up/bill-payment"><img class="img-middle" src="<?php echo base_url('assets/images/bank/32x32/SCB-2.png');?>" alt="SCB"> ตัวอย่างการชำระเงินผ่านบัญชีธนาคารไทยพาณิชย์</a></li> -->
					<li><a href="#bill-scb" class="myModal"><img class="img-middle" src="<?php echo base_url('assets/images/bank/32x32/SCB-2.png');?>" alt="SCB"> การชำระเงินผ่านบัญชีธนาคารไทยพาณิชย์</a></li>
					<!-- <li><a target="_blank" href="https://www.tmbbank.com/howto/e-banking/pay-bill.php"><img class="img-middle" src="<?php echo base_url('assets/images/bank/32x32/TMB.png');?>" alt="TMB"> ตัวอย่างการชำระเงินผ่านบัญชีธนาคารทหารไทย</a></li> -->
					<li><a href="#bill-tmb" class="myModal"><img class="img-middle" src="<?php echo base_url('assets/images/bank/32x32/TMB.png');?>" alt="TMB"> การชำระเงินผ่านบัญชีธนาคารทหารไทย</a></li>
					<!-- <li><a href="#!"><img class="img-middle" src="<?php echo base_url('assets/images/bank/32x32/KRUNGSRI-2.png');?>" alt="KRUNGSRI"> ตัวอย่างการชำระเงินผ่านบัญชีธนาคารกรุงศรีฯ</a></li> -->
					<!-- <li><a href="#!"><img class="img-middle" src="<?php echo base_url('assets/images/bank/32x32/BANGKOK-2.png');?>" alt="BANGKOK"> ตัวอย่างการชำระเงินผ่านบัญชีธนาคารกรุงเทพ</a></li> -->
				</ol>		
				<!-- <a href="#bill-scb" class="myModal">Click Me For A Modal</a> -->
				<!-- <a href="#bill-tmb" class="myModal">Click Me For A Modal</a> -->

				<div style="display:none">
					<div id="bill-scb">
						<h3>การชำระเงินผ่านบัญชีธนาคารไทยพาณิชย์</h3>
						<hr>
						<span style="font-weight: bold;font-size: 19px;">ชื่อบัญชี : </span>บจก. สินเพิ่มพูนค้าไม้<br>
						<span style="font-weight: bold;font-size: 19px;">เลขที่บัญชี : </span>468-0-03134-4<br>
						<span style="font-weight: bold;font-size: 19px;">Merchant ID : </span>0910986010<br>
					</div>
					<div id="bill-tmb">
						<h3>การชำระเงินผ่านบัญชีธนาคารทหารไทย</h3>
						<hr>
						<!-- <span style="font-weight: bold;font-size: 19px;">ชื่อบัญชี : </span>บจก. สินเพิ่มพูนค้าไม้<br> -->
						<!-- <span style="font-weight: bold;font-size: 19px;">เลขที่บัญชี : </span>468-0-03134-4<br> -->
						<span style="font-weight: bold;font-size: 19px;">Merchant ID : </span>110326527<br>
					</div>
				</div>
				
			</div>
		</div>
	</section>
	<link rel="stylesheet" href="<?php echo base_url('assets/plugin/fancybox/source/jquery.fancybox.css'); ?>">
	<script src="<?php echo base_url('assets/plugin/fancybox/source/jquery.fancybox.js'); ?>"></script>
	<script type="text/javascript">
		$("a.myModal").fancybox({
			// modal: true,
			minWidth: 400,
			minHeight: 200,
			// 'transitionIn'	:	'elastic',
			// 'transitionOut'	:	'elastic',
			// 'speedIn'		:	600, 
			// 'speedOut'		:	200, 
			// 'overlayShow'	:	false,
		});
	</script>
</main>