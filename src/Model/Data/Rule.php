<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\RegionShippingRule\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleExtensionInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Rule data
 */
class Rule extends AbstractExtensibleObject implements RuleInterface
{
    /**
     * Retrieve rule id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->_get(self::RULE_ID);
    }

    /**
     * Set rule id
     *
     * @param int $ruleId
     * @return $this
     */
    public function setId($ruleId)
    {
        return $this->setData(self::RULE_ID, $ruleId);
    }

    /**
     * Retrieve rule name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set rule name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Retrieve description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->_get(self::DESCRIPTION);
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Retrieve the start date when the rule is active
     *
     * @return string|null
     */
    public function getFromDate()
    {
        return $this->_get(self::FROM_DATE);
    }

    /**
     * Set the star date when the rule is active
     *
     * @param string $fromDate
     * @return $this
     */
    public function setFromDate($fromDate)
    {
        return $this->setData(self::FROM_DATE, $fromDate);
    }

    /**
     * Retrieve the end date when the rule is active
     *
     * @return string|null
     */
    public function getToDate()
    {
        return $this->_get(self::TO_DATE);
    }

    /**
     * Set the end date when the rule is active
     *
     * @param string $toDate
     * @return $this
     */
    public function setToDate($toDate)
    {
        return $this->setData(self::TO_DATE, $toDate);
    }

    /**
     * Whether the rule is active
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set whether the rule is active
     *
     * @param bool $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Retrieve a list of websites the rule applies to
     *
     * @return int[]
     */
    public function getWebsiteIds()
    {
        return $this->_get(self::WEBSITE_IDS);
    }

    /**
     * Set the websites the rule applies to
     *
     * @param int[] $websiteIds
     * @return $this
     */
    public function setWebsiteIds(array $websiteIds)
    {
        return $this->setData(self::WEBSITE_IDS, $websiteIds);
    }

    /**
     * Whether the methods access
     *
     * @return bool
     */
    public function getMethodsAccess()
    {
        return $this->_get(self::METHODS_ACCESS);
    }

    /**
     * Set whether the methods access
     *
     * @param bool $access
     * @return $this
     */
    public function setMethodsAccess($access)
    {
        return $this->setData(self::METHODS_ACCESS, $access);
    }

    /**
     * Retrieve a list of shipping methods the rule applies to
     *
     * @return string[]
     */
    public function getShippingMethods()
    {
        return $this->_get(self::SHIPPING_METHODS);
    }

    /**
     * Set the shipping methods the rule applies to
     *
     * @param string[] $shippingMethods
     * @return $this
     */
    public function setShippingMethods(array $shippingMethods)
    {
        return $this->setData(self::SHIPPING_METHODS, $shippingMethods);
    }

    /**
     * Retrieve a list of customer group ids the rule applies to
     *
     * @return int[]
     */
    public function getCustomerGroupIds()
    {
        return $this->_get(self::CUSTOMER_GROUP_IDS);
    }

    /**
     * Set the customer group ids the rule applies to
     *
     * @param int[] $customerGroupIds
     * @return $this
     */
    public function setCustomerGroupIds(array $customerGroupIds)
    {
        return $this->setData(self::CUSTOMER_GROUP_IDS, $customerGroupIds);
    }

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Eriocnemis\RegionShippingRuleApi\Api\Data\RuleExtensionInterface
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object
     *
     * @param \Eriocnemis\RegionShippingRuleApi\Api\Data\RuleExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(RuleExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
