<?php

namespace App\Providers;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('success', function ($message = '', $data = null , $responseHttpCode) use ($factory) {
            $format = [
                'status' => 'ok',
                'message' => $message,
                'data' => $data,
                'http_code' => $responseHttpCode
            ];

            return $factory->make($format);
        });

        $factory->macro('error', function (string $message = '', $errors = [] , $responseHttpCode) use ($factory){
            $format = [
                'status' => 'error', 
                'message' => $message,
                'errors' => $errors,
                'http_code' => $responseHttpCode
            ];

            return $factory->make($format);
        });
    }
}
