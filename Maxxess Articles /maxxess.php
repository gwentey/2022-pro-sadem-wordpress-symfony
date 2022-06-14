<?php
/*
Plugin Name: Maxxess Articles
Description: Cette extension va permettre d'ajouter 2 fields en plus dans l'API : le header et le footer.
Author: Anthony Rodrigues
Version: 1.0
Author URI: https://anthony-rodrigues.fr
*/


defined( 'ABSPATH' ) || die();

// ajout de la page setting sur le menu
include 'inc/admin-menu.php';

// gère la page de setting
include 'inc/multiple-settings.php';

// le script afin d'ajouter les 2 fields dans l'api
include 'inc/api-new-fields.php';


