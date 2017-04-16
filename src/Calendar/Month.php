<?php

namespace LRC\Calendar;

/**
 * Month class for use in calendar.
 */
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
     * @param   int     $year   Year number.
     * @param   int     $number Month number.
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
     *
     * @return  int     Year number.
     */
    public function getYear()
    {
        return $this->year;
    }
    
    /**
     * Returns the number of the month.
     *
     * @return  int     Month number.
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * Returns the number of days in the month.
     *
     * @return  int     Month length.
     */
    public function getLength()
    {
        return $this->length;
    }
    
    /**
     * Returns the name of the month.
     *
     * @return  string  Month name.
     */
    public function getName()
    {
        return self::MONTH_NAMES[$this->number - 1];
    }
    
    /**
     * Returns the date of the month's first day.
     *
     * @return  \DateTime   The date of the first day in the month.
     */
    public function getFirstDate()
    {
        $date = new \DateTime();
        $date->setDate($this->year, $this->number, 1);
        return $date;
    }
    
    /**
     * Checks whether the given day in the month is today.
     *
     * @param   int     $day    Day number.
     * @return  bool            True if the given day is today, false otherwise.
     */
    public function isToday($day)
    {
        $today = new \DateTime();
        $date = new \DateTime();
        $date->setDate($this->year, $this->number, $day);
        return ($date->format('Y-m-d') == $today->format('Y-m-d'));
    }
}
