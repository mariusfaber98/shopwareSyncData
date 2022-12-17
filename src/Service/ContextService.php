<?php declare(strict_types=1);

namespace SyncData\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Vin\ShopwareSdk\Client\AdminAuthenticator;
use Vin\ShopwareSdk\Client\GrantType\ClientCredentialsGrantType;
use Vin\ShopwareSdk\Data\Context;

class ContextService
{
    private SystemConfigService $systemConfigService;

    public function __construct(SystemConfigService $systemConfigService)
    {
        $this->systemConfigService = $systemConfigService;
    }

    public function getContext()
    {
        $domain = $this->systemConfigService->get('SyncData.config.domain');
        $clientId = $this->systemConfigService->get('SyncData.config.AccessKeyId');
        $clientSecret = $this->systemConfigService->get('SyncData.config.SecretAccessKey');

        $grantType = new ClientCredentialsGrantType($clientId, $clientSecret);
        $adminClient = new AdminAuthenticator($grantType, $domain);

        return new Context($domain, $adminClient->fetchAccessToken());
    }
}