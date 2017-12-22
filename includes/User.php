<?php

class User {

	public $bdd;
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

	public function signup() {
		if (!empty($_POST)) {
			if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_c'])) {

				if ($_POST['password'] == $_POST['password_c']) {

					$mail_exist = $this->bdd->query('SELECT email FROM users WHERE  email = :email', [':email' => htmlspecialchars($_POST['email'])])->fetch();

					if (empty($mail_exist)) {

						$this->bdd->query('INSERT INTO users(last_name,first_name,pseudonym, password, email, created_at) VALUES (:last_name,:first_name,:pseudonym,:password,:email, CURRENT_TIME )',
							[
								':last_name' => htmlspecialchars($_POST['last_name']),
								':first_name' => htmlspecialchars($_POST['first_name']),
								':pseudonym' => htmlspecialchars($_POST['pseudo']),
								':password' => password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT),
								':email' => htmlspecialchars($_POST['email']),
							]);
						$user = $this->bdd->query('SELECT * FROM users WHERE email = :email ',
							[
								':email' => htmlspecialchars($_POST['email']),
							])->fetch();
						// add true parameter to mkdir recursively
						mkdir("./users/user-".$user['id_user']);
						mkdir("./users/user-".$user['id_user']."/data");
						mkdir("./users/user-".$user['id_user']."/settings");
						$this->connect($user);
					} else {
						$this->session->setFlash('error', 'Cet email est déjà utilisé !');
					}
				} else {
					$this->session->setFlash('error', 'Mot de passe invalide');
				}

			} else {
				$this->session->setFlash('error', 'Formulaire incomplet !');
			}
		}
	}

	public function login() {
		if ( ! empty( $_POST ) ) {
			if ( ! empty( $_POST['name'] ) && ! empty( $_POST['password'] ) ) {
				$verif = $this->bdd->query( 'SELECT password from users WHERE pseudonym = :name OR  email = :name', [ ':name' => htmlspecialchars( $_POST['name'] ) ] )->fetch();
				if ( ! empty( $verif ) ) {
					if ( password_verify( htmlspecialchars( $_POST['password'] ), $verif['password'] ) ) {

						$user = $this->bdd->query( 'SELECT * from users WHERE (pseudonym = :name OR email = :name ) AND password = :password',
							[
								':name'     => htmlspecialchars( $_POST['name'] ),
								':password' => $verif['password'],
							] )->fetch();

						if ( ! empty( $user ) ) {
							$this->connect( $user );
						} else {
							$this->session->setFlash( 'error', 'Identifiants Incorrect !' );
						}
					}
				} else {
					$this->session->setFlash( 'error', 'Identifiants Incorrect !' );
				}
			} else {
				$this->session->setFlash( 'error', 'Formulaire incomplet ou vide !' );
			}
		}
	}

	public function connect( $user_info ) {
		$this->session->write( 'connected', $user_info );
		$this->bdd->query( 'UPDATE users SET last_connection = CURRENT_TIME WHERE id_user=:id', [ ':id' => $this->session->doubleRead( 'connected', 'id_user' ) ] );
		// change to header("Location:/index.php"); if necessary
		header( "Location:/index.php" );
	}

	public function logout() {
		$this->session->delete('connected');
		header("Location: /index.php");
		$this->session->setFlash( 'info', 'Vous avez bien été déconnecté !' );
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