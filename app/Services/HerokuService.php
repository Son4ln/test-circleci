<?php

namespace App\Services;

class HerokuService
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public static function setup()
    {
        if (function_exists('putenv')) {
            self::overrideDatabaseConfig();
            self::overrideRedisConfig();
            //self::overrideLogConfig();
        }
    }

    /**
     * @return void
     */
    protected static function overrideDatabaseConfig()
    {
        if (($databaseUrl = getenv('DATABASE_URL')) === false) {
            return;
        }

        putenv('DB_CONNECTION=' . self::aliasDbConnection(parse_url($databaseUrl, PHP_URL_SCHEME)));
        putenv('DB_HOST=' . parse_url($databaseUrl, PHP_URL_HOST));
        putenv('DB_PORT=' . parse_url($databaseUrl, PHP_URL_PORT));
        putenv('DB_DATABASE=' . substr(parse_url($databaseUrl, PHP_URL_PATH), 1));
        putenv('DB_USERNAME=' . parse_url($databaseUrl, PHP_URL_USER));
        putenv('DB_PASSWORD=' . parse_url($databaseUrl, PHP_URL_PASS));
    }

    /**
     * @param string $connection
     * @return string
     */
    protected static function aliasDbConnection(string $connection)
    {
        $mapping = [
            'postgres' => 'pgsql',
        ];

        return $mapping[$connection] ?? $connection;
    }

    /**
     * @return void
     */
    protected static function overrideRedisConfig()
    {
        if (($redisUrl = getenv('REDIS_URL')) === false) {
            return;
        }

        putenv('REDIS_HOST=' . parse_url($redisUrl, PHP_URL_HOST));
        putenv('REDIS_PORT=' . parse_url($redisUrl, PHP_URL_PORT));
        putenv('REDIS_USERNAME=' . parse_url($redisUrl, PHP_URL_USER));
        putenv('REDIS_PASSWORD=' . parse_url($redisUrl, PHP_URL_PASS));
    }

    /**
     * @return void
     */
    protected static function overrideLogConfig()
    {
        putenv('APP_LOG', 'errorlog');
    }
}
