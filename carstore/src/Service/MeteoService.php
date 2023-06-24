<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class MeteoService
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchMeteo(): array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&hourly=temperature_2m&current_weather=true');
    
            $content = $response->getContent();
            $decodedData = json_decode($content, true);
            
            $data = array(
                'temp' => $decodedData['current_weather']['temperature'],
                'code' => $decodedData['current_weather']['weathercode']
            );
            
            return $data;

        } catch (ClientExceptionInterface $e) {
            return array(
                'temp' => 'N/A',
                'code' => 'N/A'
            );
        } catch (\Exception $e) {
            return array(
                'temp' => 'N/A',
                'code' => 'N/A'
            );
        }
    }
}
