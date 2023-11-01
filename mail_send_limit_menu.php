<?php
function mail_send_limit_menu() {
    add_options_page('Mail Send Limit', 'Mail Send Limit', 'manage_options', 'mail_send_limit', 'mail_send_limit_page');
}
add_action('admin_menu', 'mail_send_limit_menu');
