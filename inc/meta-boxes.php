<?php
/**
 * Meta Boxes for Mohtawa Theme
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// Exit if accessed directly
if (!defined("ABSPATH")) {
    exit;
}

/**
 * Register meta boxes for the 'store' post type.
 */
function mohtawa_register_store_meta_boxes() {
    add_meta_box(
        "store_details",
        __("Store Details", "mohtawa"),
        "mohtawa_store_details_meta_box_callback",
        "store",
        "normal",
        "high"
    );
}
add_action("add_meta_boxes", "mohtawa_register_store_meta_boxes");

/**
 * Callback function for the store details meta box.
 */
function mohtawa_store_details_meta_box_callback($post) {
    // Add a nonce field so we can check for it later.
    wp_nonce_field("mohtawa_save_store_details_meta_box_data", "mohtawa_store_details_meta_box_nonce");

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $store_address = get_post_meta($post->ID, "_store_address", true);
    $store_phone = get_post_meta($post->ID, "_store_phone", true);
    $store_website = get_post_meta($post->ID, "_store_website", true);
    $store_latitude = get_post_meta($post->ID, "_store_latitude", true);
    $store_longitude = get_post_meta($post->ID, "_store_longitude", true);

    echo '<label for="store_address">' . __("Address", "mohtawa") . '</label>';
    echo '<input type="text" id="store_address" name="store_address" value="' . esc_attr($store_address) . '" size="25" />';

    echo '<label for="store_phone">' . __("Phone", "mohtawa") . '</label>';
    echo '<input type="text" id="store_phone" name="store_phone" value="' . esc_attr($store_phone) . '" size="25" />';

    echo '<label for="store_website">' . __("Website", "mohtawa") . '</label>';
    echo '<input type="text" id="store_website" name="store_website" value="' . esc_attr($store_website) . '" size="25" />';

    echo '<label for="store_latitude">' . __("Latitude", "mohtawa") . '</label>';
    echo '<input type="text" id="store_latitude" name="store_latitude" value="' . esc_attr($store_latitude) . '" size="25" />';

    echo '<label for="store_longitude">' . __("Longitude", "mohtawa") . '</label>';
    echo '<input type="text" id="store_longitude" name="store_longitude" value="' . esc_attr($store_longitude) . '" size="25" />';
}

/**
 * Save the meta box data when the post is saved.
 */
function mohtawa_save_store_details_meta_box_data($post_id) {
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if (!isset($_POST["mohtawa_store_details_meta_box_nonce"])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST["mohtawa_store_details_meta_box_nonce"], "mohtawa_save_store_details_meta_box_data")) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST["post_type"]) && "store" == $_POST["post_type"]) {
        if (!current_user_can("edit_page", $post_id)) {
            return;
        }
    } else {
        if (!current_user_can("edit_post", $post_id)) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that fields are set.
    if (isset($_POST["store_address"])) {
        // Sanitize user input.
        $my_data = sanitize_text_field($_POST["store_address"]);

        // Update the meta field in the database.
        update_post_meta($post_id, "_store_address", $my_data);
    }

    if (isset($_POST["store_phone"])) {
        $my_data = sanitize_text_field($_POST["store_phone"]);
        update_post_meta($post_id, "_store_phone", $my_data);
    }

    if (isset($_POST["store_website"])) {
        $my_data = sanitize_text_field($_POST["store_website"]);
        update_post_meta($post_id, "_store_website", $my_data);
    }

    if (isset($_POST["store_latitude"])) {
        $my_data = sanitize_text_field($_POST["store_latitude"]);
        update_post_meta($post_id, "_store_latitude", $my_data);
    }

    if (isset($_POST["store_longitude"])) {
        $my_data = sanitize_text_field($_POST["store_longitude"]);
        update_post_meta($post_id, "_store_longitude", $my_data);
    }
}
add_action("save_post", "mohtawa_save_store_details_meta_box_data");


