<?php
namespace Theshreyas\MassProductUpdate\Plugin\Ui\Model;

class AbstractReader
{
    /**
     * @var \Theshreyas\MassProductUpdate\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Catalog\Model\Product\AttributeSet\Options
     */
    private $attributeSets;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    private $visibility;

    public function __construct(
        \Theshreyas\MassProductUpdate\Helper\Data $helper,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Catalog\Model\Product\AttributeSet\Options $attributeSets,
        \Magento\Catalog\Model\Product\Visibility $visibility
    ) {
        $this->helper = $helper;
        $this->moduleManager = $moduleManager;
        $this->attributeSets = $attributeSets->toOptionArray();
        $this->visibility = $visibility;
    }

    /**
     * Generate xml for creating one action
     */
    protected function generateElement($name)
    {
        $data = $this->helper->getActionDataByName($name);
        $placeholder = (array_key_exists('placeholder', $data)) ? $data['placeholder'] : '';

        $result = [
            'arguments' => [
                'data' => [
                    "name" => "data",
                    "xsi:type" => "array",
                    "item" => [
                        'config' => [
                            "name" => "config",
                            "xsi:type" => "array",
                            "item" => [
                                "component" => [
                                    "name" => "component",
                                    "xsi:type" => "string",
                                    "value" => "uiComponent"
                                ],
                                "theshreyas_actions" => [
                                    "name" => "component",
                                    "xsi:type" => "string",
                                    "value" => 'true'
                                ],
                                "confirm" => [
                                    "name" => "confirm",
                                    "xsi:type" => "array",
                                    "item" => [
                                        "title" => [
                                            "name" => "title",
                                            "xsi:type" => "string",
                                            "translate" => "true",
                                            "value" => $data['confirm_title']
                                        ],
                                        "message" => [
                                            "name" => "message",
                                            "xsi:type" => "string",
                                            "translate" => "true",
                                            "value" => $data['confirm_message']
                                        ]
                                    ]
                                ],
                                "type" => [
                                    "name" => "type",
                                    "xsi:type" => "string",
                                    "value" => 'theshreyas_' . $data['type']
                                ],
                                "label" => [
                                    "name" => "label",
                                    "xsi:type" => "string",
                                    "translate" => "true",
                                    "value" => $data['label']
                                ],
                                "url" => [
                                    "name" => "url",
                                    "xsi:type" => "url",
                                    "path" => $data['url']
                                ]

                            ]
                        ]
                    ]
                ],
                'actions' => [
                    "name" => "actions",
                    "xsi:type" => "array",
                    'item' => [
                        0 => [
                            "name" => "0",
                            "xsi:type" => "array",
                            "item" => [
                                "typefield" => [
                                    "name" => "type",
                                    "xsi:type" => "string",
                                    "value" => "textbox"
                                ],
                                "fieldLabel" => [
                                    "name" => "fieldLabel",
                                    "xsi:type" => "string",
                                    "value" => $data['fieldLabel']
                                ],
                                "placeholder" => [
                                    "name" => "placeholder",
                                    "xsi:type" => "string",
                                    "value" => $placeholder
                                ],
                                "label" => [
                                    "name" => "label",
                                    "xsi:type" => "string",
                                    "translate" => "true",
                                    "value" => ""
                                ],
                                "url" => [
                                    "name" => "url",
                                    "xsi:type" => "url",
                                    "path" => $data['url']
                                ],
                                "type" => [
                                    "name" => "type",
                                    "xsi:type" => "string",
                                    "value" => 'Theshreyas_' . $data['type']
                                ],
                            ]
                        ]
                    ]
                ]
            ],
            'attributes' => [
                'class' => \Magento\Ui\Component\Action::class,
                'name' => $name
            ],
            'children' => []

        ];

        if (array_key_exists('hide_input', $data)) {
            $result['arguments']['actions']['item'][0]['item']['hide_input'] = [
                "name" => "hide_input",
                "xsi:type" => "string",
                "value" => '1'
            ];
        }

        return $result;
    }
}
