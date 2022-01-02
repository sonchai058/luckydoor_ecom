<div class="small-12 medium-3 columns">
	<ul class="menu vertical categories">
		<li class="categoires-head"><h3></h3></li>
		<!-- <li><a href="<?php echo base_url('aboutus'); ?>" 			class="categoires-title <?php if (uri_seg(1) === 'aboutus' && !uri_seg(2)					) echo 'active'; ?>">เกี่ยวกับเรา</a></li> -->
		<li><a href="<?php echo base_url('aboutus/terms'); ?>" 		class="categoires-title <?php if (uri_seg(1) === 'aboutus' &&  uri_seg(2) === 'terms'		) echo 'active'; ?>">ข้อตกลงและเงื่อนไข</a></li>
		<li><a href="<?php echo base_url('aboutus/privacy'); ?>" 	class="categoires-title <?php if (uri_seg(1) === 'aboutus' &&  uri_seg(2) === 'privacy'		) echo 'active'; ?>">นโยบายความเป็นส่วนตัว</a></li>
<!-- 		<li><a href="<?php echo base_url('aboutus/storelist'); ?>" 	class="categoires-title <?php if (uri_seg(1) === 'aboutus' &&  uri_seg(2) === 'storelist'	) echo 'active'; ?>">รายชื่อร้านค้า</a></li> -->
	</ul>
</div>