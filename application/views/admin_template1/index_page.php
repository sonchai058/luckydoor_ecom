<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $site = $this->webinfo_model->getOnceWebMain(); ?>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo @$site['WD_Descrip']; ?>">
        <meta name="keywords" content="<?php echo @$site['WD_Keyword']; ?>">
        <meta name="author" content="<?php echo @$site['WD_Name']; ?>">

        <link rel="shortcut icon" href="<?php echo base_url('assets/images/webconfig/'.@$site['WD_Icon']); ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('assets/images/webconfig/'.@$site['WD_Icon']); ?>" type="image/x-icon">

        <?php
            $this->load->file('assets/admin/tools/tools_config.php');
            $this->load->file('assets/admin/tools/tools_script.php');

            if (isset($content_view)) {
                if (gettype($content_view) == 'object') {
                    foreach($content_view->css_files as $key => $file) { ?>
                        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>"> <?php
                    }
                    foreach($content_view->js_files as $key => $file) { ?>
                        <script src="<?php echo $file; ?>"></script> <?php
                    }
                }
            }
        ?>

        <title><?php echo $site['WD_Name'].' ('.$title.')'; ?></title>
    </head>
    <body>
        <div class="wrap_admin">
            <div class="wrap_panel">
                <?php
                    $this->template->load('header/header');
                    $this->template->load('header/navbar');
                ?>
                <div class="wrap_content">
                    <div class="wrap_content_main">
                        <?php
                            if (gettype($content_view) == 'object') {
                                $this->template->load('content/order_tab');
                                echo $content_view->output;
                            }
                            else if (gettype($content_view) == 'string') {
                                if ($content_view == 'content/main')
                                    $this->template->load($content_view);
                                else
                                    $this->load->view($content_view);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>