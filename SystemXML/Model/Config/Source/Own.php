<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Theshreyas\SystemXML\Model\Config\Source;

class Own implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Definition toOptionArray
     */
    public function toOptionArray()
    {
        return [['value' => 'abc', 'label' => __('abc')],['value' => 'xyz', 'label' => __('xyz')],['value' => 'def', 'label' => __('def')]];
    }

    /**
     * Definition toArray
     */
    public function toArray()
    {
        return ['abc' => __('abc'),'xyz' => __('xyz'),'def' => __('def')];
    }
}
