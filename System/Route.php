<?php

namespace System;

/**
 * Class with basic router system
 * @package System
 */
class Route {

    private $routes = [];
    private static $viewsPath = '/views/';

    /**
     * Method for processing GET queries
     * @param string $pattern your path
     * @param \Closure $closure with your "controller" code
     */
    public function get(string $pattern, \Closure $closure)
    {
        $this->add($pattern, $closure, 'GET');
    }

    /**
     * Method for processing POST queries
     * @param string $pattern your path
     * @param \Closure $closure with your "controller" code
     */
    public function post(string $pattern, \Closure $closure)
    {
        $this->add($pattern, $closure, 'POST');
    }

    /**
     * Internal method for registering routes
     * @param string $pattern your path
     * @param \Closure $closure with your "controller" code
     * @param string $method checks $_SERVER['REQUEST_METHOD']
     */
    private function add(string $pattern, \Closure $closure, string $method)
    {
        $this->routes[] = [
            'pattern' => $pattern,
            'closure' => $closure,
            'method' => $method,
        ];
    }

    /**
     * Runs processing queries
     */
    public function run()
    {
        foreach ($this->routes as $route) {
            if ($route['pattern'] == $_SERVER['REQUEST_URI'] and $route['method'] == $_SERVER['REQUEST_METHOD']) {

                $result = $route['closure']();

                if (is_array($result)) {
                    header('Content-Type: application/json');
                    $result = json_encode($result);
                }

                echo $result;
                return;
            }
        }

        echo '404';
    }

    /**
     * @param string $file php with html code in views path
     * @param array $data variables which accessed in view
     * @return false|string
     */
    public static function show(string $file, array $data = [])
    {
        ob_start();
        extract($data);
        include(__DIR__ . '/../' . self::$viewsPath . $file . '.php');
        return ob_get_clean();
    }

}