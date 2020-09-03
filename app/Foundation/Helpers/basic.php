<?php

if (!function_exists('rep')) {
    /**
     * @return \App\Foundation\Modules\Repository\RepositoryHandle
     */
    function rep()
    {
        return app('rep');
    }
}

if (!function_exists('pocket')) {
    /**
     * @return \App\Foundation\Modules\Pocket\PocketHandle
     */
    function pocket()
    {
        return app('pocket');
    }
}

if (!function_exists('api_result')){
    /**
     * @return \App\Foundation\Modules\Response\ApiBusinessResponseHandle
     */
    function api_result(){
        return app('api_result');
    }
}

if (!function_exists('aes_encrypt')){
    /**
     * @return \App\Foundation\Handles\AesEncryptHandle
     */
    function aes_encrypt(){
        return app('aes_encrypt');
    }
}

if (!function_exists('current_route_name')) {
    /**
     * Get current route name
     *
     * @return string
     */
    function current_route_name()
    {
        return request()->route()[1]['as'];
    }
}

if (!function_exists('get_millisecond')) {
    /**
     * Gets the number of milliseconds of the current time
     *
     * @return float
     */
    function get_millisecond()
    {
        list($t1, $t2) = explode(' ', microtime());

        return (int)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }
}

if (!function_exists('context')) {
    /**
     * Gets data that is saved only once in the life cycle
     *
     * @param  null|string|array  $key
     * @param  null|mixed         $default
     *
     * @return \App\Foundation\Modules\Context\ContextHandler|mixed|array
     */
    function context($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('context');
        }

        if (is_array($key)) {
            return app('context')->only($key);
        }

        $value = app('context')->$key;

        return is_null($value) ? value($default) : $value;
    }
}

if (!function_exists('d')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed  $args
     *
     * @return void
     */
    function d(...$args)
    {
        foreach ($args as $argument) {
            dump($argument);
        }
    }
}

if (!function_exists('get_sql')) {
    /**
     * To monitor and print execute SQL statements
     *
     * @param  bool  $die
     *
     * @return void
     */
    function get_sql($die = false)
    {
        \Illuminate\Support\Facades\DB::listen(function ($sql) use ($die) {
            $singleSql = $sql->sql;
            if ($sql->bindings) {
                foreach ($sql->bindings as $replace) {
                    $value     = is_numeric($replace) ? $replace : "'" . $replace . "'";
                    $singleSql = preg_replace('/\?/', $value, $singleSql, 1);
                }
                if ($die) {
                    dd($singleSql);
                } else {
                    d($singleSql);
                }
            } else {
                if ($die) {
                    dd($singleSql);
                } else {
                    d($singleSql);
                }
            }
        });
    }
}