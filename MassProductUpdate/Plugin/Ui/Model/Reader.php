<?php
namespace Theshreyas\MassProductUpdate\Plugin\Ui\Model;

class Reader extends AbstractReader
{
    /**
     * Create xml config with php from admin panel
     *
     * @param \Magento\Ui\Config\Reader $subject
     * @param array $result
     * @param array $arguments
     * @return array
     */
    public function afterRead(
        \Magento\Ui\Config\Reader $subject,
        $result
    ) {

        $availableOptions = $this->helper->getMassUpdateOptions();
        //echo '<pre>'; print_r($availableOptions); exit;
        if ($this->moduleManager->isOutputEnabled('Theshreyas_MassProductUpdate') &&
            isset($result['children']['listing_top']['children']['listing_massaction']['children']) &&
            isset($result['children']['product_listing_data_source'])
        ) {
            //$item = 'modifyprice';
            $children = &$result['children']['listing_top']['children']['listing_massaction']['children'];
            foreach ($availableOptions as $item) {
                if (array_key_exists($item, $children)) {
                    continue;
                }
                $children[$item] = $this->generateElement($item);
            }
            //$children[$item] = $this->generateElement($item);
        }
        return $result;
    }
}
