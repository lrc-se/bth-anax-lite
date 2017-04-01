<?php

namespace LRC\Session;

/**
 * Session class.
 */
class Session
{
    private $name;
    
    
    /**
     * Constructor.
     */
    public function __construct($name = 'kabc16-anax-lite-session')
    {
        $this->name = $name;
    }
    
    /**
     * Sets the session name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Starts the session.
     */
    public function start()
    {
        session_name($this->name);
        session_start();
    }
    
    /**
     * Resets the session.
     */
    public function clear()
    {
        session_destroy();
    }
    
    /**
     * Checks whether a session variable exists.
     */
    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }
    
    /**
     * Gets a session variable.
     */
    public function get($key, $default = null)
    {
        return ($this->has($key) ? $_SESSION[$key] : $default);
    }
    
    /**
     * Gets a session variable and then removes it from the session.
     */
    public function getOnce($key, $default = null)
    {
        $val = $default;
        if ($this->has($key)) {
            $val = $_SESSION[$key];
            unset($_SESSION[$key]);
        }
        return $val;
    }
    
    /**
     * Sets a session variable.
     */
    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }
    
    /**
     * Removes a session variable.
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Returns or prints the contents of the session array.
     */
    public function dump($echo = false)
    {
        if ($echo) {
            var_dump($_SESSION);
        } else {
            return var_export($_SESSION, true);
        }
    }
}
