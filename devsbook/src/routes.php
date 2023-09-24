<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/signin', 'LoginController@signin');
$router->post('/signin', 'LoginController@signinAction');
$router->get('/signup', 'LoginController@signup');
$router->post('/signup', 'LoginController@signupAction');

$router->post('/post/new', 'PostController@new');

$router->get('/profile/{id}', 'ProfileController@index');
$router->get('/profile', 'ProfileController@index');


//$router->get('/search');
//$router->get('/profile');
//$router->get('/out');
//$router->get('/friends');
//$router->get('/photos');
//$router->get('/config');





