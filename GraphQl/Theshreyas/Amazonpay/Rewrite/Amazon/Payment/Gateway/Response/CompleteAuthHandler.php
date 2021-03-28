<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Theshreyas\Amazonpay\Rewrite\Amazon\Payment\Gateway\Response;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Model\Method\Logger;
use Amazon\Payment\Gateway\Helper\SubjectReader;
use Amazon\Core\Helper\Data;
use Amazon\Payment\Api\Data\PendingAuthorizationInterfaceFactory;

class CompleteAuthHandler extends \Amazon\Payment\Gateway\Response\CompleteAuthHandler
{

    /**
     * @var Data
     */
    private $coreHelper;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var SubjectReader
     */
    private $subjectReader;

    /**
     * @var PendingAuthorizationInterfaceFactory
     */
    private $pendingAuthorizationFactory;

    /**
     * CompleteAuthHandler constructor.
     *
     * @param Logger $logger
     * @param SubjectReader $subjectReader
     * @param PendingAuthorizationInterfaceFactory $pendingAuthorizationFactory
     * @param Data $coreHelper
     */
    public function __construct(
        Logger $logger,
        SubjectReader $subjectReader,
        PendingAuthorizationInterfaceFactory $pendingAuthorizationFactory,
        Data $coreHelper
    ) {
        $this->logger = $logger;
        $this->subjectReader = $subjectReader;
        $this->coreHelper = $coreHelper;
        $this->pendingAuthorizationFactory = $pendingAuthorizationFactory;
    }

    /**
     * @param array $handlingSubject
     * @param array $response
     * @throws \Exception
     */
    public function handle(array $handlingSubject, array $response)
    {

        $paymentDO = $this->subjectReader->readPayment($handlingSubject);
        $payment = $paymentDO->getPayment();
        $order = $payment->getOrder();
        $quote_id = $order->getQuoteId();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/payment_info.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('-------------- CompleteAuthHandler -------------');
        $logger->info(json_encode($handlingSubject));

        if ($response['status']) {
            $payment->setTransactionId($response['authorize_transaction_id']);


            if ($response['timeout']) {
                $payment->setIsTransactionPending(true);
                $order->setState(\Magento\Sales\Model\Order::STATE_PAYMENT_REVIEW)->setStatus(\Magento\Sales\Model\Order::STATE_PAYMENT_REVIEW);
                $this->pendingAuthorizationFactory->create()
                    ->setAuthorizationId($response['authorize_transaction_id'])
                    ->save();
            }
            $payment->setIsTransactionClosed(false);
            $quoteLink = $this->subjectReader->getQuoteLink($quote_id);
            $quoteLink->setConfirmed(true)->save();
        }
    }

}

