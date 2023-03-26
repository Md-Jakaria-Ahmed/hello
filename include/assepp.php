<?php

namespace Braintel\Codeiolab;

class Assepp
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function register_scripts()
    {
        $version = filemtime(UNSOLDSTORE_DIR . '/assets/myjs.js');

        wp_register_script('unsold-store-script', UNSOLDSTORE_ASSETS . '/myjs.js', ['jquery'], $version, true);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('unsold-store-script');
    }
}
