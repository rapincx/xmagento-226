<?php

namespace ChaOS\CustomerOrder\Controller\Customer;

use Magento\Framework\App\Action\Context;

/**
 * Class GetList
 * @package ChaOS\CustomerOrder\Controller\Customer
 */
class GetList extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Framework\Api\FilterBuilder */
    protected $filterBuilder;
    /** @var \Magento\Customer\Api\CustomerRepositoryInterface */
    protected $customerRepository;
    /** @var \Magento\Framework\Api\Search\SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /**
     * GetList constructor.
     * @param Context $context
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     */
    public function __construct(
        Context $context,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    )
    {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        if ($q = $this->getRequest()->getParam('q')) {
            $this->searchCriteriaBuilder->addFilter(
                $this->filterBuilder
                    ->setField('firstname')
                    ->setValue('%' . $q . '%')
                    ->setConditionType('like')
                    ->create()
            );
        }
        $this->searchCriteriaBuilder->addSortOrder('firstname', 'ASC');
        $this->searchCriteriaBuilder->setPageSize(10);
        $this->searchCriteriaBuilder->setCurrentPage(1);
        $customers = $this->customerRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $data = [];
        foreach ($customers as $customer) {
            if ($addresses = $customer->getAddresses()) {
                continue;
            }
            $data[] = [
                'id' => $customer->getId(),
                'firstName' => $customer->getFirstname(),
                'lastName' => $customer->getLastname(),
                'email' => $customer->getEmail()
            ];
        }
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        return $result->setData([
            'customers' => $data,
            'error' => false
        ]);
    }
}