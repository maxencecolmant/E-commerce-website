<?php include 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php list($id_product, $name_product, $price_product, $specs_product, $desc_product, $img_product, $rank_product, $quantity_product, $name_category, $username) = $bdd->query('SELECT id_product, name_product, price_product, specs_product, desc_product, img_product, rank_product, quantity_product, name_category, username FROM products LEFT JOIN users ON products.id_user = users.id_user LEFT JOIN category_ ON products.id_category = category_.id_category WHERE id_product = :id', [
   ':id' => htmlspecialchars($_GET['id']),
])->fetch(\PDO::FETCH_NUM); ?>

<!-- <?php echo $id_product;?>
<?php echo $name_product;?>

<?php echo $price_product;?>
<?php echo $specs_product;?>
<?php echo $name_category;?>
<?php echo $username;?> -->

<main id=main class="container main">
    <section id="product-page" class="product-page">
        <div class="container">
            <div class="breadcrumb-title">
                <?php $util::get_breadcrumb(); ?>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="img-product">
                            <img src="<?php echo $img_product;?>" alt="img-product">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="infos-product">
                            <h2 class="product-name">
                                <?php echo $name_product;?>
                            </h2>
                            <p class="desc">
                                <?php echo $desc_product;?>
                            </p>
                            <p class="rev">
                                <i class="socicon-star"></i>
                                <i class="socicon-star"></i>
                                <i class="socicon-star"></i>
                                <i class="socicon-star"></i>
                                <i class="socicon-star-half-empty"></i>
                            </p>
                            <p class="status">
                                Etat:
                                <span>Neuf</span>
                            </p>
                            <p class="stock">
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="op-product">
                            <div class="price">
                                <span class="price-product">
                                    <?php echo $price_product;?>
                                    <sup>€</sup>
                                </span>
                            </div>
                            <div class=delivery>
                                <p>
                                    Livraison gratuite
                                </p>
                            </div>
                            <div class="tax">
                                <p>
                                    Dont 0,00€ d'éco-participation
                                </p>
                            </div>
                            <div class="shop">
                                <a href="" class="addToCart">Ajouter au panier</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="technical-details" class="technical-details">
        <div class="container">
            <div class="content">
                <h2>
                    Fiche technique :
                    <?php echo $name_product;?>
                </h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php' ?>