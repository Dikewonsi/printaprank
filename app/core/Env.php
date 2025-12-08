<?php
    // app/core/Env.php
    namespace App\core;

    class Env
    {
        private static array $vars = [];

        public static function load(string $path): void
        {
            if (!file_exists($path)) {
                throw new \RuntimeException(".env.php not found at {$path}");
            }
            $data = require $path;
            if (!is_array($data)) {
                throw new \RuntimeException(".env.php must return an array");
            }
            self::$vars = $data;
        }

        public static function get(string $key, mixed $default = null): mixed
        {
            return self::$vars[$key] ?? $default;
        }
    }
