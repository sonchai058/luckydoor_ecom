<div class="small-12 medium-4 large-3 columns">
	<ul class="menu vertical categories">
        <li><?php echo get_session('C_flName'); ?></li>
    </ul>
    <ul class="menu vertical categories">
        <li class="categoires-head"><h3>บัญชีของฉัน</h3></li>
        <li><a href="<?php echo base_url('member/account'); ?>" 	class="categoires-title <?php if (uri_seg(1) === 'member' && uri_seg(2) === 'account'	) echo 'active'; ?>"><i class="fa fa-file-text-o"></i> ข้อมูลส่วนตัว</a></li>
        <li><a href="<?php echo base_url('member/history'); ?>" 	class="categoires-title <?php if (uri_seg(1) === 'member' && uri_seg(2) === 'history' || uri_seg(2) === 'historydetail'	|| uri_seg(2) === 'transfer') echo 'active'; ?>"><i class="fa fa-truck"></i> ติดตามสถานะคำสั่งซื้อ</a></li>
        <li><a href="<?php echo base_url('member/record'); ?>"		class="categoires-title <?php if (uri_seg(1) === 'member' && uri_seg(2) === 'record'	) echo 'active'; ?>"><i class="fa fa-history"></i> ประวัติการซื้อ/สั่งซื้อ</a></li>
        <li><a href="<?php echo base_url('member/wishlist'); ?>" 	class="categoires-title <?php if (uri_seg(1) === 'member' && uri_seg(2) === 'wishlist'	) echo 'active'; ?>"><i class="fa fa-heart"></i> รายการสินค้าที่ชอบ</a></li>
    </ul>
</div>