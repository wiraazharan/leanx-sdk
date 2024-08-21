![LeanxSdk](.github/logo.png?raw=true)

# LeanxSdk, PHP SDK for LeanX Integration

[![Latest Version](https://img.shields.io/github/release/wiraazharan/leanx-sdk.svg?style=flat-square)](https://github.com/wiraazharan/leanx-sdk/releases)
[![Build Status](https://img.shields.io/github/actions/workflow/status/wiraazharan/leanx-sdk/ci.yml?label=ci%20build&style=flat-square)](https://github.com/wiraazharan/leanx-sdk/actions?query=workflow%3ACI)
[![Total Downloads](https://img.shields.io/packagist/dt/wiraazharan/leanx-sdk.svg?style=flat-square)](https://packagist.org/packages/wiraazharan/leanx-sdk)

LeanxSdk is a PHP SDK designed to simplify integration with the LeanX payment API. This SDK provides easy-to-use methods for generating payment links, validating payments, and checking payment statuses.

- Easy setup and usage for LeanX payment integration.
- Supports both synchronous and asynchronous requests.
- Flexible configuration with dynamic base URLs and endpoints.
- Comprehensive support for generating and managing payments.

## Basic Usage

To get started with `LeanxSdk`, follow these steps:

### Instantiate the SDK

```php
use Wiraazharan\LeanxSdk\LeanxSdk;

// Replace 'your-auth-token' with your actual LeanX auth token
$authToken = 'your-auth-token';
// Base URL for LeanX API (use sandbox or live URL as needed)
$baseUrl = 'https://stag-api.leanpay.my';

// Create a new instance of the SDK
$sdk = new LeanxSdk($authToken, $baseUrl);