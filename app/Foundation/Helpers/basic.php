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