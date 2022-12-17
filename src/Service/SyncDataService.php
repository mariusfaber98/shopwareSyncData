<?php declare(strict_types=1);

namespace SyncData\Service;

use SyncData\Service\ContextService;
use Vin\ShopwareSdk\Service\Struct\SyncOperator;
use Vin\ShopwareSdk\Service\Struct\SyncPayload;
use Vin\ShopwareSdk\Service\SyncService;

class SyncDataService
{
    private ContextService $contextService;

    public function __construct(ContextService $contextService)
    {
        $this->contextService = $contextService;
    }

    public function sync($entity, $payload)
    {
        $context = $this->contextService->getContext();
        $syncPayload = new SyncPayload();
        $syncService = new SyncService($context);
        $syncPayload->set($entity . '-upsert', new SyncOperator($entity, SyncOperator::UPSERT_OPERATOR, $payload));

        return $syncService->sync($syncPayload);
    }
}