<?php

/**
 * Router of the EmmaPHP MVC Framework
 */
class Router {

    public static $halts = false;

    /**
    * Array of routes
    *
    * @var array
    */
    public static $routes = array();

    /**
    * Array of route names
    *
    * @var array
    */
    public static $names = array();

    /**
    * Array of route methods
    *
    * @var array
    */
    public static $methods = array();

    /**
    * Array of route callbacks
    *
    * @var array
    */
    public static $callbacks = array();

    /**
    * Array of patterns for url params
    *
    * @var array
    */
    public static $patterns = array(
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
        ':all' => '.*'
    );
    
    /**
    * Call static function
    *
    * @param $method - HTTP type, get, post, put, delete
    * @param array $params - Contains all params specified in routes
    */
    public static function __callstatic($method, $params) 
    {

        $name = $params[0];
        $uri = $params[1];
        $callback = $params[2];

        self::$names[$name] = $uri;
        array_push(self::$routes, $uri);
        array_push(self::$methods, strtoupper($method));
        array_push(self::$callbacks, $callback);
    }
    
    /**
    * Fixing request_uri for subdirs
    */
    public static function fixSubdirUrls() {
	$base = dirname($_SERVER['PHP_SELF']);
	$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
	$_SERVER['REQUEST_URI'] = ($_SERVER['REQUEST_URI'] == "") ? '/' : '/'.ltrim($_SERVER['REQUEST_URI'], '/');
    }

    /**
    * Go to state, redirect based on route name
    *
    * @param string $name - Name of route, will redirect if found
    */
    public static function goToState($name) {
    	
    	// Fix subdir URL
    	self::fixSubdirUrls();

        if(isset(self::$names[$name])) {
			$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

			$searches = array_keys(static::$patterns);
			$searches[] = '(';
			$searches[] = ')';

			$route = self::$names[$name];
			$route = str_replace($searches, '', $route);
			
			EmmaController::$instance->redirect($route);

        }

    }

    /**
    * Dispatch, runs the routes and check for match
    */
    public static function dispatch() {
    	
    	// Fix subdir URL
    	self::fixSubdirUrls();

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];  

        $searches = array_keys(static::$patterns);
        $replaces = array_values(static::$patterns);

        $found_route = false;

        // check if route is defined without regex
        if (in_array($uri, self::$routes)) {
            $route_pos = array_keys(self::$routes, $uri);
            foreach ($route_pos as $route) {

                if (self::$methods[$route] == $method) {
                    $found_route = true;

                    //grab all parts based on a / separator 
                    $parts = explode('/',self::$callbacks[$route]); 

                    //collect the last index of the array
                    $last = end($parts);

                    //grab the controller name and method call
                    $segments = explode('@',$last);

                    if(count($segments) != 2 || @$segments[1] == "") return false;

                    return (object) array(
                    	'segments'	=> $segments
                    );
                }
            }
        } else {
            // check if defined with regex
            $pos = 0;
            foreach (self::$routes as $route) {

                if (strpos($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route);
                }

                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    if (self::$methods[$pos] == $method) {
                        $found_route = true;

                        array_shift($matched); //remove $matched[0] as [1] is the first parameter.


                        //grab all parts based on a / separator 
                        $parts = explode('/',self::$callbacks[$pos]); 

                        //collect the last index of the array
                        $last = end($parts);

                        //grab the controller name and method call
                        $segments = explode('@',$last); 

                    	if(count($segments) != 2 || @$segments[1] == "") return false;

                        return (object) array(
                        	'segments' 	=> $segments,
                        	'matched'	=> $matched
                        );
                        
                    }
                }

                $pos++;
            
            }
        }
 
        // Return false if the route was not found
        if ($found_route == false) {
            return false;
        }

    }
}
