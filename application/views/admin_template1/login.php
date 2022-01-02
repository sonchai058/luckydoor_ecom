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
            <?php echo form_open('control/admin_access', "id='formLogin' autocomplete='off'"); ?>
                <div class="title_login">
                    <ul class="wrap_name">
                        <li><?php echo $site['WD_Name'];    ?></li>
                        <li><?php echo $site['WD_EnName'];  ?></li>
                    </ul>
                </div>
                <table class="table_data">
                    <tr>
                        <td><input type="text" name="user_id" title="Username" autofocus required placeholder="Username"></td>
                    </tr>
                    <tr>
                        <td><input type="password" name="user_pass" title="Password" value="" required placeholder="Password"></td>
                    </tr>
                </table>
                <ul class="wrap_data">
                    <li><?php echo $captcha; ?><br><input type="text" name="captcha" value=""></li>
                    <li>
                        <a class="loginSubmit" title="Login">
                            <div class="wrap_item">
                                <img src="<?php echo base_url('assets/admin/images/login.png');?>"><span>Login</span>
                            </div>
                        </a>
                    </li>
                    <li><a class="forgot_link" href="<?php echo base_url('control/forgot_password'); ?>" title="Forgot Password?">Forgot password?</a></li>
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
                $("#formLogin").submit();
            });
        });
    </script>
</html>