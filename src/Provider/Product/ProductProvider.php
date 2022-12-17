<?php declare(strict_types=1);

namespace SyncData\Provider\Product;

use SyncData\Service\UuidService;

class ProductProvider
{
    private UuidService $uuidService;

    public function __construct(UuidService $uuidService)
    {
        $this->uuidService = $uuidService;
    }

    public function getId($product): string
    {
        return $this->uuidService->getProductUuid($product['id']);
    }
}