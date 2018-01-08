<?php include_once "header_dashboard.php"; ?>
<?php include_once "nav_dashboard.php"; ?>
<div class="content-wrapper">
	<div class="container-fluid">
		<?php $util::get_breadcrumb(); ?>

		<!--User DataTables Card-->
		<div class="card mb-3">
			<div class="card-header">
				<i class="fa fa-table"></i> Produits
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
						<tr>
							<th>ID_PRODUCT</th>
							<th>NOM</th>
							<th>PRIX</th>
							<th>SPECIFICATIONS</th>
							<th>DESCRIPTION</th>
							<th>IMAGE</th>
							<th>RANG</th>
							<th>CATEGORY</th>
							<th>QUANTITE</th>
							<th>PUBLIE LE</th>
							<th>DERNIERE MODIFICATION</th>
							<th>CACHE</th>
						</tr>
						</thead>
						<tfoot>
						<tr>
                            <th>ID_PRODUCT</th>
                            <th>NOM</th>
                            <th>PRIX</th>
                            <th>SPECIFICATIONS</th>
                            <th>DESCRIPTION</th>
                            <th>IMAGE</th>
                            <th>RANG</th>
                            <th>CATEGORY</th>
                            <th>QUANTITE</th>
                            <th>PUBLIE LE</th>
                            <th>DERNIERE MODIFICATION</th>
                            <th>CACHE</th>
                        </tr>
						</tfoot>
						<tbody>
                        <?php $fct_user->bdd->getProducts(); ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer small text-muted">Updated <?php echo date("d/m/Y H:i:s")?></div>
		</div>
	</div>
</div>
<?php include_once "footer_dashboard.php"; ?>