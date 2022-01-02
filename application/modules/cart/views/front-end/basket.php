<main>
    <?php
        $this->template->load('header/breadcrumb');
        $grand_total = 0;
    ?>
    <section> <?php
        if (!$this->cart->contents()) { ?>
            <div class="row">
                <div class="columns">
                    <h2>ไม่มีสินค้าในตะกร้า</h2>
                    <a href="<?php echo base_url('product'); ?>" class="btn-continue-shop"> เลือกซื้อสินค้า</a>
                    <hr>
                </div>
            </div> <?php
        }
        else if ($this->cart->contents()) { ?>
            <div class="row">
                <div class="columns">
                    <h2>ตะกร้าสินค้าของคุณ</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="small-12 medium-8 columns">
                    <table class="scroll table-cart">
                        <thead>
                            <tr>
                                <th class="width-10"><?php if ($grand_quantity !== 0) echo number_format($grand_quantity).' สินค้า'; else echo 'ไม่มีสินค้า'; ?></th>
                                <th class="width-45"></th>
                                <th class="width-15">จำนวน / สี</th>
                                <th class="width-10">ราคาสินค้า</th>
                                <th class="width-10">ราคาทั้งหมด</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody> <?php
                            $attributes = array(
                                'id' => 'cart_order_update'
                            );
                            echo form_open('cart/cartOrderUpdate', $attributes);
                            foreach ($this->cart->contents() as $value) {
                                $P_ID = $value['id'];
                                echo form_hidden('cart['.$value['id'].'][id]',               $value['id']);
                                echo form_hidden('cart['.$value['id'].'][rowid]',            $value['rowid']);
                                echo form_hidden('cart['.$value['id'].'][name]',             $value['name']);
                                echo form_hidden('cart['.$value['id'].'][price]',            $value['price']);
                                echo form_hidden('cart['.$value['id'].'][subtotal]',         $value['subtotal']);
                                echo form_hidden('cart['.$value['id'].'][options][code]',    $value['options']['code']);
                                echo form_hidden('cart['.$value['id'].'][options][weight]',  $value['options']['weight']);
                                echo form_hidden('cart['.$value['id'].'][options][imgs]',    $value['options']['imgs']); ?>
                                <tr>
                                    <td>
                                        <a href="<?php if ($value['id'] !== '') echo base_url('product/detail/'.$value['id']); ?>">
                                            <img src="<?php if ($value['options']['imgs'] != '') echo base_url('assets/uploads/user_uploads_img/'.$value['options']['imgs']); else echo base_url('assets/images/noimage.gif'); ?>" alt="" width="50">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php if ($value['id'] !== '') echo base_url('product/detail/'.$value['id']); ?>">
                                            <h5><?php if ($value['options']['code'] != '') echo ' '.$value['options']['code']; ?></h5>
                                            <h5><?php if ($value['name'] != '') echo $value['name']; ?></h5>
                                        </a> <?php
                                        $product_stock = rowArray($this->common_model->custom_query(" SELECT * FROM `product_stock` WHERE `P_ID` = '$P_ID' AND `PS_Allow` != '3' ORDER BY `PS_ID` DESC LIMIT 1 "));
                                        if (count($product_stock) > 0 && $product_stock['PS_Amount'] != 0) { ?>
                                            <h5><i class="fa fa-check"></i> มีสินค้า <?php echo ' ('.$product_stock['PS_Amount'].')'; ?></h5> <?php
                                            echo form_input(array('type' => 'hidden', 'name' => 'cart['.$value['id'].'][stock]', 'value' => number_format($product_stock['PS_Amount'])));
                                        }
                                        else { ?>
                                            <h5><i class="fa fa-times"></i> สินค้าหมด</h5> <?php
                                            echo form_input(array('type' => 'hidden', 'name' => 'cart['.$value['id'].'][stock]', 'value' => number_format(0)));
                                        } ?>
                                        <h5>น้ำหนักต่อหน่วย: <?php echo number_format($value['options']['weight'], 2, '.', ','); ?> (กก.)</h5> <?php
                                        // if (get_session('C_ID')) {
                                            // $wlist_P_ID = $value['id'];
                                            // $wlist_M_ID = get_session('C_ID');
                                            // $product_wlist_query = $this->common_model->custom_query(
                                            //     "   SELECT * FROM `wishlist`
                                            //         WHERE `P_ID`     = '$wlist_P_ID'
                                            //         AND `M_ID`       = '$wlist_M_ID'
                                            //         AND `W_Allow`   != '3'
                                            //         ORDER BY `W_ID` DESC
                                            //         LIMIT 1     "
                                            // );
                                            // if (count($product_wlist_query) <= 0) { ?>
                                                <!-- <a href="<?php echo base_url('product/wishlist/add/'.$value['id']); ?>" class="btn-wishlist"><i class="fa fa-star-o"></i> เพิ่มในสินค้าที่อยากได้</a>  -->
                                                <?php
                                            // }
                                            // else if (count($product_wlist_query) > 0) { ?>
                                                <!-- <a href="<?php echo base_url('product/wishlist/del/'.$value['id']); ?>" class="btn-wishlist-active"><i class="fa fa-check-square-o"></i> อยู่ในสินค้าที่อยากได้</a>  -->
                                                <?php
                                            // }
                                        // } ?>
                                    </td>
                                    <td>
                                        <input type="number" id="<?php echo 'cart_'.$value['id'].'_qty'; ?>" name="<?php echo 'cart['.$value['id'].'][qty]'; ?>" value="<?php if ($value['qty'] != 0) echo $value['qty']; ?>" min="1" onkeyup="qtyKeyUp(this.value, <?php echo $value['id']; ?>);" onchange="qtyChange(this.value, <?php echo $value['id']; ?>);" onfocusout="qtyFocusOut(this.value, <?php echo $value['id']; ?>);"> <?php
                                        $product = rowArray($this->common_model->get_where_custom('product', 'P_ID', $value['id']));
                                        if (count($product) > 0) {
                                            $colors = explode(",", $product['P_Color']); ?>
                                            <select name="cart[<?php echo $value['id']; ?>][options][color]">
                                                <option disabled <?php if ($value['options']['color'] == '') { ?> selected <?php } ?>>เลือกสี</option> <?php
                                                foreach ($colors as $key => $values) {
                                                    $product_color = rowArray($this->common_model->get_where_custom('product_color', 'PC_ID', $values));
                                                    if (count($product_color) > 0) { ?>
                                                        <option value="<?php echo $product_color['PC_ID']; ?>" <?php if ($product_color['PC_ID'] == $value['options']['color']) { ?> selected <?php } ?>><?php echo $product_color['PC_Name']; ?></option> <?php
                                                    }
                                                } ?>
                                            </select> <?php
                                        } ?>
                                    </td>
                                    <td>
                                        ฿<?php echo number_format($value['price'], 2, '.' , ',');
                                        echo form_input(array('type' => 'hidden', 'id' => 'cart_'.$value['id'].'_price', 'name' => 'cart['.$value['id'].'][price]', 'value' => number_format($value['price'], 2, '.', ''))); ?>
                                    </td>
                                    <td>
                                        <?php $grand_total += ($value['price'] * $value['qty']);
                                        echo form_input(array('type' => 'hidden', 'class' => 'cart-price-total', 'id' => 'cart_'.$value['id'].'_total', 'value' => number_format($value['subtotal'], 2, '.' , ''))); ?>
                                        <span class="product_price_view" id="product_price_view_<?php echo $value['id']; ?>">฿<?php echo number_format($value['subtotal'], 2, '.' , ','); ?></span>
                                    </td>
                                    <td>
                                        <a href="#" title="ลบ" onclick="removeItem('<?php echo $value['name']; ?>', '<?php echo $value['id']; ?>', '<?php echo $value['rowid']; ?>');"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr> <?php
                            }
                            echo form_close(); ?>
                        </tbody>
                    </table>
                    <a href="#" class="button btn-cart-update" id="btn_cart_update">อัพเดทตะกร้าสินค้า</a>
                    <a href="#" class="button btn-cart-clears" id="btn_cart_clears">ล้างตะกร้าสินค้า</a>
                    <hr>
                </div>

                <!-- Summary -->
                <div class="columns">
                    <div class="row">
                        <div class="small-12 medium-expanded columns">
                            <div class="summary-head">
                                <h3>สรุปการสั่งซื้อ</h3>
                            </div>
                        </div>
                        <div class="small-6 columns">
                            <div class="summary-detail-1">
                                <h5>ยอดสุทธิ: </h5>
                            </div>
                        </div>
                        <div class="small-6 columns">
                            <h4 class="text-right" id="grand_total">฿<?php echo number_format($grand_total, 2, '.', ','); ?></h4>
                        </div>
                        <!-- <div class="small-6 columns">
                            <h5>ยอดสุทธิ (รวมภาษีมูลค่าเพิ่ม): </h5>
                        </div>
                        <div class="small-6 columns">
                            <h3 class="text-right">฿446 THB</h3>
                        </div> -->
                        <a href="<?php echo base_url('cart/address'); ?>" class="button btn-checkout">ดำเนินการชำระเงิน</a>
                        <a href="<?php echo base_url('product'); ?>" class="btn-continue-shop">เลือกซื้อสินค้าต่อ</a>
                    </div>
                </div>
            </div> <?php
        } ?>
    </section>
</main>
<script type="text/javascript">
    function qtyKeyUp(this_value, this_id) {
        if ($('#cart_' + this_id + '_price').val() > 0) {
            $('#product_price_view_' + this_id).text('฿' + ((this_value * $('#cart_' + this_id + '_price').val()).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#cart_' + this_id + '_total').val((this_value * $('#cart_' + this_id + '_price').val()).toFixed(2));
            var grand_total = 0;
            $('.cart-price-total').each(function(index) {
                grand_total += parseFloat($(this).val());
            });
            $('#grand_total').text('฿' + (grand_total.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
    }

    function qtyChange(this_value, this_id) {
        if ($('#cart_' + this_id + '_price').val() > 0) {
            $('#product_price_view_' + this_id).text('฿' + ((this_value * $('#cart_' + this_id + '_price').val()).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#cart_' + this_id + '_total').val((this_value * $('#cart_' + this_id + '_price').val()).toFixed(2));
            var grand_total = 0;
            $('.cart-price-total').each(function(index) {
                grand_total += parseFloat($(this).val());
            });
            $('#grand_total').text('฿' + (grand_total.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
    }

    function qtyFocusOut(this_value, this_id) {
        if (this_value < 1) {
            $('#cart_' + this_id + '_qty').val(1);
            $('#cart_' + this_id + '_qty').trigger('keyup');
        }
    }

    function removeItem(this_name, this_id, this_rowid) {
        if (confirm('ยืนยันการลบ ' + this_name + ' ออกจากตะกร้าสินค้า') === true)
            window.location.href = "<?php echo base_url('cart/cartOrderRemove'); ?>/" + this_rowid + "/" + this_id;
    }

    $(document).ready(function() {
        $('#btn_cart_update').click(function() {
            // if (confirm('ยืนยันการอัพเดทตะกร้าสินค้า') === true)
                $('#cart_order_update').submit();
        });
        $('#btn_cart_clears').click(function() {
            if (confirm('ยืนยันการล้างตะกร้าสินค้า') === true)
                window.location.href = "<?php echo base_url('cart/cartOrderRemove/all'); ?>";
        });
    });
</script>