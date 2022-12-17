<?php declare(strict_types=1);

namespace SyncData\Provider\Product;

use SyncData\Service\ContextService;
use Vin\ShopwareSdk\Data\Criteria;
use Vin\ShopwareSdk\Data\Entity\ProductManufacturer\ProductManufacturerDefinition;
use Vin\ShopwareSdk\Data\FieldSorting;
use Vin\ShopwareSdk\Data\Filter\ContainsFilter;
use Vin\ShopwareSdk\Factory\RepositoryFactory;

class ManufacturerProvider
{
    private ContextService $contextService;

    public function __construct(ContextService $contextService)
    {
        $this->contextService = $contextService;
    }

    public function getManufacturer($product): array
    {
        return [
            'id' => $this->getManufacturerbyName($product['manufacturer']),
        ];
    }

    private function getManufacturerbyName($manufacturerName): string
    {
        $context = $this->contextService->getContext();

        $productManufacturerRepository = RepositoryFactory::create(ProductManufacturerDefinition::ENTITY_NAME);

        $criteria = new Criteria();
        $criteria->setLimit(1);
        $criteria->addSorting(new FieldSorting('name', FieldSorting::DESCENDING));
        $criteria->addFilter(new ContainsFilter('name', $manufacturerName));

        return $productManufacturerRepository->search($criteria, $context)->entities->first()->id;
    }
}