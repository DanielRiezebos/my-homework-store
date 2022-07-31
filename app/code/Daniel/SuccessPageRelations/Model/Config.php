<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private $scopeConfig;
    private const CONFIG_DISPLAY_PATH = 'successpagerelations/config/display';
    private const FOOTER_TEXT_PATH = 'successpagerelations/config/footer_text';

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function display()
    {
        return $this->scopeConfig->getValue(self::CONFIG_DISPLAY_PATH, ScopeInterface::SCOPE_STORE);
    }

    public function getFooterText()
    {
        return $this->scopeConfig->getValue(self::FOOTER_TEXT_PATH, ScopeInterface::SCOPE_STORE);
    }
}
