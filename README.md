# mail-send-limit
This is a WordPress plugin designed to limit the number of email sends from your website. Upon installation, it creates a table in the database with the following columns:

1. ID - Record identifier
2. number_value - Total number of sends
3. number_left - Remaining number of sends
4. cur_date - Current date

The plugin's settings page can be found in the WordPress admin area under Settings -> Mail Send Limit. Here, you can set the daily email send limit and check how many sends are remaining. Each day, the available sends automatically reset to the configured limit.

There are two functions available for using the plugin's features:

1. `get_mail_send_limit()` - This function allows you to get the number of sends remaining for today.

2. `set_mail_send_limit()` - This function decreases the available sends by 1 after each email send.

These functions help you control and limit the number of email sends from your website.
