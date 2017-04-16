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
     *
     * @param   int     $expiry     Default expiry time (in seconds from now).
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
     *
     * @param   string  $key    The name of the cookie to check.
     * @return  bool            True if the cookie exists, false otherwise.
     */
    public function has($key)
    {
        return array_key_exists($key, $_COOKIE);
    }
    
    /**
     * Gets a cookie.
     *
     * @param   string  $key        The name of the cookie to get.
     * @param   mixed   $default    Default value to return if the cookie is not found.
     * @return  mixed               The value of the cookie, or the default value if the cookie is not found.
     */
    public function get($key, $default = null)
    {
        return ($this->has($key) ? $_COOKIE[$key] : $default);
    }
    
    /**
     * Gets a cookie and then removes it.
     *
     * @param   string  $key        The name of the cookie to get.
     * @param   mixed   $default    Default value to return if the cookie is not found.
     * @return  mixed               The value of the cookie, or the default value if the cookie is not found.
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
     *
     * @param   string      $key    The name of the cookie to set.
     * @param   mixed       $val    The value to set.
     * @param   int|null    $expiry The expiry time, in seconds from now (uses default expiry time as defined in the constructor if null).
     */
    public function set($key, $val, $expiry = null)
    {
        setcookie($key, $val, (!is_null($expiry) ? time() + $expiry : $this->defaultExpiry));
    }
    
    /**
     * Removes a cookie.
     *
     * @param   string  $key    The name of the cookie to remove.
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            setcookie($key, '', 1);
        }
    }
    
    /**
     * Returns or prints the contents of the cookie array.
     *
     * @param   bool        $echo   Whether or not to print the output rather than return it.
     * @return  string|void         The cookie dump as a string, or nothing if echo mode is on.
     */
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
