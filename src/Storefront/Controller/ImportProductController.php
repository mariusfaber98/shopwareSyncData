<?php declare(strict_types=1);

namespace SyncData\Storefront\Controller;

use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SyncData\Import\ProductImport;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class ImportProductController extends StorefrontController
{
    private ProductImport $productImport;

    public function __construct(ProductImport $productImport)
    {
        $this->productImport = $productImport;
    }

    /**
     * @Route("/import-products", name="frontend.import.products", methods={"GET"})
     */
    public function importProducts(): Response
    {
        return $this->renderStorefront('@SyncData/storefront/page/import.html.twig', [
            'importResponse' => $this->productImport->importProducts()->getContents(),
        ]);
    }
}