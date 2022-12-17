<?php declare(strict_types=1);

namespace SyncData\Provider\Product;

use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use SyncData\Service\ContextService;
use SyncData\Service\UuidService;
use Vin\ShopwareSdk\Data\Criteria;
use Vin\ShopwareSdk\Data\Defaults;
use Vin\ShopwareSdk\Data\Entity\SalesChannel\SalesChannelDefinition;
use Vin\ShopwareSdk\Data\Filter\EqualsFilter;
use Vin\ShopwareSdk\Data\Uuid\Uuid;
use Vin\ShopwareSdk\Factory\RepositoryFactory;

class VisibilitiesProvider
{
    private UuidService $uuidService;

    private ContextService $contextService;

    public function __construct(UuidService $uuidService, ContextService $contextService)
    {
        $this->uuidService = $uuidService;
        $this->contextService = $contextService;
    }
    public function getVisibilities($product): array
    {
        $storefrontType = Uuid::fromHexToBytes(Defaults::SALES_CHANNEL_TYPE_STOREFRONT);

        $context = $this->contextService->getContext();

        $SalesChannelRepository = RepositoryFactory::create(SalesChannelDefinition::ENTITY_NAME);

        $criteria = new Criteria();
        $criteria->setLimit(1);
        $criteria->addFilter(new EqualsFilter('typeId', $storefrontType));

        $storefrontSalesChannel = $SalesChannelRepository->search($criteria,$context)->entities->first()->id;

        return [
            [
                'id' => $this->uuidService->getProductVisibilityUuid($product['id']),
                'salesChannelId' => $storefrontSalesChannel,
                'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
            ],
        ];
    }
}