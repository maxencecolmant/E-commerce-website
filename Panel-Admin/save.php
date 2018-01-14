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
	$id = isset( $_POST['id'] ) ? intval( htmlspecialchars( $_POST['id'] ) ) : null;
	unset( $_POST['id'] );
	$table = substr( str_replace( '/panel-admin/', '', htmlspecialchars( $_POST['origin'] ) ), 0, - 4 );
	$table = $table == 'category' ? $table . '_' : $table;
	unset( $_POST['origin'] );
	$type = isset( $_POST['type'] ) ? htmlspecialchars( $_POST['type'] ) : null;
	unset( $_POST['type'] );
	$validator   = new PHP\Validator( $session, $_POST );
	$table_id    = substr( $table, 0, - 1 );
	$col_id      = 'id_' . $table_id;
	$cols        = null;
	$cols_alias  = null;
	$cols_values = array();

	foreach ( $_POST as $col => $value ) {
		$cols       .= $col . ', ';
		$cols_alias .= $col != 'published_at_' . $table_id ? ':' . $col . ', ' : '';
		if ( $col != 'published_at_' . $table_id ) {
			$cols_values[ ':' . $col ] = htmlspecialchars( $value );
		}
	}

	$cols = substr( $cols, 0, - 2 );

	switch ( $type ) {

		case 'UPDATE':
			if ( $id == null ) {
				echo 'Invalid ID';
				break;
			}
			if ( $cols != null ) {
				$old_data = $bdd->query( 'SELECT ' . $cols . ' FROM ' . $table . ' WHERE ' . $col_id . ' = :id', [
					':id' => intval( $id ),
				] )->fetch( \PDO::FETCH_ASSOC );
			}

			foreach ( $_POST as $col => $value ) {
				$value = htmlspecialchars( $value );
				switch ( $col ) {
					case 'email':
						if ( $old_data[ $col ] != $value && ! empty( trim( $value ) ) ) {
							if ( $validator->isEmail( $col ) ) {
								$bdd->query( 'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
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
						if ( $old_data[ $col ] != $value ) {
							if ( empty( trim( $value ) ) ) {
								$value = null;
							}
							$bdd->query( 'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
								':id'    => $id,
								':value' => $value,
							] );
						}
						break;
					case 'id_parent_cat':
						if ( $old_data[ $col ] != $value ) {
							if ( $validator->isEmpty( $col ) ) {
								$value = null;
							} elseif ( $validator->isNumber( $col ) ) {
								if ( $validator->isValidID( $col, $table, $col_id ) ) {
									$value = intval( $value );
									if ( $value === 0 ) {
										$value = null;
									}
								} else {
									$value = null;
									$args  = array(
										'title' => 'Erreur !',
										'text'  => 'ID_PARENT doit être un ID existant !',
										'icon'  => 'error',
										'timer' => 3000,
									);
									$session->setArgsFlash( $args );
									break;
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
								break;
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
								$args = array(
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
			$bdd->query( 'UPDATE ' . $table . ' SET last_modification_' . $table_id . ' = CURRENT_TIME WHERE ' . $col_id . ' = :id', [
				':id' => $id,
			] );
			break;

		case 'INSERT':
			switch ( $table ) {
				case 'category_';
					if ( $validator->isEmpty( 'id_parent_cat' ) ) {
						$cols_values[':id_parent_cat'] = null;
					} elseif ( $validator->isNumber( 'id_parent_cat' ) ) {
						if ( $validator->isValidID( 'id_parent_cat', $table, $col_id ) ) {
							$cols_values[':id_parent_cat'] = intval( $cols_values[':id_parent_cat'] );
						} else {
							$cols_values[':id_parent_cat'] = null;
							$args                          = array(
								'title' => 'Erreur !',
								'text'  => 'ID Parent doit être un ID existant !',
								'icon'  => 'error',
								'timer' => 3000,
							);
							$session->setArgsFlash( $args );
							break;
						}
					} else {
						$args = array(
							'title' => 'Erreur !',
							'text'  => 'ID Parent doit être un nombre !',
							'icon'  => 'error',
							'timer' => 3000,
						);
						$session->setArgsFlash( $args );
						break;
					}
					if ( $validator->isAlphaNum( 'name_category' ) && ! $validator->isEmpty( 'name_category' ) ) {
						$bdd->query( 'INSERT INTO ' . $table . ' (' . $cols . ') VALUES (' . $cols_alias . ' CURRENT_TIME)', $cols_values );
						$args = array(
							'title' => 'Bravo !',
							'text'  => 'Votre catégorie a bien été ajouté !',
							'icon'  => 'success',
							'timer' => 3000,
						);
						$session->setArgsFlash( $args );
					} else {
						$args = array(
							'title' => 'Erreur !',
							'text'  => 'Un champ n\'est pas valide !',
							'icon'  => 'error',
							'timer' => 3000,
						);
						$session->setArgsFlash( $args );
					}
					break;
				default:
					echo 'Invalid Table';
					break;
			}
			break;
		default:
			echo 'Erreur Type !';
			break;
	}
	echo $validator->isValid() ? '' : json_encode( $validator->getErrors() );
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
