<?php include 'includes/header.php'; ?>
<?php $user->login(); ?>
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
            <form id="mainForm" class="form" action="" method="POST" name="loginForm">
                <div id="forName" class="input-group">
                    <i class="socicon-users custom-icon"></i>
                    <input class="custom-font form-control" name="name" placeholder="Nom d'utilisateur ou E-mail"
                           type="text"/>
                           <label id="name-error" class="error" for="name"></label>
                </div>
                <div id="forPassword" class="input-group">
                    <i class="socicon-padlock custom-icon"></i>
                    <input class="custom-font form-control" name="password" placeholder="Mot de passe" type="password"/>
                    <label id="password-error" class="error" for="password"></label>
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
