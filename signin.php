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