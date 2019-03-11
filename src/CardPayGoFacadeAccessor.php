<?php
namespace Amorphine\CardPayGo;

use Amorphine\CardPayGo\Services\DirectIntegration;
use Amorphine\CardPayGo\Services\HostedForm;

class CardPayGoFacadeAccessor {
    const CONFIG_NAME = 'cardpaygo';

    const HOSTED_FORM_ABSTRACT_NAME = 'cardpaygo_hosted_form';
    const DIRECT_INTEGRATION_ABSTRACT_NAME = 'cardpaygo_hosted_form';

    public static $provider;

    /**
     * Get Cardpaygo helper
     *
     * @return HostedForm
     */
    public function getProvider() {
        if (empty(self::$provider)) {
            return new HostedForm(config(self::CONFIG_NAME));
        } else {
            return self::$provider;
        }
    }

    /**
     * Set Cardpaygo helper
     *
     * @param string $option - currently unused
     * @return HostedForm
     */
    public function setProvider($option = '') {

        // Set default provider.
        if (empty($option) || ($option != self::DIRECT_INTEGRATION_ABSTRACT_NAME) || ($option == self::HOSTED_FORM_ABSTRACT_NAME)) {
            self::$provider = new HostedForm(config(self::CONFIG_NAME));
        } else {
            self::$provider = new DirectIntegration(config(self::CONFIG_NAME));
        }

        return self::getProvider();
    }

}