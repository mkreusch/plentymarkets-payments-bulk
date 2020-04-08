<?php

namespace PaymentMethods\Services;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;

abstract class PaymentMethodService extends \Plenty\Modules\Payment\Method\Contracts\PaymentMethodService
{
    const PLUGIN_KEY = 'dummyPluginKey';
    const PAYMENT_KEY = 'DummyTechName';
    const PAYMENT_NAME = 'Dummy Payment';

    public function isBackendSearchable(): bool
    {
        return true;
    }

    public function isBackendActive(): bool
    {
        return true;
    }

    public function isActive()
    {
        return true;
    }

    public function getBackendName(string $lang): string
    {
        return static::PAYMENT_NAME;
    }

    public function canHandleSubscriptions(): bool
    {
        return true;
    }

    /**
     * Create the ID of the payment method if it doesn't exist yet
     */
    public function createMopIfNotExists()
    {

        if ($this->getPaymentMethod() == 'no_paymentmethod_found') {
            /** @var PaymentMethodRepositoryContract $paymentMethodRepository */
            $paymentMethodRepository = pluginApp(PaymentMethodRepositoryContract::class);
            $paymentMethodData       = [
                'pluginKey'  => static::PLUGIN_KEY,
                'paymentKey' => static::PAYMENT_KEY,
                'name'       => static::PAYMENT_NAME
            ];
            $paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
    }

    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getPaymentMethod()
    {
        /** @var PaymentMethodRepositoryContract $paymentMethodRepository */
        $paymentMethodRepository = pluginApp(PaymentMethodRepositoryContract::class);
        $paymentMethods          = $paymentMethodRepository->allForPlugin(static::PLUGIN_KEY);
        if (!is_null($paymentMethods)) {
            foreach ($paymentMethods as $paymentMethod) {
                if ($paymentMethod->paymentKey == static::PAYMENT_KEY) {
                    return $paymentMethod->id;
                }
            }
        }
        return 'no_paymentmethod_found';
    }

    public function getCompleteKey(){
        return static::PLUGIN_KEY . '::' . static::PAYMENT_KEY;
    }
}
