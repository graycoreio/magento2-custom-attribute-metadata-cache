<?php

declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See https://github.com/mage-os/mageos-magento2/blob/2.4-develop/COPYING.txt for license details.
 */

namespace Graycore\CustomAttributeMetadataCache\Model;

use Magento\Eav\Model\Entity\Attribute as EavAttribute;
use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class CacheIdentity implements IdentityInterface
{
    /**
     * @inheritDoc
     */
    public function getIdentities(array $resolvedData): array
    {
        $identities = [];
        if (isset($resolvedData['items']) && !empty($resolvedData['items'])) {
            foreach ($resolvedData['items'] as $item) {
                if (is_array($item)) {
                    $identities[] = sprintf(
                        "%s_%s_%s",
                        EavAttribute::CACHE_TAG,
                        $item['entity_type'],
                        $item['attribute_code']
                    );
                }
            }
        } else {
            return [];
        }
        return $identities;
    }
}
