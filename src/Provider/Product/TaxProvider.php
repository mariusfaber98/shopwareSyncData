<?php declare(strict_types=1);

namespace SyncData\Provider\Product;

use SyncData\Service\ContextService;
use Vin\ShopwareSdk\Data\Criteria;
use Vin\ShopwareSdk\Data\Entity\Tax\TaxDefinition;
use Vin\ShopwareSdk\Data\Filter\EqualsFilter;
use Vin\ShopwareSdk\Factory\RepositoryFactory;

class TaxProvider
{
    private ContextService $contextService;

    public function __construct(ContextService $contextService)
    {
        $this->contextService = $contextService;
    }

    public function getTaxId($product): string
    {
        $taxRate = $product['taxRate'];

        $context = $this->contextService->getContext();

        $taxRepository = RepositoryFactory::create(TaxDefinition::ENTITY_NAME);

        $criteria = new Criteria();
        $criteria->setLimit(1);
        $criteria->addFilter(new EqualsFilter('taxRate', $taxRate));

        return $taxRepository->search($criteria,$context)->entities->first()->id;
    }
}