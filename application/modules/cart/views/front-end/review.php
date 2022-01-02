<main> <?php
    $this->template->load('header/breadcrumb');
    $grand_total = 0; ?>
    <section> <?php
        if ($this->cart->contents()) { ?>
            <div class="row">
                <div class="small-12 medium-8 columns">
                    <div class="login-wrapper">
                        <h4>ยืนยันสินค้า</h4>
                        <table class="table-cart">
                            <thead>
                                <tr>
                                    <th width="100"><?php if ($grand_quantity !== 0) echo number_format($grand_quantity).' สินค้า'; else echo 'ไม่มีสินค้า'; ?></th>
                                    <th width="375"></th>
                                    <th width="90"></th>
                                    <th width="100">ราคาสินค้า</th>
                                    <th width="100">ราคาทั้งหมด</th>
                                </tr>
                            </thead>
                            <tbody> <?php
                                foreach ($this->cart->contents() as $value) {
                                    $P_ID = $value['id']; ?>
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
                                            // $product_stock = rowArray($this->common_model->custom_query(" SELECT * FROM `product_stock` WHERE `P_ID` = '$P_ID' AND `PS_Allow` != '3' ORDER BY `PS_ID` DESC LIMIT 1 "));
                                            // if (count($product_stock) > 0 && $product_stock['PS_Amount'] != 0) {
                                                ?>
                                                <!-- <h5><i class="fa fa-check"></i> มีสินค้า <?php echo ' ('.$product_stock['PS_Amount'].')'; ?></h5>  -->
                                                <?php
                                            // }
                                            // else {
                                                ?>
                                                <!-- <h5><i class="fa fa-times"></i> สินค้าหมด</h5>  -->
                                                <?php
                                            // }
                                            ?>
                                            <h5>น้ำหนักต่อหน่วย: <?php echo number_format($value['options']['weight'], 2, '.', ','); ?> (กก.)</h5> <?php
                                            $product_color = rowArray($this->common_model->get_where_custom('product_color', 'PC_ID', $value['options']['color']));
                                            if (count($product_color) <= 0) $product_color['PC_Name'] = ''; ?>
                                            <h5>สี: <?php echo $product_color['PC_Name']; ?></h5>
                                            <!-- <a href="#"><i class="fa fa-star-o"></i> เพิ่มไปยังสิ่งที่อยากได้</a> -->
                                        </td>
                                        <td>
                                            <?php if ($value['qty'] != 0) echo $value['qty']; ?>
                                        </td>
                                        <td>
                                            ฿<?php echo number_format($value['price'], 2, '.' , ','); ?>
                                        </td>
                                        <td>
                                            ฿<?php echo number_format($value['subtotal'], 2, '.' , ','); ?>
                                        </td>
                                    </tr> <?php
                                } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="small-12 medium-3 large-offset-9 columns">
                                <a href="<?php echo base_url('cart/payment'); ?>" class="button btn-checkout">ดำเนินการต่อไป</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <?php $this->load->view('front-end/summary'); ?>
            </div>
            <a href="#!"></a> <?php
        } ?>
    </section>
</main>