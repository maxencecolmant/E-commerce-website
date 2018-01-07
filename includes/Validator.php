<?php
require_once "Session.php";
/*
 * Cette classe doir être adapté, elle provient de be-guided
 *
 * Elle servira a faire les verification coté serveur
 *
 * Il faudra peut etre changer son fonctionnement
 *
 * Pour l'instant on specifie les donné ($data) a verifié dans un tableau (le POST ou GET )
 *
 * Puis on vérifie telle ou telle condition en specifiant le champ voulu ($field)
 *
 * on récupère ensuite le tableau des erreur et on fait des flash (peut etre a retirer)
 */
class Validator
{
    private $data;
    private $session;
    private $errors = [];

    public function __construct($data,$session)
    {
        $this->data = $data;
        $this->session = $session;
    }

    private function getField($field)
    {
        if (!isset($this->data[$field])) {
            return null;
        }
        return $this->data[$field];
    }

    public function isAlphaNum($field, $errorMsg)
    {
        if (!isset($this->data[$field]) || !preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            $this->session->setFlash('danger', $errorMsg);
        }
    }

    public function isUnique($field, $db, $table, $errorMsg)
    {
        $record = $db->query("SELECT id_user from $table WHERE $field = :id", [':id' => $this->getField($field)])->fetch();
        if ($record) {
            $this->errors[$field] = $errorMsg;
            $this->session->setFlash('danger', $errorMsg);
        }
    }

    public function isEmail($field, $errorMsg)
    {
        if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $errorMsg;
            $this->session->setFlash('danger', $errorMsg);
        }
    }

    public function isConfirmed($field, $errorMsg)
    {
        if (empty($this->getField($field)) || $this->getField($field) != $this->getField($field . '_confirm')) {
            $this->errors[$field] = $errorMsg;
            $this->session->setFlash('danger', $errorMsg);
        }
    }
    
    public function isEmpty($field, $errorMsg)
    {
        if (empty($this->getField($field))) {
            $this->errors[$field] = $errorMsg;
            $this->session->setFlash('danger', $errorMsg);
        }
    }
        

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}