<?php

namespace PaymentMethods\Providers;

use PaymentMethods\Services\ConradPaymentMethodService;
use PaymentMethods\Services\GrouponPaymentMethodService;
use PaymentMethods\Services\LidlPaymentMethodService;
use PaymentMethods\Services\MiscPaymentMethodService;
use PaymentMethods\Services\OttoAustriaPaymentMethodService;
use PaymentMethods\Services\OwnUsePaymentMethodService;
use PaymentMethods\Services\PaymentMethodService;
use PaymentMethods\Services\ReturnGeneralPaymentMethodService;
use PaymentMethods\Services\ReturnInternalPaymentMethodService;
use PaymentMethods\Services\ReturnTechnisatPaymentMethodService;
use PaymentMethods\Services\ReturnTelestarPaymentMethodService;
use PaymentMethods\Services\StationaryFinancingPaymentMethodService;
use PaymentMethods\Services\StationaryInvoicePaymentMethodService;
use PaymentMethods\Services\StationaryInvoicePaymentPaymentMethodService;
use PaymentMethods\Services\TechnigroupPaymentMethodService;
use PaymentMethods\Services\VoelknerPaymentMethodService;
use PaymentMethods\Services\WunschgutscheinPaymentMethodService;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodContainer;
use Plenty\Plugin\ServiceProvider;

/**
 * Class MainServiceProvider
 * @package PaymentMethods\Providers
 */
class MainServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    /**
     * Boot additional services for the payment method
     *
     * @param PaymentMethodContainer $payContainer
     */
    public function boot(
        PaymentMethodContainer $payContainer
    ) {

        /** @var PaymentMethodService[] $paymentMethods */
        $paymentMethods = [
            pluginApp(ConradPaymentMethodService::class),
            pluginApp(GrouponPaymentMethodService::class),
            pluginApp(LidlPaymentMethodService::class),
            pluginApp(MiscPaymentMethodService::class),
            pluginApp(OwnUsePaymentMethodService::class),
            pluginApp(ReturnGeneralPaymentMethodService::class),
            pluginApp(ReturnInternalPaymentMethodService::class),
            pluginApp(ReturnTechnisatPaymentMethodService::class),
            pluginApp(ReturnTelestarPaymentMethodService::class),
            pluginApp(StationaryFinancingPaymentMethodService::class),
            pluginApp(StationaryInvoicePaymentMethodService::class),
            pluginApp(TechnigroupPaymentMethodService::class),
            pluginApp(VoelknerPaymentMethodService::class),
            pluginApp(WunschgutscheinPaymentMethodService::class),
            pluginApp(StationaryInvoicePaymentPaymentMethodService::class),
            pluginApp(OttoAustriaPaymentMethodService::class)
        ];
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethod->createMopIfNotExists();
            $payContainer->register($paymentMethod->getCompleteKey(), get_class($paymentMethod), []);
        }
    }
}
