<?php declare(strict_types=1);

namespace SyncData\Provider\Product;

use SyncData\Service\ContextService;
use SyncData\Service\SyncDataService;
use SyncData\Service\UuidService;
use Vin\ShopwareSdk\Data\Criteria;
use Vin\ShopwareSdk\Data\Entity\MediaFolder\MediaFolderDefinition;
use Vin\ShopwareSdk\Data\Filter\EqualsFilter;
use Vin\ShopwareSdk\Factory\RepositoryFactory;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\MediaService;

class MediaProvider
{
    private UuidService $uuidService;

    private ContextService $contextService;

    private SyncDataService $syncDataService;

    public function __construct(UuidService $uuidService, SyncDataService $syncDataService, ContextService $contextService)
    {
        $this->uuidService = $uuidService;
        $this->contextService = $contextService;
        $this->syncDataService = $syncDataService;
    }

    public function getMedia($product): array
    {
        $images = $product['media'];

        foreach($images as $image)
        {
            $imageName = basename($image);
            $mediaId = $this->uuidService->getMediaUuid($imageName);
            $this->importProductMedia($mediaId,$image,$imageName);

            $media[] = array(
                'id' => $this->uuidService->getProductMediaUuid($product['id'], $imageName),
                'mediaId' => $mediaId,
            );
        }

        return $media;
    }

    public function getCoverId($product): string
    {
        $imageName = basename($product['media'][0]);
        return $this->uuidService->getProductMediaUuid($product['id'], $imageName);
    }

    private function importProductMedia($mediaId,$url,$imageName): ApiResponse
    {
        $context = $this->contextService->getContext();
        $mediaService = new MediaService($context);
        $productFolder = $this->getDefaultFolderIdForEntity('product');

        $payload[] = array(
            'id' => $mediaId,
            'mediaFolderId' => $productFolder,
        );

        $this->syncDataService->sync('media', $payload);

        return $mediaService->uploadMediaFromUrl($mediaId, $url, 'jpg', $imageName);
    }

    private function getDefaultFolderIdForEntity(string $entity): string
    {
        $context = $this->contextService->getContext();

        $MediaFolderRepository = RepositoryFactory::create(MediaFolderDefinition::ENTITY_NAME);

        $criteria = new Criteria();
        $criteria->addAssociation('defaultFolder');
        $criteria->addFilter(new EqualsFilter('media_folder.defaultFolder.entity', $entity));

        return $MediaFolderRepository->search($criteria,$context)->entities->first()->id;
    }
}