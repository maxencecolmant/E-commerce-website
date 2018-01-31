<?php include_once "header_dashboard.php"; ?>
<?php include_once "nav_dashboard.php"; ?>
<?php
$cmd = $bdd->query(
	'SELECT id_order, total_price, date_order, username FROM orders LEFT JOIN users ON orders.id_user = users.id_user')->fetchAll( \PDO::FETCH_ASSOC );
?>
    <div class="content-wrapper">
        <div class="container-fluid">
			<?php $util::get_breadcrumb(); ?>
            <!--User DataTables Card-->
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="currentPage col-sm-12 col-md-6">
                            <i class="fa fa-table"></i> Commandes
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>N° CMD</th>
                                <th>ARTICLES</th>
                                <th>TOTAL TTC</th>
                                <th>PROPRIETAIRE</th>
                                <th>DATE</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>N° CMD</th>
                                <th>ARTICLES</th>
                                <th>TOTAL TTC</th>
                                <th>PROPRIETAIRE</th>
                                <th>DATE</th>
                            </tr>
                            </tfoot>
                            <tbody>
							<?php if( !empty( $cmd ) ) : ?>
								<?php foreach( $cmd as $commande ) : ?>
									<?php
									$cmdP = $bdd->query(
										'SELECT  orders_info.id_product, quantity_product_ordered, name_product, price_product FROM  orders_info LEFT JOIN products ON orders_info.id_product = products.id_product WHERE id_order = :id_order', [
										":id_order" => $commande['id_order'],
									] )->fetchAll( \PDO::FETCH_ASSOC );
									?>
                                    <tr>
                                        <td class="align-middle text-center">
											<?php echo $commande['id_order']; ?>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="panel-group" role="tablist">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab"
                                                         id="collapseListGroupHeading1<?php echo $commande['id_order']; ?>">
                                                        <h4
                                                                class="panel-title"><a
                                                                    href="#collapseListGroup1<?php echo $commande['id_order']; ?>"
                                                                    class="" role="button"
                                                                    data-toggle="collapse" aria-expanded="false"
                                                                    aria-controls="collapseListGroup1<?php echo $commande['id_order']; ?>">
                                                                DETAILS </a></h4></div>
                                                    <div class="panel-collapse collapse" role="tabpanel"
                                                         id="collapseListGroup1<?php echo $commande['id_order']; ?>"
                                                         aria-labelledby="collapseListGroupHeading1<?php echo $commande['id_order']; ?>"
                                                         aria-expanded="false" style="">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center">ID</th>
                                                                <th class="text-center">LIBELLE</th>
                                                                <th class="text-center">PRIX UNITAIRE</th>
                                                                <th class="text-center">QUANTITE</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
															<?php foreach( $cmdP as $p ) : ?>
                                                                <tr class="text-center">
                                                                    <td><?php echo $p['id_product']; ?></td>
                                                                    <td><?php echo $p['name_product']; ?></td>
                                                                    <td><?php echo $p['price_product']; ?> €</td>
                                                                    <td><?php echo $p['quantity_product_ordered']; ?></td>
                                                                </tr>
															<?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                        <div class="panel-footer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
											<?php echo $commande['total_price']; ?> €
                                        </td>
                                        <td class="align-middle text-center">
											<?php echo $commande['username']; ?>
                                        </td>
                                        <td class="align-middle text-center">
											<?php echo $commande['date_order']; ?>
                                        </td>
                                    </tr>
								<?php endforeach; ?>
							<?php else: ?>
                                <tr>
                                    <td class="text-center" colspan="4">Aucune Commande</td>
                                </tr>
							<?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated <?php echo date( "d/m/Y H:i:s" ) ?></div>
            </div>
        </div>
    </div>
<?php include_once "footer_dashboard.php"; ?>