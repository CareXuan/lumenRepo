<?php


namespace App\Foundation\Modules\Pocket;

use Doctrine\DBAL\Exception\ServerException;
use App\Pockets\TestPocket;

/**
 * Class PocketHandle
 * @package App\Foundation\Modules\Pocket
 *
 * @property TestPocket $test
 */
class PocketHandle
{
    protected static $pockets;
    protected static $instance;
    protected static $registerList = [
        'test' => TestPocket::class
    ];

    protected function __construct() { }

    protected function __clone() { }

    public static function instance()
    {
        if (!isset(self::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function registerAll()
    {
        foreach (self::$registerList as $name => $class) {
            self::$pockets[$name] = app($class);
        }
    }

    public function regisiter($name)
    {
        self::$pockets[$name] = app(self::$registerList[$name]);
    }

    public function __get($name)
    {
        if (isset(self::$registerList[$name]) && !isset(self::$pockets[$name])) {
            self::regisiter($name);
        } elseif (!isset(self::$registerList[$name])) {
            throw new ServerException($name . ' Unregistered please add to registerList');
        }

        return self::$pockets[$name];
    }
}