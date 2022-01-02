<?php 
    $slide_images   =  array(
        array(
            'img'   => 'http://placehold.it/1200x400', 
        ), 
        array( 
            'img'   => 'http://placehold.it/1200x400', 
        ), 
        array(
            'img'   => 'http://placehold.it/1200x400', 
        ), 
    );
    $slide_attr     =  array(
        ''          => '', 
    );
?>
<div class="row carousel-holder">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <?php 
                $active = ' active';
                foreach ($slide_images as $key => $value) { ?>
                    <div class="item<?php echo $active; ?>">
                        <img class="slide-image" src="<?php echo $value['img']; ?>" alt="" title="">
                    </div> <?php
                    $active = '';
                }
            ?>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>