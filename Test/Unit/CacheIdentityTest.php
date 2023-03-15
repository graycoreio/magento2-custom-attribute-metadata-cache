<?php declare(strict_types=1);

namespace Graycore\CustomAttributeMetadataCache\Test\Unit;

use Graycore\CustomAttributeMetadataCache\Model\CacheIdentity;
use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class CacheIdentityTest extends \PHPUnit\Framework\TestCase
{

    public function testItWorks(): void
    {
        $om = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $identity = new CacheIdentity(
            $om->getObject(\Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory::class),
            $om->getObject(\Magento\Eav\Model\Config::class),

        );

        $this->assertTrue($identity instanceof IdentityInterface);
    }
}
