<!-- ![LeanxSdk](.github/logo.png?raw=true) -->

# LeanxSdk, PHP SDK for LeanX Integration

<!-- [![Latest Version](https://img.shields.io/github/release/wiraazharan/leanx-sdk.svg?style=flat-square)](https://github.com/wiraazharan/leanx-sdk/releases)
[![Build Status](https://img.shields.io/github/actions/workflow/status/wiraazharan/leanx-sdk/ci.yml?label=ci%20build&style=flat-square)](https://github.com/wiraazharan/leanx-sdk/actions?query=workflow%3ACI) -->
<!-- [![Total Downloads](https://img.shields.io/packagist/dt/wiraazharan/leanx-sdk.svg?style=flat-square)](https://packagist.org/packages/wiraazharan/leanx-sdk) -->

LeanxSdk is a PHP SDK designed to simplify integration with the LeanX payment API. This SDK provides easy-to-use methods for generating payment links, validating payments, and checking payment statuses.

- Easy setup and usage for LeanX payment integration.
- Flexible configuration with dynamic base URLs and endpoints.
- Comprehensive support for generating and managing payments.

## Basic Usage

To get started with `LeanxSdk`, follow these steps:

### Instantiate the SDK
```php
use Wiraazharan\LeanxSdk\LeanxSdk;

// Base URL for LeanX API (use sandbox or live URL as needed)
$baseUrl = 'https://api.leanx.dev';
// Replace 'your-auth-token' with your actual LeanX auth token
$authToken = 'LP-922AFF8C-MM|cdffb385-7f8b-4fa8-9bdf-5563c7b6c2cb|a59592d0bf0620ac09ee406b91f7006b59b96a35d1406dc3101e383dfa9abf820686064e7b281adc71a3a3a36eed5xxxxxxxxxxxxe41ad25a0d07axxxxx';
// Replace 'hashKey' with your actual LeanX Hash Key
$hashKey = 'a59592d0bf0620ac09ee406b91f7006b59b96a35d1406dc3101e383dfa9abf820686064e7b281adc71a3a3xxxxxxxe1ae77b39e41ad25a0d07a2525531';
// Replace 'UUID' with your actual LeanX UUID
$UUID = 'cdffb385-7f8b-xxxxxxx-c7b6c2cb';

// Create a new instance of the SDK
$sdk = new LeanxSdk($baseUrl, $authToken, $hashKey, $UUID);
```

### Generate a Payment Link
### To generate a payment link, use the GeneratePaymentLinkv1 method. Here is an example of how to use it:
``` php
$parameters = [
    'amount' => 100.00,
    'full_name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'phone_number' => '0123456789',
    'invoice_no' => 'INV12345',
    'redirect_url' => 'https://yourwebsite.com/redirect',
    'callback_url' => 'https://yourwebsite.com/callback'
];

$response = $sdk->GeneratePaymentLinkv1($parameters);
print_r($response);
```

### Generate a HMAC Payment Link
### To generate a HMAC payment link, use the GeneratePaymentLinkv1WithHashmac method. Here is an example of how to use it:
``` php
$parameters = [
    'amount' => 100.00,
    'full_name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'phone_number' => '0123456789',
    'invoice_no' => 'INV12345',
    'redirect_url' => 'https://yourwebsite.com/redirect',
    'callback_url' => 'https://yourwebsite.com/callback'
];

$response = $sdk->GeneratePaymentLinkv1WithHashmac($parameters);
print_r($response);
```

### Generate Auto Bill Page
### To generate Auto Bill Page, use the CreateAutoBillPagev1WithHashmac method. Here is an example of how to use it:
``` php
$parameters = [
    'amount' => 100.00,
    'full_name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'phone_number' => '0123456789',
    'invoice_no' => 'INV12345',
    'redirect_url' => 'https://yourwebsite.com/redirect',
    'callback_url' => 'https://yourwebsite.com/callback'
];

$response = $sdk->CreateAutoBillPagev1WithHashmac($parameters);
print_r($response);
```

### Check Payment Status
```php
$invoiceNo = 'INV12345';

$response = $sdk->CheckPaymentStatusV1WithHmac($invoiceNo);
print_r($response);
```