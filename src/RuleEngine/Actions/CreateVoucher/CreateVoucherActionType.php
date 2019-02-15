<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 5:00 PM
 */

namespace App\RuleEngine\Actions\CreateVoucher;


use App\RuleEngine\ActionTypeInterface;
use App\RuleEngine\ContextModels\Voucher;
use App\RuleEngine\ValueResolver;
use Psr\Log\LoggerInterface;

class CreateVoucherActionType implements ActionTypeInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function perform(ValueResolver $valueResolver): array
    {
        $voucherId = $valueResolver->get('voucher_id');
        $this->logger->info('action_create_voucher', ['voucher_id' => $voucherId]);

        $voucher = new Voucher();
        $voucher->setVoucherId($voucherId);
        $voucher->setCustomerCode(uniqid());

        return [
            'voucher' => $voucher,
        ];
    }

    public function getParametersFormType(): string
    {
        return CreateVoucherActionFormType::class;
    }

    public function getResultDefinition(): array
    {
        return [
            'voucher' => Voucher::class,
        ];
    }
}
