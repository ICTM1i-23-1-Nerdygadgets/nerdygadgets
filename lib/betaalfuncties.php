<?php

require_once "./vendor/autoload.php";
$_ENV = parse_ini_file('.env');

$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey($_ENV["MOLLIE_API_KEY"]);

function getIssuers() {
    global $mollie;
    $issuers = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
    return $issuers;
}

function createPayment($amount, $selectedIssuerId, $orderId) {
    global $mollie;
    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => "$amount"
        ],
        "method" => \Mollie\Api\Types\PaymentMethod::IDEAL,
        "description" => "Order #{$orderId}",
        "redirectUrl" => $_ENV["WEB_URL"] . "/account.php?page=order&nr=" . $orderId,
        "webhookUrl"  => $_ENV["WEB_URL"] . "/webhook.php",
        "metadata" => [
            "order_id" => $orderId,
        ],
        
        "issuer" => ! empty($selectedIssuerId) ? $selectedIssuerId : null,
    ]);
    return $payment;
}

