<?php


namespace App\Foundation\Modules\Response;


use Symfony\Component\HttpFoundation\Response;

class ApiResponseHandle
{
    /**
     * http请求成功
     *
     * @param  array   $data
     * @param  string  $message
     * @param  int     $businessCode
     * @param  array   $header
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok(array $data, string $message, int $businessCode, array $header = [])
    {
        return $this->succeed($data, $message, Response::HTTP_OK, $businessCode, $header);
    }

    /**
     * 统一返回成功方法
     *
     * @param $data
     * @param $message
     * @param $statusCode
     * @param $businessCode
     * @param $header
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function succeed(array $data, string $message, int $statusCode, int $businessCode, array $header)
    {
        $header['App-Req-MSec'] = get_millisecond() - context()->get('request_start_time');

        return response()->json([
            'code'    => $businessCode,
            'message' => $message,
            'data'    => $data,
        ], $statusCode, $header);
    }

    /**
     * 统一返回失败方法
     *
     * @param $message
     * @param $errors
     * @param $statusCode
     * @param $businessCode
     * @param $header
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function failed(string $message, array $errors, int $statusCode, int $businessCode, array $header)
    {
        $header['App-Req-MSec'] = context()->get('request_start_time') - get_millisecond();

        return response()->json([
            'code'    => $businessCode,
            'message' => $message,
            'details' => (object)$errors,
        ], $statusCode, $header);
    }
}