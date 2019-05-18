<?php
require 'boot.php';

use System\{
    Db,
    Route,
};

$route = new Route();

/**
 * Main route with form and reviews
 */
$route->get('/', function() {
    return Route::show('index');
});

/**
 * Route for getting reviews by ajax
 */
$route->get('/posts', function() {
    $posts = Db::select('select * from reviews order by id desc');

    return Route::show('posts', ['posts' => $posts]);
});

/**
 * Route for posting reviews. Returns errors in json
 */
$route->post('/send', function() {
    $required = ['name', 'email', 'text'];
    $data = [];

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            return ['error' => 'All fields are required'];
        }

        if ($field == 'email' and !filter_var($_POST[$field], FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Your email is fake. Send real'];
        }

        if (in_array($field, ['name', 'email']) and mb_strlen($_POST[$field]) > 100) {
            return ['error' => $field . ' is too long'];
        }

        $data[$field] = $_POST[$field];
    }

    Db::insert('reviews', $data);

    return ['error' => false];

});


$route->run();
