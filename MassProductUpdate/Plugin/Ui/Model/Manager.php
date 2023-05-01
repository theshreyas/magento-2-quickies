<?php
namespace Theshreyas\MassProductUpdate\Plugin\Ui\Model;

class Manager extends AbstractReader
{
    /**
     * Create xml config with php from admin panel
     *
     * @param \Magento\Ui\Model\Manager $subject
     * @param array $result
     * @param array $arguments
     * @return array
     */
    public function afterGetData(
        \Magento\Ui\Model\Manager $subject,
        $result
    ) {
        $availableOptions = $this->helper->getMassUpdateOptions();
        //echo '<pre>'; print_r($availableOptions); exit;
        if ($this->moduleManager->isOutputEnabled('Theshreyas_MassProductUpdate') &&
            isset($result['product_listing']['children']['listing_top']['children']['listing_massaction']['children'])
        ) {
            //$item = 'modifyprice';
            $children = &$result['product_listing']['children']['listing_top']['children']['listing_massaction']['children'];
            foreach($availableOptions as $item) {
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
