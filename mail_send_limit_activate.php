<?php
function mail_send_limit_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mail_send_limit';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        number_value mediumint(9) NOT NULL,
        number_left mediumint(9) NOT NULL,
        cur_date DATE NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $wpdb->insert($table_name, array('id' => 1, 'number_value' => 0, 'number_left' => 0, 'cur_date' => date('Y-m-d')));
}
register_activation_hook(__FILE__, 'mail_send_limit_activate');
