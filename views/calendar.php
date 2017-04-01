<?php

// find surrounding months
$prev = $month->getNumber() - 1;
$prevMonth = new \LRC\Calendar\Month($month->getYear() - ($prev < 1 ? 1 : 0), ($prev < 1 ? 12 : $prev));
$next = $month->getNumber() + 1;
$nextMonth = new \LRC\Calendar\Month($month->getYear() + ($next > 12 ? 1 : 0), ($next > 12 ? 1 : $next));

?>
        <h1>Månadskalender</h1>
        <div class="calendar">
            <div class="calendar-title">
                <a class="button float-left" href="<?= $app->url->create('calendar/' . $prevMonth->getYear() . '/' . $prevMonth->getNumber()) ?>">« Föregående</a>
                <a class="button float-right" href="<?= $app->url->create('calendar/' . $nextMonth->getYear() . '/' . $nextMonth->getNumber()) ?>">Nästa »</a>
                <h2><?= $month->getName() . ' ' . $month->getYear() ?></h2>
            </div>
            <p class="calendar-image"><img class="img" src="<?= $app->url->asset('img/calendar/' . $month->getNumber()) ?>" alt="<?= $month->getName() ?>"></p>
            <table class="calendar-table">
                <tr>
                    <th>Vecka</th>
<?php foreach (\LRC\Calendar\Month::DAY_NAMES as $n => $name) : ?>
                    <th<?= ($n == 6 ? ' class="red"' : '') ?>><?= $name ?></th>
<?php endforeach; ?>
                </tr>
<?php

// find starting points
$date = $month->getFirstDate();
$week = ltrim($date->format('W'), '0');
$day = -(($date->format('N') - 1) % 7) + 1;

// render week rows
$break = false;
?>
<?php while (!$break) : ?>
                <tr>
                    <td><?= $week ?></td>
<?php
    // render day cells
    for ($i = 0; $i < 7; $i++, $day++) {
        // is the day inside the month?
        if ($day < 1) {
            $dayNum = $prevMonth->getLength() + $day;
            $dayClass = 'calendar-other';
        } elseif ($day > $month->getLength()) {
            $dayNum = $day - $month->getLength();
            $dayClass = 'calendar-other';
        } else {
            $dayNum = $day;
            $dayClass = '';
        }
        
        // is the day a holiday?
        if (($i + 1) % 7 == 0) {
            $dayClass = trim("$dayClass red");
        }
        
        // is the day today?
        if ($month->isToday($day)) {
            $dayClass = trim("$dayClass today");
        }
?>
                    <td<?= ($dayClass ? ' class="' . $dayClass . '"' : '') ?>><?= $dayNum ?></td>
<?php
    }
    
    // done?
    if ($day > $month->getLength()) {
        $break = true;
    }
    
    $date->modify('+1 week');
    $week = ltrim($date->format('W'), '0');
?>
                </tr>
<?php endwhile; ?>
            </table>
        </div>
