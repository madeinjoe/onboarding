<?php

namespace Custom\Setup;

defined('ABSPATH') || die('Direct access not allowed');
define('ASSETSURI', THEME_URL . '/assets');

class CustomEnqueue
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'customStyle']);
        add_action('admin_enqueue_scripts', [$this, 'customStyle']);
        add_action('wp_enqueue_scripts', [$this, 'tailwindLayer']);
        add_action('wp_enqueue_scripts', [$this, 'fontawesomeCDN']);
        add_action('wp_enqueue_scripts', [$this, 'loginScripts']);
        add_action('wp_enqueue_scripts', [$this, 'taskjsScript']);
    }

    public function customStyle()
    {
        wp_enqueue_style('custom-style', ASSETSURI . '/src/custom/custom-style.css');
    }

    public function tailwindLayer()
    {
        /** CDN */
        wp_register_script('tailwind-cdn', 'https://cdn.tailwindcss.com', [], '1.0', false);
        wp_enqueue_script('tailwind-cdn');
        echo '
        <style type="text/tailwindcss">
            @layer base {
                body::-webkit-scrollbar {
                    @apply w-2;
                }

                body::-webkit-scrollbar-track {
                    @apply bg-gray-300;
                }

                body::-webkit-scrollbar-thumb {
                    @apply bg-gray-500 border-2 border-sky-300 hover:bg-gray-600;
                }
            }

            @layer components {
                .input-group {
                    @apply flex flex-col gap-1;
                }

                .form-label {
                    @apply mb-1 font-medium text-black;
                }

                .form-label > span.required {
                    @apply text-red-400 text-sm italic;
                }

                .form-control {
                    @apply rounded font-normal text-base px-2 py-1.5 bg-white border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400;
                }

                .btn {
                    @apply flex items-center justify-center gap-1 px-2 py-1 text-base font-bold text-justify;
                }

                .btn-outline-blue {
                    @apply border-[1px] border-blue-400 text-blue-400 transition-all ease-in-out duration-300 hover:bg-blue-500 hover:text-white;
                }

                .form-control ~ .password-sh-toggle {
                    @apply fill-current text-gray-500 w-4 h-4 top-[60%] right-3 cursor-pointer hover:text-black;
                }
            }
        </style>';
    }

    public function fontawesomeCDN()
    {
        /** CDN */
        wp_register_style('fontawesome-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        wp_style_add_data('fontawesome-cdn', 'integrity', 'sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==');
        wp_style_add_data('fontawesome-cdn', 'integrity', 'sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==');
        wp_style_add_data('fontawesome-cdn', 'crossorigin', 'anonymous');
        wp_style_add_data('fontawesome-cdn', 'referrerpolicy', 'no-referrer');
        wp_enqueue_style('fontawesome-cdn');
    }

    public function loginScripts()
    {
        global $post;
        if ($post->post_name == 'custom-login') {
            /** Login js */
            wp_enqueue_script('login-js', ASSETSURI . '/src/custom/login-script.js', array('jquery'));
            wp_localize_script('login-js', 'clData', array('loginUrl' => admin_url('admin-ajax.php')));
        }
    }

    public function taskjsScript()
    {
        global $post;
        if ($post->post_name == 'task-javascript') {
            wp_enqueue_script('task-js', ASSETSURI . '/src/custom/task-js-script.js', array('jquery'));
            wp_localize_script('task-js', 'tjsData', array('loginUrl' => admin_url('admin-ajax.php')));
        }
    }
}

// Initialize
new CustomEnqueue();
