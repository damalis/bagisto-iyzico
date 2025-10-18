<?php
 
namespace Damalis\Iyzico\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
 
/**
 *  Iyzico service provider
 *
 * @author  damalis
 */
class IyzicoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    
   
    public function boot()
    {
		
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'iyzico');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'iyzico');
		
        $this->publishes([
            __DIR__ . '/../Resources/assets' => public_path('/vendor/damalis/iyzico/assets'),
        ], 'iyzico');
		
		Event::listen('sales.refund.save.after', 'Damalis\Iyzico\Listeners\IyzicoRefund@afterCreated');
		Event::listen('sales.order.cancel.after', 'Damalis\Iyzico\Listeners\IyzicoCancel@afterCanceled');

    }
 
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {   
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {   
        //this will merge payment method
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php', 'payment_methods'
        );

        // add menu inside configuration  
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'   
        );

    }
}
