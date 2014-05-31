<?php
/**
 * wpmu-signup-steps
 *
 * @package   wpmu-signup-steps
 * @author    jossemarGT <hello@jossemargt.com>
 * @license   GPL-2.0+
 * @link      http://jossemargt.com
 * @copyright 5-29-2014 jossemargt
 */

require_once(plugin_dir_path(__FILE__) . "/views/ViewManager.php");

/**
 * wpmu-signup-steps class.
 *
 * @package WPMUSignupSteps
 * @author  jossemarGT <hello@jossemargt.com>
 */
class WPMUSignupSteps{
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = "1.0.0";

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = "wpmu-signup-steps";

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action("init", array($this, "load_plugin_textdomain"));

		// Add the options page and menu item.
		add_action("admin_menu", array($this, "add_plugin_admin_menu"));

		// Load admin style sheet and JavaScript.
		// add_action("admin_enqueue_scripts", array($this, "enqueue_admin_styles"));
		// add_action("admin_enqueue_scripts", array($this, "enqueue_admin_scripts"));
		
		// Enqueue scripts and styles (header)
		add_action("signup_header", array($this, "enqueue_signup_styles_and_scritps"));
		
		// Before any signup form (new user, new blog, another blog).
		add_action("before_signup_form", array($this, "action_render_steps_markup"));
		
		// -- User registration
		add_action("signup_extra_fields", array($this, "action_add_fields_user_signup_form"));
		// 'signup_hidden_fields',  'validate-user' // New user
		
		// -- Blog registration		
		// After blog signup form 
		add_action("signup_blogform", array($this, "action_before_register_new_blog_form"));
		// 'signup_hidden_fields', 'create-another-site' // Returning user
		
		// Before any signup (server side) and default stage // new user, new blog o another blog
		// add_action("preprocess_signup_form", array($this, "action_before_register_new_blog_form"));
		
		// Signup finished
		// Head up! It get fired 3 times, in user signup ,new site signup (for new user), new site for returning user
		// add_action("signup_finished", array($this, "action_add_fields_user_signup_form"));
		
		// Check "stage" POST variable to know in witch step you are $_POST['stage'] :678
		// "validate-user-signup" after new user form
		// "validate-blog-signup" after new site form
		// "gimmeanotherblog" after another site registration (returning user)
		// "default" before any registration (server side)
		
		// After any signup (new user, new blog, another blog) form and before wp_footer
		add_action("after_signup_form", array($this, "action_before_register_new_blog_form"));
		
		// add_filter("TODO", array($this, "filter_method_name"));

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn"t been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate($network_wide) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate($network_wide) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters("plugin_locale", get_locale(), $domain);

		load_textdomain($domain, WP_LANG_DIR . "/" . $domain . "/" . $domain . "-" . $locale . ".mo");
		load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . "/lang/");
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_style($this->plugin_slug . "-admin-styles", plugins_url("css/admin.css", __FILE__), array(),
				$this->version);
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_script($this->plugin_slug . "-admin-script", plugins_url("js/wpmu-signup-steps-admin.js", __FILE__),
				array("jquery"), $this->version);
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_signup_styles_and_scritps() {
		wp_enqueue_style($this->plugin_slug . "-plugin-styles", plugins_url("css/public.css", __FILE__), array(),
			$this->version);
		
		wp_enqueue_script($this->plugin_slug . "-plugin-script", plugins_url("js/public.js", __FILE__), array("jquery"),
			$this->version);
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		$this->plugin_screen_hook_suffix = add_plugins_page(__("wpmu-signup-steps - Administration", $this->plugin_slug),
			__("wpmu-signup-steps", $this->plugin_slug), "read", $this->plugin_slug, array($this, "display_plugin_admin_page"));
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once("views/admin.php");
	}

	/**
	 * Insert the visual steps in wp-signup.php before the signup form
	 *
	 * @since    1.0.1
	 */
	public function action_render_steps_markup() {
		$viewMan = new ViewManager();

		$last_stage = isset($_POST["stage"]) ? $_POST["stage"] : "default" ;
		$user_logged_in = is_user_logged_in();
		
		$active_signup = get_site_option( 'registration', 'none' ); // wp-signup:649
		$active_signup = apply_filters( 'wpmu_active_signup', $active_signup ); // wp-signup:658
		
		$viewMan->render("signup-steps.tpl.php", array(
			"active_signup_type" => $active_signup,
			"user_logged_in" => $user_logged_in,
			"last_stage" => $last_stage
		));
	}
	
	public function action_before_register_new_blog_form(){
		// Before the blog registration
		// First step for existing users (returning users as internal doc says wp-signup.php:219 / WP 3.9.1)
		// Second step for new users
	}
	
	public function action_add_fields_user_signup_form() {
		// Add extra fields to the user signup (new users)
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}

}