<?php

namespace techdeals;


class Cart
{
    
    private $session;
    private $validator;
    
    /**
     * Cart constructor.
     *
     * @param $session
     */
    public function __construct ($data)
    {
        $this->session = Session::getInstance();
        $this->validator = new Validator($this->session, $data);
    }
    
    public function addProductToCart ($id_product, $quantity_product_ordered)
    {
        
        if ($this->createCart() && !$this->isLocked()) {
            if ($this->validator->isNumber('id') && !$this->validator->isEmpty('q')) {
                $gotProduct = array_key_exists($id_product, $this->session->read('cart'));
                if ($gotProduct) {
                    $_SESSION['cart'][$id_product]['quantity_product_ordered'] += intval($quantity_product_ordered);
                } else {
                    $this->session->doubleWrite(
                        'cart', $id_product, array(
                        'id_product' => intval($id_product),
                        'quantity_product_ordered' => intval($quantity_product_ordered)
                    ));
                }
            } else {
                $this->session->setFlash('default', 'danger', 'Une erreur est survenue !');
            }
        }
    }
    
    public function createCart ()
    {
        if (!$this->session->exist('cart')) {
            $this->session->write('cart', array());
            $this->session->doubleWrite('cart', 'lock', false);
        }
        
        return true;
    }
    
    private function isLocked ()
    {
        if ($this->session->doubleRead('cart', 'lock')) {
            return true;
        }
        
        return false;
    }
    
    public function updateProductQuantity ($id_product, $quantity_product_ordered)
    {
        if ($this->createCart() && !$this->isLocked()) {
            if ($quantity_product_ordered > 0) {
                $gotProduct = array_key_exists($id_product, $this->session->read('cart'));
                
                if ($gotProduct) {
                    $_SESSION['cart'][$id_product]['quantity_product_ordered'] = intval($quantity_product_ordered);
                }
            } else {
                $this->removeProductToCart($id_product);
            }
        } else {
            $this->session->setFlash('default', 'danger', 'Une erreur est survenue !');
        }
    }
    
    public function removeProductToCart ($IDs)
    {
        
        $IDs = preg_split('/,/', $IDs, null, PREG_SPLIT_NO_EMPTY);
        
        if ($this->createCart() && !$this->isLocked()) {
            foreach ($IDs as $id_product) {
                if ($this->session->doubleExist('cart', $id_product)) {
                    $this->session->doubleDelete('cart', $id_product);
                } else {
                    $this->session->setFlash('default', 'danger', 'Une erreur est survenue !');
                }
            }
        }
    }
    
    public function cartHT ()
    {
        $total = $this->totalCart();
        $ht = round(($total / 1.2), 2);
        
        return $ht;
    }
    
    public function cartTVA() {
        return $this->totalCart() - $this->cartHT();
    }
    
    public function totalCart ()
    {
        $cart = $this->session->read('cart');
        $count = 0.00;
        
        if ($cart == null) {
            return $count;
        }
        
        foreach ($cart as $product) {
            if (is_array($product)) {
                $price = Database::getDatabase()->query('SELECT price_product FROM products WHERE id_product = :id', [
                    ':id' => $product['id_product'],])->fetch(\PDO::FETCH_ASSOC);
                $count += floatval($price['price_product']) * $product['quantity_product_ordered'];
            }
        }
        
        return $count;
    }
    
    public function removeCart ()
    {
        if ($this->session->exist('cart')) {
            $this->session->delete('cart');
        }
    }
    
}