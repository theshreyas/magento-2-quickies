<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Theshreyas\OrderGridExport\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Theshreyas\OrderGridExport\Model\Export\ConvertToXls;
use Magento\Framework\App\Response\Http\FileFactory;

/**
 * Class Render
 */
class GridToXls extends Action
{
    /**
     * @var ConvertToXls
     */
    protected $converter;

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @param Context $context
     * @param ConvertToXml $converter
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Context $context,
        ConvertToXls $converter,
        FileFactory $fileFactory
    ) {
        parent::__construct($context);
        $this->converter = $converter;
        $this->fileFactory = $fileFactory;
    }

    /**
     * Export data provider to XML
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        return $this->fileFactory->create('export.xls', $this->converter->getXlsFile(), 'var');
    }
}