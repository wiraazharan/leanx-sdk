<?php

namespace Wiraazharan\LeanxSdk;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use stdClass;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class LeanxSdk
{
    protected $client;
    protected $authToken;
    protected $baseUrl;
    protected $hashKey;
    protected $UUID;

    public function __construct(string $baseUrl, string $authToken, string $hashKey, string $UUID)
    {
        $this->authToken = $authToken;
        $this->hashKey = $hashKey;
        $this->UUID = $UUID;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->client = new Client();
    }

    //NON HMAC ENDPOINTS;
    public function GeneratePaymentLinkv1(array $parameters)
    {
        $URLPATH = "/api/v1/merchant/create-bill-page";
        $HTTPMETHOD = "POST";
        $endpoint = $this->baseUrl . $URLPATH;

        $header = [
            'Content-Type' => 'application/json',
            'auth-token' => $this->authToken,
        ];

        $body = $parameters;
        $response = json_decode($this->PostRequestMamJsonBody($endpoint, $header, $body));
        $responses = [
            // "url" => $endpoint,
            // "header" => $header,
            // "body" => $body,
            "response" => $response,
        ];
        return $responses;
    }
    public function CheckPaymentStatusV1(string $invoiceNo)
    {
        $URLPATHFORSIGNATURE = "/api/v1/merchant/manual-checking-transaction";
        $URLPATH = "/api/v1/merchant/manual-checking-transaction?invoice_no=" . $invoiceNo;
        $HTTPMETHOD = "POST";
        $endpoint = $this->baseUrl . $URLPATH;

        //GENERATE SIGNATURE
        $signatures = $this->GenerateSignature($this->UUID, $this->authToken, $this->hashKey, $HTTPMETHOD, $URLPATHFORSIGNATURE);
        //GENERATE SIGNATURE

        $header = [
            'Content-Type' => 'application/json',
            'auth-token' => $this->authToken,
        ];

        $body = [];
        $response = json_decode($this->PostRequestLeanx($endpoint, $header, $body));
        $responses = [
            // "url" => $endpoint,
            // "header" => $header,
            // "body" => $body,
            "response" => $response,
        ];
        return $responses;
    }
    public function GetPaymentServices(array $parameters)
    {
        $URLPATH = "/api/v1/merchant/list-payment-services";
        $HTTPMETHOD = "POST";
        $endpoint = $this->baseUrl . $URLPATH;

        // Prepare the request headers
        $header = [
            'Content-Type' => 'application/json',
            'auth-token' => $this->authToken,
        ];

        // Prepare the request body
        $body = $parameters;

        // Make the POST request and get the response
        $response = json_decode($this->PostRequestMamJsonBody($endpoint, $header, $body));

        // Prepare and return the response details
        $responses = [
            // "url" => $endpoint,
            // "header" => $header,
            // "body" => $body,
            "response" => $response,
        ];
        return $responses;
    }
    //NON HMAC ENDPOINTS;

    //HMAC ENDPOINTS;
    public function GeneratePaymentLinkv1WithHashmac(array $parameters)
    {
        $URLPATHFORSIGNATURE = "/api/v1/merchant/create-bill-page";
        $URLPATH = "/api/v1/merchant/create-bill-page";
        $HTTPMETHOD = "POST";
        $endpoint = $this->baseUrl . $URLPATH;

        //GENERATE SIGNATURE
        $signatures = $this->GenerateSignature($this->UUID, $this->authToken, $this->hashKey, $HTTPMETHOD, $URLPATHFORSIGNATURE);
        //GENERATE SIGNATURE

        $header = [
            'Content-Type' => 'application/json',
            'auth-token' => $this->authToken,
            'x-signature' => $signatures["x-signature"],
            'x-timestamp' => $signatures["x-timestamp"],
            'x-nonce' => $signatures["x-nonce"],
        ];

        $body = $parameters;

        $response = json_decode($this->PostRequestMamJsonBody($endpoint, $header, $body));
        $responses = [
            // "url" => $endpoint,
            // "signature" => $signatures,
            // "header" => $header,
            // "body" => $body,
            "response" => $response,
        ];
        return $responses;
    }
    public function CreateAutoBillPagev1WithHashmac(array $parameters)
    {
        $URLPATHFORSIGNATURE = "/api/v1/merchant/create-auto-bill-page";
        $URLPATH = "/api/v1/merchant/create-auto-bill-page";
        $HTTPMETHOD = "POST";
        $endpoint = $this->baseUrl . $URLPATH;

        //GENERATE SIGNATURE
        $signatures = $this->GenerateSignature($this->UUID, $this->authToken, $this->hashKey, $HTTPMETHOD, $URLPATHFORSIGNATURE);
        //GENERATE SIGNATURE

        $header = [
            'Content-Type' => 'application/json',
            'auth-token' => $this->authToken,
            'x-signature' => $signatures["x-signature"],
            'x-timestamp' => $signatures["x-timestamp"],
            'x-nonce' => $signatures["x-nonce"],
        ];

        $body = $parameters;

        $response = json_decode($this->PostRequestMamJsonBody($endpoint, $header, $body));
        $responses = [
            // "url" => $endpoint,
            // "signature" => $signatures,
            // "header" => $header,
            // "body" => $body,
            "response" => $response,
        ];
        return $responses;
    }
    public function CheckPaymentStatusV1WithHmac(string $invoiceNo)
    {
        $URLPATHFORSIGNATURE = "/api/v1/merchant/manual-checking-transaction";
        $URLPATH = "/api/v1/merchant/manual-checking-transaction?invoice_no=" . $invoiceNo;
        $HTTPMETHOD = "POST";
        $endpoint = $this->baseUrl . $URLPATH;

        //GENERATE SIGNATURE
        $signatures = $this->GenerateSignature($this->UUID, $this->authToken, $this->hashKey, $HTTPMETHOD, $URLPATHFORSIGNATURE);
        //GENERATE SIGNATURE

        $header = [
            'Content-Type' => 'application/json',
            'auth-token' => $this->authToken,
            'x-signature' => $signatures["x-signature"],
            'x-timestamp' => $signatures["x-timestamp"],
            'x-nonce' => $signatures["x-nonce"],
        ];

        $body = [];
        $response = json_decode($this->PostRequestLeanx($endpoint, $header, $body));
        $responses = [
            // "url" => $endpoint,
            // "signature" => $signatures,
            // "header" => $header,
            // "body" => $body,
            "response" => $response,
        ];
        return $responses;
    }
    public function GetPaymentServicesHmac(array $parameters)
    {
        $URLPATHFORSIGNATURE = "/api/v1/merchant/list-payment-services";
        $URLPATH = "/api/v1/merchant/list-payment-services";
        $HTTPMETHOD = "POST";
        $endpoint = $this->baseUrl . $URLPATH;

        //GENERATE SIGNATURE
        $signatures = $this->GenerateSignature($this->UUID, $this->authToken, $this->hashKey, $HTTPMETHOD, $URLPATHFORSIGNATURE);
        //GENERATE SIGNATURE

        $header = [
            'Content-Type' => 'application/json',
            'auth-token' => $this->authToken,
            'x-signature' => $signatures["x-signature"],
            'x-timestamp' => $signatures["x-timestamp"],
            'x-nonce' => $signatures["x-nonce"],
        ];

        // Prepare the request body
        $body = $parameters;

        // Make the POST request and get the response
        $response = json_decode($this->PostRequestMamJsonBody($endpoint, $header, $body));

        // Prepare and return the response details
        $responses = [
            // "url" => $endpoint,
            // "header" => $header,
            // "body" => $body,
            "response" => $response,
        ];
        return $responses;
    }
    //HMAC ENDPOINTS;


    //DECODE CALLBACK
    public function DecodeCallback($payload)
    {
        $secretKey = $this->hashKey;
        try {
            // Decode the JWT using the provided secret key and algorithm
            $decoded = JWT::decode($payload, new Key($secretKey, 'HS256'));
            return (array) $decoded; // Convert the decoded object to an array
        } catch (ExpiredException $e) {
            // Handle expired token
            return ['error' => 'Token expired'];
        } catch (SignatureInvalidException $e) {
            // Handle invalid signature
            return ['error' => 'Invalid token signature'];
        } catch (\Exception $e) {
            // Handle other possible exceptions
            return ['error' => 'Invalid token: ' . $e->getMessage()];
        }
    }
    //DECODE CALLBACK



    //TOOLBOX

    protected function sendRequest(string $method, string $endpoint, array $parameters = [], bool $json = false)
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'auth-token' => $this->authToken,
            'Accept' => 'application/json'
        ];

        if ($json) {
            $headers['Content-Type'] = 'application/json';
            $body = $parameters;
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

    protected static function PostRequestMamPlainText($endpoint, $header = null, $body)
    {

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;
        } catch (Exception $e) {
            // $obj = new stdClass;
            // $obj->respDesc = Psr7\str($e->getRequest());
            // return json_encode($obj);
            return $e->getMessage();
        }
    }

    protected static function PostRequestMam($endpoint, $header = null, $body)
    {

        try {
            if ($header == null) {
                $client = new Client([
                    'headers' => [
                        // 'Content-Type' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'verify' => env('SSL_VERIFICATION', false)
                ]);
            } else {
                $client = new Client([
                    'headers' => $header,
                    'verify' => env('SSL_VERIFICATION', false)
                ]);
            }

            $response = $client->post(
                $endpoint,
                [
                    'form_params' => $body,
                    'timeout' => env('REQUEST_TIMEOUT_IN_SECONDS', 3000),
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            // $obj = new stdClass;
            // $obj->respDesc = Psr7\str($e->getRequest());
            // return json_encode($obj);
            if ($e->hasResponse()) {
                $obj = new stdClass;
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                $obj->statusCode = $e->getCode();
                $obj->respDesc = $exception;
                return json_encode($obj);
            } else {
                $obj = new stdClass;
                $obj->respDesc = $e->getMessage() != null ? $e->getMessage() : "Connection Error. Check VPN and Etc..";
                // "Connection Error. Check VPN and Etc.." ;
                return json_encode($obj);
            }
        }
    }

    protected static function PostRequestMamJsonBody($endpoint, $header = null, $body)
    {

        try {
            if ($header == null) {
                $client = new Client([
                    'headers' => [
                        'Content-Type' => 'application/json',
                        // 'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'verify' => env('SSL_VERIFICATION', false)
                ]);
            } else {
                $client = new Client([
                    'headers' => $header,
                    'verify' => env('SSL_VERIFICATION', false)
                ]);
            }

            $response = $client->post(
                $endpoint,
                [
                    'json' => $body,
                    'timeout' => env('REQUEST_TIMEOUT_IN_SECONDS', 3000),
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            // $obj = new stdClass;
            // $obj->respDesc = Psr7\str($e->getRequest());
            // return json_encode($obj);
            if ($e->hasResponse()) {
                $obj = new stdClass;
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                $obj->statusCode = $e->getCode();
                $obj->respDesc = $exception;
                return json_encode($obj);
            } else {
                $obj = new stdClass;
                $obj->respDesc = $e->getMessage() != null ? $e->getMessage() : "Connection Error. Check VPN and Etc..";
                // "Connection Error. Check VPN and Etc.." ;
                return json_encode($obj);
            }
        }
    }

    protected static function PutRequestMamJsonBody($endpoint, $header = null, $body)
    {

        try {
            if ($header == null) {
                $client = new Client([
                    'headers' => [
                        'Content-Type' => 'application/json',
                        // 'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'verify' => env('SSL_VERIFICATION', false)
                ]);
            } else {
                $client = new Client([
                    'headers' => $header,
                    'verify' => env('SSL_VERIFICATION', false)
                ]);
            }

            $response = $client->put(
                $endpoint,
                [
                    'json' => $body,
                    'timeout' => env('REQUEST_TIMEOUT_IN_SECONDS', 3000),
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            // $obj = new stdClass;
            // $obj->respDesc = Psr7\str($e->getRequest());
            // return json_encode($obj);
            if ($e->hasResponse()) {
                $obj = new stdClass;
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                $obj->statusCode = $e->getCode();
                $obj->respDesc = $exception;
                return json_encode($obj);
            } else {
                $obj = new stdClass;
                $obj->respDesc = $e->getMessage() != null ? $e->getMessage() : "Connection Error. Check VPN and Etc..";
                // "Connection Error. Check VPN and Etc.." ;
                return json_encode($obj);
            }
        }
    }

    protected static function PostRequestMamMultipart($endpoint, $header = null, $body, $fileParameterName)
    {
        try {
            if ($header == null) {
                $client = new Client([
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'verify' => env('SSL_VERIFICATION', false)
                ]);
            } else {
                $client = new Client([
                    'headers' => $header,
                    'verify' => env('SSL_VERIFICATION', false)
                ]);
            }

            // Check if body contains a file parameter
            $hasFile = false;
            foreach ($body as $key => $value) {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $hasFile = true;
                    break;
                }
            }

            $multipartBody = [];
            $multipartBody[] = [
                'name' => "file",
                'contents' => fopen($body->{$fileParameterName}->path(), 'r'),
                'filename' => $body->{$fileParameterName}->getClientOriginalName()
            ];
            // dd($multipartBody);
            // foreach ($body as $key => $value) {
            //     if ($value instanceof \Illuminate\Http\UploadedFile) {
            //         $multipartBody[] = [
            //             'name' => "file",
            //             'contents' => fopen($value->path(), 'r'),
            //             'filename' => $value->getClientOriginalName()
            //         ];
            //     } else {
            //         $multipartBody[] = [
            //             'name' => $key,
            //             'contents' => $value
            //         ];
            //     }
            // }

            $response = $client->post(
                $endpoint,
                [
                    'multipart' => $multipartBody,
                    'timeout' => 300,
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $obj = new stdClass;
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                $obj->statusCode = $e->getCode();
                $obj->respDesc = $exception;
                return json_encode($obj);
            } else {
                $obj = new stdClass;
                $obj->respDesc = $e->getMessage() != null ? $e->getMessage() : "Connection Error. Check VPN and Etc..";
                return json_encode($obj);
            }
        }
    }

    protected static function PostRequestLeanx($endpoint, $header = null, $body)
    {

        try {
            if ($header == null) {
                $client = new Client([
                    'headers' => [
                        'Content-Type' => 'application/json',
                        // 'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                ]);
            } else {
                $client = new Client([
                    'headers' => $header,
                ]);
            }

            $response = $client->post(
                $endpoint,
                [
                    // 'form_params' => $body,
                    'json' => $body,
                    'timeout' => env('REQUEST_TIMEOUT_IN_SECONDS', 3000),
                ]
            );

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            // $obj = new stdClass;
            // $obj->respDesc = Psr7\str($e->getRequest());
            // return json_encode($obj);
            if ($e->hasResponse()) {
                $obj = new stdClass;
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                $obj->statusCode = $e->getCode();
                $obj->respDesc = $exception;
                $obj->response_code = 10000;
                return json_encode($obj);
            } else {
                $obj = new stdClass;
                $obj->respDesc = $e->getMessage() != null ? $e->getMessage() : "Connection Error. Check VPN and Etc..";
                $obj->response_code = 10000;
                // "Connection Error. Check VPN and Etc.." ;
                return json_encode($obj);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            $obj = new stdClass;
            $obj->respDesc = $e->getMessage() != null ? $e->getMessage() : "Connection Error. Check VPN and Etc..";
            $obj->response_code = 10000;
            // "Connection Error. Check VPN and Etc.." ;
            return json_encode($obj);
        }
    }

    protected static function GenerateSignature($UUID, $AUTH_TOKEN, $HASH_KEY, $HTTP_METHOD, $URL_PATH)
    {
        // Replace placeholders with actual values
        $PLATFORM = "api";
        $API_VERSION = "v1";

        // Replace placeholders in the URL path
        $URL_PATH = str_replace("{{PLATFORM}}", $PLATFORM, $URL_PATH);
        $URL_PATH = str_replace("{{API_VERSION}}", $API_VERSION, $URL_PATH);

        // Get the current timestamp in seconds
        $TIME_STAMP = time();

        // Generate a random UUID for the nonce
        $NONCE = self::generateUuidV4();

        // Create the message to be hashed
        $message = "{$HTTP_METHOD}|{$UUID}|{$URL_PATH}|{$TIME_STAMP}|{$AUTH_TOKEN}|{$NONCE}";

        // Generate the HMAC signature using SHA256
        $hmacSignature = hash_hmac('sha256', $message, $HASH_KEY);

        // Return the headers
        return [
            'x-signature' => $hmacSignature,
            'x-timestamp' => $TIME_STAMP,
            'x-nonce' => $NONCE
        ];
    }

    private static function generateUuidV4()
    {
        return sprintf(
            '%04x%04x-%04x-4%03x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}