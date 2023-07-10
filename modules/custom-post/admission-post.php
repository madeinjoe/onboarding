<?php
defined('ABSPATH') || die('Direct Access not allowed');

class AdmissionPage extends RegisterPost
{

    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'loginPage']);
        add_action('after_setup_theme', [$this, 'registrationPage']);
        add_action('wp_ajax_custom_registration', [$this, 'registrationHandle']);
        add_action('wp_ajax_nopriv_custom_registration', [$this, 'registrationHandle']);
        add_action('wp_ajax_custom_login', [$this, 'loginHandle']);
        add_action('wp_ajax_nopriv_custom_login', [$this, 'loginHandle']);
        add_action('wp_mail_failed', [$this, 'wpfailerror'], 10, 1);
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

    public function registrationPage()
    {
        /** Custom registration */
        $permalink = 'custom-registration';
        $template = 'template-parts/custom-registration.php';
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

        /** Custom activation */
        $activationPermalink = 'custom-activation';
        $activationTemplate = 'template-parts/custom-activation.php';
        $activationAargs = [
            'post_name' => $activationPermalink,
            'post_author' => get_current_user_id(),
            'post_date' => date('Y-m-d H:i:s', time()),
            'post_date_gmt' => gmdate('Y-m-d H:i:s', time()),
            'post_status' => 'publish',
            'post_type' => 'page',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_parent' => 0,
        ];

        $this->makePost($activationPermalink, 'Your account is activated!', 'page', ['administrator'], $activationTemplate, $activationAargs);
        $this->makePost($permalink, 'Register Now!', 'page', ['administrator'], $template, $args);
    }

    public function loginHandle()
    {
        /** Verify nonce */
        if (!isset($_POST['_custom_login_nonce']) || !wp_verify_nonce($_POST['_custom_login_nonce'], '_custom_login')) {
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
            wp_send_json($response, $code);
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
                    'message' => 'Credentials is invalid.'
                ];

                $code = 400;
            } else {
                wp_set_current_user($check->ID);
                wp_set_auth_cookie($check->ID, $credentials['remember'], is_ssl());
                do_action('wp_login', $check->data->user_login, $check);

                switch (strtolower($check->roles[0])) {
                    case 'subscriber':
                        $postForSubs = get_page_by_path('hello-subscriber', 'object', 'post');
                        $redirect = get_permalink($postForSubs->ID);
                        break;
                    case 'editor':
                    case 'contributor':
                        $redirect = admin_url('edit.php');
                        break;
                    default:
                        $redirect = admin_url('/');
                }

                $response = [
                    'success' => true,
                    'message' => 'Success Login.',
                    'data' => [
                        'session' => wp_get_all_sessions(),
                        'check' => $check,
                        'redirect' => $redirect
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

    public function registrationHandle ()
    {
        /** Verify nonce */
        if (!isset($_POST['_custom_registration_nonce']) || !wp_verify_nonce($_POST['_custom_registration_nonce'], '_custom_registration')) {
            $response = [
                'success' => false,
                'message' => 'Invalid nonce token.',
                'errors' => [
                    'nonce' => [
                        'nonce token is invalid'
                    ]
                ]
            ];
            return wp_send_json($response, 400);
        }

        $validate = $this->_validate_registration($_POST);
        if (!$validate['is_valid']) {
            $response = [
                'success' => false,
                'test' => 'test validate',
                'message' => 'Invalid user input.',
                'errors' => $validate['errors']
            ];
            return wp_send_json($response, 400);
        } else {
            /** Add user */
            $addUser = wp_insert_user([
                'user_login' => sanitize_user($_POST['registration-username']),
                'user_email' => sanitize_email($_POST['registration-email']),
                'user_pass' => wp_hash_password($_POST['registration-password']),
            ]);

            /** If success result is user ID and WP_Error if failed */
            if (is_wp_error($addUser)) {
                $response = [
                    'success' => false,
                    'message' => $addUser->get_error_message(),
                    'errors' => $addUser->get_error_messages()
                ];
                return wp_send_json($response, 400);
            } else {
                /** Set user role to subscriber */
                $thisUser = new WP_User($addUser);
                $thisUser->set_role('subscriber');

                /** Update activation code */
                $activationCode = wp_hash($addUser.time());
                $activationPage = get_page_by_path('custom-activation', 'object', 'page');
                $activationUrl = add_query_arg(['acode' => $activationCode, 'user' => $addUser], get_permalink($activationPage->ID ?? 1));
                wp_update_user(['ID' => $addUser, 'user_activation_key' => $activationCode]);

                /** Send activation code */
                $headers[] = 'From: '.WPMS_MAIL_FROM_NAME.'<'.WPMS_MAIL_FROM.'>';
                wp_mail( sanitize_email($_POST['registration-email']), 'SUBJECT', 'Activation link : ' . $activationUrl, $headers );

                $response = [
                    'success' => false,
                    'message' => 'success adding user.',
                    'active_code' => $activationCode
                ];
                return wp_send_json($response, 200);
            }
        }
    }

    private function _validate_registration($request) {
        $response = [
            'is_valid' => true,
            'errors' => []
        ];

        /** Validate username */
        if (!isset($request['registration-username'])) {
            $response['is_valid'] = false;
            $response['errors']['registration-username'][] = 'username is required.';
        } else if (username_exists(sanitize_text_field($request['registration-username']))) {
            $response['is_valid'] = false;
            $response['errors']['registration-username'][] = 'username is required.';
        }

        /** validate email */
        if (!isset($request['registration-email'])) {
            $response['is_valid'] = false;
            $response['errors']['registraiton-email'][] = 'email is already used.';
        } else if (email_exists(sanitize_email($request['registration-email']))) {
            $response['is_valid'] = false;
            $response['errors']['registraiton-email'][] = 'email is already used.';
        } else if (!is_email(sanitize_email($request['registration-email']))) {
            $response['is_valid'] = false;
            $response['errors']['registraiton-email'][] =  'email is invalid.';
        }

        /** Validate password and confirmation */
        if (!isset($request['registration-password'])) {
            $response['is_valid'] = false;
            $response['errors']['registration-password'][] = 'password is required.';
        }
        if (!isset($request['registration-re-password'])) {
            $response['is_valid'] = false;
            $response['errors']['registration-re-password'][] = 'password confirmation is required.';
        } else if ($request['registration-re-password'] !== $request['registration-password']) {
            $response['is_valid'] = false;
            $response['errors']['registration-re-password'][] = 'password confirmation doesn\'t match.';
        }

        return $response;
    }

    public function wpfailerror ($error) {
        if ($error && is_wp_error($error)) {
            error_log("<pre>".print_r('wp_mail error : '.$error->errors['wp_mail_failed'][0], true)."</pre>");
        }
    }
}

// Initialize
new AdmissionPage();
