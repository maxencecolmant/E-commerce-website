<?php
class Session
{
    static $instance = null;
    
    static function getInstance(){
        if(!self::$instance){
            self::$instance = new Session();
        }
        return self::$instance;
    }
    
    public function __construct(){
        session_start();
    }
    
    public function setFlash($key, $message){
        
        $_SESSION['flash'][$key][$message] = $message;
    }
    
    public function hasFlashes(){
        return isset($_SESSION['flash']);
    }
    
    public function hasError() {
        return isset($_SESSION['flash']['danger']);
    }
    
    public function getFlashes(){
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    
    public function write($key, $value){
        $_SESSION[$key] = $value;
    }
    
    public function doubleWrite($key1, $key2, $value){
        $_SESSION[$key1][$key2] = $value;
    }
    
    public function read($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    
    public function doubleRead($key1, $key2) {
        return isset($_SESSION[$key1][$key2]) ? $_SESSION[$key1][$key2] : null;
    }
    
    public function delete($key){
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public function doubleDelete($keyAccess, $key){
        if (isset($_SESSION[$keyAccess][$key])) {
            unset($_SESSION[$keyAccess][$key]);
        }
    }
    
}