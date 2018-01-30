<?php

namespace techdeals;

class UserRestrict {
	
	private $statusUser;
	
	private $rules = array(
		'/index.php'  => 'ALL',
		'/includes/'  => 'ANY',
		'/payment.php' => 'LOGGED',
		'/dashboard/' => array(
			'PARTNER',
			'ADMIN',
			'SUPER_ADMIN',
		),
		'/dashboard/users.php' => array(
			'ADMIN',
			'SUPER_ADMIN',
		),
		'/dashboard/category.php' => array(
			'ADMIN',
			'SUPER_ADMIN',
		),
	);
	
	/**
	 * UserRestrict constructor.
	 *
	 * @param $statusUser
	 */
	public function __construct() {
		$this->statusUser = Session::getInstance()->doubleRead( 'connected', 'status' );
	}
	
	
	public function restrict() {
		$path = $_SERVER['PHP_SELF'];
		
		if( isset( $this->rules[$path] ) ) {
			$this->redirect( $path );
		} else {
			foreach( $this->rules as $pathRule => $rule ) {
				if( preg_match( '#' . $pathRule . '#', $path ) ) {
					$this->redirect( $pathRule );
				}
			}
		}
		
		return;
		
	}
	
	private function redirect( $path ) {
		
		if($this->rules[$path] == 'LOGGED') {
			$this->rules[$path] = array(
				'USER',
				'PARTNER',
				'ADMIN',
				'SUPER_ADMIN',
			);
		}
		
		if( is_array( $this->rules[$path] ) ) {
			if( !in_array( $this->statusUser, $this->rules[$path] ) ) {
				header( 'Location: /' );
			}
		} else {
			if( $this->rules[$path] == 'ANY' ) {
				header( 'Location: /' );
			}
			if( $this->rules[$path] == 'ALL' ) {
				return;
			}
		}
	}
	
	public function isAllow($pathToAllow) {
		if( is_array( $this->rules[$pathToAllow] ) ) {
			if( in_array( $this->statusUser, $this->rules[$pathToAllow] ) ) {
				return true;
			}
		} else {
			if( $this->rules[$pathToAllow] == 'ANY' ) {
				return false;
			}
			if( $this->rules[$pathToAllow] == 'ALL' ) {
				return true;
			}
		}
		
		return false;
	}
}
