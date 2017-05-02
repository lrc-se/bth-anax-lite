<?php

namespace LRC\User;

/**
 * Test cases for class User.
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test object instantiation and properties.
     */
    public function testInstantiation()
    {
        $user = new User();
        $this->assertEquals(0, $user->level);
        $this->assertEquals(1, $user->active);
        $this->assertNull($user->id);
        $this->assertNull($user->username);
        $this->assertNull($user->password);
        $this->assertNull($user->email);
        $this->assertNull($user->image);
    }
    
    /**
     * Test methods.
     */
    public function testMethods()
    {
        $user = new User();
        $this->assertEquals('img/user.png', $user->getImage());
        $user->image = 'img/user2.png';
        $this->assertEquals('img/user2.png', $user->getImage());
        
        $this->assertEquals('Användare', $user->getLevel());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isAdmin(true));
        $user->level = 1;
        $this->assertEquals('Administratör', $user->getLevel());
        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isAdmin(true));
        $user->level = 2;
        $this->assertEquals('Super&shy;administratör', $user->getLevel());
        $this->assertTrue($user->isAdmin());
        $this->assertTrue($user->isAdmin(true));
    }
}
