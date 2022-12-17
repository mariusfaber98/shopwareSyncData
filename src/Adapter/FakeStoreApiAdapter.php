<?php declare(strict_types=1);

namespace SyncData\Adapter;

use GuzzleHttp\Client;

class FakeStoreApiAdapter
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }
    public function getProducts(): array
    {
        $response = $this->client->request('GET', 'https://fakestoreapi.com/products?limit=5');

        $content = json_decode($response->getBody()->getContents(), true);

        foreach($content as $item)
        {
            $media = array($item['image'],'https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg');

            $products[] = array(
                'id' => $item['id'],
                'title' => $item['title'],
                'price' => $item['price'],
                'description' => $item['description'],
                'category' => $item['category'],
                'media' => $media,
                'manufacturer' => 'shopware AG',
                'taxRate' => 19.00,
                'stock' => 10,
            );
        }

        return $products;
    }
}