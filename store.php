<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Store uploaded images in the session
add_filter('woocommerce_add_cart_item_data', 'add_custom_fields_data_as_custom_cart_item_data', 10, 2);
function add_custom_fields_data_as_custom_cart_item_data($cart_item_data, $product_id){
    if (isset($_FILES['images']) && !empty($_FILES['images'])) {
        $allowed_extensions = array('jpg', 'jpeg', 'png'); // Add allowed file extensions here

        $uploaded_images = [];
        foreach ($_FILES['images']['name'] as $key => $value) {
            if ($_FILES['images']['error'][$key] === 0) {
                $file_extension = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);

                // Check if the file extension is in the allowed list
                if (in_array(strtolower($file_extension), $allowed_extensions)) {
                    $upload = wp_upload_bits($_FILES['images']['name'][$key], null, file_get_contents($_FILES['images']['tmp_name'][$key]));
                    $filetype = wp_check_filetype(basename($upload['file']), null);
                    $upload_dir = wp_upload_dir();
                    $upl_base_url = is_ssl() ? str_replace('http://', 'https://', $upload_dir['baseurl']) : $upload_dir['baseurl'];
                    $base_name = basename($upload['file']);
                    $uploaded_images[] = [
                        'guid' => $upl_base_url . '/' . _wp_relative_upload_path($upload['file']),
                        'file_type' => $filetype['type'],
                        'file_name' => $base_name,
                        'title' => ucfirst(preg_replace('/\.[^.]+$/', '', $base_name)),
                    ];
                } else {
                    // Display an error message if the file extension is not allowed
                    wc_add_notice('Please upload files with the following extensions: jpg, jpeg, png', 'error');
                }
            }
        }
        $product_key = 'product_' . $product_id;
        $product_images = WC()->session->get('custom_uploaded_images', []);
        $product_images[$product_key] = $uploaded_images;
        WC()->session->set('custom_uploaded_images', $product_images);
        $cart_item_data['unique_key'] = md5(microtime() . rand()); // Avoid merging items
    }
    return $cart_item_data;
}


// Save Image data as order item meta data
add_action('woocommerce_checkout_create_order_line_item', 'custom_field_update_order_item_meta', 20, 4);
function custom_field_update_order_item_meta($item, $cart_item_key, $values, $order){
    if (isset($values['unique_key'])) {
        $product_id = $values['product_id'];
        $product_key = 'product_' . $product_id;
        $product_images = WC()->session->get('custom_uploaded_images', []);
        if (!empty($product_images[$product_key])) {
            $item->update_meta_data('_img_files', $product_images[$product_key]);
            unset($product_images[$product_key]);
            WC()->session->set('custom_uploaded_images', $product_images);
        }
    }
}