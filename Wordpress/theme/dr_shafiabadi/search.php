<?php get_header(); ?>

    <br><br><br><br>
    <section id="page">

        <div class="col-md-9">
            <?php while(have_posts()) : the_post(); ?>
                <div class="page_content">
                    <div class="title_bar">
                        <a href="<?php the_permalink() ?>"><h1><i class="fa fa-edit"></i> <?php the_title(); ?></h1></a>
                        <div class="descript">
                            <ul>
                                <li><i class="fa fa-user-circle"></i> نویسنده : <?php the_author(); ?></li>
                                <li><i class="fa fa-calendar"></i> تاریخ انتشار : <?php the_time('d-m-y') ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10" id="post_content_text">
                            <div class="img_post">

                                <center><img src="" class="img-responsive" alt=""></center>
                            </div>
                            <p><?php the_content(); ?></p>
                            <a href="<?php the_permalink() ?>" class="btn btn-md btn-primary pull-left">بیشتر بخوانید</a>
                        </div>
                        <div class="col-md-2" id="shareit">
                            <center><h3>اشتراک با</h3></center>
                            <center>
                                <ul>
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" target="_blank"><i class="fa fa-facebook-square fa-4x"></i></a></li>
                                    <li><a href="http://twitter.com/share?text=text&url=<?php the_permalink() ?>" target="_blank"><i class="fa fa-twitter-square fa-4x"></i></a></li>
                                    <li><a href="https://telegram.me/share/url?url=<?php the_permalink() ?>" target="_blank"><i class="fa fa-telegram fa-4x"></i></a></li>
                                </ul>
                            </center>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php if(!have_posts()) : ?>
                <div class="page_content">
                    <div class="title_bar">
                        <a href=""><h1><i class="fa fa-edit"></i> نتیجه جستجو</h1></a>
                        <div class="descript">
                            <ul>
                                <li><i class="fa fa-user-circle"></i> نویسنده : <?php the_author(); ?></li>
                                <li><i class="fa fa-calendar"></i> تاریخ انتشار : <?php the_time('d-m-y') ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10" id="post_content_text">
                            <div class="img_post">

                                <center><img src="" class="img-responsive" alt=""></center>
                            </div>
                            <p>موردی یافت نشد!</p>

                        </div>
                        <div class="col-md-2" id="shareit">
                            <center><h3>اشتراک با</h3></center>
                            <center>
                                <ul>
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" target="_blank"><i class="fa fa-facebook-square fa-4x"></i></a></li>
                                    <li><a href="http://twitter.com/share?text=text&url=<?php the_permalink() ?>" target="_blank"><i class="fa fa-twitter-square fa-4x"></i></a></li>
                                    <li><a href="https://telegram.me/share/url?url=<?php the_permalink() ?>" target="_blank"><i class="fa fa-telegram fa-4x"></i></a></li>
                                </ul>
                            </center>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(function_exists('page_navi_slider')){page_navi_slider();}?>
        </div>


        <?php
        include_once "sidebar.php";
        ?>
    </section>



    <div class="clearfix"></div>

<?php get_footer(); ?>