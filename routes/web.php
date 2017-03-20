<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'MainController@main');
$app->post('/', 'UrlController@register');
$app->get('/{id:[A-Za-z0-9]+}', 'UrlController@redirect');
