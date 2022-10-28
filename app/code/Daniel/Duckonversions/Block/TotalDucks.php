<?php

declare(strict_types=1);

namespace Daniel\Duckonversions\Block;

use Magento\Framework\View\Element\Template;

class TotalDucks extends Template
{
    public function getTotalDucksFromQuote(): float
    {
        return 13.37;
    }
}
