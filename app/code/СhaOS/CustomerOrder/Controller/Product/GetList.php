<?php

namespace ChaOS\CustomerOrder\Controller\Product;

use Magento\Framework\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;

/**
 * Class GetList
 * @package ChaOS\CustomerOrder\Controller\Product
 */
class GetList extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\Api\FilterBuilder */
    protected $filterBuilder;
    /** @var ProductRepositoryInterface */
    protected $productRepository;
    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /**
     * GetList constructor.
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder
    )
    {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($q = $this->getRequest()->getParam('q')) {
            $this->searchCriteriaBuilder->addFilter(
                $this->filterBuilder
                    ->setField('name')
                    ->setValue('%' . $q . '%')
                    ->setConditionType('like')
                    ->create()
            );
        }
        $this->searchCriteriaBuilder->addSortOrder('name', 'ASC');
        $this->searchCriteriaBuilder->setPageSize(10);
        $this->searchCriteriaBuilder->setCurrentPage(1);
        $products = $this->productRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $data = [];
        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'sku' => $product->getSku()
            ];
        }
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        return $result->setData([
            'products' => $data,
            'error' => false
        ]);
    }
}