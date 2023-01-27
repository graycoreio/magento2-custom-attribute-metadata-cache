<?php declare(strict_types=1);

namespace Graycore\CustomAttributeMetadataCache\Test\Unit;

use Graycore\CustomAttributeMetadataCache\Model\CacheIdentity;
use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class CacheIdentityTest extends \PHPUnit\Framework\TestCase
{

    public function testItWorks(): void
    {
        $identity = new CacheIdentity();

        $this->assertTrue($identity instanceof IdentityInterface);
    }
}
