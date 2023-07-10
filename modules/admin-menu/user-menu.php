<?php

namespace Custom\WPMenu\User;

defined('ABSPATH') || die("Direct access not allowed");
require_once MODULES_DIR . '/helper/custom-input-helper.php';

use \Custom\Helper\CustomInput as CI;

class UserMenu {
    protected $userMetaKeys;

    public function __construct () {
        $this->userMetaKeys = [
            '_user_address' => [
                'label' => 'User Address',
                'type'  => 'textarea'
            ]
        ];

        add_action('user_new_form', [$this, 'userRenderMB']);
        add_action('user_new_form', [$this, 'userCurrentLogin']);
        add_action('show_user_profile', [$this, 'userRenderMB']);
        add_action('edit_user_profile', [$this, 'userRenderMB']);
        add_action('user_register', [$this, 'userSaveMB']);
        add_action('profile_update', [$this, 'userSaveMB']);
        add_filter( 'manage_users_columns', [$this, 'customColumn']);
        add_filter( 'manage_users_custom_column', [$this, 'customRow'], 10, 3);
    }

    public function userRenderMB ($user) {
        /** Check if this is user profile, edit user, or add_new_user screen */
        if (gettype($user) === 'string' || $user === 'add-new-user') {
            foreach($this->userMetaKeys as $key => $value) {
                $mbData[$key] = $value;
                $mbData[$key]['meta-key'] = $key;
                $mbData[$key]['meta-value'] = null;
            }
        } else {
            foreach($this->userMetaKeys as $key => $value) {
                $mbData[$key] = $value;
                $mbData[$key]['meta-key'] = $key;
                $mbData[$key]['meta-value'] = get_user_meta($user->ID, $key, true);
            }
        }

        // print("<pre>".print_r($mbData, true)."</pre>");
        // CI::renderAllInput($mbData, true, '_user_metabox', '_user_metabox');
        echo '<div>';
        echo '<h2>User extra information</h2>';
        echo '<table class="form-table" role="presentation">';
        echo '<tbody>';
        foreach ($mbData as $key => $values) {
            echo '<tr>';
            echo '<th><label for="mb_'.$values['meta-key'].'" >'.$values['label'].'</label></th>';
            if ($values['type'] === 'textarea') {
                echo '<td> <textarea id="mb_'.$values['meta-key'].'" name="'.$values['meta-key'].'" rows="5" cols="50">'.$values['meta-value'].'</textarea></td>';
            } else {
                echo '<td> <input type="text" id="mb_'.$values['meta-key'].'" name="'.$values['meta-key'].'" values="'.$values['meta-value'].'" /></td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    public function userSaveMB (Int $user_id) {
        /** Get current user */
        $currentUser = wp_get_current_user();

        /** Check current user capability */
        if (current_user_can('edit_user', $currentUser->ID)) {
            foreach ($this->userMetaKeys as $key => $values) {
                if ($values['type'] === 'textarea') {
                    $metaValue = sanitize_textarea_field($_POST[$key]);
                } else {
                    $metaValue = sanitize_text_field($_POST[$key]);
                }
                update_user_meta($user_id, $key, $metaValue);
            }
        } else {
            return wp_die(__('You have no permission to edit this user'), 'Not allowed');
        }
    }

    public function customColumn ($column_name) {
        $column_name['address'] = 'Address';
        return $column_name;
    }

    public function customRow ($output, $column_name, $user_id) {
        switch ($column_name) {
            case 'address' :
                return get_user_meta($user_id, '_user_address', true);
            default:
        }
        return $output;
    }

    public function userCurrentLogin () {
        /** Get current user */
        $currentUser = wp_get_current_user();

        // print("<pre>".print_r($currentUser, true)."</pre>");
        echo '<table class="form-table" role="presentation">';
        echo '<thead><tr><th>Data Key</th><th>Data Value</th></tr></thead>';
        echo '<tbody>';
        foreach ($currentUser->data as $key => $values) {
            echo '<tr>';
            echo '<td>'.$key.'</td>';
            echo '<td>'.$values.'</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}

// Initialized
new UserMenu();
