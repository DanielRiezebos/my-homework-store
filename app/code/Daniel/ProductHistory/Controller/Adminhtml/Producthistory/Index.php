<?php

namespace Daniel\ProductHistory\Controller\Adminhtml\Producthistory;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;


class Index extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'Daniel_ProductHistory::producthistory';
    protected PageFactory $pageFactory;

    public function __construct(Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Product History'));

        return $resultPage;
    }
}
