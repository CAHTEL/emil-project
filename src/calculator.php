<?php

namespace Calculator;

use function cli\line;
use function cli\prompt;

function payAnnuitiPayment(int $sum, int $team, $percent)
{
    $balance = $sum;
    $percentPerMonth = ($percent / 12) / 100;
    $coefficient = $percentPerMonth * ((1 + $percentPerMonth) ** $team) / ((1 + $percentPerMonth) ** $team - 1);
    $paymentsMonthly = 0;
     for ($i = 1; $i <= $team; $i++) {
        $percentParth = round(($sum - $paymentsMonthly) * $percentPerMonth, 2);
        $payment = round($sum * $coefficient, 2);
        $paymentsMonthly = round($payment - $percentParth, 2);
        $balance = round($balance - $paymentsMonthly, 2);
        line("Платёж в месяц: %s        Процентная часть: %s        Часть от ОД: %s     Остаток задолженности: %s", $payment, $percentParth, $paymentsMonthly, $balance);
     }
}

function payDifPayment(int $sum, int $team, &$percent)
{
    $paymentsMonthly = round($sum / $team, 2);
    $percent = $percent / 100;
    $daysInYear = 360;
    $daysInMonth = 30;
    for ($i = 1; $i <= $team; $i++) {
        $q = $sum - ($paymentsMonthly * $i);
        $interestPaid = round(($q * $percent * $daysInMonth) / $daysInYear, 2);
        $payments = $paymentsMonthly + $interestPaid;
        line("Платёж в месяц: %s        Процентная часть: %s        Часть от ОД: %s     Остаток задолженности: %s", $payments, $interestPaid, $paymentsMonthly, $q);
    }
}

function run()
{
    $sumCredit = prompt('Сумма кредита?(в рублях)');
    $termCredit = prompt('Срок кредитования? (в месяцах)');
    $percentRate = prompt('Процентная ставка?(в процентах)');
    $typeCredit = prompt('Тип платежа?(Аннуитентный или Дифференцированный)');
    if (mb_strtolower($typeCredit) === 'аннуитентный')  {
    payAnnuitiPayment($sumCredit, $termCredit, $percentRate);
    }
    elseif (mb_strtolower($typeCredit) === 'дифференцированный') {
        payDifPayment($sumCredit, $termCredit, $percentRate);
    }
    else {
        print_r('Неверный тип платежа!');
    }
}
