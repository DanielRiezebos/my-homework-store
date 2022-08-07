<?php

declare(strict_types=1);

namespace Daniel\ConfigurationHistory\Observer;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Daniel\ConfigurationHistory\Model\CoreConfigHistoryFactory;
use Daniel\ConfigurationHistory\Model\ResourceModel\CoreConfigHistoryFactory as CoreConfigHistoryResourceFactory;

class ConfigChangeObserver implements ObserverInterface
{
    private CoreConfigHistoryFactory $coreConfigHistoryFactory;
    private CoreConfigHistoryResourceFactory $coreConfigHistoryResourceFactory;

    public function __construct(
        CoreConfigHistoryFactory $coreConfigHistoryFactory,
        CoreConfigHistoryResourceFactory $coreConfigHistoryResourceFactory
    ) {
        $this->coreConfigHistoryFactory = $coreConfigHistoryFactory;
        $this->coreConfigHistoryResourceFactory = $coreConfigHistoryResourceFactory;
    }

    public function execute(Observer $observer)
    {
        $chapter = $this->coreConfigHistoryFactory->create();
        $writer = $this->coreConfigHistoryResourceFactory->create();

        $chapter->setData('message', 'Hello world!');
        try {
            $writer->save($chapter);
        } catch (Exception $e) {
            // Do nothing...
        }
    }
}
