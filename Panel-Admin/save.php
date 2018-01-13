<?php

use techdeals as PHP;

require_once "../includes/Session.php";
require_once "../includes/init.php";
require_once "../includes/Validator.php";
require_once "../includes/User.php";
require_once "../includes/Util.php";

$session = PHP\Session::getInstance();
$bdd     = PHP\Database::getDatabase();
$user    = PHP\User::getInstance();
$util    = PHP\Util::class;

if ( ! empty( $_POST ) ) {
	$validator = new PHP\Validator( $session, $_POST );
	$data      = array();
	$id        = intval( htmlspecialchars( $_POST['id'] ) );
	unset( $_POST['id'] );
	$table = substr( str_replace( '/panel-admin/', '', htmlspecialchars( $_POST['origin'] ) ), 0, - 4 );
	$table = $table == 'category' ? $table . '_' : $table;
	unset( $_POST['origin'] );
	$table_id = substr( $table, 0, - 1 );
	$col_id   = 'id_' . $table_id;
	$cols     = null;

	foreach ( $_POST as $col => $value ) {
		$cols .= $col . ', ';
	}

	$cols = substr( $cols, 0, - 2 );

	if ( $cols != null ) {
		$old_data = $bdd->query( 'SELECT ' . $cols . ' FROM ' . $table . ' WHERE ' . $col_id . ' = :id', [
			':id' => intval( $id ),
		] )->fetch( \PDO::FETCH_ASSOC );
	}

	foreach ( $_POST as $col => $value ) {
		$value = htmlspecialchars($value);
		switch ( $col ) {
			case 'email':
				if ( $old_data[$col] != $value && ! empty( trim( $value ) ) ) {
					if ( $validator->isEmail( $col ) ) {
						$bdd->query( 'UPDATE ' . $table . ' SET email = :value WHERE ' . $col_id . ' = :id', [
							':id'    => $id,
							':value' => $value,
						] );
					} else {
						$args = array(
							'title' => 'Une erreur est survenue !',
							'text'  => 'L\'email n\'est pas valide !',
							'icon'  => 'error',
						);
						$session->setArgsFlash( $args );
					}
				}
				break;
			case 'img_user_profile':
				if ( $old_data[$col] != $value ) {
					if ( empty( trim( $value ) ) ) {
						$value = null;
					}
					$bdd->query( 'UPDATE ' . $table . ' SET img_user_profile = :value WHERE ' . $col_id . ' = :id', [
						':id'    => $id,
						':value' => $value,
					] );
				}
				break;
			case 'id_parent_cat':
				if ( $old_data[$col] != $value ) {
					if ( empty( trim( $value ) ) ) {
						$value = null;
					} else {
						if ( $validator->isNumber( $col ) ) {
							$value = intval( $value );
							if ( $value === 0 ) {
								$value = null;
							}
						} else {
							$value = null;
							$args  = array(
								'title' => 'Erreur !',
								'text'  => 'ID_PARENT doit être un nombre !',
								'icon'  => 'error',
								'timer' => 3000,
							);
							$session->setArgsFlash( $args );
						}
					}
					$bdd->query( 'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
						':id'    => $id,
						':value' => $value,
					] );
				}
				break;
			default:
				if ( $old_data[ $col ] != $value && ! empty( trim( $value ) ) ) {
					if ( $validator->isAlphaNum( $col ) ) {
						$bdd->query( 'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
							':id'    => $id,
							':value' => $value,
						] );
					} else {
						$args  = array(
							'title' => 'Erreur !',
							'text'  => 'Un champ n\'est pas valide !',
							'icon'  => 'error',
							'timer' => 3000,
						);
						$session->setArgsFlash( $args );
					}
				}
				break;
		}
	}
	echo $validator->isValid() ? '' : json_encode( $validator->getErrors() );
	$bdd->query( 'UPDATE ' . $table . ' SET last_modification_' . $table_id . ' = CURRENT_TIME WHERE ' . $col_id . ' = :id', [
		':id' => $id,
	] );
	echo 'Done';
} else {
	$args = array(
		'title' => 'Erreur !',
		'text'  => 'Vous êtes perdu !',
		'icon'  => 'error',
		'timer' => 3000,
	);

	$session->setArgsFlash( $args );

	header( "Location: /" );
}
