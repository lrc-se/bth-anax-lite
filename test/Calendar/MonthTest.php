<?php

namespace LRC\Calendar;

/**
 * Test cases for calendar class Month.
 */
class MonthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test object instantiation.
     */
    public function testInstantiation()
    {
        $month = new Month(2017, 2);
        $this->assertEquals(2017, $month->getYear());
        $this->assertEquals(2, $month->getNumber());
        $this->assertEquals(28, $month->getLength());
    
        $month = new Month(2016, 2);
        $this->assertEquals(29, $month->getLength());
        $this->assertEquals('Februari', $month->getName());
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid month: wrong--3');
        $month = new Month('wrong', -3);
    }
    
    /**
     * Test non-trivial methods.
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testMethods()
    {
        $month = new Month(1999, 12);
        $firstDate = \DateTime::createFromFormat('Y-m-d', '1999-12-01');
        $this->assertEquals($firstDate, $month->getFirstDate());
        $this->assertFalse($month->isToday(31));
        
        $today = new \DateTime();
        $month = new Month($today->format('Y'), $today->format('n'));
        $this->assertTrue($month->isToday($today->format('j')));
    }
}
