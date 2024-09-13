<?php

namespace App\Controller\Service;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PopulateItemDb
{
    private $client;
    private $em;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $em)
    {
        $this->client = $client;
        $this->em = $em;
    }

    public function fetchItemData(): array
    {
        $response = $this->client->request(
            'GET',
            'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/items.json'
        );

        return $response->toArray();
    }

    public function getItemData(array $data): array
    {
        $getData = [];

        foreach ($data as $itemData) {
            $getData[] = [
                'name' => $itemData['name'],
                'description' => $itemData['description'],
                'icon' => $itemData['iconPath'],
                'cost' => $itemData['priceTotal'],
                'inShop' => $itemData['inStore'],
                'inSet' => $itemData['displayInItemSets'],

            ];
        }

        return $getData;
    }

    public function saveItemData(array $itemData)
    {

        $itemRepo = $this->em->getRepository(Item::class);

        foreach ($itemData as $data) {

            if (!$data['inShop']) {
                continue; 
            }

            if (!$data['inSet']) {
                continue;
            }

            $itemName = $data['name'];
            $itemIcon = $data['icon'];
            $itemDescription = htmlspecialchars_decode($data['description']);

            $item = $itemRepo->findOneBy(['name' => $itemName]);

            if (!$item) {
                $item = new Item();
                $item->setName($itemName);
            }

            $item->setCost($data['cost']);

            $item->setDescription($itemDescription);

            $iconFileName = strtolower(basename($itemIcon));
            $iconUrl = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/assets/items/icons2d/' . $iconFileName . '';
            $item->setIcon($iconUrl);



            $this->em->persist($item);
        }

        $this->em->flush();
    }
}
