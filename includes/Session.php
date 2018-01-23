<?php

namespace techdeals;

/**
 * Class Session
 * @package techdeals
 */
class Session
{
    /**
     * @var null
     */
    static $instance = null;
    
    /**
     * Session constructor.
     */
    public function __construct ()
    {
        session_start();
    }
    
    /**
     * @return null|Session
     */
    static function getInstance ()
    {
        if (!self::$instance) {
            self::$instance = new Session();
        }
        
        return self::$instance;
    }
    
    /**
     * @param $mode
     * @param $type
     * @param $args
     */
    public function setFlash ($mode, $type, $args)
    {
        $_SESSION['flash'][$mode][$type] = $args;
    }
    
    /**
     * @param $mode
     * @return bool
     */
    public function getFlashes ($mode)
    {
        if ($this->hasFlashes($mode)) {
            $flash = $_SESSION['flash'][$mode];
            unset($_SESSION['flash'][$mode]);
            
            return $flash;
        }
        
        return null;
        
    }
    
    /**
     * @param $mode
     * @return bool
     */
    public function hasFlashes ($mode)
    {
        return isset($_SESSION['flash'][$mode]);
    }
    
    /**
     * @param $args
     */
    public function setArgsFlash ($args)
    {
        $_SESSION['args_flash'] = $args;
    }
    
    /**
     * @return null
     */
    public function getArgsFlash ()
    {
        if ($this->hasArgsFlash()) {
            $args = $_SESSION['args_flash'];
            unset($_SESSION['args_flash']);
            
            return $args;
        }
        
        return null;
    }
    
    /**
     * @return bool
     */
    public function hasArgsFlash ()
    {
        return isset($_SESSION['args_flash']);
    }
    
    /**
     * @param $key
     * @param $value
     */
    public function write ($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * @param $key
     */
    public function get ($key)
    {
        echo $this->read($key);
    }
    
    /**
     * @param $key
     * @return null
     */
    public function read ($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    
    /**
     * @param $key
     */
    public function delete ($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * @param $key1
     * @param $key2
     * @param $value
     */
    public function doubleWrite ($key1, $key2, $value)
    {
        $_SESSION[$key1][$key2] = $value;
    }
    
    /**
     * @param $key1
     * @param $key2
     */
    public function doubleGet ($key1, $key2)
    {
        echo $this->doubleRead($key1, $key2);
    }
    
    /**
     * @param $key1
     * @param $key2
     * @return null
     */
    public function doubleRead ($key1, $key2)
    {
        return isset($_SESSION[$key1][$key2]) ? $_SESSION[$key1][$key2] : null;
    }
    
    /**
     * @param $keyAccess
     * @param $key
     */
    public function doubleDelete ($keyAccess, $key)
    {
        if (isset($_SESSION[$keyAccess][$key])) {
            unset($_SESSION[$keyAccess][$key]);
        }
    }
}