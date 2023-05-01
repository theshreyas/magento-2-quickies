<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Theshreyas\OrderGridExport\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Theshreyas\OrderGridExport\Model\Export\ConvertToCustomCsv;
use Magento\Framework\App\Response\Http\FileFactory;

/**
 * Class Render
 */
class gridToCustomcsv extends Action
{
    /**
     * @var ConvertToCustomCsv
     */
    protected $converter;

    /**
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @param Context $context
     * @param ConvertToCustomCsv $converter
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Context $context,
        ConvertToCustomCsv $converter,
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
        return $this->fileFactory->create('CustomOrderCsv.csv', $this->converter->getCustomCsvFile(), 'var');
    }
}