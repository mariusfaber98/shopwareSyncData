<?php declare(strict_types=1);

namespace SyncData\Mapper;

use SyncData\Provider\Product\ProductProvider;
use SyncData\Provider\Product\PriceProvider;
use SyncData\Provider\Product\TaxProvider;
use SyncData\Provider\Product\MediaProvider;
use SyncData\Provider\Product\ManufacturerProvider;
use SyncData\Provider\Product\CategoriesProvider;
use SyncData\Provider\Product\VisibilitiesProvider;

class ProductMapper
{
    private ProductProvider $productProvider;

    private TaxProvider $taxProvider;

    private PriceProvider $priceProvider;

    private MediaProvider $mediaProvider;

    private ManufacturerProvider $manufacturerProvider;

    private CategoriesProvider $categoriesProvider;

    private VisibilitiesProvider $visibilitiesProvider;

    public function __construct(
        ProductProvider      $productProvider,
        TaxProvider          $taxProvider,
        PriceProvider        $priceProvider,
        ManufacturerProvider $manufacturerProvider,
        MediaProvider        $mediaProvider,
        CategoriesProvider   $categoriesProvider,
        VisibilitiesProvider $visibilitiesProvider
    )
    {
        $this->productProvider = $productProvider;
        $this->taxProvider = $taxProvider;
        $this->priceProvider = $priceProvider;
        $this->manufacturerProvider = $manufacturerProvider;
        $this->mediaProvider = $mediaProvider;
        $this->categoriesProvider = $categoriesProvider;
        $this->visibilitiesProvider = $visibilitiesProvider;
    }

    public function getId($product): string
    {
        return $this->productProvider->getId($product);
    }
    public function getProductNumber($product): string
    {
        return (string) $product['id'];
    }

    public function getTaxId($product): string
    {
        return $this->taxProvider->getTaxId($product);
    }

    public function getStock($product): int
    {
        return (int) $product['stock'];
    }

    public function getName($product): string
    {
        return (string) $product['title'];
    }

    public function getDescription($product): string
    {
        return (string) $product['description'];
    }

    public function getPrice($product): array
    {
        return $this->priceProvider->getPrice($product);
    }

    public function getManufacturer($product): array
    {
        return $this->manufacturerProvider->getManufacturer($product);
    }

    public function getMedia($product): array
    {
        return $this->mediaProvider->getMedia($product);
    }

    public function getCoverId($product): string
    {
        return $this->mediaProvider->getCoverId($product);
    }

    public function getCategories($product): array
    {
        return $this->categoriesProvider->getCategories($product);
    }

    public function getVisibilities($product): array
    {
        return $this->visibilitiesProvider->getVisibilities($product);
    }
}