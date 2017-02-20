<?php
/**
 * @package All-in-One-SEO-Pack
 */
/**
 * The Sitemap class.
 */
if ( !class_exists( 'All_in_One_SEO_Pack_Sitemap' ) ) {
	class All_in_One_SEO_Pack_Sitemap extends All_in_One_SEO_Pack_Module {
		var $cache_struct = null;
		var $cache_home = null;
		var $comment_string;
		var $start_memory_usage = 0;
		var $max_posts = 50000;
		var $paginate = false;
		var $prio;
		var $prio_sel;
		var $freq;
		var $freq_sel;
		var $extra_sitemaps;
		
		function __construct( ) {
			if ( get_class( $this ) === 'All_in_One_SEO_Pack_Sitemap' ) { // Set this up only when instantiated as this class
				$this->name = __( 'XML Sitemap', 'all-in-one-seo-pack' ); // Human-readable name of the plugin
				$this->prefix = 'aiosp_sitemap_';						  // option prefix
				$this->file = __FILE__;									  // the current file
				$this->extra_sitemaps = Array();
				$this->extra_sitemaps = apply_filters( $this->prefix . 'extra', $this->extra_sitemaps );				
			}
			parent::__construct();
			$this->comment_string = __( "نقشه سایت %s با ابزار بسته سئو %s تیم پرو استایل [www.prostyle.ir]تولید شده است در  %s  ", 'all-in-one-seo-pack' );

			$this->help_text = Array(
				"filename"			=> __( "Specifies the name of your sitemap file. This will default to 'sitemap'.", 'all-in-one-seo-pack' ),
				"google"			=> __( "Notify Google when you update your sitemap settings.", 'all-in-one-seo-pack' ),
				"bing"				=> __("Notify Bing when you update your sitemap settings.", 'all-in-one-seo-pack' ),
				"daily_cron"		=> __( "Notify search engines daily, and also update static sitemap daily if in use. (this uses WP-Cron, so make sure this is working properly on your server as well)", 'all-in-one-seo-pack' ),
				"indexes"			=> __( "Organize sitemap entries into distinct files in your sitemap. Enable this only if your sitemap contains over 50,000 URLs or the file is over 5MB in size.", 'all-in-one-seo-pack' ),
				"paginate"			=> __( "Split long sitemaps into separate files.", 'all-in-one-seo-pack' ),
				"max_posts"			=> __( "Allows you to specify the maximum number of posts in a sitemap (up to 50,000).", 'all-in-one-seo-pack' ),
				"posttypes"			=> __( "Select which Post Types appear in your sitemap.", 'all-in-one-seo-pack' ),
				"taxonomies"		=> __( "Select which taxonomy archives appear in your sitemap", 'all-in-one-seo-pack' ),
				"archive"			=> __( "Include Date Archives in your sitemap.", 'all-in-one-seo-pack' ),
				"author"			=> __( "Include Author Archives in your sitemap.", 'all-in-one-seo-pack' ),
				"gzipped"			=> __( "Create a compressed sitemap file in .xml.gz format.", 'all-in-one-seo-pack' ),
				"robots"			=> __( "Places a link to your Sitemap.xml into your virtual Robots.txt file.", 'all-in-one-seo-pack' ),
				"rewrite"			=> __( "Places a link to the sitemap file in your virtual Robots.txt file which WordPress creates.", 'all-in-one-seo-pack' ),
				"noindex"			=> __( "Tells search engines not to index the sitemap file itself.", 'all-in-one-seo-pack' ),
				"debug"				=> __( "Use rewrites to generate your sitemap on the fly. NOTE: This is required for WordPress Multisite.", 'all-in-one-seo-pack'),
				"addl_url"			=> __( 'URL to the page.', 'all-in-one-seo-pack' ),
				"addl_prio"			=> __( 'The priority of the page.', 'all-in-one-seo-pack' ),
				"addl_freq"			=> __( 'The frequency of the page.', 'all-in-one-seo-pack' ),
				"addl_mod"			=> __( 'Last modified date of the page.', 'all-in-one-seo-pack' ),
				"excl_categories"	=> __( "Entries from these categories will be excluded from the sitemap.", 'all-in-one-seo-pack' ),
				"excl_pages"		=> __( "Use page slugs or page IDs, seperated by commas, to exclude pages from the sitemap.", 'all-in-one-seo-pack' )
			);
			
			$this->help_anchors = Array(
				'filename' => '#filename-prefix',
				'google' => '#notify-google-bing',
				'bing' => '#notify-google-bing',
				'indexes' => '#enable-sitemap-indexes',
				'posttypes' => '#post-types-and-taxonomies',
				'taxonomies' => '#post-types-and-taxonomies',
				'archive' => '#include-archive-pages',
				'author' => '#include-archive-pages',
				'gzipped' => '#create-compressed-sitemap',
				'robots' => '#link-from-virtual-robots',
				'rewrite' => '#dynamically-generate-sitemap',
				'addl_url' => '#additional-pages',
				'addl_prio' => '#additional-pages',
				'addl_freq' => '#additional-pages',
				'addl_mod' => '#additional-pages',
				'excl_categories' => '#excluded-items',
				'excl_pages' => '#excluded-items',
			);

			$this->default_options = array(
					'filename'	=> Array( 'name'	  => __( 'Filename Prefix',  'all-in-one-seo-pack' ),
				 						  'default'	  => 'sitemap', 'type' => 'text', 'sanitize' => 'filename' ),
					'google'	=> Array( 'name'	  => __( 'Notify Google', 'all-in-one-seo-pack') ),
					'bing'		=> Array( 'name'	  => __( 'Notify Bing',  'all-in-one-seo-pack') ),
					'daily_cron'=> Array( 'name'	  => __( 'Schedule Updates', 'all-in-one-seo-pack' ), 'type' => 'select',
										   'initial_options' => Array(	0		 => __( 'No Schedule', 'all-in-one-seo-pack' ),
																		'daily'	 => __( 'Daily', 'all-in-one-seo-pack' ),
																		'weekly' => __( 'Weekly', 'all-in-one-seo-pack' ),
																		'monthly'=> __( 'Monthly', 'all-in-one-seo-pack' ) ),
									  		'default' => 0 ),
					'indexes'	=> Array( 'name'	  => __( 'Enable Sitemap Indexes', 'all-in-one-seo-pack' ) ),
					'paginate'	=> Array( 'name'	  => __( 'Paginate Sitemap Indexes', 'all-in-one-seo-pack' ),
										  'condshow'  => Array( "{$this->prefix}indexes" => 'on' ) ),
					'max_posts' => Array( 'name'	  => __( 'Maximum Posts Per Sitemap', 'all-in-one-seo-pack' ),
										  'type' 	  => 'text', 'default' => 50000,
					 					  'condshow'  => Array( "{$this->prefix}indexes" => 'on', "{$this->prefix}paginate" => 'on' ) ),
					'posttypes' => Array( 'name'	  => __( 'Post Types', 'all-in-one-seo-pack'),
					 					  'type'	  => 'multicheckbox', 'default' => 'all' ),
					'taxonomies'=> Array( 'name'	  => __( 'Taxonomies', 'all-in-one-seo-pack' ),
										  'type'	  => 'multicheckbox', 'default' => 'all' ),
					'archive'	=> Array( 'name'	  => __( 'Include Date Archive Pages', 'all-in-one-seo-pack' ) ),
					'author'	=> Array( 'name'	  => __( 'Include Author Pages', 'all-in-one-seo-pack' ) ),
					'gzipped'	=> Array( 'name'	  => __( 'Create Compressed Sitemap', 'all-in-one-seo-pack' ), 'default' => 'On' ),
					'robots'	=> Array( 'name'	  => __( 'Link From Virtual Robots.txt', 'all-in-one-seo-pack' ), 'default' => 'On' ),
					'rewrite'	=> Array( 'name'	  => __( 'Dynamically Generate Sitemap', 'all-in-one-seo-pack' ), 'default'	  => 'On' ),
					'noindex'	=> Array( 'name'	  => __( 'Noindex Sitemap file', 'all-in-one-seo-pack' ),
										  'condshow'  => Array( "{$this->prefix}rewrite" => true ) )
			);
			
			$status_options = Array(
						'link'	 => Array( 'default' => '', 'type' => 'html', 'label' => 'none', 'save' => false ),
						'debug'  => Array( 'name' => __( 'Debug Log', 'all-in-one-seo-pack' ), 'default' => '', 'type' => 'html', 'disabled' => 'disabled', 'save' => false, 'label' => 'none', 'rows' => 5, 'cols' => 120, 'style' => 'min-width:950px' )
			);
			
			$this->layout = Array(
				'status' => Array(
						'name' => __( 'Sitemap Status', 'all-in-one-seo-pack' ),
						'help_link' => 'http://semperplugins.com/documentation/xml-sitemaps-module/',
						'options' => array_keys( $status_options ) ),
				'default' => Array(
						'name' => $this->name,
						'help_link' => 'http://semperplugins.com/documentation/xml-sitemaps-module/',
						'options' => array_keys( $this->default_options )
					)
			);
			
			$prio = Array();
			for( $i = 0; $i <= 10; $i++ ) {
				$str = sprintf( "%0.1f", $i / 10.0 );
				$prio[ $str ] = $str;
			}
			$arr_no = Array( 'no' => __( 'Do Not Override', 'all-in-one-seo-pack' ) );
			$arr_sel = Array( 'sel' => __( 'Select Individual', 'all-in-one-seo-pack' ) );
			$this->prio_sel = array_merge( $arr_no, $arr_sel, $prio );
			$this->prio = array_merge( $arr_no, $prio );
			
			$freq = Array();
			foreach ( Array( 'always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never' ) as $f ) $freq[ $f ] = $f;
			$this->freq_sel = array_merge( $arr_no, $arr_sel, $freq );
			$this->freq = array_merge( $arr_no, $freq );
			
			foreach( Array( 'prio' => __( 'priority', 'all-in-one-seo-pack' ), 'freq' => __( 'frequency', 'all-in-one-seo-pack' ) ) as $k => $v ) {
				$s = "{$k}_options";
				$$s = Array();
				foreach( Array( 'homepage'		=> __( 'homepage', 'all-in-one-seo-pack' ),
								'post'			=> __( 'posts', 'all-in-one-seo-pack' ),
								'taxonomies'	=> __( 'taxonomies', 'all-in-one-seo-pack' ),
								'archive'		=> __( 'archive pages', 'all-in-one-seo-pack' ),
								'author'		=> __( 'author pages', 'all-in-one-seo-pack' ) ) as $opt => $val ) {
					$arr = $$s;
					if ( ( $opt == 'post' ) || ( $opt == 'taxonomies' ) ) {
						$iopts = $this->{"{$k}_sel"};
					} else {
						$iopts = $this->$k;
					}
					
					$arr[ $k . '_' . $opt ] = Array( 'name' => $this->ucwords( $val ), 'help_text' => sprintf( __( "Manually set the %s of your %s.", 'all-in-one-seo-pack' ), $v, $val ), 'type' => 'select', 'initial_options' => $iopts, 'default' => 'no' );
					if ( ( $opt == 'archive' ) || ( $opt == 'author' ) ) $arr[ $k . '_' . $opt ][ 'condshow' ] = Array( $this->prefix . $opt => 'on' );
					$$s = $arr;
				}
			}
			
			$addl_options = Array(
							'addl_instructions' => Array( 'default' => '<div>' . __( 'Enter information below for any additional links for your sitemap not already managed through WordPress.', 'all-in-one-seo-pack' ) . '</div><br />', 'type' => 'html', 'label' => 'none', 'save' => false ),
							'addl_url'  => Array( 'name' => __( 'Page URL', 'all-in-one-seo-pack' ), 'type' => 'text', 'label' => 'top', 'save' => false ),
							'addl_prio' => Array( 'name' => __( 'Page Priority', 'all-in-one-seo-pack' ), 'type' => 'select', 'initial_options' => $prio, 'label' => 'top', 'save' => false ),
							'addl_freq' => Array( 'name' => __( 'Page Frequency', 'all-in-one-seo-pack' ), 'type' => 'select', 'initial_options' => $freq, 'label' => 'top', 'save' => false ),
							'addl_mod'  => Array( 'name' => __( 'Last Modified', 'all-in-one-seo-pack' ), 'type' => 'text', 'label' => 'top', 'save' => false ),
							'addl_pages'=> Array( 'name' => __( 'Additional Pages', 'all-in-one-seo-pack' ), 'type' => 'custom', 'save' => true ),
							'Submit'    => Array( 'type' => 'submit', 'class' => 'button-primary', 'name'  => __( 'Add URL', 'all-in-one-seo-pack' ) . ' &raquo;', 'style' => 'margin-left: 20px;', 'label' => 'none', 'save' => false, 'value' => 1 )
							);
							
			$excl_options = Array(
							'excl_categories' => Array( 'name' => __( 'Excluded Categories', 'all-in-one-seo-pack' ), 'type' => 'multicheckbox', 'initial_options' => '' ),
							'excl_pages' => Array( 'name' => __( 'Excluded Pages', 'all-in-one-seo-pack' ), 'type' => 'text' )
							);
			
			$this->layout['addl_pages'] = Array(
					'name' => __( 'Additional Pages', 'all-in-one-seo-pack' ),
					'help_link' => 'http://semperplugins.com/documentation/xml-sitemaps-module/#additional-pages',
					'options' => array_keys( $addl_options )
				);
				
			$this->layout['excl_pages'] = Array(
					'name' => __( 'Excluded Items', 'all-in-one-seo-pack' ),
					'help_link' => 'http://semperplugins.com/documentation/xml-sitemaps-module/#excluded-items',
					'options' => array_keys( $excl_options )
				);
			
			$this->layout['priorities']  = Array(
						'name' => __( 'Priorities', 'all-in-one-seo-pack' ),
						'help_link' => 'http://semperplugins.com/documentation/xml-sitemaps-module/#priorities-and-frequencies',
						'options' => array_keys( $prio_options )
					);
			
			$this->layout['frequencies']  = Array(
						'name' => __( 'Frequencies', 'all-in-one-seo-pack' ),
						'help_link' => 'http://semperplugins.com/documentation/xml-sitemaps-module/#priorities-and-frequencies',
						'options' => array_keys( $freq_options )
					);
			
			$this->default_options = array_merge( $status_options, $this->default_options, $addl_options, $excl_options, $prio_options, $freq_options );

			$this->add_help_text_links();
			
			add_action( 'init', Array( $this, 'load_sitemap_options' ) );
			add_action( $this->prefix . 'settings_update',  Array( $this, 'do_sitemaps' ) );
			add_filter( $this->prefix . 'display_settings', Array( $this, 'update_post_data' ) );
			add_filter( $this->prefix . 'display_options',  Array( $this, 'filter_display_options' ) );
			add_filter( $this->prefix . 'update_options',   Array( $this, 'filter_options' ) );
			add_filter( $this->prefix . 'output_option', Array( $this, 'display_custom_options' ), 10, 2 );
			add_action( $this->prefix . 'daily_update_cron', Array( $this, 'daily_update' ) );
		}
		
		// Add new intervals of a week and a month
		// See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
		function add_cron_schedules( $schedules ) {
		    $schedules['weekly'] = array(
		        'interval' => 604800, // 1 week in seconds
		        'display'  => __( 'Once Weekly', 'all-in-one-seo-pack' )
		    );
		    $schedules['monthly'] = array(
		        'interval' => 2629740, // 1 month in seconds
		        'display'  => __( 'Once Monthly', 'all-in-one-seo-pack' )
		    );
		    return $schedules;
		}
		
		function cron_update() {
			add_filter( 'cron_schedules', Array( $this, 'add_cron_schedules' ) );
			if ( !wp_next_scheduled( $this->prefix . 'daily_update_cron' ) )
		        wp_schedule_event( time(), $this->options[$this->prefix . 'daily_cron'], $this->prefix . 'daily_update_cron' );
		}
		
		function daily_update() {
			$last_run = get_option( $this->prefix . 'cron_last_run' );
			if ( empty( $last_run ) || ( time() - $last_run > 23.5 * 60 * 60 ) ) // sanity check
				$this->do_sitemaps( __( "Daily scheduled sitemap check has finished.", 'all-in-one-seo-pack' ) );
			$last_run = time();
			update_option( $this->prefix . 'cron_last_run', $last_run );
		}
		
		/** Initialize options, after constructor **/
		function load_sitemap_options() {
			// load initial options / set defaults
			$this->update_options( );
			if ( !empty( $this->options["{$this->prefix}indexes"] ) && !empty( $this->options["{$this->prefix}paginate"] ) ) {
				$this->paginate = true;
				if ( ( $this->options["{$this->prefix}max_posts"] ) && ( $this->options["{$this->prefix}max_posts"] > 0 ) && ( $this->options["{$this->prefix}max_posts"] < 50000 ) )
					$this->max_posts = $this->options["{$this->prefix}max_posts"];
			}

			if ( is_multisite() ) $this->options["{$this->prefix}rewrite"] = 'On';

			if ( $this->options["{$this->prefix}rewrite"] ) $this->setup_rewrites();
			
			if ( $this->option_isset( 'robots' ) )
				add_action( 'do_robots', Array( $this, 'do_robots' ), 100 );
			
			if ( isset( $this->options[$this->prefix . 'daily_cron'] ) && $this->options[$this->prefix . 'daily_cron'] ) {
				add_action( 'wp', Array( $this, 'cron_update' ) );				
			} else {
				if ( $time = wp_next_scheduled( $this->prefix . 'daily_update_cron' ) )
			        wp_unschedule_event( $time, $this->prefix . 'daily_update_cron' );
			}
		}
		
		/** Custom settings - displays boxes for add pages to sitemap option. **/
		function display_custom_options( $buf, $args ) {
			if ( $args['name'] == "{$this->prefix}addl_pages" ) {
				$buf .= "<div id='{$this->prefix}addl_pages'>";
				if ( !empty( $args['value'] ) ) {
					$buf .= "<table class='aioseop_table' cellpadding=0 cellspacing=0>\n";
					foreach ( $args['value'] as $k => $v ) {
						if ( is_object( $v ) ) $v = (Array)$v;
						$buf .= "\t<tr><td><a href='#' title='$k' class='aiosp_delete_url'></a> {$k}</td><td>{$v['prio']}</td><td>{$v['freq']}</td><td>{$v['mod']}</td></tr>\n";
					}
					$buf .= "</table>\n";
				}
			}
			$args['options']['type'] = 'hidden';
			if ( !empty( $args['value'] ) )
				$args['value'] = json_encode( $args['value'] );
			else
				$args['options']['type'] = 'html';
			if ( empty( $args['value'] ) ) $args['value'] = '';
			$buf .= $this->get_option_html( $args );
			$buf .= '</div>';
			return $buf;
		}
		
		/** Add post type details for settings once post types have been registered. **/
		function add_post_types() {
			$post_type_titles = $this->get_post_type_titles( Array( 'public' => true ) );
			$taxonomy_titles = $this->get_taxonomy_titles(  Array( 'public' => true ) );
			if ( isset( $post_type_titles['attachment'] ) ) $post_type_titles['attachment'] = __( "Media / Attachments", 'all-in-one-seo-pack' );
			$this->default_options['posttypes' ]['initial_options'] = array_merge( Array( 'all' => __( 'All Post Types', 'all-in-one-seo-pack' ) ), $post_type_titles );
			$this->default_options['taxonomies']['initial_options'] = array_merge( Array( 'all' => __( 'All Taxonomies', 'all-in-one-seo-pack' ) ), $taxonomy_titles );
			$this->default_options['posttypes' ]['default'] = array_keys( $this->default_options['posttypes' ]['initial_options'] );
			$this->default_options['taxonomies']['default'] = array_keys( $this->default_options['taxonomies']['initial_options'] ); 
			$this->default_options['excl_categories']['initial_options'] = $this->get_category_titles();
			$prio_help = __( "Manually set the priority for the ", 'all-in-one-seo-pack' );
			$freq_help = __( "Manually set the frequency for the ", 'all-in-one-seo-pack' );
			$post_name = __( " Post Type", 'all-in-one-seo-pack' );
			$tax_name = __( " Taxonomy", 'all-in-one-seo-pack' );
			foreach( $post_type_titles as $k => $v ) {
				$key = 'prio_post_' . $k;
				$this->default_options = aioseop_array_insert_after( $this->default_options, 'prio_post', Array( $key => Array( 'name' => $v . $post_name, 'help_text' => $prio_help . $v . $post_name, 'type' => 'select', 'initial_options' => $this->prio, 'default' => 'no', 'condshow' => Array( "{$this->prefix}prio_post" => 'sel' ) ) ) );				
				$this->layout['priorities']['options'][] = $key;
				$key = 'freq_post_' . $k;
				$this->default_options = aioseop_array_insert_after( $this->default_options, 'freq_post', Array( $key => Array( 'name' => $v . $post_name, 'help_text' => $freq_help . $v . $post_name, 'type' => 'select', 'initial_options' => $this->freq, 'default' => 'no', 'condshow' => Array( "{$this->prefix}freq_post" => 'sel' ) ) ) );
				$this->layout['frequencies']['options'][] = $key;
			}
			foreach( $taxonomy_titles as $k => $v ) {
				$key = 'prio_taxonomies_' . $k;
				$this->default_options = aioseop_array_insert_after( $this->default_options, 'prio_taxonomies', Array( $key => Array( 'name' => $v . $tax_name, 'help_text' => $prio_help . $v . $tax_name, 'type' => 'select', 'initial_options' => $this->prio, 'default' => 'no', 'condshow' => Array( "{$this->prefix}prio_taxonomies" => 'sel' ) ) ) );				
				$this->layout['priorities']['options'][] = $key;
				$key = 'freq_taxonomies_' . $k;
				$this->default_options = aioseop_array_insert_after( $this->default_options, 'freq_taxonomies', Array( $key => Array( 'name' => $v . $tax_name, 'help_text' => $freq_help . $v . $tax_name, 'type' => 'select', 'initial_options' => $this->freq, 'default' => 'no', 'condshow' => Array( "{$this->prefix}freq_taxonomies" => 'sel' ) ) ) );
				$this->layout['frequencies']['options'][] = $key;
			}
			$this->update_options();
		}

		/** Set up settings, checking for sitemap conflicts, on settings page. **/
		function add_page_hooks() {
			$this->flush_rules_hook();
			$this->add_post_types();
			parent::add_page_hooks();
			add_action( $this->prefix . 'settings_header', Array( $this, 'do_sitemap_scan' ), 5 );
			add_filter( "{$this->prefix}submit_options",	Array( $this, 'filter_submit'   ) );
		}

		/** Change submit button to read "Update Sitemap". **/
		function filter_submit( $submit ) {
			$submit['Submit']['value'] = __( 'Update Sitemap', 'all-in-one-seo-pack' ) . ' &raquo;';
			return $submit;
		}
		
		/** Disable writing sitemaps to the filesystem for multisite. **/
		function update_post_data( $options ) {
			if ( is_multisite() ) $options[ $this->prefix . 'rewrite' ]['disabled'] = 'disabled';
			return $options;
		}
		
		function get_rewrite_url( $url ) {
			global $wp_rewrite;
			$url = parse_url( esc_url( $url ), PHP_URL_PATH );
			$url = ltrim( $url, '/' );
			if ( !empty( $wp_rewrite ) ) {
				$rewrite_rules = $wp_rewrite->rewrite_rules();
				foreach( $rewrite_rules as $k => $v ) {
					if ( preg_match( "@^$k@", $url ) )
						return $v;
				}
			}
			return false;
		}
		
		/** Add in options for status display on settings page, sitemap rewriting on multisite. **/
		function filter_display_options( $options ) {
			if ( is_multisite() ) $options[ $this->prefix . 'rewrite'] = 'On';
			if ( isset( $options[ $this->prefix . 'max_posts'] ) && ( ( $options[ $this->prefix . 'max_posts'] <= 0 ) || ( $options[ $this->prefix . 'max_posts'] >= 50000 ) ) )
				$options[ $this->prefix . 'max_posts'] = 50000;
			$url = trailingslashit( get_home_url() ) . $options[ $this->prefix . 'filename' ] . '.xml';
			$options[ $this->prefix . 'link' ] = sprintf( __( "Please review your settings below and click %s to build your sitemap; then, %s.",
														'all-in-one-seo-pack' ), sprintf( '<a href="#" onclick="document.dofollow.elements[\'Submit\'][0].click();">%s</a>',
													__( 'Update Sitemap', 'all-in-one-seo-pack' ) ), '<a href="' . esc_url( $url ) . '" target="_blank">' . 
													__( "view your sitemap", 'all-in-one-seo-pack' ) . "</a>" );
			if ( $this->option_isset( 'rewrite' ) ) {
				
				$options[ $this->prefix . 'link' ] .= '<p>' . __( "Note: you are using dynamic sitemap generation to keep your sitemap current; this will not generate a static sitemap file.", 'all-in-one-seo-pack' ) . '</p>';
				$rule = $this->get_rewrite_url( $url );
				$rules = $this->get_rewrite_rules();
				if ( in_array( $rule, $rules ) )
					$options[ $this->prefix . 'link' ] .= '<p>' . __( "Dynamic sitemap generation appears to be using the correct rewrite rules.", 'all-in-one-seo-pack' ) . '</p>';
				else
					$options[ $this->prefix . 'link' ] .= '<p>' . __( "Dynamic sitemap generation does not appear to be using the correct rewrite rules; please disable any other sitemap plugins or functionality on your site and reset your permalinks.", 'all-in-one-seo-pack' ) . '</p>';
			}
			if ( !get_option( 'blog_public' ) ) {
				global $wp_version;
				if ( ( version_compare( $wp_version, '3.5.0', '>=' ) ) || ( function_exists( 'set_url_scheme' ) ) ) {
					$privacy_link = '<a href="options-reading.php">' . __( 'Reading Settings', 'all-in-one-seo-pack' ) . '</a>';
				} else {
					$privacy_link = '<a href="options-privacy.php">' . __( 'Privacy Settings', 'all-in-one-seo-pack' ) . '</a>';
				}
				$options[ $this->prefix . 'link' ] .= '<p class="aioseop_error_notice">' . sprintf( __( "Warning: your privacy settings are configured to ask search engines to not index your site; you can change this under %s for your blog.",
				 												'all-in-one-seo-pack' ), $privacy_link );
			}
			if ( $this->option_isset( 'debug' ) ) $options["{$this->prefix}debug"] = '<pre>' . $options["{$this->prefix}debug"] . '</pre>';
			return $options;
		}

		/** Handle 'all' option for post types / taxonomies, further sanitization of filename, rewrites on for multisite, setting up addl pages option. **/
		function filter_options( $options ) {
			if ( !isset( $this->default_options['posttypes' ]['initial_options'] ) ) $this->add_post_types();
			if ( is_array( $options["{$this->prefix}posttypes"] ) && in_array( 'all', $options["{$this->prefix}posttypes"] ) && is_array( $this->default_options['posttypes' ]['initial_options'] ) )
				$options["{$this->prefix}posttypes"] = array_keys( $this->default_options['posttypes' ]['initial_options'] );
			if ( is_array( $options["{$this->prefix}taxonomies"] ) && in_array( 'all', $options["{$this->prefix}taxonomies"] ) && is_array( $this->default_options['taxonomies' ]['initial_options'] ) )
				$options["{$this->prefix}taxonomies"] = array_keys( $this->default_options['taxonomies' ]['initial_options'] );
			$opt = $this->prefix . 'filename';
			if ( isset( $options[$opt] ) && !empty( $options[$opt] ) )
				$options[$opt] = str_replace( '/', '', $options[$opt] );
			else
				$options[$opt] = 'sitemap';
			if ( is_multisite() ) $options[ $this->prefix . 'rewrite'] = 'On';
			if ( !is_array( $options[ $this->prefix . 'addl_pages' ] ) ) {
				$options[ $this->prefix . 'addl_pages' ] = wp_specialchars_decode( stripslashes_deep( $options[ $this->prefix . 'addl_pages' ] ), ENT_QUOTES );
				$decoded = json_decode( $options[ $this->prefix . 'addl_pages' ] );
				if ( $decoded === NULL )
					$decoded = maybe_unserialize( $options[ $this->prefix . 'addl_pages' ] );
				if ( !is_array( $decoded ) ) $decoded = (Array)$decoded;
				if ( $decoded === NULL )
					$decoded = $options[ $this->prefix . 'addl_pages' ];
				$options[ $this->prefix . 'addl_pages' ] = $decoded;	
			}
			if ( is_array( $options[ $this->prefix . 'addl_pages' ] ) ) {
				foreach( $options[ $this->prefix . 'addl_pages' ] as $k => $v ) {
					if ( is_object( $v ) )
						$options[ $this->prefix . 'addl_pages' ][$k] = (Array)$v;
				}
			}
			if ( isset( $options[ $this->prefix . 'addl_pages' ][0] ) ) unset( $options[ $this->prefix . 'addl_pages' ][0] );
			if ( !empty( $_POST[ $this->prefix . 'addl_url' ] ) ) {
				foreach( Array( 'addl_url', 'addl_prio', 'addl_freq', 'addl_mod' ) as $field ) {
					if ( !empty( $_POST[ $this->prefix . $field ] ) ) {
						$_POST[ $this->prefix . $field ] = esc_attr( wp_kses_post( $_POST[ $this->prefix . $field ] ) );
					} else {
						$_POST[ $this->prefix . $field ] = '';
					}
				}
				if ( !is_array( $options[ $this->prefix . 'addl_pages' ] ) ) $options[ $this->prefix . 'addl_pages' ] = Array();
				$options[ $this->prefix . 'addl_pages' ][ $_POST[ $this->prefix . 'addl_url' ] ] = Array(
																										'prio' => $_POST[ $this->prefix . 'addl_prio' ],
																										'freq' => $_POST[ $this->prefix . 'addl_freq' ],
																										'mod'  => $_POST[ $this->prefix . 'addl_mod' ],
																									);
			}
			return $options;
		}
		
		/** Get sitemap urls of child blogs, if any. **/
		function get_child_sitemap_urls() {
			$siteurls = Array();
			$blogs = $this->get_child_blogs();
			if ( !empty( $blogs ) ) {
				$option_name = $this->get_option_name();
				foreach ( $blogs as $blog_id )
					if ( $this->is_aioseop_active_on_blog( $blog_id ) ) {
						$options = get_blog_option( $blog_id, $this->parent_option );
						if ( !empty( $options ) && !empty($options['modules']) && !empty($options['modules']['aiosp_feature_manager_options']) 
						  && !empty($options['modules']['aiosp_feature_manager_options']['aiosp_feature_manager_enable_sitemap']) 
						  && !empty($options['modules'][$option_name]) ) {
							global $wpdb;
							$sitemap_options = $options['modules'][$option_name];
							$siteurl = '';
							if ( defined( 'SUNRISE' ) && SUNRISE && is_object( $wpdb ) && isset( $wpdb->dmtable ) && !empty( $wpdb->dmtable ) ) {
								$domain = $wpdb->get_var( "SELECT domain FROM {$wpdb->dmtable} WHERE blog_id = '$blog_id' AND active = 1 LIMIT 1" );
								if ( $domain ) {
									if ( false == isset( $_SERVER[ 'HTTPS' ] ) )
										$_SERVER[ 'HTTPS' ] = 'Off';
									$protocol = ( 'on' == strtolower( $_SERVER[ 'HTTPS' ] ) ) ? 'https://' : 'http://';
									$siteurl = untrailingslashit( $protocol . $domain  );	
								}
							}
							if ( !$siteurl ) $siteurl = get_home_url( $blog_id );
							$url = $siteurl . '/' . $sitemap_options["{$this->prefix}filename"] . '.xml';
							if ( $sitemap_options["{$this->prefix}gzipped"] ) $url .= '.gz';
							$siteurls[] = $url;
						}
					}
			}
			$siteurls = apply_filters( $this->prefix . 'sitemap_urls', $siteurls ); // legacy
			return apply_filters( $this->prefix . 'child_urls', $siteurls );
		}

		/** Scan for sitemaps on filesystem. **/
		function scan_match_files() {
			$scan1 = $scan2 = '';
			$files = Array();
			
			if ( !empty( $this->options["{$this->prefix}filename"] ) ) {
				$scan1 = get_home_path() . $this->options["{$this->prefix}filename"] . '*.xml';
				if ( !empty( $this->options["{$this->prefix}gzipped"] ) )
					$scan2 .= get_home_path() . $this->options["{$this->prefix}filename"] . '*.xml.gz';
				
				if ( empty( $scan1 ) && empty( $scan2 ) ) return $files;
				$home_path = get_home_path();
				$filescan = $this->scandir( $home_path );
				if ( !empty( $filescan ) )
				foreach( $filescan as $f ) {
					if ( !empty($scan1) && fnmatch($scan1, $home_path . $f ) ) {
						$files[] = $home_path . $f;
						continue;
					}
					if ( !empty($scan2) && fnmatch($scan2, $home_path . $f ) )
							$files[] = $home_path . $f;
				}
	
				return $files;
			}
		}
		
		/** Handle deleting / renaming of conflicting sitemap files. **/
		function do_sitemap_scan() {
			$msg = '';
			if ( !empty(  $this->options["{$this->prefix}rewrite"] ) && ( get_option('permalink_structure') == '' ) ) { 
				$msg = '<p>' . __( 'Warning: dynamic sitemap generation must have permalinks enabled.', 'all-in-one-seo-pack' ) . '</p>';
			}
			if ( !empty( $_POST['aioseop_sitemap_rename_files'] ) || !empty( $_POST['aioseop_sitemap_delete_files'] ) ) {
				$nonce = $_POST['nonce-aioseop'];
				if (!wp_verify_nonce($nonce, 'aioseop-nonce')) die ( __( 'Security Check - If you receive this in error, log out and back in to WordPress', 'all-in-one-seo-pack' ) );
				if ( !empty( $_POST['aioseop_sitemap_conflict'] ) ) {
					$files = $this->scan_match_files();
					foreach ( $files as $f => $file ) $files[$f] = realpath( $file );
					foreach( $_POST['aioseop_sitemap_conflict'] as $ren_file ) {
						$ren_file = realpath( get_home_path() . $ren_file );
						if ( in_array( $ren_file, $files ) ) {
							if ( !empty( $_POST['aioseop_sitemap_delete_files'] ) ) {
								if ( $this->delete_file( $ren_file ) )
									$msg .= "<p>" . sprintf( __( "Deleted %s.", 'all-in-one-seo-pack' ), $ren_file ) . "</p>";
								continue;
							}
							$count = 0;
							do {
								$ren_to = $ren_file . '._' . sprintf( "%03d", $count ) . ".old";
								$count++;
							} while ( $this->file_exists( $ren_to ) && ( $count < 1000 ) );
							if ( $count >= 1000 )
								$msg .= "<p>" . sprintf( __( "Couldn't rename file %s!", 'all-in-one-seo-pack' ), $ren_file) . "</p>";
							else {
								$ren = $this->rename_file( $ren_file, $ren_to );
								if ( $ren )
									$msg .= "<p>" . sprintf( __( "Renamed %s to %s.", 'all-in-one-seo-pack' ), $ren_file, $ren_to) . "</p>";
							}
						} else $msg .= "<p>" . sprintf( __( "Couldn't find file %s!", 'all-in-one-seo-pack' ), $ren_file) . "</p>";
					}
				}
			} else {
				$msg .= $this->scan_sitemaps();
			}
			
			if ( !empty( $msg ) )
				$this->output_error( $msg );
		}

		/** Do the scan, return the results. **/
		function scan_sitemaps() {
			$msg = '';
			$files = $this->scan_match_files();
			if ( !empty( $files ) ) $msg = $this->sitemap_warning( $files );
			return $msg;
		}
		
		/** Get the list of potentially conflicting sitemap files. **/
		function get_problem_files( $files, &$msg ) {
			$problem_files = Array();
			$use_wpfs = true;
			$wpfs = $this->get_filesystem_object();
			if ( !is_object( $wpfs ) ) {
				$use_wpfs = false;
			} else {
				if ( $wpfs->method == 'direct' ) $use_wpfs = false;
			}
			
			foreach ( $files as $f ) {
				if ( $this->is_file( $f ) ) {
					$fn = $f;
					$compressed = false;
					if ( $this->substr( $f, -3 ) == '.gz' ) $compressed = true;
					if ( $use_wpfs ) {
						if ( $compressed ) {  // inefficient but necessary
							$file = $this->load_file( $fn );
							if ( !empty( $file ) ) $file = gzuncompress( $file, 4096 );
						} else {
							$file = $this->load_file( $fn, false, null, -1, 4096 );
						}
					}
					else {
						if ( $compressed ) $fn = 'compress.zlib://' . $fn;
						$file = file_get_contents( $fn, false, null, -1, 4096 );
					}
					if ( !empty( $file ) ) {
						$matches = Array();
						if ( preg_match( "/<!-- " . sprintf( $this->comment_string, '(.*)', '(.*)', '(.*)' ) .  " -->/",
							 				$file, $matches ) ) {
								if ( !empty(  $this->options["{$this->prefix}rewrite"] ) ) {
									$msg .= '<p>' . sprintf( __( "Warning: a static sitemap '%s' generated by All in One SEO Pack %s on %s already exists that may conflict with dynamic sitemap generation.", 'all-in-one-seo-pack' ),
									 $f, $matches[2], $matches[3] ) . "</p>\n";
									$problem_files[] = $f;
								}
						} else {
							$msg .= '<p>' . sprintf( __( "Potential conflict with unknown file %s.", 'all-in-one-seo-pack' ), $f ) . "</p>\n";
							$problem_files[] = $f;
						}
					}
				}
			}
			return $problem_files;
		}
		
		/** Display the warning and the form for conflicting sitemap files. **/
		function sitemap_warning( $files ) {
			$msg = '';
			$conflict = false;
			$problem_files = $this->get_problem_files( $files, $msg );
			if ( !empty( $problem_files ) ) $conflict = true;
			if ( $conflict ) {
				foreach ( $problem_files as $p )
					$msg .= "<input type='hidden' name='aioseop_sitemap_conflict[]' value='" . esc_attr( basename ( realpath( $p ) ) ) . "'>\n";
				$msg .= "<input type='hidden' name='nonce-aioseop' value='" . wp_create_nonce('aioseop-nonce') . "'>\n";
				$msg .= "<input type='submit' name='aioseop_sitemap_rename_files' value='" . __( "Rename Conflicting Files", 'all-in-one-seo-pack' ) . "'> ";
				$msg .= "<input type='submit' name='aioseop_sitemap_delete_files' value='" . __( "Delete Conflicting Files", 'all-in-one-seo-pack' ) . "'>";
				$msg = '<form action="" method="post">' . $msg . '</form>';
			}
			return $msg;
		}
		
		/** Updates debug log messages. **/
		function debug_message( $msg ) {
			if ( empty( $this->options["{$this->prefix}debug"] ) ) $this->options["{$this->prefix}debug"] = '';
			$this->options["{$this->prefix}debug"] = date( 'Y-m-d H:i:s' ) . " {$msg}\n" . $this->options["{$this->prefix}debug"];
			if ( $this->strlen( $this->options["{$this->prefix}debug"] ) > 2048 ) {
				$end = $this->strrpos( $this->options["{$this->prefix}debug"], "\n" );
				if ( $end === false ) $end = 2048;
				$this->options["{$this->prefix}debug"] = $this->substr( $this->options["{$this->prefix}debug"], 0, $end );
			}
			$this->update_class_option( $this->options );
		}
		
		/** Set up hooks for rewrite rules for dynamic sitemap generation. **/
		function setup_rewrites() {
			add_action( 'rewrite_rules_array', Array( $this, 'rewrite_hook' ) );
			add_filter( 'query_vars', Array( $this, 'query_var_hook' ) );
			add_action( 'parse_query', Array( $this, 'sitemap_output_hook') );
			if ( !get_transient( "{$this->prefix}rules_flushed" ) )
				add_action( 'wp_loaded', Array($this, 'flush_rules_hook' ) );
		}

		/** Build and return our rewrite rules. **/
		function get_rewrite_rules() {
			$sitemap_rules_normal = $sitemap_rules_gzipped = Array();
			$sitemap_rules_normal = array(
				$this->options["{$this->prefix}filename"] . '.xml'			=> "index.php?{$this->prefix}path=root",
				$this->options["{$this->prefix}filename"] . '_(.+)_(\d+).xml'=> 'index.php?' . $this->prefix . 'path=$matches[1]&' . $this->prefix . 'page=$matches[2]',
				$this->options["{$this->prefix}filename"] . '_(.+).xml'		=> 'index.php?' . $this->prefix . 'path=$matches[1]'
			);
			if ( $this->options["{$this->prefix}gzipped"] ) {
				$sitemap_rules_gzipped = array(
			        $this->options["{$this->prefix}filename"] . '.xml.gz'		=> "index.php?{$this->prefix}gzipped=1&{$this->prefix}path=root.gz",
			        $this->options["{$this->prefix}filename"] . '_(.+)_(\d+).xml.gz'	=> 'index.php?' . $this->prefix . 'path=$matches[1].gz&' . $this->prefix . 'page=$matches[2]',
			        $this->options["{$this->prefix}filename"] . '_(.+).xml.gz'	=> 'index.php?' . $this->prefix . 'path=$matches[1].gz'
			    );
			}
			$sitemap_rules = $sitemap_rules_gzipped + $sitemap_rules_normal;
			return $sitemap_rules;
		}

		/** Add in our rewrite rules. **/
		function rewrite_hook( $rules ) {
			$sitemap_rules = $this->get_rewrite_rules();
			if ( !empty( $sitemap_rules ) ) 
				$rules = $sitemap_rules + $rules;
			return $rules;
		}
		
		/** Flush rewrite rules when necessary. **/
		function flush_rules_hook() {
			global $wp_rewrite;
			$sitemap_rules = $this->get_rewrite_rules( $wp_rewrite );
			if ( !empty( $sitemap_rules ) ) {
				$rules = get_option( 'rewrite_rules' );
				$rule = key( $sitemap_rules );
				if ( !isset( $rules[ $rule ] ) || ( $rules[ $rule ] != $sitemap_rules[ $rule ] ) ) {
				   	$wp_rewrite->flush_rules();
					set_transient( "{$this->prefix}rules_flushed", true, 43200 );
				}
			}
		}

		/** Add our query variable for sitemap generation. **/
		function query_var_hook($vars) {
			$vars[] = "{$this->prefix}path";
			if ( $this->paginate )
				$vars[] = "{$this->prefix}page";
			return $vars;
		}

		/** Start timing and get initial memory usage for debug info. **/
		function log_start() {
			$this->start_memory_usage = memory_get_peak_usage();
			timer_start();
		}

		/** Stop timing and log memory usage for debug info. **/
		function log_stats( $sitemap_type = 'root', $compressed = false, $dynamic = true ) {
			$time = timer_stop();
			$end_memory_usage = memory_get_peak_usage();
			$sitemap_memory_usage = $end_memory_usage - $this->start_memory_usage;
			$end_memory_usage = $end_memory_usage / 1024.0 / 1024.0;
			$sitemap_memory_usage = $sitemap_memory_usage / 1024.0 / 1024.0;
			if ( $compressed ) $sitemap_type = __( 'compressed', 'all-in-one-seo-pack' ) . " $sitemap_type";
			if ( $dynamic )
				$sitemap_type = __( 'dynamic', 'all-in-one-seo-pack ') . " $sitemap_type";
			else
				$sitemap_type = __( 'static', 'all-in-one-seo-pack ') . " $sitemap_type";
			$this->debug_message( sprintf( " %01.2f MB memory used generating the %s sitemap in %01.3f seconds, %01.2f MB total memory used.", $sitemap_memory_usage, $sitemap_type, $time, $end_memory_usage ) );
		}

		/** Handle outputting of dynamic sitemaps, logging. **/
		function sitemap_output_hook($query) {
			$page = 0;
			if ( ( $this->options["{$this->prefix}rewrite"] ) )
				if( !empty( $query->query_vars["{$this->prefix}path"] ) ) {
					if( !empty( $query->query_vars["{$this->prefix}page"] ) )
						$page = $query->query_vars["{$this->prefix}page"] - 1;
					$this->start_memory_usage = memory_get_peak_usage();
					$sitemap_type = $query->query_vars["{$this->prefix}path"];
					$gzipped = false;
					if ( $this->substr( $sitemap_type, -3 ) === '.gz' ) {
						$gzipped = true;
						$sitemap_type = $this->substr( $sitemap_type, 0, -3 );
					}
					$blog_charset = get_option( 'blog_charset' );
					if ( $this->options["{$this->prefix}gzipped"] && $gzipped ) {
						header( "Content-Type: application/x-gzip; charset=$blog_charset", true);
					} else {
						$gzipped = false;
						header( "Content-Type: text/xml; charset=$blog_charset", true );
					}
					if ( $this->options["{$this->prefix}noindex"] ) {
						header( "X-Robots-Tag: noindex", true );
					}
					if ( $gzipped ) ob_start();
					$this->do_rewrite_sitemap( $sitemap_type, $page );
					if ( $gzipped ) echo gzencode( ob_get_clean() );
					$this->log_stats( $sitemap_type, $gzipped );
					exit();
				}
		}
		
		function get_sitemap_data( $sitemap_type, $page = 0 ) {
			$sitemap_data = Array();
			if ( $this->options["{$this->prefix}indexes"] ) {
				$posttypes = $this->options["{$this->prefix}posttypes"];
				if ( empty( $posttypes ) ) $posttypes = Array();
				$taxonomies = $this->options["{$this->prefix}taxonomies"];
				if ( empty( $taxonomies ) ) $taxonomies = Array();
				if ( $sitemap_type === 'root' ) {
					$sitemap_data = array_merge( $this->get_sitemap_index_filenames() );
				} elseif ( $sitemap_type === 'addl' ) {
					$sitemap_data = $this->get_addl_pages();	
				} elseif ( $sitemap_type === 'archive' && $this->option_isset( 'archive' ) ) {
					$sitemap_data = $this->get_archive_prio_data();					
				} elseif ( $sitemap_type === 'author' && $this->option_isset( 'author' ) ) {
					$sitemap_data = $this->get_author_prio_data();					
				} elseif ( in_array( $sitemap_type, $posttypes ) ) {
					$sitemap_data = $this->get_all_post_priority_data( $sitemap_type, 'publish', $page );
				} elseif ( in_array( $sitemap_type, $taxonomies ) ) {
					$sitemap_data = $this->get_term_priority_data( get_terms( $sitemap_type, $this->get_tax_args( $page ) ) );
				} else {
					if ( is_array( $this->extra_sitemaps ) && in_array( $sitemap_type, $this->extra_sitemaps ) )
						$sitemap_data = apply_filters( $this->prefix . 'custom_' . $sitemap_type, $sitemap_data, $page, $this_options );
				}
			} elseif ( $sitemap_type === 'root' ) $sitemap_data = $this->get_simple_sitemap();
			return apply_filters( $this->prefix . 'data', $sitemap_data, $sitemap_type, $page, $this->options );
		}

		/** Output sitemaps dynamically based on rewrite rules. **/
		function do_rewrite_sitemap( $sitemap_type, $page = 0 ) {
			$this->add_post_types();
			$comment = __( "dynamically", 'all-in-one-seo-pack' );			
			echo $this->do_build_sitemap( $sitemap_type, $page, '', $comment );
		}

		/** Build a url to the sitemap. **/
		function get_sitemap_url() {
			$url = get_home_url() . '/' . $this->options["{$this->prefix}filename"] . '.xml';
			if ( $this->options["{$this->prefix}gzipped"] ) $url .= '.gz';
			return $url;
		}

		/** Notify search engines, do logging. **/
		function do_notify() {
			$notify_url = Array(	'google' => 'http://www.google.com/webmasters/sitemaps/ping?sitemap=', 
									'bing' => 'http://www.bing.com/webmaster/ping.aspx?siteMap='
						);

			$url = $this->get_sitemap_url();
			if ( !empty( $url ) )
				foreach ( $notify_url as $k => $v )
					if ( isset( $this->options[$this->prefix . $k] ) && $this->options[$this->prefix . $k] ) {
						$response = wp_remote_get( $notify_url[$k] . urlencode( $url ) );
						if ( is_array( $response ) && !empty( $response['response'] ) && !empty( $response['response']['code'] ) ) {
							if ( $response['response']['code'] == 200 ) {
								$this->debug_message( sprintf( __( 'Successfully notified %s about changes to your sitemap at %s.', 'all-in-one-seo-pack' ), $k, $url ) );
							} else {
								$this->debug_message( sprintf( __( 'Failed to notify %s about changes to your sitemap at %s, error code %s.', 'all-in-one-seo-pack' ), $k, $url, $response['response']['code'] ) );
							}
						} else {
							$this->debug_message( sprintf( __( 'Failed to notify %s about changes to your sitemap at %s, unable to access via wp_remote_get().', 'all-in-one-seo-pack' ), $k, $url ) );							
						}
					} else {
						$this->debug_message( sprintf( __( 'Did not notify %s about changes to your sitemap.', 'all-in-one-seo-pack' ), $k, $url ) );
					}
		}
		
		/** Add Sitemap parameter to virtual robots.txt file. **/
		function do_robots() {
			$url = $this->get_sitemap_url();
			echo "\nSitemap: $url\n";
		}

		/** Build static sitemaps on submit if rewrite rules are not in use, do logging. **/
		function do_sitemaps( $message = '' ) {
			if ( !empty( $this->options["{$this->prefix}indexes"] ) && !empty( $this->options["{$this->prefix}paginate"] ) ) {
				$this->paginate = true;
				if ( ( $this->options["{$this->prefix}max_posts"] ) && ( $this->options["{$this->prefix}max_posts"] > 0 ) && ( $this->options["{$this->prefix}max_posts"] < 50000 ) )
					$this->max_posts = $this->options["{$this->prefix}max_posts"];
				else
					$this->max_posts = 50000;				
			} else {
				$this->paginate = false;
				$this->max_posts = 50000;
			}
			if ( !$this->options["{$this->prefix}rewrite"] ) {
				if ( $this->options["{$this->prefix}indexes"] ) {
					$this->do_indexed_sitemaps();
				} else {
					$this->log_start();
					$comment = sprintf( __( "file '%s' statically", 'all-in-one-seo-pack' ), $this->options["{$this->prefix}filename"] );
					$sitemap = $this->do_simple_sitemap( $comment );
					$this->write_sitemaps( $this->options["{$this->prefix}filename"], $sitemap );
					$this->log_stats( 'root', $this->options["{$this->prefix}gzipped"], false );
				}
			} else {
				delete_transient( "{$this->prefix}rules_flushed" );
			}
			$this->do_notify();
			if ( !empty( $message ) && is_string( $message ) ) {
				$this->debug_message( $message );
			} else {
				$this->debug_message( __( 'Updated sitemap settings.', 'all-in-one-seo-pack' ) );				
			}
		}

		function add_xml_mime_type( $mime ) {
			if ( !empty( $mime ) ) {
				$mime['xml'] = 'text/xml';
			}
			return $mime;
		}

		/** Write sitemaps (compressed or otherwise) to the filesystem. **/
		function write_sitemaps( $filename, $contents ) {
			$this->write_sitemap( $filename . ".xml", $contents );
			if ( $this->options["{$this->prefix}gzipped"] ) $this->write_sitemap( $filename . ".xml.gz", $contents, true );			
		}
		
		/** Write a single sitemap to the filesystem, handle compression. **/
		function write_sitemap($filename, $contents, $gzip = false) {
			if ( $gzip ) $contents = gzencode( $contents );
			add_filter( 'upload_mimes', Array( $this, 'add_xml_mime_type' ) );
			$filename = get_home_path() . sanitize_file_name( $filename );
			remove_filter( 'upload_mimes', Array( $this, 'add_xml_mime_type' ) );
			return $this->save_file( $filename, $contents );
		}
		
		/*** Helper function for handling default values ***/
		function get_default_values( $defaults, $prefix, &$cache, $item, $nodefaults = false, $type = '' ) {
			if ( !empty( $cache[ $item . $type ] ) ) return $cache[ $item . $type ];
			if ( !empty( $defaults[ $item ] ) ) {
				$field = $this->prefix . $prefix . $item;
				if ( $this->option_isset( $prefix . $item ) && $this->options[ $field ] != 'no' ) {
					if ( ( $this->options[ $field ] == 'sel' ) && !empty( $type ) && ( isset( $this->options[ $this->prefix . $prefix . $item . '_' . $type ] ) ) ) {
						if ( $this->options[ $this->prefix . $prefix . $item . '_' . $type ] == 'no' ) return false;
						if ( $this->options[ $this->prefix . $prefix . $item . '_' . $type ] == 'sel' ) return false;
						$cache[ $item . $type ] = $this->options[ $this->prefix . $prefix . $item . '_' . $type ];
					} else {
						if ( $this->options[ $field ] == 'no' ) return false;
						if ( $this->options[ $field ] == 'sel' ) return false;
						$cache[ $item . $type ] = $this->options[ $field ];
					}
					return $cache[ $item . $type ];
				}
				if ( $nodefaults ) return false;
				return $defaults[ $item ];
			}
			return false;
		}

		/** Get priority settings for sitemap entries. **/
		function get_default_priority( $item, $nodefaults = false, $type = '' ) {
			$defaults = Array( 'homepage' => '1.0', 'blog' => '0.9', 'sitemap' => '0.8', 'post' => '0.7', 'archive' => '0.5', 'author' => '0.3', 'taxonomies' => '0.3' );
			static $cache = Array();
			return $this->get_default_values( $defaults, 'prio_', $cache, $item, $nodefaults, $type );
		}

		/** Get frequency settings for sitemap entries. **/
		function get_default_frequency( $item, $nodefaults = false, $type = '' ) {
			$defaults = Array( 'homepage' => 'always', 'blog' => 'daily', 'sitemap' => 'hourly', 'post' => 'weekly', 'archive' => 'monthly', 'author' => 'weekly', 'taxonomies' => 'monthly' );
			static $cache = Array();
			return $this->get_default_values( $defaults, 'freq_', $cache, $item, $nodefaults, $type );
		}
		
		/** Build an index of sitemaps used. **/
		function get_sitemap_index_filenames() {
			$files = Array();
			$options = $this->options;
			$prefix = $options["{$this->prefix}filename"];
			$suffix = '.xml';
			if ( $options["{$this->prefix}gzipped"] ) $suffix .= '.gz';
			if ( empty( $options["{$this->prefix}posttypes"] ) ) $options["{$this->prefix}posttypes"] = Array();
			if ( empty( $options["{$this->prefix}taxonomies"] ) ) $options["{$this->prefix}taxonomies"] = Array();
			$options["{$this->prefix}posttypes"] = array_diff( $options["{$this->prefix}posttypes"], Array( 'all' ) );
			$options["{$this->prefix}taxonomies"] = array_diff( $options["{$this->prefix}taxonomies"], Array( 'all' ) );
			$url_base = trailingslashit( get_home_url() );
			$files[] = Array( 'loc' => $url_base . $prefix . '_addl' . $suffix );
			if ( !empty( $options["{$this->prefix}posttypes"] ) ) {
				$prio = $this->get_default_priority( 'post' );
				$freq = $this->get_default_frequency( 'post' );
				$post_counts = $this->get_all_post_counts( Array('post_type' => $options["{$this->prefix}posttypes"], 'post_status' => 'publish') );
				if ( !is_array( $post_counts ) && is_array( $options["{$this->prefix}posttypes"] ) && count( $options["{$this->prefix}posttypes"] ) == 1 ) {
					$post_counts = Array( $options["{$this->prefix}posttypes"][0] => $post_counts );
				}
				foreach( $options["{$this->prefix}posttypes"] as $sm ) {
					if ( $post_counts[$sm] == 0 ) continue;
					if ( $this->paginate ) {
						if ( $post_counts[$sm] > $this->max_posts ) {
							$count = 1;
							for( $post_count = 0; $post_count < $post_counts[$sm]; $post_count += $this->max_posts ) {
								$files[] = Array( 'loc' => $url_base . $prefix . '_' . $sm . '_' . ( $count++ ) . $suffix, 'priority' => $prio, 'changefreq' => $freq );
							}
						} else $files[] = Array( 'loc' => $url_base . $prefix . '_' . $sm . $suffix, 'priority' => $prio, 'changefreq' => $freq );
					} else
						$files[] = Array( 'loc' => $url_base . $prefix . '_' . $sm . $suffix, 'priority' => $prio, 'changefreq' => $freq );					
				}
			}
			if ( $this->option_isset( 'archive' ) )
				$files[] = Array( 'loc' => $url_base . $prefix . '_archive' . $suffix, 'priority' => $this->get_default_priority( 'archive' ), 'changefreq' => $this->get_default_frequency( 'archive' )  );
			if ( $this->option_isset( 'author' ) )
				$files[] = Array( 'loc' => $url_base . $prefix . '_author' . $suffix, 'priority' => $this->get_default_priority( 'author' ), 'changefreq' => $this->get_default_frequency( 'author' )  );
				
			if ( !empty( $options["{$this->prefix}taxonomies"] ) )
				foreach( $options["{$this->prefix}taxonomies"] as $sm ) {
					$term_count = wp_count_terms( $sm, array('hide_empty' => true) );
					if ( !is_wp_error( $term_count ) && ( $term_count > 0 ) ) {
						if ( $this->paginate ) {
							if ( $term_count > $this->max_posts ) {
								$count = 1;
								for( $tc = 0; $tc < $term_count; $tc += $this->max_posts ) {
									$files[] = Array( 'loc' => $url_base . $prefix . '_' . $sm . '_' . ( $count++ ) . $suffix, 'priority' => $this->get_default_priority( 'taxonomies' ), 'changefreq' => $this->get_default_frequency( 'taxonomies' ) );
								}
							} else $files[] = Array( 'loc' => $url_base . $prefix . '_' . $sm . $suffix, 'priority' => $this->get_default_priority( 'taxonomies' ), 'changefreq' => $this->get_default_frequency( 'taxonomies' ) );
						} else
							$files[] = Array( 'loc' => $url_base . $prefix . '_' . $sm . $suffix, 'priority' => $this->get_default_priority( 'taxonomies' ), 'changefreq' => $this->get_default_frequency( 'taxonomies' )  );						
					}
				}
			foreach( $this->get_child_sitemap_urls() as $csm )
				$files[] = Array( 'loc' => $csm, 'priority' => $this->get_default_priority( 'sitemap' ), 'changefreq' => $this->get_default_frequency( 'sitemap' ) );
			return $files;
		}
		
		function do_build_sitemap( $sitemap_type, $page = 0, $filename = '', $comment = '' ) {
			if ( empty( $filename ) ) {
				if ( $sitemap_type == 'root' ) {
					$filename = $this->options["{$this->prefix}filename"];					
				} else {
					$filename = $this->options["{$this->prefix}filename"] . '_' . $sitemap_type;					
				}
			}
			if ( empty( $comment ) )
				$comment = __( "file '%s' statically", 'all-in-one-seo-pack' );
			$sitemap_data = $this->get_sitemap_data( $sitemap_type, $page );
			if ( ( $sitemap_type == 'root' ) && !empty( $this->options["{$this->prefix}indexes"] ) ) {
				return $this->build_sitemap_index( $sitemap_data, sprintf( $comment, $filename ) );
			} else {
				return $this->build_sitemap( $sitemap_data, sprintf( $comment, $filename ) );
			}
		}
		
		function do_write_sitemap( $sitemap_type, $page = 0, $filename = '', $comment = '' ) {
			if ( empty( $filename ) ) {
				if ( $sitemap_type == 'root' ) {
					$filename = $this->options["{$this->prefix}filename"];					
				} else {
					$filename = $this->options["{$this->prefix}filename"] . '_' . $sitemap_type;					
				}
			}
			if ( empty( $comment ) )
				$comment = __( "file '%s' statically", 'all-in-one-seo-pack' );
			$this->write_sitemaps( $filename, $this->do_build_sitemap( $sitemap_type, $page, $filename, $comment ) );
		}

		/** Build all the indexes. **/
		function do_indexed_sitemaps() {
			$this->start_memory_usage = memory_get_peak_usage();
			$options = $this->options;
			
			$this->do_write_sitemap( 'root' );
			$this->do_write_sitemap( 'addl' );
			
			if ( $this->option_isset( 'archive' ) ) $this->do_write_sitemap( 'archive' );
			if ( $this->option_isset( 'author' ) ) $this->do_write_sitemap( 'author' );

			if ( ( !isset( $options["{$this->prefix}posttypes"] ) ) || ( !is_array( $options["{$this->prefix}posttypes"] ) ) ) $options["{$this->prefix}posttypes"] = Array();
			if ( ( !isset( $options["{$this->prefix}taxonomies"] ) ) || ( !is_array( $options["{$this->prefix}taxonomies"] ) ) ) $options["{$this->prefix}taxonomies"] = Array();
			$options["{$this->prefix}posttypes"] = array_diff( $options["{$this->prefix}posttypes"], Array( 'all' ) );
			$options["{$this->prefix}taxonomies"] = array_diff( $options["{$this->prefix}taxonomies"], Array( 'all' ) );

			if ( !empty( $options["{$this->prefix}posttypes"] ) ) {
				$post_counts = $this->get_all_post_counts( Array('post_type' => $options["{$this->prefix}posttypes"], 'post_status' => 'publish') );
				foreach ( $options["{$this->prefix}posttypes"] as $posttype ) {
					if ( $post_counts[$posttype] === 0 ) continue;
					if ( $this->paginate && ( $post_counts[$posttype] > $this->max_posts ) ) {
							$count = 1;
							for( $post_count = 0; $post_count < $post_counts[$posttype]; $post_count += $this->max_posts ) {								
								$this->do_write_sitemap( $posttype, $count - 1, $options["{$this->prefix}filename"] . "_{$posttype}_{$count}" );
								$count++;
							}
					} else {
						$this->do_write_sitemap( $posttype );
					}
				}
			}
			
			if ( !empty( $options["{$this->prefix}taxonomies"] ) )
				foreach( $options["{$this->prefix}taxonomies"] as $taxonomy ) {
					$term_count = wp_count_terms( $taxonomy, array('hide_empty' => true) );
					if ( !is_wp_error( $term_count ) && ( $term_count > 0 ) ) {
						if ( $this->paginate ) {
							if ( $term_count > $this->max_posts ) {
								$count = 1;
								for( $tc = 0; $tc < $term_count; $tc += $this->max_posts ) {
									$this->do_write_sitemap( $taxonomy, $tc, $options["{$this->prefix}filename"] . "_{$taxonomy}_{$count}" );
									$count++;
								}
							} else {
								$this->do_write_sitemap( $taxonomy );
							}
						} else {
							$this->do_write_sitemap( $taxonomy );
						}
					}
				}
			$this->log_stats( 'indexed', $options["{$this->prefix}gzipped"], false );
		}
		
		function get_simple_sitemap() {
			$home = Array(
						'loc' => get_home_url(),
						'priority' => $this->get_default_priority( 'homepage' ),
						'changefreq' => $this->get_default_frequency( 'homepage' )
					);
			$posts = get_option( 'page_for_posts' );
			$this->paginate = false;
			if ( $posts ) {
				$posts = $this->get_permalink( $posts );
				if ( $posts == $home['loc'] )
					$posts = null;
				else
					$posts = Array(
								'loc' => $posts,
								'priority' => $this->get_default_priority( 'blog' ),
								'changefreq' => $this->get_default_frequency( 'blog' )
							 );
			}
			$child = $this->get_child_sitemap_urls();
			$options = $this->options;
			if ( is_array( $options["{$this->prefix}posttypes"] ) )
				$options["{$this->prefix}posttypes"] = array_diff( $options["{$this->prefix}posttypes"], Array( 'all' ) );
			if ( is_array( $options["{$this->prefix}taxonomies"] ) )
				$options["{$this->prefix}taxonomies"] = array_diff( $options["{$this->prefix}taxonomies"], Array( 'all' ) );
			$prio = $this->get_all_post_priority_data( $options["{$this->prefix}posttypes"] );
			if ( $this->option_isset( 'archive' ) ) $prio = array_merge( $prio, $this->get_archive_prio_data() );
			if ( $this->option_isset( 'author' ) ) $prio = array_merge( $prio, $this->get_author_prio_data() );
			foreach ( $prio as $k => $p )
				if ( untrailingslashit( $p['loc'] ) == untrailingslashit( $home['loc'] ) ) {
					$prio[$k]['priority'] = '1.0';
					$home = null;
					break;
				}
			if ( ( $posts != null ) && isset( $posts['loc'] ) )
				foreach ( $prio as $k => $p )
					if ( $p['loc'] == $posts['loc'] ) {
						$prio[$k]['priority'] = $this->get_default_priority( 'blog' );
						$prio[$k]['changefreq'] = $this->get_default_frequency( 'blog' );
						$posts = null;
						break;
					}
			if ( is_array( $posts ) ) array_unshift( $prio, $posts );
			if ( is_array( $home ) )  array_unshift( $prio, $home );				
			$terms = get_terms( $options["{$this->prefix}taxonomies"], $this->get_tax_args() );
			$prio2 = $this->get_term_priority_data( $terms );
			$prio3 = $this->get_addl_pages_only();
			$prio = array_merge( $child, $prio, $prio2, $prio3 );
			if ( is_array( $this->extra_sitemaps ) )
				foreach( $this->extra_sitemaps as $sitemap_type ) {
					$sitemap_data = Array();
					$sitemap_data = apply_filters( $this->prefix . 'custom_' . $sitemap_type, $sitemap_data, $page, $this_options );
					$prio = array_merge( $prio, $sitemap_data );
				}
			return $prio;
		}

		/** Build a single, stand-alone sitemap without indexes. **/
		function do_simple_sitemap( $comment = '' ) {
			$sitemap_data = $this->get_simple_sitemap();
			$sitemap_data = apply_filters( $this->prefix . 'data', $sitemap_data, 'root', 0, $this->options );
			return $this->build_sitemap( $sitemap_data, $comment );
		}
		
		/** Output the XML for a sitemap. **/
		function output_sitemap( $urls, $comment = '' ) {
			$max_items = 50000;
			if ( !is_array( $urls ) ) return null;
			echo '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n\r\n";
			echo "<!-- " . sprintf( $this->comment_string, $comment, AIOSEOP_VERSION, date('D, d M Y H:i:s e') ) . " -->\r\n";
			$plugin_path = $this->plugin_path['url'];
			$plugin_url = parse_url( $plugin_path );
			$current_host = $_SERVER['HTTP_HOST'];
			if ( empty( $current_host ) ) $current_host = $_SERVER['SERVER_NAME'];
			
			if ( !empty( $current_host ) && ( $current_host != $plugin_url['host'] ) )
				$plugin_url['host'] = $current_host;
			
			//unset( $plugin_url['scheme'] );
			$plugin_path = $this->unparse_url( $plugin_url );
			
			$xml_header = '<?xml-stylesheet type="text/xsl" href="' . AIOSEOP_PLUGIN_URL . 'sitemap.xsl"?>' . "\r\n"
						. '<urlset ';
			$namespaces = apply_filters( $this->prefix . 'xml_namespace', Array( 'xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9' ) );
			if ( !empty( $namespaces ) ) {
				$ns = Array();
				foreach( $namespaces as $k => $v ) {
					$ns[] = esc_attr( $k ) . '=' . '"' . esc_url( $v, Array( 'http', 'https' ) ) . '"';
				}
				$xml_header .= join( "\r\n\t", $ns );
			}
			$xml_header .= '>' . "\r\n";
			echo $xml_header;
			$count = 0;
			foreach ( $urls as $url ) {
				echo "\t<url>\r\n";
				if ( is_array( $url ) ) {
					foreach ( $url as $k => $v ) {
						if ( !empty( $v ) ) {
							if ( $k == 'loc' ) $v = esc_url( $v );
								if ( is_array( $v ) ) {
									$buf = "\t\t\t<$k>\r\n";
									foreach( $v as $ext => $attr ) {
										if ( is_array( $attr ) ) {
											$buf = '';
											echo "\t\t<$k>\r\n";
											foreach( $attr as $a => $nested ) {
												if ( is_array( $nested ) ) {
													echo "\t\t\t<$a>\r\n";
													foreach( $nested as $next => $nattr ) {
														echo "\t\t\t\t<$next>$nattr</$next>\r\n";
													}
													echo "\t\t\t</$a>\r\n";
												} else echo "\t\t\t<$a>$nested</$a>\r\n";
											}
											echo "\t\t</$k>\r\n";
										} else $buf .= "\t\t\t<$ext>$attr</$ext>\r\n";
									}
									if ( !empty( $buf ) ) echo $buf . "\t\t</$k>\r\n";
								} else echo "\t\t<$k>$v</$k>\r\n";
						}
					}
				} else {
					echo "\t\t<loc>" . esc_url( $url ) . "</loc>\r\n";
				}
				echo "\t</url>\r\n";
				if ( $count >= $max_items ) break;
			}
			echo '</urlset>';
		}
		
		/** Output the XML for a sitemap index. **/
		function output_sitemap_index( $urls, $comment = '' ) {
			$max_items = 50000;
			if ( !is_array( $urls ) ) return null;
			echo '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n\r\n";
			echo "<!-- " . sprintf( $this->comment_string, $comment, AIOSEOP_VERSION, date('D, d M Y H:i:s e') ) . " -->\r\n";
			echo '<?xml-stylesheet type="text/xsl" href="' . AIOSEOP_PLUGIN_URL . 'sitemap.xsl"?>' . "\r\n";
			echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\r\n";
			$count = 0;
			foreach ( $urls as $url ) {
				echo "\t<sitemap>\r\n";
				if ( is_array( $url ) ) {
					foreach ( $url as $k => $v ) {
						if ( $k == 'loc' ) {
							echo "\t\t<$k>" . esc_url( $v ) . "</$k>\r\n";
						} elseif ( $k == 'lastmod' ) {
							echo "\t\t<$k>$v</$k>\r\n";	
						}
					}
				} else {
					echo "\t\t<loc>" . esc_url( $url ) . "</loc>\r\n";
				}
				echo "\t</sitemap>\r\n";
				$count++;
				if ( $count >= $max_items ) break;
			}
			echo '</sitemapindex>';
		}
		
		/** Return an XML sitemap index as a string. **/
		function build_sitemap_index( $urls, $comment = '' ) {
			ob_start();
			$this->output_sitemap_index( $urls, $comment );
			return ob_get_clean();
		}
		
		/** Return an XML sitemap as a string. **/
		function build_sitemap( $urls, $comment = '' ) {
			ob_start();
			$this->output_sitemap( $urls, $comment );
			return ob_get_clean();
		}

		/** Return sitemap data for an array of terms. **/
		function get_term_priority_data( $terms ) {
			$prio = Array();
			if (is_array( $terms ) ) {
				$def_prio = $this->get_default_priority( 'taxonomies' );
				$def_freq = $this->get_default_frequency( 'taxonomies' );
				foreach ($terms as $term) {
					$pr_info = Array();
					$pr_info['loc'] = $this->get_term_link( $term, $term->taxonomy );
					if ( ( $this->options[ $this->prefix . 'prio_taxonomies' ] == 'sel' ) && ( isset( $this->options[ $this->prefix . 'prio_taxonomies_' . $term->taxonomy ] ) ) && ( $this->options[ $this->prefix . 'prio_taxonomies_' . $term->taxonomy ] != 'no' ) ) {
							$pr_info['priority'] = $this->options[ $this->prefix . 'prio_taxonomies_' . $term->taxonomy ];
					} else $pr_info['priority'] = $def_prio;
					if ( ( $this->options[ $this->prefix . 'freq_taxonomies' ] == 'sel' ) && ( isset( $this->options[ $this->prefix . 'freq_taxonomies_' . $term->taxonomy ] ) ) && ( $this->options[ $this->prefix . 'freq_taxonomies_' . $term->taxonomy ] != 'no' ) ) {
							$pr_info['changefreq'] = $this->options[ $this->prefix . 'freq_taxonomies_' . $term->taxonomy ];
					} else $pr_info['changefreq'] = $def_freq;
					$prio[] = $pr_info;
				}
			}
			return $prio;
		}

		/** Return a list of permalinks for an array of terms. **/
		function get_term_permalinks( $terms ) {
			$links = Array();
			if (is_array($terms)) {
				foreach ($terms as $term) {
					$url = $this->get_term_link( $term );
					$links[] = $url;
				}
			}
			return $links;
		}
		
		/** Return permalinks for archives. **/
		function get_archive_permalinks( $posts ) {
			$links = Array();
			$archives = Array();
			if (is_array( $posts) )
				foreach ( $posts as $post ) {
					$date = mysql2date( 'U', $post->post_date );
					$year = date( 'Y', $date );
					$month = date( 'm', $date );
					$archives[ $year . '-' . $month ] = Array( $year, $month );
				}					
			$archives = array_keys( $archives );
			foreach( $archives as $d ) $links[] = get_month_link( $d[0], $d[1] );
			return $links;
		}
		
		/** Return permalinks for authors. **/
		function get_author_permalinks( $posts ) {
			$links = Array();
			$authors = Array();
			if (is_array( $posts) )
				foreach ( $posts as $post )
					$authors[ $post->author_id ] = 1;
			$authors = array_keys( $authors );
			foreach( $authors as $auth_id ) $links[] = get_author_posts_url( $auth_id );
			return $links;
		}

		/** Return permalinks for posts. **/
		function get_post_permalinks( $posts ) {
			$links = Array();
			if (is_array( $posts) )
				foreach ( $posts as $post ) {
					$post->filter = "sample";
					$url = $this->get_permalink( $post );
					$links[] = $url;					
				}
			return $links;
		}
		
		/** Convert back from parse_url -- props to thomas at gielfeldt dot com, http://www.php.net/manual/en/function.parse-url.php#106731 **/
		function unparse_url($parsed_url) {
			$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : ''; 
			$host     = isset($parsed_url['host']) ? $parsed_url['host'] : ''; 
			if ( !empty( $host ) && empty( $scheme ) ) $scheme = '//';
			$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : ''; 
			$user     = isset($parsed_url['user']) ? $parsed_url['user'] : ''; 
			$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
			$pass     = ($user || $pass) ? "$pass@" : '';
			$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
			$query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
			$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
			return "$scheme$user$pass$host$port$path$query$fragment"; 
		}
		
		/** Return data for user entered additional pages. **/
		function get_addl_pages_only() {
			$pages = Array();
			if ( !empty( $this->options[ $this->prefix . 'addl_pages' ] ) ) {
				$siteurl = parse_url( get_home_url() );
				foreach( $this->options[ $this->prefix . 'addl_pages' ] as $k => $v ) {
					$url = parse_url( $k );
					if ( empty( $url['scheme'] ) ) $url['scheme'] = $siteurl['scheme'];
					if ( empty( $url['host'] ) ) $url['host'] = $siteurl['host'];
					$freq = $prio = $mod = '';
					if ( !empty( $v['mod'] ) )  $mod  = $v['mod'];
					if ( !empty( $v['freq'] ) ) $freq = $v['freq'];
					if ( !empty( $v['prio'] ) ) $prio = $v['prio'];
					if ( $freq == 'no' ) $freq = '';
					if ( $prio == 'no' ) $prio = '';
					$mod = date( 'Y-m-d\TH:i:s\Z', mysql2date( 'U', $mod ) );
					$pages[] = Array( 'loc' => $this->unparse_url( $url ), 'lastmod' => $mod, 'changefreq' => $freq, 'priority' => $prio );					
				}
			}
			$pages = apply_filters( $this->prefix . 'addl_pages_only', $pages );
			return $pages;
		}

		/** Return data for user entered additional pages and extra pages. **/
		function get_addl_pages() {
			$home = Array();
			$home = Array(
						'loc' => get_home_url(),
						'priority' => $this->get_default_priority( 'homepage' ),
						'changefreq' => $this->get_default_frequency( 'homepage' ) 
					);
			$posts = get_option( 'page_for_posts' );
			if ( $posts ) {
				$posts = $this->get_permalink( $posts );
				if ( $posts == $home['loc'] )
					$posts = Array();
				else
					$posts = Array(
								'loc' => $posts,
								'priority' => $this->get_default_priority( 'blog' ),
								'changefreq' => $this->get_default_frequency( 'blog' )
							 );
			} else $posts = Array();
			$pages = $this->get_addl_pages_only();
			if ( !empty( $home ) )
				$pages[] = $home;
			if ( !empty( $posts ) )
				$pages[] = $posts;
			$pages = apply_filters( $this->prefix . 'addl_pages', $pages );
			return $pages;
		}
		
		/** Return links for user entered additional pages. **/
		function get_addl_page_links() {
			if ( !empty( $this->options[ $this->prefix . 'addl_pages' ] ) )
				return array_keys( $this->options[ $this->prefix . 'addl_pages' ] );
			return Array();
		}
		
		/** Scores posts based on date and relative comment count, if any. **/
		function get_prio_calc( $date, $stats = 0 ) {
			static $cur_time = null;
			if ($cur_time === null) $cur_time = time();
			$time = $cur_time - mysql2date( 'U', $date );
			if ( !empty( $stats ) && isset( $stats['max'] ) && ( $stats['max'] ) ) {
				$minadj = $time >> 3;
				$maxadj = $time >> 1;
				$avg = $stats['count'] / $stats['total'];
				$calc = ( $stats['comment_count'] - $stats['min'] ) / $stats['max'];
				$calc = $maxadj * $calc;
				if ( $avg < $stats['comment_count'] )
					$minadj = $time >> 2;
				else
					$maxadj = $time >> 2;
				if ( $calc > $maxadj ) $calc = $maxadj;
				if ( $calc < $minadj ) $calc = $minadj;
				$time -= $calc;
			}
			$days = $time / ( 60 * 60 * 24 );
			$prio_table = Array(
				'daily' => 7,
				'weekly' => 30,
				'monthly' => 210,
				'yearly' => null
			);
			$interval = 1.0;
			$prev_days = 0;
			foreach ($prio_table as $change => $max_days) {
			        $interval -= 0.3;
			        if ( $max_days === null) {
			                $changefreq = $change;
			                $prio = 0.1;
			                break;
			        }
			        if ($days < $max_days) {
			        	$int_days_max = $max_days - $prev_days;
			        	$int_days = $days - $prev_days;
			        	$prio = $interval + ( ( int ) ( 3 * ( ( $max_days - $int_days ) / $int_days_max ) ) / 10.0 );
						$changefreq = $change;
						break;
			        }
			        $prev_days = $max_days;
			}
			return Array( 'lastmod' => $date, 'changefreq' => $changefreq, 'priority' => $prio );
		}
		
		/** Generate sitemap priority data for archives from an array of posts. **/
		function get_archive_prio_from_posts( $posts ) {
			$archives = Array();
			if ( is_array( $posts ) )
				foreach( $posts as $p ) {
					if ( $p->post_type != 'post' ) continue;
					$date = date( 'Y-m', mysql2date( 'U', $p->post_date ) );
					if ( empty( $archives[ $date ] ) ) {
						$archives[ $date ] = $p;
					} else {
						if ( $p->post_modified > $archives[ $date ]->post_modified )
							$archives[ $date ] = $p;
					}
				}
			if ( !empty( $archives ) )
				return $this->get_prio_from_posts( $archives, $this->get_default_priority( 'archive', true ), $this->get_default_frequency( 'archive', true ), Array( $this, 'get_archive_link_from_post' ) );
			return $archives;
		}
		
		/** Return an archive link from a post. **/
		function get_archive_link_from_post( $post ) {
			if ( $post->post_type != 'post' ) return false;
			$date = mysql2date( 'U', $post->post_date );
			return get_month_link( date( 'Y', $date ), date( 'm', $date ) );
		}
		
		/** Generate sitemap priority data for authors from an array of posts. **/
		function get_author_prio_from_posts( $posts ) {
			$authors = Array();
			if ( is_array( $posts ) )
				foreach( $posts as $p ) {
					if ( $p->post_type != 'post' ) continue;
					if ( empty( $authors[ $p->post_author ] ) ) {
						$authors[ $p->post_author ] = $p;
					} else {
						if ( $p->post_modified > $authors[ $p->post_author ]->post_modified )
							$authors[ $p->post_author ] = $p;
					}
			}
			return $this->get_prio_from_posts( $authors, $this->get_default_priority( 'author', true ), $this->get_default_frequency( 'author', true ), Array( $this, 'get_author_link_from_post' ) );
		}
		
		/** Return an author link from a post. **/
		function get_author_link_from_post( $post ) {
			return get_author_posts_url( $post->post_author );
		}
		
		/** Return comment statistics on an array of posts. **/
		function get_comment_count_stats( $posts ) {
			$count = 0;
			$total = 0.0;
			$min = null;
			$max = 0;
			if ( is_array( $posts ) )
				foreach ( $posts as $post )
					if ( !empty( $post->comment_count ) ) {
						$cnt = $post->comment_count;
						$count++;
						$total += $cnt;
						if ( $min === null ) $min = $cnt;
						if ( $max < $cnt ) $max = $cnt;
						if ( $min > $cnt ) $min = $cnt;
					}
			if ( $count )
				return Array( 'max' => $max, 'min' => $min, 'total' => $total, 'count' => $cnt );
			else
				return 0;
		}
		
		/** Generate sitemap priority data from an array of posts. **/
		function get_prio_from_posts( $posts, $prio_override = false, $freq_override = false, $linkfunc = 'get_permalink' ) {
			$prio = Array();
			$args = Array( 'prio_override' => $prio_override, 'freq_override' => $freq_override, 'linkfunc' => $linkfunc );
			if ( ( $prio_override ) && ( $freq_override ) )
				$stats = 0;
			else
				$stats = $this->get_comment_count_stats( $posts );
			if ( is_array( $posts ) ) {
				foreach ( $posts as $post ) {
					$url = '';
					$post->filter = "sample";
					if ( $linkfunc == 'get_permalink' )
						$url = $this->get_permalink( $post );
					else
						$url = call_user_func( $linkfunc, $post );
					$date = $post->post_modified;
					if ( '0000-00-00 00:00:00' === $date )
						$date = $post->post_date;
					if ( '0000-00-00 00:00:00' !== $date )
						$date = date( 'Y-m-d\TH:i:s\Z', mysql2date( 'U', $date ) );
					else
						$date = 0;
					if ( ( $prio_override ) && ( $freq_override ) )
						$pr_info = Array( 'lastmod' => $date, 'changefreq' => null, 'priority' => null );
					else {
						if ( empty( $post->comment_count ) )
							$stat = 0;
						else
							$stat = $stats;
						if ( !empty( $stat ) ) $stat['comment_count'] = $post->comment_count;
						$pr_info = $this->get_prio_calc( $date, $stat );
					}
					if ( $prio_override )
						$pr_info[ 'priority' ] = $prio_override;
					if ( $freq_override )
						$pr_info[ 'changefreq' ] = $freq_override;
					if ( ( $this->options[ $this->prefix . 'prio_post' ] == 'sel' ) && ( isset( $this->options[ $this->prefix . 'prio_post_' . $post->post_type ] ) ) ) {
						if ( ( $this->options[ $this->prefix . 'prio_post_' . $post->post_type ] != 'no' ) && ( $this->options[ $this->prefix . 'prio_post_' . $post->post_type ] != 'sel' ) )
							$pr_info[ 'priority' ] = $this->options[ $this->prefix . 'prio_post_' . $post->post_type ];
					}
					if ( ( $this->options[ $this->prefix . 'freq_post' ] == 'sel' ) && ( isset( $this->options[ $this->prefix . 'freq_post_' . $post->post_type ] ) ) ) {
						if ( ( $this->options[ $this->prefix . 'freq_post_' . $post->post_type ] != 'no' ) && ( $this->options[ $this->prefix . 'freq_post_' . $post->post_type ] != 'sel' ) )
							$pr_info[ 'changefreq' ] = $this->options[ $this->prefix . 'freq_post_' . $post->post_type ];
					}
					$pr_info['loc'] = $url;
					if ( is_float( $pr_info['priority'] ) ) $pr_info['priority'] = sprintf( "%0.1F", $pr_info['priority'] );
					$pr_info = apply_filters( $this->prefix . 'prio_item_filter', $pr_info, $post, $args );
					if ( !empty( $pr_info ) )
						$prio[] = $pr_info;
				}
			}
			return $prio;
		}

		/** Return excluded categories for taxonomy queries. **/
		function get_tax_args( $page = 0 ) {
			$args = Array();
			if ( $this->option_isset( 'excl_categories' ) )
				$args['exclude'] = $this->options[ $this->prefix . 'excl_categories'];
			if ( $this->paginate ) {
				$args['number'] = $this->max_posts;
				$args['offset'] = $page * $this->max_posts;
				
			}
			return $args;
		}

		/** Return excluded categories and pages for post queries. **/
		function set_post_args( $args ) {
			if ( $this->option_isset( 'excl_categories' ) ) {
				$cats = Array();
				foreach( $this->options[ $this->prefix . 'excl_categories'] as $c ) $cats[] = -$c;
				$args['category'] = implode( ',', $cats );
			}
			if ( $this->option_isset( 'excl_pages' ) )
				$args['exclude'] = $this->options[ $this->prefix . 'excl_pages' ];
			return $args;
		}
		
		/** Return sitemap data for archives. **/
		function get_archive_prio_data() {
			$args = Array( 'numberposts' => 50000, 'post_type' => 'post' );
			$args = $this->set_post_args( $args );
			$posts = $this->get_all_post_type_data( $args );
			return $this->get_archive_prio_from_posts( $posts );
		}
		
		/** Return sitemap data for authors. **/
		function get_author_prio_data() {
			$args = Array( 'numberposts' => 50000, 'post_type' => 'post' );
			$args = $this->set_post_args( $args );
			$posts = $this->get_all_post_type_data( $args );
			return $this->get_author_prio_from_posts( $posts );
		}

		/** Return sitemap data for posts. **/
		function get_all_post_priority_data( $include = 'any', $status = 'publish', $page = 0 ) {
			$posts = $page_query = Array();
			if ( $this->paginate )
				$page_query = Array( 'offset' => $page * $this->max_posts );
			if ( ( $status == 'publish' ) && ( $include == 'attachment' ) ) $status = 'inherit';
			if ( is_array( $include ) && ( ( $pos = array_search( 'attachment', $include ) ) !== false ) ) {
				unset( $include[$pos] );
				$att_args = Array( 'post_type' => 'attachment', 'post_status' => 'inherit' );
				$att_args = array_merge( $att_args, $page_query );
				$posts = $this->get_all_post_type_data( $att_args );
			}
			$args = Array( 'post_type' => $include, 'post_status' => $status );
			$args = array_merge( $args, $page_query );
			$args = $this->set_post_args( $args );
			$posts = array_merge( $this->get_all_post_type_data( $args ), $posts );
			return $this->get_prio_from_posts( $posts, $this->get_default_priority( 'post', true ), $this->get_default_frequency( 'post', true ) );
		}

		/** Return a list of all permalinks. **/
		function get_all_permalinks( $include = 'any', $status = 'publish' ) {
			$args = Array( 'post_type' => $include, 'post_status' => $status );
			$args = $this->set_post_args( $args );
			$posts = $this->get_all_post_type_data( $args );
			$links = $this->get_post_permalinks( $posts );
			if ( $this->option_isset( 'archive' ) )
				$links = array_merge( $links, $this->get_archive_permalinks( $posts ) );
			if ( $this->option_isset( 'author' ) )
				$links = array_merge( $links, $this->get_author_permalinks( $posts ) );
			return $links;
		}
		
		/** Static memory cache for permalink_structure option. **/
		function cache_structure( $pre ) {
			return $this->cache_struct;
		}
		
		/** Static memory cache for home option. **/
		function cache_home( $pre ) {
			return $this->cache_home;
		}
		
		/** Cache permalink_structure and home for repeated sitemap queries. **/
		function cache_options() {
			static $start = true;
			if ( $start ) {
				$this->cache_struct = get_option( 'permalink_structure' );
				if ( !empty( $this->cache_struct ) ) add_filter( 'pre_option_permalink_structure', Array( $this, 'cache_structure' ) );
				$this->cache_home = get_option( 'home' );
				if ( !empty( $this->cache_home ) ) add_filter( 'pre_option_home', Array( $this, 'cache_home' ) );
				$start = false;
			}
		}

		/** Call get_term_link with caching in place. **/
		function get_term_link( $term, $taxonomy = '' ) {
			static $start = true;
			if ( $start ) {
				$this->cache_options();
				$start = false;
			}
			return get_term_link( $term, $taxonomy );
		}
		
		/** Call get_permalink with caching in place. **/
		function get_permalink( $post ) {
			static $start = true;
			if ( $start ) {
				$this->cache_options();
				$start = false;
			}
			return get_permalink( $post );
		}
		
		/** Return term counts using wp_count_terms(). **/
		function get_all_term_counts( $args ) {
			$term_counts = null;
			if ( !empty( $args ) && !empty( $args['taxonomy'] ) )
				if ( !is_array( $args['taxonomy'] ) || ( count( $args['taxonomy'] ) == 1 ) ) {
					if ( is_array( $args['taxonomy'] ) )
						$args['taxonomy'] = array_shift( $args['taxonomy'] );
					$term_counts = wp_count_terms( $args['taxonomy'], array('hide_empty' => true) );
				} else
					foreach( $args['taxonomy'] as $taxonomy ) {
						if ( $taxonomy === 'all' ) continue;
						$term_counts[$taxonomy] = wp_count_terms( $taxonomy, array('hide_empty' => true) );
					}
			$term_counts = apply_filters( $this->prefix . 'term_counts', $term_counts, $args );
			return $term_counts;
		}
		
		/** Return post counts using wp_count_posts(). **/
		function get_all_post_counts( $args ) {
			$post_counts = null;
			$status = 'inherit';
			if ( !empty( $args['post_status'] ) ) $status = $args['post_status'];
			if ( !empty( $args ) && !empty( $args['post_type'] ) )
				if ( !is_array( $args['post_type'] ) || ( count( $args['post_type'] ) == 1 ) ) {
					if ( is_array( $args['post_type'] ) )
						$args['post_type'] = array_shift( $args['post_type'] );
					$count = (Array)wp_count_posts( $args['post_type'] );					
					$post_counts = $count[$status];
				} else
					foreach( $args['post_type'] as $post_type ) {
						if ( $post_type === 'all' ) continue;
						$count = (Array)wp_count_posts( $post_type );
						
						if ( empty( $count ) )
							$post_counts[$post_type] = 0;
						else {
							if ( $post_type == 'attachment' )
								$post_counts[$post_type] = $count['inherit'];
							else
								$post_counts[$post_type] = $count[$status];
						}
					}
			$post_counts = apply_filters( $this->prefix . 'post_counts', $post_counts, $args );
			return $post_counts;
		}
		
		function get_total_post_count( $args ) {
			$total = 0;
			$counts = $this->get_all_post_counts( $args );
			if ( !empty( $counts ) )
				if ( is_array( $counts ) )
					foreach( $counts as $count )
						$total += $count;
				else
					$total = $counts;
			return $total;
		}

		/** Return post data using get_posts(). **/
		function get_all_post_type_data( $args ) {
			$defaults = array(
				'numberposts' => $this->max_posts, 'offset' => 0,
				'category' => 0, 'orderby' => 'post_date',
				'order' => 'DESC', 'include' => array(),
				'exclude' => array(), 'post_type' => 'any',
				'meta_key' => '', 'meta_value' => '', 'meta_compare' => '', 'meta_query' => '',
				'cache_results' => false,
				'no_found_rows' => true
			);
			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) $defaults['suppress_filters'] = false;
			$args = wp_parse_args( $args, $defaults );
			if ( empty( $args['post_type'] ) )
				return apply_filters( $this->prefix . 'post_filter', Array(), $args );
			$exclude_slugs = Array();
			if ( !empty( $args['exclude'] ) ) {
				$exclude = preg_split( '/[\s,]+/', trim( $args['exclude'] ) );
				if ( !empty( $exclude ) ) {
					foreach( $exclude as $k => $v ) {
						if ( !is_numeric( $v ) || ( $v != (int)$v ) ) {
							$exclude_slugs[] = $v;
							unset( $exclude[$k] );
						}
					}
					if ( !empty( $exclude_slugs ) )
						$args['exclude'] = implode( ',', $exclude );
				}
			}
			
				$ex_args = $args;
				$ex_args['meta_key'] = '_aioseop_sitemap_exclude';
				$ex_args['meta_value'] = 'on';
				$ex_args['meta_compare'] = '=';
				$ex_args['fields'] = 'ids';
				$ex_args['posts_per_page'] = -1;
				$q = new WP_Query( $ex_args );
				if ( !is_array( $args['exclude'] ) ) $args['exclude'] = explode( ',', $args['exclude'] );
				if ( !empty( $q->posts ) ) $args['exclude'] = array_merge( $args['exclude'], $q->posts );
			// }
			
			$posts = get_posts( apply_filters( $this->prefix . 'post_query', $args ) );
			if ( !empty( $exclude_slugs ) ) {
				foreach( $posts as $k => $v ) {
					if ( in_array( $v->post_name, $exclude_slugs ) )
						unset( $posts[$k] );
				}
			}
			$posts = apply_filters( $this->prefix . 'post_filter', $posts, $args );
			return $posts;
		}
	}
}

