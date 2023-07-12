<?php
defined('ABSPATH') || die('Direct access not allowed');

class shopACF {
    public function __construct() {
        $this->shopOptionPage();
        add_action('the_post', [$this, 'shopRenderContact'], 10, 1);
    }

    public function shopOptionPage () {
        if (function_exists('acf_add_options_page')) {
			acf_add_options_page([
				"page_title" => "Shop ACF Settings",
				"menu_title" => "Shop ACF Settings",
				"menu_slug" => "shop-acf-settings",
				"capability" => "edit_posts",
				"redirect" => false,
			]);
        }
    }

    public function shopRenderContact ($page) {
        if (is_page('contact-us')) {
            $socialMedia = get_field('social_media_link', 'option');
            $email = get_field('contact_email', 'option');
            $phone = get_field('contact_phone', 'option');

            echo '<div class="container flex flex-col gap-2 p-2">';
            echo '<h1 class="font-bold">Contact</h1>';

            echo '<div class="flex gap-2">';
            echo "<div class=\"w-1/4 cusor-pointer flex flex-col items-center justify-center p-2 border-[10px] border-red-500 bg-gray-100 rounded hover:bg-gray-200\">";
            echo "<h2 class=\"font-medium uppercase\">Shop Email</h2>";
            echo $email;
            echo "</div>";

            echo "<div class=\"w-1/4 cusor-pointer flex flex-col items-center justify-center p-2 border-[10px] border-red-500 bg-gray-100 rounded hover:bg-gray-200\">";
            echo "<h2 class=\"font-medium uppercase\">Shop Phone Number</h2>";
            echo "(".$phone['code_area'].") - ".$phone['phone_number']."";
            echo "</div>";
            echo '</div>';

            echo '<h1 class="font-bold">Social Media</h1>';
            echo '<div class="flex gap-2">';
            foreach($socialMedia as $key => $values) {
                echo "<a href=\"".$values['social_media_url']."\" class=\"w-1/4 cursor-pointer p-2 border-[1px] border-red-400 bg-gray-100 rounded\">";
                echo "<div class=\"w-full flex items-center justify-center\">";
                echo $values['social_media_name'];
                echo "</div>";
                echo "</a>";
            }
            echo '</div>';
            echo '</div>';
        }
    }
}

// Initialize
new shopACF();
