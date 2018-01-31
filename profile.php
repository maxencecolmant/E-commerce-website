<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php' ?>
<?php
$user = $bdd->query( 'SELECT * FROM users WHERE id_user = :id ',
                           [
	                           ':id' =>  $session->doubleRead('connected', 'id_user'),
                           ] )->fetch( \PDO::FETCH_ASSOC );
$session->write('connected', $user);
$info = $session->read('connected');
?>
<div class="container" style="text-align:center;min-height: 70vh;">
    <h1 class="page-header">Modifiez votre profil</h1>
    <div class="row">
        <!-- edit form column -->
        <div class="">
            <form name="form-user" class="form-horizontal" role="form" method="post" action="#">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Nom d'utilisateur:</label>
                    <div class="col-lg-8">
                        <input name="username" class="form-control" value="<?php echo $info['username']; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Prénom:</label>
                    <div class="col-lg-8">
                        <input name="first_name" class="form-control" value="<?php echo $info['first_name']; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Nom:</label>
                    <div class="col-lg-8">
                        <input name="last_name" class="form-control" value="<?php echo $info['last_name']; ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input name="email" class="form-control" type="email" value="<?php echo $info['email']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Mot de passe:</label>
                    <div class="col-md-8">
                        <input name="password" class="form-control" value="" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Confirmez votre mot de passe:</label>
                    <div class="col-md-8">
                        <input name="password_c" class="form-control" value="" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="hidden" name="id" value="<?php echo $info['id_user']; ?>">
                        <input type="hidden" name="origin" value="users.php">
                        <input type="hidden" name="type" value="UPDATE">
                        <input id="save" class="btn btn-primary" value="Sauvegarder" type="submit">
                        <span></span>
                        <input class="btn btn-default" value="Annuler" type="reset">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php' ?>
<script>
   $('#save').click(function (e) {
        e.preventDefault();
        $input = ['email', 'first_name', 'last_name', 'password', 'password_c', 'id', 'origin', 'type', 'username'];
        $data = {};

        $input.forEach(function (value) {
            $data[value] = document.forms['form-user'].elements[value].value;
        });

       $.ajax({
           type: 'POST',
           url: '/Dashboard/save.php',
           data: $data,
           success: function (data) {
               console.log(data);
               location.reload();
           },
       });
    });
    
    
</script>
