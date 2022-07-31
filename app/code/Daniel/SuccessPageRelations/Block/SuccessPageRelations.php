<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Block;

use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Daniel\SuccessPageRelations\Model\Config;

class SuccessPageRelations extends Template
{
    private $checkoutSession;
    private $productCollection;
    private $config;

    public function __construct (
        Session $checkoutSession,
        CollectionFactory $productCollection,
        Config $config,
        Template\Context $context,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->productCollection = $productCollection;
        $this->config = $config;
        parent::__construct($context, $data);
    }

    public function getSuccessPageRelatedProducts (): array
    {
        $order = $this->checkoutSession->getLastRealOrder();
        $productCollection = $this->productCollection->create();

        /** Item $orderItem */
        foreach ($order->getItems() as $orderItem) {
            $productCollection->addAttributeToSelect('*');
            $productCollection->addAttributeToFilter('sku',
                ['in' => $orderItem->getProduct()->getSuccessPageProducts()]
            );
            $productCollection->load();
        }

        return $productCollection->getItems();
    }

    public function shouldDisplay()
    {
        return $this->config->display();
    }

    public function getFooterText()
    {
        return $this->config->getFooterText();
    }
}
