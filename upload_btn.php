<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Add the custom field to the product page
add_action('woocommerce_before_add_to_cart_button', 'display_additional_product_fields', 9);
function display_additional_product_fields(){
   echo '
    <p class="form-row validate-required" id="image">
        <label for="file_field">'. __("Upload Images") .'
            <input type="file" name="images[]" id="custom_product_image" accept="image/*" multiple>
        </label>
        <div class="custom-product-image-preview"></div>
    </p>
    <input type="hidden" id="custom_image_uploaded" name="custom_image_uploaded" value="0">';
}