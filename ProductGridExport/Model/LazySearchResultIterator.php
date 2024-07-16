<?php

namespace Theshreyas\ProductGridExport\Model;

use Exception;
use Iterator;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;

class LazySearchResultIterator implements Iterator
{

    protected $generator;

    public function __construct(AbstractCollection $collection)
    {
        $this->generator = static::getGenerator($collection);
    }

    public static function getGenerator(AbstractCollection $collection)
    {
        $lastPage = (int) $collection->getLastPageNumber();

        for ($page = (int) $collection->getCurPage(); $page <= $lastPage; $page++) {
            $items = $collection->setCurPage($page)
                ->clear() // If we do not clear, getItems will return stale results.
                ->getItems();

            yield from $items;
        }
    }

    public function rewind(): void
    {
        $this->generator->rewind();
    }

    public function valid(): bool
    {
        return $this->generator->valid();
    }

    public function current(): mixed
    {
        return $this->generator->current();
    }

    public function key(): mixed
    {
        return $this->generator->key();
    }

    public function next(): void
    {
        $this->generator->next();
    }
}
