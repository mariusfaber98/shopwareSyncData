<?php declare(strict_types=1);

namespace SyncData\Import;

use SyncData\Adapter\FakeStoreApiAdapter;
use SyncData\Mapper\ProductMapper;
use SyncData\Service\SyncDataService;
use Vin\ShopwareSdk\Service\ApiResponse;

class ProductImport
{
    private FakeStoreApiAdapter $fakeStoreApiAdapter;

    private ProductMapper $productMapper;

    private SyncDataService $syncDataService;

    public function __construct(FakeStoreApiAdapter $fakeStoreApiAdapter, ProductMapper $productMapper, SyncDataService $syncDataService)
    {
        $this->fakeStoreApiAdapter = $fakeStoreApiAdapter;
        $this->productMapper = $productMapper;
        $this->syncDataService = $syncDataService;
    }

    public function importProducts(): ApiResponse
    {
        $products = $this->fakeStoreApiAdapter->getProducts();

        foreach ($products as $product)
        {
            $payload[] = array (
                'id' => $this->productMapper->getId($product),
                'productNumber' => $this->productMapper->getProductNumber($product),
                'taxId' => $this->productMapper->getTaxId($product),
                'stock' => $this->productMapper->getStock($product),
                'name' =>  $this->productMapper->getName($product),
                'description' => $this->productMapper->getDescription($product),
                'manufacturer' => $this->productMapper->getManufacturer($product),
                'media' => $this->productMapper->getMedia($product),
                'coverId' => $this->productMapper->getCoverId($product),
                'categories' => $this->productMapper->getCategories($product),
                'price' => $this->productMapper->getPrice($product),
                'visibilities' => $this->productMapper->getVisibilities($product),
            );
        }

        return $this->syncDataService->sync('product', $payload);
    }

}