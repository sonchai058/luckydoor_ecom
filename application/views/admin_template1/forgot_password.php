<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $site = $this->webinfo_model->getOnceWebMain(); ?>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo @$site['WD_Descrip']; ?>">
        <meta name="keywords" content="<?php echo @$site['WD_Keyword']; ?>">
        <meta name="author" content="<?php echo @$site['WD_Name']; ?>">

        <link rel="shortcut icon" href="<?php echo base_url('assets/images/webconfig/'.$site['WD_Icon']); ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('assets/images/webconfig/'.$site['WD_Icon']); ?>" type="image/x-icon">
        
        <?php
            echo css_asset('jquery-ui.min.css');
            echo css_asset('font-awesome.min.css');
            echo css_asset('../admin/css/images_sprites.css');
            echo css_asset('../admin/css/reset.css');
            echo css_asset('../admin/css/login.css');
            echo js_asset('jquery.min.js');
            echo js_asset('jquery-ui.min.js');
        ?>

        <title><?php echo $site['WD_Name'].' ('.$title.')'; ?></title>
    </head>

    <body>
        <div class="wrap_login">
            <?php echo form_open('control/password_sending', "id='formForgotPassword' autocomplete='off'"); ?>
                <div class="title_login">
                    <ul class="wrap_name">
                        <li><?php echo $site['WD_Name'];    ?></li>
                        <li><?php echo $site['WD_EnName'];  ?></li>
                    </ul>
                    <ul><li>กรอกอีเมลของท่าน</li></ul>
                </div>
                <table class="table_data">
                    <tr>
                        <td><input type="email" name="email" title="Email" autofocus required placeholder="Email address"></td>
                    </tr>
                </table>
                <ul class="wrap_data">
                    <li>
                        <a class="loginSubmit" title="Send">
                            <div class="wrap_item">
                                <img src="<?php echo base_url('assets/admin/images/mail.png');?>"><span>Send</span>
                            </div>
                        </a>
                    </li>
                    <li><font color="red">*</font> หากยังไม่ได้รับอีเมลตอบกลับกรุณาส่งใหม่อีกครั้ง</li>
                    <li><font color="red">*</font> ระบบจะส่งลิ้งค์พร้อมรหัสผ่านไปยังอีเมลของท่าน</li>
                    <li><a class="forgot_link" href="<?php echo base_url('control/login'); ?>" title="กลับไปหน้าลงชื่อเข้าใช้">&#8810; กลับไปหน้าลงชื่อเข้าใช้</a></li>
                </ul>
            <?php echo form_close(); ?>
        </div>
    </body>
    <script>
        $(document).ready(function() {
            $('input').each(function(index) {
                $(this).keyup(function(event) {
                    if (event.keyCode == 13)
                        $('.loginSubmit').click();
                });
            });
            $("body").hide().fadeIn(380);
            $(".loginSubmit").click(function() {
                $("#formForgotPassword").submit();
            });
        });
    </script>
</html>