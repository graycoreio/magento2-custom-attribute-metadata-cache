<?php

namespace Graycore\CustomAttributeMetadataCache\Model;

use Magento\Framework\Config\ReaderInterface;

class GraphQlReader implements ReaderInterface
{
    public function read($scope = null)
    {
        return [
            'Query' => [
                'fields' => [
                    'customAttributeMetadata' => [
                        'cache' => [
                            'cacheable' => true,
                            'cacheIdentity' => CacheIdentity::class
                        ]
                    ]
                ]
            ]
        ];
    }
}
