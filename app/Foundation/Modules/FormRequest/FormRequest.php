<?php


namespace App\Foundation\Modules\FormRequest;

use Laravel\Lumen\Http\Request;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Redirector;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;

class FormRequest extends Request implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    protected $container;

    protected $redirector;

    protected $redirectRoute;

    protected $errorBag = 'default';

    protected $dontFlash = ['password', 'password_confirmation'];

    protected function getValidatorInstance()
    {
        $factory = $this->container->make(Factory::class);
        if (method_exists($this, 'validator')) {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }

        return $factory->make($this->validationData(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes());
    }

    protected function validationData()
    {
        return $this->all();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response($this->formatErrors($validator)));
    }

    protected function passesAuthorization()
    {
        if (method_exists($this, 'authorize')) {
            return $this->container->call([$this, 'authorize']);
        }
    }

    protected function failedAuthorization()
    {
        throw new UnauthorizedException($this->forbiddenResponse());
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }

    public function forbiddenResponse()
    {
        return new Response('Forbidden', 403);
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }

    public function setRedirector(Redirector $redirector)
    {
        $this->redirector = $redirector;

        return $this;
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    public function route($param = null, $default = null)
    {
        $route = call_user_func($this->getRouteResolver());

        if (is_null($route) || is_null($param)) {
            return $route;
        }

        $parameters = end($route);

        return Arr::get($parameters, $param, $default);
    }
}