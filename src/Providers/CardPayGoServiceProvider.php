<?php
namespace Amorphine\CardPayGo\Providers;

use Amorphine\CardPayGo\Services\HostedForm;
use Illuminate\Support\ServiceProvider;

class CardPayGoServiceProvider extends ServiceProvider {

    const CONFIG_NAME = 'cardpaygo';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function register()
    {
        // bind an instance within container
        $this->app->singleton('cardpaygo_hosted_form', function () {
            return new HostedForm();
        });

        //merge configs
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            self::CONFIG_NAME
        );
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // publish config files
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('cardpaygo.php'),
        ], 'cardpaygo');

        // Publish Lang Files
        //$this->loadTranslationsFrom(__DIR__.'/../../lang', self::CONFIG_KEY);
    }

}