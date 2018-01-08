<?php

class Session
{
    static $instance = null;
    
    public function __construct ()
    {
        session_start();
    }
    
    static function getInstance ()
    {
        if (!self::$instance) {
            self::$instance = new Session();
        }
        
        return self::$instance;
    }
    
    public function setFlash ($mode, $type, $args)
    {
        $_SESSION['flash'][$mode][$type] = $args;
    }
    
    public function getFlashes ($mode)
    {
        if ($this->hasFlashes($mode)) {
            $flash = $_SESSION['flash'][$mode];
            unset($_SESSION['flash'][$mode]);
            
            return $flash;
        }
        
        return false;
        
    }
    
    public function hasFlashes ($mode)
    {
        return isset($_SESSION['flash'][$mode]);
    }
    
    public function setArgsFlash ($args)
    {
        $_SESSION['args_flash'] = $args;
    }
    
    public function getArgsFlash ()
    {
        if ($this->hasArgsFlash()) {
            $args = $_SESSION['args_flash'];
            unset($_SESSION['args_flash']);
            
            return $args;
        }
        
        return null;
    }
    
    public function hasArgsFlash ()
    {
        return isset($_SESSION['args_flash']);
    }
    
    public function write ($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public function get ($key)
    {
        echo $this->read($key);
    }
    
    public function read ($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    
    public function delete ($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public function doubleWrite ($key1, $key2, $value)
    {
        $_SESSION[$key1][$key2] = $value;
    }
    
    public function doubleGet ($key1, $key2)
    {
        echo $this->doubleRead($key1, $key2);
    }
    
    public function doubleRead ($key1, $key2)
    {
        return isset($_SESSION[$key1][$key2]) ? $_SESSION[$key1][$key2] : null;
    }
    
    public function doubleDelete ($keyAccess, $key)
    {
        if (isset($_SESSION[$keyAccess][$key])) {
            unset($_SESSION[$keyAccess][$key]);
        }
    }
}

$session = Session::getInstance();