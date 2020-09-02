<?php


namespace App\Foundation\Modules\Repository;


use Doctrine\DBAL\Exception\ServerException;
use App\Reposiories\TestRepository;

/**
 * Class RepositoryHandle
 * @package App\Foundation\Modules\Repository
 *
 * @property TestRepository $test
 */
class RepositoryHandle
{
    protected static $registerList = [
        'test' => TestRepository::class
    ];

    protected static $instance;

    protected static $repositories = [];

    protected function __construct() { }

    protected function __clone() { }

    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public static function regisiterAll()
    {
        foreach (self::$registerList as $name => $class) {
            self::$repositories[$name] = app($class);
        }
    }

    public static function register($name)
    {
        self::$repositories[$name] = app(self::$registerList[$name]);
    }

    public function __get($name)
    {
        if (isset(self::$registerList[$name]) && !isset(self::$repositories[$name])) {
            self::register($name);
        } elseif (!isset(self::$registerList[$name])) {
            throw new ServerException($name . ' Unregistered please add to registerList');
        }

        return self::$repositories[$name];
    }
}