<?php
//  global $product;
//  $newproduct = wc_get_product( $product->ID );
//  print("<pre>".print_r($newproduct, true)."</pre>");

$prd = wc_get_product();
print("<pre>".print_r($prd, true)."</pre>");
?>

<div class="flex flex-col gap-2 bg-red-300">
    <div class="flex">
        <?php do_action('woocommerce_before_single_product'); ?>
    </div>
    <div class="flex flex-row flex-nowrap">
        <div class="w-5/12 bg-green-200">
            <?php do_action('woocommerce_before_single_product_summary'); ?>
        </div>
        <div class="flex flex-col w-7/12 gap-3 px-4 pt-2 pb-5 bg-blue-200">
            <h1 class="text-5xl font-semibold tracking-wide"><?php echo the_title(); ?></h1>
            <span class="flex flex-row gap-2 price flex-nowrap">
                <h1 class="text-lg font-bold line-through"><?php echo $prd->get_regular_price(); ?></h1>
                <h1 class="text-lg font-bold text-green-400"><?php echo $prd->get_sale_price(); ?></h1>
            </span>
        </div>
    </div>
</div>