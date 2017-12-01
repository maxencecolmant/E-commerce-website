<?php
class Database
{
    static $instance_bdd = null;
    private $bdd;
    
    static function getDatabase()
    {
        if (!self::$instance_bdd){
            self::$instance_bdd = new Database('root', '', 'mini_twitter');
        }
        return self::$instance_bdd;
        
    }
    
    public function __construct($login, $password, $database_name, $host = 'localhost')
    {
        try {
            $this->bdd = new PDO("mysql:dbname=$database_name;host=$host", $login, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }
    
    /**
     * @param $query
     * @param bool|array $params
     * @return PDOStatement
     */
    public function query($query, $params = false)
    {
        if ($params) {
            $req = $this->bdd->prepare($query);
            $req->execute($params) or die (print_r($req->errorInfo()));
        } else {
            $req = $this->bdd->query($query);
        }
        return $req;
    }
    
    public function lastInsertId()
    {
        return $this->bdd->lastInsertId();
    }
    
    public function setAttribute($attribut, $value) {
        $this->bdd->setAttribute($attribut, $value);
    }
}

$bdd = Database::getDatabase();