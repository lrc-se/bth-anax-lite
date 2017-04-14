<?php

namespace LRC\User;

class User
{
    const LEVELS = ['Användare', 'Administratör', 'Superadministratör'];
    const ORDER_BY = ['username', 'birthdate', 'email', 'level', 'active'];
    
    public $id;
    public $username;
    public $password;
    public $birthdate;
    public $email;
    public $image;
    public $level;
    public $active;
    
    
    public function __construct()
    {
        $this->level = 0;
        $this->active = 1;
    }
    
    public function getAge()
    {
        $now = new \DateTime();
        $years = (int)$now->format('Y') - (int)substr($this->birthdate, 0, 4);
        return ($now->format('m-d') > substr($this->birthdate, 5) ? $years : $years - 1);
    }
    
    public function getImage()
    {
        return (!empty($this->image) ? $this->image : 'img/user.png');
    }
    
    public function getLevel()
    {
        return self::LEVELS[$this->level];
    }
    
    public function isAdmin($super = false)
    {
        return ($this->level >= ($super ? 2 : 1));
    }
}
