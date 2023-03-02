<?php

namespace Calculator;

use function cli\line;
use function cli\prompt;

function payAnnuitiPayment(int $sum, int $team, $percent)
{
    $payment = 0;
    $q = $sum;
    $percentPerMonth = ($percent / 12) / 100;
     for ($i = 1; $i <= $team; $i++) {
        $percentParth = round(($sum - $payment) * $percentPerMonth, 2);
        $coefficient = $percentPerMonth * ((1 + $percentPerMonth) ** $team) / ((1 + $percentPerMonth) ** $team - 1);
        $payment = round($sum * $coefficient, 2);
        $partDuty = round($payment - $percentParth, 2);
        $q = round($q - $partDuty, 2);
        line("Платёж в месяц: %s        Процентная часть: %s        Часть от ОД: %s     Остаток задолженности: %s", $payment, $percentParth, $partDuty, $q);
     }
}

function payDifPayment(int $sum, int $team, &$percent)
{
    $partDuty = round($sum / $team, 2);
    $percent = $percent / 100;
    $daysInYear = 360;
    for ($i = 1; $i <= $team; $i++) {
        $q = $sum - ($partDuty * $i);
        $interestPaid = round(($q * $percent * 30) / $daysInYear, 2);
        $payment = $partDuty + $interestPaid;
        line("Платёж в месяц: %s        Процентная часть: %s        Часть от ОД: %s     Остаток задолженности: %s", $payment, $interestPaid, $partDuty, $q);
    }
}

function payCredit()
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
