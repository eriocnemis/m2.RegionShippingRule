<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleSearchResultInterface;
use Eriocnemis\RegionShippingRuleApi\Api\GetRuleListInterface;
use Eriocnemis\RegionShippingRule\Api\GetActiveRuleListInterface;

/**
 * Find active rules by search criteria
 *
 * @api
 */
class GetActiveRuleList implements GetActiveRuleListInterface
{
    /**
     * @var GetRuleListInterface
     */
    private $getRuleList;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * Initialize provider
     *
     * @param GetRuleListInterface $getRuleList
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param FilterBuilder $filterBuilder
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        GetRuleListInterface $getRuleList,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder,
        TimezoneInterface $timezone
    ) {
        $this->getRuleList = $getRuleList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->timezone = $timezone;
    }

    /**
     * Retrieve list of rules
     *
     * @param int[] $ruleIds
     * @return RuleSearchResultInterface
     */
    public function execute(array $ruleIds): RuleSearchResultInterface
    {
        $date = $this->timezone->date()->format('Y-m-d');
        $this->searchCriteriaBuilder->setFilterGroups(
            [
                $this->getFilterGroup(RuleInterface::FROM_DATE, 'lteq', $date),
                $this->getFilterGroup(RuleInterface::TO_DATE, 'gteq', $date)
            ]
        );

        $this->searchCriteriaBuilder->addFilter(RuleInterface::RULE_ID, $ruleIds, 'in');
        $this->searchCriteriaBuilder->addFilter(RuleInterface::STATUS, 1);

        return $this->getRuleList->execute($this->searchCriteriaBuilder->create());
    }

    /**
     * Retrieve filter group
     *
     * @param string $field
     * @param string $conditionType
     * @param mixed $value
     * @return \Magento\Framework\Api\Search\FilterGroup
     */
    private function getFilterGroup($field, $conditionType = 'eq', $value)
    {
        return $this->filterGroupBuilder
            ->addFilter($this->getFilter($field, 'null'))
            ->addFilter($this->getFilter($field, $conditionType, $value))
            ->create();
    }

    /**
     * Retrieve filter
     *
     * @param string $field
     * @param string $conditionType
     * @param mixed $value
     * @return \Magento\Framework\Api\Filter
     */
    private function getFilter($field, $conditionType = 'eq', $value = null)
    {
        $filterBuilder = $this->filterBuilder->setField($field)->setConditionType($conditionType);
        if (null !== $value) {
            $filterBuilder->setValue($value);
        }
        return $filterBuilder->create();
    }
}
