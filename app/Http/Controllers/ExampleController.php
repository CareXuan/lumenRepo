<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\TestRequest;

class ExampleController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function test(TestRequest $request)
    {
        rep()->test->test();
    }
}
