<?php
    $site       = $this->webinfo_model->getOnceWebMain();
    $success    = array('7' => 'ส่งสินค้าแล้ว');
    $primary    = array('5' => 'โอนเงินแล้ว', '6' => 'รอส่งสินค้า');
    $secondary  = array('1' => 'ปกติ', '4' => 'รอโอนเงิน');
    $warning    = array('2' => 'ระงับ');
    $alert      = array('3' => 'ยกเลิก');
?>
<main>
    <?php $this->template->load('header/breadcrumb'); ?>
    <section>
        <div class="row">
            <?php $this->load->view('front-end/section'); ?>
            <div class="small-12 medium-expand columns">
                <div class="wrapper-orderstatus-title">
                    <h1>ติดตามสถานะคำสั่งซื้อ</h1>
                    ติดตามสถานะคำสั่งซื้อ
                </div>
                <ul class="menu order-list">
                    <li>ORDER # <?php echo $order_data['OD_Code']; ?> </li>
                    <li>Placed on <?php echo date('d/m/Y', strtotime($order_data['OD_DateTimeUpdate'])); ?></li>
                    <li><span class="<?php if (in_array($order_status, $success)) echo 'success'; else if (in_array($order_status, $primary)) echo 'primary'; else if (in_array($order_status, $secondary)) echo 'secondary'; else if (in_array($order_status, $warning)) echo 'warning'; else if (in_array($order_status, $alert)) echo 'alert'; ?> order-badge"><?php echo $order_status; ?></span></li> <?php
                    if (in_array($order_status, $secondary)) { ?>
                        <li><a class="btn-history-transfer" href="<?php echo base_url('member/transfer/'.$order_data['OD_ID']); ?>">แจ้งโอนเงิน</a></li> <?php
                    } ?>
                </ul>
                <table class="table-order scroll">
                    <thead>
                        <tr>
                            <th class="width-15"></th>
                            <th class="width-50"></th>
                            <th class="width-5">จำนวน</th>
                            <th class="width-15">ราคาสินค้า</th>
                            <th class="width-10">ราคาทั้งหมด</th>
                        </tr>
                    </thead>
                    <tbody> <?php
                        foreach ($order_list as $key => $value) { ?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url('product/detail/'.$value['P_ID']); ?>"> <?php
                                        if ($value['P_Img'] !== '') { ?>
                                            <img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['P_Img']); ?>" alt="" width="50"> <?php
                                        }
                                        else { ?>
                                            <img src="<?php echo base_url('assets/images/noimage.gif'); ?>" alt="" width="50"> <?php
                                        } ?>
                                    </a>
                                </td>
                                <td><h5><a href="<?php echo base_url('product/detail/'.$value['P_ID']); ?>"><?php echo $value['P_Name'].' ('.$value['P_IDCode'].')'; ?></a></h5></td>
                                <td><?php echo number_format($value['ODL_Amount']); ?></td>
                                <td>฿<?php echo number_format($value['ODL_Price'], 2, '.', ','); ?></td>
                                <td>฿<?php echo number_format($value['ODL_FullSumPrice'], 2, '.', ','); ?></td>
                            </tr> <?php
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>ราคารวม:</td>
                            <td>฿<?php echo number_format($order_data['OD_SumPrice'], 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="width-20">ค่าขนส่งและดำเนินการ:</td>
                            <td>฿<?php echo number_format($order_data['OD_FullSumPrice'] - $order_data['OD_SumPrice'], 2, '.', ','); ?></td>
                        </tr>
                        <!-- <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Tax:</td>
                            <td>฿446.00</td>
                        </tr> -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>ราคารวมทั้งสิ้น:</td>
                            <td>฿<?php echo number_format($order_data['OD_FullSumPrice'], 2, '.', ','); ?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="row">
                    <!-- <div class="small-8 columns">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis hic neque, sint recusandae, quibusdam eum dignissimos! Veritatis perferendis temporibus architecto, optio provident, ratione molestias autem dicta modi numquam, dolore ipsum.</p>
                        <br>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis hic neque, sint recusandae, quibusdam eum dignissimos! Veritatis perferendis temporibus architecto, optio provident, ratione molestias autem dicta modi numquam, dolore ipsum.</p>
                    </div>
                    <div class="small-4 columns">
                        <h4><i class="fa fa-ticket"></i> Invoice address</h4>
                        <address>
                            <p>บริษัท ลักกี้ดอร์ เทรดดิ้ง จำกัด</p>
                            <p>125/250 หมู่ที่ 3 ถนนรัตนาธิเบศร์ ตำบลไทรม้า อำเภอเมืองนนทบุรี จังหวัดนนทบุรี</p>
                        </address>
                        <br>
                        <h4><i class="fa fa-ticket"></i> Invoice address</h4>
                        <address>
                            <p>บริษัท ลักกี้ดอร์ เทรดดิ้ง จำกัด</p>
                            <p>125/250 หมู่ที่ 3 ถนนรัตนาธิเบศร์ ตำบลไทรม้า อำเภอเมืองนนทบุรี จังหวัดนนทบุรี</p>
                        </address>
                    </div> -->
                    <div class="small-6 columns">
                        <h4><i class="fa fa-ticket"></i> ที่อยู่ลูกค้า</h4>
                        <address>
                            <?php
                                $address = '';
                                if (!empty($member_data)) {
                                    if ($member_data['M_hrNumber']      != '') $address .= 'เลขที่/ห้อง '.$member_data['M_hrNumber'];
                                    if ($member_data['M_VilBuild']      != '') $address .= ' หมู่บ้าน/อาคาร/คอนโด '.$member_data['M_VilBuild'];
                                    if ($member_data['M_VilNo']         != '') $address .= ' หมู่ที่ '.$member_data['M_VilNo'];
                                    if ($member_data['M_LaneRoad']      != '') $address .= ' ตรอก/ซอย '.$member_data['M_LaneRoad'];
                                    if ($member_data['M_Street']        != '') $address .= ' ถนน '.$member_data['M_Street'];
                                    if ($member_data['M_Street']        != '') $address .= ' ถนน '.$member_data['M_Street'];
                                    if ($member_data['District_ID']     != '') {
                                        $District_ID = rowArray($this->common_model->get_where_custom('districts', 'District_ID', $member_data['District_ID']));
                                        if (count($District_ID) > 0) $District_Name = $District_ID['District_Name'];
                                    }
                                    if ($member_data['Amphur_ID']       != '') {
                                        $Amphur_ID = rowArray($this->common_model->get_where_custom('amphures', 'Amphur_ID', $member_data['Amphur_ID']));
                                        if (count($Amphur_ID) > 0) $Amphur_Name = $Amphur_ID['Amphur_Name'];
                                    }
                                    if ($member_data['Province_ID']     != '') {
                                        $Province_ID = rowArray($this->common_model->get_where_custom('provinces', 'Province_ID', $member_data['Province_ID']));
                                        if (count($Province_ID) > 0) $Province_Name = $Province_ID['Province_Name'];
                                    }
                                    if ($member_data['Province_ID']     != '' && $member_data['Province_ID'] == '1') {
                                        $address .= ' แขวง'.$District_Name;
                                        $address .= ' เขต'.$Amphur_Name;
                                        $address .= ' '.$Province_Name;
                                    }
                                    if ($member_data['Province_ID']     != '' && $member_data['Province_ID'] != '1') {
                                        $address .= ' ตำบล'.$District_Name;
                                        $address .= ' อำเภอ'.$Amphur_Name;
                                        $address .= ' จังหวัด'.$Province_Name;
                                    }
                                    if ($member_data['Zipcode_Code']    != '') $address .= ' รหัสไปรษณีย์ '.$member_data['Zipcode_Code'];
                                }
                            ?>
                            <p><?php echo trim($address); ?></p>
                        </address>
                    </div>
                    <div class="small-6 columns">
                        <h4><i class="fa fa-ticket"></i> ที่อยู่ในการจัดส่ง</h4>
                        <address>
                            <?php
                                $address = '';
                                if (!empty($address_data)) {
                                    if ($address_data['OD_hrNumber']    != '') $address .= 'เลขที่/ห้อง '.$address_data['OD_hrNumber'];
                                    if ($address_data['OD_VilBuild']    != '') $address .= ' หมู่บ้าน/อาคาร/คอนโด '.$address_data['OD_VilBuild'];
                                    if ($address_data['OD_VilNo']       != '') $address .= ' หมู่ที่ '.$address_data['OD_VilNo'];
                                    if ($address_data['OD_LaneRoad']    != '') $address .= ' ตรอก/ซอย '.$address_data['OD_LaneRoad'];
                                    if ($address_data['OD_Street']      != '') $address .= ' ถนน '.$address_data['OD_Street'];
                                    if ($address_data['District_ID']    != '') {
                                        $District_ID = rowArray($this->common_model->get_where_custom('districts', 'District_ID', $address_data['District_ID']));
                                        if (count($District_ID) > 0) $District_Name = $District_ID['District_Name'];
                                    }
                                    if ($address_data['Amphur_ID']      != '') {
                                        $Amphur_ID = rowArray($this->common_model->get_where_custom('amphures', 'Amphur_ID', $address_data['Amphur_ID']));
                                        if (count($Amphur_ID) > 0) $Amphur_Name = $Amphur_ID['Amphur_Name'];
                                    }
                                    if ($address_data['Province_ID']    != '') {
                                        $Province_ID = rowArray($this->common_model->get_where_custom('provinces', 'Province_ID', $address_data['Province_ID']));
                                        if (count($Province_ID) > 0) $Province_Name = $Province_ID['Province_Name'];
                                    }
                                    if ($address_data['Province_ID']    != '' && $address_data['Province_ID'] == '1') {
                                        $address .= ' แขวง'.$District_Name;
                                        $address .= ' เขต'.$Amphur_Name;
                                        $address .= ' '.$Province_Name;
                                    }
                                    if ($address_data['Province_ID']    != '' && $address_data['Province_ID'] != '1') {
                                        $address .= ' ตำบล'.$District_Name;
                                        $address .= ' อำเภอ'.$Amphur_Name;
                                        $address .= ' จังหวัด'.$Province_Name;
                                    }
                                    if ($address_data['Zipcode_Code']   != '') $address .= ' รหัสไปรษณีย์ '.$address_data['Zipcode_Code'];
                                }
                            ?>
                            <p><?php echo trim($address); ?></p>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>