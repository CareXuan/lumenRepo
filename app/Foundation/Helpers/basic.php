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