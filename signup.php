<?php
include_once "includes/Session.php";
include_once "includes/init.php";


if (!empty($_POST)) {
    if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_c'])) {

        if ($_POST['password'] == $_POST['password_c']) {

            $mail_exist = $bdd->query('SELECT email FROM users WHERE  email = :email', [':email' => htmlspecialchars($_POST['email'])])->fetch();
            
            if (empty($mail_exist)) {

                $bdd->query('INSERT INTO users(last_name,first_name,pseudonym, password, email, created_at) VALUES (:last_name,:first_name,:pseudonym,:password,:email, CURRENT_TIME )',
                    [
                        ':last_name' => htmlspecialchars($_POST['last_name']),
                        ':first_name' => htmlspecialchars($_POST['first_name']),
                        ':pseudonym' => htmlspecialchars($_POST['pseudo']),
                        ':password' => password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT),
                        ':email' => htmlspecialchars($_POST['email']),
                    ]);
                $user = $bdd->query('SELECT * FROM users WHERE email = :email ',
                    [
                        ':email' => htmlspecialchars($_POST['email']),
                    ])->fetch();
		// add true parameter to mkdir recursively
                mkdir("./users/user-".$user['id_user']);
                mkdir("./users/user-".$user['id_user']."/data");
                mkdir("./users/user-".$user['id_user']."/settings");
                $session->connnect($user, $bdd);
            } else {
                $session->setFlash('error', 'Cet email est déjà utilisé !');
            }
        } else {
            $session->setFlash('error', 'Mot de passe invalide');
        }
        
    } else {
        $session->setFlash('error', 'Formulaire incomplet !');
    }
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php' ?>

<div class="container form">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 form-custom">
      <h2 class="img-header">
        <img class="img-logo" src="assets/icones/logo.png" />
        <div class="content">
          Inscription
      </div>
  </h2>
  <form action="" method="POST">
    <div class="row">
        <div class="col-lg-6">
            <div class="input-group">
                <i class="socicon-users custom-icon"></i>
                <input class="custom-font form-control" name="first_name" placeholder="Nom" type="nom"/>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="input-group">
                <i class="socicon-users custom-icon"></i>
                <input class="custom-font form-control" name="last_name" placeholder="Prénom" type="prenom" />
            </div>
        </div>
    </div>
    <div class="input-group">
     <i class="socicon-users custom-icon"></i>
     <input class="custom-font form-control" name="pseudo" placeholder="Nom d'utilisateur" type="pseudo" />
 </div>

 <div class="input-group">
    <i class="socicon-envelope custom-icon"></i>
    <input class="custom-font form-control" name="email" placeholder="Email" type="text" />
</div>
<div class="input-group">
 <i class="socicon-padlock custom-icon"></i>
 <input class="custom-font form-control" name="password" placeholder="Mot de passe" type="password" />
</div>

<div class="input-group">
    <i class="socicon-check2 custom-icon"></i>
    <input class="custom-font form-control" name="password_c" placeholder="Confirmation" type="password" />
</div>
<small class="message-user">
    En cliquant sur S'inscrire, vous acceptez les  <a href="">Conditions d'utilisation</a> et <a href="">la Politique de confidentialité</a> de TechDeals
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


