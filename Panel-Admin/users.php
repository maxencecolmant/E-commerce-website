<?php include_once "header_dashboard.php"; ?>
<?php include_once "nav_dashboard.php"; ?>
<?php $fct_user->actionUser(); ?>
<div class="content-wrapper">
    <div class="container-fluid">
		<?php Util::get_breadcrumb(); ?>
	    <?php
	    if (Session::getInstance()->hasFlashes()) {
		    foreach (Session::getInstance()->getFlashes() as $key => $values): ?>
                <div class="ui <?php echo $key; ?> message">
                    <i class="close icon"></i>
                    <div class="header">
					    <?php echo $key; ?> !
                    </div>
                    <ul class="list">
					    <?php foreach ($values as $value) : ?>
                            <li><?php echo $value; ?></li>
					    <?php endforeach; ?>
                    </ul>
                </div>
		    <?php endforeach;
	    } ?>

        <!--User DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Utilisateurs
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID_USER</th>
                            <th>NOM</th>
                            <th>PRENOM</th>
                            <th>NOM D'UTILISATEUR</th>
                            <th>EMAIL</th>
                            <th>IMG_PROFILE</th>
                            <th>CREE LE</th>
                            <th>DERNIERE CONNEXION</th>
                            <th>STATUS</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID_USER</th>
                            <th>NOM</th>
                            <th>PRENOM</th>
                            <th>NOM D'UTILISATEUR</th>
                            <th>EMAIL</th>
                            <th>IMG_PROFILE</th>
                            <th>CREE LE</th>
                            <th>DERNIERE CONNEXION</th>
                            <th>STATUS</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php $fct_user->bdd->getUsers(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">Updated <?php echo date("d/m/Y H:i:s")?></div>
        </div>
    </div>
</div>
<?php include_once "footer_dashboard.php"; ?>