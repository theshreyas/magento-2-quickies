<?php

namespace Theshreyas\ProductGridExport\Model\Export;

use Theshreyas\ProductGridExport\Model\LazySearchResultIterator;
use Magento\Framework\Convert\ExcelFactory;
use Magento\Framework\Filesystem;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Ui\Model\Export\ConvertToXml;
use Magento\Ui\Model\Export\MetadataProvider;
use Magento\Ui\Model\Export\SearchResultIteratorFactory;

class ConvertToXls extends ConvertToXml
{

    /**
     * Returns XLS file
     *
     * @return array
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getXlsFile()
    {
        $component = $this->filter->getComponent();

        $name = md5(microtime());
        $file = 'export/'. $component->getName() . $name . '.xls';

        $this->filter->applySelectionOnTargetProvider();
        $dataProvider = $component->getContext()->getDataProvider();

        // Force all results
        $searchResult = $dataProvider->getSearchResult()
            ->setCurPage(1)
            ->setPageSize($this?->pageSize ?? 200);

        $excel = $this->excelFactory->create([
            'iterator' => LazySearchResultIterator::getGenerator($searchResult),
            'rowCallback'=> [$this, 'getRowData'],
        ]);

        $this->directory->create('export');
        $stream = $this->directory->openFile($file, 'w+');
        $stream->lock();
        $excel->setDataHeader($this->metadataProvider->getHeaders($component));
        $excel->write($stream, $component->getName() . '.xls');

        $stream->unlock();
        $stream->close();

        return [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ];
    }

    public function getRowData($item) : array
    {
        return $this->metadataProvider->getRowData($item, $this->metadataProvider->getFields($this->filter->getComponent()), []);
    }
}
