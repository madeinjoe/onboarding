<?php
require_once MODULES_DIR . '/helper/custom-input.php';

use \Custom\Input\CustomInput as CI;
?>

<div style="margin: 1.25rem 1.25rem 1.25rem 0; display: flex; flex-direction: column; gap: 0.75rem;">
    <h1 style="font-size: 1.25rem; line-height: 1.75rem;"><?php echo get_admin_page_title() ?? 'Shop\'s Setting'; ?></h1>
    <hr>
    <form style="display: flex; flex-direction: column; gap: 0.5rem;" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input name='action' type="hidden" value='change_shop_setting'>
        <?php
        $mbData = $meta;
        foreach ($meta as $key => $value) {
            $mbData[$key]['meta-key'] = $key;
            $mbData[$key]['meta-value'] = get_option($key);
        }

        /** Render metaboxes */
        $this->customInput->renderAllInput($mbData, true, '_shop_setting_metabox', '_shop_setting_metabox'); // renderAllInput is a non-static, automaticly added _nonce into attribute name of nonce input
        ?>
        <button type="submit" style="width: -moz-fit-content; width: fit-content; display: flex; align-items: center; justify-content: center; padding: 0.25rem 0.5rem; text-align: justify; font-size: 1rem; line-height: 1.5rem; font-weight: 700; background-color: rgba(96, 165, 250, 1);">Save Changes</button>
    </form>
</div>