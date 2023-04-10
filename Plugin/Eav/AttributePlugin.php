<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See https://github.com/mage-os/mageos-magento2/blob/2.4-develop/COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Graycore\CustomAttributeMetadataCache\Plugin\Eav;

use Magento\Eav\Model\Entity\Attribute;
use Magento\Framework\Api\AttributeInterface;

/**
 * EAV plugin runs page cache clean and provides proper EAV identities.
 */
class AttributePlugin
{
    /**
     * Clean cache by relevant tags after entity save.
     *
     * @param Attribute $subject
     * @param array $result
     *
     * @return string[]
     */
    public function afterGetIdentities(Attribute $subject, array $result): array
    {
        return array_merge(
            $result,
            [
                sprintf(
                    "%s_%s_%s",
                    Attribute::CACHE_TAG,
                    $subject->getEntityType()->getEntityTypeCode(),
                    $subject->getOrigData(AttributeInterface::ATTRIBUTE_CODE)
                        ?? $subject->getData(AttributeInterface::ATTRIBUTE_CODE)
                )
            ]
        );
    }
}
