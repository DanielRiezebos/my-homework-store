<?php

declare(strict_types=1);

namespace Daniel\OrderQtyAggregator\Plugin;

use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductExtensionInterface;

class QtyOrderedAggregator
{
    public function afterGet(ProductRepository $subject, ProductInterface $result)
    {
        /** @var ProductExtensionInterface $extensionAttributes */
        $extensionAttributes = $result->getExtensionAttributes();

        // This value is now hardcoded. Imagine a Helper class that actually aggregates the total amount of times this
        // product has been ordered and using that result as the parameter in below function.
        // This module was built primarily to understand Magento 2's extension attributes so further implementation
        // was not a requirement.
        $extensionAttributes->setTotalQtyOrdered(20);

        $result->setExtensionAttributes($extensionAttributes);
        return $result;
    }
}
