<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Admin new order email: Display linked buttons + the links of the image files
add_action('woocommerce_email_after_order_table', 'wc_email_new_order_custom_meta_data', 10, 4);
function wc_email_new_order_custom_meta_data($order, $sent_to_admin, $plain_text, $email){
    if ('new_order' === $email->id) {
        foreach ($order->get_items() as $item) {
            if ($file_data = $item->get_meta('_img_files')) {
                foreach ($file_data as $image) {
                    echo '<p>
                        <a href="' . $image['guid'] . '" target="_blank" class="button">' . __("Download Image") . '</a><br>
                        <pre><code style="font-size:12px; background-color:#eee; padding:5px;">' . $image['guid'] . '</code></pre>
                    </p><br>';
                }
            }
        }
    }
    if (!$sent_to_admin && 'customer_processing_order' === $email->id) {
        foreach ($order->get_items() as $item) {
            if ($file_data = $item->get_meta('_img_files')) {
                foreach ($file_data as $image) {
                    echo '<p>
                        <a href="' . $image['guid'] . '" target="_blank" class="button">' . __("Download Image") . '</a><br>
                        <pre><code style="font-size:12px; background-color:#eee; padding:5px;">' . $image['guid'] . '</code></pre>
                    </p><br>';
                }
            }
        }
    }
}