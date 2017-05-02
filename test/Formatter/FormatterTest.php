<?php

namespace LRC\Formatter;

/**
 * Test cases for class Formatter.
 */
class FormatterTest extends \PHPUnit_Framework_TestCase
{
    private $formatter;
    
    public function __construct()
    {
        $this->formatter = new Formatter();
    }
    
    /**
     * Test nl2br formatter.
     */
    public function testNewlines()
    {
        $this->assertEquals(nl2br("test\ntest\r\ntest", false), $this->formatter->nl2br("test\ntest\r\ntest"));
    }
    
    /**
     * Test link formatter.
     */
    public function testLink()
    {
        $this->assertEquals('hej hopp <a href="https://dbwebb.se/">https://dbwebb.se/</a> i galopp', $this->formatter->link('hej hopp https://dbwebb.se/ i galopp'));
    }
    
    /**
     * Test strip formatter.
     */
    public function testStrip()
    {
        $this->assertEquals('hej hopp i galopp alert("XSS!");', $this->formatter->strip('hej <b>hopp</b> i <I>galopp</i> <script>alert("XSS!");</script>'));
    }
    
    /**
     * Test escape formatter.
     */
    public function testEscape()
    {
        $this->assertEquals('&lt;em&gt;Hej&lt;/em&gt; hopp &amp; &quot;galopp&quot;!', $this->formatter->esc('<em>Hej</em> hopp & "galopp"!'));
    }
    
    /**
     * Test slug formatter.
     */
    public function testSlug()
    {
        $this->assertEquals('det-har-verkar-ha-gatt-gott-inte-sant', $this->formatter->slug('Det här verkar ha gått GÖTT, inte sant!?'));
    }
    
    /**
     * Test BBCode formatter.
     */
    public function testBBCode()
    {
        $this->assertEquals(
            '<strong>hej</strong> <em>hopp</em> <u>i</u> <a href="http://galopp.se/img.jpg"><img src="http://galopp.se/img.jpg" alt=""></a> <a href="https://dbwebb.se/">https://dbwebb.se/</a>',
            $this->formatter->bbcode('[b]hej[/b] [i]hopp[/i] [u]i[/u] [url=http://galopp.se/img.jpg][img]http://galopp.se/img.jpg[/img][/url] [url]https://dbwebb.se/[/url]')
        );
    }
    
    /**
     * Test Markdown formatter.
     */
    public function testMarkdown()
    {
        $this->assertEquals(
            "<p><em>hej</em> <strong>Hopp</strong> i <strong><em>GALOPP</em></strong>! <img src=\"img.jpg\" alt=\"Test\" /></p>\n",
            $this->formatter->markdown('*hej* __Hopp__ i ***GALOPP***! ![Test](img.jpg)')
        );
    }
    
    /**
     * Test apply method.
     */
    public function testApply()
    {
        $this->assertEquals('&lt;em&gt;test&lt;/em&gt; &lt;u&gt;TEST&lt;/u&gt;', $this->formatter->apply('<strong>[i]test[/i]</strong> [u]<sup>TEST</sup>[/u]', 'strip,bbcode , esc'));
        $this->assertEquals('&lt;em&gt;test&lt;/em&gt; &lt;u&gt;TEST&lt;/u&gt;', $this->formatter->apply('<strong>[i]test[/i]</strong> [u]<sup>TEST</sup>[/u]', 'strip,foo, bbcode,esc,bar'));
    }
}
