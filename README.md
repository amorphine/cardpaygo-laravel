# Laravel CardPayGo

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- [Introduction](#introduction)
- [Links](#links)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Support](#support)

    
<a name="introduction"></a>
## Introduction

By using this plugin you can create CardPayGo payment forms in your Laravel application.

**Currently only Hosted Forms are supported**

<a name="links"></a>
## Links

Github repo
https://github.com/amorphine/cardpaygo-laravel

<a name="installation"></a>
## Installation

* Currently not published at packagist. Add to composer via repository

<a name="configuration"></a>
## Configuration

* After installation, you will need to add your cardpaygo settings. Following is the code you will find in **config/cardpaygo.php**, which you should update accordingly.

```php
return [
    // mandatory
    'merchantID'    => '',

    // optional. The password you have configured for the merchantID.
    // This is set within the MMS. Currently not used
    'merchantPwd'   => '',

    //ISO standard country code for the merchant’s location.
    'countryCode'   => '',

    //ISO standard currency code for this transaction.
    //You may only use currencies that are enabled for
    //your merchant account.
    'currencyCode'  => '',

    // default is SALE
    'action'        => '',

    // optional. A non-public URL which will receive a copy
    // of the transaction result by POST.
    'callbackURL'   => '',

    // signing algorithm. Available: SHA512, SHA256, SHA1, MD5, CRC32. Default one: SHA512
    'signatureAlgorithm' => '',

    // is set via MMS
    'signaturePassphrase' => '',
];
```

<a name="usage"></a>
## Usage

Following are some ways through which you can access the paypal provider:

```php
// Import the class namespaces first, before using it directly
use Amorphine\CardPayGo\Services\HostedForm;

$provider = new HostedForm;

// Through facade. No need to import namespaces
$provider = CardPayGo::setProvider('hosted_form');      // To use express hosted form(used by default).

$provider->addFormOptions($order_model->getCardPayGoData()); // add more form options like amount etc.

$data = $provider->getFormData(); // get array of form data you can use the way you like. F.e. you can render it as html-form to be submitted

```

## Support

This plugin only supports Laravel 5.1 or greater.
* In case of any issues, kindly create one on the [Issues](https://github.com/srmklive/laravel-paypal/issues) section.
* If you would like to contribute:
  * Fork this repository.
  * Implement your features.
  * Generate pull request.
 
