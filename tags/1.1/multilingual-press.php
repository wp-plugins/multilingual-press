<?php
/**
 * Plugin Name: Multilingual Press
 * Plugin URI:  https://github.com/inpsyde/multilingual-press
 * Description: By using the WordPress plugin Multilingual-Press it's much easier to build multilingual sites and run them with WordPress Multisite feature. 
 * Author:      Inpsyde GmbH
 * Author URI:  http://inpsyde.com
 * Version:     1.0.3
 * Text Domain: multilingualpress
 * Domain Path: /languages
 * License:     GPLv3
 * 
 * By using the WordPress plugin Multilingual-Press it's much
 * easier to build multilingual sites and run them with
 * WordPress Multisite feature.
 * 
 * @author      fb, rw, ms, th
 * @version     1.0.2
 * @package     mlp
 * @subpackage  main
 * 
 * Available hooks
 * =================
 * - mlp_blogs_add_fields - Allows modules to add form fields to the Multilingual Press blog settings screen
 * - mlp_blogs_add_fields_secondary - Same as above, with lower priority. 
 * - mlp_blogs_save_fields - Modules can hook in here to handle user data returned by their form fields
 * - mlp_options_page_add_metabox - This hook registers a metabox on the Multilingual Press options page. Use Mlp_Settingspage::$class_object->options_page for 'screen' parameter.
 * - mlp_settings_save_fields - Handles the data of the options page form. Function parameter contains the form data
 * - mlp_modules_add_fields - Add data to the module manager. Probably obsolete in the future.
 * - mlp_modules_save_fields - Hooks into the module manager's saving routine.
 * 
 * Available filters
 * =================
 * - mlp_pre_save_postdata - This filter is passed the postdata prior to creating blog interlinks.
 * - mlp-context-help - Is passed the content of the contextual help screen.
 * - mlp_language_codes - Is passed all the language codes used by Multilingual Press.
 * 
 * Changelog
 * =================
 * 
 * 1.0.3
 * - Code: Auto Updater Improvements
 * - Code: Fixed Feature Loader
 * - Removed link to blog posts on is_home()
 * - Removed static ?noredirect parameter
 * - Added modern greek as language
 * - Added private posts for translations
 * - Added parameter handling for mlp_show_linked_elements template function
 * - Added parameter show_current_blog on mlp_show_linked_elements template function
 * - Added show current blog at the MLP Widget 
 * - Added hook for checkbox "translate this post"
 * - Added hook to change the default meta box
 * - Added hook to change the link to the blog
 * - Changed admin_url into network_admin_url
 * - Redirect Feature: Added better check for session_start
 * - Redirect Feature: Added redirect on is_home()
 * - Redirect Feature: Added ?noredirect link with core plugin hook
 * - Redirect Feature: Added english as browser language
 * - Quicklink Feature: Added blog language to quicklink
 * - Dashboard Widget: Fixed "This post is translated" checkbox
 * - Advanced Translator: Removed default metabox when  feature is active
 * - Added Feature: Default Actions
 * - Autoupdate Feature: Removed autoupdate module from module list
 *  
 * 1.0.2
 * - Code: Fixed Auto Updater
 * - Version: Hopping due to some Auto Update Issues
 * 
 * 1.0.1
 * - Code: Fixed Wrong Encoding in different files
 * - Code: Fixed several warnings, notices and small bugs
 * - Code: Fixed Auto Updater
 * - Code: Fixed several Advanced Translator Bugs
 * - Code: Fixed Post Relationships in Blog Duplicate
 * 
 * 1.0
 * - Feature: Advanced Translator for Posts and Pages
 * - Feature: Support for Custom Post Types
 * - Feature: Dashboard Widget
 * - Feature: Duplicate Blogs
 * - Feature: Quick Load of new language packs
 * - Feature: Automatic browser redirection
 * - Feature: Systemwide Trash
 * - Feature: Individual backend language user settings
 * 
 * 0.9.1
 * - Using local logo 
 * 
 * 0.9
 * - Feature: Added Demo Module
 * - Feature: Added sort option to widget
 * - Feature: Added is_home() to our queries
 * - Feature: Added mlp_get_interlinked_permalinks
 * - Feature: Added mlp_get_blog_language
 * - Code: Fixed Widget
 * - Code: Fixed several notices
 * - Code: Fixed Buffer Bug in Settingspage
 * - Code: Fixed Notices on refresh of the blog settings
 * - Code: Fixed Column Content
 * - Code: Fixed Relationship Error Notice
 * - Code: Better Error Message for blog relationships
 * - Code: Constant Language Strings
 * - Code: Added Korean Language
 * 
 * 0.8.2
 * - PHP 5.2 Fix
 * 
 * 0.8.1
 * - Adding Plugin Settingspage, Code Cleanup
 * - added check that prevents the use of this plugin in a not-setted blog
 * - Codexified several stuff
 * - Fixed Missing Table from external Module
 * - Added filter for the list, fixed Style
 * - Fixed several notices
 * - fixed language key output
 * 
 * 0.8
 * - Codexified
 * - Renamed the files
 * - changed textdomain
 * - fixed fi_FI language pack
 * - fixed several widget bugs ( #10, #13, #18, #22 )
 * - Documentation
 * - Only load the Widget CSS when widget is used
 * - added a check box to the editing view asking whether you want to create the drafts to other languages
 * - Translation is availeable for drafts
 * - Fixed up JS
 * - Blog Checkup for invalid data
 * 
 * 0.7.5a
 * - Display an admin notice if the plugin was not activated on multisite
 * - Set the parent page if this page was also handled by the plugin [Issue 2](https://github.com/inpsyde/multilingual-press/issues/2)
 * - Fix a problem that a new multisite cannot set related blogs
 * - Change filter [Issue 12](https://github.com/inpsyde/multilingual-press/issues/12)
 * - Widget bugfix [Issue 12](https://github.com/inpsyde/multilingual-press/issues/12)
 * - Smaller source via use function selected() [Issue 12](https://github.com/inpsyde/multilingual-press/issues/12)
 * - Static value for register widget [Issue 12](https://github.com/inpsyde/multilingual-press/issues/12)
 * - Update Wiki for wrapper functions [Wiki on Repo](https://github.com/inpsyde/multilingual-press/wiki)
 * - Add new pages on [Wiki on Repo](https://github.com/inpsyde/multilingual-press/wiki) for Filter- and Action Hooks inside the plugin
 * - Fix bug, if you kill data on an blog for dont interlinked with other blogs
 * 
 * 0.7.4a
 * - Exported the basic UI and userinput handling functionality into "default-module" class
 * - By default post types other than post and page are excluded
 * - Incorrect flags for some languages [Issue 7](https://github.com/inpsyde/multilingual-press/issues/7)
 *
 * 0.7.3a
 * - Exported helper functions into own class
 * - Code documentation
 *
 * 0.7.2a
 * - Updated language codes
 */

if ( ! class_exists( 'Multilingual_Press' ) ) {
	
	// Enqueue plugin
	if ( function_exists( 'add_filter' ) ) {
	
		// Kick-Off
		add_filter( 'plugins_loaded', array( 'Multilingual_Press', 'get_object' ) );
	
		// Upon activation
		register_activation_hook( __FILE__, array( 'Multilingual_Press', 'install_plugin' ) );
	
		// Upon deactivation
		register_deactivation_hook( __FILE__, array( 'Multilingual_Press', 'remove_plugin' ) );
	}

	class Multilingual_Press {
	
		/**
		 * The class object
		 *
		 * @static
		 * @since  0.1
		 * @var    string
		 */
		static protected $class_object = NULL;

		/**
		 * The linked elements table
		 *
		 * @since  0.1
		 * @var    string
		 */
		protected $link_table = '';

		/**
		 * source id of the current element 
		 *
		 * @static
		 * @since  0.1
		 * @var    string
		 */
		private $source_id = 0;

		/**
		 * source id of the current blog
		 *
		 * @since  0.1
		 * @var    string
		 */
		private $source_blog_id = 0;

		/**
		 * source type of the current content
		 *
		 * @since  0.2
		 * @var    string
		 */
		private $source_type = '';

		/**
		 * Array containing loaded modules
		 *
		 * @since  0.5
		 * @var    array
		 */
		protected $loaded_modules = array( );

		/**
		 * array containing language codes and names
		 *
		 * @protected
		 * @since  0.5
		 * @var    array
		 */
		protected $lang_codes;
		
		/**
		 * The plugins textdomain
		 *
		 * @static
		 * @since 0.8
		 * @var string
		 */
		public static $textdomain = '';
		
		/**
		 * The plugins textdomain path
		 *
		 * @static
		 * @since 0.8
		 * @var string
		 */
		public static $textdomainpath = '';
		
		/**
		 * The plugins Name
		 *
		 * @static
		 * @since 0.4
		 * @var string
		 */
		public static $plugin_name = '';
		
		/**
		 * The plugins plugin_base
		 *
		 * @static
		 * @since 0.3
		 * @var string
		 */
		public static $plugin_base_name = '';
		
		/**
		 * The plugins URL
		 *
		 * @static
		 * @since 0.4
		 * @var string
		 */
		public static $plugin_url = '';
		
		/**
		 * Used in save_post() to prevent recursion
		 *
		 * @static
		 * @since	0.8
		 * @var		NULL | integer
		 */
		private static $source_blog = NULL;

		/**
		 * to load the object and get the current state 
		 *
		 * @access  public
		 * @since   0.1
		 * @return  $class_object
		 */
		public function get_object() {
			if ( NULL == self::$class_object )
				self::$class_object = new self;
			return self::$class_object;
		}

		/**
		 * init function to register all used hooks,
		 * load class files and set parameters
		 * such as the database table 
		 *
		 * @access  public
		 * @since   0.1
		 * @uses	add_filter, get_site_option, is_multisite, is_super_admin,
		 * 			do_action, apply_filters
		 * @global	$wpdb | WordPress Database Wrapper
		 * @global	$pagenow | Current Page Wrapper
		 * @return  void
		 */
		public function __construct() {
			global $pagenow;
			
			// This check prevents using this plugin not in a multisite
			if ( function_exists( 'is_multisite' ) && ! is_multisite() && is_super_admin() ) {
				add_filter( 'admin_notices',  array( $this, 'error_msg_no_multisite' ) );
				return;
			}
			
			// This check prevents the use of this plugin in a not-setted blog
			if ( 'admin-post.php' != $pagenow && 'admin-ajax.php' != $pagenow && ! is_network_admin() && ! array_key_exists( get_current_blog_id(), get_site_option( 'inpsyde_multilingual', array() ) ) )
				return;
			
			// The Plugins Basename
			self::$plugin_base_name = plugin_basename( __FILE__ );
				
			// The Plugins URL
			self::$plugin_url = $this->get_plugin_header( 'PluginURI' );
				
			// The Plugins Name
			self::$plugin_name = $this->get_plugin_header( 'Name' );
				
			// Textdomain
			self::$textdomain = $this->get_textdomain();
			// Textdomain Path
			self::$textdomainpath = $this->get_domain_path();
			
			global $wpdb;

			// Show database errors
			// (only for development)
			$wpdb->show_errors();

			// Set linked elements table
			$this->link_table = $wpdb->base_prefix . 'multilingual_linked';

			// Load classes
			$this->include_files();

			// Kick-Off Init
			do_action( 'inpsyde_mlp_init' );

			// Hooks and filters
			add_filter( 'init', array( $this, 'load_plugin_textdomain' ) );

			// Enqueue scripts
			add_filter( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_filter( 'wp_enqueue_scripts', array( $this, 'wp_styles' ) );

			// AJAX hooks for the tab form and the meta boxes
			add_filter( 'wp_ajax_tab_form', array( $this, 'draw_blog_settings_form' ) );
			add_filter( 'wp_ajax_save_multilang_settings', array( $this, 'update_blog_settings' ) );
			add_filter( 'wp_ajax_get_metabox_content', array( $this, 'ajax_get_metabox_content' ) );

			// Context help of the plugin
			add_filter( 'contextual_help', array( $this, 'context_help' ), 10, 3 );

			// Cleanup upon blog delete
			add_filter( 'delete_blog', array( $this, 'delete_blog' ), 10, 2 );
			
			// Checkup blog cleanup
			add_filter( 'admin_head', array( $this, 'checkup_blog_message' ) );
			add_filter( 'wp_ajax_checkup_blogs', array( $this, 'checkup_blog' ) );
			
			// Check for errors
			add_filter( 'all_admin_notices', array( $this, 'check_for_user_errors_admin_notice' ) );
			if ( TRUE == $this->check_for_user_errors() )
				return;
			
			// Load modules
			$this->load_modules();
			
			// Does another plugin offer its own save method?
			$external_save_method = apply_filters( 'inpsyde_multilingualpress_external_save_method', FALSE );
			if ( ! $external_save_method )
				add_filter( 'save_post', array( $this, 'save_post' ) );
			
			// Add the meta box
			$get_metabox_handler = apply_filters( 'inpsyde_multilingualpress_get_metabox_handler', array( $this, 'add_meta_boxes' ) );
			add_filter( 'add_meta_boxes', $get_metabox_handler );
		}
		
		/**
		 * Get a value of the plugin header
		 *
		 * @since	0.8
		 * @uses	get_plugin_data, ABSPATH
		 * @param	string $value
		 * @return	string The plugin header value
		 */
		protected function get_plugin_header( $value = 'TextDomain' ) {
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_value = $plugin_data[ $value ];
		
			return $plugin_value;
		}
		
		/**
		 * Get the Textdomain
		 *
		 * @since	0.8
		 * @return	The plugins textdomain
		 */
		public function get_textdomain() {
			return $this->get_plugin_header( 'TextDomain' );
		}
		
		/**
		 * Get the Textdomain Path where the language files are located
		 *
		 * @since	0.8
		 * @return	The plugins textdomain path
		 */
		public function get_domain_path() {
			return $this->get_plugin_header( 'DomainPath' );
		}
		
		/**
		 * Load the localization
		 *
		 * @since 0.1
		 * @uses load_plugin_textdomain, plugin_basename
		 * @return void
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( $this->get_textdomain(), FALSE, dirname( plugin_basename( __FILE__ ) ) . $this->get_domain_path() );
		}

		/**
		 * Include class files when needed
		 * 
		 * @access  public
		 * @since   0.1
		 * @uses	is_admin, add_filter
		 * @global	$pagenow | current page identifier
		 * @return  void
		 */
		private function include_files() {

			global $pagenow;

			// Include helper functions
			require_once( 'inc/class-Mlp_Helpers.php' );

			// Include widget
			require_once( 'inc/class-Mlp_Widget.php' );
			
			// Include default module
			require_once( 'inc/class-Mlp_Default_Module.php' );

			// Page specific admin files
			$hook = array( 'sites.php' );
			if ( is_admin() && in_array( $pagenow, $hook ) ) {

				require_once( 'inc/class-Mlp_Custom_Columns.php' );
				add_filter( 'init', array( 'Mlp_Custom_Columns', 'init' ) );
			}

			// Global admin files
			if ( is_admin() ) {

				// Include settings page _after_ modules are loaded
				require_once( 'inc/class-Mlp_Settingspage.php' );
				add_filter( 'plugins_loaded', array( 'Mlp_Settingspage', 'get_object' ), 8 );
			}
		}

		/**
		 * Load frontend CSS if the widget is active
		 * 
		 * @access  public
		 * @since	0.5.3b
		 * @uses	wp_enqueue_style, plugins_url
		 * @return  void
		 */
		public function wp_styles() {
			
			if ( is_active_widget( false, false, 'mlp_widget' ) )
				wp_enqueue_style( 'mlp-frontend-css', plugins_url( 'css/frontend.css', __FILE__ ) );
		}

		/**
		 * Load admin javascript and CSS
		 *
		 * @access  public
		 * @since	0.5.3b
		 * @uses	wp_enqueue_script, plugins_url, wp_localize_script, wp_enqueue_style
		 * @global	$pagenow | current page identifier
		 * @return  void
		 */
		public function admin_scripts() {

			global $pagenow;

			// We only need our Scripts on our pages
			$pages = array(
				'site-info.php',
				'site-users.php',
				'site-themes.php',
				'site-settings.php',
				'settings.php'
			);

			if ( in_array( $pagenow, $pages ) ) {
				wp_enqueue_script( 'mlp-js', plugins_url( 'js/', __FILE__ ) . 'multilingual_press.js' );
				wp_localize_script( 'mlp-js', 'mlp_loc', $this->localize_script() );
				wp_enqueue_style( 'mlp-admin-css', plugins_url( 'css/admin.css', __FILE__ ) );
			}
		}

		/**
		 * Make localized strings available in javascript
		 *
		 * @access  public
		 * @since	0.1
		 * @uses	wp_create_nonce
		 * @global	$pagenow | current page identifier
		 * @return	type $loc | Array containing localized strings
		 */
		public function localize_script() {

			if ( isset( $_GET[ 'id' ] ) )
				$blog_id = $_GET[ 'id' ];
			else 
				$blog_id = 0;
			
			$loc = array(
				'tab_label'						=> __( 'Multilingual Press', $this->get_textdomain() ),
				'blog_id'						=> intval( $blog_id ),
				'ajax_tab_nonce'				=> wp_create_nonce( 'mlp_tab_nonce' ),
				'ajax_form_nonce'				=> wp_create_nonce( 'mlp_form_nonce' ),
				'ajax_select_nonce'				=> wp_create_nonce( 'mlp_select_nonce' ),
				'ajax_switch_language_nonce'	=> wp_create_nonce( 'mlp_switch_language_nonce' ),
				'ajax_check_single_nonce'		=> wp_create_nonce( 'mlp_check_single_nonce' )
			);

			return $loc;
		}

		/**
		 * set the source id for starting
		 *
		 * @access  public
		 * @since   0.1
		 * @uses	get_current_blog_id
		 * @param   int $sourceid ID of the selected element
		 * @param   int $source_blog ID of the selected blog
		 * @param   string $source_type type of the selected element
		 * @return  void
		 */
		public function set_source_id( $sourceid, $source_blog = 0, $source_type = '' ) {

			$this->source_id = $sourceid;
			if ( 0 == $source_blog )
				$source_blog = get_current_blog_id();
			
			$this->source_blog_id = $source_blog;
			$this->source_type = $source_type;

			// set the current element as the first linked element
			$this->set_linked_element( $sourceid, $sourceid, $source_blog, $source_type );
		}

		/**
		 * set the source id of the element
		 *
		 * @access  public
		 * @since   0.1
		 * @uses	get_current_blog_id
		 * @param   int $element_id ID of the selected element
		 * @param   int $sourceid ID of the selected element
		 * @param   int $source_blog ID of the selected blog
		 * @param   string $type type of the selected element
		 * @param   int $blog_id ID of the selected blog
		 * @global	$wpdb | WordPress Database Wrapper
		 * @return  void
		 */
		public function set_linked_element( $element_id, $source_id = 0, $source_blog_id = 0, $type = '', $blog_id = 0 ) {

			global $wpdb;

			if ( 0 == $blog_id )
				$blog_id = get_current_blog_id();
			
			if ( 0 == $source_id )
				$source_id = $this->source_id;
			
			if ( 0 == $source_blog_id )
				$source_blog_id = $this->source_blog_id;
			
			if ( ! $this->link_table )
				$this->link_table = $wpdb->base_prefix . 'multilingual_linked';
			
			$wpdb->insert( $this->link_table, array( 'ml_source_blogid' => $source_blog_id, 'ml_source_elementid' => $source_id, 'ml_blogid' => $blog_id, 'ml_elementid' => $element_id, 'ml_type' => $type ) );
		}

		/**
		 * create the element on other blogs and link them
		 *
		 * @access  public
		 * @since   0.1
		 * @uses	get_post_status, get_post, get_post_thumbnail_id, wp_upload_dir, get_post_meta, 
		 *			pathinfo, get_blog_list, get_current_blog_id, switch_to_blog, wp_insert_post, 
		 *			wp_unique_filename, wp_check_filetype, is_wp_error, wp_update_attachment_metadata, 
		 *			wp_generate_attachment_metadata, update_post_meta, restore_current_blog
		 * @param   $post_id ID of the post
		 * @return  void
		 */
		public function save_post( $post_id ) {

			// We're only interested in published posts at this time
			$post_status = get_post_status( $post_id );
			if ( 'publish' !== $post_status && 'draft' !== $post_status && 'private' !== $post_status )
				return;

			// Avoid recursion:
			// wp_insert_post() invokes the save_post hook, so we have to make sure
			// the loop below is only entered once per save action. Therefore we save
			// the source_blog in a static class variable. If it is already set we
			// know the loop has already been entered and we can exit the save action.
			if ( NULL === self::$source_blog )
				self::$source_blog = get_current_blog_id();
			else
				return;
			
			// If checkbox is not checked, return
			if ( ! isset( $_POST[ 'translate_this_post' ] ) )
				return;
			
			// Get the post
			$postdata = get_post( $post_id, ARRAY_A );
			
			// Apply a filter here so modules can play around
			// with the postdata before it is processed.
			$postdata = apply_filters( 'mlp_pre_save_postdata', $postdata );
			
			// If there is no filter hooked into this saving method, then we
			// will exclude all post types other that "post" and "page".
			// @TODO: improve this logic :/
			// @TODO: create a whitelist for allowed post types, incl. apply_filters() ?		   
			if ( ! has_filter( 'mlp_pre_save_postdata' ) ) 
				if ( 'post' != $postdata[ 'post_type'] && 'page' != $postdata[ 'post_type'] ) 
					return;
			
			// When the filter returns FALSE, we'll stop here
			if ( FALSE == $postdata || ! is_array( $postdata ) )
				return;
								
			$linked = mlp_get_linked_elements( $post_id );

			// We already linked this element?
			if ( 0 !== count( $linked ) )
				return;

			$this->set_source_id( $post_id );
			$file = '';
			
			// Check for thumbnail
			if ( current_theme_supports( 'post-thumbnails' ) ) {
				$thumb_id = get_post_thumbnail_id( $post_id );
				if ( 0 < $thumb_id ) {
					$path = wp_upload_dir();
					$file = get_post_meta( $thumb_id, '_wp_attached_file', true );
					$fileinfo = pathinfo( $file );
				}
			}
			
			// Create the post array
			$newpost = array(
				'post_title'	=> $postdata[ 'post_title' ],
				'post_content'	=> $postdata[ 'post_content' ],
				'post_status'	=> 'draft',
				'post_author'	=> $postdata[ 'post_author' ],
				'post_excerpt'	=> $postdata[ 'post_excerpt' ],
				'post_date'		=> $postdata[ 'post_date' ],
				'post_type'		=> $postdata[ 'post_type' ]
			);
			
			$blogs = mlp_get_available_languages();

			if ( ! ( 0 < count( $blogs ) ) )
				return;

			// Load Page Parents			
			$parent_elements = array( );
			if ( 'page' == $postdata[ 'post_type' ] && 0 < $postdata[ 'post_parent' ] )
				$parent_elements = mlp_get_linked_elements( $postdata[ 'post_parent' ] );

			// Create a copy of the item for every related blog
			foreach ( $blogs as $blogid => $blogname ) {

				if ( $blogid != self::$source_blog ) {
					
					switch_to_blog( $blogid );

					// Set the linked parent page 
					if ( 0  < count( $parent_elements ) && 0 < $parent_elements[ $blogid ] )
						$newpost[ 'post_parent'] = $parent_elements[ $blogid ];
					
					// Insert remote blog post
					$remote_post_id = wp_insert_post( $newpost );
					
					if ( '' != $file ) { // thumbfile exists
						include_once ( ABSPATH . 'wp-admin/includes/image.php' ); //including the attachment function
						if ( 0 < count( $fileinfo ) ) {
							
							$filedir = wp_upload_dir();
							$filename = wp_unique_filename( $filedir[ 'path' ], $fileinfo[ 'basename' ] );
							$copy = copy( $path[ 'basedir' ] . '/' . $file, $filedir[ 'path' ] . '/' . $filename );
							
							if ( $copy ) {
								unset( $postdata[ 'ID' ] );
								$wp_filetype = wp_check_filetype( $filedir[ 'url' ] . '/' . $filename ); //get the file type
								$attachment = array(
									'post_mime_type'	=> $wp_filetype[ 'type' ],
									'guid'				=> $filedir[ 'url' ] . '/' . $filename,
									'post_parent'		=> $remote_post_id,
									'post_title'		=> '',
									'post_excerpt'		=> '',
									'post_author'		=> $postdata[ 'post_author' ],
									'post_content'		=> '',
								);
								
								//insert the image
								$attach_id = wp_insert_attachment( $attachment, $filedir[ 'path' ] . '/' . $filename );
								if ( ! is_wp_error( $attach_id ) ) {
									wp_update_attachment_metadata(
										$attach_id, wp_generate_attachment_metadata( $attach_id, $filedir[ 'path' ] . '/' . $filename )
									);
									set_post_thumbnail( $remote_post_id, $attach_id );
								} // update the image data
							}
						}
					}
					$this->set_linked_element( $remote_post_id );
					restore_current_blog();
				}
			}
		}

		/**
		 * add the metaboxes on posts and pages
		 *
		 * @access  public
		 * @since   0.1
		 * @uses	add_meta_box
		 * @global	$post | the current post
		 * @return  void
		 */
		public function add_meta_boxes() {
			global $post;
			
			// Do we have linked elements?
			$linked = mlp_get_linked_elements( $post->ID );
			if ( ! $linked ) {
				add_meta_box( 'multilingual_press_translate', __( 'Multilingual Press: Translate Post', $this->get_textdomain() ), array( $this, 'display_meta_box_translate' ), 'post', 'normal', 'high' );
				add_meta_box( 'multilingual_press_translate', __( 'Multilingual Press: Translate Page', $this->get_textdomain() ), array( $this, 'display_meta_box_translate' ), 'page', 'normal', 'high' );
				return;
			}
			
			// Register metaboxes
			add_meta_box( 'multilingual_press_link', __( 'Multilingual Press: Linked posts', $this->get_textdomain() ), array( $this, 'display_meta_box' ), 'post', 'normal', 'high' );
			add_meta_box( 'multilingual_press_link', __( 'Multilingual Press: Linked pages', $this->get_textdomain() ), array( $this, 'display_meta_box' ), 'page', 'normal', 'high' );
		}

		/**
		 * show the metabox
		 *
		 * @access  public
		 * @since   0.1
		 * @uses	get_site_option, get_current_blog_id
		 * @param   $post post object  
		 * @return  void
		 */
		public function display_meta_box( $post ) {

			$linked = mlp_get_linked_elements( $post->ID );
			if ( 0 < count( $linked ) ) { // post is a linked post
				$languages = mlp_get_available_languages();
				if ( 0 < count( $languages ) ) {
					?>
					<select name="multilingual_press" id="multilingual_press">
						<option><?php _e( 'choose preview language', $this->get_textdomain() ); ?></option>
					<?php
					foreach ( $languages as $language_blogid => $language_name ) {
						if ( $language_blogid != get_current_blog_id() ) {
							?>
							<option value="<?php echo $language_blogid; ?>"><?php echo $language_name;?></option>
							<?php 
						}
					}
					?>
					</select>
					<div id="multilingual_press_content"></div>
					
					<script type="text/javascript">
						//<![CDATA[
						jQuery( document ).ready( function( $ ) {
							$( '#multilingual_press' ).change( function() {

								blogid = '';
								$( '#multilingual_press option:selected' ).each( function () {
									blogid += $( this ).attr( 'value' );
								} );
								
								$.post( ajaxurl,
									{
										action: 'get_metabox_content',
										blogid: blogid,
										post: <?php echo $post->ID; ?>
									},
									function( returned_data ) {
										if ( '' != returned_data ) {
											$( '#multilingual_press_content' ).html( returned_data );
										}
									}
								);
							} );
						} );
						//]]>
					</script>
					<?php
				}
			}
		}
		
		/**
		 * show the metabox
		 *
		 * @access  public
		 * @since   0.2
		 * @param   $post post object
		 * @return  void
		 */
		public function display_meta_box_translate( $post ) {
			
			?>
			<p>
				<input type="checkbox" id="translate_this_post" name="translate_this_post" <?php checked( TRUE, apply_filters( 'inpsyde_multilingualpress_translate_this_post_checkbox', FALSE ) ); ?> />
				<label for="translate_this_post"><?php _e( 'Translate this post', $this->get_textdomain() ); ?></label>
			</p>
			<?php
		}

		/**
		 * Load the Content for the Metabox 
		 *
		 * @access  public
		 * @since   0.1
		 * @uses	switch_to_blog, get_post, get_the_title, get_post_status, admin_url, apply_filters, restore_current_blog 
		 * @return  void
		 */
		public function ajax_get_metabox_content() {

			$has_linked = FALSE;

			// Get elements linked to this item
			$linked = mlp_get_linked_elements( esc_attr( $_POST[ 'post' ] ) );

			// No elements available? Au revoir.
			if ( ! $linked )
				die( __( 'No post available', $this->get_textdomain() ) );

			// Walk through elements
			foreach ( $linked as $linked_blog => $linked_post ) {

				// Not concerning this blog?
				if ( intval( $_POST[ 'blogid' ] ) !== $linked_blog )
					continue;

				// Switch to appropriate blog to
				// have the helper functions at hand
				switch_to_blog( $linked_blog );
				
				// Get post
				$remote_post = get_post( $linked_post );

				// Create output
				if ( NULL != $remote_post ) {
					$has_linked = TRUE;
					echo '<p>' . __( 'Status:', $this->get_textdomain() ) . '&nbsp;<b>' . ucfirst( get_post_status( $linked_post ) ) . '</b>&nbsp;|&nbsp;' . __( 'Published on:', $this->get_textdomain() ) . '<b>&nbsp;' . get_post_time( get_option( 'date_format' ), FALSE, $linked_post ) . '</b></p>';
					echo '<h2 id="headline">' . get_the_title( $linked_post ) . '</h2>';
					echo '<textarea id="content" class="large-text cols="80" rows="10" disabled="disabled">' . apply_filters( 'the_content', $remote_post->post_content ) . '</textarea>';
					echo '<p><a href="' . admin_url( 'post.php?post=' . $linked_post . '&action=edit' ) . '">' . __( 'Edit', $this->get_textdomain() ) . '</a></p>';
				}
				restore_current_blog();
			}

			// No posts available?
			if ( FALSE === $has_linked )
				die( '<p>' . __( 'No post available', $this->get_textdomain() ) . '</p>' );

			die();
		}

		/**
		 * This is the basic blog settings page.
		 * Modules can hook in their form fields here. 
		 *
		 * @access  public
		 * @since   0.1
		 * @uses	check_ajax_referer, wp_die, get_blogaddress_by_id, _e, screen_icon
		 * 			do_action, submit_button
		 * @param   $id ID of the blog
		 * @return  void
		 */
		public function draw_blog_settings_form() {

			// check nonce
			check_ajax_referer( 'mlp_tab_nonce', 'tab_nonce' );

			// Get blog id
			$current_blog_id = isset( $_REQUEST[ 'id' ] ) ? intval( $_REQUEST[ 'id' ] ) : 0;

			if ( ! $current_blog_id )
				wp_die( __( 'Invalid site ID.' ) );

			// Use a linked page title
			$site_url_no_http = preg_replace( '#^http(s)?://#', '', get_blogaddress_by_id( $current_blog_id ) );
			$title_site_url_linked = sprintf( __( 'Edit Site: <a href="%1$s">%2$s</a>' ), get_blogaddress_by_id( $current_blog_id ), $site_url_no_http );
			
			screen_icon( 'ms-admin' );
			?>
			<h2 id="edit-site"><?php echo $title_site_url_linked; ?></h2>
			
			<h3 class="nav-tab-wrapper">
				<a class="nav-tab" href="site-info.php?id=<?php echo $current_blog_id; ?>"><?php _e( 'Info' ); ?></a>
				<a class="nav-tab" href="site-users.php?id=<?php echo $current_blog_id; ?>"><?php _e( 'Users' ); ?></a>
				<a class="nav-tab" href="site-themes.php?id=<?php echo $current_blog_id; ?>"><?php _e( 'Themes' ); ?></a>
				<a class="nav-tab" href="site-settings.php?id=<?php echo $current_blog_id; ?>"><?php _e( 'Settings' ); ?></a>
				<a href="#" class="nav-tab nav-tab-active" id="mlp_settings_tab"><?php _e( 'Multilingual Press', $this->get_textdomain() ); ?></a>
			</h3>

			<form action="" method="post" id="multilingualpress_settings">
				<!-- Modules can hook their form fields here -->
				<?php do_action( 'mlp_blogs_add_fields', $current_blog_id ); ?>

				<!-- Secondary fields hook -->
				<?php do_action( 'mlp_blogs_add_fields_secondary', $current_blog_id ); ?>

				<?php submit_button(); ?>
			</form>
			<?php
			die;
		}

		/**
		 * @todo	PHP Doc
		 */
		private function parse_serialized_postdata( $data ) {

			parse_str( $data, $parsed_data );

			return $parsed_data;
		}

		/**
		 * Make available a hook 
		 * to save blog settings
		 *
		 * @access	public
		 * @since	0.1
		 * @uses	check_ajax_referer, do_action, _e
		 * @return	void
		 */
		public function update_blog_settings() {

			// check nonce
			check_ajax_referer( 'mlp_form_nonce', 'form_nonce' );

			// Modules can hook their saving routine here.
			// They will be passed the user input a
			// a function parameter
			$data = $this->parse_serialized_postdata( urldecode( $_POST[ 'serialized_data' ] ) );

			do_action( 'mlp_blogs_save_fields', $data );
			?>

			<div class="updated"><p><?php _e( 'Blog settings saved', $this->get_textdomain() ); ?></p></div>

			<?php
			die;
		}


		/**
		 * create the element links database table  
		 *
		 * @access	public
		 * @since	0.1
		 * @uses	dbDelta
		 * @global	$wpdb | WordPress Database Wrapper
		 * @return	void
		 */
		public function install_plugin() {

			global $wpdb;

			// The sql executed to create the elements table
			$sql = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->base_prefix . 'multilingual_linked (
						`ml_id` INT NOT NULL AUTO_INCREMENT ,
						`ml_source_blogid` int(11) NOT NULL,
						`ml_source_elementid` int(11) NOT NULL,
						`ml_blogid` INT NOT NULL,
						`ml_elementid` INT NOT NULL,
						`ml_type` varchar(20) CHARACTER SET utf8 NOT NULL,
						PRIMARY KEY ( `ml_id` ) , INDEX ( `ml_blogid` , `ml_elementid` )
					);';

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}

		/**
		 * Execute this function
		 * upon plugin deactivation
		 * 
		 * @since	0.1
		 * @return	type 
		 */
		public function remove_plugin() {
			
			return;
		}

		/**
		 * Returns array of modules, also
		 * saves them in the class var "loaded_modules".
		 * Scans the plugins' subfolder "/features"
		 *
		 * @access	public
		 * @since	0.1
		 * @return	array Files to include
		 */
		public function load_modules() {

			// Get dir
			$handle = @opendir( dirname( __FILE__ ) . '/features' );
			if ( ! $handle )
				return;

			// Loop through directory files
			while ( FALSE !== ( $plugin = readdir( $handle ) ) ) {
				
				// Is this file for us?
				if ( '.php' == substr( $plugin, -4 ) ) {

					// Save in class var
					$this->loaded_modules[ substr( $plugin, 0, -4 ) ] = TRUE;

					// Include module file
					require_once dirname( __FILE__ ) . '/features/' . $plugin;
				}
			}
			closedir( $handle );
		}

		/**
		 * Check state of module to determine
		 * aktivation/deactivation
		 * 
		 * @access	protected
		 * @since	0.3b
		 * @param	string $module | module handler
		 * @uses	get_site_option, update_site_option, 
		 * @return	array $state | module state  
		 */
		protected function get_module_state( $module ) {

			// Get the current states
			$state = get_site_option( 'state_modules', FALSE );

			// New module?
			if ( ! ( isset( $state[ $module[ 'slug' ] ] ) ) ) {
				$module[ 'state' ] = 'on';
				$state[ $module[ 'slug' ] ] = $module;

				update_site_option( 'state_modules', $state );
				return $state[ $module[ 'slug' ] ][ 'state' ];
			}
			else if ( 'off' == $state[ $module[ 'slug' ] ][ 'state' ] ) {
				// Deaktivated module?
				return $state[ $module[ 'slug' ] ][ 'state' ];
			}
		}

		/**
		 * Delete removed blogs from site_option 'inpsyde_multilingual'
		 * and cleanup linked elements table
		 * 
		 * @param	int $blog_id 
		 * @since	0.3
		 * @uses	get_site_option, update_site_option
		 * @global	$wpdb | WordPress Database Wrapper
		 * @return	void
		 */
		public function delete_blog( $blog_id ) {

			global $wpdb;
			
			$current_blog_id = $blog_id;
			
			// Update Blog Relationships
			// Get blogs related to the current blog
			$all_blogs = get_site_option( 'inpsyde_multilingual' );
			
			if ( ! $all_blogs )
				$all_blogs = array( );
				
			// The user defined new relationships for this blog. We add it's own ID
			// for internal purposes
			$data[ 'related_blogs' ][] = $current_blog_id;
			$new_rel = $data[ 'related_blogs' ];
				
			// Loop through related blogs
			foreach ( $all_blogs as $blog_id => $blog_data ) {
				
				if ( $current_blog_id == $blog_id )
					continue;
					
				// 1. Get related blogs' current relationships
				$current_rel = get_blog_option( $blog_id, 'inpsyde_multilingual_blog_relationship' );
				
				if ( ! is_array( $current_rel ) )
					$current_rel = array();
					
				// 2. Compare old to new relationships
				// Get the key of the current blog in the relationships array of the looped blog
				$key = array_search( $current_blog_id, $current_rel );
				
				// These blogs should not be connected. Delete
				// possibly existing connection
				if ( FALSE !== $key && isset( $current_rel[ $key ] ) )
					unset( $current_rel[ $key ] );
				
				// $current_rel should be our relationships array for the currently looped blog
				update_blog_option( $blog_id, 'inpsyde_multilingual_blog_relationship', $current_rel );
			}
			
			// Update site_option
			$blogs = get_site_option( 'inpsyde_multilingual' );
			if ( array_key_exists( $current_blog_id, $blogs ) )
				unset( $blogs[ $current_blog_id ] );
			
			update_site_option( 'inpsyde_multilingual', $blogs );
			
			// Cleanup linked elements table
			$error = $wpdb->query( $wpdb->prepare( "DELETE FROM {$this->link_table} WHERE ml_source_blogid = %d OR ml_blogid = %d", $blog_id, $blog_id ) );
		}

		/**
		 * Contextual help
		 *
		 * @since	0.5.6b
		 * @param	string $contextual_help
		 * @param	type $screen_id
		 * @param	type $screen
		 * @uses	get_current_screen, apply_filters
		 * @return	void
		 */
		public function context_help( $contextual_help, $screen_id, $screen ) {

			$screen = get_current_screen();

			$sites = array(
				'site-info-network',
				'site-users-network',
				'site-themes-network',
				'site-settings-network'
			);

			if ( in_array( $screen_id, $sites ) ) {

				$content  = '<p><strong>' . __( 'Choose blog language', $this->get_textdomain() ) . '</strong>';
				$content .= __( ' - Set the language and flag. You can use this to distinguish blogs and display them in the frontend using the Multilingual Press widget.', $this->get_textdomain() ) . '</p>';
				$content .= '<p><strong>' . __( 'Alternative language title', $this->get_textdomain() ) . '</strong>';
				$content .= __( ' - Alternative language title will be used mainly in the Multilingual Press frontend widget. You can use it to determine a site title other than the default one (i.e. "My Swedish Site")', $this->get_textdomain() ) . '</p>';
				$content .= '<p><strong>' . __( 'Blog flag image URL', $this->get_textdomain() ) . '</strong>';
				$content .= __( ' - Multilingual Press uses a default flag image, you can define a custom one here.', $this->get_textdomain() ) . '</p>';
				$content .= '<p><strong>' . __( 'Multilingual Blog Relationship', $this->get_textdomain() ) . '</strong>';
				$content .= __( ' - Determine which blogs will be interlinked. If you create a post or page, they will be automaticaly duplicated into each interlinked blog.', $this->get_textdomain() ) . '</p>';

				$content = apply_filters( 'mlp-context-help', $content );

				$screen->add_help_tab( array(
					'id'		=> 'multilingualpress-help',
					'title'		=> __( 'Multilingual Press', $this->get_textdomain() ),
					'content'	=> $content
				) );
			}
		}

		/**
		 * Display an Admin Notice if multisite is not active 
		 * 
		 * @since	0.7.5a
		 * @uses	_e
		 * @return	void
		*/
		public function error_msg_no_multisite() {
			?>
			<div class="error">
				<p>
					<?php _e( 'Multilingual Press only works in a multisite installation. See how to install a multisite network:', $this->get_textdomain() ); ?>
					<a href="http://codex.wordpress.org/Create_A_Network" title="<?php _e( 'WordPress Codex: Create a network', $this->get_textdomain() ); ?>"><?php _e( 'WordPress Codex: Create a network', $this->get_textdomain() ); ?></a>
				</p>
			</div><?php
		}
		
	/**
		 * returns an error-nag with an ajax-link for the blog cleanup
		 * if there is a problem
		 * 
		 * @access	public
		 * @since	0.8
		 * @uses	get_site_option, is_super_admin, _e
		 * @return	void
		 */
		public function checkup_blog_message() {
			
			$is_checkup_message = get_site_option( 'multilingual_press_check_db', FALSE );
			if ( $is_checkup_message && is_super_admin() ) {
				?>
				<div class="error" id="multilingual_press_checkup"><p><?php _e( 'We found invalid Multilingual Press Data in your Blogsystem. <a href="#" id="multilingual_press_checkup_link">Please do a checkup by clicking here</a>', $this->get_textdomain() ); ?></p></div>
				<?php
			}
		}
		
		/**
		 * Checks the blog for invalid data
		 *
		 * @access	public
		 * @since	0.8
		 * @uses	get_site_option, is_super_admin, _e, delete_site_option
		 * @return	void
		 */
		public function checkup_blog() {
			
			// Message
			?>
			<p><?php _e( 'Cleanup runs. Please stand by.', $this->get_textdomain() ); ?></p>
			<?php
			
			// Update Blog Relationships
			// Get blogs related to the current blog
			$all_blogs = get_site_option( 'inpsyde_multilingual' );
			
			if ( ! $all_blogs )
				$all_blogs = array();
			
			$current_blog_id = get_current_blog_id();
			$cleanup_blogs = array();
			
			// The user defined new relationships for this blog. We add it's own ID
			// for internal purposes
			$data[ 'related_blogs' ][] = $current_blog_id;
			$new_rel = $data[ 'related_blogs' ];
			
			// Loop through related blogs
			foreach ( $all_blogs as $blog_id => $blog_data ) {
				// Does this blog exists?
				$blog_details = get_blog_details( $blog_id );
				if ( empty( $blog_details ) )
					$cleanup_blogs[] = $blog_id;
			}
			
			// We found blogs so we have to check em up
			if ( 0 < count( $cleanup_blogs ) ) {
				?><p><?php _e( sprintf( '%d Corrupt Blogs found. Fixing ...', count( $cleanup_blogs ) ), $this->get_textdomain() ); ?></p><?php
				
				// Loop throug the blogs array
				foreach ( $all_blogs as $blog_id => $blog_data ) {
					
					// Loop throug corrupt blogs
					foreach ( $cleanup_blogs as $blog_to_clean ) {
						
						// 1. Get related blogs' current relationships
						$current_rel = get_blog_option( $blog_id, 'inpsyde_multilingual_blog_relationship' );
						
						// We have relationshops
						if ( 1 < count( $current_rel ) ) {
							
							// 2. Compare old to new relationships
							// Get the key of the current blog in the relationships array of the looped blog
							$key = array_search( $blog_to_clean, $current_rel );
							
							// These blogs should not be connected. Delete
							// possibly existing connection
							if ( FALSE !== $key && isset( $current_rel[ $key ] ) )
								unset( $current_rel[ $key ] );
							
							update_blog_option( $blog_id, 'inpsyde_multilingual_blog_relationship', $current_rel );
						}
					}
				}
				
				?><p><?php _e( 'Relationships has been deleted.' , $this->get_textdomain() ); ?></p><?php
				
				// Update site_option
				$blogs = get_site_option( 'inpsyde_multilingual' );
				foreach ( $cleanup_blogs as $blog_to_clean ) {
					
					if ( array_key_exists( $blog_to_clean, $blogs ) )
						unset( $blogs[ $blog_to_clean ] );
					
				}
				update_site_option( 'inpsyde_multilingual', $blogs );
				
				?><p><?php _e( 'Blogmap has been updated.' , $this->get_textdomain() ); ?></p><?php
				?><p><?php _e( 'All done!' , $this->get_textdomain() ); ?></p><?php
			}
			
			delete_site_option( 'multilingual_press_check_db' );
			die;
		}
		
		/**
		 * Checks for errors
		 * 
		 * @access	public
		 * @since	0.8
		 * @uses	
		 * @return	boolean
		 */
		public function check_for_user_errors() {
			
			return $this->check_for_errors();
		}
		
		/**
		 * Checks for errors
		 *
		 * @access	public
		 * @since	0.9
		 * @uses
		 * @return	void
		 */
		public function check_for_user_errors_admin_notice() {
				
			if ( TRUE == $this->check_for_errors() ) {
				?><div class="error"><p><?php _e( 'You didn\'t setup any blog relationships! You have to setup them first to use Multilingual Press. For this, go to Network &raquo; Sites &raquo; and choose a blog to edit. Then go to the tab "Multilingiual Press" and set up the relationships.' , $this->get_textdomain() ); ?></p></div><?php
			}
		}
		
		/**
		 * Checks for errors
		 *
		 * @access	public
		 * @since	0.9
		 * @uses
		 * @return	boolean
		 */
		public function check_for_errors() {
			
			if ( defined( 'DOING_AJAX' ) )
				return FALSE;
				
			if ( ! is_admin() && is_network_admin() )
				return FALSE;
			
			// Get blogs related to the current blog
			$all_blogs = get_site_option( 'inpsyde_multilingual', array() );
			
			if ( 2 > count( $all_blogs ) ) {
				if ( is_super_admin() ) {
					return TRUE;
				}
			}
						
			return FALSE;
		}
	}
}
?>