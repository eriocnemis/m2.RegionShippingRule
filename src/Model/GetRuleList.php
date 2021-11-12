<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Eriocnemis\RegionShippingRuleApi\Api\GetRuleListInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleSearchResultInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleSearchResultInterfaceFactory;
use Eriocnemis\RegionShippingRule\Model\ResourceModel\Rule\CollectionFactory;
use Eriocnemis\RegionShippingRule\Api\ConvertRuleToDataInterface;

/**
 * Find rules by search criteria
 *
 * @api
 */
class GetRuleList implements GetRuleListInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var RuleSearchResultInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ConvertRuleToDataInterface
     */
    private $convertRuleToData;

    /**
     * Initialize provider
     *
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param RuleSearchResultInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ConvertRuleToDataInterface $convertRuleToData
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        RuleSearchResultInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ConvertRuleToDataInterface $convertRuleToData
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->convertRuleToData = $convertRuleToData;
    }

    /**
     * Retrieve list of rules
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return RuleSearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): RuleSearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        }
        $this->collectionProcessor->process($searchCriteria, $collection);

        $items = [];
        /** @var \Magento\Framework\Model\AbstractModel $model */
        foreach ($collection->getItems() as $model) {
            $items[] = $this->convertRuleToData->execute($model);
        }

        /** @var RuleSearchResultInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($items);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
