<div class="dt-custom-head">
    <div class="dt-custom-menu">
        <ul> <?php
        	if (uri_seg(1) == 'control') { ?>
	            <li class=""><a href="<?php echo base_url('control'); ?>"><i class="fa fa-money"></i> ยอดการขาย</a><div></div></li>
	            <li class="active"><a href="<?php echo base_url('control/total_amounts'); ?>"><i class="fa fa-cubes"></i> สินค้าที่ขายได้</a><div></div></li> <?php
	        }
	        else if (uri_seg(1) == 'statistic') { ?>
	        	<li class=""><a href="<?php echo base_url('statistic/control_statistic/total_sales'); ?>"><i class="fa fa-money"></i> ยอดการขาย</a><div></div></li>
	            <li class="active"><a href="<?php echo base_url('statistic/control_statistic/total_amounts'); ?>"><i class="fa fa-cubes"></i> สินค้าที่ขายได้</a><div></div></li> <?php
	        } ?>
        </ul>
    </div>
</div>
<div id="order_detail">
	<div class="mDiv">
		<div class="ftitle"> <?php
			echo $title;
			if ($date_start !== '' && $date_end !== '')
				echo ' (วันที่ '.formatDateThai(dateChange($date_start, 2)).' - วันที่ '.formatDateThai(dateChange($date_end, 2)).')';
			else if (!empty($get_date))
				echo ' (วันที่ '.formatDateThai($get_date[0]['Date']).' - วันที่ '.formatDateThai($get_date[count($get_date) - 1]['Date']).')';
			else
				echo ' (วันที่ '.formatDateThai(date('Y-m-d')).' - วันที่ '.formatDateThai(date('Y-m-d')).')';
			?>
		</div>
	</div>
	<div class="main-table-box">
		<div class="bDiv">
			<table cellspacing="0" cellpadding="0" border="0">
				<?php $thai_month = array("0" => "", "1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม", "4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน", "7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม"); ?>
				<thead>
					<tr class="hDiv">
						<th><div class="text-center">ลำดับที่</div></th>
						<th><div class="text-center">รหัสสินค้า</div></th>
						<th><div class="text-center">ชื่อสินค้า</div></th>
						<th><div class="text-center">จำนวนที่ขายไป</div></th>
						<th><div class="text-center">ราคารวม</div></th>
					</tr>
				</thead>
				<tbody> <?php
					$erow 				= 1;
					$ODL_Amount 		= 0;
					$ODL_FullSumPrice 	= 0;
					foreach ($summary as $key => $values) {
						foreach ($values as $value) {
							$row['P_IDCode'] 			= $value->P_IDCode;
							$row['P_Name'] 				= $value->P_Name;
							$row['ODL_Amount'] 			= $value->ODL_Amount;
							$row['ODL_FullSumPrice']	= $value->ODL_FullSumPrice;
						} ?>
						<tr <?php if ($erow %2 === 0) { ?> class="erow" <?php } ?>>
							<td class="text-normal"><div class="text-left"><?php echo $erow; ?></div></td>
							<td class="text-normal"><div class="text-left"><?php echo $row['P_IDCode']; ?></div></td>
							<td class="text-normal"><div class="text-left"><?php echo $row['P_Name']; ?></div></td>
							<td class="text-numeri"><div class="text-right"><?php echo $row['ODL_Amount']; ?></div></td>
							<td class="text-numeri"><div class="text-right">฿<?php echo number_format($row['ODL_FullSumPrice'], 2); ?></div></td>
						</tr> <?php
						$erow 				+= 1;
						$ODL_Amount 		+= $row['ODL_Amount'];
						$ODL_FullSumPrice 	+= $row['ODL_FullSumPrice'];
					} ?>
				</tbody>
				<tfoot>
					<tr class="hDiv">
						<th class="text-normal" colspan="3"><div class="text-left">สินค้าที่ขายไปทั้งหมด</div></th>
						<th class="text-numeri"><div class="text-right"><?php echo $ODL_Amount; ?></div></th>
						<th class="text-numeri"><div class="text-right">฿<?php echo number_format($ODL_FullSumPrice, 2); ?></div></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<div class="date_select"> <?php
    if (get_session('M_Type') == '1' || get_session('M_Type') == '2') {
        echo form_open('', array('id' => 'formTotalAmounts')); ?>
            <label for="date-start">ค้นหา</label>&nbsp;<input id="date-start" name="date-start" type="text" value="<?php if ($ODL_Amount > 0 && $ODL_FullSumPrice > 0) echo $date_start!=''?$date_start:date("d/m/Y", strtotime($get_date[0]['Date'])); else echo date('d/m/Y'); ?>">&nbsp;
            <label for="date-end">ถึง</label>&nbsp;<input id="date-end" name="date-end" type="text" value="<?php if ($ODL_Amount > 0 && $ODL_FullSumPrice > 0) echo $date_end!=''?$date_end:date("d/m/Y", strtotime($get_date[count($get_date) - 1]['Date'])); else echo date('d/m/Y'); ?>">&nbsp;
            <input type="submit" name="bt_submit1" value="ค้นหา" title="ค้นหา" id="sttss"> <br><br>
            <input type="submit" name="bt_submit2" value="Download PDF document" title="Download PDF document" id="dpdfd"> <?php
        echo form_close();
    } ?>
</div>

<div id="stat_rs">
    <?php
        if ($date_start != '' && $date_end != '') {
            echo "วันที่ ".formatDateThai(dateChange($date_start, 2))." - วันที่ ".formatDateThai(dateChange($date_end, 2))."<br>";
        } else {
            if (isset($get_date[0]['Date']) && isset($get_date[count($get_date) - 1]['Date']))
                echo "วันที่ ".formatDateThai($get_date[0]['Date'])." - วันที่ ".formatDateThai($get_date[count($get_date) - 1]['Date'])."<br>";
        }
        echo "สินค้าที่ขายไปทั้งหมด: ".$ODL_Amount." <br>";
        echo "ยอดการขายทั้งหมด: ฿".number_format($ODL_FullSumPrice, 2)." ";
    ?>
</div>

<script type="text/javascript">

    $("input[name='date-start']").datepicker({
        altField: this,
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        gotoCurrent: true,
        autoSize: true,
        maxDate: '0',
        onClose: function( selectedDate ) {
            $("input[name='date-end']").datepicker( "option", "minDate", selectedDate );
        }
    });

    $("input[name='date-end']").datepicker({
        altField: this,
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        gotoCurrent: true,
        autoSize: true,
        maxDate: '0',
        onClose: function( selectedDate ) {
            $("input[name='date-start']").datepicker( "option", "maxDate", selectedDate );
        }
    });

    $(document).ready(function() {
        $('#dpdfd').click(function() {
            $('#formTotalAmounts').attr('target', '_blank');
            $('#formTotalAmounts').submit();
        });
        $('#sttss').click(function() {
            $('#formTotalAmounts').attr('target', '_self');
            $('#formTotalAmounts').submit();
        });
    });

</script>