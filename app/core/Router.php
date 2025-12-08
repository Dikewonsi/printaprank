<?php
    // app/core/Router.php
    namespace App\core;

    class Router
    {
        private array $routes = [
            'GET' => [],
            'POST' => [],
        ];

        public function get(string $path, callable|array $handler): void
        {
            $this->routes['GET'][$path] = $handler;
        }

        public function post(string $path, callable|array $handler): void
        {
            $this->routes['POST'][$path] = $handler;
        }

        public function dispatch(string $method, string $uri)
        {
            $path = parse_url($uri, PHP_URL_PATH);
            $handler = $this->routes[$method][$path] ?? null;

            if (!$handler) {
                http_response_code(404);
                echo "404 Not Found";
                return;
            }

            if (is_array($handler)) {
                [$class, $method] = $handler;
                $instance = new $class();
                return $instance->$method();
            }

            return $handler();
        }
    }
