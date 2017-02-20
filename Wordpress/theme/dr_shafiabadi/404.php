<?php get_header(); ?>

    <br><br><br><br>
    <section id="page">

        <div class="col-md-9">

                <div class="page_content">
                    <div class="title_bar">
                        <a href=""><h1><i class="fa fa-edit"></i> خطا 404</h1></a>
                        <div class="descript">
                            <ul>
                                <li><i class="fa fa-user-circle"></i> نویسنده : </li>
                                <li><i class="fa fa-calendar"></i> تاریخ انتشار : <?php the_time('d-m-y') ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10" id="post_content_text">
                            <div class="img_post">

                                <center><img src="" class="img-responsive" alt=""></center>
                            </div>
                            <p>با عرض پوزش</p>
                            <p>مطلب مورد نظر یافت نشد!</p>
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

        </div>


        <?php
        include_once "sidebar.php";
        ?>

    </section>



    <div class="clearfix"></div>

<?php get_footer(); ?>