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

if ( ! empty( $_GET ) ) {
	if ( isset( $_GET['colToSet'] ) && isset( $_GET['value'] ) ) {
		$response = $bdd->query( 'SELECT ' . $_GET['colToGet'] . ' FROM ' . $_GET['table'] . ' WHERE ' . $_GET['colToSet'] . '=:value', [
			':value' => htmlspecialchars( $_GET['value'] ),
		] )->fetchAll( \PDO::FETCH_ASSOC );
		if ( $_GET['type'] == 'JSON' ) {
			echo json_encode( $response );

		} elseif ( $_GET['type'] == 'RAW' ) {
			echo $response[$_GET['colToGet']];
		}
	} else {
		$response = $bdd->query( 'SELECT ' . $_GET['colToGet'] . ' FROM ' . $_GET['table'] )->fetchAll( \PDO::FETCH_COLUMN );
		if ( $_GET['type'] == 'JSON' ) {
			echo json_encode( $response );

		} elseif ( $_GET['type'] == 'RAW' ) {
			var_dump( $response );
			foreach ( $response as $key => $ID ) {
				echo $ID;
			}
		}
	}

}