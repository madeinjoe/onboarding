<?php
defined('ABSPATH') || die('Direct Access not allowed');

class AdmissionPage extends RegisterPost
{

    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'loginPage']);
        add_action('wp_ajax_custom_login', [$this, 'loginHandle']);
        add_action('wp_ajax_nopriv_custom_login', [$this, 'loginHandle']);
    }

    public function loginPage()
    {
        $permalink = 'custom-login';
        $template = 'template-parts/custom-login.php';
        $args = [
            'post_name' => $permalink,
            'post_author' => get_current_user_id(),
            'post_date' => date('Y-m-d H:i:s', time()),
            'post_date_gmt' => gmdate('Y-m-d H:i:s', time()),
            'post_status' => 'publish',
            'post_type' => 'page',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_parent' => 0,
        ];

        $this->makePost($permalink, 'Login Here', 'page', ['administrator'], $template, $args);
    }

    public function loginHandle()
    {
        /** Verify nonce */
        if (!isset($_POST['_custom_login']) || !wp_verify_nonce($_POST['_custom_login'], '_custom_login_nonce')) {
            $response = [
                'success' => false,
                'message' => 'Invalid nonce token.',
                'errors' => [
                    'nonce' => [
                        'nonce token is invalid'
                    ]
                ]
            ];

            $code = 400;
        }

        if (isset($_POST['login-username']) && isset($_POST['login-password'])) {
            $credentials = [
                'user_login' => sanitize_user($_POST['login-username']),
                'user_password' => sanitize_text_field($_POST['login-password']),
                'remember' => $_POST['login-remember'] ?? false
            ];

            // $user = wp_authenticate($credentials['user_login'], $credentials['user_password']);
            // wp_set_auth_cookie($user->ID, $credentials['remember'], is_ssl());
            // do_action('wp_login', $user->user_login, $user);

            $check = wp_signon($credentials, true);

            if (is_wp_error($check)) {
                $response = [
                    'success' => false,
                    'message' => 'Credentials is invalid.',
                    'cred' => $credentials
                ];

                $code = 400;
            } else {
                wp_set_current_user($check->ID);
                wp_set_auth_cookie($check->ID, $credentials['remember'], is_ssl());
                do_action('wp_login', $check->data->user_login, $check);

                $response = [
                    'success' => true,
                    'message' => 'Success Login.',
                    'data' => [
                        'session' => wp_get_all_sessions(),
                        'check' => $check,
                        'redirect' => home_url('/dashboard')
                    ]
                ];

                $code = 200;
            }

            // $getUser = get_user_by('login', sanitize_user($_POST['login-username']));
            // if ($getUser) {
            //     $verify = wp_check_password(sanitize_text_field($_POST['login-password']), $getUser->user_pass);

            //     if ($verify) {
            //         $credentials = [
            //             'user_login' => sanitize_user($_POST['login-username']),
            //             'user_password' => sanitize_text_field($_POST['login-password']),
            //             'remember' => true
            //         ];

            //         // $user = wp_authenticate($credentials['user_login'], $credentials['user_password']);
            //         // wp_set_auth_cookie($user->ID, $credentials["remember"], $secure_cookie);
            //         // do_action('wp_login', $user->user_login, $user);

            //         $check = wp_signon($credentials, true);

            //         if (is_wp_error($check)) {
            //             $response = [
            //                 'success' => false,
            //                 'message' => 'Failed Login.'
            //             ];

            //             $code = 400;
            //         } else {
            //             wp_set_current_user($check->ID);
            //             wp_set_auth_cookie($check->ID, $credentials["remember"]);
            //             do_action('wp_login', $check->data->user_login, $check);

            //             $response = [
            //                 'success' => true,
            //                 'message' => 'Success Login.',
            //                 'data' => [
            //                     'session' => wp_get_all_sessions(),
            //                     'check' => $check,
            //                     'redirect' => home_url('/dashboard')
            //                 ]
            //             ];

            //             $code = 200;
            //         }
            //     } else {
            //         $response = [
            //             'success' => false,
            //             'message' => 'Invalid Credentials.',
            //             'errors' => [
            //                 'credentials' => [
            //                     'Username or password is invalid.'
            //                 ]
            //             ]
            //         ];

            //         $code = 400;
            //     }
            // } else {
            //     $response = [
            //         'success' => false,
            //         'message' => 'Invalid Credentials.',
            //         'errors' => [
            //             'credentials' => [
            //                 'Username not found.'
            //             ]
            //         ]
            //     ];

            //     $code = 400;
            // }
        } else {
            if (!isset($_POST['login-username'])) {
                $errorMsg['username'] = 'Username is required.';
            }

            if (!isset($_POST['login-password'])) {
                $errorMsg['password'] = 'Password is required.';
            }

            $response = [
                'success' => false,
                'message' => 'Invalid Credential.',
                'errors' => $errorMsg
            ];

            $code = 400;
        }


        wp_send_json($response, $code);
    }
}

// Initialize
new AdmissionPage();
