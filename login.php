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
<div class="container form">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 form-custom">
      <h2 class="img-header">
        <img class="img-logo" src="assets/icones/logo.png" />
        <div class="content">
          Connexion
        </div>
      </h2>
      <form action="" method="POST">
        <div class="form-group">
         <i class="socicon-users custom-icon"></i><input class="custom-font" name="name" placeholder="Nom d'utilisateur ou adresse e-mail" type="text" />
       </div>
       <div class="form-group">
        <i class="socicon-padlock custom-icon"></i><input class="custom-font" name="password" placeholder="Mot de passe" type="password" />
      </div>
      <div class="form-group">
        <input type="checkbox">
        <label>Rester connecté</label>
      </div>
      <div class="forgot_password">
       <a href="">Mot de passe oublié ?</a>
     </div>
     <input type="submit" value="Se connecter" class="ui fluid large blue submit button">
     <div class="message suggestion">
       Vous n'avez pas de compte ? <a href="signup.php">Inscription</a>
     </div>
     <div class="error message"></div>
   </form>
 </div>
</div>
</div>
<?php include 'includes/footer.php'; ?>
