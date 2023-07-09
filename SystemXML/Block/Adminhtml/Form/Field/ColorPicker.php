<?php
namespace Theshreyas\SystemXML\Block\Adminhtml\Form\Field;

class ColorPicker extends \Magento\Config\Block\System\Config\Form\Field
{
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {
        $html = $element->getElementHtml();
        $value = $element->getData('value');

        $html .= $value.'<script type="text/javascript">
            require(["jquery","jquery/colorpicker/js/colorpicker"], function ($) {
               "use strict";
                $(document).ready(function () {
                  console.log("start45");
                    var $el = $("#' . $element->getHtmlId() . '");
                  console.log($el);
                    $el.css("backgroundColor", "'. $value .'");

                    // Attach the color picker
                    $el.ColorPicker({
                        color: "'. $value .'",
                        onChange: function (hsb, hex, rgb) {
                            $el.css("backgroundColor", "#" + hex).val("#" + hex);
                        }
                    });
                  console.log("end45");
                });
            });
            </script>';
        return $html;
    }
}