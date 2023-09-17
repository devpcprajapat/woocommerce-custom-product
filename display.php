<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Show the images below the product images in the cart
add_filter('woocommerce_cart_item_thumbnail', 'display_custom_images_in_cart_thumbnail', 10, 3);
function display_custom_images_in_cart_thumbnail($product_thumbnail, $cart_item, $cart_item_key) {
    if (!empty($cart_item['unique_key'])) {
        $product_id = $cart_item['product_id'];
        $product_key = 'product_' . $product_id;
        $product_images = WC()->session->get('custom_uploaded_images', []);
        echo '<div class="cart-custom-images">';
        foreach ($product_images[$product_key] as $product) {
           echo '<a href="'.$product['guid'].'" target="_blank"><img src="'.$product['guid'].'" /></a>';
        }
        echo '</div>';
    }
    return $product_thumbnail;
}

// Admin orders: Display linked buttons + the links of the image files
add_action('woocommerce_after_order_itemmeta', 'backend_image_links_after_order_itemmeta', 10, 3);
function backend_image_links_after_order_itemmeta($item_id, $item, $product){
    if (is_admin() && $item->is_type('line_item') && $file_data = $item->get_meta('_img_files')) {
        foreach ($file_data as $image) {
            echo '<a href="' . $image['guid'] . '" target="_blank" class="button">' . __("View") . '</a>';
            echo '<img src="' . $image['guid'] . '" style="width:150px; height:auto; border:1px solid #ddd; margin:5px;" /><br/>';
        }
    }
}