<?php
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
