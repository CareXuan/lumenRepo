<?php

namespace App\Http\Controllers;

class ExampleBaseController extends BaseController
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

    public function test()
    {
        pocket()->test->test();
    }
}
