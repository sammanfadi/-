
/**
 * Mohtawa Theme Admin JavaScript
 */

(function($) {
    $(document).ready(function() {

        // Media Uploader
        $(".mohtawa-media-upload-button").on("click", function(e) {
            e.preventDefault();
            var button = $(this);
            var image = wp.media({ 
                title: "Upload Image",
                multiple: false
            }).open()
            .on("select", function(e){
                var uploaded_image = image.state().get("selection").first();
                var image_url = uploaded_image.toJSON().url;
                button.prev("input[type=\"text\"]").val(image_url);
                button.next(".mohtawa-image-preview").attr("src", image_url).show();
            });
        });

        // Color Picker
        $(".mohtawa-color-picker").wpColorPicker();

        // Tabs in admin panel
        $(".mohtawa-admin-tabs a").on("click", function(e) {
            e.preventDefault();
            var tab = $(this).attr("href");
            $(".mohtawa-admin-tabs a").removeClass("nav-tab-active");
            $(this).addClass("nav-tab-active");
            $(".mohtawa-admin-tab-content").hide();
            $(tab).show();
        });

        // Initialize the first tab
        $(".mohtawa-admin-tabs a:first").trigger("click");

        // Repeatable fields
        $(".mohtawa-add-repeatable").on("click", function(e) {
            e.preventDefault();
            var field = $(this).closest(".mohtawa-repeatable-field");
            var new_field = field.clone();
            new_field.find("input").val("");
            field.after(new_field);
        });

        $(document).on("click", ".mohtawa-remove-repeatable", function(e) {
            e.preventDefault();
            $(this).closest(".mohtawa-repeatable-field").remove();
        });

    });
})(jQuery);

