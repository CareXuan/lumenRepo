<?php


namespace App\Foundation\Modules\Context;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Exceptions\ServiceException;

class ContextHandler
{
    protected static $instance;

    protected static $data = [];

    protected function __construct() { }

    protected function __clone() { }

    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function set($key, $value)
    {
        if ($value instanceof Closure) {
            $value = $value();
        }

        Arr::set(static::$data, Str::snake($key, '_'), $value);

        return $value;
    }

    public function get($key, $default = null)
    {
        return Arr::get(static::$data, $key, $default);
    }

    public function only($keys)
    {
        return Arr::only(static::$data, $keys);
    }

    public function has($key)
    {
        return array_key_exists($key, static::$data);
    }

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    public function __get($key)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        $method = 'get' . ucfirst(Str::camel($key)) . 'Attribute';

        if (method_exists($this, $method)) {
            $value = $this->$method();

            return $this->set($key, $value);
        }

        return null;
    }

    public function __call($method, $parameters)
    {
        $key = Str::snake($method);

        if ($this->has($key)) {
            return $this->get($key);
        }

        if (!method_exists($this, $method)) {
            throw new ServiceException(sprintf('Method %s::%s does not exist.', static::class, $method));
        }

        $value = $this->$method(...$parameters);

        return $this->set($key, $value);
    }

    protected function getRouteNameAttribute()
    {
        $route_params = request()->route();
        $route_name   = '';

        foreach ($route_params as $route_param) {
            if (is_array($route_param) && array_key_exists('as', $route_param)) {
                $route_name = $route_param['as'];
            }
        }

        return $route_name;
    }
}