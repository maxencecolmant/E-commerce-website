<?php
include 'includes/header.php';
include 'includes/navbar.php';
?>
<?php $util::sendMail(); ?>
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
				<form class="form" id="mainForm" method="POST" name="contactForm">
					<div id="forEmail" class="form-group">
						<input id="email" type="email" class="contact-email form-control" placeholder="Email" name="email" >
						<label id="email-error" class="error" for="email"></label>
					</div>
					<div id="forSubject" class="form-group">
						<input id="subject" type="text" class="contact-subject form-control" placeholder="Sujet" name="subject">
						<label id="subject-error" class="error" for="subject"></label>
                    </div>
                    
                    <div id="forMessage" class="form-group">
						<textarea id="message" class="contact-message form-control none" rows="8" placeholder="Message" name="message"></textarea>
						<label id="message-error" class="error" for="message"></label>
                    </div>

					<div class="text-center submit-button">
 						<input id="submit" type="submit" class="btn-custom bttn-jelly bttn-md" value="Envoyer"/>
 					</div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php include 'includes/footer.php'; ?>