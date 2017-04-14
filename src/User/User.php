<?php

namespace LRC\User;

class User
{
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
    
    public function isAdmin($super = false)
    {
        return ($this->level >= ($super ? 2 : 1));
    }
}
