<?php
/**
 * Plugin Name: Evento Task
 * Description: Plugin to add events to the website
 * Plugin URI:  #
 * Version:     1.0.0
 * Author:     Mahmoud Abdelrahman
 * Author URI:  #
 * Text Domain: evento-task
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'BASE_URL', plugin_dir_url(__FILE__) );
define( 'BASE_DIR', plugin_dir_path(__FILE__) );
// Add Plugin actions

final class Evento_Task {
    
    const VERSION = '1.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }
    
    
    public function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    public function i18n() {

        load_plugin_textdomain( 'evento-task' );

    }
    public function init() {
        
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        require_once BASE_DIR.'/meta-data.php';
        require_once BASE_DIR.'/widget.php';
        require_once BASE_DIR.'/shortcode.php';
        add_action('admin_enqueue_scripts', [ $this,'admin_widget_scripts']);
        add_action( 'wp_enqueue_scripts', [ $this, 'widget_styles' ] );

    }

    /**
     * @return null
     */
    public function widget_styles() {
        wp_enqueue_style( 'event_front_style', BASE_URL.'/assets/css/events-front.css', array(), '1.0.0');
    }

    public function admin_widget_scripts()
    {
        wp_enqueue_script( 'datepicker', BASE_URL.'/assets/js/datepicker.min.js', array( 'jquery' ), '1.0.9', true );
        wp_enqueue_script( 'event_custom_script', BASE_URL. '/assets/js/event_custom_script.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_style( 'datepicker', BASE_URL.'/assets/css/datepicker.min.css', array(), '1.0.9');
        wp_enqueue_style( 'event_custom_style', BASE_URL.'/assets/css/events.css', array(), '1.0.0');

    }



    /**
     * When the post is saved, saves our custom data.
     */

    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'evento-task' ),
            '<strong>' . esc_html__( 'evento-task Elementor Elements', 'evento-task' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'evento-task' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }
    
}

Evento_Task::instance();

