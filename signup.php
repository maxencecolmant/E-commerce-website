<?php
include_once "includes/Session.php";
include_once "includes/init.php";
include_once "includes/Util.php";
include_once "includes/User.php";

$fct_user->signup();
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php' ?>

<div class="container form">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 form-custom">
            <h2 class="img-header">
                <img class="img-logo" src="assets/icones/logo.png"/>
                <div class="content">
                    Inscription
                </div>
            </h2>
            <form action="" method="POST">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <i class="socicon-users custom-icon"></i>
                            <input class="custom-font form-control" name="first_name" placeholder="Nom" type="text"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <i class="socicon-users custom-icon"></i>
                            <input class="custom-font form-control" name="last_name" placeholder="Prénom" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <i class="socicon-users custom-icon"></i>
                    <input class="custom-font form-control" name="pseudo" placeholder="Nom d'utilisateur" type="text"/>
                </div>

                <div class="input-group">
                    <i class="socicon-envelope custom-icon"></i>
                    <input class="custom-font form-control" name="email" placeholder="Email" type="email"/>
                </div>
                <div class="input-group">
                    <i class="socicon-padlock custom-icon"></i>
                    <input class="custom-font form-control" name="password" placeholder="Mot de passe" type="password"/>
                </div>

                <div class="input-group">
                    <i class="socicon-check2 custom-icon"></i>
                    <input class="custom-font form-control" name="password_c" placeholder="Confirmation"
                           type="password"/>
                </div>
                <small class="message-user">
                    En cliquant sur S'inscrire, vous acceptez les <a href="">Conditions d'utilisation</a> et <a href="">la
                        Politique de confidentialité</a> de TechDeals
                </small>
                <div class="text-center submit-button">
                    <input type="submit" value="S'inscrire" class="btn-custom bttn-jelly bttn-md">
                </div>
                <div class="message suggestion text-center">
                    Vous avez déjà un compte ? <a href="login.php">Connexion</a>
                </div>
                <div class="error message"></div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>


