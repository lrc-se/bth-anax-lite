<?php

namespace LRC\Cookie;

/**
 * Cookie class.
 */
class Cookie
{
    private $defaultExpiry;
    
    
    /**
     * Constructor.
     */
    public function __construct($expiry = null)
    {
        $this->defaultExpiry = (!is_null($expiry) ? time() + $expiry : 0);
    }
    
    /**
     * Clears all cookies.
     */
    public function clear()
    {
        foreach ($_COOKIE as $key) {
            setcookie($key, '', 1);
        }
    }
    
    /**
     * Checks whether a cookie exists.
     */
    public function has($key)
    {
        return array_key_exists($key, $_COOKIE);
    }
    
    /**
     * Gets a cookie.
     */
    public function get($key, $default = null)
    {
        return ($this->has($key) ? $_COOKIE[$key] : $default);
    }
    
    /**
     * Gets a cookie and then removes it.
     */
    public function getOnce($key, $default = null)
    {
        $val = $default;
        if ($this->has($key)) {
            $val = $_COOKIE[$key];
            setcookie($key, '', 1);
        }
        return $val;
    }
    
    /**
     * Sets a cookie.
     */
    public function set($key, $val, $expiry = null)
    {
        setcookie($key, $val, (!is_null($expiry) ? time() + $expiry : $this->defaultExpiry));
    }
    
    /**
     * Removes a cookie.
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            setcookie($key, '', 1);
        }
    }
    
    /**
     * Returns or prints the contents of the cookie array.
     */
    public function dump($echo = false)
    {
        if ($echo) {
            var_dump($_COOKIE);
        } else {
            return var_export($_COOKIE, true);
        }
    }
}
