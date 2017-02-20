<?php
include "header.php";
?>
    <section id="slider">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">

          <div class="item active">
            <img class="img-responsive" src="<?php bloginfo('template_url'); ?>/images/sweslamshahr.jpg" alt="sweslamshahr">
            <div class="enter">
              <div class="row">
                <div class="details">
                  <h3>اردوی استارتاپ ویکند دانشگاه آزاد اسلامی واحد اسلامشهر</h3>
                </div>

              </div>
            </div>
          </div>

<!--          <div class="item">-->
<!--            <img class="img-responsive" src="--><?php //bloginfo('template_url'); ?><!--/images/192.jpg" alt="Chania">-->
<!--            <div class="enter">-->
<!--              <div class="row">-->
<!--                <div class="details">-->
<!--                  <h3>این سایت برای مدتی در حال تست و آزمایش باقی خواهد ماند. انشاءالله پس از رفع اشکالات، به روز رسانی و بارگذاری خواهد شد. </h3>-->
<!--                </div>-->
<!--                <div class="pic">-->
<!--                  <img src="--><?php //bloginfo('template_url'); ?><!--/images/shafi.png" class="img-responsive" alt="">-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->

          <div class="item">
            <img class="img-responsive" src="<?php bloginfo('template_url'); ?>/images/slide-3.jpg" alt="مجتمع پرفسور حسابی">
            <div class="enter">
              <div class="row">
                <div class="details">
                  <h3>دانشگاه آزاد اسلامی واحد اسلامشهر</h3>
                </div>
              </div>
            </div>
          </div>


          <div class="item">
            <img class="img-responsive" src="<?php bloginfo('template_url'); ?>/images/hesabi.jpg" alt="مجتمع پرفسور حسابی">
            <div class="enter">
              <div class="row">
                <div class="details">
                  <h3 style="color: #1b6d85;">مجتمع پرفسور حسابی دانشگاه آزاد اسلامی واحد اسلامشهر</h3>
                </div>
              </div>
            </div>
          </div>

          <div class="item">
            <img class="img-responsive" src="<?php bloginfo('template_url'); ?>/images/vahed.jpg" alt="مجتمع پرفسور حسابی">
            <div class="enter">
              <div class="row">
                <div class="details">
<!--                  <h3>دانشگاه آزاد اسلامی واحد اسلامشهر</h3>-->
                </div>
              </div>
            </div>
          </div>


        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
<!--      --><?php
//      putRevSlider("slider1");
//
      ?>
    </section>

    <section id="news">
    <br><br><br>
      <center><h2>اخبار و رویداد ها</h2></center>
      <br><br>
      <div class="container">
        <!--        start of omomi-->
        <div class="col-md-4 col-sm-6 col-xs-12" id="boxes">
          <div class="headtitle">
            <h2><i class="glyphicon glyphicon-bookmark text-danger"></i> اخبار عمومی</h2>
          </div>
          <br>

          
        <div id="omomi" class="carousel slide" data-ride="carousel">
            <?php
              $args = array(
                  'cat' => 3
              );
              $the_query = new WP_Query( $args );
              $loop = $the_query->found_posts;
            ?>
            <ol class="carousel-indicators">
              <?php
                for ($i=0; $i<$loop ; $i++) { 
                  if ($i==0){
                    echo "<li data-target=\"#omomi\" data-slide-to=\"0\" class=\"active\"></li>";
                    continue;
                  }
                  echo "<li data-target=\"#omomi\" data-slide-to=\"$i\"></li>";
                }
              ?>

            </ol>

            <div class="carousel-inner" role="listbox">

              <?php
                $my_query = new WP_Query('showposts=5&cat=3');
               $ii=0;
                while ($my_query->have_posts()):
                $my_query->the_post();
                $do_not_duplicate = $post->ID;
                  ?>

              <div class="newscontent item <?php if ($ii==0) echo " active"; ?>">
                <?php
                  $adssrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
                ?>
                <center><img class="img-responsive" src="<?= $adssrc[0]; ?>" alt="<?php the_title();?>"></center>
                <br>
                <h3><?php the_title(); ?></h3><br>
                <p class="text-justify"><?php the_content(''); ?></p>
                <br>
                <a href="<?php the_permalink() ?>" style="float:left;"><button class="btn btn-warning">بیشتر بخوانید...</button></a>
              </div>

                <?php
                ++ $ii;
                endwhile;
              ?>


            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control newcontrol" href="#omomi" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control newcontrol" href="#omomi" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>


          </div>

        </div>
<!--        end of omomi-->

        <!--        start of conf-->
        <div class="col-md-4 col-sm-6 col-xs-12" id="boxes">
          <div class="headtitle">
            <h2><i class="glyphicon glyphicon-bookmark text-danger"></i> کنفرانس ها و همایش ها</h2>
          </div>
          <br>
          <div id="confernce" class="carousel slide" data-ride="carousel">
            <?php
            $args = array(
                'cat' => 4
            );
            $the_query = new WP_Query( $args );
            $loop = $the_query->found_posts;
            ?>
            <ol class="carousel-indicators">
              <?php
              for ($i=0; $i<$loop ; $i++) {
                if ($i==0){
                  echo "<li data-target=\"#confernce\" data-slide-to=\"0\" class=\"active\"></li>";
                  continue;
                }
                echo "<li data-target=\"#confernce\" data-slide-to=\"$i\"></li>";
              }
              ?>

            </ol>

            <div class="carousel-inner" role="listbox">
            <?php
            $my_query = new WP_Query('showposts=5&cat=4');
            $iii=0;
            while ($my_query->have_posts()):
              $my_query->the_post();
              $do_not_duplicate = $post->ID;
              ?>

              <div class="newscontent item <?php if ($iii==0) echo " active"; ?>">
                <?php
                $adssrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
                ?>
                <center><img class="img-responsive" src="<?= $adssrc[0]; ?>" alt="<?php the_title();?>"></center>
                <br>
                <h3><?php the_title(); ?></h3><br>
                <p class="text-justify"></p>
                <br>
                <a href="<?php the_permalink() ?>" style="float:left;"><button class="btn btn-warning">بیشتر بخوانید...</button></a>
              </div>
              <?php
              ++ $iii;
            endwhile;
            ?>



            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control newcontrol" href="#confernce" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control newcontrol" href="#confernce" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>


          </div>
        </div>
        <!--        end of conf-->

        <!--        start of tec-->
        <div class="col-md-4 col-sm-6 col-xs-12" id="boxes">
          <div class="headtitle">
            <h2><i class="glyphicon glyphicon-bookmark text-danger"></i> اخبار تکنولوژی</h2>
          </div>
          <br>
          <div id="technews" class="carousel slide" data-ride="carousel">

            <?php
            $args = array(
                'cat' => 5
            );
            $the_query = new WP_Query( $args );
            $loop = $the_query->found_posts;
            ?>
            <ol class="carousel-indicators">
              <?php
              for ($i=0; $i<$loop ; $i++) {
                if ($i==0){
                  echo "<li data-target=\"#technews\" data-slide-to=\"0\" class=\"active\"></li>";
                  continue;
                }
                echo "<li data-target=\"#technews\" data-slide-to=\"$i\"></li>";
              }
              ?>

            </ol>

            <div class="carousel-inner" role="listbox">

              <?php
              $my_query = new WP_Query('showposts=5&cat=5');
              $iiii=0;
              while ($my_query->have_posts()):
                $my_query->the_post();
                $do_not_duplicate = $post->ID;
                ?>
              <div class="newscontent item <?php if ($iiii==0) echo " active"; ?>">
                <?php
                $adssrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
                ?>
                <center><img class="img-responsive" src="<?= $adssrc[0]; ?>" alt="<?php the_title();?>"></center>
                <br>
                <h3><?php the_title(); ?></h3><br>
                <p class="text-justify"><?php the_content(''); ?></p>
                <br>
                <a href="<?php the_permalink() ?>" style="float:left;"><button class="btn btn-warning">بیشتر بخوانید...</button></a>
              </div>
                <?php
                ++ $iiii;
              endwhile;
              ?>



            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control newcontrol" href="#technews" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control newcontrol" href="#technews" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>


          </div>
        </div>
        <!--        start of tec-->
        <div class="clearfix"></div>

      </div>
    </section>

    <br><br><br>

    <section id="aboutdr">
      <div class="container">

        <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
          <br>
          <br>
          <br>
          <br>
          <h2>دکتر محمد حسین شفیع آبادی</h2>
          <br><br>
          <p>سوابق علمی</p>
          <ul>
            <li>کارشناسی کامپيوتر -سخت افزار ، شهيد بهشتي(1376 الی 1380)</li>
            <li>کارشناسي ارشد-کامپيوتر(معماري سيستم هاي کامپيوتري)–صنعتي امير کبير (1381 الی 1383)</li>
            <li>دکتری تخصصی کامپیوتر(معماري سيستم هاي کامپيوتري)-علوم تحقیقات تهران</li>
          </ul>
          <br>
          <p>سوابق اجرایی</p>
          <ul>
            <li>هیات علمی دانشگاه آزاد اسلامی واحد اسلامشهر-گروه کامپیوتر(1384 تا کنون)</li>
            <li>مدیر گروه کامپیوتر (1390 تا کنون)</li>
            <li>سرپرست مجتمع فنی پروفسورحسابی(1391 تاکنون)</li>
          </ul>
          <button class="btn btn-primary pull-left">بیشتر بخوانید</button>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
          <img src="<?php bloginfo('template_url'); ?>/images/drshafiabadi.png" class="img-responsive" alt="">
        </div>

      </div>
    </section>

    <section id="articls">
      <br><br>
      <center><h2>مقالات</h2></center>
      <br>
      
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        
        <div id="books" class="carousel slide" data-ride="carousel">
          <?php
//          var_dump($maghalat);
          $lst = sizeof($maghalat);
          ?>
              <ol class="carousel-indicators">
                <?php
                  for ($i=0;$i<$lst;$i++) {
                    ?>
                    <li data-target="#books" data-slide-to="<?php echo $i;?>" <?php if ($i==0) echo "class=\"active\""; ?>></li>
                    <?php
                  }
                    ?>
              </ol>

              <div class="carousel-inner" role="listbox">

                <?php
                  global $maghalat;
                  $looper = 0;
                  foreach ($maghalat as $name => $link) {
                    ?>

                    <div class="item <?php if ($looper==0) echo "active"; ?>">
                      <center>
                        <ul>
                          <li>
                            <a href="<?php echo $link; ?>"><img src="<?php bloginfo('template_url'); ?>/images/mg1.jpg" class="img-responsive" alt=""></a>
                          </li>
                        </ul>
                      </center>
                      <p class="text-center text-success"><?php echo $name; ?></p>
                    </div>

                    <?php
                    $looper++;
                  }
                    ?>

<!--                <div class="item">-->
<!--                  <center><ul>-->
<!--                    <li>-->
<!--                      <img src="--><?php //bloginfo('template_url'); ?><!--/images/book1.png" class="img-responsive" alt="">-->
<!--                    </li>-->
<!--                  </ul></center>-->
<!--                  <p class="text-center text-success">Synchronization of Two Different Chaotic Neural Networks with Unknown Time Delay Using Time-Scale Separation Technique(2012)</p>-->
<!--                </div>-->

              </div>

              <a class="left carousel-control newcontrol" href="#books" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control newcontrol" href="#books" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

          <div id="bookcase">
            
          </div>
        <div class="clearfix"></div>
        
      </div>
    </section>

    <div class="clearfix"></div>

<?php
include "footer.php";
?>