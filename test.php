<?php
/**
 * @package hello test
 * @version 1.0.0
 */
/*
Plugin Name: Test Plugin
Plugin URI: https://wedevs.com
Description: this is just plugin
Version: 1.0.0
Author URI: https://www.md-zakaria-ahmed.blogspot
*/

// don't call the file directly

final class MyTest
{
    protected static $instance = null;

    private function __construct()
    {
        require_once __DIR__ . '/vendor/autoload.php';
        
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        $this->define_constants();

        add_action('dokan_loaded', [$this, 'load']);
    }

    public function load()
    {
        new Assepp();
    }

    public function define_constants()
    {
        $this->define('UNSOLDSTORE_DIR', __DIR__);
        $this->define('UNSOLDSTORE_ASSETS', plugins_url('assets', __FILE__));
    }

    /**
     * Provide facility to override the constant from theme or hooks
     *
     * @param mixed $value
     *
     * @return void
     */
    public function define(string $name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    public function activate()
    {
        if (!$this->check_dependencies()) {
            wp_die($this->get_dependency_message());
        }

        flush_rewrite_rules(true);
    }

    protected function get_dependency_message()
    {
        return __('Test plugin enabled but not effective. It requires WooCommerce and Dokan plugins to work. ', 'test');
    }

    public function check_dependencies(): bool
    {
        if (!class_exists('Woocommerce') || !class_exists('WeDevs_Dokan')) {
            return false;
        }

        if (!is_plugin_active('woocommerce/woocommerce.php') || !is_plugin_active('dokan-lite/dokan.php')) {
            return false;
        }

        return true;
    }

    public function deactivate()
    {
        // TODO: Perform task for activating the plugin
    }

    public static function init() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

/**
* Define boot method
* 
* @return MyTest_Setup
*/
function test_setup()
{
    return MyTest::init();
}

// Start booting 

test_setup();