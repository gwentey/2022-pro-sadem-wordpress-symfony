<?php
defined('ABSPATH') || die();

/*******************************************************
 * Adding a group of settings fields to the top level page
 *******************************************************/
add_action('admin_init', 'settings_maxxess_settings');
/**
 * Registers a single setting
 */
function settings_maxxess_settings()
{

    /**
     * Register a single setting.
     * Instead of using multiple calls to register_setting() for each of our setting field,
     * we will declare a single setting, save all fields value in an array.
     * So we must provide a custom sanitizing function here.
     * Also, the setting group is the same as our single field example, because it's on the same page, 
     * so we're taking advantage of a single nonce field generated by the page callback.
     */
    register_setting(
        'settings_maxxess',                            // Settings group. Custom or existing (e.g. 'general')
        'settings_maxxess_settings',          // Setting name
        'settings_maxxess_sanitize'  // Sanitize callback. Must be custom here, since we're going to store an array of settings.
    );

    // Register a section in our top level page, to house our group of settings
    add_settings_section(
        'front_end_maxxess_section',          // Section ID
        __("Modification des paramètres du front-end"), // Title
        '',  // Callback if you need to display something special in your section. If not, you can pass in an empty string.
        'settings_maxxess_settings_page'             // Page to display the section in.
    );


    // Registers a checkbox example
    add_settings_field(
        'settings_redirection_maxxess_checkbox',                           // Field ID
        __('Activer la redirection', 'settings-maxxess'),          // Title
        'settings_maxxess_checkbox_field_display', // Callback
        'settings_maxxess_settings_page',                  // Page
        'front_end_maxxess_section',                // Section
        array(
            'label_for' => 'settings_redirection_maxxess_checkbox',  // Id for the input and label element.
            'description' => __("Permet de rediriger l'utilisateur quand il arrive sur la page index.php", 'settings-maxxess'),
        )
    );

    // Registers a text field example
    add_settings_field(
        'settings_redirection_maxxess_text',                             // Field ID
        __('Url de redirection de index'),            // Title
        'settings_maxxess_text_field_display',   // Callback to actually display the field's markup
        'settings_maxxess_settings_page',                // Page
        'front_end_maxxess_section',              // Section
        array(
            'label_for' => 'settings_redirection_maxxess_text',  // Id for the input and label element.
        )
    );

    
    // Register a section in our top level page, to house our group of settings
    add_settings_section(
        'api_maxxess_section',          // Section ID
        __("Modification des paramètres l'API", 'settings-maxxess'), // Title
        '',  // Callback if you need to display something special in your section. If not, you can pass in an empty string.
        'settings_maxxess_settings_page'             // Page to display the section in.
    );


    // Registers a text field example
    add_settings_field(
        'settings_api_maxxess_text',                             // Field ID
        __('Url du site wordpress', 'settings-maxxess'),            // Title
        'api_settings_maxxess_text_field_display',   // Callback to actually display the field's markup
        'settings_maxxess_settings_page',                // Page
        'api_maxxess_section',              // Section
        array(
            'label_for' => 'settings_api_maxxess_text',  // Id for the input and label element.
        )
    );

}


/**
 * Displays the text field example setting
 * Note the `name` attribute of the input,refering now to an array of settings.
 * 
 * @param  array  $args  Arguments passed to corresponding add_settings_field() call
 */
function settings_maxxess_text_field_display($args)
{
    $settings = get_option('settings_maxxess_settings');
    $value = !empty($settings['settings_redirection_maxxess_text']) ? $settings['settings_redirection_maxxess_text'] : '';
?>
    <input id="<?php echo esc_attr($args['label_for']); ?>" class="regular-text" type="text" name="settings_maxxess_settings[settings_redirection_maxxess_text]" value="<?php echo esc_attr($value); ?>">
<?php
}


/**
 * Displays the checkbox field example setting
 * 
 * @param  array  $args  Arguments passed to corresponding add_settings_field() call
 */
function settings_maxxess_checkbox_field_display($args)
{
    $settings = get_option('settings_maxxess_settings');
    $checked = (bool) $settings['settings_redirection_maxxess_checkbox'] ?: false;
?>
    <input id="<?php echo esc_attr($args['label_for']); ?>" type="checkbox" name="settings_maxxess_settings[settings_redirection_maxxess_checkbox]" <?php checked($checked); ?>>
    <span><?php echo esc_html($args['description']); ?></span>
<?php
}




/**
 * Displays the text field example setting
 * Note the `name` attribute of the input,refering now to an array of settings.
 * 
 * @param  array  $args  Arguments passed to corresponding add_settings_field() call
 */
function api_settings_maxxess_text_field_display($args)
{
    $settings = get_option('settings_maxxess_settings');
    $value = !empty($settings['settings_api_maxxess_text']) ? $settings['settings_api_maxxess_text'] : '';
?>
    <input id="<?php echo esc_attr($args['label_for']); ?>" class="regular-text" type="text" name="settings_maxxess_settings[settings_api_maxxess_text]" value="<?php echo esc_attr($value); ?>">
<?php
}



/**
 * Sanitize callback for our settings.
 * We have to sanitize each of our field ourselves.
 * 
 * @param  array  $settings  An array of settings (due to the inputs' name attributes)
 */
function settings_maxxess_sanitize($settings)
{
    // Sanitizes the fields
    $settings['settings_redirection_maxxess_text']     = !empty($settings['settings_redirection_maxxess_text']) ? sanitize_text_field($settings['settings_redirection_maxxess_text']) : '';
    $settings['settings_redirection_maxxess_checkbox'] = isset($settings['settings_redirection_maxxess_checkbox']);


    $settings['settings_api_maxxess_text']     = !empty($settings['settings_api_maxxess_text']) ? sanitize_text_field($settings['settings_api_maxxess_text']) : '';

    return $settings;
}
