<?php
namespace Theshreyas\FrontendDisable\Model\Config\Source;


class Custom implements \Magento\Framework\Option\ArrayInterface{

    public function toOptionArray()
    {

        return [
            ['value' => 0, 'label' => __('Normal')],
            ['value' => 1, 'label' => __('Blank Page')],
            ['value' => 2, 'label' => __('Redirect to Home Page')],
            ['value' => 3, 'label' => __('Redirect to Admin')],
            ['value' => 4, 'label' => __('Custom URL')]
        ];
    }
}