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
                Log-in to your account
            </div>
        </h2>
        <form class="ui large form">
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i><input name="email" placeholder="E-mail address" type="text" />
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i><input name="password" placeholder="Password" type="password" />
                    </div>
                </div>
                <input type="submit" value="Login" class="ui fluid large blue submit button">
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



