<?php
defined('ABSPATH') || die("Direct access not allowed");

require_once MODULES_DIR . '/helper/custom-input-helper.php';

use \Custom\Helper\CustomInput as CI;

class setWooCommSupport {
    protected $wooPrdMetaKeys;

    public function __construct() {
        /** Meta in this (product) post-type */
        $this->wooPrdMetaKeys = [
            '_prd_custom_meta' => [
                'label' => 'Product Custom Meta',
                'type' => 'text',
                'placeholder' => 'Input product Custom Meta'
            ]
        ];
        add_theme_support('after_setup_theme', [$this, 'setWoocomerceSupport']);
        add_action('add_meta_boxes', [$this, 'wooProductsMB']);
        add_action('save_post', [$this, 'wooProductSaveMeta']);
        add_action('woocommerce_product_meta_end', [$this, 'wooProductRenderMeta'], 10, 1);
    }

    public function setWoocomerceSupport () {
        add_theme_support('woocommerce', [
            'thumbnail_image_width' => 250,
            'single_image_width' => 300
        ]);
    }

    public function wooProductsMB () {
        add_meta_box(
            'woo_product_detail_box',
            'Product Detail',
            [$this, 'wooProductRenderMB'],
            'product',
            'advanced',
            'default',
            ['meta' => $this->wooPrdMetaKeys]
        );
    }

    public function wooProductRenderMB($post, $callback_args = [])
    {
        /** Get meta key value from db */
        $mbData = $callback_args['args']['meta'];
        foreach ($callback_args['args']['meta'] as $key => $value) {
            $mbData[$key]['meta-key'] = $key;
            $mbData[$key]['meta-value'] = get_post_meta($post->ID, $key, true);
        }

        /** Render metaboxes
         * renderAllInput is a static, this method will automaticly added _nonce into attribute name of nonce input
         */
        CI::renderAllInput($mbData, true, '_woo_product_metabox', '_woo_product_metabox');
    }

    public function wooProductSaveMeta($post_id)
    {
        if (!isset($_POST['_woo_product_metabox_nonce']) || !wp_verify_nonce($_POST['_woo_product_metabox_nonce'], '_woo_product_metabox')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || !current_user_can('edit_post', $post_id)) {
            return;
        }

        foreach ($this->wooPrdMetaKeys as $metaKey => $value) {
            if (isset($_POST[$metaKey])) {
                switch ($value['type']) {
                    case 'textarea':
                        update_post_meta($post_id, $metaKey, sanitize_textarea_field($_POST[$metaKey]));
                        break;
                    default:
                        update_post_meta($post_id, $metaKey, sanitize_text_field($_POST[$metaKey]));
                }
            }
        }
    }

    public function wooProductRenderMeta () {
        global $product;

        if (is_product()) {
            echo '<h1>custom meta : '.$product->get_meta('_prd_custom_meta')."</h1>";
        }
    }
}

// Initialize
new setWooCommSupport();
