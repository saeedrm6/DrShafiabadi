<sidebar class="col-md-3">

    <div class="widget">
        <div class="stripe-line"></div>
        <div class="widget-container">
            <a target="_blank" href="https://telegram.me/joinchat/D1QgmEBsi7vYGJ8ZqNdKGw"><img src="<?php bloginfo('template_url'); ?>/images/tl.jpg" class="pull-left img-responsive" alt=""></a>
            <a target="_blank" href="https://calendar.google.com/calendar/embed?src=uni.shafiabadi%40gmail.com&ctz=Asia/Tehran"><img src="<?php bloginfo('template_url'); ?>/images/calc.png" class="pull-left img-responsive img-circle" alt=""></a>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="widget">
        <div class="stripe-line"></div>
        <div class="widget-container">
            <h3>جستجو</h3>

                <form role="search" method="get" id="searchform" class="searchform" action="<?php bloginfo('url'); ?>">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input name="s" id="s" type="text" class="form-control" placeholder="عبارت را وارد نمایید">
                            <span class="input-group-btn">
                                <button id="searchsubmit" class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-12 -->
                </form>
                <br><br>

        </div>
        <br>
    </div>


    <?php
    dynamic_sidebar('wg_sidebar');
    ?>

</sidebar>