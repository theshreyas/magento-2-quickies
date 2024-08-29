<?php

namespace Theshreyas\SystemXML\Model\Adminhtml\System\Config\Backend;

use Magento\Framework\Exception\LocalizedException;
use Magento\Reminder\Model\Config\Source\CronFrequencyTypes;

class ReindexCron extends \Magento\Framework\App\Config\Value
{
    public const CRON_STRING_PATH = 'crontab/default/jobs/cron_frequency/schedule/cron_expr';

    public const CRON_MODEL_PATH = 'crontab/default/jobs/cron_frequency/run/model';

    /**
     * @var string
     */
    protected $_runModelPath = '';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Config\ValueFactory $_configValueFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param string $runModelPath
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        protected \Magento\Framework\App\Config\ValueFactory $_configValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        $runModelPath = '',
        array $data = []
    ) {
        $this->_runModelPath = $runModelPath;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * Cron settings after save
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterSave()
    {
        $time = $this->getData('groups/cron_frequency/fields/time/value');
        $frequency = $this->getData('groups/cron_frequency/fields/frequency/value');

        $cronExprString = '';

        if ($frequency == CronFrequencyTypes::CRON_MINUTELY) {
            $interval = (int)$this->getFieldsetDataValue('interval');
            $cronExprString = "*/{$interval} * * * *";
        } elseif ($frequency == CronFrequencyTypes::CRON_HOURLY) {
            $minutes = (int)$this->getFieldsetDataValue('minutes');
            if ($minutes >= 0 && $minutes <= 59) {
                $cronExprString = "{$minutes} * * * *";
            } else {
                throw new LocalizedException(
                    __('The valid number of minutes needs to be entered. Enter and try again.')
                );
            }
        } else {
            $cronExprArray = [
                (int)$time[1],
                (int)$time[0],
                $frequency == \Magento\Cron\Model\Config\Source\Frequency::CRON_MONTHLY ? '1' : '*',
                '*',
                $frequency == \Magento\Cron\Model\Config\Source\Frequency::CRON_WEEKLY ? '1' : '*',
            ];

            $cronExprString = join(' ', $cronExprArray);
        }

        try {
            $this->_configValueFactory->create()->load(
                self::CRON_STRING_PATH,
                'path'
            )->setValue(
                $cronExprString
            )->setPath(
                self::CRON_STRING_PATH
            )->save();

            $this->_configValueFactory->create()->load(
                self::CRON_MODEL_PATH,
                'path'
            )->setValue(
                $this->_runModelPath
            )->setPath(
                self::CRON_MODEL_PATH
            )->save();
        } catch (\Exception $e) {
            throw new LocalizedException(__('The Cron expression was unable to be saved.'));
        }
        return parent::afterSave();
    }
}
