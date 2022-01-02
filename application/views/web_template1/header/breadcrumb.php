<section>
    <div class="row">
        <div class="columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="<?php echo $breadcrumb['index_url']['path']; ?>"><?php echo $breadcrumb['index_url']['name']; ?></a></li> <?php
                    if (!empty($breadcrumb['lists_url']['path']) && !empty($breadcrumb['lists_url']['name'])) {
                        foreach (array_combine($breadcrumb['lists_url']['path'], $breadcrumb['lists_url']['name']) as $key => $value) { ?>
                            <li><a href="<?php echo $key; ?>"><?php echo $value; ?></a></li> <?php
                        }
                    } ?>
                    <li><span class="show-for-sr">Current: </span> <?php echo $breadcrumb['currt_url']['name']; ?></li>
                </ul>
            </nav>
        </div>
    </div>
</section>