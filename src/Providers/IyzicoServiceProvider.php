<?php
 
namespace Damalis\Iyzico\Providers;

use Illuminate\Support\ServiceProvider;
use Webkul\Core;
 
/**
 *  Iyzico service provider
 *
 * @author    damalis
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

        //$this->app->register(IyzicoServiceProvider::class);
        
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

    protected function registerConfig()
    {   
        //this will merge payment method
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php', 'paymentmethods'
        );

        // add menu inside configuration  
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'   
        );

    }
}
