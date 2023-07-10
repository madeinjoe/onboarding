<?php

namespace Custom\Setup\Mail;

defined('ABSPATH') || die('Direct access not allowed');

class CustomMail {
    public function __construct () {
        add_action('phpmailer_init', [$this, 'sandboxMailtrap']);
    }

    public function sandboxMailtrap($phpmailer) {
        $phpmailer->isSMTP();
        $phpmailer->Host        = 'sandbox.smtp.mailtrap.io';
        $phpmailer->Port        = 2525;
        $phpmailer->SMTPAuth    = true;
        $phpmailer->Username    = 'a680de2ccde62d';
        $phpmailer->Password    = '9ee904f570163b';
        // $phpmailer->From        = 'sender@testmail.com';
        // $phpmailer->FromName    = 'Test Name';
        $phpmailer->setFrom('sender@testmail.com', 'Test Sender');
        $phpmailer->SMTPSecure  = 'tls';
    }
}

// Initialize
new CustomMail();
