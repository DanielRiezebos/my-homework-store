<?php

declare(strict_types=1);

namespace Daniel\CacheType\Plugin;

use Magento\Theme\Block\Html\Title;
use Daniel\CacheType\Model\CustomCacher;

class SetTitleInCache
{
    private CustomCacher $customCacher;

    public function __construct(CustomCacher $customCacher)
    {
        $this->customCacher = $customCacher;
    }

    public function afterGetPageTitle(Title $subject, $result)
    {
        // Store the page title in the custom cache to study Magento 2 cache functionality
        $cachedPageTitle = $this->customCacher->read();
        if ($cachedPageTitle === null) {
            $cachedPageTitle = $result;
            $this->customCacher->write($result);
        }

        return $cachedPageTitle;
    }
}
