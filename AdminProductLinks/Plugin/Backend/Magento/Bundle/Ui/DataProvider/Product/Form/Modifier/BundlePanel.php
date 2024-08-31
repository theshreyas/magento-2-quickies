<?php
declare (strict_types = 1);

namespace Theshreyas\AdminProductLinks\Plugin\Backend\Magento\Bundle\Ui\DataProvider\Product\Form\Modifier;

class BundlePanel
{
    /**
     * Update html template
     *
     * @param \Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\BundlePanel $subject
     * @param mixed $result
     * @param mixed $meta
     */
    public function afterModifyMeta(
        \Magento\Bundle\Ui\DataProvider\Product\Form\Modifier\BundlePanel $subject,
        $result,
        $meta
    ) {
        if (isset($result["bundle-items"]["children"]["bundle_options"]["children"]["record"]["children"]["product_bundle_container"]["children"]["bundle_selections"]["children"]["record"]["children"]["name"]["arguments"]["data"]["config"]["elementTmpl"])) {
            $result["bundle-items"]["children"]["bundle_options"]["children"]["record"]["children"]["product_bundle_container"]["children"]["bundle_selections"]["children"]["record"]["children"]["name"]["arguments"]["data"]["config"]["elementTmpl"] = "ui/form/element/html";
        }
        return $result;
    }
}
