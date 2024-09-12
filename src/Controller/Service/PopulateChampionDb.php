<?php

namespace App\Controller\Service;

use App\Entity\Champion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PopulateChampionDb
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchChampionData(): array
    {
        $response = $this->client->request(
            'GET',
            'https://ddragon.leagueoflegends.com/cdn/14.17.1/data/en_GB/champion.json'
        );

        return $response->toArray();
    }

    public function getChampionData(array $data): array
    {
        $getData = [];

        foreach ($data['data'] as $championData) {
            $getData[] = [
                'name' => $championData['name'],
                'description' => $championData['blurb'],
                'role' => $championData['tags'],
                'key' => $championData['key'],
       
            ];
        }

        return $getData;
    }

    public function saveChampionData(array $championData, EntityManagerInterface $em)
    {
        foreach ($championData as $data) {

            $championRole = implode(', ', $data['role']); 
            $championKey= ($data['key']);
            $splashUrl = 'https://cdn.communitydragon.org/latest/champion/' . $championKey . '/splash-art';

            $champion = new Champion();
            $champion->setName($data['name']);
            $champion->setDescription($data['description']);
            $champion->setRole($championRole);
            $champion->setChampionKey($data['key']);
            $champion->setSplashArt($splashUrl);
        
            $em->persist($champion);
        }

        $em->flush();
    }

    public function fetchItemData(): array
    {
        $response = $this->client->request(
            'GET',
            'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/items.json'
        );

        return $response->toArray();
    }
}



