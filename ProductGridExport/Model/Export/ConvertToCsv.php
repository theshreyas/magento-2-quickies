<?php

namespace Theshreyas\ProductGridExport\Model\Export;

use Theshreyas\ProductGridExport\Model\LazySearchResultIterator;
use Magento\Framework\Exception\LocalizedException;

class ConvertToCsv extends \Magento\Ui\Model\Export\ConvertToCsv
{
    /**
     * Returns CSV file
     *
     * @return array
     * @throws LocalizedException
     */
    public function getCsvFile()
    {
        $component = $this->filter->getComponent();

        $name = md5(microtime());
        $file = 'export/'. $component->getName() . $name . '.csv';

        $this->filter->applySelectionOnTargetProvider();
        $dataProvider = $component->getContext()->getDataProvider();
        $fields = $this->metadataProvider->getFields($component);

        $this->directory->create('export');
        $stream = $this->directory->openFile($file, 'w+');
        $stream->lock();
        $stream->writeCsv($this->metadataProvider->getHeaders($component));
        $page = 1;

        $searchResult = $dataProvider->getSearchResult()
            ->setCurPage($page)
            ->setPageSize($this?->pageSize ?? 200);

        $items = LazySearchResultIterator::getGenerator($searchResult);
        foreach ($items as $item) {
            $this->metadataProvider->convertDate($item, $component->getName());
            $stream->writeCsv($this->metadataProvider->getRowData($item, $fields, []));
        }

        $stream->unlock();
        $stream->close();

        return [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ];
    }
}
