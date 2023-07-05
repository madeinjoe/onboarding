<?php

namespace Custom\Setup;

defined('ABSPATH') || die('Direct access not allowed');
define('ASSETSDIR', get_stylesheet_directory() . '/assets');
define('ASSETSURI', get_stylesheet_directory_uri() . '/assets');

class CustomEnqueue
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'customStyle']);
        add_action('admin_enqueue_scripts', [$this, 'customStyle']);
    }

    public function customStyle()
    {
        wp_enqueue_style('custom-style', ASSETSURI . '/src/custom/custom-style.css');
    }
}

// Initialize
new CustomEnqueue();
