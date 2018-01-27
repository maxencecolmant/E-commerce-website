<?php

namespace techdeals;

/**
 * Class Category
 * @package techdeals
 */
class Category
{
    
    /**
     * @var null
     */
    public static $category = null;
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
     * Category constructor.
     * @param $bdd
     * @param $session
     */
    public function __construct($bdd, $session)
    {
        $this->bdd = $bdd;
        $this->session = $session;
        $this->validator = new Validator($this->session);
    }
    
    /**
     * @return null|Category
     */
    public static function getCategory()
    {
        if (!self::$category) {
            self::$category = new Category(Database::getDatabase(), Session::getInstance());
        }
        
        return self::$category;
    }
    
    public function getNavCat()
    {
        $return = '';
        
        foreach ($this->allCategory() as $item => $value) {
            $return .= '<li><a href="view.php?category=' . $value . '">' . $value . '</a></li>';
        }
        
        return $return;
    }
    
    public function allCategory()
    {
        return $this->bdd->query('SELECT name_category FROM category_ WHERE id_parent_cat IS NULL')->fetchAll(\PDO::FETCH_COLUMN);
    }
    
    public function displayChild($nameCategory)
    {
        $isParentCat = $this->bdd->query('SELECT id_category FROM category_ WHERE id_parent_cat = :id', [
            ':id' => $this->nameToID($nameCategory),
        ])->fetchAll(\PDO::FETCH_COLUMN);
        
        $return = '';
        
        if (!empty($isParentCat)) {
            foreach ($isParentCat as $item) {
                $infoItem = $this->getInfoCat($item);
                //         $return .= '<div class="col-sm-6 col-md-4">
                //     <div class="thumbnail">
                //         <img src="" alt="...">
                //         <div class="caption">
                //             <h3>' . $infoItem['name_category'] . '</h3>
                //             <p>...</p>
                //             <p><a href="view.php?category=' . $infoItem['name_category'] . '" class="btn btn-primary" role="button">Voir plus</a></p>
                //         </div>
                //     </div>
                // </div>';

                $return .= '<div class="category-item-3 components">
                    <div class="category">
                        <div class="content">
                            <div class="category-header">
                                <img class="img-responsive" src="" alt="">
                                <a href="view.php?category=' . $infoItem['name_category'] . '" class="title">' . $infoItem['name_category'] . '</a>
                            </div>

                            <ul>
                                <li>
                                    <a href="">Subcategory</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>';
            }
        }
        
        echo $return;
    }
    
    public function nameToID($nameCategory)
    {
        $idCategory = $this->bdd->query('SELECT id_category FROM category_ WHERE name_category = :name', [
            ':name' => $nameCategory,
        ])->fetch(\PDO::FETCH_ASSOC);
        
        return $idCategory['id_category'];
    }
    
    public function getInfoCat($idCat)
    {
        return $this->bdd->query('SELECT id_category, name_category, id_parent_cat FROM category_ WHERE id_category = :id', [
            ':id' => $idCat,
        ])->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function displayProduct($nameCategory)
    {
        $products = $this->bdd->query('SELECT id_product, name_product, price_product, desc_product, img_product FROM products WHERE id_category = :id', [
            ':id' => $this->nameToID($nameCategory),
        ])->fetchAll(\PDO::FETCH_ASSOC);
        
        $return = '';
        
        foreach ($products as $item) {
            // $return .= '<div class="media">
            //       <div class="media-left media-middle">
            //         <a href="#">
            //           <img class="media-object" src="' . $item['img_product'] . '" alt="...">
            //         </a>
            //       </div>
            //       <div class="media-body">
            //         <h4 class="media-heading">' . $item['name_product'] . '</h4>
            //         ' . $item['desc_product'] . '
            //       </div>
            //       <div class="media-right">
            //         ' . $item['price_product'] . ' €
            //       </div>
            //       <div class="media-right">
            //       <a href="product.php?id=' . $item['id_product'] . '">Acheter</a>
            //       </div>
            //     </div>';


            // le nom de la categorie est en get
            $return .= '<div class="product-item-4">
                <div class="product">
                    <div class="content">
                        <img class="img-responsive" src="'.$item['img_product'].'" alt="">
                        <span class="cat">'.htmlspecialchars($_GET['category']).'</span>
                        <a href="product.php?id=' . $item['id_product'] . '" class="title">'.$item['name_product'].'</a>

                        <p class="rev">
                            <i class="socicon-star"></i>
                            <i class="socicon-star"></i>
                            <i class="socicon-star"></i>
                            <i class="socicon-star"></i>
                            <i class="socicon-star-half-empty"></i>
                        </p>
                        <div class="price">

                            <span class="currentPrice">'.$item['price_product'].'€</span>
                            <span class="oldPrice"></span>
                        </div>
                        <a href="product.php?id=' . $item['id_product'] . '" class="cart-btn">
                            <i class="socicon-shopping-cart-black-shape"></i>
                        </a>
                    </div>
                </div>
            </div>';
        }
        
        echo $return;
    }
    
    public function isParentCat($nameCategory)
    {
        $child = $this->bdd->query('SELECT id_category FROM category_ WHERE id_parent_cat = :id', [
            ':id' => $this->nameToID($nameCategory),
        ])->fetchAll(\PDO::FETCH_COLUMN);
        
        if (empty($child)) {
            return false;
        }
        
        return true;
    }
}
