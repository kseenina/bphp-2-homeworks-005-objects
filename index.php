<?php
declare(strict_types= 1);
function scheduleGen(): void {
    $month = date('m');
    $year = date('Y');
    $firstDay = DateTime::createFromFormat('d-m-Y', '01-' . $month . '-' . $year);
    echo($firstDay->format('F') . PHP_EOL);
    $daysInMonth = (int)$firstDay->format('t');
    $currentWeekday = (int)$firstDay->format('N');
    $position = 0;
    for ($i = 1; $i < $currentWeekday; $i++) {
        echo '   ';
        $position++;
    }
    $workDays = [];
    $currentDay = 1;
    while ($currentDay <= $daysInMonth) {
        if ($currentWeekday === 6) {
            $currentDay += 2;
            $currentWeekday = 1;
        } elseif ($currentWeekday === 7) {
            $currentDay++;
            $currentWeekday = 1;
        }
        $workDays[] = $currentDay;
        $currentDay += 3;
        $currentWeekday += 3;
        if ($currentWeekday > 7) {
            $currentWeekday -= 7;
        }
    }
    for ($i = 1; $i <= $daysInMonth; $i++) {
        $i < 10 ? $j = '0' . $i : $j = $i;
        if (in_array($i, $workDays, true)) {
            echo "\033[31m" . $j . ' ' . "\033[0m";
        } else {
            echo $j . ' ';
        }
        $position++;
        if ($position % 7 === 0) {
            echo PHP_EOL;
        }
    }
}

scheduleGen();