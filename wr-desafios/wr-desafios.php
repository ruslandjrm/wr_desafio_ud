<?php

/**
 *
 * The plugin bootstrap file
 *
 * This file is responsible for starting the plugin using the main plugin class file.
 *
 * @since 0.0.1
 * @package WR_Desafio_UD
 *
 * @wordpress-plugin
 * Plugin Name:     WR desafios
 * Description:     Desafios para Weremote.
 * Version:         0.0.1
 * Author:          Rusland Rojas.
 * Author URI:      https://www.linkedin.com/in/rusland-rojas-menacho/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     wr_desafio_ud
 * Domain Path:     /lang
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access not permitted.' );
}
//Solve problem with Gutenberg and wp_editor.
define('CONCATENATE_SCRIPTS', false);

if ( ! class_exists( 'WR_Desafio_UD' ) ) {

	/*
	 * main WR_Desafio_UD class
	 *
	 * @class WR_Desafio_UD
	 * @since 0.0.1
	 */
	class WR_Desafio_UD {

		/*
		 * WR_Desafio_UD plugin version
		 *
		 * @var string
		 */
		public $version = '4.7.5';

		/**
		 * The single instance of the class.
		 *
		 * @var WR_Desafio_UD
		 * @since 0.0.1
		 */
		protected static $instance = null;

		/**
		 * Main WR_Desafio_UD instance.
		 *
		 * @since 0.0.1
		 * @static
		 * @return WR_Desafio_UD - main instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * WR_Desafio_UD class constructor.
		 */
		public function __construct() {
			$this->load_plugin_textdomain();
			$this->define_constants();
			$this->includes();
			$this->define_actions();
		}

		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'wr_desafio_ud', false, basename( dirname( __FILE__ ) ) . '/lang/' );
		}

		/**
		 * Include required core files
		 */
		public function includes() {
			// Load custom functions and hooks
			if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
			require_once __DIR__ . '/includes/includes.php';
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}


		/**
		 * Define WR_Desafio_UD constants
		 */
		private function define_constants() {
			define( 'WR_DESAFIO_UD_PLUGIN_FILE', __FILE__ );
			define( 'WR_DESAFIO_UD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			define( 'WR_DESAFIO_UD_VERSION', $this->version );
			define( 'WR_DESAFIO_UD_PATH', $this->plugin_path() );
		}

		/**
		 * Define WR_Desafio_UD actions
		 */
		public function define_actions() {
			//
		}
		
	}

	$WR_Desafio_UD = new WR_Desafio_UD();
}
