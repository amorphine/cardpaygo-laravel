<?php
/**
 * CardPayGo module Setting
 * Created by Pavel Fedin <fe-pavel@yandex.ru>.
 */

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

    'signaturePassphrase' => '',
];
