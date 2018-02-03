<?php include_once 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php
require_once 'includes/Cart.php';
$cart = new techdeals\Cart( $_POST );

if( !empty( $_POST ) ) {
	$validator->setData( $_POST );
	
	if( !$validator->isEmpty( 'action' ) ) {
		$id = isset( $_POST['id'] ) ? htmlspecialchars( $_POST['id'] ) : null;
		$q = isset( $_POST['q'] ) ? htmlspecialchars( $_POST['q'] ) : null;
		switch( htmlspecialchars( $_POST['action'] ) ) {
			case 'add':
				if( !$validator->isEmpty( 'id' ) && !$validator->isEmpty( 'q' ) ) {
					$cart->addProductToCart( $id, $q );
					header( 'Location: /panier.php' );
				} else {
					$session->setFlash( 'default', 'danger', 'Une erreur est survenue !' );
				}
				break;
			case 'remove':
				if( !$validator->isEmpty( 'id' ) ) {
					$cart->removeProductToCart( $id );
					header( 'Location: /panier.php' );
				} else {
					$session->setFlash( 'default', 'danger', 'Une erreur est survenue !' );
				}
				break;
			case 'refresh':
				if( !$validator->isEmpty( 'id' ) && !$validator->isEmpty( 'q' ) ) {
					$cart->updateProductQuantity( $id, $q );
				} else {
					$session->setFlash( 'default', 'danger', 'Une erreur est survenue !' );
				}
				break;
			case 'drop':
				$cart->removeCart();
				break;
			default:
				break;
		}
	}
}
$cart_product = null;
if( $cart->createCart() ) {
	$cartP = $session->read( 'cart' );
	foreach( $cartP as $id => $item ) {
		if( is_array( $item ) ) {
			$cart_product .= $item['id_product'] . ', ';
		}
	}
	if( $cart_product != null ) {
		$cart_product = substr( $cart_product, 0, -2 );
		$curr_cart = $bdd->query( 'SELECT id_product, name_product, price_product, img_product FROM products WHERE id_product IN (' . $cart_product . ')' )->fetchAll( \PDO::FETCH_ASSOC );
	}
}
?>
<script>
    var cartInfo = [];
</script>
<main id=main class="container main" style="min-height: 70vh;">
    <section id="cart-page" class="cart-page">
        <div class="container">
            <div class="breadcrumb-title">
				<?php $util::get_breadcrumb(); ?>
            </div>
            <div class="content">
                <h2>Ma commande</h2>
                <div class="row">
                    <fieldset>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center">Produit</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-center">Prix TTC</th>
                                    <th class="text-center">Sous-Total</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody>
								<?php if( $cart_product != null ) : ?>
									<?php $i = 0; ?>
									<?php foreach( $curr_cart as $curr_product ): ?>
                                        <tr>
                                            <form method="post" action="panier.php">
                                                <td class="align-middle text-center">
                                                    <a href="">
                                                        <img class="img-responsive center-block extra-small-img"
                                                             alt="product" style="max-height: 60px;"
                                                             src="/assets/images/products/<?php echo $curr_product['img_product']; ?>">
                                                    </a>
                                                </td>
                                                <td class="align-middle text-center">
													<?php echo $curr_product['name_product']; ?>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <input type="number" class="form-control stepper-input"
                                                           id="q_<?php echo $i;
													       $i++; ?>" name="q"
                                                           value="<?php echo $_SESSION['cart'][$curr_product['id_product']]['quantity_product_ordered']; ?>"
                                                           step="1">
                                                </td>
                                                <td class="align-middle text-center">
													<?php echo $curr_product['price_product'] ?> €
                                                </td>
                                                <td class="align-middle text-center">
													<?php echo floatval( $curr_product['price_product'] ) * $_SESSION['cart'][$curr_product['id_product']]['quantity_product_ordered']; ?>
                                                    €
                                                </td>
                                                <td class="align-middle text-center">
                                                    <input type="hidden" name="id"
                                                           value="<?php echo $curr_product['id_product']; ?>">
                                                    <input type="hidden" name="action" value="refresh">
                                                    <button type="submit" class="btn btn-info text-center no-margin"
                                                            href="#">
                                                        <i class="fa fa-refresh"></i>
                                                    </button>
                                                    <button id="<?php echo $curr_product['id_product']; ?>"
                                                            class="btn btn-danger text-center no-margin remove-product">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </form>
                                            <script>
                                                cartInfo.push(
													<?php echo json_encode( $session->doubleRead( 'cart', $curr_product['id_product'] ) );?>
                                                );
                                            </script>
                                        </tr>
									<?php endforeach; ?>
								<?php else: ?>
                                    <tr>
                                        <td colspan="6" class="align-middle text-center">Panier Vide</td>
                                    </tr>
								<?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <fieldset class="buttons">
                        <div class="pull-left">
                            <a class="return btn btn-info btn-lg lg-2x " href="/view.php">Retour vers boutique</a>
                            <button id="drop-cart" class="drop-cart btn btn-danger btn-lg lg-2x ">Vider le panier
                            </button>
                        </div>
                        <div class="pull-right">

                            <a id="valid-order" class="valid-order btn btn-info btn-lg lg-2x " href="payment.php">Commander</a>
                        </div>
                    </fieldset>
                </div>
                <div class="row" style="margin-top: 50px;">
                    <div class="total-cart col-sm-4 col-sm-offset-8">
                        <section class="wrap wrap-border internal-padding spacer-bottom-15">
                            <h4 class=" no-margin">Total de ma commande :</h4>
                            <div class="spacer-top-5">
                                <div class="row spacer-bottom-5">
                                    <div class="col-xs-6">Articles:</div>
                                    <div class="col-xs-6 text-right">
										<?php echo $cart->cartHT(); ?> €
                                    </div>
                                </div>
                                <div class="row spacer-bottom-5">
                                    <div class="col-xs-6">TVA:</div>
                                    <div class="col-xs-6 text-right">
										<?php echo $cart->cartTVA(); ?> €
                                    </div>
                                </div>
                                <div class="row"></div>
                                <div class="row spacer-bottom-5">
                                    <div class="col-xs-6 ">
                                        <strong>Total à payer:</strong>
                                    </div>
                                    <div class="col-xs-6 text-right">
										<?php echo $cart->totalCart(); ?> €
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
if( $cart->totalCart() > 0 ) {
	$session->doubleWrite( 'cart', 'total_price', $cart->totalCart() );
}
?>
<?php include 'includes/footer.php' ?>