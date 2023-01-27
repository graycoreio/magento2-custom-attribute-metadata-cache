<?php

namespace Graycore\CustomAttributeMetadataCache\Model;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class CacheIdentity implements IdentityInterface
{
    public function getIdentities(array $resolvedData): array
    {
        return [];
    }
}
