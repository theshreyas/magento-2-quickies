<?php

namespace Theshreyas\SystemXML\Model\Adminhtml\System\Config\Source;

class CronFrequencyTypes
{
    public const CRON_WEEKLY = 'W';

    public const CRON_MONTHLY = 'M';

    /**
     * @param \Magento\Reminder\Model\Config\Source\CronFrequencyTypes $cronFrequencyTypes
     */
    public function __construct(
        protected \Magento\Reminder\Model\Config\Source\CronFrequencyTypes $cronFrequencyTypes
    ) {
    }

    /**
     * Return array of cron frequency types
     *
     * @return array
     */
    public function getCronFrequencyTypes()
    {
        $cronFrequencies = $this->cronFrequencyTypes->getCronFrequencyTypes();
        $frequencies = [self::CRON_WEEKLY => __('Weekly'),
            self::CRON_MONTHLY => __('Monthly')];
        return array_merge($cronFrequencies, $frequencies);
    }
}
