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

            // Normalize trailing slash
            if ($path !== '/' && str_ends_with($path, '/')) {
                $path = rtrim($path, '/');
            }

            // If app is served from /public, strip that
            $path = preg_replace('#^/public#', '', $path);

            // Try exact match
            if (isset($this->routes[$method][$path])) {
                $handler = $this->routes[$method][$path];
                return $this->invokeHandler($handler);
            }

            // Try dynamic routes...
            foreach ($this->routes[$method] as $route => $handler) {
                $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
                if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                    array_shift($matches);
                    return $this->invokeHandler($handler, $matches);
                }
            }

            http_response_code(404);
            echo "404 Not Found (path: $path)";
        }


        private function invokeHandler($handler, array $params = [])
        {
            if (is_array($handler)) {
                [$class, $method] = $handler;
                $instance = null;

                // --- CRITICAL ADMIN ACCESS CONTROL FIX ---
                $adminControllerClass = 'App\\controllers\\AdminController';

                if ($class === $adminControllerClass) {
                    // If it's the AdminController, pass the method name 
                    // to the constructor for the bypass check.
                    $instance = new $class($method); 
                } else {
                    // Instantiate all other controllers normally.
                    $instance = new $class();
                }
                // -----------------------------------------
                
                // Execute the controller method
                return $instance->$method(...$params);
            }
            
            // Handle closure/callable functions
            return $handler(...$params);
        }
    }
