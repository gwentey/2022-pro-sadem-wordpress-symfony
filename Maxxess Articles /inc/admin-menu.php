<?php
defined( 'ABSPATH' ) || die();


/******************************
 * Configuration de la page d'administration
 ******************************/

add_action( 'admin_menu', 'settings_maxxess_menu_items' );
/**
 * Registers our new menu items
 */
function settings_maxxess_menu_items() {

    // `add_menu_page()` creates a top-level menu item.
    $page_hookname = add_menu_page(
        __( 'Maxxess Articles', 'settings_maxxess' ), // Page title
        __( 'Maxxess Articles', 'settings_maxxess' ), // Menu title
        'manage_options',                                        // Capabilities
        'settings_maxxess_settings_page',          // Slug
        'settings_maxxess_page_callback',          // Display callback
        'dashicons-welcome-widgets-menus',                                      // Icon
        66                                                       // Priority/position. Just after 'Plugins'
    );

}

/**
 * Displays our top level page content
 */
function settings_maxxess_page_callback(){
    ?>
        <div class="wrap">
            <!-- Displays the title -->
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <!-- The form must point to options.php -->
            <form action="options.php" method="POST">
                <?php 
                    // Output the necessary hidden fields : nonce, action, and option page name
                    settings_fields( 'settings_maxxess' );
                    // Loops through registered sections and fields for the page slug passed in, and display them.
                    do_settings_sections( 'settings_maxxess_settings_page' );
                    // Displays a submit button
                    submit_button();
                ?>
            </form>
        </div>
    <?php
}
