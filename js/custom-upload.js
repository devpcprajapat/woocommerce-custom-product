jQuery(document).ready(function($) {
    var fileInput = $('#custom_product_image');
    var imagePreview = $('.custom-product-image-preview');
    fileInput.on('change', function() {
        imagePreview.html('');
        var files = this.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = document.createElement('img');
                    img.src = event.target.result;
                    img.alt = 'Custom Product Image';
                    imagePreview.append(img);
                };
                reader.readAsDataURL(file);
            }
        }
    });
});