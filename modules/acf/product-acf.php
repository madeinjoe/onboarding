<?php
defined('ABSPATH') || die('Direct access not allowed');

class ProductACF {
    public function __construct() {
        // $this->productAddACF();
        $this->productOptionPage();
    }

    public function productAddACF () {
        if (function_exists('acf_add_local_field_group')) :
            acf_add_local_field_group ([
                'key' => 'product_detail',
                'title' => 'Product Detail (ACF)',
                'fields' => [
                    array (
                        'key' => 'field_product_price',
                        'label' => 'Product Price',
                        'name' => 'product_price',
                        'type' => 'number',
                        'instructions' => 'Enter product price.',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => 'acf-product-price',
                        ),
                        'default_value' => '',
                        'placeholder' => 'Enter product price',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                        'min' => 0,
                        'max' => 9999.99,
                        'step' => 0.01,
                        'readonly' => 0,
                        'disabled' => 0,
                    ),
                    [
                        'key' => 'field_product_sku',
                        'label' => 'Product SKU',
                        'name' => 'product_sku',
                        'type' => 'text',
                        'instructions' => 'Enter product sku.',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => 'acf-product-sku',
                        ),
                        'default_value' => '',
                        'placeholder' => 'Enter product sku',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                        'readonly' => 0,
                        'disabled' => 0,
                    ],
                    [
                        'key' => 'field_product_stock_tatus',
                        'label' => 'Stock status',
                        'name' => 'product_stock_tatus',
                        'type' => 'radio',
                        'instructions' => 'select product status.',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'choices' => [
                            'is_po' => 'Pre-order',
                            'in_stock' => 'In stock'
                        ],
                        'default_value' => 'in_stock',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => 'acf-product-stock_status',
                        ),
                        'default_value' => '',
                        'placeholder' => 'select product status',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                        'readonly' => 0,
                        'disabled' => 0,
                    ],
                ],
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'products',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ]);
        endif;
    }

    public function productOptionPage () {
        if (function_exists('acf_add_options_page')) {
			acf_add_options_page([
				"page_title" => "Product Settings",
				"menu_title" => "Product Settings",
				"menu_slug" => "product-settings",
				"capability" => "edit_posts",
				"redirect" => false,
			]);
        }
    }
}

// Initialize
new ProductACF();
