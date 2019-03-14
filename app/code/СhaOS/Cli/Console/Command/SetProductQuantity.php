<?php

namespace ChaOS\Cli\Console\Command;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\CatalogInventory\Api\StockStateInterface;

/**
 * Class SetProductQuantity
 * @package ChaOS\Cli\Console\Command
 */
class SetProductQuantity extends ConsoleCommand
{
    /** @var string result messages */
    public const MESSAGE_SUCCESS = 'operation completed successfully';
    public const MESSAGE_ERROR = 'operation failed';
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var StockRegistryInterface
     */
    private $stockRegistry;
    /**
     * @var State
     */
    private $state;
    private $stockItemInterface;

    /**
     * SetProductQuantity constructor.
     * @param ProductRepository $productRepository
     * @param StockRegistryInterface $stockRegistry
     * @param StockStateInterface $stockItemInterface
     * @param State $state
     * @param string|null $name
     */
    public function __construct(
        ProductRepository $productRepository,
        StockRegistryInterface $stockRegistry,
        StockStateInterface $stockItemInterface,
        State $state,
        ?string $name = null
    )
    {
        $this->stockItemInterface = $stockItemInterface;
        $this->productRepository = $productRepository;
        $this->state = $state;
        $this->stockRegistry = $stockRegistry;
        parent::__construct($name);
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setName('set-product-quantity:set-quantity')
            ->setDescription('Change product quantity by its id')
            ->setDefinition([
                new InputArgument(
                    'productId',
                    InputArgument::OPTIONAL,
                    'Id of product you want to change'
                ),
                new InputArgument(
                    'quantity',
                    InputArgument::OPTIONAL,
                    'New quantity you want to set for product'
                )
            ]);
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
            $productId = (int)$input->getArgument('productId');
            $newProductQuantity = (int)$input->getArgument('quantity');
            /** @var \Magento\Catalog\Model\Product $product */
            $product = $this->productRepository->getById($productId);
            $stockItemInterface = $this->stockItemInterface;
            /** @var \Magento\CatalogInventory\Model\Stock\Item $stockItem */
            $stockItem = $this->stockRegistry->getStockItem($productId);
            if ($product) {
                $stockItem->setQty($newProductQuantity);
            }
            $this->stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);
            $output->writeln("<info>" . self::MESSAGE_SUCCESS
                . "Product $productId quantity changed to $newProductQuantity"
                . "</info>");
        } catch (\Exception $e) {
            $output->writeln("<error>" . self::MESSAGE_ERROR . "{$e->getMessage()}<error>");
        }
    }
}