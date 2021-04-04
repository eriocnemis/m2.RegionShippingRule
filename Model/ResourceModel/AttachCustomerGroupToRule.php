<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Eriocnemis\RegionShippingRule\Api\AttachCustomerGroupToRuleInterface;

/**
 * Attach customer groups to rule
 */
class AttachCustomerGroupToRule implements AttachCustomerGroupToRuleInterface
{
    /**
     * Customer group relation table name
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
     * Attach customer groups
     *
     * @param int[] $customerGroupIds
     * @param int $ruleId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $customerGroupIds, int $ruleId): void
    {
        try {
            $data = [];
            foreach ($customerGroupIds as $groupId) {
                $data[] = [
                    'rule_id' => $ruleId,
                    'customer_group_id' => $groupId
                ];
            }

            if ($data) {
                $this->resource->getConnection()->insertOnDuplicate(
                    $this->resource->getTableName(self::TABLE_NAME),
                    $data
                );
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotSaveException(
                __('Could not attach customer group to rule with id %id', ['id' => $ruleId])
            );
        }
    }
}
