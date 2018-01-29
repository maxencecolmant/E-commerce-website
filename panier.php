<?php include_once 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php
require_once 'includes/Cart.php';
$cart = new techdeals\Cart( $_GET );

if( !empty( $_GET ) ) {
	$validator->setData( $_GET );
	
	if( !$validator->isEmpty( 'action' ) ) {
		$id = htmlspecialchars( $_GET['id'] );
		$q = htmlspecialchars( $_GET['q_' . $id] );
		switch( htmlspecialchars( $_GET['action'] ) ) {
			case 'add':
				if( !$validator->isEmpty( 'id' ) && !$validator->isEmpty( 'q_' . $id ) ) {
					$cart->addProductToCart( $id, $q );
				} else {
					$session->setFlash( 'default', 'danger', 'Une erreur est survenue !' );
				}
				break;
			case 'remove':
				if( !$validator->isEmpty( 'id' ) ) {
					$cart->removeProductToCart( $id );
				} else {
					$session->setFlash( 'default', 'danger', 'Une erreur est survenue !' );
				}
				break;
			case 'refresh':
				if( !$validator->isEmpty( 'id' ) && !$validator->isEmpty( 'q_' . $id ) ) {
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

?>
<main class="container">
	<?php var_dump( $session->read( 'cart' ) );
	
	?>
    <div class="row">
        <form method="get" action="#">
            <fieldset>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="bg-extra-light-grey"></th>
                            <th class="bg-extra-light-grey">Product</th>
                            <th class="bg-extra-light-grey">Quantity</th>
                            <th class="bg-extra-light-grey">Price</th>
                            <th class="bg-extra-light-grey">Subtotal</th>
                            <th class="bg-extra-light-grey"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <form method="get" action="#">
                                <td class="align-middle">
                                    <a href=""> <img
                                                class="img-responsive center-block extra-small-img"
                                                alt="product"
                                                src="<?php ///img_product ?>">
                                    </a></td>
                                <td class="align-middle">
									<?php //name_product ?>
                                </td>
                                <td scope="row" class="align-middle">
                                    <input type="number" class="form-control stepper-input"
                                           name="<?php //q_(id_product) ?>" value="<?php //quantity ?>"
                                           step="1">
                                </td>
                                <td class="align-middle text-center">
									<?php //price ?>
                                </td>
                                <td class="align-middle text-center">
									<?php //sub-total ?>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="hidden" name="id" value="<?php //id_product ?>">
                                    <button type="submit" class="btn btn-info text-center no-margin" href="#"><i
                                                class="fa fa-refresh"></i></button>
                                    <a class="btn btn-danger text-center no-margin" href="#"><i class="fa fa-trash"></i></a>
                                </td>
                            </form>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <fieldset class="buttons">
                <div class="pull-right">
                    <a class="btn btn-info btn-lg lg-2x text-uppercase" href="/shop">Back to shopping</a>
                    <a class="btn btn-info btn-lg lg-2x text-uppercase" href="/payment">Purchase it</a>
                    <a class="btn btn-info btn-lg lg-2x text-uppercase" href="#"><i class="fa fa-refresh"></i></a>

                    </a></div>
            </fieldset>
        </form>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <section class="single-block bg-white wrap-radius">
                <div class="icon-email"> <!--icon-email, icon-discount, icon-shipping-->
                    <h4 class="title-box text-uppercase no-margin-top">
                        SUBSCRIBE TO NEWSLETTER
                    </h4>
                    <p class="copy-box no-margin-top">
                        Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et
                        dolore magna aliqua.
                    </p>
                    <div class="text-center">
                        <a class="btn btn-link no-margin" href="#">SHOW MORE</a>
                    </div>
                </div>
            </section>

        </div>
        <div class="col-sm-4">
            <section class="single-block bg-white wrap-radius">
                <div class="icon-discount"> <!--icon-email, icon-discount, icon-shipping-->
                    <h4 class="title-box text-uppercase no-margin-top">
                        Have a Coupon?
                    </h4>
                    <p class="copy-box no-margin-top">
                        Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et
                        dolore magna aliqua.
                    </p>
                    <div class="text-center">
                        <a class="btn btn-link no-margin" href="#">SHOW MORE</a>
                    </div>
                </div>
            </section>

        </div>
        <div class="col-sm-4">
            <section class="wrap wrap-border internal-padding spacer-bottom-15">
                <h4 class="text-uppercase no-margin">Summary order</h4>
                <div class="spacer-top-5">
                    <div class="row spacer-bottom-5">
                        <div class="col-xs-6">Articles:</div>
                        <div class="col-xs-6 text-right">$ 45,00</div>
                    </div>
                    <div class="row spacer-bottom-5">
                        <div class="col-xs-6">Shipping costs:</div>
                        <div class="col-xs-6 text-right">
                            <b>GRATIS</b>
                        </div>
                    </div>
                    <div class="row spacer-bottom-5">
                        <div class="col-xs-6 highlighted">
                            <strong>Gift Certificate:</strong>
                        </div>
                        <div class="col-xs-6 text-right">
                            <b>- $ 45,00</b>
                        </div>
                    </div>
                    <div class="row spacer-bottom-5">
                        <div class="col-xs-6">Total order:</div>
                        <div class="col-xs-6 text-right">$ 0,00</div>
                    </div>
                    <p class="small no-margin spacer-top-15">
                        Your order includes VAT.
                        <a href="/kidstore/terms-conditions">
                            <u>Details</u>
                        </a>
                    </p>
                </div>
            </section>

        </div>
    </div>
</main>
<?php include 'includes/footer.php' ?>
