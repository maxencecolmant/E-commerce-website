<?php include_once 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php

$cmd = $bdd->query(
    'SELECT id_order, total_price, date_order FROM orders WHERE id_user = :id_user',
    [
    ':id_user' => $session->doubleRead('connected', 'id_user'),
]
)->fetchAll(\PDO::FETCH_ASSOC);
?>

    <main id=main class="container main" style="min-height: 70vh;">
        <section id="orders-page" class="orders-page">
            <div class="container">
                <div class="breadcrumb-title">
                    <?php $util::get_breadcrumb(); ?>
                </div>
                <div class="content">
                    <h2>Mes commandes</h2>
                    <div class="row">
                        <fieldset>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <col width="70">
                                    <col width="655">
                                    <col width="265">
                                    <col width="80">
                                    <thead>
                                        <tr>
                                            <th class="text-center nbcmd">N° Cmd</th>
                                            <th class="text-center">Liste des Articles</th>
                                            <th class="text-center datecmd">Date</th>
                                            <th class="text-center totalprice">Total TTC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($cmd)) :?>
                                        <?php foreach ($cmd as $commande) : ?>
                                        <?php
                        $cmdP = $bdd->query(
                            'SELECT  orders_info.id_product, quantity_product_ordered, name_product, price_product FROM  orders_info LEFT JOIN products ON orders_info.id_product = products.id_product WHERE id_order = :id_order',
    [
                            ":id_order" => $commande['id_order'],
                        ]
)->fetchAll(\PDO::FETCH_ASSOC);
                        ?>
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <?php echo $commande['id_order']; ?>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="panel-group" role="tablist">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="collapseListGroupHeading1<?php echo $commande['id_order']; ?>">
                                                                <h4 class="panel-title">
                                                                    <a href="#collapseListGroup1<?php echo $commande['id_order']; ?>" class="" role="button" data-toggle="collapse" aria-expanded="false"
                                                                        aria-controls="collapseListGroup1<?php echo $commande['id_order']; ?>">
                                                                        Détails </a>
                                                                </h4>
                                                            </div>
                                                            <div class="panel-collapse collapse" role="tabpanel" id="collapseListGroup1<?php echo $commande['id_order']; ?>" aria-labelledby="collapseListGroupHeading1<?php echo $commande['id_order']; ?>"
                                                                aria-expanded="false" style="">
                                                                <table class="table table-hover table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">Id</th>
                                                                            <th class="text-center">Libellé</th>
                                                                            <th class="text-center">Prix Unitaire</th>
                                                                            <th class="text-center">Quantité</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($cmdP as $p) : ?>
                                                                        <tr class="text-center">
                                                                            <td>
                                                                                <?php echo $p['id_product']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $p['name_product']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $p['price_product']; ?> €</td>
                                                                            <td>
                                                                                <?php echo $p['quantity_product_ordered']; ?>
                                                                            </td>
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
                                                    <?php echo $commande['date_order']; ?>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <?php echo $commande['total_price']; ?> €
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
                        </fieldset>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'includes/footer.php' ?>