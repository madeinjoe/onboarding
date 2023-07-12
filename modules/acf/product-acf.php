<?php
defined('ABSPATH') || die('Direct access not allowed');

class ProductACF {
    public function __construct() {
        // $this->productAddACF();
        $this->productOptionPage();
        add_action('the_post', [$this, 'productRenderPage'], 10, 1);
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

    public function productRenderPage ($post) {
        if (is_single() && $post->post_type === 'products') {
            if (get_field('product_variant', $post->ID) !== null && count(get_field('product_variant', $post->ID)) > 0) {
                $variant = [];
                foreach (get_field('product_variant', $post->ID) as $key => $value) {
                    array_push($variant, "[".$value['variant_code']."] - ".$value['variant_name']);
                }
            }

            $output = '<div class="container page-content justify-self-center">';
            $output .= '<table>';
            $output .= '<thead>';
            $output .= '<tr>';
            $output .= '<th>Key</th>';
            $output .= '<th>Value</th>';
            $output .= '</tr>';
            $output .= '</thead>';
            $output .= '<tbody>';

            $output .= '<tr>';
            $output .= '<td> product_type </td>';
            $output .= '<td>'.get_field('product_type', $post->ID).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_price </td>';
            $output .= '<td>'.get_field('product_price', $post->ID).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_status </td>';
            $output .= '<td>'.get_field('product_status', $post->ID).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_type </td>';
            $output .= '<td>'.get_field('product_type', $post->ID).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_colour </td>';
            $output .= '<td>'.implode(', ', get_field('product_colour', $post->ID)).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_variant </td>';
            $output .= '<td>'.implode(', ', $variant).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_brand </td>';
            $output .= '<td>'.implode(', ', get_field('product_brand', $post->ID)).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_ecommerce_link </td>';
            $output .= '<td>'.get_field('product_ecommerce_link', $post->ID).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_thumbnail </td>';
            $output .= '<td> <img src="'.get_field('product_thumbnail', $post->ID).'" alt="" width="200" height="150" /></td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_short_description </td>';
            $output .= '<td>'.get_field('product_short_description', $post->ID).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_has_bonus </td>';
            $output .= '<td>'.get_field('product_has_bonus', $post->ID).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td> product_embed </td>';
            $output .= '<td>'.get_field('product_embed', $post->ID).'</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td rowspan="'.(count(get_field('stock_group', $post->ID)) + 1).'"> stock_group </td>';
            // $output .= '<td>'.get_field('stock_group', $post->ID).'</td>';
            $output .= '</tr>';
            foreach(get_field('stock_group', $post->ID) as $key => $value) {
                $output .= '<tr>';
                $output .= '<td>key : '.$key.' => value : '.get_field($key, $post->ID).'</td>';
                $output .= '</tr>';
            }

            $output .= '<tr>';
            $output .= '<td> size </td>';
            $output .= '<td>'.get_field('shirt_size', $post->ID).'</td>';
            $output .= '</tr>';
            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div>';

            $a = apply_filters('the_content', $output);
            echo $a;
        }
    }
}

// Initialize
new ProductACF();
