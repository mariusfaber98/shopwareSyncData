<?php declare(strict_types=1);

namespace SyncData\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SyncData\Import\ProductImport;

class ImportProductCommand extends Command
{
    protected static $defaultName = 'sync-data:import-Products';

    private ProductImport $productImport;

    public function __construct(ProductImport $productImport)
    {
        $this->productImport = $productImport;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->productImport->importProducts()->getStatusCode();

        switch ($response) {
            case 200:
                $output->writeln('Successfully imported all products');
                return self::SUCCESS;
            case 500:
                $output->writeln('Status code 500');
                return self::FAILURE;
            default:
                $output->writeln('No status code');
                return self::INVALID;
        }
    }
}