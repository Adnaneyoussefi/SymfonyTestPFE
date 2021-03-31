<?php

namespace App\Service;

use App\Service\Iservice;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherAPI implements Iservice {

    private $api_weather;
    private $client;

    public function __construct(string $api_weather, HttpClientInterface $client)
    {
        $this->api_weather = $api_weather;
        $this->client = $client;
    }

    public function getModels(): array {
        
       return [];
    }

    public function getModel($id): array
    {
        $res = $this->client->request(
            'GET',
            $this->api_weather.'?q='.$id.'&appid=54df8d8dec65889a7f5068971c6cc858'
        );
        return $res->toArray();
    }
}