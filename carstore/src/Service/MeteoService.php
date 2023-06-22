<?php

namespace App\Service\MeteoApi;

use Symfony\Contract\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class MeteoService 
{
    protected HttpClientInterface $client;
    // protected ParameterBagInterface $parameterBag;
    // ParameterBagInterface $parameterBag
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        // $this->parameterBag = $parameterBag;
    }

    public function executeRequest()
    {
        $response = $this->client->request(
            'GET',
            'https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&hourly=temperature_2m&current_weather=true'
        );


        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }
}