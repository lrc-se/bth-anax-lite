<?php

namespace LRC\Calendar;

class Month
{
    const MONTH_NAMES = ['Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'];
    const DAY_NAMES = ['Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag', 'Söndag'];
    
    private $year;
    private $number;
    private $length;
    
    
    /**
     * Constructor.
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct($year, $number)
    {
        $date = \DateTime::createFromFormat('Y-n', "$year-$number");
        if (!$date || $date->format('Y-n') != "$year-$number") {
            throw new \Exception("Invalid month: $year-$number");
        }
        $this->year = $year;
        $this->number = $number;
        $this->length = cal_days_in_month(CAL_GREGORIAN, $this->number, $this->year);
    }
    
    /**
     * Returns the year of the month.
     */
    public function getYear()
    {
        return $this->year;
    }
    
    /**
     * Returns the number of the month.
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * Returns the number of days in the month.
     */
    public function getLength()
    {
        return $this->length;
    }
    
    /**
     * Returns the name of the month.
     */
    public function getName()
    {
        return self::MONTH_NAMES[$this->number - 1];
    }
    
    /**
     * Returns the date of the month's first day.
     */
    public function getFirstDate()
    {
        $date = new \DateTime();
        $date->setDate($this->year, $this->number, 1);
        return $date;
    }
    
    /**
     * Checks whether the given day in the month is today.
     */
    public function isToday($day)
    {
        $today = new \DateTime();
        $date = new \DateTime();
        $date->setDate($this->year, $this->number, $day);
        return ($date->format('Y-m-d') == $today->format('Y-m-d'));
    }
}
