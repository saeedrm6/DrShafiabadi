<?php

/**
 * @package All-in-One-SEO-Pack
 */

class aiosp_metaboxes {
	
	function __construct() {
		//construct

	}
	

	
	
	
	
	
	static function display_extra_metaboxes( $add, $meta ) {
		echo "<div class='aioseop_metabox_wrapper' >";
		switch ( $meta['id'] ) {
			case "aioseop-about":
				?><div class="aioseop_metabox_text">
							<p><h2 style="display:inline;"><?php echo AIOSEOP_PLUGIN_NAME; ?></h2><?php sprintf( __( "by %s of %s.", 'all-in-one-seo-pack' ), 'Michael Torbert', '<a target="_blank" title="Semper Fi Web Design"
							href="http://semperfiwebdesign.com/">Semper Fi Web Design</a>' ); ?>.</p>
							<?php
							global $current_user;
							$user_id = $current_user->ID;
							$ignore = get_user_meta( $user_id, 'aioseop_ignore_notice' );
							if ( !empty( $ignore ) ) {
								$qa = Array();
								wp_parse_str( $_SERVER["QUERY_STRING"], $qa );
								$qa['aioseop_reset_notices'] = 1;
								$url = '?' . build_query( $qa );
								echo '<p><a href="' . $url . '">' . __( "Reset Dismissed Notices", 'all-in-one-seo-pack' ) . '</a></p>';
							}
							if ( !AIOSEOPPRO ) {
							?>
							<p>
							<strong><?php echo aiosp_common::get_upgrade_hyperlink( 'side', __('Pro Version', 'all-in-one-seo-pack'), __('UPGRADE TO PRO VERSION', 'all-in-one-seo-pack'), '_blank' );  ?></strong></p>
							<?php } ?>
						</div>
				<?php
		    case "aioseop-donate":
		        ?>
				<div>

				<?php if ( !AIOSEOPPRO ) { ?>
					<div class="aioseop_metabox_text">
						<p>If you like this plugin and find it useful, help keep this plugin free and actively developed by clicking the <a 				href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mrtorbert%40gmail%2ecom&item_name=All%20In%20One%20SEO%20Pack&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8"
							target="_blank"><strong>donate</strong></a> button or send me a gift from my <a
							href="https://www.amazon.com/wishlist/1NFQ133FNCOOA/ref=wl_web" target="_blank">
							<strong>Amazon wishlist</strong></a>.  Also, don't forget to follow me on <a
							href="http://twitter.com/michaeltorbert/" target="_blank"><strong>Twitter</strong></a>.
						</p>
					</div>
				<?php } ?>

					<div class="aioseop_metabox_feature">

				<?php if ( !AIOSEOPPRO ) { ?>
								<a target="_blank" title="<?php _e( 'Donate', 'all-in-one-seo-pack' ); ?>"
	href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mrtorbert%40gmail%2ecom&item_name=All%20In%20One%20SEO%20Pack&item_number=Support%20Open%20Source&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">
					<img src="<?php echo AIOSEOP_PLUGIN_URL; ?>images/donate.jpg" alt="<?php _e('Donate with Paypal', 'all-in-one-seo-pack' ); ?>" />	</a>
					<a target="_blank" title="Amazon Wish List" href="https://www.amazon.com/wishlist/1NFQ133FNCOOA/ref=wl_web">
					<img src="<?php echo AIOSEOP_PLUGIN_URL; ?>images/amazon.jpg" alt="<?php _e('My Amazon Wish List', 'all-in-one-seo-pack' ); ?>" /> </a>
				<?php } ?>

					<a target="_blank" title="<?php _e( 'Follow us on Facebook', 'all-in-one-seo-pack' ); ?>" href="http://www.facebook.com/pages/Semper-Fi-Web-Design/121878784498475"><span class="aioseop_follow_button aioseop_facebook_follow"></span></a>
					<a target="_blank" title="<?php _e( 'Follow us on Twitter', 'all-in-one-seo-pack' ); ?>" href="http://twitter.com/semperfidev/"><span class="aioseop_follow_button aioseop_twitter_follow"></span></a>
					</div><?php if(get_locale() != 'en_US'){ ?>
					<div>
					</div>
					<?php } ?>
				</div>
		        <?php
		        break;
			case "aioseop-list":
			?>
				<div class="aioseop_metabox_text">
						<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:right; font:14px Tahoma, Geneva, sans-serif; }
</style>
<div id="mc_embed_signup">
<center><form action="//shahedi.us10.list-manage.com/subscribe/post?u=6dae518e7aef9b9211c30ba6f&amp;id=61542777a3" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<h2 align="center">عضویت در گروه طراحان</h2>
<div class="indicates-required">
<div class="mc-field-group">
	<label for="mce-EMAIL">آدرس ایمیلتان را اینجا وارد نمائید و هر ماه یک محصول ویژه را از ما هدیه بگیرید <span class="asterisk">*</span>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL"></label>
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; right: -5000px;"><input type="text" name="b_6dae518e7aef9b9211c30ba6f_61542777a3" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="ثبت اشتراک" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form></center>
</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text'; /*
 * Translated default messages for the $ validation plugin.
 * Locale: FA
 */
$.extend($.validator.messages, {
       required: "تکمیل این فیلد اجباری است.",
       remote: "لطفا این فیلد را تصحیح کنید.",
       email: ".لطفا یک ایمیل صحیح وارد کنید",
       url: "لطفا آدرس صحیح وارد کنید.",
       date: "لطفا یک تاریخ صحیح وارد کنید",
       dateISO: "لطفا تاریخ صحیح وارد کنید (ISO).",
       number: "لطفا عدد صحیح وارد کنید.",
       digits: "لطفا تنها رقم وارد کنید",
       creditcard: "لطفا کریدیت کارت صحیح وارد کنید.",
       equalTo: "لطفا مقدار برابری وارد کنید",
       accept: "لطفا مقداری وارد کنید که ",
       maxlength: $.validator.format("لطفا بیشتر از {0} حرف وارد نکنید."),
       minlength: $.validator.format("لطفا کمتر از {0} حرف وارد نکنید."),
       rangelength: $.validator.format("لطفا مقداری بین {0} تا {1} حرف وارد کنید."),
       range: $.validator.format("لطفا مقداری بین {0} تا {1} حرف وارد کنید."),
       max: $.validator.format("لطفا مقداری کمتر از {0} حرف وارد کنید."),
       min: $.validator.format("لطفا مقداری بیشتر از {0} حرف وارد کنید.")
});}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->
				</div>
			<?php
				break;
		    case "aioseop-support":
		        ?><div class="aioseop_metabox_text">
				 <h3>تماس با تیم پرو استایل</h3>
                <p>
                    <strong>پشتیبانی محصولات </strong></p>
                    <p>برای دریافت راهنمایی لطفا توضیحات خود را در مورد خطای پیش آمده همراه با اطلاعات ورود به سایت با نقش مدیر را به ایمیل <span style="border-bottom: 1px solid;">Info@prostyle.ir</span> ارسال فرمائید تا در اولین فرصت اقدامات لازم انجام شود .
                </p>
                <p>
                    <p><strong>دریافت مشاوره در مورد سایر محصولات</strong></p>
             
                <p>وب سایت تیم پرو استایل : www.prostyle.ir
                </p>
                <p><div class="aioseop_icon aioseop_Telegram_icon"></div><a target="_blank" href="https://telegram.me/wpdesigners"><?php _e( 'عضویت در گروه تلگرام مشتریان برای آخرین اخبار محصولات', 'all_in_one_seo_pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_pc_icon"></div><a target="_blank" href="http://marketwp.ir/author/pchelper/"><?php _e( 'مشاهده سایر محصولات تیم پرو استایل', 'all_in_one_seo_pack' ); ?></a></p>
                <p><div class="aioseop_icon aioseop_file_icon"></div><a target="_blank" href="http://semperplugins.com/documentation/"><?php _e( 'Read the All in One SEO Pack user guide', 'all_in_one_seo_pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_support_icon"></div><a target="_blank" title="<?php _e( 'All in One SEO Pro Plugin Support Forum', 'all-in-one-seo-pack' ); ?>"
				href="http://semperplugins.com/support/"><?php _e( 'Access our Premium Support Forums', 'all-in-one-seo-pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_cog_icon"></div><a target="_blank" title="<?php _e( 'All in One SEO Pro Plugin Changelog', 'all-in-one-seo-pack' ); ?>"
				href="<?php if ( AIOSEOPPRO ) { echo 'http://semperplugins.com/documentation/all-in-one-seo-pack-pro-changelog/'; } else { echo 'http://semperfiwebdesign.com/blog/all-in-one-seo-pack/all-in-one-seo-pack-release-history/'; } ?>"><?php _e( 'View the Changelog', 'all-in-one-seo-pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_youtube_icon"></div><a target="_blank" href="http://semperplugins.com/doc-type/video/"><?php _e( 'Watch video tutorials', 'all-in-one-seo-pack' ); ?></a></p>
				<p><div class="aioseop_icon aioseop_book_icon"></div><a target="_blank" href="http://semperplugins.com/documentation/quick-start-guide/"><?php _e( 'Getting started? Read the Beginners Guide', 'all-in-one-seo-pack' ); ?></a></p>
				</div>
		        <?php
		        break;
		}
		echo "</div>";
	}
	
	
	
	
	
	
	
	
	
}