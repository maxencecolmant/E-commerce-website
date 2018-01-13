<?php

namespace techdeals;

/**
 * Class Category
 * @package techdeals
 */
class Category
{
    
    /**
     * @var null
     */
    static $category = null;
    /**
     * @var
     */
    public $bdd;
    /**
     * @var
     */
    private $session;
    /**
     * @var Validator
     */
    private $validator;
    
    /**
     * Category constructor.
     * @param $bdd
     * @param $session
     */
    public function __construct ($bdd, $session)
    {
        
        $this->bdd = $bdd;
        $this->session = $session;
        $this->validator = new Validator($this->session);
        
    }
    
    /**
     * @return null|User
     */
    static function getCategory ()
    {
        if (!self::$category) {
            self::$category = new User(Database::getDatabase(), Session::getInstance());
        }
        
        return self::$category;
    }
    
}