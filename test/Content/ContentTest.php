<?php

namespace LRC\Content;

/**
 * Test cases for class Content.
 */
class ContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test object instantiation and methods.
     */
    public function testObject()
    {
        $content = new Content();
        $content->type = 'page';
        $this->assertEquals('Sida', $content->getType());
        $this->assertTrue($content->isPage());
        $this->assertFalse($content->isPost());
        $this->assertFalse($content->isBlock());
        $content->type = 'post';
        $this->assertEquals('Inlägg', $content->getType());
        $this->assertTrue($content->isPost());
        $this->assertFalse($content->isPage());
        $this->assertFalse($content->isBlock());
        $content->type = 'block';
        $this->assertEquals('Block', $content->getType());
        $this->assertTrue($content->isBlock());
        $this->assertFalse($content->isPage());
        $this->assertFalse($content->isPost());
        
        $this->assertFalse($content->isPublished());
        $date = new \DateTime();
        $date->setTimestamp($date->getTimestamp() - 3600);
        $content->published = $date->format('Y-m-d H:i:s');
        $this->assertTrue($content->isPublished());
        $date->setTimestamp($date->getTimestamp() + 7200);
        $content->published = $date->format('Y-m-d H:i:s');
        $this->assertFalse($content->isPublished());
    }
}
