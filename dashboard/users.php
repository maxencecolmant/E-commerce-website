<?php include_once "header_dashboard.php"; ?>
<?php include_once "nav_dashboard.php"; ?>
<?php $user->actionUser(); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $util::get_breadcrumb(); ?>
            <!--User DataTables Card-->
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="currentPage col-sm-12 col-md-6">
                            <i class="fa fa-table"></i> Utilisateurs
                        </div>
                        <div class="custom-right col-sm-12 col-md-6">
                            <a class="addItem btn btn-primary" href="#" role="button">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> Ajouter un utilisateur
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID_USER</th>
                                <th>NOM</th>
                                <th>PRENOM</th>
                                <th>NOM D'UTILISATEUR</th>
                                <th>EMAIL</th>
                                <th>MOT DE PASSE</th>
                                <th>IMG_PROFILE</th>
                                <th>STATUS</th>
                                <th>CREE LE</th>
                                <th>DERNIERE CONNEXION</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>ID_USER</th>
                                <th>NOM</th>
                                <th>PRENOM</th>
                                <th>NOM D'UTILISATEUR</th>
                                <th>EMAIL</th>
                                <th>MOT DE PASSE</th>
                                <th>IMG_PROFILE</th>
                                <th>STATUS</th>
                                <th>CREE LE</th>
                                <th>DERNIERE CONNEXION</th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php $user->bdd->getUsers(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated <?php echo date("d/m/Y H:i:s") ?></div>
            </div>
        </div>
    </div>
<?php include_once "footer_dashboard.php"; ?>