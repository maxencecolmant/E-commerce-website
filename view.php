<?php include 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php $currentCategory = htmlspecialchars($_GET['category']); ?>

<main id=main class="container main">
    <section id="view-page" class="view-page">
        <div class="container">
            <div class="breadcrumb-title">
                <?php $util::get_breadcrumb(); ?>
            </div>
            <div class=aside>
                <div class="row">
                    <h4 class="aside-title">Filter ma recherche</h4>
                </div>

            </div>
            <div class="content">
                <div class="row">
                    <h2 class="currentCategory">
                        <?php echo $currentCategory; ?>
                    </h2>

                    <?php
            if ($category->isParentCat($currentCategory)) {
                $category->displayChild($currentCategory);
            } else {
                $category->displayProduct($currentCategory);
            }
            ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php' ?>