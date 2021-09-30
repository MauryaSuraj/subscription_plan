<?php

//require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51IS94qHFpfnFc9xoqspqHVCVrps6mFetZvEPe1IjEnQ0NiEF61H0EflPmT2VVVxB3Hx7lRbBvDC0Z32Mb6Sghbve00peN8KgV6');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:4242/public';

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    # TODO: replace this with the `price` of the product you want to sell
    'price' => '{{PRICE_ID}}',
    'quantity' => 1,
  ]],
  'payment_method_types' => [
    'card',
  ],
  'mode' => 'payment',
  'success_url' => $CFG->wwwroot . '/local/subscription_plan/success.html',
  'cancel_url' => $CFG->wwwroot . '/local/subscription_plan/cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);