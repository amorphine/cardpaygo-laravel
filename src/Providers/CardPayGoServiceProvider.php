<?php
namespace Amorphine\CardPayGo\Providers;

use Amorphine\CardPayGo\Services\DirectIntegration;
use Amorphine\CardPayGo\Services\HostedForm;
use Illuminate\Support\ServiceProvider;

class CardPayGoServiceProvider extends ServiceProvider {

    const CONFIG_NAME = 'cardpaygo';

    const HOSTED_FORM_ABSTRACT_NAME = 'cardpaygo_hosted_form';
    const DIRECT_INTEGRATION_ABSTRACT_NAME = 'cardpaygo_hosted_form';

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
        $this->app->singleton(self::HOSTED_FORM_ABSTRACT_NAME, function () {
            return new HostedForm(config(self::CONFIG_NAME));
        });

        // bind an instance within container
        $this->app->singleton(self::DIRECT_INTEGRATION_ABSTRACT_NAME, function () {
            return new DirectIntegration(config(self::CONFIG_NAME));
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