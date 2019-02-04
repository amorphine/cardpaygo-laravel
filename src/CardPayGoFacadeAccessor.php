<?php
namespace Amorphine\CardPayGo;

use Amorphine\CardPayGo\Services\HostedForm;

class CardPayGoFacadeAccessor {
    public static $provider;

    /**
     * Get Cardpaygo helper
     *
     * @return HostedForm
     */
    public function getProvider() {
        if (empty(self::$provider)) {
            return new HostedForm();
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
        self::$provider = new HostedForm();

        return self::getProvider();
    }

}