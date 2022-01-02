<?php $site = $this->webinfo_model->getOnceWebMain(); ?>
<footer class="footer">
	<div class="row">
		<div class="small-6 medium-6 large-3 columns">
			<h3>ฝ่ายบริการลูกค้า</h3>
			<hr class="hr-title-2">
			<ul class="footer-widget">
				<li><a href="<?php echo base_url('service'); ?>" 			title="ศูนย์ให้ความช่วยเหลือ">ศูนย์ให้ความช่วยเหลือ</a></li>
				<li><a href="<?php echo base_url('service/transports'); ?>" title="การขนส่ง และการจัดส่ง">การขนส่ง และการจัดส่ง</a></li>
				<!-- <li><a href="<?php echo base_url('service/refunds'); ?>" 	title="การคืนสินค้า และการคืนเงิน">การคืนสินค้า และการคืนเงิน</a></li> -->
				<!-- <li><a href="<?php echo base_url('service/returns'); ?>" 	title="วิธีการคืนสินค้า">วิธีการคืนสินค้า</a></li> -->
			</ul>
		</div>
		<div class="small-6 medium-6 large-3 columns">
			<h3>Luckydoor</h3>
			<hr class="hr-title-2">
			<ul class="footer-widget">
				<li><a href="<?php echo base_url('aboutus'); ?>" 			title="เกี่ยวกับ">เกี่ยวกับ</a></li>
				<li><a href="<?php echo base_url('aboutus/terms'); ?>" 		title="ข้อตกลงและเงืื่อนไข">ข้อตกลงและเงื่อนไข</a></li>
				<li><a href="<?php echo base_url('aboutus/privacy'); ?>" 	title="นโยบายความเป็น่สวนตัว">นโยบายความเป็นส่วนตัว</a></li>
				<li><a href="<?php echo base_url('control'); ?>" 			title="สำหรับเจ้าหน้าที่" target="_blank">สำหรับเจ้าหน้าที่</a></li>
				<!-- <li><a href="<?php echo base_url('aboutus/storelist'); ?>" 	title="รายชื่อร้านค้า">รายชื่อร้านค้า</a></li> -->
			</ul>
		</div>
		<div class="small-12 medium-12 large-4 large-offset-2 columns">
			<h3>วิธีชำระเงิน</h3>
			<hr class="hr-title-2">
			<ul class="pay-icon">
				<li><a href="#"><img src="<?php echo base_url('assets/images/payment/visa-1@2x.png'); ?>" alt="visa"></a></li>
				<li><a href="#"><img src="<?php echo base_url('assets/images/payment/mastercard@2x.png'); ?>" alt="mastercard"></a></li>
				<li><a href="#"><img src="<?php echo base_url('assets/images/payment/maestro@2x.png'); ?>" alt="maestro"></a></li>
				<li><a href="#"><img src="<?php echo base_url('assets/images/payment/paypal@2x.png'); ?>" alt="paypal"></a></li>
				<li><a href="#"><img src="<?php echo base_url('assets/images/payment/JCB_Cards.png'); ?>" alt="JCB"></a></li>
				<li><a href="#"><img src="<?php echo base_url('assets/images/bank/32x32/scb1.png'); ?>" alt="SCB"></a></li>
				<li><a href="#"><img src="<?php echo base_url('assets/images/bank/32x32/tmb1.png'); ?>" alt="TMB"></a></li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<h3>Partnership</h3>
			<hr class="hr-title-2">
			<ul class="partner">
				<!-- <li><a target="_blank" href="http://www.homeworks.co.th"><img src="<?php echo base_url('assets/images/partner/homeworks.png'); ?>" alt="homeworks"></a></li> -->
				<!-- <li><a target="_blank" href="http://www.globalhouse.co.th"><img src="<?php echo base_url('assets/images/partner/globalhouse.png'); ?>" alt="globalhouse"></a></li> -->
				<!-- <li><a target="_blank" href="http://www.thaiwatsadu.com"><img src="<?php echo base_url('assets/images/partner/thaiwatsadu.png'); ?>" alt="thaiwatsadu"></a></li> -->
				<li><a target="_blank" href="http://www.homepro.co.th/"><img src="<?php echo base_url('assets/images/partner/homepro.png'); ?>" alt="homepro"></a></li>
			</ul>
		</div>
		<div class="small-12 medium-6 large-4 large-offset-2 columns">
			<div class="home-adr _dotranslate">
				<?php $this->template->load('content/address'); ?>
			</div>
			<div class="home-adr _notranslate notranslate">
				<div class="adr-1">
					<p>
						Lucky door Trading Co., Ltd.<br>
						125/250 Moo 3 Rattanathibet Road Tambon Sai-Ma Amphoe Mueang Nonthaburi.
						<a class="help" href="<?php echo base_url('assets/images/map/luckydoor.jpg'); ?>" target="_blank">>> Click to view the map.</a>
					</p>
					<p>
						Phone: (029) 776-3224 &nbsp; Fax: (029) 776-323.
					</p>
				</div>
				<div class="adr-2">
					<p>
						J. Wood Industry Co., Ltd.<br>
						61 Moo 4 Tambon Buakkhang, Sankamphaeng district, Chiangmai
						<a class="help" href="<?php echo base_url('assets/images/map/jwood.jpg'); ?>" target="_blank">>> Click to view the map.</a>
					</p>
					<p>
						Phone: (053) 433-224 &nbsp; Fax: (053) 433-223.
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<h5>COPYRIGHT © 2015 BY <?php echo strtoupper($site['WD_EnName']); ?> ALL RIGHT RESERVED. POWERD BY <a class="footer-url" href="https://www.facebook.com/ServiceTechnologyConsultant" target="_blank">SERVICE TECHNOLOGY CONSULTANT</a></h5>
	</div>
</footer>