<?php include 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>

<?php $currentCategory = isset( $_GET['category'] ) ? htmlspecialchars( $_GET['category'] ) : null; ?>
<?php $search = isset( $_GET['search'] ) ? htmlspecialchars( $_GET['search'] ) : null ?>

    <main id=main class="container main" style="min-height: 70vh;">
        <section id="view-page" class="view-page">
            <div class="container">
                <div class="breadcrumb-title">
					<?php $util::get_breadcrumb(); ?>
                </div>
				<?php if( ($currentCategory != null && !$category->isParentCat( $currentCategory )) || $search != null ) : ?>
                    <div class=aside>
                        <div class="row">
                            <h3 class="aside-title">Filter ma recherche</h3>
                            <div class="filter-categories">
                                <form name="filters" class="filters" action="">
                                    <!-- filter1 -->
									<?php
									if( $currentCategory != null ) {
										$category->displayFilter( $currentCategory );
									} elseif( $search != null) {
									    $category->displayFilterSearch($search);
                                    }
									?>
                                    <!-- <a href="" class="btn apply-filter">Appliquer les filtres</a> -->
                                    <button type="submit" class="btn apply-filter">Appliquer les filtres</button>
                                    <!-- <a href="" class="btn cancel-filter hidden">Annuler les filtres</a> -->
                                    <button type="submit" class="btn cancel-filter hidden">Annuler les filtres</button>
                                </form>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
                <div class="content">
                    <div class="row">
                        <h2 class="currentCategory">
							<?php if( $search != null ): ?> Résultat de la recherche pour :
								<?php echo $search; ?>
							<?php else: ?>
								<?php echo $currentCategory != null ? $currentCategory : 'Toutes les catégories'; ?>
							<?php endif; ?>
                        </h2>
                        <div class="grid">
							<?php if( $currentCategory != null ) : ?>
								<?php
								if( $category->isParentCat( $currentCategory ) ) {
									$category->displayChild( $currentCategory );
								} else {
									$category->displayProduct( $currentCategory );
								}
								?>
							<?php elseif( $search != null ): ?>
								<?php
								$category->displaySearch( $search );
								?>
							<?php else: ?>
								<?php $category->displayAll(); ?>
							<?php endif; ?></div>
                    </div>
                </div>
            </div>
        </section>

    </main>

<?php include 'includes/footer.php' ?>