<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Client\Yookassa as Client;
use YookassaException;

#[AsCommand(
    name: 'app:yookassa',
    description: 'Add a short description for your command',
)]
class YookassaCommand extends Command
{

    public function __construct(private readonly Client $yookassa)
    {
        parent::__construct();


    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
            ->addOption(
                'extra-option',
                null,
                InputOption::VALUE_NONE,
                'Whether or not to do something optional'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $receipt = array(
            'receipt' => array(
                'customer'  => array(
                    'email' => 'user@example.com',
                ),
                'items' => array(
                    array(
                        'description' => 'Пошив одежды по размеру',
                        'quantity' => 1.000,
                        'amount' => array(
                            'value' => 100.00,
                            'currency' => 'RUB'
                        ),
                        'vat_code' => 1,
                        'payment_mode' => 'partial_prepayment',
                        'payment_subject' => 'service',
                    ),
                ),
            ));
        $link = $this->yookassa->getPaymentLink(100, 'test', 'http://ya.ru', $receipt);

        var_dump($link->getId());
        $io->success('Payment link ');

        return Command::SUCCESS;
    }
}
