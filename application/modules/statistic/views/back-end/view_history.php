<link rel="stylesheet" href="<?php echo base_url('assets/plugin/datepicker/jquery-ui.css');?>">

<script src="<?php echo base_url('assets/plugin/datepicker/jquery-1.4.4.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugin/datepicker/jquery-ui-1.8.10.offset.datepicker.min.js');?>"></script>

<script src="<?php echo base_url('assets/plugin/highcharts/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/highcharts/js/modules/exporting.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/highcharts/js/modules/offline-exporting.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/highcharts/js/themes/grid-light.js'); ?>"></script>

<div id="chart_content"></div>

<div class="date_select"> <?php
    echo form_open(); ?>
        <label for="date-start">ค้นหา</label>&nbsp;<input name="date-start" type="text" value="<?php echo $date_start!=''?$date_start:date("d/m/Y", strtotime($get_date[0]['Date'])); ?>">&nbsp;
        <label for="date-end">ถึง</label>&nbsp;<input name="date-end" type="text" value="<?php echo $date_end!=''?$date_end:date("d/m/Y", strtotime($get_date[count($get_date) - 1]['Date'])); ?>">&nbsp;
        <input type="submit" name="bt_submit1" value="ค้นหา" title="ค้นหา"> <?php
    echo form_close(); ?>
</div>

<div id="stat_rs"> <?php
    if ($date_start !== '' && $date_end !== '')
        echo "วันที่ ".formatDateThai(dateChange($date_start, 2))." - วันที่ ".formatDateThai(dateChange($date_end, 2))."<br>";
    else
        echo "วันที่ ".formatDateThai($get_date[0]['Date'])." - วันที่ ".formatDateThai($get_date[count($get_date) - 1]['Date'])."<br>";
    echo "มีผู้เยี่ยมชมเว็บไชต์ทั้งหมด: ".$total." คน"; ?>
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
        onClose: function(selectedDate) {
		    $("input[name='date-end']").datepicker("option", "minDate", selectedDate);
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
        onClose: function(selectedDate) {
		    $("input[name='date-start']").datepicker("option", "maxDate", selectedDate);
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
            text: '<span style="font-size:30px;font-weight:600;font-family:TH Krub"><?php if ($mode == '1') { echo "จำนวนผู้เยี่ยมชมเว็บไซต์ (Front-End)"; } else { echo "จำนวนผู้เยี่ยมชมเว็บไซต์ (Back-End)"; } ?></span>'
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
                text: '<span style="font-size:18px;font-family:TH Krub">อัตราผู้เยี่ยมชมเว็บไชต์</span>'
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
            pointFormat:    '<span style="font-size:20px;font-weight:600;font-family:TH Krub">จำนวนผู้เยี่ยมชม</span><span style="font-size:20px;font-family:TH Krub">: {point.y} คน</span>'
        },

        series: [{
            type: 'areaspline',
            data: [<?php
                foreach ($get_date as $row) {
                    $date = explode("-", $row['Date']);
                    $date_m = ($date[1] - 1);
                    echo "[Date.UTC($date[0], $date_m, $date[2]), {$row['count']}],";
                }
            ?>],
        }]
    });
</script>