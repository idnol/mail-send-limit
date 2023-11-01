<?php
function get_mail_send_limit() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mail_send_limit';

    $number_left = $wpdb->get_var("SELECT number_left FROM $table_name WHERE id = 1");

    return $number_left;
}
