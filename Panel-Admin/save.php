<?php
include '../includes/User.php';

if ( !empty( $_POST ) ) {
	$data     = array();
	$id = intval( $_POST['id'] );
	$old_data = $bdd->query( 'SELECT last_name, first_name, username, email, img_user_profile, status FROM users WHERE id_user = :id', [
		':id' => $id,
	] )->fetch( PDO::FETCH_ASSOC );

	foreach ( $_POST as $key => $value ) {
		if ( $key != 'id' ) {
			$data[ $key ] = $value;
		}
	}

	foreach ( $data as $key => $value ) {
		switch ( $key ) {
			case 'last_name':
				if ( $old_data['last_name'] != $value && ! empty( trim( $value ) ) ) {
					$bdd->query( 'UPDATE users SET last_name = :value WHERE id_user = :id', [
						':id'    => $id,
						':value' => $value,
					] );
				}
				break;
			case 'first_name':
				if ( $old_data['first_name'] != $value && ! empty( trim( $value ) ) ) {
					$bdd->query( 'UPDATE users SET first_name = :value WHERE id_user = :id', [
						':id'    => $id,
						':value' => $value,
					] );
				}
				break;
			case 'username':
				if ( $old_data['username'] != $value && ! empty( trim( $value ) ) ) {
					$bdd->query( 'UPDATE users SET username = :value WHERE id_user = :id', [
						':id'    => $id,
						':value' => $value,
					] );
				}
				break;
			case 'email':
				if ( $old_data['email'] != $value && ! empty( trim( $value ) ) ) {
					$re = '/(.*)@(.{3,7}).(com|fr)/';
					if ( preg_match( $re, $value) ) {
						$bdd->query( 'UPDATE users SET email = :value WHERE id_user = :id', [
							':id'    => $id,
							':value' => $value,
						] );
					} else {
						$args = array(
							'title' => 'Une erreur est survenue !',
							'text' => 'L\'email n\'est pas valide !',
							'icon' => 'error',
						);
						$session->setArgsFlash($args);
					}
				}
				break;
			case 'img_user_profile':
				if ( $old_data['img_user_profile'] != $value ) {
					if ( empty( trim( $value ) ) ) {
						$value = null;
					}
					$bdd->query( 'UPDATE users SET img_user_profile = :value WHERE id_user = :id', [
						':id'    => $id,
						':value' => $value,
					] );
				}
				break;
			case 'status':
				if ( $old_data['status'] != $value && ! empty( trim( $value ) ) ) {
					$bdd->query( 'UPDATE users SET status = :value WHERE id_user = :id', [
						':id'    => $id,
						':value' => $value,
					] );
				}
				break;
		}
		echo 'ok';
	}

}
