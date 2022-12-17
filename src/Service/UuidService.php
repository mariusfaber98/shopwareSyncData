<?php declare(strict_types=1);

namespace SyncData\Service;

use Shopware\Core\Framework\Uuid\Uuid;

class UuidService
{
    public function getProductUuid($productId): string
    {
        return Uuid::fromStringToHex($productId.'product');
    }

    public function getCategoryUuid($categoryName): string
    {
        return Uuid::fromStringToHex($categoryName.'category');
    }

    public function getMediaUuid($imageName): string
    {
        return Uuid::fromStringToHex($imageName.'media');
    }

    public function getProductMediaUuid($productId, $imageName): string
    {
        return Uuid::fromStringToHex($productId.$imageName.'productMedia');
    }

    public function getProductVisibilityUuid($productId): string
    {
        return Uuid::fromStringToHex($productId.'visibility');
    }
}