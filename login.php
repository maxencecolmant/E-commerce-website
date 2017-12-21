<?php
include_once "includes/init.php";
include_once "includes/Session.php";
include_once "includes/Util.php";
include_once "includes/User.php";

if ( ! empty( $_POST ) ) {
	if ( ! empty( $_POST['name'] ) && ! empty( $_POST['password'] ) ) {
		$verif = $bdd->query( 'SELECT password from users WHERE pseudonym = :name OR  email = :name', [ ':name' => htmlspecialchars( $_POST['name'] ) ] )->fetch();
		if ( ! empty( $verif ) ) {
			if ( password_verify( htmlspecialchars( $_POST['password'] ), $verif['password'] ) ) {

				$user = $bdd->query( 'SELECT * from users WHERE (pseudonym = :name OR email = :name ) AND password = :password',
					[
						':name'     => htmlspecialchars( $_POST['name'] ),
						':password' => $verif['password'],
					] )->fetch();

				if ( ! empty( $user ) ) {
					$fct_user->connnect( $user, $bdd );
				} else {
					$session->setFlash( 'error', 'Identifiants Incorrect !' );
				}
			}
		} else {
			$session->setFlash( 'error', 'Identifiants Incorrect !' );
		}
	} else {
		$session->setFlash( 'error', 'Formulaire incomplet ou vide !' );
	}
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php' ?>
<div class="container form">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 form-custom">
            <h2 class="img-header">
                <img class="img-logo" src="assets/icones/logo.png"/>
                <div class="content">
                    Connexion
                </div>

            </h2>
            <form class="form" action="" method="POST">
                <div class="input-group">
                    <i class="socicon-users custom-icon"></i>
                    <input class="custom-font form-control" name="name" placeholder="Nom d'utilisateur ou E-mail"
                           type="text"/>
                </div>
                <div class="input-group">
                    <i class="socicon-padlock custom-icon"></i>
                    <input class="custom-font form-control" name="password" placeholder="Mot de passe" type="password"/>
                </div>
                <div class="user-actions">
                    <div class="checkbox checkbox-circle keep-connected">
                        <input id="check-box" type="checkbox">
                        <label for="check-box">
                            Rester connecté
                        </label>
                    </div>
                    <div class="forgot_password">
                        <a href="">Mot de passe oublié ?</a>
                    </div>
                </div>
                <div class="text-center submit-button">
                    <input type="submit" value="Se connecter" class="btn-custom bttn-jelly bttn-md">
                </div>
                <div class="message suggestion text-center">
                    Vous n'avez pas de compte ? <a href="signup.php">Inscription</a>
                </div>
                <div class="error message"></div>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
