<?php

declare(strict_types=1);

namespace Daniel\Duckonversions\Model;

use Daniel\Duckonversions\Setup\InstallData as DuckAttribute;
use Magento\Quote\Model\Quote\Item;

class DuckAggregator
{
    public function getTotalDucksFromItems(array $items) : float
    {
        $totalWeightInDucks = 0;

        /** @var Item $item */
        foreach ($items as $item) {
            $totalWeightInDucks += $this->getDuckWeightFromQuoteItem($item) * $item->getQty();
        }

        return $totalWeightInDucks;
    }

    public function getDuckWeightFromQuoteItem(Item $item) : float
    {
        return (float)$item->getProduct()->getData(DuckAttribute::ATTRIBUTE_CODE) ?? 0;
    }
}
