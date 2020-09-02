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
}