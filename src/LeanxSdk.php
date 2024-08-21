<?php

namespace Wiraazharan\LeanxSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class LeanxSdk
{
    private $client;
    private $authToken;
    private $baseUrl;

    public function __construct($authToken, $baseUrl)
    {
        $this->authToken = $authToken;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'auth-token' => $this->authToken,
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function request($method, $endpoint, $parameters = [])
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'json' => $parameters,
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents(), true);
            }
            return ['error' => $e->getMessage()];
        }
    }

    public function generatePaymentLink(array $parameters)
    {
        return $this->request('POST', '/api/v1/merchant/create-bill-page', $parameters);
    }

    public function validatePayment(array $parameters)
    {
        return $this->request('POST', '/api/v1/merchant/validate', $parameters);
    }

    public function checkPaymentStatus($invoiceNo)
    {
        $endpoint = '/api/v1/merchant/manual-checking-transaction';
        $parameters = ['invoice_no' => $invoiceNo];
        return $this->request('GET', $endpoint, $parameters);
    }
}
