<?php

namespace Rabiloo\Facebook;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Http\GraphRawResponse;
use Facebook\HttpClients\FacebookHttpClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class Guzzle6HttpClient implements FacebookHttpClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Guzzle6HttpClient constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sends a request to the server and returns the raw response.
     *
     * @param string $url The endpoint to send the request to.
     * @param string $method The request method.
     * @param string $body The body of the request.
     * @param array $headers The request headers.
     * @param int $timeOut The timeout in seconds for the request.
     * @return GraphRawResponse Raw response from the server.
     * @throws FacebookSDKException
     */
    public function send($url, $method, $body, array $headers, $timeOut)
    {
        $request = new Request($method, $url, $headers, $body);

        try {
            $response = $this->client->send($request, ['timeout' => $timeOut, 'http_errors' => false]);
        } catch (RequestException $exc) {
            throw new FacebookSDKException($exc->getMessage(), $exc->getCode());
        }

        $responseHeaders = $response->getHeaders();
        foreach ($responseHeaders as $key => $values) {
            $responseHeaders[$key] = implode(', ', $values);
        }

        $responseBody = $response->getBody()->getContents();
        $httpStatusCode = $response->getStatusCode();

        return new GraphRawResponse($responseHeaders, $responseBody, $httpStatusCode);
    }
}
