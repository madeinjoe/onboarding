<?php
defined('ABSPATH') || die("Can't access directly");
require_once MODULES_DIR . '/helper/custom-input-helper.php';

use \Custom\InputHelper\CustomInput as CI;

class ProductCPT extends RegisterCPT
{
    protected $slugCPT;
    protected $prdMetaKeys;

    public function __construct()
    {
        /** This Object Post-type Slug */
        $this->slugCPT = 'products';

        /** Meta in this (product) post-type */
        $this->prdMetaKeys = [
            '_prd_price' => [
                'label' => 'Product Price',
                'type'  => 'number',
                'min'   => '0',
                'max'   => '9999.99',
                'step'  => '0.01'
            ],
            '_prd_sku' => [
                'label' => 'Product SKU',
                'type' => 'text',
                'placeholder' => 'Input product SKU...'
            ],
            '_prd_stock_qty' => [
                'label' => 'Product Stock ',
                'type'  => 'number',
                'min'   => '0',
                'max'   => '9999',
                'step'  => '1'
            ]
        ];

        add_action('init', [$this, 'productsCreateCPT']);
        add_action('add_meta_boxes', [$this, 'productMB']);
        add_action('save_post', [$this, 'productSaveMB']);
        add_action('wp_head', [$this, 'productMetatagKeywords']);
        add_filter('cf_filter_the_title', [$this, 'productTitleFilter'], 10, 3);
    }

    public function productsCreateCPT()
    {
        $additionalArgs = [
            'menu_position' => 5,
            'has_archive' => true,
            'public' => true,
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'custom-fields',
                'thumbnail',
                'page_attributes'
            ),
            'taxonomies' => array('category', 'post_tag', 'size', 'brand'),
            'show_in_rest' => true
        ];

        $this->customPostType('Products', $this->slugCPT, $additionalArgs);
        $this->sizeCreateCPT($this->slugCPT);
        $this->brandCreateCPT($this->slugCPT);
    }

    public function productMB(String $slug_cpt = null)
    {
        add_meta_box(
            'product_detail_box',
            'Product Detail',
            [$this, 'productRenderMB'],
            $this->slugCPT,
            'advanced',
            'default',
            ['meta' => $this->prdMetaKeys]
        );
    }

    public function productRenderMB($post, $callback_args = [])
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
        CI::renderAllInput($mbData, true, '_product_metabox', '_product_metabox');
    }

    public function productSaveMB($post_id)
    {
        /** Verify nonce */
        if (!isset($_POST['_product_metabox_nonce']) || !wp_verify_nonce($_POST['_product_metabox_nonce'], '_product_metabox')) {
            return;
        }

        /** Check Autosave */
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || !current_user_can('edit_post', $post_id)) {
            return;
        }

        /** Save metabox data */
        // $metaValues = []; // Use this if using wp_update_post only
        foreach ($this->prdMetaKeys as $metaKey => $value) {
            if (isset($_POST[$metaKey])) {
                switch ($value['type']) {
                    case 'textarea':
                        // $metaValues[$metaKey] = sanitize_textarea_field($_POST[$metaKey]);
                        update_post_meta($post_id, $metaKey, sanitize_textarea_field($_POST[$metaKey]));
                        break;
                    default:
                        // $metaValues[$metaKey] = sanitize_text_field($_POST[$metaKey]);
                        update_post_meta($post_id, $metaKey, sanitize_text_field($_POST[$metaKey]));
                }
            }
        }

        // wp_update_post(['ID' => $post_id, 'meta_input' => $metaValues]);
    }

    public function productMetatagKeywords()
    {
        echo "<meta name=\"keywords\" content=\"WordPress, tutorial, try\">";
    }

    public function productTitleFilter(String $title, String $prefix = 'NEW', array $tags = [])
    {
        if ($tags && count($tags) > 0) {
            return $tags['markup-open'] . '[' . $prefix . ']&nbsp' . $title . $tags['markup-close'];
        } else {
            return '[' . $prefix . ']' . $title;
        }
    }

    public function sizeCreateCPT(String $slug_cpt = null)
    {
        /** Set default value of slug_cpt argument */
        $slug_cpt = $slug_cpt ?? $this->slugCPT;

        $slug_tax = 'size';
        $labels = array(
            'name'              => _x('Sizes', 'taxonomy general name'),
            'singular_name'     => _x('Size', 'taxonomy singular name'),
            'search_items'      => __('Search Sizes'),
            'all_items'         => __('All Sizes'),
            'parent_item'       => __('Parent Sizes'),
            'parent_item_colon' => __('Parent Sizes:'),
            'edit_item'         => __('Edit Sizes'),
            'update_item'       => __('Update Sizes'),
            'add_new_item'      => __('Add New Sizes'),
            'new_item_name'     => __('New Sizes Name'),
            'menu_name'         => __('Sizes'),
        );

        $args = [
            'label' => __('Sizes'),
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'public'            => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => $slug_tax),
            'capabilities'      => ['manage_categories']
        ];

        $this->taxonomy($slug_cpt, $slug_tax, $args);
    }

    public function brandCreateCPT(String $slug_cpt = null)
    {
        /** Set default value of slug_cpt argument */
        $slug_cpt = $slug_cpt ?? $this->slugCPT;

        $slug_tax = 'brand';
        $labels = array(
            'name'              => _x('Brands', 'taxonomy general name'),
            'singular_name'     => _x('Brand', 'taxonomy singular name'),
            'search_items'      => __('Search Brands'),
            'all_items'         => __('All Brands'),
            'parent_item'       => __('Parent Brands'),
            'parent_item_colon' => __('Parent Brands:'),
            'edit_item'         => __('Edit Brands'),
            'update_item'       => __('Update Brands'),
            'add_new_item'      => __('Add New Brands'),
            'new_item_name'     => __('New Brands Name'),
            'menu_name'         => __('Brands'),
        );

        $args = [
            'label' => __('Brands'),
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'public'            => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => $slug_tax),
        ];

        $this->taxonomy($slug_cpt, $slug_tax, $args);
    }
}

// Initialize the class
new ProductCPT();
