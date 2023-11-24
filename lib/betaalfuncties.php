<?php

require_once __DIR__ . "./vendor/autoload.php";
$_ENV = parse_ini_file('.env');

$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey($_ENV["MOLLIE_API_KEY"]);

function getIssuers() {
    global $mollie;
    $issuers = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
    return $issuers;
}

function createPayment($amount, $description, $selectedIssuerId, $orderId) {
    global $mollie;
    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => "$amount"
        ],
        "description" => "$description",
        "redirectUrl" => $_ENV["WEB_URL"] . "/payment/success.php?order_id=" . $orderId,
        "webhookUrl"  => $_ENV["WEB_URL"] . "/payment/webhook.php",
        "method"      => \Mollie\Api\Types\PaymentMethod::IDEAL,
        "issuer"      => $selectedIssuerId, // e.g. "ideal_INGBNL2A"
    ]);
    return $payment->getCheckoutUrl();
}

