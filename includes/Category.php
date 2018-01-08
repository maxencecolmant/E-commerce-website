<?php

namespace techdeals;

class Category {

	static $category = null;
	public $bdd;
	private $session;
	private $validator;

	public function __construct ($bdd, $session)
	{

		$this->bdd = $bdd;
		$this->session = $session;
		$this->validator = new Validator($this->session);

	}

	static function getCategory ()
	{
		if (!self::$category) {
			self::$category = new User(Database::getDatabase(), Session::getInstance());
		}

		return self::$category;
	}

}