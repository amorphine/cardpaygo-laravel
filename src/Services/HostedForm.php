<?php

namespace Amorphine\CardPayGo\Services;

/**
 * Class HostedForm
 *
 * Represents HostedForm payment method
 *
 * @package Amorphine\CardPayGo\Services
 */
class HostedForm {
    const CONFIG_KEY_MERCHANT_ID    = 'merchantID';
    const CONFIG_KEY_MERCHANT_PWD   = 'merchantPwd';
    const CONFIG_KEY_COUNTRY_CODE   = 'countryCode';
    const CONFIG_KEY_CURRENCY_CODE  = 'currencyCode';
    const CONFIG_KEY_ACTION         = 'action';
    const CONFIG_KEY_CALLBACK_URL   = 'callbackURL';
    const CONFIG_KEY_SIGNATURE_ALGORITHM    = 'signatureAlgorithm';
    const CONFIG_KEY_SIGNATURE_PASSPHRASE   = 'signaturePassphrase';

    const PAYMENT_ACTION_SALE = 'SALE';
    const PAYMENT_ACTION_PREAUTH = 'PREAUTH';

    const INTEGRATION_URL =  'https://app.cardpaygo.com/paymentform/';

    const DEFAULT_SIGNATURE_HASH_ALGO = 'SHA512';

    /**
     * @var array CardPayGo configuration
     */
    public $config = [];

    /**
     * @var array Additional options
     */
    public $options = [];

    /**
     * @var array Additional options should be included into request form
     */
    public $formOptions = [];


    /**
     * CardPayGo HostedForm Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        // Setting PayPal API Credentials
        $this->resolveConfig($config);
    }

    /**
     * Apply base config. If not laravel app passed config is used.
     * Otherwise the config is being resolved via laravel config mechanism
     *
     * @param array $config
     *
     * @return void
     */
    private function resolveConfig(array $config = [])
    {
        if (count($config)) {
            $this->loadConfig($config);
        } else {
            if (function_exists('config')) {
                $this->loadConfig(
                    config('cardpaygo')
                );
            }
        }
    }

    /**
     * Load config and apply it to the class' one
     *
     * @param array $config
     */
    private function loadConfig(array $config = []) {
        // Setting PayPal API Credentials
        collect($config)->map(function ($value, $key) {
            $this->config[$key] = $value;
        });
    }

    /**
     * Set config key with a value
     *
     * @param $key
     * @param $value
     */
    public function setConfigValue(string $key, $value) {
        $this->config[$key] = $value;
    }

    /**
     * Get config value
     *
     * @param $key
     * @return bool
     */
    public function getConfigValue(string $key) {
        return isset($this->config[$key]) ? $this->config[$key] : false;
    }

    /**
     * Add options to be rendered in form
     *
     * @param array $options
     */
    public function addFormOptions(array $options=[]) {
        if (!count($options)) {
            return;
        }

        collect($options)->map(function ($value, $key) {
            $this->formOptions[$key] = $value;
        });
    }

    /**
     * Get form data to generate POST form
     *
     * @return array
     */
    public function getFormData() {
        $form_data = [
            // config values
            'merchantID'    => $this->config[self::CONFIG_KEY_MERCHANT_ID],
            'merchantPwd'   => $this->config[self::CONFIG_KEY_MERCHANT_PWD],
            'countryCode'   => $this->config[self::CONFIG_KEY_COUNTRY_CODE],
            'currencyCode'  => $this->config[self::CONFIG_KEY_CURRENCY_CODE],
            'action'        => $this->config[self::CONFIG_KEY_ACTION] ?: self::PAYMENT_ACTION_SALE,
            'callbackURL'   => $this->config[self::CONFIG_KEY_CALLBACK_URL],

            // dynamic values
            //'type'          => $this->formOptions['type'] ?: 1,
            'amount' => $this->formOptions['amount'],
            'transactionUnique' => $this->formOptions['transactionUnique'],
            'orderRef'      => $this->formOptions['orderRef'],
            'redirectURL'   => $this->formOptions['redirectURL'],
        ];

        // clean up empty values
        $form_data = array_filter($form_data, function ($value) {
             return !empty($value);
        });

        // add signature
        $signature = $this->getSignature($form_data);

        // check algorithm name. If it's not SHA512, prepend signature with algorithm name
        $algorithm = $this->getSignatureAlgorithm();
        if ($algorithm !== self::DEFAULT_SIGNATURE_HASH_ALGO) {
            $signature = "({$algorithm})".$signature;
        }

        //add signature to form fields
        $form_data['signature'] = $signature;

        return $form_data;
    }

    /**
     * Get signature for form fields
     * Signature algorithm and preshared key is resolved through config
     *
     * @param array $form_data
     * @return string
     */
    private function getSignature(array $form_data = []) {
        ksort($form_data);
        $algorithm = $this->getSignatureAlgorithm();
        $string = http_build_query($form_data).$this->getConfigValue(self::CONFIG_KEY_SIGNATURE_PASSPHRASE);

        return hash($algorithm, $string);
    }

    /**
     * Get algorithm to generate hash for signature
     *
     * @return string - algorithm name. Default is SHA512
     */
    public function getSignatureAlgorithm() {
        return $this->getConfigValue(self::CONFIG_KEY_SIGNATURE_ALGORITHM) ?: self::DEFAULT_SIGNATURE_HASH_ALGO;
    }
}