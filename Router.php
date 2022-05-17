<?php 

class Router {

    private $routes = ['get' => [], 'post' => []];
    private $request = [];

    // some routes should not require login.
    // specifically I'm adding this to prevent problems with submitting login form to /login (POST method)
    // without this when I submit my form it would automatically serve up the login page again without 
    // processing the form.
    private $noLogin = [
        '/login'
    ];
    
    // add a GET route
    public function get($uri, $callback) {
        $this->routes['get'][$uri] = $callback;
    }
    
    // add a POST route
    public function post($uri, $callback) {
        $this->routes['post'][$uri] = $callback;
    }

    // Dispatch the route based on $_SERVER
    public function dispatch($request) {
        $req_uri = $request['REQUEST_URI']; 
        $req_broken = explode('?', $req_uri);
        $uri = $req_broken[0];
        $method = strtolower($request['REQUEST_METHOD']);

        if(!$_SESSION['loggedIn'] && !in_array($uri, $this->noLogin)) { // not logged in and login required. fire loginPage
            $this->fire('UsersController@loginPage');
        } else if(array_key_exists($uri, $this->routes[$method])) { // route and method found. fire method based on saved route
            $this->fire($this->routes[$method][$uri]);
        } else { // no matching route/method. 404
            $this->fire('PagesController@E404');
        }
    }

    // given callback string from route, call controller and method
    private function fire($callable) {
        $arr = explode('@',$callable);
        list($con, $method) = explode('@',$callable);
        $c = new $con();
        $c->$method();
    }
}