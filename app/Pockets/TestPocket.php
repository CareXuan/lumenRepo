<?php


namespace App\Pockets;

use App\Foundation\Modules\Pocket\BasePocket;

class TestPocket extends BasePocket
{
    public function test(){
        echo "hello world";
    }
}