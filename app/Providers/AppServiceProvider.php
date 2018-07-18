<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Customer;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('pclass', function($status){

            if ($status === 'ok') {
                return "<?php echo 'text-info';?>";
            }
            else{
                return "<?php echo 'text-danger'.{$status};?>";
            }
        });


        Blade::directive('customer',function($id){
            $c = Customer::find($id);
            return $c;
        });

        View::share('appconfigs', \App\Configuration::all());
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
