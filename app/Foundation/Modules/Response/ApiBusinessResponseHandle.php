<?php


namespace App\Foundation\Modules\Response;

class ApiBusinessResponseHandle
{
    private $apiHandle;

    public function __construct()
    {
        $this->apiHandle = new ApiResponseHandle();
    }

    /**
     * get请求成功
     *
     * @param          $data
     * @param  string  $message
     * @param  array   $header
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOK($data, $message = 'get ok', $header = [])
    {
        return $this->apiHandle->ok($data, $message, ApiCode::STATUS_OK, $header);
    }

    /**
     * 请求中缺少token
     *
     * @param          $data
     * @param  string  $message
     * @param  array   $header
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authTokenMissing($data, $message = 'authenticate token missing', $header = [])
    {
        return $this->apiHandle->fail($data, $message, ApiCode::AUTH_TOKEN_MISSING, $header);
    }


    /**
     * forbidden通用方法
     *
     * @param          $data
     * @param  string  $message
     * @param  array   $header
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbidCommon($message = '禁止的动作', $data = [], $header = [])
    {
        return $this->apiHandle->forbidden($data, $message, ApiCode::FORBIDDEN, $header);
    }
}