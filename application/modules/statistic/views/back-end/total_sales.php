<link rel="stylesheet" href="<?php echo base_url('assets/plugin/datepicker/jquery-ui.css'); ?>">

<script src="<?php echo base_url('assets/plugin/datepicker/jquery-1.4.4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/datepicker/jquery-ui-1.8.10.offset.datepicker.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/plugin/highcharts/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/highcharts/js/modules/exporting.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/highcharts/js/modules/offline-exporting.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/highcharts/js/themes/grid-light.js'); ?>"></script>

<div class="dt-custom-head">
    <div class="dt-custom-menu">
        <ul> <?php
            if (uri_seg(1) == 'control') { ?>
                <li class="active"><a href="<?php echo base_url('control'); ?>"><i class="fa fa-money"></i> ยอดการขาย</a><div></div></li>
                <li class=""><a href="<?php echo base_url('control/total_amounts'); ?>"><i class="fa fa-cubes"></i> สินค้าที่ขายได้</a><div></div></li> <?php
            }
            else if (uri_seg(1) == 'statistic') { ?>
                <li class="active"><a href="<?php echo base_url('statistic/control_statistic/total_sales'); ?>"><i class="fa fa-money"></i> ยอดการขาย</a><div></div></li>
                <li class=""><a href="<?php echo base_url('statistic/control_statistic/total_amounts'); ?>"><i class="fa fa-cubes"></i> สินค้าที่ขายได้</a><div></div></li> <?php
            } ?>
        </ul>
    </div>
</div>

<div id="chart_content"></div>

<div class="date_select"> <?php
    if (get_session('M_Type') == '1' || get_session('M_Type') == '2') {
        echo form_open('', array('id' => 'formTotalSales')); ?>
            <label for="date-start">ค้นหา</label>&nbsp;<input id="date-start" name="date-start" type="text" value="<?php if ($total > 0) echo $date_start!=''?$date_start:date("d/m/Y", strtotime($get_date[0]['Date'])); else echo date('d/m/Y'); ?>">&nbsp;
            <label for="date-end">ถึง</label>&nbsp;<input id="date-end" name="date-end" type="text" value="<?php if ($total > 0) echo $date_end!=''?$date_end:date("d/m/Y", strtotime($get_date[count($get_date) - 1]['Date'])); else echo date('d/m/Y'); ?>">&nbsp;
            <input type="submit" name="bt_submit1" value="ค้นหา" title="ค้นหา" id="sttss"> <br><br>
            <input type="submit" name="bt_submit2" value="Download PDF document" title="Download PDF document" id="dpdfd"> <?php
        echo form_close();
    } ?>
</div>

<div id="stat_rs">
    <?php
        if ($date_start != '' && $date_end != '') {
            echo "วันที่ ".formatDateThai(dateChange($date_start,2))." - วันที่ ".formatDateThai(dateChange($date_end,2))."<br>";
        } else {
            if (isset($get_date[0]['Date']) && isset($get_date[count($get_date)-1]['Date']))
                echo "วันที่ ".formatDateThai($get_date[0]['Date'])." - วันที่ ".formatDateThai($get_date[count($get_date)-1]['Date'])."<br>";
            else
                echo "วันที่ ".formatDateThai(date('Y-m-d'))." - วันที่ ".formatDateThai(date('Y-m-d'))."<br>";
        }
        echo "ยอดการขายทั้งหมด: ฿".number_format($total, 2)." ";
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
    $('#chart_content').highcharts({
        exporting: {
            chartOptions: {
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                }
            },
            scale: 3,
            fallbackToExportServer: false
        },

        chart: {
            zoomType: 'x'
        },

        title: {
            text: '<span style="font-size:30px;font-weight:600;font-family:TH Krub">ยอดการขาย</span>'
        },

        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%b \'%y',
            }
        },

        yAxis: {
            min: 0,
            title: {
                text: '<span style="font-size:18px;font-family:TH Krub">อัตรายอดขาย</span>'
            }
        },

        legend: {
            enabled: false
        },

        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },

        tooltip: {
            headerFormat:   '<span style="font-size:30px;font-weight:600;font-family:TH Krub">{point.key}</span><br>',
            pointFormat:    '<span style="font-size:20px;font-weight:600;font-family:TH Krub">ยอดการขาย</span><span style="font-size:20px;font-family:TH Krub">: ฿{point.y:,.2f}</span>'
        },

        series: [{
            type: 'areaspline',
            data: [<?php
                foreach ($get_date as $key => $value) {
                    $date = explode("-", $value['Date']);
                    $date_m = ($date[1]-1);
                    echo "[Date.UTC($date[0], $date_m, $date[2]), {$price[$key]}],";
                }
            ?>],
        }]
    });

    $(document).ready(function() {
        $('#dpdfd').click(function() {
            $('#formTotalSales').attr('target', '_blank');
            $('#formTotalSales').submit();
        });
        $('#sttss').click(function() {
            $('#formTotalSales').attr('target', '_self');
            $('#formTotalSales').submit();
        });
    });

    // $('#chart_content').highcharts({
    //     exporting: {
    //         chartOptions: {
    //             plotOptions: {
    //                 series: {
    //                     dataLabels: {
    //                         enabled: true
    //                     }
    //                 }
    //             }
    //         },
    //         scale: 3,
    //         fallbackToExportServer: false
    //     },

    //     chart: {
    //         type: 'column'
    //     },

    //     title: {
    //         text: '<span style="font-size:22px; font-weight:600; padding-top: 20px;">ยอดการขาย</span>'
    //     },

    //     xAxis: {
    //         type: 'datetime',
    //         dateTimeLabelFormats: {
    //             month: '%b \'%y',
    //         },
    //         crosshair: true
    //     },

    //     yAxis: {
    //         min: 0,
    //         title: {
    //             text: 'อัตรา ยอดขาย'
    //         }
    //     },

    //     legend: {
    //         enabled: false,
    //         floating: true,
    //         layout: 'vertical',
    //         align: 'left',
    //         x: 120,
    //         verticalAlign: 'top',
    //         y: 100,
    //     },

    //     plotOptions: {
    //         // area: {
    //         //     fillColor: {
    //         //         linearGradient: {
    //         //             x1: 0,
    //         //             y1: 0,
    //         //             x2: 0,
    //         //             y2: 1
    //         //         },
    //         //         stops: [
    //         //             [0, Highcharts.getOptions().colors[0]],
    //         //             [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
    //         //         ]
    //         //     },
    //         //     marker: {
    //         //         radius: 2
    //         //     },
    //         //     lineWidth: 1,
    //         //     states: {
    //         //         hover: {
    //         //             lineWidth: 1
    //         //         }
    //         //     },
    //         //     threshold: null
    //         // }
    //         column: {
    //             pointPadding: 0.2,
    //             borderWidth: 0
    //         }
    //     },

    //     tooltip: {
    //         headerFormat: '<span style="font-size:22px;font-weight:600;">{point.key}</span><table>',
    //         pointFormat: '<tr><td style="color:{series.color};padding:0;font-weight:bold">{series.name}: </td>' +
    //             '<td style="padding:0"> &nbsp; <b>{point.y:.2f}</b></td></tr>',
    //         footerFormat: '</table>',
    //         shared: true,
    //         useHTML: true
    //     },

    //     series: [{
    //         name: 'ยอดการขาย',
    //         data: [<?php
    //             foreach ($get_date as $key => $value) {
    //                 $date = explode("-", $value['Date']);
    //                 $date_m = ($date[1]-1);
    //                 echo "[Date.UTC($date[0], $date_m, $date[2]), {$price[$key]}],";
    //             }
    //         ?>],
    //         tooltip: {
    //             pointFormat: '<tr><td style="color:{series.color};padding:0;font-weight:bold">{series.name}: </td>' +
    //                 '<td style="padding:0"> &nbsp; <b>฿{point.y:.2f}</b></td></tr>',
    //             footerFormat: '</table>',
    //         },
    //     }, {
    //         name: 'สินค้าที่ขายได้',
    //         data: [<?php
    //             foreach ($get_date as $key => $value) {
    //                 $date = explode("-", $value['Date']);
    //                 $date_m = ($date[1]-1);
    //                 echo "[Date.UTC($date[0], $date_m, $date[2]), {$amount[$key]}],";
    //             }
    //         ?>],
    //         tooltip: {
    //             pointFormat: '<tr><td style="color:{series.color};padding:0;font-weight:bold">{series.name}: </td>' +
    //                 '<td style="padding:0"> &nbsp; <b>{point.y:.0f}</b></td></tr>',
    //             footerFormat: '</table>',
    //         },
    //     }]
    // });
</script>