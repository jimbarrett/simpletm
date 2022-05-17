<?php 
// start the session
session_start();

require_once('db/conf.php');

// autoloader 
spl_autoload_register(function($class) {
    if(file_exists($class . '.php')) {
        require($class . '.php');
    } else if(file_exists('classes/' . $class . '.php')) {
        require('classes/' . $class . '.php');
    }
});

// router
$router = new Router();

// task routes
$router->get('/', 'TasksController@index');
$router->post('/tasks/delete', 'TasksController@delete');
$router->get('/task/showform', 'TasksController@showform');
$router->post('/task/savenew', 'TasksController@savenew');
$router->post('/tasks/updatetitle', 'TasksController@updatetitle');
$router->post('/tasks/updateduedate', 'TasksController@updateduedate');
$router->post('/tasks/markcomplete', 'TasksController@markcomplete');
// login/logout routes
$router->get('/login', 'UsersController@loginPage');
$router->post('/login', 'UsersController@doLogin');
$router->get('/logout', 'UsersController@logout');

// dispatch route based on server vars
$router->dispatch($_SERVER);