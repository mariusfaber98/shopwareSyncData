<?php declare(strict_types=1);

namespace SyncData\Provider\Product;

use SyncData\Service\ContextService;
use SyncData\Service\SyncDataService;
use SyncData\Service\UuidService;
use Vin\ShopwareSdk\Data\Criteria;
use Vin\ShopwareSdk\Data\Entity\Category\CategoryDefinition;
use Vin\ShopwareSdk\Data\Filter\EqualsFilter;
use Vin\ShopwareSdk\Factory\RepositoryFactory;

class CategoriesProvider
{
    private UuidService $uuidService;

    private ContextService $contextService;

    private SyncDataService $syncDataService;

    public function __construct(UuidService $uuidService, ContextService $contextService, SyncDataService $syncDataService)
    {
        $this->uuidService = $uuidService;
        $this->contextService = $contextService;
        $this->syncDataService = $syncDataService;
    }

    public function getCategories($product): array
    {
        return [
            [
                'id' => $this->importCategory($product['category']),
            ],
        ];
    }


    private function importCategory($categoryName): string
    {
        $categoryId = $this->uuidService->getCategoryUuid($categoryName);
        $payload[] = array(
            'id' => $categoryId,
            'parentId' => $this->getRootCategoryId(),
            'name' => $categoryName,
        );

        $this->syncDataService->sync('category', $payload);

        return $categoryId;
    }

    private function getRootCategoryId(): string
    {
        $context = $this->contextService->getContext();

        $CategoryRepository = RepositoryFactory::create(CategoryDefinition::ENTITY_NAME);

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('parentId', null));

        $rootCategory = $CategoryRepository->search($criteria, $context)->first();

        if (!$rootCategory) {
            throw new \RuntimeException('Root category not found');
        }

        return $rootCategory->id;
    }
}