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

            // Try exact match first
            if (isset($this->routes[$method][$path])) {
                $handler = $this->routes[$method][$path];
                return $this->invokeHandler($handler);
            }

            // Try dynamic routes
            foreach ($this->routes[$method] as $route => $handler) {
                $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
                if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                    array_shift($matches); // remove full match
                    return $this->invokeHandler($handler, $matches);
                }
            }

            http_response_code(404);
            echo "404 Not Found";
        }

        private function invokeHandler($handler, array $params = [])
        {
            if (is_array($handler)) {
                [$class, $method] = $handler;
                $instance = new $class();
                return $instance->$method(...$params);
            }
            return $handler(...$params);
        }
    }
