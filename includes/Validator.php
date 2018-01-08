<?php

class Validator
{
    private $data;
    private $session;
    private $errors = [];
    private $errors_msg = array(
        'not_exist' => "Champ inexistant !",
        'not_alpha' => "Ce champs n'est pas alphanumérique !",
        'not_unique' => "Ce champ n'est pas unique !",
        'not_email' => "Ce champ n'est pas un email !",
        'not_confirm' => "Ce champ n'est pas confirmé !",
        'not_fill' => "Ce champ n'est pas rempli !",
    );
    
    public function __construct ($session, $data = null)
    {
        $this->session = $session;
        $this->data = $data;
    }
    
    public function setData ($data)
    {
        $this->data = $data;
    }
    
    public function isAlphaNum ($field, $errorMsg = false)
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))) {
            $this->errors[$field] = $errorMsg ? $errorMsg : $this->errors_msg['not_alpha'];
            
            return false;
        }
        
        return true;
    }
    
    private function getField ($field)
    {
        if (!isset($this->data[$field])) {
            $this->errors[$field] = $this->errors_msg['not_exist'];
            
            return null;
        }
        
        return $this->data[$field];
    }
    
    public function isUnique ($field, $db, $table, $errorMsg = false)
    {
        $record = $db->query('SELECT id_' . substr($table, 0, -1) . ' from ' . $table . ' WHERE ' . $field . ' = :value', [':value' => $this->getField($field)])->fetch();
        if ($record) {
            $this->errors[$field] = $errorMsg ? $errorMsg : $this->errors_msg['not_unique'];
            
            return false;
        }
        
        return true;
    }
    
    public function isEmail ($field, $errorMsg = false)
    {
        if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $errorMsg ? $errorMsg : $this->errors_msg['not_email'];
            
            return false;
        }
        
        return true;
    }
    
    public function isConfirmed ($field, $errorMsg = false)
    {
        if ($this->getField($field) != $this->getField($field . '_c')) {
            $this->errors[$field] = $errorMsg ? $errorMsg : $this->errors_msg['not_confirm'];
            
            return false;
        }
        
        return true;
    }
    
    public function hasEmptyFields ()
    {
        foreach ($this->data as $field => $value) {
            if ($this->isEmpty($field)) {
                return true;
            }
        }
        
        return false;
    }
    
    public function isEmpty ($field, $errorMsg = false)
    {
        if (empty($this->getField($field))) {
            $this->errors[$field] = $errorMsg ? $errorMsg : $this->errors_msg['not_fill'];
            
            return true;
        }
        
        return false;
    }
    
    public function isValid ()
    {
        return empty($this->errors);
    }
    
    public function getErrors ()
    {
        return $this->errors;
    }
    
    public function showErrors() {
        foreach ($this->errors as $error) {
            $this->session->setFlash('default', 'danger', $error);
        }
    }
}