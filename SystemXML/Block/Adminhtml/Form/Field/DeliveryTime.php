<?php

namespace Theshreyas\SystemXML\Block\Adminhtml\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;

class DeliveryTime extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\Data\Form\Element\Renderer\RendererInterface,
    \Magento\Widget\Block\BlockInterface
{
    public const TIME_NAME_FROM = 'groups[complex_fields][fields][delivery_time_from][value]';
    public const TIME_NAME_TO   = 'groups[complex_fields][fields][delivery_time_to][value]';

    /**
     * Form element which re-rendering
     *
     * @var \Magento\Framework\Data\Form\Element\Fieldset
     */
    protected $element;

    /**
     * @var string
     */
    protected $_template = 'Theshreyas_SystemXML::form/renderer/timeslider.phtml';

    /**
     * @var string
     */
    protected $_htmlId = 'time-range';

    /**
     * Retrieve an element
     *
     * @return \Magento\Framework\Data\Form\Element\Fieldset
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Set an element
     *
     * @param AbstractElement $element
     * @return $this
     */
    public function setElement(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Render element
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $this->element = $element;

        return $this->toHtml();
    }

    /**
     * @return string
     */
    public function getHtmlId()
    {
        return $this->_htmlId;
    }

    /**
     * @return string
     */
    public function getNameFrom()
    {
        return self::TIME_NAME_FROM;
    }

    /**
     * @return string
     */
    public function getNameTo()
    {
        return self::TIME_NAME_TO;
    }

    /**
     * @param int $minutes
     * @return string
     */
    public function minutesToTime($minutes)
    {
        $hours   = floor($minutes / 60);
        $minutes = $minutes % 60;
        $part    = $hours >= 12 ? 'PM' : 'AM';

        return sprintf('%02d:%02d %s', $hours, $minutes, $part);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    protected function _toHtml()
    {
        if (!$this->getTemplate()) {
            return '';
        }

        return $this->fetchView($this->getTemplateFile());
    }
}
