<?php

namespace Amorphine\CardPayGo\Facades;

use \Illuminate\Support\Facades\Facade;

class CardPayGo extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Amorphine\CardPayGo\CardPayGoFacadeAccessor';
    }

}