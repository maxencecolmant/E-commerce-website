<?php include_once "header_dashboard.php"; ?>
<?php $util::rmItem('category'); ?>
<?php include_once "nav_dashboard.php"; ?>
	<div class="content-wrapper">
		<div class="container-fluid">
			<?php $util::get_breadcrumb(); ?>
			<!--User DataTables Card-->
			<div class="card mb-3">
				<div class="card-header">
                    <div class="row">
                        <div class="currentPage col-sm-12 col-md-6">
                            <i class="fa fa-table"></i> Catégories
                        </div>
                        <div class="custom-right col-sm-12 col-md-6">
                            <a class="addItem btn btn-primary" href="#" role="button">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter une catégorie
                            </a>
                        </div>
                    </div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
							<thead>
							<tr>
								<th>ID_CATEGORY</th>
								<th>NOM</th>
								<th>ID_PARENT</th>
								<th>PUBLIE LE</th>
								<th>DERNIERE MODIFICATION</th>
                                <th></th>
							</tr>
							</thead>
							<tfoot>
							<tr>
                                <th>ID_CATEGORY</th>
                                <th>NOM</th>
                                <th>ID_PARENT</th>
                                <th>PUBLIE LE</th>
                                <th>DERNIERE MODIFICATION</th>
                                <th></th>
							</tr>
							</tfoot>
							<tbody>
							<?php $user->bdd->getCategory(); ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer small text-muted">Updated <?php echo date("d/m/Y H:i:s")?></div>
			</div>
		</div>
	</div>
<?php include_once "footer_dashboard.php"; ?>