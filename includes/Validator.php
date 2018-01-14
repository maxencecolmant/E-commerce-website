<?php

namespace techdeals;

/**
 * Class Validator
 * @package techdeals
 */
class Validator {
	/**
	 * @var null
	 */
	private $data;
	/**
	 * @var
	 */
	private $session;
	/**
	 * @var array
	 */
	private $errors = [];
	/**
	 * @var array
	 */
	private $errors_msg = array(
		'not_exist'   => "Champ inexistant !",
		'not_alpha'   => "Ce champs n'est pas alphanumérique !",
		'not_unique'  => "Ce champ n'est pas unique !",
		'not_email'   => "Ce champ n'est pas un email !",
		'not_confirm' => "Ce champ n'est pas confirmé !",
		'not_fill'    => "Ce champ n'est pas rempli !",
		'not_number'  => "Ce champs n'est pas un nombre !",
		'not_valid'   => "Ce champs n\'est pas valide !",
	);

	/**
	 * Validator constructor.
	 *
	 * @param $session
	 * @param null $data
	 */
	public function __construct( $session, $data = null ) {
		$this->session = $session;
		$this->data    = $data;
	}

	/**
	 * @param $data
	 */
	public function setData( $data ) {
		$this->data = $data;
	}

	/**
	 * @param $field
	 * @param bool $errorMsg
	 *
	 * @return bool
	 */
	public function isAlphaNum( $field, $errorMsg = false ) {
		if ( ! preg_match( '/^[a-zA-Z0-9_ ]+$/', $this->getField( $field ) ) ) {
			$this->errors[ $field ] = $errorMsg ? $errorMsg : $this->errors_msg['not_alpha'];

			return false;
		}

		return true;
	}

	/**
	 * @param $field
	 *
	 * @return null
	 */
	private function getField( $field ) {
		if ( ! isset( $this->data[ $field ] ) ) {
			$this->errors[ $field ] = $this->errors_msg['not_exist'];

			return null;
		}

		return $this->data[ $field ];
	}

	/**
	 * @param $field
	 * @param $db
	 * @param $table
	 * @param bool $errorMsg
	 *
	 * @return bool
	 */
	public function isUnique( $field, $db, $table, $errorMsg = false ) {
		$record = $db->query( 'SELECT id_' . substr( $table, 0, - 1 ) . ' from ' . $table . ' WHERE ' . $field . ' = :value', [ ':value' => $this->getField( $field ) ] )->fetch();
		if ( $record ) {
			$this->errors[ $field ] = $errorMsg ? $errorMsg : $this->errors_msg['not_unique'];

			return false;
		}

		return true;
	}

	/**
	 * @param $field
	 * @param bool $errorMsg
	 *
	 * @return bool
	 */
	public function isEmail( $field, $errorMsg = false ) {
		if ( ! filter_var( $this->getField( $field ), FILTER_VALIDATE_EMAIL ) ) {
			$this->errors[ $field ] = $errorMsg ? $errorMsg : $this->errors_msg['not_email'];

			return false;
		}

		return true;
	}

	/**
	 * @param $field
	 * @param bool $errorMsg
	 *
	 * @return bool
	 */
	public function isConfirmed( $field, $errorMsg = false ) {
		if ( $this->getField( $field ) != $this->getField( $field . '_c' ) ) {
			$this->errors[ $field ] = $errorMsg ? $errorMsg : $this->errors_msg['not_confirm'];

			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function hasEmptyFields() {
		foreach ( $this->data as $field => $value ) {
			if ( $this->isEmpty( $field ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $field
	 * @param bool $errorMsg
	 *
	 * @return bool
	 */
	public function isEmpty( $field, $errorMsg = false ) {
		if ( empty( trim( $this->getField( $field ) ) ) ) {
			$this->errors[ $field ] = $errorMsg ? $errorMsg : $this->errors_msg['not_fill'];

			return true;
		}

		return false;
	}

	public function isNumber( $field, $errorMsg = false ) {

		if ( ! is_numeric( $this->getField( $field ) ) ) {
			$this->errors[ $field ] = $errorMsg ? $errorMsg : $this->errors_msg['not_number'];

			return false;
		}

		return true;
	}

	public function isValidID( $field, $table, $fieldID, $errorMsg = false ) {
		$validID = Database::getDatabase()->query( 'SELECT ' . $fieldID . ' FROM ' . $table )->fetchAll( \PDO::FETCH_COLUMN );

		foreach ( $validID as $key => $ID ) {
			if ( $this->getField( $field ) == $ID ) {
				return true;
			}
		}

		$this->errors[ $field ] = $errorMsg ? $errorMsg : $this->errors_msg['not_valid'];

		return false;

	}

	/**
	 * @return bool
	 */
	public function isValid() {
		return empty( $this->errors );
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 *
	 */
	public function showErrors() {
		foreach ( $this->errors as $error ) {
			$this->session->setFlash( 'default', 'danger', $error );
		}
	}
}