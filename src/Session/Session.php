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
     *
     * @param   string  $name   Session name.
     */
    public function __construct($name = 'kabc16-anax-lite-session')
    {
        $this->name = $name;
    }
    
    /**
     * Sets the session name.
     *
     * @param   string  $name   The name to set.
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
        if (session_status() == PHP_SESSION_ACTIVE && session_name() == $this->name) {
            return;
        }
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
     *
     * @param   string  $key    The name of the variable to check.
     * @return  bool            True is the variable exists, false otherwise.
     */
    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }
    
    /**
     * Gets a session variable.
     *
     * @param   string  $key        The name of the variable to get.
     * @param   mixed   $default    Default value to return if the variable is not found in the session.
     * @return  mixed               The value of the variable, or the default value if the variable is not found.
     */
    public function get($key, $default = null)
    {
        return ($this->has($key) ? $_SESSION[$key] : $default);
    }
    
    /**
     * Gets a session variable and then removes it from the session.
     *
     * @param   string  $key        The name of the variable to get.
     * @param   mixed   $default    Default value to return if the variable is not found in the session.
     * @return  mixed               The value of the variable, or the default value if the variable is not found.
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
     *
     * @param   string  $key    The name of the variable to set.
     * @param   mixed   $val    The value to set.
     */
    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }
    
    /**
     * Removes a session variable.
     *
     * @param   string  $key    The name of the variable to remove.
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Returns or prints the contents of the session array.
     *
     * @param   bool        $echo   Whether or not to print the output rather than return it.
     * @return  string|void         The session dump as a string, or nothing if echo mode is on.
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
