<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotDeleteException;
use Eriocnemis\RegionShippingRule\Api\DetachMethodFromRuleInterface;

/**
 * Detach shipping methods from rule
 */
class DetachMethodFromRule implements DetachMethodFromRuleInterface
{
    /**
     * Shipping methods relation table name
     */
    private const TABLE_NAME = 'eriocnemis_region_shipping_rule_method';

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
     * Detach shipping methods
     *
     * @param int $ruleId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $ruleId): void
    {
        try {
            $this->resource->getConnection()->delete(
                $this->resource->getTableName(self::TABLE_NAME),
                ['rule_id = ?' => $ruleId]
            );
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotDeleteException(
                __('Could not detach shipping methods from rule with id %id', ['id' => $ruleId])
            );
        }
    }
}
