<?php

class Database
{
    static $instance_bdd = null;
    private $bdd;
    
    public function __construct ($login, $password, $database_name, $host = 'localhost')
    {
        try {
            $this->bdd = new PDO("mysql:dbname=$database_name;host=$host", $login, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }
    
    static function getDatabase ()
    {
        if (!self::$instance_bdd) {
            self::$instance_bdd = new Database('db_projet_php', 'password', 'techdeals_db', '81.57.206.30:3307');
        }
        
        return self::$instance_bdd;
        
    }
    
    public function lastInsertId ()
    {
        return $this->bdd->lastInsertId();
    }
    
    public function setAttribute ($attribut, $value)
    {
        $this->bdd->setAttribute($attribut, $value);
    }
    
    public function getUsers ()
    {
        $users = $this->query('SELECT `id_user`, `last_name`, `first_name`, `username`, `email`, `img_user_profile`, `created_at`, `last_connection`, `status` FROM `users`')->fetchAll();
        
        foreach ($users as list($id_user, $last_name, $first_name, $pseudonym, $email, $img_usr_profile, $created_at, $last_connection, $status)) {
            echo '<tr id="' . $id_user . '">
                            <td name="id_user">' . $id_user . '</td>
                            <td name="last_name" class="possible">' . $last_name . '</td>
                            <td name="first_name" class="possible">' . $first_name . '</td>
                            <td name="username" class="possible">' . $pseudonym . '</td>
                            <td name="email" class="possible">' . $email . '</td>
                            <td name="img_user_profile" class="possible">' . $img_usr_profile . '</td>
                            <td>' . $created_at . '</td>
                            <td>' . $last_connection . '</td>
                            <td name="status">' . $status . '</td>
                            <td>
                            <span id="' . $id_user . '">
                            <a id="modify-' . $id_user . '" class="modify btn-primary" href="" title="Modifier"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></a>
                            <a id="cancel-' . $id_user . '" class="cancelMod btn-danger" href="" title="Annuler" hidden="true"><i class="fa fa-fw fa-close" aria-hidden="true"></i></a>
                            </span>
                            <a id="repare" class="btn-warning" href="?id=' . $id_user . '&action=2" title="Réparer"><i class="fa fa-fw fa-wrench" aria-hidden="true"></i></a>
                            <a id="delete" class="btn-danger" href="?id=' . $id_user . '&action=3" title="Supprimer"><i class="fa fa-fw fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>';
        }
    }
    
    /**
     * @param $query
     * @param bool|array $params
     *
     * @return PDOStatement
     */
    public function query ($query, $params = false)
    {
        if ($params) {
            $req = $this->bdd->prepare($query);
            $req->execute($params) or die (print_r($req->errorInfo()));
        } else {
            $req = $this->bdd->query($query);
        }
        
        return $req;
    }
    
    public function getProducts ()
    {
        $products = $this->query('SELECT `id_product`, `name_product`, `price_product`, `desc_product`, `rank_product`, `category_product`, `quantity_product`, `published_at_product`, `last_modification_product`, `is_hidden` FROM `products')->fetchAll();
        
        foreach ($products as list($id_product, $name_product, $price_product, $desc_product, $rank_product, $category_product, $quantity_product, $published_at_product, $last_mod_product, $is_hidden)) {
            echo '<tr>
                            <td>' . $id_product . '</td>
                            <td>' . $name_product . '</td>
                            <td>' . $price_product . '</td>
                            <td>' . $desc_product . '</td>
                            <td>' . $rank_product . '</td>
                            <td>' . $category_product . '</td>
                            <td>' . $quantity_product . '</td>
                            <td>' . $published_at_product . '</td>
                            <td>' . $last_mod_product . '</td>
                            <td>' . $is_hidden . '</td>
                            <td>
                            <a class="btn-primary" href="?id=' . $id_product . '&action=1" title="Modifier"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></a>
                            <a class="btn-warning" href="?id=' . $id_product . '&action=2" title="Réparer"><i class="fa fa-fw fa-wrench" aria-hidden="true"></i></a>
                            <a class="btn-danger" href="?id=' . $id_product . '&action=3" title="Supprimer"><i class="fa fa-fw fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>';
        }
    }
    
    public function getCategory ()
    {
        $products = $this->query('SELECT `id_category`, `name_category`, `id_parent_cat`, `published_at_category`, `last_modification_category` FROM `category_`')->fetchAll();
        
        foreach ($products as list($id_category, $name_category, $id_parent_cat, $published_at_category, $last_mod_category)) {
            echo '<tr>
                            <td>' . $id_category . '</td>
                            <td>' . $name_category . '</td>
                            <td>' . $id_parent_cat . '</td>
                            <td>' . $published_at_category . '</td>
                            <td>' . $last_mod_category . '</td>
                            <td>
                            <a class="btn-primary" href="?id=' . $id_category . '&action=1" title="Modifier"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i></a>
                            <a class="btn-warning" href="?id=' . $id_category . '&action=2" title="Réparer"><i class="fa fa-fw fa-wrench" aria-hidden="true"></i></a>
                            <a class="btn-danger" href="?id=' . $id_category . '&action=3" title="Supprimer"><i class="fa fa-fw fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>';
        }
    }
    
}

$bdd = Database::getDatabase();
