<?php
function set_current_date_for_sending() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mail_send_limit';
    $db_date = new DateTime($wpdb->get_var("SELECT cur_date FROM $table_name WHERE id = 1"));
    $current_date = new DateTime();
    $interval = $current_date->diff($db_date);
    if ($interval->days > 0 || $interval->h > 24) {
        $number_value = $wpdb->get_var("SELECT number_value FROM $table_name WHERE id = 1");
        $wpdb->update($table_name, array(
            'number_left' => $number_value,
            'cur_date' => date('Y-m-d')
        ), array('id' => 1));
    }
}
add_action('init', 'set_current_date_for_sending');
