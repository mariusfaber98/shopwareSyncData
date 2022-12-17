<?php declare(strict_types=1);

namespace SyncData\Provider\Product;

use Shopware\Core\Defaults;

class PriceProvider
{
    public function getPrice($product): array
    {
        $nettoPrice = $product['price'] / ($product['taxRate'] / 100 + 1);

        return [[
            'net' => $nettoPrice,
            'gross' => $product['price'],
            'linked' => true,
            'currencyId' => Defaults::CURRENCY,
        ]];
    }
}