<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('odd', function ($attribute, $value, $parameters, $validator) {
            if (!empty($value) && (strlen($value) % 2) == 0) {
                return true;
            }
            return false;
        });
        Validator::extend('username', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $value);
        });

        Validator::extend('strlen', function ($attribute, $value, array $parameters) {
            if (empty($parameters)) {
                throw new \InvalidArgumentException('Parameters must be passed');
            }

            $min = 0;
            if (count($parameters) === 1) {
                list($max) = $parameters;
            } elseif (count($parameters) >= 2) {
                list($min, $max) = $parameters;
            }

            if (! isset($max) || $max < $min) {
                throw new \InvalidArgumentException('The parameters passed are incorrect');
            }

            // 计算单字节.
            preg_match_all('/[a-zA-Z0-9_]/', $value, $single);
            $single = count($single[0]) / 2;

            // 多子节长度.
            $double = mb_strlen(preg_replace('([a-zA-Z0-9_])', '', $value));

            $length = $single + $double;

            return $length >= $min && $length <= $max;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
