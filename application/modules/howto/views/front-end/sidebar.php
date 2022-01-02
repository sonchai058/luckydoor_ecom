<div class="small-12 medium-3 columns">
	<ul class="menu vertical categories">
		<li class="categoires-head"><h3>ออร์เดอร์และการชำระเงิน</h3></li>
		<li><a href="<?php echo base_url('howto/supplying'); ?>" 	class="categoires-title <?php if (uri_seg(1) === 'howto' &&  uri_seg(2) === 'supplying'		) echo 'active'; ?>">วิธีการซื้อสินค้า</a></li>
		<li><a href="<?php echo base_url('howto'); ?>" 				class="categoires-title <?php if (uri_seg(1) === 'howto' && !uri_seg(2)						) echo 'active'; ?>">วิธีการชำระเงิน</a></li>
		<li><a href="<?php echo base_url('howto/verify'); ?>" 		class="categoires-title <?php if (uri_seg(1) === 'howto' &&  uri_seg(2) === 'verify'		) echo 'active'; ?>">การตรวจสอบสถานะการสั่งซื้อ</a></li>
		<!-- <li><a href="<?php echo base_url('howto/ordercancel'); ?>" 	class="categoires-title <?php if (uri_seg(1) === 'howto' &&  uri_seg(2) === 'ordercancel'	) echo 'active'; ?>">ยกเลิกการสั่งซื้อ</a></li> -->
	</ul>
</div>