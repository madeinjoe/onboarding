<?php

/**
 * Template Name: For Task Javascript Only
 *
 */


defined('ABSPATH') || die('Direct Access not allowed');

get_header();

$limit = 12;

while (have_posts()) :
    the_post();
?>
    <main id="main-one" class="flex flex-col items-center min-h-screen gap-2 bg-gray-100">
        <div class="container">
            <div id="div-input-alter" class="flex w-full gap-2 mb-2">
                <select name="n-select-by" id="select-by" class="form-control w-fit">
                    <option value="by-id">select by id</option>
                    <option value="by-class">select by class</option>
                </select>
                <select name="n-select-dom" id="select-dom" class="form-control w-fit">
                    <option value="">Select Element</option>
                    <option value="prd-div">Product div</option>
                    <option value="prd-title">Product Title</option>
                    <option value="prd-price">Product Price</option>
                    <option value="prd-img">Product Image</option>
                </select>
                <select name="n-select-prd" id="select-prd" class="form-control w-fit">
                    <option value="">Select Product</option>
                    <option value="all">All Product</option>
                    <?php for ($opt = 1; $opt <= $limit; $opt++) : ?>
                        <option value="<?php echo $opt ?>">Product <?php echo $opt; ?></option>
                    <?php endfor; ?>
                </select>
                <!-- <select name="n-select-attr" id="select-attr" class="form-control w-fit">
                    <option value="">Select Attribute</option>
                    <option value="title">title</option>
                    <option value="d-id">data-id</option>
                    <option value="d-name">data-name</option>
                    <option value="d-other">data-other</option>
                </select> -->
                <input type="text" id="change-dom-html" name="n-change-dom-html" class="form-control w-fit" placeholder="Change HTML into DOM.." />
                <input type="text" id="add-dom-class" name="n-add-dom-class" class="form-control w-fit" placeholder="Class to add to DOM.." />
                <input type="text" id="add-attr-name" name="n-add-attr-name" class="form-control w-fit" placeholder="Attribute name to add.." />
                <input type="text" id="add-attr-value" name="n-add-attr-value" class="form-control w-fit" placeholder="Attribute value to add.." />
            </div>
            <div id="div-button-alter" class="flex w-full gap-2">
                <button id="btn-get-dom" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Get DOM</button>
                <button id="btn-change-html" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Change HTML</button>
                <button id="btn-add-html" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Add HTML</button>
                <button id="btn-add-class" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Add Class</button>
                <button id="btn-add-attr-name" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Change Attribute Val</button>
                <button id="btn-add-attr-value" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Add Attribute</button>
                <button id="launch-event-clicked" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Launch Custom Event</button>
                <button id="launch2-event-clicked" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Launch 2 Custom Event</button>
                <span id="second-event-trigger"></span>
            </div>
            <div id="input-ls" class="flex w-full mt-2 border-[1px] border-black gap-2">
                <input type="text" id="store-ls" name="store-ls" class="form-control w-fit" placeholder="Input Value to store in local.." />
                <button id="set-local-storage" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Save to localStorage</button>
                <button id="get-local-storage" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Get from localStorage</button>
            </div>
            <div id="input-cookie" class="flex w-full mt-2 border-[1px] border-black gap-2">
                <input type="text" id="store-cookie" name="store-cookie" class="form-control w-fit" placeholder="Input Value to store in local.." />
                <button id="set-cookie" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Write Cookie</button>
                <button id="get-cookie" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Read Cookie</button>
                <button id="del-cookie" class="bg-gray-300 btn hover:bg-gray-400 border-[1px] border-gray-300">Delete Cookie</button>
            </div>
            <div id="div-one" class="pt-5 pb-3 grid grid-flow-row grid-cols-12 gap-3 class-div-one border-[1px] border-red-300">
                <?php for ($prd = 1; $prd <= $limit; $prd++) : ?>
                    <div id="prd-div-<?php echo $prd; ?>" class="flex flex-col w-full col-span-2 gap-2 overflow-hidden bg-white rounded-t-lg rounded-b-md class-prd-div">
                        <div id="prd-img-<?php echo $prd; ?>" class="w-full bg-sky-200 min-h-[5rem]"></div>
                        <div class="flex flex-col px-2 pt-1 pb-2 prd-body">
                            <span id="prd-title-<?php echo $prd; ?>" class="w-full font-light tracking-wide text-justify text-black class-prd-title">Product No. <?php echo $prd; ?></span>
                            <span id="prd-price-<?php echo $prd; ?>" class="w-full text-sm font-medium text-black class-prd-price text-start">Rp<?php echo $prd . '000.00'; ?></span>
                            <div id="prd-div-html-<?php echo $prd; ?>" class="class-prd-div-html" data-extra="prd-extra-<?php echo $prd; ?>">Change this if Product Div Selected when "change html"</div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </main>

<?php
endwhile;
get_footer();
