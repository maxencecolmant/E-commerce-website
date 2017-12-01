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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no" name="viewport" />
    <meta content="Semantic-UI-Forest, collection of design, themes and templates for Semantic-UI." name="description" />
    <meta content="Semantic-UI, Theme, Design, Template" name="keywords" />
    <meta content="PPType" name="author" />
    <meta content="#ffffff" name="theme-color" />
    <title>Semantic-UI-Forest, collection of design, themes and templates for Semantic-UI.</title>
    <link href="assets/static/dist/semantic-ui/semantic.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/static/stylesheets/default.css" rel="stylesheet" type="text/css" />
    <link href="assets/static/stylesheets/pandoc-code-highlight.css" rel="stylesheet" type="text/css" />
    <script src="assets/static/dist/jquery/jquery.min.js"></script>
</head>
<body>
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui blue image header">
            <img class="image" src="assets/icones/full_logo.png" />
            <div class="content">
                S'inscrire
            </div>
        </h2>
        <form class="ui large form">
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i><input name="last_name" placeholder="Prènom" type="prenom" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i><input name="" placeholder="Name" type="nom" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i><input name="pseudo" placeholder="Pseudo" type="pseudo" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i><input name="email" placeholder="Email" type="text" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i><input name="password" placeholder="Password" type="password" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i><input name="password_c" placeholder="Confirm-Password" type="password" />
                    </div>
                </div>
                <div class="ui fluid large blue submit button">
                    Login
                </div>
            </div>
            <div class="ui error message"></div>
        </form>
        <div class="ui message">
            New to us?<a href="login.html#"> Sign Up</a>
        </div>
    </div>
</div>
<style type="text/css">
    body {
        background-color: #DADADA;
    }
    body > .grid {
        height: 100%;
    }
    .image {
        margin-top: -100px;
    }
    .column {
        max-width: 450px;
    }
</style>
<script>
    $(document)
        .ready(function() {
            $('.ui.form')
                .form({
                    fields: {
                        email: {
                            identifier  : 'email',
                            rules: [
                                {
                                    type   : 'empty',
                                    prompt : 'Please enter your e-mail'
                                },
                                {
                                    type   : 'email',
                                    prompt : 'Please enter a valid e-mail'
                                }
                            ]
                        },
                        password: {
                            identifier  : 'password',
                            rules: [
                                {
                                    type   : 'empty',
                                    prompt : 'Please enter your password'
                                },
                                {
                                    type   : 'length[6]',
                                    prompt : 'Your password must be at least 6 characters'
                                }
                            ]
                        }
                    }
                })
            ;
        })
    ;
</script>
</body>
</html>















