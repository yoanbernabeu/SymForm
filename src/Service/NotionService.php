<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NotionService
{
    private $client;
    private $param;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $param)
    {
        $this->client = $client;
        $this->param = $param;
    }

    public function makeRequest(?array $body = null): array
    {
        $response = $this->client->request(
            'POST',
            'https://api.notion.com/v1/databases/'.$this->param->get('NOTION_DATABASE').'/query',
            [
                'auth_bearer' => $this->param->get('NOTION_API'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Notion-Version' => '2021-08-16',
                ],
                'json' => $body,
            ]
        );
        return $response->toArray()['results'];
    }

    // Récupère toutes les données de notion
    public function getAll(): array
    {
        return $this->formatData($this->makeRequest());
    }

    // Récupère les données de notion pour une entrée
    public function getOne(string $id): array
    {
        $array = [
            'filter' => 
                [
                    'property' => 'id',
                    'text' => [
                        'equals' => $id,
                    ],
                ],
            ];

        return $this->formatData($this->makeRequest($array));
    }

    // Format les données
    public function formatData(array $data): array
    {
        $formattedData = [];

        foreach ($data as $value) {
            $formattedData[] = [
                'id' => $value['properties']['id']['formula']['string'],
                'nom' => $value['properties']['Nom']['title'][0]['plain_text'],
                'resume' => $value['properties']['Résumé']['rich_text'][0]['plain_text'],
                'image' => $value['properties']['Image']['files'][0]['file']['url'] ?? $value['properties']['Image']['files'][0]['file']['url'] = null,
                'prix' => $value['properties']['Prix']['number'],
                'lien' => $value['properties']['Lien']['url'],
            ];
        }

        return $formattedData;
    }

}