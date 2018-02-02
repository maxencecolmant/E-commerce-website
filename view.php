<?php include 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php $currentCategory = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : null; ?>
<?php $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : null ?>

<main id=main class="container main" style="min-height: 70vh;">
    <section id="view-page" class="view-page">
        <div class="container">
            <div class="breadcrumb-title">
                <?php $util::get_breadcrumb(); ?>
            </div>
            <div class=aside>
                <div class="row">
                    <h4 class="aside-title">Filter ma recherche</h4>
                    <div class="filter-categories">
                        <form action="">
                            <!-- filter1 -->
                            <div class="f-category">
                                <div class="f-header">
                                    <h2>Cupcake Donut</h2>
                                </div>
                                <div class="f-content">
                                    <div class="input-group">
                                        <input type="checkbox" name="checkbox" id="checkbox">
                                        <label for="checkbox">Mon filtre 1</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="checkbox" name="checkbox" id="checkbox">
                                        <label for="checkbox">Mon filtre 1</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="checkbox" name="checkbox" id="checkbox">
                                        <label for="checkbox">Mon filtre 1</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="checkbox" name="checkbox" id="checkbox">
                                        <label for="checkbox">Mon filtre 1</label>
                                    </div>
                                </div>
                            </div>
                            <!-- filter2 -->
                            <div class="f-category">
                                <div class="f-header">
                                    <h2>Cupcake Donut</h2>
                                </div>
                                <div class="f-content">
                                    <input type="checkbox" name="checkbox" id="checkbox">
                                    <label for="checkbox">Mon filtre 1</label>
                                </div>
                            </div>
                            <!-- filter3 -->
                            <div class="f-category">
                                <div class="f-header">
                                    <h2>Cupcake Donut</h2>
                                </div>
                                <div class="f-content">
                                    <input type="checkbox" name="checkbox" id="checkbox">
                                    <label for="checkbox">Mon filtre 1</label>
                                </div>
                            </div>
                            <!-- <a href="" class="btn apply-filter">Appliquer les filtres</a> -->
                            <input type="submit" value="Appliquer les filtres" class="btn apply-filter">
                            <!-- <a href="" class="btn cancel-filter hidden">Annuler les filtres</a> -->
                            <input type="submit" value="Annuler les filtres" class="btn cancel-filter hidden">
                        </form>
                    </div>
                </div>

            </div>
            <div class="content">
                <div class="row">
                    <h2 class="currentCategory">
                        <?php if ($search != null): ?> Résultat de la recherche pour :
                        <?php echo $search; ?>
                        <?php else: ?>
                        <?php echo $currentCategory != null ? $currentCategory : 'Toutes les catégories'; ?>
                        <?php endif; ?>
                    </h2>
                    <?php if ($currentCategory != null) : ?>
                    <?php
                            if ($category->isParentCat($currentCategory)) {
                                $category->displayChild($currentCategory);
                            } else {
                                $category->displayProduct($currentCategory);
                            }
                            ?>
                        <?php elseif ($search != null): ?>
                        <?php
                            $category->displaySearch($search);
                            ?>
                            <?php else: ?>
                            <?php $category->displayAll(); ?>
                            <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php' ?>