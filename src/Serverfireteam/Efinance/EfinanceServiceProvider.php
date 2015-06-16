<?php namespace Serverfireteam\Efinance;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Route;
use Illuminate\Translation;

class EfinanceServiceProvider extends ServiceProvider
{
    protected $defer = false;
        
    public function register()
    {
        
        $this->publishes([
            __DIR__.'/config/efinance.php' => config_path('efinance.php'),
        ]);
    }
        
    public function boot()
    {        
        ini_set('soap.wsdl_cache_enabled', 0);
        ini_set('soap.wsdl_cache_ttl', 0);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
    
    
}
