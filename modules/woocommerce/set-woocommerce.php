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
        add_action('woocommerce_calculated_total', [$this, 'wooCartTotal'], 10, 2);
        add_action('woocommerce_cart_calculate_fees', [$this, 'wooCartAddFees'], 10, 1);
        add_action('woocommerce_order_item_meta_start', [$this, 'wooEmailItemMeta'], 10, 4);
        add_action('woocommerce_single_product_summary', [$this, 'wooProductSumarry'], 10, 1);
        add_action('woocommerce_before_single_product', [$this, 'singleProductScript']);
        add_action('wp_ajax_woo_add_to_cart', [$this, 'wooAtcHandle']);
        add_action('wp_ajax_nopriv_woo_add_to_cart', [$this, 'wooAtcHandle']);
    }

    public function setWoocomerceSupport () {
        add_theme_support('woocommerce', [
            'thumbnail_image_width' => 550,
            'single_image_width' => 100
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

    public function wooCartTotal ($total, $cart) {
        if (WC()->customer->get_shipping_country() !== 'ID') {
            return $total + 90;
        }
        return $total;
    }

    public function wooCartAddFees ($cart) {
        if ($cart->subtotal >= 100000) {
            $fees = floatval((1 / 100) * $cart->subtotal);
            $cart->add_fee( __( 'Custom Fee', 'woocommerce' ) , $fees, false );
        }
    }

    public function wooEmailItemMeta ($item_id, $item, $order, $do_plain) {
        echo '<hr>';
        echo array_key_first($this->wooPrdMetaKeys).' : '.get_post_meta($item->get_product_id(), array_key_first($this->wooPrdMetaKeys), true);
    }

    public function singleProductScript() {
        if (is_product() && is_single()) {
            wp_enqueue_script('single-product-js', ASSETSURI . '/src/custom/single-product-script.js', array('jquery'));
            wp_localize_script('single-product-js', 'atcData', ['url' => admin_url('admin-ajax.php'), 'action' => 'woo_add_to_cart']);
        }
    }

    public function wooProductSumarry ($product) {
    }

    public function wooAtcHandle () {
        /** Verify nonce */
        if (!isset($_POST['_atc_nonce']) || !wp_verify_nonce($_POST['_atc_nonce'], '_atc')) {
            $response = [
                'success' => false,
                'message' => 'Invalid nonce token.',
                'errors' => [
                    'nonce' => [
                        'nonce token is invalid'
                    ]
                ]
            ];
            return wp_send_json($response, 400);
        }

        /** Validate */
        $validate = $this->_validate_atc($_POST);
        if (!$validate['is_valid']) {
            $response = [
                'success' => false,
                'message' => 'Invalid user input.',
                'errors' => $validate['errors']
            ];
            return wp_send_json($response, 400);
        } else {
            $response = [
                'success' => true,
                'message' => 'Added to cart.'
            ];
            return wp_send_json($response, 201);
        }
    }

    private function _validate_atc($request) {
        $response = [
            'is_valid' => true,
            'errors' => []
        ];

        /** Validate length */
        if (!isset($request['length'])) {
            $response['is_valid'] = false;
            $response['errors']['length'][] = 'length is required.';
        } else if (sanitize_text_field($request['length']) <= 0) {
            $response['is_valid'] = false;
            $response['errors']['length'][] = 'length must be more than 0.';
        } else if (sanitize_text_field($request['length']) > 5) {
            $response['is_valid'] = false;
            $response['errors']['length'][] = 'length cannot be more than 5.';
        }

        /** validate piece */
        if (!isset($request['piece'])) {
            $response['is_valid'] = false;
            $response['errors']['piece'][] = 'piece is already used.';
        } else if (sanitize_text_field($request['piece']) <= 0) {
            $response['is_valid'] = false;
            $response['errors']['piece'][] = 'piece must be more than 0.';
        }

        return $response;
    }
}

// Initialize
new setWooCommSupport();
