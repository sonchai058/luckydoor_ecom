<div class="small-12 medium-3 large-2 columns">
    <!-- SideMenu -->
    <ul class="menu vertical product-menu" data-accordion-menu>
        <li class="menu-head"><h3>สินค้า</h3></li>
        <li><a href="<?php echo base_url('product'); ?>" class="<?php if (uri_seg(1) === 'product' && !uri_seg(2)) echo 'menu-title'; ?>">Products</a></li> <?php
        foreach ($type_query as $key => $value) { ?>
            <li><a href="<?php echo base_url('product/type/'.$value['PT_ID']); ?>" class="<?php if (uri_seg(1) === 'product' && uri_seg(2) === 'type' && uri_seg(3) === $value['PT_ID']) echo 'menu-title'; ?>"><?php echo $value['PT_Name']; ?></a></li> <?php
        } ?>
        <li><a href="#" class="<?php if (uri_seg(1) === 'product' && uri_seg(2) === 'category') echo 'menu-title'; ?>">สินค้าแยกตามหมวดหมู่</a>
            <ul class="menu vertical is-active"> <?php
                foreach ($category_query as $key => $value) { ?>
                    <li class="sub-menu"><a href="<?php echo base_url('product/category/'.$value['C_ID']); ?>" class="<?php if (uri_seg(1) === 'product' && uri_seg(2) === 'category' && uri_seg(3) === $value['C_ID']) echo 'menu-title'; ?>"><?php echo $value['C_Name']; ?></a></li> <?php
                } ?>
            </ul>
        </li>
    </ul>
</div>