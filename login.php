<?php
 include_once  "includes\init.php";
 include_once  "includes\Session.php";

if (!empty($_POST)) {
    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        $email = $bdd->query('SELECT password from users WHERE name = :name', [':name' => htmlspecialchars($_POST['name'])])->fetch();
        if (!empty($email)) {
            if (password_verify(htmlspecialchars($_POST['password']), $email['password'])) {
                
                $user = $bdd->query('SELECT * from users WHERE name = :name AND password = :password',
                    [
                        ':name' => htmlspecialchars($_POST['name']),
                        ':password' => $email['password'],
                    ])->fetch();
                
                if (!empty($user)) {
                    $session->connnect($user);
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


