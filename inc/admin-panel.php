<?php
/**
 * Admin Panel for Mohtawa Theme
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// Exit if accessed directly
if (!defined("ABSPATH")) {
    exit;
}

/**
 * Add top-level menu page for Mohtawa Theme.
 */
function mohtawa_add_admin_menu() {
    add_menu_page(
        __("Mohtawa Options", "mohtawa"),
        __("Mohtawa", "mohtawa"),
        "manage_options",
        "mohtawa-options",
        "mohtawa_options_page_html",
        "dashicons-admin-generic",
        6
    );
}
add_action("admin_menu", "mohtawa_add_admin_menu");

/**
 * Display the Mohtawa options page HTML.
 */
function mohtawa_options_page_html() {
    // Check user capabilities
    if (!current_user_can("manage_options")) {
        return;
    }

    // Add error/update messages

    // Check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET["settings-updated"])) {
        // Add settings saved message with the class of "updated" for the CSS
        add_settings_error("mohtawa_messages", "mohtawa_message", __("Settings Saved", "mohtawa"), "updated");
    }

    // Show error/update messages
    settings_errors("mohtawa_messages");
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "mohtawa_options"
            settings_fields("mohtawa_options");
            // output setting sections and their fields
            // (sections are added at the top of the build_options_page function)
            do_settings_sections("mohtawa-options");
            // output save settings button
            submit_button(__("Save Settings", "mohtawa"));
            ?>
        </form>
    </div>
    <?php
}

/**
 * Register Mohtawa Theme settings.
 */
function mohtawa_settings_init() {
    // Register a new setting for "mohtawa" page.
    register_setting("mohtawa_options", "mohtawa_options");

    // Register a new section in the "mohtawa" page.
    add_settings_section(
        "mohtawa_section_general",
        __("General Settings", "mohtawa"),
        "mohtawa_section_general_callback",
        "mohtawa-options"
    );

    // Register a new field in the "mohtawa_section_general" section, with the setting "mohtawa_options".
    add_settings_field(
        "mohtawa_field_logo",
        __("Site Logo", "mohtawa"),
        "mohtawa_field_logo_callback",
        "mohtawa-options",
        "mohtawa_section_general",
        [
            "label_for" => "mohtawa_field_logo",
            "class" => "mohtawa_row",
            "mohtawa_custom_data" => "custom",
        ]
    );

    add_settings_field(
        "mohtawa_field_color_scheme",
        __("Color Scheme", "mohtawa"),
        "mohtawa_field_color_scheme_callback",
        "mohtawa-options",
        "mohtawa_section_general",
        [
            "label_for" => "mohtawa_field_color_scheme",
            "class" => "mohtawa_row",
            "mohtawa_custom_data" => "custom",
        ]
    );
}
add_action("admin_init", "mohtawa_settings_init");

/**
 * General section callback function.
 */
function mohtawa_section_general_callback() {
    echo 
        __("These are the general settings for your Mohtawa theme.", "mohtawa");
}

/**
 * Logo field callback function.
 */
function mohtawa_field_logo_callback($args) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option("mohtawa_options");
    ?>
    <input type="text" id="<?php echo esc_attr($args["label_for"]); ?>" name="mohtawa_options[<?php echo esc_attr($args["label_for"]); ?>]" value="<?php echo isset($options[$args["label_for"]]) ? esc_attr($options[$args["label_for"]]) : ""; ?>">
    <p class="description">
        <?php esc_html_e("Enter the URL of your site logo.", "mohtawa"); ?>
    </p>
    <?php
}

/**
 * Color scheme field callback function.
 */
function mohtawa_field_color_scheme_callback($args) {
    $options = get_option("mohtawa_options");
    ?>
    <select id="<?php echo esc_attr($args["label_for"]); ?>" name="mohtawa_options[<?php echo esc_attr($args["label_for"]); ?>]">
        <option value="light" <?php selected(isset($options[$args["label_for"]]) ? $options[$args["label_for"]] : "", "light"); ?>><?php esc_html_e("Light", "mohtawa"); ?></option>
        <option value="dark" <?php selected(isset($options[$args["label_for"]]) ? $options[$args["label_for"]] : "", "dark"); ?>><?php esc_html_e("Dark", "mohtawa"); ?></option>
    </select>
    <p class="description">
        <?php esc_html_e("Select the color scheme for your theme.", "mohtawa"); ?>
    </p>
    <?php
}


