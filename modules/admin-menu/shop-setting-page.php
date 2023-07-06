<?php
require_once MODULES_DIR . '/helper/custom-input-helper.php';

use \Custom\Helper\CustomInput as CI;

?>

<div style="margin: 1.25rem 1.25rem 1.25rem 0; display: flex; flex-direction: column; gap: 0.75rem;">
    <h1 style="font-size: 1.25rem; line-height: 1.75rem;"><?php echo get_admin_page_title() ?? 'Shop\'s Setting'; ?></h1>
    <hr>
    <div style="display: flex; flex-direction: column; gap: 0.5rem">
        <h2 style="font-size: 1rem; line-height: 1.5rem; font-weight: 400;">Custom WP Options : </h2>
        <table style="width: 50%; border: 1px solid rgba(0, 0, 0, 1); border-collapse: collapse;">
            <thead style="text-align: left;">
                <th style="border: 1px solid rgba(0, 0, 0, 1); border-collapse: collapse; padding: 0.5rem 0.5rem;">Name</th>
                <th style="border: 1px solid rgba(0, 0, 0, 1); border-collapse: collapse; padding: 0.5rem 0.5rem;">Value</th>
            </thead>
            <tbody>
                <?php
                $mbData = $meta;

                foreach ($meta as $key => $value) {
                    $mbData[$key]['meta-key'] = $key;
                    $mbData[$key]['meta-value'] = get_option($key);
                ?>

                    <tr style="border: 1px solid rgba(0, 0, 0, 1); border-collapse: collapse;">
                        <td style="border: 1px solid rgba(0, 0, 0, 1); border-collapse: collapse; padding: 0.5rem 0.5rem;"><?php echo $key; ?></td>
                        <td style="border: 1px solid rgba(0, 0, 0, 1); border-collapse: collapse; padding: 0.5rem 0.5rem;"><?php echo $mbData[$key]['meta-value']; ?></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
    <hr>
    <form style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input name='action' type="hidden" value='change_shop_setting'>
        <?php
        /** Render metaboxes */
        CI::renderAllInput($mbData, true, '_shop_setting_metabox', '_shop_setting_metabox');
        ?>
        <button type="submit" style="width: -moz-fit-content; width: fit-content; display: flex; align-items: center; justify-content: center; padding: 0.25rem 0.5rem; text-align: justify; font-size: 1rem; line-height: 1.5rem; font-weight: 700; background-color: rgba(96, 165, 250, 1);">Save Changes</button>
    </form>
</div>