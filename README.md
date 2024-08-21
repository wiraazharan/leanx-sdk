## LeanxSdk, PHP SDK for LeanX Integration

LeanxSdk is a PHP SDK designed to simplify integration with the LeanX payment API. This SDK provides easy-to-use methods for generating payment links, validating payments, and checking payment statuses.

*   Easy setup and usage for LeanX payment integration.
*   Flexible configuration with dynamic base URLs and endpoints.
*   Comprehensive support for generating and managing payments.

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

```php
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

### Check Payment Status

```php
$invoiceNo = 'INV12345';

$response = $sdk->CheckPaymentStatusV1($invoiceNo);
print_r($response);
```

### Payment Services List

```php
$parameters = [
  "payment_type" => "WEB_PAYMENT",
  "payment_status" => "active",
  "payment_model_reference_id" => 1,
];

$response = $sdk->GetPaymentServices($parameters);
print_r($response);
```

---

## HMAC Endpoints

---

### Generate a Payment Link

```php
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

```php
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

### Payment Services List

```php
$parameters = [
  "payment_type" => "WEB_PAYMENT",
  "payment_status" => "active",
  "payment_model_reference_id" => 1,
];

$response = $sdk->GetPaymentServicesHmac($parameters);
print_r($response);
```

---

## Callback Decode Helper

---

```php
$callbackData = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpbnZvaWNlX25vIjoiSU5WMTIzNDUwMDAzIiwiY2xpZW50X2RhdGEiOnsibWVyY2hhbnRfaW52b2ljZV9ubyI6IklOVjEyMzQ1MDAwMyIsInV1aWQiOiJjZGZmYjM4NS03ZjhiLTRmYTgtOWJkZi01NTYzYzdiNmMyY2IiLCJvcmRlcl9pZCI6Ik5vbmUifSwiaW52b2ljZV9zdGF0dXNfaWQiOjIsImludm9pY2VfdHlwZV9pZCI6MSwiaW52b2ljZV90eXBlIjoiTk9STUFMX0NPTExFQ1RJT04iLCJpbnZvaWNlX3N0YXR1cyI6IlNVQ0NFU1MiLCJhbW91bnQiOiI1MS4wMCIsInBheW1lbnRfbW9kZWxfcmVmZXJlbmNlX2lkIjoxLCJyYXRlX3R5cGVfcmVmZXJlbmNlX2lkIjoxLCJwYXltZW50X3NlcnZpY2VfaWQiOjI5LCJjbGllbnRfcmVkaXJlY3RfdXJsIjoiaHR0cHM6Ly93ZWJob29rLnNpdGUvYjMzMTJhZmEtOGIyNy00OWIxLWEwNWYtNDgyZTdhNWM3NjRlIiwiY2xpZW50X2NhbGxiYWNrX3VybCI6Imh0dHBzOi8vc3RhZy1hcGkubGVhbnBheS5teS9hcGkvdjEvY2FsbGJhY2stdXJsL2NhbGxiYWNrLXJlZGlyZWN0P191dWlkPWNkZmZiMzg1LTdmOGItNGZhOC05YmRmLTU1NjNjN2I2YzJjYiZvcmRlcl9pZD1Ob25lIiwiY2xpZW50X3RyYW5zYWN0aW9uX2RldGFpbHMiOm51bGwsInByZWZ1bmRfY29sbGVjdGlvbiI6eyJpdGVtIjpudWxsLCJyZXNwb25zZV9jb2RlIjoyMTAwfSwiZGVzY3JpcHRpb24iOm51bGwsImNhcmRfdG9rZW4iOm51bGwsImZweF9kZWJpdF9hdXRoX2NvZGUiOm51bGwsImZweF9jcmVkaXRfYXV0aF9jb2RlIjpudWxsLCJmcHhfZGViaXRfc3RhdHVzIjoiIiwidHJhbnNhY3Rpb25fcmVzcG9uc2VfdGltZSI6IjIxIEF1Z3VzdCAyNCAwMzoxNjozMSBQTSIsIm9yaWdpbmFsX3RyYW5zYWN0aW9uX3Jlc3BvbnNlX3RpbWUiOiIyMDI0LTA4LTIxIDE1OjE2OjMxIn0.1DQSTWKPoiIhzYfHzLrtqAeokUoR59AofSJnAOvDTuc';

$response = $sdk->DecodeCallback($callbackData);
print_r($response);
```