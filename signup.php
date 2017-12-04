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
<div class="ui middle aligned center aligned grid custom-font">
    <div class="column">
        <h2 class="ui custom-color image header">
            <img class="image logo-pages" src="assets/icones/logo.png" />
            <div class="content">
                Inscription
            </div>
        </h2>
        <form class="ui large form" action="" method="POST">
            <div class="ui stacked segment">
                <div class="two fields">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="dfd-socicon-users custom-icon"></i><input class="custom-font" name="first_name" placeholder="Nom" type="nom" />
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="dfd-socicon-users custom-icon"></i><input class="custom-font" name="last_name" placeholder="Prénom" type="prenom" />
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="dfd-socicon-users custom-icon"></i><input class="custom-font" name="pseudo" placeholder="Nom d'utilisateur" type="pseudo" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="dfd-socicon-envelope custom-icon"></i><input class="custom-font" name="email" placeholder="Email" type="text" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="dfd-socicon-padlock custom-icon"></i><input class="custom-font" name="password" placeholder="Mot de passe" type="password" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="dfd-socicon-check2 custom-icon"></i><input class="custom-font" name="password_c" placeholder="Confirmation" type="password" />
                    </div>
                </div>
                <div class="ui checkbox">
                  <input type="checkbox" tabindex="0" class="hidden">
                  <label>J'ai lu et j'accepte les <a href=""> conditions générales de vente</a>.</label>
              </div>
              <input type="submit" value="S'inscrire" class="ui fluid large blue submit button">
              <div class="ui message suggestion">
                Vous avez déjà un compte ? <a href="login.php">Connexion</a>
            </div>
        </div>
        <div class="ui error message"></div>
    </form>
</div>
</div>

<?php include 'includes/footer.php';

?>
<script type="text/javascript">
    $('.ui.checkbox')
    .checkbox()
    ;
</script>




