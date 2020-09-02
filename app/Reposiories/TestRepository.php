<?php


namespace App\Reposiories;

use App\Foundation\Modules\Repository\BaseRepository;
use App\Models\Test;

class TestRepository extends BaseRepository
{
    public function setModel()
    {
        return Test::class;
    }

    public function test()
    {
        echo "test";
    }
}