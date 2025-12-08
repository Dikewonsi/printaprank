<?php
    // app/core/Config.php
    namespace App\core;

    class Config
    {
        public static function appUrl(): string
        {
            return Env::get('APP_URL', 'http://localhost');
        }

        public static function frontendUrl(): string
        {
            return Env::get('FRONTEND_URL', 'http://localhost:5173');
        }

        public static function isDebug(): bool
        {
            return (bool) Env::get('APP_DEBUG', false);
        }

        public static function db(): array
        {
            return [
                'driver' => Env::get('DB_DRIVER', 'mysql'),
                'host'   => Env::get('DB_HOST', '127.0.0.1'),
                'port'   => (int) Env::get('DB_PORT', 3306),
                'name'   => Env::get('DB_NAME', ''),
                'user'   => Env::get('DB_USER', ''),
                'pass'   => Env::get('DB_PASS', ''),
                'charset'=> 'utf8mb4',
            ];
        }
    }
