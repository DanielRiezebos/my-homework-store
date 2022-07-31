<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Model\Product;

use Magento\Catalog\Model\Product\Link as Origin;
use Magento\Catalog\Model\ResourceModel\Product\Link\Product\CollectionFactory;
use Magento\CatalogInventory\Helper\Stock;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Link extends Origin
{
    const LINK_TYPE_SUCCESSPAGE = 7;

    public function __construct(
        Context $context,
        Registry $registry,
        \Magento\Catalog\Model\ResourceModel\Product\Link\CollectionFactory $linkCollectionFactory,
        CollectionFactory $productCollectionFactory,
        Stock $stockHelper,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $linkCollectionFactory,
            $productCollectionFactory,
            $stockHelper,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * @return $this
     */
    public function useSuccessPageLinks()
    {
        $this->setLinkTypeId(self::LINK_TYPE_SUCCESSPAGE);
        return $this;
    }
}
