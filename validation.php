<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}


// Add JavaScript to prevent adding to cart without a custom image
add_action('wp_footer', 'custom_image_validation_js');
function custom_image_validation_js() {
    ?>
    <script>
        jQuery(function($){
            // When the add to cart button is clicked
            $('.single_add_to_cart_button').click(function(e){
                // Check if a custom image has been uploaded
                var customImageInput = $('#custom_product_image')[0];
                if (customImageInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please upload a custom image before adding to cart.');
                } else {
                    var allowedExtensions = ['jpg', 'jpeg', 'png'];
                    var fileExtension = customImageInput.files[0].name.split('.').pop().toLowerCase();
                    if (allowedExtensions.indexOf(fileExtension) === -1) {
                        e.preventDefault();
                        alert('Please upload a JPG, JPEG, or PNG image only.');
                    } else {
                        $('#custom_image_uploaded').val('1');
                    }
                }
            });
        });
    </script>
    <?php
}

// Check if a custom image has been uploaded before adding to cart
add_filter('woocommerce_add_to_cart_validation', 'custom_image_validation', 10, 3);
function custom_image_validation($passed, $product_id, $quantity) {
    if ($_POST['custom_image_uploaded'] === '0') {
        wc_add_notice('Please upload a custom image before adding to cart.', 'error');
        return false;
    }
    return $passed;
}
