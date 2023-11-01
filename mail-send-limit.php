<?php
/*
Plugin Name: Mail Send Limit
Description: Setting a limit for sending emails
Version: 1.0
Author: Dmytro Shkatula
*/

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

function mail_send_limit_menu() {
    add_options_page('Mail Send Limit', 'Mail Send Limit', 'manage_options', 'mail_send_limit', 'mail_send_limit_page');
}
add_action('admin_menu', 'mail_send_limit_menu');

function mail_send_limit_page() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'mail_send_limit';

    if (isset($_POST['mail_send_limit_update'])) {
        $number_value = intval($_POST['number_value']);
        $wpdb->update($table_name, array(
            'number_value' => $number_value,
            'number_left' => $number_value
        ), array('id' => 1));
    }

    $number_value = $wpdb->get_var("SELECT number_value FROM $table_name WHERE id = 1");
    $number_left = $wpdb->get_var("SELECT number_left FROM $table_name WHERE id = 1");
    $db_date = $wpdb->get_var("SELECT cur_date FROM $table_name WHERE id = 1");
    ?>
    <div class="wrap">
        <h2 style="margin-bottom: 18px">Mail Send Limit</h2>
        <form method="post" action="">
            <h4>Enter the number of emails:</h4>
            <input type="number" name="number_value" id="number_value" value="<?php echo $number_value; ?>">
            <input style="padding: 7px 15px; background: #0a58ca; color: #fff; border-radius: 5px; border: none;" type="submit" name="mail_send_limit_update" value="Update">
        </form>
        <h3 style="margin-bottom: 12px;">The number of emails left to send per day as of <span style="color: orangered;"><?php echo $db_date; ?></span></h3>
        <h4 style="font-size: 18px"><?php echo sprintf('<span style="color: orangered;">%s</span> mails', $number_left); ?></h4>
    </div>
    <?php
}

function get_mail_send_limit() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mail_send_limit';

    $number_left = $wpdb->get_var("SELECT number_left FROM $table_name WHERE id = 1");

    return $number_left;
}

function set_mail_send_limit() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mail_send_limit';

    $number_left = $wpdb->get_var("SELECT number_left FROM $table_name WHERE id = 1");

    $wpdb->update($table_name, array(
        'number_left' => (int)$number_left - 1
    ), array('id' => 1));
}

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