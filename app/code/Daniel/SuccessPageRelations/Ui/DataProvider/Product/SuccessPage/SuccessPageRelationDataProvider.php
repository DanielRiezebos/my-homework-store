<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Ui\DataProvider\Product\SuccessPage;

use Magento\Catalog\Ui\DataProvider\Product\Related\AbstractDataProvider;
use Daniel\SuccessPageRelations\Setup\Patch\Data\InstallSuccessPageRelationType;

class SuccessPageRelationDataProvider extends AbstractDataProvider
{
    protected function getLinkType(): string
    {
        return InstallSuccessPageRelationType::SUCCES_PAGE_CODE;
    }
}
