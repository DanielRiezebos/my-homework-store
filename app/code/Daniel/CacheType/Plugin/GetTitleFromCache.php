<?php

declare(strict_types=1);

namespace Daniel\CacheType\Plugin;

use Daniel\CacheType\Model\CustomCacher;
use Magento\Theme\Block\Html\Title;

class GetTitleFromCache
{
    private CustomCacher $customCacher;

    public function __construct(CustomCacher $customCacher)
    {
        $this->customCacher = $customCacher;
    }

    public function beforeSetPageTitle(Title $subject, $pageTitle)
    {
        $cachedPageTitle = $this->customCacher->read();
        if ($cachedPageTitle === null) {
            $cachedPageTitle = $pageTitle;
            $this->customCacher->write($pageTitle);
        }

        return $cachedPageTitle;
    }
}
