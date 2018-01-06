<?php
include 'includes/header.php'; 
include 'includes/navbar.php'; 


//add php for contact mail
?>
<div class="container form">
	<div class="col-md-6 col-md-offset-3 form-custom">

		<div class="">
			<h2 class="img-header">
				<img class="img-logo" src="assets/icones/logo.png"/>
				<div class="content">
					Formulaire de contact
				</div>
			</h2>
			<div class="contact-form">
				<form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<div class="input-group">
						<i class="socicon-mail custom-icon"></i>
						<input id="contact-email" type="text" class="contact-email form-control" placeholder="Email" name="email">
					</div>
					<div class="input-group">
						<i class="socicon-folder custom-icon"></i>
						<input id="contact-subject" type="text" class="contact-subject form-control" placeholder="Sujet" name="subject">
                    </div>
                    
                    <div class="form-group">
                        <textarea id="contact-message" class="contact-message form-control none" rows="8" placeholder="Message" name="message"></textarea>
                    </div>
	
					<div class="text-center submit-button">
						<input type="submit" class="btn-custom bttn-jelly bttn-md" value="Envoyer"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="/assets/custom/contact_form.js"></script>