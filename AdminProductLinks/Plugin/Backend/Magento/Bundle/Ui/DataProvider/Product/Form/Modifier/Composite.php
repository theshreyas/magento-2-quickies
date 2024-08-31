<?php
declare (strict_types = 1);

namespace Theshreyas\AdminProductLinks\Plugin\Backend\Magento\Bundle\Ui\DataProvider\Product\Form\Modifier;

class Composite
{
    /**
     * Construct function
     *
     * @param \Theshreyas\AdminProductLinks\Helper\Data $helper
     */
    public function __construct(
        protected \Theshreyas\AdminProductLinks\Helper\Data $helper
    ) {
    }

    /**
     * Update html template
     *
     * @param \Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\Composite $subject
     * @param mixed $result
     * @param mixed $data
     */
    public function afterModifyData(
        \Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\Composite $subject,
        $result,
        $data
    ) {
        foreach ($result as $k => $v) {
            if (empty($v['bundle_options']['bundle_options'])) {
                continue;
            }

            foreach ($v['bundle_options']['bundle_options'] as $k2 => $v2) {
                if (empty($v2['bundle_selections']) || !is_array($v2['bundle_selections'])) {
                    continue;
                }

                foreach ($v2['bundle_selections'] as $k3 => $child) {
                    if (isset($child['product_id'])) {
                        $url = $this->helper->getProductUrl($child['product_id']);
                        $urlHtml = '<a target="_blank" href="' . $url . '">' . $child['name']. '</a>';
                        $result[$k]['bundle_options']['bundle_options'][$k2]['bundle_selections'][$k3]['name'] = $urlHtml;
                    }
                }
            }
        }
        return $result;
    }
}
