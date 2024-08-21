<?php

namespace Wiraazharan\LeanxSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class LeanxSdk
{
    protected $client;
    protected $authToken;
    protected $baseUrl;

    public function __construct(string $authToken, string $baseUrl)
    {
        $this->authToken = $authToken;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->client = new Client();
    }

    public function generatePaymentLink(array $parameters)
    {
        $endpoint = '/merchant/create-bill-page';
        return $this->sendRequest('POST', $endpoint, $parameters);
    }

    public function validatePayment(array $parameters)
    {
        $endpoint = '/merchant/validate';
        return $this->sendRequest('POST', $endpoint, $parameters);
    }

    public function checkPaymentStatus(string $invoiceNo)
    {
        $endpoint = '/merchant/manual-checking-transaction';
        return $this->sendRequest('GET', $endpoint, ['invoice_no' => $invoiceNo]);
    }

    public function createBillPage(array $parameters)
    {
        $endpoint = '/merchant/create-bill-page';
        return $this->sendRequest('POST', $endpoint, $parameters, true);
    }

    protected function sendRequest(string $method, string $endpoint, array $parameters = [], bool $json = false)
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'auth-token' => $this->authToken,
            'Accept' => 'application/json'
        ];

        if ($json) {
            $headers['Content-Type'] = 'application/json';
            $body = json_encode($parameters);
        } else {
            $body = http_build_query($parameters);
        }

        $request = new Request($method, $url, $headers, $body);

        try {
            $response = $this->client->sendAsync($request)->wait();
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}