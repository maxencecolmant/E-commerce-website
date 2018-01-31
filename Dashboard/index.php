<?php include_once "header_dashboard.php"; ?>
<?php include_once "nav_dashboard.php"; ?>
    <div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
		<?php $util::get_breadcrumb(); ?>

        <div class="container">
			<?php if( $restrict->isAllow( '/dashboard/users.php' ) ): ?>
                <div class="row">
                    <div class="jumbotron col-md-4 text-center">
                        <h1><i class="fa fa-fw  fa-3x fa-users"></i></h1>
                        <p><a class="btn btn-primary btn-lg" href="users.php" role="button">Gérer les utilisateurs</a>
                        </p>
                    </div>
                    <div class="jumbotron col-md-4 text-center">
                        <h1><i class="fa fa-fw  fa-3x fa-sitemap"></i></h1>
                        <p><a class="btn btn-primary btn-lg" href="category.php" role="button">Gérer les catégories</a>
                        </p>
                    </div>
                </div>
			<?php endif; ?>
            <div class="row">
                <div class="jumbotron col-md-4 text-center">
                    <h1><i class="fa fa-fw  fa-3x fa-database"></i></h1>
                    <p><a class="btn btn-primary btn-lg" href="products.php" role="button">Gérer les produits</a></p>
                </div>
				<?php if( $restrict->isAllow( '/dashboard/orders.php' ) ): ?>
                    <div class="jumbotron col-md-4 text-center">
                        <h1><i class="fa fa-fw  fa-3x fa-shopping-cart"></i></h1>
                        <p><a class="btn btn-primary btn-lg" href="orders.php" role="button">Gérer les commandes</a></p>
                    </div>
				<?php endif; ?>
            </div>

        </div>
    </div>
<?php include_once "footer_dashboard.php"; ?>