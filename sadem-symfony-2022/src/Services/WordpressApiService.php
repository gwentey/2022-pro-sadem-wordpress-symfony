<?php

namespace App\Services;

class WordpressApiService
{

/* 
    $username = 'username';
    $password = 'password';
     
    $context = stream_context_create(array(
        'http' => array(
            'header'  => "Authorization: Basic " . base64_encode("$username:$password")
        )
    ));
    $data = file_get_contents($url, false, $context); */

    function get($resource)
    {
        $apiUrl = $_ENV['WP_HOSTNAME'] . 'wp-json/wp/v2';

        // on ignore les erreur 401, 404 afin de les écoutés
        $json = file_get_contents($apiUrl . $resource, false, stream_context_create(['http' => ['ignore_errors' => true]]));
        $result = json_decode($json);
        return $result;
    }

  
}