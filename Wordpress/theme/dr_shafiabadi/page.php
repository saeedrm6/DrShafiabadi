<?php get_header(); ?>

  <br><br><br><br>
  <section id="page">

    <div class="col-md-9">
      <?php while(have_posts()) : the_post(); ?>
        <div class="page_content">
          <div class="title_bar">
            <a href=""><h1><i class="fa fa-edit"></i> <?php the_title(); ?></h1></a>
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
                <?php
                $pic = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
                if ($pic) {
                  ?>
                  <center><img src="<?= $pic[0]; ?>" class="img-responsive" alt="<?php the_title(); ?>"></center>
                  <?php
                }
                  ?>
              </div>
              <p><?php the_content(); ?></p>
              <?php
                if (get_post_meta( get_the_ID(), "book" , true )) {
                  $book=get_post_meta( get_the_ID(), "book", true );?>

                  <div class="col-md-10">
                  <div class="book_ax">

                      <div class="first_tb">
                        <div class="row">
                          <div class="boxx"></div>
                          <?php
                              $args = array (
                                  'cat' => 8,
                                  'posts_per_page' => -1, //showposts is deprecated
                                  'orderby' => 'date',
                              );
                              $cat_posts = new WP_query($args);
                              if ($cat_posts->have_posts()) : while ($cat_posts->have_posts()) :
                                $cat_posts->the_post();
                                $adssrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
                                if (get_post_meta( get_the_ID(), "link" , true )) {
                                  $link=get_post_meta( get_the_ID(), "link", true );
                                }else{
                                  $link="";
                                }
                          ?>
                            <a class="tooltipp" data-toggle="tooltip" data-placement="bottom" title="<?php the_title(); ?>" href="<?= $link; ?>"><img src="<?= $adssrc[0]; ?>" class="img-responsive" alt="<?php the_title(); ?>"></a>
                                <?php
                                  endwhile; endif;
                                ?>

                        </div>

                      </div>
                    <div class="clearfix"></div>
                      <div class="secound_tb">
                        <div class="row">
                          <div class="boxx"></div>
                          <?php
                          $args = array (
                              'cat' => 9,
                              'posts_per_page' => -1, //showposts is deprecated
                              'orderby' => 'date',
                          );
                          $cat_posts = new WP_query($args);
                          if ($cat_posts->have_posts()) : while ($cat_posts->have_posts()) :
                            $cat_posts->the_post();
                            $adssrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
                            if (get_post_meta( get_the_ID(), "link" , true )) {
                              $link=get_post_meta( get_the_ID(), "link", true );
                            }else{
                              $link="";
                            }
                            ?>
                            <a class="tooltipp" data-toggle="tooltip" data-placement="bottom" title="<?php the_title(); ?>" href="<?= $link; ?>"><img src="<?= $adssrc[0]; ?>" class="img-responsive" alt="<?php the_title(); ?>"></a>
                            <?php
                          endwhile; endif;
                          ?>

                        </div>
                      </div>

                    <div class="clearfix"></div>

                    <div class="third_tb">
                      <div class="row">
                        <div class="boxx"></div>
                        <?php
                        $args = array (
                            'cat' => 10,
                            'posts_per_page' => -1, //showposts is deprecated
                            'orderby' => 'date',
                        );
                        $cat_posts = new WP_query($args);
                        if ($cat_posts->have_posts()) : while ($cat_posts->have_posts()) :
                          $cat_posts->the_post();
                          $adssrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
                          if (get_post_meta( get_the_ID(), "link" , true )) {
                            $link=get_post_meta( get_the_ID(), "link", true );
                          }else{
                            $link="";
                          }
                          ?>
                          <a class="tooltipp" data-toggle="tooltip" data-placement="bottom" title="<?php the_title(); ?>" href="<?= $link; ?>"><img src="<?= $adssrc[0]; ?>" class="img-responsive" alt="<?php the_title(); ?>"></a>
                          <?php
                        endwhile; endif;
                        ?>

                      </div>
                    </div>

                    <div class="fourth_tb">
                      <div class="row">
                        <div class="boxx"></div>
                        <?php
                        $args = array (
                            'cat' => 11,
                            'posts_per_page' => -1, //showposts is deprecated
                            'orderby' => 'date',
                        );
                        $cat_posts = new WP_query($args);
                        if ($cat_posts->have_posts()) : while ($cat_posts->have_posts()) :
                          $cat_posts->the_post();
                          $adssrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 720,405 ), false, '' );
                          if (get_post_meta( get_the_ID(), "link" , true )) {
                            $link=get_post_meta( get_the_ID(), "link", true );
                          }else{
                            $link="";
                          }
                          ?>
                          <a class="tooltipp" data-toggle="tooltip" data-placement="bottom" title="<?php the_title(); ?>" href="<?= $link; ?>"><img src="<?= $adssrc[0]; ?>" class="img-responsive" alt="<?php the_title(); ?>"></a>
                          <?php
                        endwhile; endif;
                        ?>

                      </div>
                    </div>

                    <div class="fivth_tb">
                      <div class="row">
                        <div class="boxx"></div>

                      </div>
                    </div>

                    </div>

                  </div>
                  <div class="col-md-2"></div>


                  <?php
                }
              ?>
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
            <div class="clearfix"></div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    

    <?php
      include_once "sidebar.php";
    ?>
  </section>



    <div class="clearfix"></div>

<?php get_footer(); ?>