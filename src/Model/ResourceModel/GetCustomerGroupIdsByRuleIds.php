<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\RegionShippingRule\Api\GetCustomerGroupIdsByRuleIdsInterface;

/**
 * Get customer group ids by rule ids
 */
class GetCustomerGroupIdsByRuleIds implements GetCustomerGroupIdsByRuleIdsInterface
{
    /**
     * Website relation table name
     */
    private const TABLE_NAME = 'eriocnemis_region_shipping_rule_customer_group';

    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize resource
     *
     * @param ResourceConnection $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceConnection $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * Retrieve customer group ids
     *
     * @param int[] $ruleIds
     * @return mixed[]
     * @throws LocalizedException
     */
    public function execute(array $ruleIds): array
    {
        $websiteIds = [];
        try {
            $connection = $this->resource->getConnection();
            $select = $connection->select()->from(
                $this->resource->getTableName(self::TABLE_NAME),
                ['rule_id', 'customer_group_id']
            )->where('rule_id IN (?)', $ruleIds);

            $result = $connection->fetchAll($select);
            if ($result) {
                foreach ($result as $data) {
                    $websiteIds[$data['rule_id']][] = $data['customer_group_id'];
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new LocalizedException(
                __('Could not retrieve customer group ids by rule ids')
            );
        }
        return $websiteIds;
    }
}
