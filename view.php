<?php include 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php $currentCategory = htmlspecialchars($_GET['category']); ?>
<main>
    <div class="container">
        <?php $util::get_breadcrumb(); ?>
        <div class="row">
            <h2><?php echo $currentCategory; ?></h2>
        </div>
        <div class="row">
            <?php
            if ($category->isParentCat($currentCategory)) {
                $category->displayChild($currentCategory);
            } else {
                $category->displayProduct($currentCategory);
            }
            ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php' ?>
