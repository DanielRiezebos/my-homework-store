<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Model\ProductLink\CollectionProvider;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductLink\CollectionProviderInterface;

class SuccessPage implements CollectionProviderInterface
{
    public function getLinkedProducts(Product $product)
    {
        return $product->getSuccessPageProducts();
    }
}
