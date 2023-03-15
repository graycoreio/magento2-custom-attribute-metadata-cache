<?php

namespace Graycore\CustomAttributeMetadataCache\Model;

use Magento\Catalog\Model\Product as ProductEntityType;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Model\Entity\Attribute;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory as AttributeCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class CacheIdentity implements IdentityInterface
{
    private AttributeCollectionFactory $attributeCollectionFactory;
    private EavConfig $eavConfig;

    public function __construct(AttributeCollectionFactory $attributeCollectionFactory, EavConfig $eavConfig)
    {
        $this->attributeCollectionFactory = $attributeCollectionFactory;
        $this->eavConfig = $eavConfig;
    }

    private function mapAttributesByEntityType(array $resolvedData): array
    {
        $data = [];
        foreach ($resolvedData['items'] ?? [] as $item) {
            $data[$item['entity_type']][] = $item;
        }
        return $data;
    }

    private function getEavAttributeIds(string $entityTypeId, array $attributeCodes): array
    {
        return array_map(
            fn(AttributeInterface $attribute) => Attribute::CACHE_TAG . '_' . $attribute->getAttributeId(),
            $this->attributeCollectionFactory->create()
                ->addFieldToFilter(
                    AttributeInterface::ENTITY_TYPE_ID,
                    ['eq' => $entityTypeId]
                )
                ->addFieldToFilter(
                    AttributeInterface::ATTRIBUTE_CODE,
                    ['in' => $attributeCodes]
                )->getItems()
        );
    }

    public function getIdentities(array $resolvedData): array
    {
        $identities = [];
        foreach ($this->mapAttributesByEntityType($resolvedData) as $entityType => $attributes) {
            try {
                $entityTypeId = $this->eavConfig->getEntityType($entityType)->getEntityTypeId();
            } catch (LocalizedException $e) {
                continue;
            }
            $identities = array_merge(
                $identities,
                $this->getEavAttributeIds($entityTypeId, array_map(fn($item) => $item['attribute_code'], $attributes))
            );
        }
        return $identities;
    }
}
