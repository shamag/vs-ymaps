<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       no
 * @since      1.0.0
 *
 * @package    Vs_Ymaps
 * @subpackage Vs_Ymaps/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vs_Ymaps
 * @subpackage Vs_Ymaps/public
 * @author     shamag <otbacmhe@gmail.com>
 */
class Vs_Ymaps_Public {
	private $name='ym';
	private $placemarks_name='ym_pl';
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version )
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$page_title = 'Яндекс карты';
		$menu_title = "яндекс карты";
	}
 //add_menu_page( $page_title, $menu_title, 0, '11', $output_function, $icon_url, $position );


// mt_options_page() displays the page content for the Test Options submenu

// mt_manage_page() displays the page content for the Test Manage submenu
	

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vs_Ymaps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vs_Ymaps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vs-ymaps-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vs_Ymaps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vs_Ymaps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}

	public function register_shortcodes() {

		add_shortcode( 'vsymaps', array( $this, 'shortcode' ) );

	}
	public function shortcode($atts){

		
		extract( shortcode_atts( array (
			'name' => 'name',

		), $atts ) );
		//$name = $this->name;
		
		wp_enqueue_script('ymaps','https://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vs-ymaps-public.js', array( 'jquery' ), $this->version, false );
		$options = get_option((string)$this->name);
		$placemarks = get_option((string)$this->placemarks_name);

		return "<div id=\"map\"></div><div class='legend'></div><div class='options'>".json_encode($options)."</div><div class='placemarks'>".json_encode($placemarks)."</div>";
	}

}
