<?php
require_once('wp_bootstrap_navwalker.php');
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    add_post_type_support( 'support', 'thumbnail' );
}

function shafi_setup(){
    add_theme_support('title-tag');
}
add_action('after_setup_theme',"shafi_setup");

function register_my_menu() {
  register_nav_menu('top_menu',__( 'تاپ منو' ));
}
add_action( 'init', 'register_my_menu' );

function shafi_widgets_init(){
    register_sidebar(array(
        'name'=>'اخبارفوتر',
        'id'=>'news_wg_footer',
        'before_widget'=>'<div id="latestnews" class="col-md-4 col-lg-4 col-sm-4 col-xs-12">',
        'after_widget'=>'</div>',
        'before_title'=>'<h3><i class="fa fa-x fa-newspaper-o"></i> &nbsp;',
        'after_title'=>'</h3><hr>',
    ));
}
add_action('widgets_init','shafi_widgets_init');

function shafi_widgets_init2(){
    register_sidebar(array(
        'name'=>'پیوندفوتر',
        'id'=>'link_wg_footer',
        'before_widget'=>'<br><div id="latestnews" class="col-md-4 col-lg-4 col-sm-4 col-xs-12">',
        'after_widget'=>'</div>',
        'before_title'=>'<h3><i class="fa fa-x fa-link"></i> &nbsp;',
        'after_title'=>'</h3><hr>',
    ));
}
add_action('widgets_init','shafi_widgets_init2');

function shafi_widgets_sidebar(){
    register_sidebar(array(
        'name'=>'سایدبار',
        'id'=>'wg_sidebar',
        'before_widget'=>'<div class="widget"><div class="stripe-line"></div><div class="widget-container">',
        'after_widget'=>'<div class="clearfix"></div></div></div>',
        'before_title'=>'<h3>',
        'after_title'=>'</h3>',
    ));
}
add_action('widgets_init','shafi_widgets_sidebar');


$maghalat = ["Synchronization of Two Different Chaotic Neural Networks with Unknown Time Delay Using Time-Scale Separation Technique(2012)"=>"https://www.researchgate.net/profile/Mohammad_Hossein_Shafiabadi/publication/310588620_Synchronization_of_Two_Different_Chaotic_Neural_Networks_with_Unknown_Time_Delay_Using_Time-Scale_Separation_Technique/links/5831f04108ae004f74c2aa41/Synchronization-of-Two-Different-Chaotic-Neural-Networks-with-Unknown-Time-Delay-Using-Time-Scale-Separation-Technique.pdf","Feedback Error Learning using Laguerre-based Controller to Control the Velocity of an Electro Hydraulic Servo System(2012)"=>"","Using ANFIS Method For Modeling Of High Chromium Alloy Wear In Phosphate Laboratory Grinding Mill2012)"=>""];
?>