<?php

use techdeals as PHP;

require_once "../includes/Session.php";
require_once "../includes/init.php";
require_once "../includes/Validator.php";
require_once "../includes/User.php";
require_once "../includes/Util.php";
require_once "../includes/UserRestrict.php";

$restrict = new PHP\UserRestrict();

$restrict->restrict();

$session = PHP\Session::getInstance();
$bdd = PHP\Database::getDatabase();
$user = PHP\User::getInstance();
$util = PHP\Util::class;

if (!empty($_POST)) {
    $data = $_POST;
    $id = isset($_POST['id']) ? intval(htmlspecialchars($_POST['id'])) : null;
    unset($_POST['id']);
    $pass_c = isset($_POST['password_c']) ? htmlspecialchars($_POST['password_c']) : null;
    unset($_POST['password_c']);
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $_POST['password'] = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);
    }
    $table = substr(str_replace('/dashboard/', '', htmlspecialchars($_POST['origin'])), 0, -4);
    $table = $table == 'category' ? $table . '_' : $table;
    unset($_POST['origin']);
    $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : null;
    unset($_POST['type']);
    $validator = new PHP\Validator($session, $_POST);
    $table_id = substr($table, 0, -1);
    $col_id = 'id_' . $table_id;
    $cols = null;
    $cols_alias = null;
    $cols_values = array();
    
    if ($table == 'products') {
        if ($validator->isEmpty('id_user')) {
            $_POST['id_user'] = $session->doubleRead('connected', 'id_user');
        }
        if (!$validator->isEmpty('id_user')) {
            $req = $bdd->query(
                'SELECT id_user FROM users WHERE username = :value', [
                ':value' => $_POST['id_user'],
            ])->fetch(\PDO::FETCH_ASSOC);
            if (!empty($req)) {
                $_POST['id_user'] = $req['id_user'];
            }
        }
        if (!$validator->isEmpty('id_category')) {
            $req = $bdd->query(
                'SELECT id_category FROM category_ WHERE name_category = :value', [
                ':value' => $_POST['id_category'],
            ])->fetch(\PDO::FETCH_ASSOC);
            if (!empty($req)) {
                $_POST['id_category'] = $req['id_category'];
            }
        }
        
        $validator->dropError();
        
        $validator->setData($_POST);
    }
    
    if ($table == 'category_') {
        if (!$validator->isNumber('id_parent_cat')) {
            $req = $bdd->query(
                'SELECT id_category FROM category_ WHERE name_category = :value', [
                ':value' => $_POST['id_parent_cat'],
            ])->fetch(\PDO::FETCH_ASSOC);
            if (!empty($req)) {
                $_POST['id_parent_cat'] = $req['id_category'];
            }
        }
        
        $validator->dropError();
        
        $validator->setData($_POST);
    }
    
    foreach ($_POST as $col => $value) {
        $cols .= $col . ', ';
        $cols_alias .= $col != 'published_at_' . $table_id ? ':' . $col . ', ' : '';
        if ($col != 'published_at_' . $table_id) {
            $cols_values[':' . $col] = htmlspecialchars($value);
        }
    }
    
    $cols = substr($cols, 0, -2);
    $cols_alias = substr($cols_alias, 0, -2);
    
    switch ($type) {
        
        case 'UPDATE':
            
            if ($id == null) {
                echo 'Invalid ID';
                break;
            }
            if ($cols != null) {
                $old_data = $bdd->query(
                    'SELECT ' . $cols . ' FROM ' . $table . ' WHERE ' . $col_id . ' = :id', [
                    ':id' => intval($id),
                ])->fetch(\PDO::FETCH_ASSOC);
            }
            
            foreach ($_POST as $col => $value) {
                $value = htmlspecialchars($value);
                switch ($col) {
                    case 'email':
                        if ($old_data[$col] != $value && !empty(trim($value))) {
                            if ($validator->isEmail($col)) {
                                $bdd->query(
                                    'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                    ':id' => $id,
                                    ':value' => $value,
                                ]);
                            } else {
                                $args = array(
                                    'title' => 'Une erreur est survenue !',
                                    'text' => 'L\'email n\'est pas valide !',
                                    'icon' => 'error',
                                );
                                $session->setArgsFlash($args);
                            }
                        }
                        break;
                    case 'password':
                        if ($old_data[$col] != $value && !empty(trim($value))) {
                            if (password_verify($pass_c, $value)) {
                                $bdd->query(
                                    'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                    ':id' => $id,
                                    ':value' => $value,
                                ]);
                            } else {
                                $args = array(
                                    'title' => 'Une erreur est survenue !',
                                    'text' => 'Les mots de passe ne sont pas identiques !',
                                    'icon' => 'error',
                                );
                                $session->setArgsFlash($args);
                            }
                        }
                        break;
                    case 'rank_product':
                        if ($old_data[$col] != $value && !empty(trim($value))) {
                            if ($validator->isNumber($col)) {
                                if ($validator->isUnique($col, $bdd, 'products')) {
                                    $bdd->query(
                                        'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                        ':id' => $id,
                                        ':value' => $value,
                                    ]);
                                } else {
                                    $args = array(
                                        'title' => 'Une erreur est survenue !',
                                        'text' => 'Le rang doit être unique !',
                                        'icon' => 'error',
                                    );
                                    $session->setArgsFlash($args);
                                }
                            } else {
                                $args = array(
                                    'title' => 'Une erreur est survenue !',
                                    'text' => 'Le champ doit être un nombre !',
                                    'icon' => 'error',
                                );
                                $session->setArgsFlash($args);
                            }
                        }
                        break;
                    case 'price_product':
                    case 'quantity_product':
                        if ($old_data[$col] != $value && !empty(trim($value))) {
                            if ($validator->isNumber($col)) {
                                $bdd->query(
                                    'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                    ':id' => $id,
                                    ':value' => $value,
                                ]);
                            } else {
                                $args = array(
                                    'title' => 'Une erreur est survenue !',
                                    'text' => 'Le champ doit être un nombre !',
                                    'icon' => 'error',
                                );
                                $session->setArgsFlash($args);
                            }
                        }
                        break;
                    case 'img_user_profile':
                    case 'img_product':
                        if ($old_data[$col] != $value) {
                            if (empty(trim($value))) {
                                $value = null;
                            }
                            $bdd->query(
                                'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                ':id' => $id,
                                ':value' => $value,
                            ]);
                        }
                        break;
                    case 'id_category':
                        if ($old_data[$col] != $value) {
                            if ($validator->isEmpty($col)) {
                                $value = null;
                            } elseif ($validator->isNumber($col)) {
                                if ($validator->isValidID($col, 'category_', 'id_category')) {
                                    $value = intval($value);
                                    if ($value === 0) {
                                        $value = null;
                                    }
                                } else {
                                    $value = null;
                                    $args = array(
                                        'title' => 'Erreur !',
                                        'text' => 'ID_CATEGORY doit être un ID existant !',
                                        'icon' => 'error',
                                        'timer' => 3000,
                                    );
                                    $session->setArgsFlash($args);
                                    break;
                                }
                            } else {
                                $value = null;
                                $args = array(
                                    'title' => 'Erreur !',
                                    'text' => 'Invalid entry !',
                                    'icon' => 'error',
                                    'timer' => 3000,
                                );
                                $session->setArgsFlash($args);
                                break;
                            }
                            
                            $bdd->query(
                                'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                ':id' => $id,
                                ':value' => $value,
                            ]);
                        }
                        break;
                    case 'id_user':
                        if ($old_data[$col] != $value) {
                            if ($validator->isEmpty($col)) {
                                $value = null;
                            } elseif ($validator->isNumber($col)) {
                                if ($validator->isValidID($col, 'users', 'id_user')) {
                                    $value = intval($value);
                                    if ($value === 0) {
                                        $value = null;
                                    }
                                } else {
                                    $value = null;
                                    $args = array(
                                        'title' => 'Erreur !',
                                        'text' => 'ID_USER doit être un ID existant !',
                                        'icon' => 'error',
                                        'timer' => 3000,
                                    );
                                    $session->setArgsFlash($args);
                                    break;
                                }
                            } else {
                                $value = null;
                                $args = array(
                                    'title' => 'Erreur !',
                                    'text' => 'Invalid owner!',
                                    'icon' => 'error',
                                    'timer' => 3000,
                                );
                                $session->setArgsFlash($args);
                                break;
                            }
                            
                            $bdd->query(
                                'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                ':id' => $id,
                                ':value' => $value,
                            ]);
                        }
                        break;
                    case 'id_parent_cat':
                        if ($old_data[$col] != $value) {
                            if ($validator->isEmpty($col)) {
                                $value = null;
                            } elseif ($validator->isNumber($col)) {
                                if ($validator->isValidID($col, $table, $col_id)) {
                                    $value = intval($value);
                                    if ($value === 0) {
                                        $value = null;
                                    }
                                } else {
                                    $value = null;
                                    $args = array(
                                        'title' => 'Erreur !',
                                        'text' => 'ID_PARENT doit être un ID existant !',
                                        'icon' => 'error',
                                        'timer' => 3000,
                                    );
                                    $session->setArgsFlash($args);
                                    break;
                                }
                            } else {
                                $value = null;
                                $args = array(
                                    'title' => 'Erreur !',
                                    'text' => 'ID_PARENT doit être un nombre !',
                                    'icon' => 'error',
                                    'timer' => 3000,
                                );
                                $session->setArgsFlash($args);
                                break;
                            }
                            
                            $bdd->query(
                                'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                ':id' => $id,
                                ':value' => $value,
                            ]);
                        }
                        break;
                    case 'name_product':
                    case 'desc_product':
	                case 'specs_product':
                        if ($old_data[$col] != $value && !empty(trim($value))) {
                            $bdd->query(
                                'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                ':id' => $id,
                                ':value' => $value,
                            ]);
                        }
                        break;
                    default:
                        if ($old_data[$col] != $value && !empty(trim($value))) {
                            if ($validator->isAlphaNum($col)) {
                                $bdd->query(
                                    'UPDATE ' . $table . ' SET ' . $col . ' = :value WHERE ' . $col_id . ' = :id', [
                                    ':id' => $id,
                                    ':value' => $value,
                                ]);
                            } else {
                                $args = array(
                                    'title' => 'Erreur !',
                                    'text' => 'Un champ n\'est pas valide !',
                                    'icon' => 'error',
                                    'timer' => 3000,
                                );
                                $session->setArgsFlash($args);
                            }
                        }
                        break;
                }
            }
            $bdd->query(
                'UPDATE ' . $table . ' SET last_modification_' . $table_id . ' = CURRENT_TIME WHERE ' . $col_id . ' = :id', [
                ':id' => $id,
            ]);
            break;
        
        case 'INSERT':
            switch ($table) {
                case 'category_';
                    if ($validator->isEmpty('id_parent_cat')) {
                        $cols_values[':id_parent_cat'] = null;
                    } elseif ($validator->isNumber('id_parent_cat')) {
                        if ($validator->isValidID('id_parent_cat', $table, $col_id)) {
                            $cols_values[':id_parent_cat'] = intval($cols_values[':id_parent_cat']);
                        } else {
                            $cols_values[':id_parent_cat'] = null;
                            $args = array(
                                'title' => 'Erreur !',
                                'text' => 'ID Parent doit être un ID existant !',
                                'icon' => 'error',
                                'timer' => 3000,
                            );
                            $session->setArgsFlash($args);
                            break;
                        }
                    } else {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'ID Parent doit être un nombre !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    }
                    if ($validator->isAlphaNum('name_category') && !$validator->isEmpty('name_category')) {
                        $bdd->query('INSERT INTO ' . $table . ' (' . $cols . ') VALUES (' . $cols_alias . ')', $cols_values);
                        $args = array(
                            'title' => 'Bravo !',
                            'text' => 'Votre catégorie a bien été ajouté !',
                            'icon' => 'success',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                    } else {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Un champ n\'est pas valide !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                    }
                    break;
                case 'users':
                    if (!$validator->isAlphaNum('last_name') && !$validator->isAlphaNum('first_name') && !$validator->isAlphaNum('username')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Un champ n\'est pas valide !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isUnique('username', $bdd, $table)) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Username doit être unique !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isUnique('email', $bdd, $table)) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Email doit être unique !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isEmail('email')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'L\'email n\'est pas valide !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif ($validator->isEmpty('last_name')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'last_name est vide !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif ($validator->isEmpty('first_name')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'first_name est vide !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif ($validator->isEmpty('username')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Username est vide !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif ($validator->isEmpty('password')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Password ne peut pas être vide !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif ($validator->isEmpty('img_user_profile')) {
                        $cols_values[':img_user_profile'] = null;
                    }
                    $cols_values[':password'] = password_hash($cols_values[':password'], PASSWORD_BCRYPT);
                    $bdd->query('INSERT INTO ' . $table . ' (' . $cols . ') VALUES (' . $cols_alias . ')', $cols_values);
                    mkdir("./users/user-" . $cols_values[':id_user']);
                    mkdir("./users/user-" . $cols_values[':id_user'] . "/data");
                    mkdir("./users/user-" . $cols_values[':id_user'] . "/settings");
                    $args = array(
                        'title' => 'Bravo !',
                        'text' => 'Votre utilisateur a bien été ajouté !',
                        'icon' => 'success',
                        'timer' => 3000,
                    );
                    $session->setArgsFlash($args);
                    break;
                case 'products' :
                    if (!$validator->isNumber('price_product')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Le prix doit être un nombre !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isNumber('rank_product')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Le rang doit être un nombre !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isNumber('quantity_product')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'La quantité doit être un nombre !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isNumber('id_category')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'La catégorie doit être un nombre !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isValidID('id_category', 'category_', 'id_category')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'La catégorie n\'existe pas !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isNumber('id_user')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Le propriétaire doit être un nombre !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif (!$validator->isValidID('id_user', 'users', 'id_user')) {
                        $args = array(
                            'title' => 'Erreur !',
                            'text' => 'Le propriétaire n\'existe pas !',
                            'icon' => 'error',
                            'timer' => 3000,
                        );
                        $session->setArgsFlash($args);
                        break;
                    } elseif ($validator->isEmpty('img_product')) {
                        $cols_values[':img_product'] = null;
                    }
                    if ($validator->isEmpty('is_hidden')) {
                        unset($cols_values[':is_hidden']);
                        $cols_alias = str_replace(', :is_hidden', '', $cols_alias);
                        $cols = str_replace(', is_hidden', '', $cols);
                    }
                    
                    $bdd->query('INSERT INTO ' . $table . ' (' . $cols . ') VALUES (' . $cols_alias . ')', $cols_values);
                    $args = array(
                        'title' => 'Bravo !',
                        'text' => 'Votre produit a bien été ajouté !',
                        'icon' => 'success',
                        'timer' => 3000,
                    );
                    $session->setArgsFlash($args);
                    break;
                default:
                    echo 'Invalid Table';
                    echo $table;
                    echo json_encode($data);
                    break;
            }
            break;
        default:
            echo 'Erreur Type !';
            break;
    }
    echo $validator->isValid() ? '' : json_encode($validator->getErrors());
    echo 'Done';
} else {
    $args = array(
        'title' => 'Erreur !',
        'text' => 'Vous êtes perdu !',
        'icon' => 'error',
        'timer' => 3000,
    );
    
    $session->setArgsFlash($args);
    
    header("Location: /");
}
