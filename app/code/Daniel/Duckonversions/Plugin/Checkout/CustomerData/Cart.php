<?php

declare(strict_types=1);

namespace Daniel\Duckonversions\Plugin\Checkout\CustomerData;

use Magento\Checkout\Model\Session;
use Magento\Checkout\CustomerData\Cart as Input;
use Daniel\Duckonversions\Model\DuckAggregator;

class Cart
{
    private Session $checkoutSession;
    private DuckAggregator $duckAggregator;

    public function __construct(Session $session, DuckAggregator $duckAggregator)
    {
        $this->checkoutSession = $session;
        $this->duckAggregator = $duckAggregator;
    }

    public function afterGetSectionData(Input $subject, $result) : array
    {
        $result["totalDucks"] = $this->duckAggregator->getTotalDucksFromItems(
            $this->checkoutSession->getQuote()->getAllItems()
        );

        return $result;
    }
}
