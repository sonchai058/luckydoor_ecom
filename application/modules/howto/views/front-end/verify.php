<main>
	<?php $this->template->load('header/breadcrumb'); ?>

	<section>
		<div class="row">
			<?php $this->load->view('front-end/sidebar'); ?>

			<div class="small-12 medium-9 large-7 columns">
				<h2 class="text-title">การตรวจสอบสถานะการสั่งซื้อ</h2>
				<div class="transport-wrapper">
					<h4><i class="fa fa-angle-double-right"></i> ฉันจะตรวจสอบสถานะสินค้าของฉันได้อย่างไร ?</h4>
					<p>ท่านสามารถตรวจสอบสถานะรายการสั่งซื้อออนไลน์ของท่านได้ 24 ชั่วโมง / 7 วัน โดยปฎิบัติตามขั้นตอนต่อไปนี้</p>
					<ol class="service-ol" style="margin-left: 40px;">
						<li>ไปที่ <a href="<?php echo base_url('member/transfercustom'); ?>" class="link">แจ้งโอนเงิน</a></li>
						<li>ใส่หมายเลขคำสั่งซื้อของท่าน และอีเมล์</li>
						<li>กด <bold>"ค้นหา"</bold> เพื่อดำเนินการ</li>
					</ol>
					<br>

					<h4><i class="fa fa-angle-double-right"></i> ฉันไม่สามารถตรวจสอบสถานะสินค้าได้ ฉันควรทำอย่างไร ?</h4>
					<p>ข้อมูลของหมายเลขติดตามสินค้าอาจจะยังไม่ได้ถูกเปิดการใช้งาน โดยหมายเลขติดตามสินค้าจะสามารถใช้งานได้ภายใน 1-2 วันทำการข้างหน้า เมื่อบริษัทขนส่งที่ร่วมงานกับเราได้ทำการอัพเดทข้อมูลแล้ว</p>
					<br>
					<p>แต่ท่านสามารถตรวจสอบสถานะรายการสั่งซื้อของท่านได้ที่เครื่องมือติดตามสถานะคำสั่งซื้อของเรา <a href="<?php echo base_url('member/transfercustom'); ?>" class="link">คลิกที่นี่</a> ระบบของ Luckydoor จะปรับปรุงข้อมูลเป็นรายวัน เพื่อที่จะให้บริการตรวจสอบสถานะคำสั่งซื้อที่ดีที่สุดแก่ท่าน</p>
					<br>
					<p>หากหลังจาก 1 วันทำการ ท่านยังไม่สามารถใช้หมายเลขพัสดุได้ กรุณาติดต่อเรา <a href="<?php echo base_url('contactus'); ?>" class="link">คลิกที่นี่</a> เราจะช่วยเหลือท่านทันที</p>
				</div>
			</div>

		</div>
	</section>
</main>