<?php

namespace techdeals;


/**
 * Class User
 * @package techdeals
 */
class User
{
    
    /**
     * @var null
     */
    static $user = null;
    /**
     * @var
     */
    public $bdd;
    /**
     * @var
     */
    private $session;
    /**
     * @var Validator
     */
    private $validator;
    
    /**
     * User constructor.
     * @param $bdd
     * @param $session
     */
    public function __construct ($bdd, $session)
    {
        
        $this->bdd = $bdd;
        $this->session = $session;
        $this->validator = new Validator($this->session);
        
    }
    
    /**
     * @return null|User
     */
    static function getInstance ()
    {
        if (!self::$user) {
            self::$user = new User(Database::getDatabase(), Session::getInstance());
        }
        
        return self::$user;
    }
    
    
    /**
     *
     */
    public function signup ()
    {
        if (!empty($_POST)) {
            $this->validator->setData($_POST);
            if (!$this->validator->hasEmptyFields()) {
                
                if ($this->validator->isAlphaNum('last_name') && $this->validator->isAlphaNum('first_name') && $this->validator->isAlphaNum('username')) {
                    
                    if ($this->validator->isConfirmed('password')) {
                        
                        //$mail_exist = $this->bdd->query('SELECT email FROM users WHERE  email = :email', [':email' => htmlspecialchars($_POST['email'])])->fetch();
                        
                        if ($this->validator->isEmail('email')) {
                            if ($this->validator->isUnique('email', $this->bdd, 'users')) {
                                
                                $this->bdd->query('INSERT INTO users(last_name,first_name,username, password, email, created_at) VALUES (:last_name,:first_name,:username,:password,:email, CURRENT_TIME )',
                                    [
                                        ':last_name' => htmlspecialchars($_POST['last_name']),
                                        ':first_name' => htmlspecialchars($_POST['first_name']),
                                        ':username' => htmlspecialchars($_POST['username']),
                                        ':password' => password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT),
                                        ':email' => htmlspecialchars($_POST['email']),
                                    ]);
                                $user = $this->bdd->query('SELECT * FROM users WHERE email = :email ',
                                    [
                                        ':email' => htmlspecialchars($_POST['email']),
                                    ])->fetch(\PDO::FETCH_ASSOC);
                                // add true parameter to mkdir recursively
                                mkdir("./users/user-" . $user['id_user']);
                                mkdir("./users/user-" . $user['id_user'] . "/data");
                                mkdir("./users/user-" . $user['id_user'] . "/settings");
                                $this->connect($user);
                            } else {
                                /*
                                $args = array(
                                    'title' => 'Erreur !',
                                    'text' => 'Cet email est déjà utilisé !',
                                    'icon' => 'error',
                                );
                                $this->session->setFlash('sweet_alert', 'error', $args);
                                */
                                $this->validator->showErrors();
                            }
                        } else {
                            $this->validator->showErrors();
                        }
                    } else {
                        /*
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Mot de passe invalide !',
                            'icon' => 'error',
                        );
                        $this->session->setFlash('sweet_alert', 'error', $args);
                        */
                        $this->validator->showErrors();
                    }
                } else {
                    /*
                    $args = array(
                        'title' => 'Erreur !',
                        'text' => 'Mot de passe invalide !',
                        'icon' => 'error',
                    );

                    $this->session->setFlash('default', 'error', $args);
                    */
                    $this->validator->showErrors();
                }
            } else {
                /*
                $args = array(
                    'title' => 'Erreur !',
                    'text' => 'Champ invalide !',
                    'icon' => 'error',
                );
                $this->session->setFlash('sweet_alert', 'error', $args);
                */
                $this->validator->showErrors();
            }
        }
    }
    
    /**
     * @param $user_info
     */
    public function connect ($user_info)
    {
        $this->session->write('connected', $user_info);
        $this->bdd->query('UPDATE users SET last_connection = CURRENT_TIME WHERE id_user=:id', [':id' => $this->session->doubleRead('connected', 'id_user')]);
        // change to header("Location:/index.php"); if necessary
        setcookie('status_user', $this->session->doubleRead('connected', 'status'), time() + 3600, '/panel-admin/');
        header("Location: /");
    }
    
    /**
     *
     */
    public function login ()
    {
        if (!empty($_POST)) {
            $this->validator->setData($_POST);
            if (!$this->validator->hasEmptyFields()) {
                $verif = $this->bdd->query('SELECT password from users WHERE username = :name OR  email = :name', [':name' => htmlspecialchars($_POST['name'])])->fetch();
                if (!empty($verif)) {
                    if (password_verify(htmlspecialchars($_POST['password']), $verif['password'])) {
                        
                        $user = $this->bdd->query('SELECT * from users WHERE (username = :name OR email = :name ) AND password = :password',
                            [
                                ':name' => htmlspecialchars($_POST['name']),
                                ':password' => $verif['password'],
                            ])->fetch(\PDO::FETCH_ASSOC);
                        
                        if (!empty($user)) {
                            $this->connect($user);
                        } else {
                            /*
                            $args = array(
                                'title' => 'Erreur !',
                                'text' => 'N'existe pas dans la base de donnée !',
                                'icon' => 'error',
                            );
                            $this->session->setFlash('sweet_alert', 'error', $args);
                            */
                            $this->validator->showErrors();
                            $this->session->setFlash('default', 'danger', 'N\'existe pas dans la base de donnée !');
                        }
                    } else {
                        /*
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Identifiants Incorrect !',
                            'icon' => 'error',
                        );
                        $this->session->setFlash('sweet_alert', 'error', $args);
                        */
                        $this->validator->showErrors();
                        $this->session->setFlash('default', 'danger', 'Indentifiants Incorrect !');
                    }
                } else {
                    
                    $args = array(
                        'title' => 'Erreur !',
                        'text' => 'Identifiants Incorrect !',
                        'icon' => 'error',
                    );
                    $this->session->setFlash('sweet_alert', 'error', $args);
                    
                    $this->validator->showErrors();
                    $this->session->setFlash('default', 'danger', 'Indentifiants Incorrect !');
                }
            } else {
                /*
                $args = array(
                    'title' => 'Erreur !',
                    'text' => 'Formulaire incomplet ou vide !',
                    'icon' => 'error',
                );
                $this->session->setFlash('sweet_alert', 'error', $args);
                */
                $this->validator->showErrors();
            }
        }
    }
    
    /**
     *
     */
    public function logout ()
    {
        $this->session->delete('connected');
        $args = array(
            'title' => 'Information !',
            'text' => 'Vous avez bien été déconnecté !',
            'icon' => 'info',
        );
        $this->session->setArgsFlash($args);
        header("Location: /");
    }
    
    /**
     *
     */
    public function actionUser ()
    {
        if (!empty($_GET)) {
            if (isset($_GET['id']) && isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 1:
                        //header("Location: users.php");
                        $args = array(
                            'title' => 'TITRE',
                            'text' => 'Vers la page de modification',
                            'icon' => 'success',
                            'timer' => 3000,
                        );
                        $this->session->setFlash('sweet_alert', 'success', $args);
                        break;
                    case 2:
                        //header("Location: users.php");
                        if (!isset($_GET['confirm'])) {
                            $args = array(
                                'title' => 'Réparer ?',
                                'text' => 'Les fichiers contenus dans les dossiers de l\'utilisateur seront supprimés !',
                                'icon' => 'warning',
                                'buttons' => array(
                                    'cancel' => 'Annuler',
                                    'confirm' => 'Continuer',
                                ),
                                'dangerMode' => true,
                            );
                            $this->session->setFlash('sweet_alert', 'warning', $args);
                        } else {
                            if (!file_exists("../users/user-" . $_GET['id'])) {
                                mkdir("../users/user-" . $_GET['id']);
                                mkdir("../users/user-" . $_GET['id'] . "/data");
                                mkdir("../users/user-" . $_GET['id'] . "/settings");
                                $args = array(
                                    'title' => 'Succès !',
                                    'text' => 'Les dossiers ont bien été créé !',
                                    'icon' => 'success',
                                );
                            } else {
                                $args = array(
                                    'title' => 'Erreur !',
                                    'text' => 'Les dossiers existe déjà !',
                                    'icon' => 'error',
                                );
                            }
                            $this->session->setArgsFlash($args);
                            header("Location: users.php");
                            exit();
                        }
                        break;
                    case 3:
                        
                        //header("Location: users.php");
                        if (!isset($_GET['confirm'])) {
                            $args = array(
                                'title' => 'Supprimer ?',
                                'text' => 'Cela supprimera l\'utilisateur ainsi que ces produits.',
                                'icon' => 'warning',
                                'buttons' => array(
                                    'cancel' => 'Annuler',
                                    'confirm' => 'Supprimer',
                                ),
                                'dangerMode' => true,
                            );
                            $this->session->setFlash('sweet_alert', 'warning', $args);
                        } else {
                            $this->bdd->query('DELETE FROM users WHERE id_user = :id', [':id' => $_GET['id']]);
                            if (file_exists("../users/user-" . $_GET['id'])) {
                                Util::rmDirR("../users/user-" . $_GET['id']);
                            }
                            header("Location: users.php");
                        }
                        break;
                    default:
                        //header("Location: users.php");
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Cet action n\'existe pas ! ',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $this->session->setFlash('sweet_alert', 'error', $args);
                        
                        break;
                }
            }
        }
    }
}

$fct_user = User::getInstance();