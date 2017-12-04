<?php
include_once  "includes\init.php";
include_once  "includes\Session.php";

if (!empty($_POST)) {
    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        $verif = $bdd->query('SELECT password from users WHERE pseudonym = :name OR  email = :name', [':name' => htmlspecialchars($_POST['name'])])->fetch();
        if (!empty($verif)) {
            if (password_verify(htmlspecialchars($_POST['password']), $verif['password'])) {

                $user = $bdd->query('SELECT * from users WHERE (pseudonym = :name OR email = :name ) AND password = :password',
                    [
                        ':name' => htmlspecialchars($_POST['name']),
                        ':password' => $verif['password'],
                    ])->fetch();
                
                if (!empty($user)) {
                    $session->connnect($user, $bdd);
                } else {
                    $session->setFlash('error', 'Identifiants Incorrect !');
                }
            }
        } else {
            $session->setFlash('error', 'Identifiants Incorrect !');
        }
    } else {
        $session->setFlash('error', 'Formulaire incomplet ou vide !');
    }
}

?>

<?php include 'includes/header.php'; ?>
<div class="ui middle aligned center aligned grid custom-font">
    <div class="column">
        <h2 class="ui custom-color image header">
            <img class="image logo-pages" src="assets/icones/logo.png" />
            <div class="content">
                Connexion
            </div>
        </h2>
        <form class="ui large form" action="" method="POST">
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                       <i class="dfd-socicon-users custom-icon"></i><input class="custom-font" name="name" placeholder="Nom d'utilisateur ou adresse e-mail" type="text" />
                   </div>
               </div>
               <div class="field">
                <div class="ui left icon input">
                    <i class="dfd-socicon-padlock custom-icon"></i><input class="custom-font" name="password" placeholder="Mot de passe" type="password" />
                </div>
            </div>
            <div class="ui checkbox">
              <input type="checkbox" tabindex="0" class="hidden">
              <label>Rester connecté</label>
          </div>
          <div class="forgot_password">
              <a href="">Mot de passe oublié ?</a>
          </div>
          <input type="submit" value="Se connecter" class="ui fluid large blue submit button">
          <div class="ui message suggestion">
            Vous n'avez pas de compte ? <a href="signup.php">Inscription</a>
        </div>
    </div>
    <div class="ui error message"></div>
</form>

</div>
</div>
<?php include 'includes/footer.php'; ?>
