<?php


namespace App\Foundation\Modules\Response;


class ApiCode
{
    const AUTH_TOKEN_MISSING = 1001;//缺少token
    const FORBIDDEN = 1002;//forbidden

    const STATUS_OK = 2000;//请求成功
}