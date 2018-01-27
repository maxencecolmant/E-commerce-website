<?php include 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php list($id_product, $name_product, $price_product, $specs_product, $desc_product, $img_product, $rank_product, $quantity_product, $name_category, $username) = $bdd->query('SELECT id_product, name_product, price_product, specs_product, desc_product, img_product, rank_product, quantity_product, name_category, username FROM products LEFT JOIN users ON products.id_user = users.id_user LEFT JOIN category_ ON products.id_category = category_.id_category WHERE id_product = :id', [
   ':id' => htmlspecialchars($_GET['id']),
])->fetch(\PDO::FETCH_NUM); ?>
<?php $util::get_breadcrumb(); ?>

<?php echo $id_product;?>
<?php echo $name_product;?>
<?php echo $price_product;?>
<?php echo $specs_product;?>
<?php echo $name_category;?>
<?php echo $username;?>
<?php include 'includes/footer.php' ?>