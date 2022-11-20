<?php

declare(strict_types=1);

namespace Daniel\Duckonversions\Block;

use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Session;
use Daniel\Duckonversions\Model\DuckAggregator;

class TotalDucks extends Template
{
    private $checkoutSession;
    private DuckAggregator $duckAggregator;

    public function __construct(
        Template\Context $context,
        array $data = [],
        Session $checkoutSession,
        DuckAggregator $duckAggregator
    ) {
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
        $this->duckAggregator = $duckAggregator;
    }

    public function getTotalDucksFromQuote(): ?float
    {
        return $this->duckAggregator->getTotalDucksFromItems($this->checkoutSession->getQuote()->getAllItems());
    }
}
