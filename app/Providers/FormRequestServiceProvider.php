<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Foundation\Modules\FormRequest\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Laravel\Lumen\Http\Redirector;

class FormRequestServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });
        $this->app->resolving(FormRequest::class, function ($request, $app) {
            $this->initializeRequest($request, $app['request']);
            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
        });
    }

    protected function initializeRequest(FormRequest $form, Request $current)
    {
        $files = $current->all();
        $files = is_array($files) ? array_filter($files) : $files;
        $form->initialize(
            $current->query->all(),
            $current->request->all(),
            $current->attributes->all(),
            $current->cookies->all(),
            $files,
            $current->server->all(),
            $current->getContent()
        );
        $form->setJson($current->json());
        if ($session = $current->getSession()) {
            $form->setLaravelSession($session);
        }
        $form->setUserResolver($current->getUserResolver());
        $form->setRouteResolver($current->getRouteResolver());
    }
}