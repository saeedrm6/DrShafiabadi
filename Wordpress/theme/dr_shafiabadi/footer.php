<footer id="footer">
<!--    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">-->
<!--        <br>-->
<!--        <h3><i class="fa fa-x fa-link"></i> پیوند ها</h3>-->
<!--        <hr>-->
<!--        <ul class="latestnews">-->
<!--            <li><a href="">انجمن کامپیوتر واحد اسلامشهر</a></li>-->
<!--            <li><a href="">دانلود الگوهای اماده ارائه</a></li>-->
<!--            <li><a href="">گروه کامپیوتر دانشگاه اسلامشهر</a></li>-->
<!--        </ul>-->
<!--        <br>-->
<!--        <h3><i class="glyphicon glyphicon-envelope"></i> عضویت در خبرنامه سایت</h3>-->
<!--        <hr>-->
<!--        <form action="" method="">-->
<!--            <div class="inputform">-->
<!--                <input type="email" name="" placeholder="Email">-->
<!--                <i class="fa fa-x fa-vcard"></i>-->
<!--            </div>-->
<!--            <input class="btn btn-default" type="hidden" value="مشترک کن" hidden="hidden">-->
<!--        </form>-->
<!--    </div>-->
    <?php
        dynamic_sidebar('link_wg_footer');
        dynamic_sidebar('news_wg_footer');
    ?>
    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
        <br><br>
        <ul class="footnav">
            <li role="presentation"><a href="#">گالری تصاویر</a></li>
            <li role="presentation"><a href="#">اخبار</a></li>
            <li role="presentation"><a href="#">پرسش و پاسخ</a></li>
            <li role="presentation"><a href="#">تماس با ما</a></li>
            <li role="presentation"><a href="#">انتشارات</a></li>
        </ul>
        <div class="clearfix"></div>
        <br>
        <center>
            <ul class="footnavsocial">
                <li><a href=""><i class="fa fa-3x fa-twitter-square"></i></a></li>
                <li><a href=""><i class="fa fa-3x fa-instagram"></i></a></li>
                <li><a href=""><i class="fa fa-3x fa-telegram"></i></a></li>
                <li><a href=""><i class="fa fa-3x fa-facebook-square"></i></a></li>
            </ul>
        </center>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="fotcop">
        <center>
            <p>تمامی حقوق وب سایت محفوظ می باشد</p>
            <a href="http://rahimimanesh.com" id="copyright">طراحی و برنامه نویسی : سعید رحیمی منش</a>
        </center>
    </div>
</footer>
<div class="clearfix"></div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
<?php wp_footer(); ?>
</body>
</html>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
