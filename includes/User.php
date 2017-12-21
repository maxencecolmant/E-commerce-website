<?php

class User {

	private $bdd;
	private $session;
	static $user = null;

	static function getInstance() {
		if ( ! self::$user ) {
			self::$user = new User( Database::getDatabase(), Session::getInstance() );
		}

		return self::$user;
	}

	public function __construct( $bdd, $session ) {

		$this->bdd     = $bdd;
		$this->session = $session;

	}

	public function connnect( $user_info ) {
		$this->session->write( 'connected', $user_info );
		$this->bdd->query( 'UPDATE users SET last_connection = CURRENT_TIME WHERE id_user=:id', [ ':id' => $this->doubleRead( 'connected', 'id_user' ) ] );
		// change to header("Location:/index.php"); if necessary
		header( "Location:/index.php" );
	}

	public function getUsers() {
		$users = $this->bdd->query( 'SELECT `id_user`, `last_name`, `first_name`, `pseudonym`, `email`, `img_user_profile`, `created_at`, `last_connection`, `status` FROM `users`' )->fetchAll();

		foreach ( $users as list( $id_user, $last_name, $first_name, $pseudonym, $email, $img_usr_profile, $created_at, $last_connection, $status ) ) {
			echo '<tr>
                            <td>' . $id_user . '</td>
                            <td>' . $last_name . '</td>
                            <td>' . $first_name . '</td>
                            <td>' . $pseudonym . '</td>
                            <td>' . $email . '</td>
                            <td>' . $img_usr_profile . '</td>
                            <td>' . $created_at . '</td>
                            <td>' . $last_connection . '</td>
                            <td>' . $status . '</td>
                            <td>
                            <a class="btn-primary" href="?id=' . $id_user . '&action=1" title="Modifier"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></a>
                            <a class="btn-warning" href="?id=' . $id_user . '&action=2" title="Réparer"><i class="fa fa-fw fa-wrench" aria-hidden="true"></i></a>
                            <a class="btn-danger" href="?id=' . $id_user . '&action=3" title="Supprimer"><i class="fa fa-fw fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>';
		}
	}

	public function actionUser() {
		if ( ! empty( $_GET ) ) {
			if ( isset( $_GET['id'] ) && isset( $_GET['action'] ) ) {
				switch ( $_GET['action'] ) {
					case 1:
						//header("Location: users.php");
						$this->session->setFlash('info', 'Vers la page de modification');
						break;
					case 2:
						//header("Location: users.php");
						$this->session->setFlash('info', 'FIx');
						break;
					case 3:
						//header("Location: users.php");
						$this->session->setFlash('info', 'Suppression');
						break;
					default:
						//header("Location: users.php");
						$this->session->setFlash('error', 'Une erreur est survenue !');
						break;
				}
			}
		}
	}
}

$fct_user = User::getInstance();