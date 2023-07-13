<?php
//  global $product;
//  $newproduct = wc_get_product( $product->ID );
//  print("<pre>".print_r($newproduct, true)."</pre>");

$prd = wc_get_product();
?>

<div class="flex flex-col gap-2">
    <div class="flex">
        <?php do_action('woocommerce_before_single_product'); ?>
    </div>
    <div class="flex flex-row flex-nowrap">
        <div class="relative w-6/12 h-[32rem] overflow-hidden rounded-lg wc-image bg-gray-100 border border-solid border-black custom-wc">
            <?php do_action('woocommerce_before_single_product_summary'); ?>
        </div>
        <div class="flex flex-col w-6/12 gap-3 px-4 pt-2 pb-5">
            <!-- <?php echo do_action( 'woocommerce_single_product_summary' ); ?> -->
            <h1 class="text-5xl font-semibold tracking-wide uppercase">Lorem Title</h1>
            <span class="flex flex-col price flex-nowrap">
                <h1 class="text-2xl font-medium text-gray-400 line-through"><?php echo $prd->get_price_html(); ?></h1>
                <h1 class="text-[2rem] leading-[2.35] font-bold underline text-emerald-600 underline-offset-1 decoration-3"><?php echo $prd->get_sale_price(); ?></h1>
            </span>
            <form class="flex flex-col gap-2" id="form-add-to-cart">
                <?php wp_nonce_field('_atc', '_atc_nonce'); ?>
                <div class="flex w-full gap-2 px-2 py-3 bg-gray-100 rounded flex-nowrap">
                    <div class="w-3/12 border-2 border-red-300 border-solid input-group">
                        <label for="input-length" class="form-label">Length</label>
                        <input type="number" name="length" id="input-length" min="1" max="5" step="1" class="form-control w-fit">
                    </div>
                    <div class="w-4/12 border-2 border-red-300 border-solid input-group">
                        <label for="input-pcs" class="form-label">Piece</label>
                        <input type="number" name="" id="input-pcs" min="1" step="1" class="form-control w-fit">
                    </div>
                    <div class="w-4/12 border-2 border-red-300 border-solid input-group">
                        <label class="form-label">Price per pcs</label>
                        <label class="form-label" id="price-per-piece"></label>
                    </div>
                    <div class="flex items-start justify-center w-1/12 border-2 border-red-300 border-solid">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="w-6 h-6 text-green-600 fill-current">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="text-white bg-green-600 border-none rounded btn hover:bg-green-900">Add to cart</button>
            </form>
            <span class="text-sm italic text-red-300">This is overrided template in starter-hello-elementor-mi themes/woocommerce</span>
            <div class="py-2 text-gray-400 border-gray-300 border-solid border-y-2">
                taxo-cat goes here : <a href="#" class="cursor-pointer hover:text-black">link to cat</a>
            </div>
        </div>
    </div>
    <div class="border border-gray-500 border-solid rounded-lg shadow-3xl">
        <div class="flex flex-row justify-center w-full h-full gap-2 px-3 pt-2 pb-3 rounded-lg tab-head">
            <div class="w-3/12 tab-nav " data-target="#content-desc">Description</div>
            <div class="w-3/12 tab-nav active" data-target="#content-review">Reviews (<?php echo $prd->get_review_count(); ?>)</div>
        </div>
        <div class="relative px-3 pt-0 pb-5 tab-body">
            <div id="content-desc" class="w-full tab-content ">
                <?php echo $prd->get_description(); ?>
            </div>
            <div id="content-review" class="flex flex-col w-full gap-2 tab-content active">
                <h5>Review</h5>
                <?php if ($prd->get_review_count() < 1) : ?>
                <p>
                    There are no reviews yet. Be the first to review <?php echo $prd->get_name(); ?>.
                    The email address will not be published. Required fields are marked with *
                </p>
                <?php endif; ?>
                <ul class="flex w-full gap-1 list-none">
                    <li class="relative flex items-center justify-center">
                       <input type="checkbox" name="" id="input-star-1" class="absolute w-6 h-6 opacity-50">
                       <label for="input-star-1" class="star-checkbox-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1 w-7 h-7">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                       </label>
                    </li>
                    <li class="relative flex items-center justify-center">
                       <input type="checkbox" name="" id="input-star-1" class="absolute w-6 h-6 opacity-50">
                       <label for="input-star-2" class="star-checkbox-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1 w-7 h-7">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                       </label>
                    </li>
                    <li class="relative flex items-center justify-center">
                       <input type="checkbox" name="" id="input-star-1" class="absolute w-6 h-6 opacity-50">
                       <label for="input-star-3" class="star-checkbox-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1 w-7 h-7">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                       </label>
                    </li>
                    <li class="relative flex items-center justify-center">
                       <input type="checkbox" name="" id="input-star-1" class="absolute w-6 h-6 opacity-50">
                       <label for="input-star-4" class="star-checkbox-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1 w-7 h-7">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                       </label>
                    </li>
                    <li class="relative flex items-center justify-center">
                       <input type="checkbox" name="" id="input-star-1" class="absolute w-6 h-6 opacity-50">
                       <label for="input-star-5" class="star-checkbox-label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1 w-7 h-7">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                            </svg>
                       </label>
                    </li>
                </ul>
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1 w-7 h-7">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                    </svg> -->
                <?php
                    // print("<pre>".print_r($prd->get_reviews_allowed(), true)."</pre>")."<br>";
                    // print("<pre>".print_r($prd->get_rating_counts(), true)."</pre>")."<br>";
                    // print("<pre>".print_r($prd->get_average_rating(), true)."</pre>")."<br>";
                    // print("<pre>".print_r($prd->get_review_count(), true)."</pre>")."<br>";
                    // echo $prd->get_rating_counts()."<br>";
                    // echo $prd->get_average_rating()."<br>";
                    // echo $prd->get_review_count()."<br>";
                ?>
            </div>
        </div>
    </div>

    <?php
    // do_action( 'woocommerce_after_single_product_summary' );
    // do_action( 'woocommerce_after_single_product' );
    ?>
</div>