<?php
// Let's register a new field for returning the script srcs
add_action('rest_api_init', 'gw_register_rest_field');

function gw_register_rest_field()
{
    register_rest_field(
        'post',
        'more_info',
        array(
            'get_callback'    => 'gw_fetch_post_cont',
            'schema'          => null,
        )
    );
}

// Callback function to actually retrieve the data
function gw_fetch_post_cont($object)
{
    // Get the id of the post object array
    $post_id = $object['id'];


    // récupération du paramètre dans la section des réglages
    $url_du_site_api = get_option('settings_maxxess_settings')['settings_api_maxxess_text'];

    // Let's get the content of post number 123 : http://localhost:8888/Sadem/wordpress/
    $response = wp_remote_get("{$url_du_site_api}?p={$post_id}");


    if (is_array($response)) {

        $content = $response['body'];
        // Extract the src attributes. You can also use preg_match_all
        $document = new DOMDocument();
        libxml_use_internal_errors(true);

        $document->loadHTML($content);
        libxml_use_internal_errors(false);

        // An empty array to store all the 'srcs'
        $scripts_array = [];

        // An array for exclude css et script
        $scripts_excludes = [

        ];

        // EVERY SCRIPT
        foreach ($document->getElementsByTagName('script') as $script) {
            if ($script->hasAttribute('src')) {
                if ($script->hasAttribute('id')) {
                    $scripts_array['script'][] = "<script src='" . $script->getAttribute('src') . "'id='" . $script->getAttribute('id') . "'></script>";
                }
            } else if ($script->hasAttribute('id')) {
                $scripts_array['script'][] = "<script id='" . $script->getAttribute('id') . "'>" . $script->nodeValue . "</script>";
            } else {
                $scripts_array['script'][] = "<script>" . $script->nodeValue . "</script>";
            }
        }
        // EVERY CSS
        foreach ($document->getElementsByTagName('link') as $link) {
            if ($link->hasAttribute('href')) {
                if ($link->hasAttribute('id')) {
                    // verifie s'il ne fait pas partie des tableaux des exclusions afin d'épurer le code
                     // if (!in_array($link->hasAttribute('id'), $scripts_excludes)) {
                        $scripts_array['header'][] = "<link rel='stylesheet' id='" . $link->getAttribute('id') . "'href='" . $link->getAttribute('href') . "' media='all'/>";
                    // }
                } else {
                    $scripts_array['header'][] = "<link rel='stylesheet' href='" . $link->getAttribute('href') . "'/>";
                }
            }
        }
        // EVERY STYLE
        foreach ($document->getElementsByTagName('style') as $style) {
            $scripts_array['header'][] = "<style>" . $style->nodeValue . "</style>";
        }
    }




    return $scripts_array;
}
