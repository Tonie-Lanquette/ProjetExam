<?php

namespace App\Controller\Service;

use App\Entity\Champion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PopulateChampionDb
{
    private $client;
    private $em;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $em)
    {
        $this->client = $client;
        $this->em = $em;
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
                'role' => $championData['tags'],
                'key' => $championData['key'],
       
            ];
        }

        return $getData;
    }

    public function fetchChampionDescription(int $key): array
    {
        $response = $this->client->request(
            'GET',
            'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/champions/' . $key . '.json'
        );

        return $response->toArray();
    }

    public function saveChampionData(array $championData)
    {
        
        $championRepo = $this->em->getRepository(Champion::class);

        foreach ($championData as $data) {

            $championKey = ($data['key']);
            $champion = $championRepo->findOneBy(['championKey' => $championKey]);

            if (!$champion) {
                $champion = new Champion();
                $champion->setChampionKey($championKey); 
            }

            $championDescription = $this->fetchChampionDescription($data['key']);
            $description = $championDescription['shortBio'];

            $champion->setName($data['name']);

            $champion->setDescription($description);

            $championRole = implode(', ', $data['role']);
            $champion->setRole($championRole);

            $splashUrl = 'https://cdn.communitydragon.org/latest/champion/' . $championKey . '/splash-art';
            $champion->setSplashArt($splashUrl);

            $squarePortrait = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/champion-icons/' . $championKey . '.png';
            $champion->setSquarePortrait($squarePortrait);

            $this->em->persist($champion);
        }

        $this->em->flush();
    }

}



