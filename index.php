<?php
declare(strict_types= 1);
function scheduleGen(?int $year = null, ?int $month = null, int $monthCount = 1, ?int $currentDay = null): void {
    $year ??= (int) date('Y');
    $month ??= (int) date('m');
    $currentDay ??= 1;
    $currentDayFormatted = strlen((string) $currentDay) === 1 ? '0' . $currentDay : $currentDay; 
    $currentDayObject = DateTime::createFromFormat('d-m-Y', $currentDayFormatted . '-' . $month . '-' . $year); 
    $firstDay = DateTime::createFromFormat('d-m-Y', '01-' . $month . '-' . $year);
    echo $firstDay->format('F') . PHP_EOL;
    $daysInMonth = (int)$firstDay->format('t');
    $currentWeekday = (int)$firstDay->format('N');
    $position = 0;
    for ($i = 1; $i < $currentWeekday; $i++) {
        echo '   ';
        $position++;
    }
    $currentWeekday = (int)$currentDayObject->format('N');
    $workDays = [];
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
    echo PHP_EOL;
    if ($monthCount > 1) {
        if ($month === 12) {
            $month = 1;
            $year++;
        } else {
            $month++;
        }
        $currentDay = end($workDays) + 3 - $daysInMonth;
        scheduleGen($year, $month, $monthCount - 1, $currentDay);
    }
}

scheduleGen(2026, 10, 5);