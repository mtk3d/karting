<?php

declare(strict_types=1);

namespace Karting\App\Formatter;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class MoneyFormatter
{
    private IntlMoneyFormatter $moneyFormatter;

    public function __construct()
    {
        $currencies = new ISOCurrencies();
        $numberFormatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $this->moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
    }

    public function format(Money $money): string
    {
        return $this->moneyFormatter->format($money);
    }
}
