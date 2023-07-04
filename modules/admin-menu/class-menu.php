<?php

namespace Custom\WPMenu;

defined('ABSPATH') || die("Direct access not allowed");
require_once MODULES_DIR . '/helper/custom-input.php';

use \Custom\Input\CustomInput as CI;

class CustomAdminMenu
{
    protected $customInput;
    protected $ssMetaKeys;

    public function __construct()
    {
        $this->ssMetaKeys = [
            '_shop_currency' => [
                'label'     => 'Shop Currency',
                'type'      => 'select',
                'required'  => true,
                'options'   => [
                    'USD' => 'US Dollar',
                    'IDR' => 'Indonesian Rupiah',
                    'MSR' => 'Malaysian Ringgit'
                ],
                'placeholder' => 'Choose Shop Use Currency'
            ],
            '_shop_address' => [
                'label' => 'Shop Adress',
                // 'required'  => false,
                'type' => 'textarea',
                ''
            ]
        ];
        $this->customInput = new CI();
        add_action('admin_menu', [$this, 'shopSettingMenu']);
        add_action('admin_post_change_shop_setting', [$this, 'shopSettingUpdate']);
        // add_action('add_meta_boxes', [$this, 'shopSettingMB']);
    }

    public function shopSettingMenu()
    {
        /** Use named arguments ONLY IF the system running php version >= 8 */
        add_menu_page(
            $page_title = 'Shop Settings',
            $menu_title = 'Shop Setting',
            $capability = 'manage_options',
            $menu_slug = 'shop-setting',
            $callback = [$this, 'shopSettingRenderPage'],
            $icon_url = 'dashicons-store',
            $position = 20
        );
    }

    public function shopSettingRenderPage()
    {
        extract(['meta' => $this->ssMetaKeys]);
        ob_start();
        include __DIR__ . '/shop-setting-page.php';
        $output = ob_get_clean();
        echo $output;

        // include __DIR__ . '/shop-setting-page.php';
        // echo 'teas';
    }

    public function shopSettingMB()
    {
        add_meta_box(
            'Shop Setting',
            'Shop Setting',
            [$this, 'shopSettingRenderMB'],
            // 'shop-setting',
            'admin.php?page=shop-setting',
            'advanced',
            'default',
            ['meta' => $this->ssMetaKeys]
        );
    }

    public function shopSettingRenderMB($post, $callback_args = [])
    {
        // include __DIR__ . '/shop-setting-page.php';
        echo 'a';
        extract(['meta' => $this->ssMetaKeys]);
        ob_start();
        include __DIR__ . '/shop-setting-page.php';
        $output = ob_get_clean();
        echo $output;

        /** Get meta key value from db */
        // $mbData = $callback_args['args']['meta'];
        // foreach ($callback_args['args']['meta'] as $key => $value) {
        //     $mbData[$key]['meta-key'] = $key;
        //     $mbData[$key]['meta-value'] = get_post_meta($post->ID, $key, true);
        // }

        /** Render metaboxes */
        // $this->customInput->renderAllInput($mbData, true, '_shop_setting_metabox', '_shop_setting_metabox'); // renderAllInput is a non-static, automaticly added _nonce into attribute name of nonce input
        // print("<pre>" . print_r($test, true) . "</pre>");
    }

    public function shopSettingUpdate()
    {
        /** Verify nonce */
        if (!isset($_POST['_shop_setting_metabox_nonce']) || !wp_verify_nonce($_POST['_shop_setting_metabox_nonce'], '_shop_setting_metabox')) {
            wp_redirect(admin_url('post.php'));
            return;
        }

        foreach ($this->ssMetaKeys as $metaKey => $value) {
            if (isset($_POST[$metaKey])) {
                switch ($value['type']) {
                    case 'textarea':
                        update_option($metaKey, sanitize_textarea_field($_POST[$metaKey]));
                        break;
                    default:
                        update_option($metaKey, sanitize_text_field($_POST[$metaKey]));
                }
            }
        }

        wp_redirect(admin_url('admin.php?page=shop-setting'));
    }
}

// Initialize
new CustomAdminMenu();
