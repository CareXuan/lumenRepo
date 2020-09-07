<?php


namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class AuthenticateMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!request()->headers->has('authenticate')) {
            return api_result()->authTokenMissing(true);
        }
        $now        = time();
        $header     = $next($request);
        $token      = request()->headers->get('authenticate');
        $uuid       = substr($token, 0, 16);
        $token      = substr($token, 16);
        $authArr    = json_decode(aes_encrypt()->decrypt($token), true);
        $id         = (int)$authArr['id'];
        $number     = (int)$authArr['number'];
        $updateTime = $authArr['update_time'];
        $deleteTime = $authArr['delete_time'];
        $user       = new User();
        $user->setAttribute('id', $id);
        $user->setAttribute('number', $number);
        context()->set('login-user', $user);
        if ($now > $deleteTime) {
            return api_result()->forbidCommon('登录信息已超时');
        } elseif ($now > $updateTime && $now < $deleteTime) {
            $newTokenArr = [
                'id'          => $id,
                'number'      => $number,
                'update_time' => $now + 3600,
                'delete_time' => $now + 7200
            ];
            $newToken    = $uuid . aes_encrypt()->encrypt($newTokenArr);
            $header->headers->set('new-auth', $newToken);
        }

        return $header;
    }
}