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
        add_action('wp_enqueue_scripts', [$this, 'registrationScripts']);
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

        echo "
        <script>
        tailwind.config = {
            theme: {
                fontSize: {
                    'thxl': ['2rem', '2.125rem'],
                },
                extend: {
                    colors: {
                        clifford: '#da373d',
                    },
                    boxShadow: {
                      '3xl': '0 0px 40px rgba(0, 0, 0, 0.25)',
                    },
                    animation: {
                      fade: 'fadeOut 5s ease-in-out',
                    },

                    keyframes: {
                      fadeOut: {
                        '0%': { backgroundColor: theme('colors.red.300') },
                        '100%': { backgroundColor: theme('colors.transparent') },
                      },
                    }
                }
            }
        }
        </script>";

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

                .form-control.input-invalid ~ .password-sh-toggle {
                    @apply fill-current text-gray-500 w-4 h-4 top-[45%] right-3 cursor-pointer hover:text-black;
                }

                .input-invalid {
                    @apply border border-red-500 bg-red-200/80 focus:outline-none focus:ring-1 focus:ring-red-400 focus:border-red-400 !important;
                }

                .product_title {
                    @apply text-4xl font-bold tracking-wide
                }

                .woocommerce-product-gallery {
                    @apply relative;
                }

                .woocommerce-product-gallery__trigger {
                    @apply absolute right-3 top-3 z-10;
                }

                .onsale {
                    @apply absolute z-10 top-3 left-2 h-2 w-2 pt-0 !important;
                }

                .price {
                    @apply align-middle;
                }

                del bdi {
                    @apply text-lg font-semibold mr-2;
                }

                ins bdi {
                    @apply text-2xl font-bold text-green-600;
                }

                form.cart, .woocommerce-variation-add-to-cart {
                    @apply flex flex-col gap-3;
                }

                .wp-post-image {
                    @apply rounded-xl border-2 border-black p-1 !important;
                }

                div.quantity > input.qty {
                    @apply w-24 !important;
                }

                .wc-shop-title > h2 {
                    @apply text-lg font-bold !important;
                }

                .wc-shop-price > span {
                    @apply flex flex-col items-start;
                }

                .wc-shop-price > span > del > span > bdi {
                    @apply text-gray-500 font-normal text-base;
                }

                .wc-shop-price > span > ins > span > bdi {
                    @apply text-emerald-600 font-bold text-xl -mt-1;
                }

                .zooming {
                    @apply max-h-[32rem] !important;
                }

                .tab-nav {
                    @apply py-2 font-semibold text-center uppercase rounded h-fit border border-solid border-emerald-500;
                }

                .tab-nav:not(.active) {
                    @apply text-emerald-500 duration-500;
                }

                .tab-nav.active {
                    @apply bg-emerald-500 text-white duration-500;
                }

                .tab-content {
                    @apply top-0;
                }

                .tab-content:not(.active) {
                    @apply absolute opacity-0 z-0 duration-300;
                }

                .tab-content.active {
                    @apply static opacity-100 z-10 duration-500;
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
        if (!empty($post) && $post->post_name == 'custom-login') {
            /** Login js */
            wp_enqueue_script('login-js', ASSETSURI . '/src/custom/login-script.js', array('jquery'));
            wp_localize_script('login-js', 'clData', array('loginUrl' => admin_url('admin-ajax.php')));
        }
    }

    public function registrationScripts()
    {
        global $post;
        if (!empty($post) && $post->post_name == 'custom-registration') {
            /** Login js */
            wp_enqueue_script('registration-js', ASSETSURI . '/src/custom/registration-script.js', array('jquery'));
            wp_localize_script('registration-js', 'caData', array('registrationUrl' => admin_url('admin-ajax.php')));
        }
    }

    public function taskjsScript()
    {
        global $post;
        if (!empty($post) && $post->post_name == 'task-javascript') {
            wp_enqueue_script('task-js', ASSETSURI . '/src/custom/task-js-script.js', array('jquery'));
            wp_localize_script('task-js', 'tjsData', array('loginUrl' => admin_url('admin-ajax.php')));
        }
    }
}

// Initialize
new CustomEnqueue();
