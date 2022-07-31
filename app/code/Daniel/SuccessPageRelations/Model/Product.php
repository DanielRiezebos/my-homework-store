<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Model;

use Magento\Catalog\Model\Product as Origin;
use Magento\Catalog\Model\ProductLink\Link;
use Daniel\SuccessPageRelations\Setup\Patch\Data\InstallSuccessPageRelationType;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Product extends Origin
{
    /**
     * Retrieve array of Success page products
     *
     * @return array
     */
    public function getSuccessPageProducts()
    {
        if (!$this->hasSuccessPageProducts()) {
            $successPageProductSkus = [];

            /** @var Link $productLink */
            foreach ($this->getProductLinks() as $productLink) {
                if ($productLink->getData('link_type') == InstallSuccessPageRelationType::SUCCES_PAGE_CODE) {
                    $successPageProductSkus[] = $productLink->getLinkedProductSku();
                }
            }

            if (!$this->hasSuccessPageProducts()) {
                $this->setSuccessPageProducts($successPageProductSkus);
                $this->setData('has_success_page_products', true);
            }
        }

        return $this->getData('success_page_products');
    }

    public function getSuccessPageProductIds()
    {
        if (!$this->hasSuccessPageProducts()) {
            $ids = [];
            foreach ($this->getSuccessPageProducts() as $product) {
                $ids[] = $product->getId();
            }

            $this->setSuccessPageProductIds($ids);
        }

        return $this->getData('success_page_product_ids');
    }
}
