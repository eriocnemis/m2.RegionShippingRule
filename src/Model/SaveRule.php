<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model;

use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;
use Eriocnemis\RegionShippingRuleApi\Api\SaveRuleInterface;
use Eriocnemis\RegionShippingRuleApi\Api\ValidateRuleInterface;
use Eriocnemis\RegionShippingRule\Api\ConvertRuleToDataInterface;
use Eriocnemis\RegionShippingRule\Api\ConvertDataToRuleInterface;
use Eriocnemis\RegionShippingRule\Model\ResourceModel\Rule as RuleResource;

/**
 * Save rule data
 *
 * @api
 */
class SaveRule implements SaveRuleInterface
{
    /**
     * @var RuleResource
     */
    private $resource;

    /**
     * @var ValidateRuleInterface
     */
    private $validateRule;

    /**
     * @var ConvertDataToRuleInterface
     */
    private $convertDataToRule;

    /**
     * @var ConvertRuleToDataInterface
     */
    private $convertRuleToData;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize provider
     *
     * @param RuleResource $resource
     * @param ValidateRuleInterface $validateRule
     * @param ConvertDataToRuleInterface $convertDataToRule
     * @param ConvertRuleToDataInterface $convertRuleToData
     * @param LoggerInterface $logger
     */
    public function __construct(
        RuleResource $resource,
        ValidateRuleInterface $validateRule,
        ConvertDataToRuleInterface $convertDataToRule,
        ConvertRuleToDataInterface $convertRuleToData,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->validateRule = $validateRule;
        $this->convertDataToRule = $convertDataToRule;
        $this->convertRuleToData = $convertRuleToData;
        $this->logger = $logger;
    }

    /**
     * Save rule
     *
     * @param RuleInterface $rule
     * @return RuleInterface
     * @throws CouldNotSaveException
     * @throws ValidationException
     */
    public function execute(RuleInterface $rule): RuleInterface
    {
        $this->validateRule->execute($rule);
        /** @var \Eriocnemis\RegionShippingRule\Model\Rule $model */
        $model = $this->convertDataToRule->execute($rule);
        try {
            $this->resource->save($model);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotSaveException(
                __('Could not save the rule with id: %1', $rule->getId())
            );
        }
        return $this->convertRuleToData->execute($model);
    }
}
