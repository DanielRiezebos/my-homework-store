<?php

declare(strict_types=1);

namespace Daniel\Duckonversions\Block;

use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Session;
use Daniel\Duckonversions\Setup\InstallData as DuckAttribute;
use Magento\Quote\Model\Quote\Item;

class TotalDucks extends Template
{
    private $checkoutSession;

    public function __construct(
        Template\Context $context,
        array $data = [],
        Session $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    public function getTotalDucksFromQuote(): float
    {
        $totalWeightInDucks = 0;
        $allItemsInQuote = $this->checkoutSession->getQuote()->getAllItems();

        /** @var Item $item */
        foreach ($allItemsInQuote as $item) {
            $qty = $item->getQty();
            $product = $item->getProduct();
            if ($product->getData(DuckAttribute::ATTRIBUTE_CODE) != null) {
                $totalWeightInDucks += ($product->getData(DuckAttribute::ATTRIBUTE_CODE) * $qty);
            }
        }

        return $totalWeightInDucks;
    }
}
