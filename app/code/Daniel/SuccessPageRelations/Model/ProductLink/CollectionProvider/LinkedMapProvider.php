<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Model\ProductLink\CollectionProvider;

use Magento\Catalog\Model\ProductLink\CollectionProvider\LinkedMapProvider as Origin;

class LinkedMapProvider extends Origin
{
    /**
     * Link types supported.
     */
    private const TYPES = ['crosssell', 'related', 'upsell', 'success_page'];

    /**
     * Type name => Product model cache key.
     */
    private const PRODUCT_CACHE_KEY_MAP = [
        'crosssell' => 'cross_sell_products',
        'upsell' => 'up_sell_products',
        'related' => 'related_products',
        'success_page' => 'success_page_products'
    ];

    /**
     * @inheritDoc
     */
    public function canProcessLinkType(string $linkType): bool
    {
        return in_array($linkType, self::TYPES, true);
    }
}
