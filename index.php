<?php include 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

    <main id="main" class="container main">
        <section id="slider_header" class="slider_header">
            <div class="container">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item carousel-item active">

                            <div style="background:linear-gradient(rgba(12, 31, 146, 0.2), rgba(0, 0, 0, 0.5)), rgba(12, 31, 146, 0.2) url(/assets/images/deal1.jpg) center center;  background-size:cover;"
                                 class="slider-size">
                                <div class="carousel-caption">
                                    <h3 class="product-name">Macbook Pro 13</h3>
                                    <p class="price">Seulement à
                                        <span class="currentPrice">1200€</span> au lieu de 1900€</p>
                                    <a href="" class="btn-like-link-standard" style="font-size:18px;padding: 6px 30px;">Acheter</a>
                                </div>
                            </div>
                        </div>
                        <div class="item carousel-item">

                            <div style="background:linear-gradient(rgba(12, 31, 146, 0.2), rgba(0, 0, 0, 0.5)), rgba(12, 31, 146, 0.2) url(/assets/images/deal1.jpg) center center;  background-size:cover;"
                                 class="slider-size">
                                <div class="carousel-caption">
                                    <h3 class="product-name">Macbook Pro 13</h3>
                                    <p class="price">Seulement à
                                        <span class="currentPrice">1200€</span> au lieu de 1900€</p>
                                    <a href="" class="btn-like-link-standard" style="font-size:18px;padding: 6px 30px;">Acheter</a>
                                </div>
                            </div>
                        </div>
                        <div class="item carousel-item">

                            <div style="background:linear-gradient(rgba(12, 31, 146, 0.2), rgba(0, 0, 0, 0.5)), rgba(12, 31, 146, 0.2) url(/assets/images/deal1.jpg) center center;  background-size:cover;"
                                 class="slider-size">
                                <div class="carousel-caption">
                                    <h3 class="product-name">Macbook Pro 13</h3>
                                    <p class="price">Seulement à
                                        <span class="currentPrice">1200€</span> au lieu de 1900€</p>
                                    <a href="" class="btn-like-link-standard" style="font-size:18px;padding: 6px 30px;">Acheter</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <i class="socicon-arrow-left"></i>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <i class="socicon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>


        <section id="selection" class="selection">
            <div class="container">
                <div class=content>
                    <h2>
                        Notre selection du mois
                    </h2>
					<?php
					$product_select = $bdd->query(
						'SELECT id_product, name_product, name_category, img_product, price_product
 FROM products LEFT JOIN category_ ON products.id_category = category_.id_category WHERE is_hidden = :v', [ ':v' => 1, ] )->fetchAll( \PDO::FETCH_ASSOC );
					?>
                    <div class="container">
                        <div class="content">
                            <table class="table">
                                <tr>
									<?php if( !empty( $product_select )) : ?>
									<?php foreach( $product_select as $pr ) : ?>
                                        <td>
                                            <div class="product-item-4">
                                                <div class="product">
                                                    <div class="content">
                                                        <img class="img-responsive"
                                                             src="/assets/images/products/<?php echo $pr['img_product']; ?>"
                                                             alt="">
                                                        <span class="cat"><?php echo $pr['name_category']; ?></span>
                                                        <a href="product.php?id=<?php echo $pr['id_product']; ?>"
                                                           class="title"><?php echo $pr['name_product']; ?></a>

                                                        <p class="rev">
                                                            <i class="socicon-star"></i>
                                                            <i class="socicon-star"></i>
                                                            <i class="socicon-star"></i>
                                                            <i class="socicon-star"></i>
                                                            <i class="socicon-star-half-empty"></i>
                                                        </p>
                                                        <div class="price">

                                                        <span class="currentPrice"><?php echo $pr['price_product']; ?>
                                                            €</span>
                                                            <span class="oldPrice"></span>
                                                        </div>
                                                        <a href="product.php?id=<?php echo $pr['id_product']; ?>"
                                                           class="cart-btn">
                                                            <i class="socicon-shopping-cart-black-shape"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
									<?php endforeach; ?>
                                </tr>
                            </table>
                        </div>
                    </div>
				<?php else: ?>
                    <div>
                        <p>En cours de sélection !</p>
                    </div>
				<?php endif; ?>
                </div>
            </div>

        </section>


        <!-- Partners -->

        <section id="partners" class="partners">
            <div class="container">
                <div class=content>
                    <h2>
                        Nos marques partenaires
                    </h2>
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active">
                            <a href="#a" data-toggle="tab">Marque 1</a>
                        </li>
                        <li role="presentation">
                            <a href="#b" data-toggle="tab">Marque 2</a>
                        </li>
                        <li role="presentation">
                            <a href="#c" data-toggle="tab">Marque 3</a>
                        </li>
                        <li role="presentation">
                            <a href="#d" data-toggle="tab">Marque 4</a>
                        </li>
                        <li role="presentation">
                            <a href="#e" data-toggle="tab">Marque 5</a>
                        </li>
                    </ul>

                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="a">
                            <!-- Product -->
                            <div class="product-item-5">
                                <div class="product">
                                    <div class="content">
                                        <img class="img-responsive" src="/assets/images/evo_samsung.png" alt="">

                                        <span class="cat">Disque SSD</span>
                                        <a href="#" class="title">
                                            SSD Samsung Serie 850 EVO - 500 Go</a>

                                        <p class="rev">
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star-half-empty"></i>
                                            <span>(4)</span>
                                        </p>
                                        <div class="price">

                                            <span class="currentPrice">139,90€</span>
                                            <span class="oldPrice">179,90€</span>
                                        </div>
                                        <a href="#." class="cart-btn">
                                            <i class="socicon-shopping-cart-black-shape"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product -->
                            <div class="product-item-5">
                                <div class="product">
                                    <div class="content">
                                        <img class="img-responsive" src="/assets/images/evo_samsung.png" alt="">

                                        <span class="cat">Disque SSD</span>
                                        <a href="#" class="title">
                                            SSD Samsung Serie 850 EVO - 500 Go</a>

                                        <p class="rev">
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star-half-empty"></i>
                                            <span>(4)</span>
                                        </p>
                                        <div class="price">

                                            <span class="currentPrice">139,90€</span>
                                            <span class="oldPrice">179,90€</span>
                                        </div>
                                        <a href="#." class="cart-btn">
                                            <i class="socicon-shopping-cart-black-shape"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product -->
                            <div class="product-item-5">
                                <div class="product">
                                    <div class="content">
                                        <img class="img-responsive" src="/assets/images/evo_samsung.png" alt="">

                                        <span class="cat">Disque SSD</span>
                                        <a href="#" class="title">
                                            SSD Samsung Serie 850 EVO - 500 Go</a>

                                        <p class="rev">
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star-half-empty"></i>
                                            <span>(4)</span>
                                        </p>
                                        <div class="price">

                                            <span class="currentPrice">139,90€</span>
                                            <span class="oldPrice">179,90€</span>
                                        </div>
                                        <a href="#." class="cart-btn">
                                            <i class="socicon-shopping-cart-black-shape"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product -->
                            <div class="product-item-5">
                                <div class="product">
                                    <div class="content">
                                        <img class="img-responsive" src="/assets/images/evo_samsung.png" alt="">

                                        <span class="cat">Disque SSD</span>
                                        <a href="#" class="title">
                                            SSD Samsung Serie 850 EVO - 500 Go</a>

                                        <p class="rev">
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star-half-empty"></i>
                                            <span>(4)</span>
                                        </p>
                                        <div class="price">

                                            <span class="currentPrice">139,90€</span>
                                            <span class="oldPrice">179,90€</span>
                                        </div>
                                        <a href="#." class="cart-btn">
                                            <i class="socicon-shopping-cart-black-shape"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product -->
                            <div class="product-item-5">
                                <div class="product">
                                    <div class="content">
                                        <img class="img-responsive" src="/assets/images/evo_samsung.png" alt="">

                                        <span class="cat">Disque SSD</span>
                                        <a href="#" class="title">
                                            SSD Samsung Serie 850 EVO - 500 Go</a>

                                        <p class="rev">
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star"></i>
                                            <i class="socicon-star-half-empty"></i>
                                            <span>(4)</span>
                                        </p>
                                        <div class="price">

                                            <span class="currentPrice">139,90€</span>
                                            <span class="oldPrice">179,90€</span>
                                        </div>
                                        <a href="#" class="cart-btn">
                                            <i class="socicon-shopping-cart-black-shape"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="b">
                            <h3>marque2
                            </h3>
                        </div>
                        <div class="tab-pane" id="c">
                            <h3>marque3
                            </h3>
                        </div>
                        <div class="tab-pane" id="d">
                            <h3>marque4
                            </h3>
                        </div>
                        <div class="tab-pane" id="e">
                            <h3>marque5
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="categories" class="categories">
			<?php
			$cat = $category->allCategory();
			?>
            <div class="container">
                <div class=content>
                    <h2>
                        Catégories
                    </h2>
					<?php if( !empty( $cat ) ) : ?>
						<?php foreach( $cat as $main ) : ?>
                            <div class="category-item-4 components">
                                <div class="category">
                                    <div class="content">
                                        <div class="category-header">
                                            <a href="view.php?category=<?php echo $main; ?>"
                                               class="title">
												<?php echo $main; ?></a>
                                        </div>
										<?php
										$id = $category->nameToID( $main );
										
										$subCat = $category->getSubcategory( $id );
										?>

                                        <ul>
											<?php foreach( $subCat as $sC ) : ?>
                                            <?php $info = $category->getInfoCat($sC); ?>
                                                <li>
                                                    <a href="view.php?category=<?php echo $info['name_category'];?>"><?php echo $info['name_category'];?></a>
                                                </li>
											<?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
						<?php endforeach; ?>
					<?php else: ?>
                        <p>Erreur : aucune catégorie trouvé !</p>
					<?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Social -->
        <section class="social" id="social">
            <div id="social-container" class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Abonnez-vous à la newsletter

                        </h3>
                    </div>
                    <div class="col-md-6">
                        <form>
                            <input type="email" placeholder="Saisissez votre adresse e-mail...">
                            <button type="submit">S'abonner!</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!--  -->
        <!-- I'll add it later -->
        <section class="brands" id="brands">
            <div class="container">
                <div class="row">
                    <div class="cl-5">
                        <div class="brand">
                            <a href="https://fr.msi.com/">
                                <img src="/assets/images/brand/msi-logo.png" width="120px" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="cl-5">
                        <div class="brand">
                            <a href="https://www.asus.com/fr/">
                                <img src="/assets/images/brand/asus-logo.png" width="120px" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="cl-5">
                        <div class="brand">
                            <a href="http://www.samsung.com/fr/">
                                <img src="/assets/images/brand/samsung-logo.png" width="120px" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="cl-5">
                        <div class="brand">
                            <a href="https://www.nvidia.fr/">
                                <img src="/assets/images/brand/nvidia-logo.png" width="120px" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="cl-5">
                        <div class="brand">
                            <a href="https://www.intel.fr/">
                                <img src="/assets/images/brand/intel-logo.png" width="120px" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>


<?php include 'includes/footer.php' ?>