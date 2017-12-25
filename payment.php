<?php
include_once "includes/init.php";
include_once "includes/Session.php";
include_once "includes/Util.php";
include_once "includes/User.php";
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>
<div class="container form">
	<div class="col-md-6 col-md-offset-3 form-custom">

		<div class="creditCardForm">
			<h2 class="img-header">
				<img class="img-logo" src="assets/icones/logo.png"/>
				<div class="content">
					Formulaire de paiement
				</div>

			</h2>
			<div class="payment">
				<form class="form">
					<div class="input-group owner">
						<i class="socicon-users custom-icon"></i>
						<input type="text" class="form-control" id="owner" placeholder="Propriétaire">
					</div>
					<div class="input-group" id="card-number-field">
						<i class="socicon-credit-card custom-icon"></i>
						<input type="text" class="form-control" id="cardNumber" placeholder="N° de carte">
					</div>
					<div class="row">
						<div class="col-lg-8">
							<div class="input-group" id="expiration-date">
								<select class="form-control" style="width: 50%; margin-right: 10px;">
									<option selected="selected" disabled>Mois</option>
									<option value="01">Janvier</option>
									<option value="02">Février </option>
									<option value="03">Mars</option>
									<option value="04">Avril</option>
									<option value="05">Mai</option>
									<option value="06">Juin</option>
									<option value="07">Juillet</option>
									<option value="08">Août</option>
									<option value="09">Septembre</option>
									<option value="10">Octobre</option>
									<option value="11">Novembre</option>
									<option value="12">Décembre</option>
								</select>
								<select class="form-control" id="year" style="width: 30%;">
									<option selected="selected" disabled>Année</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="input-group CVV">
								<i class="socicon-barcode custom-icon"></i>
								<input type="text" class="form-control" id="cvv" placeholder="CVC">
							</div>
						</div>
					</div>
					<div class="form-group" id="credit_cards">
						<img src="assets/payment-icons/visa.png" id="visa" width="50px;">
						<img src="assets/payment-icons/mastercard.png" id="mastercard"  width="50px;">
						<img src="assets/payment-icons/maestro.png" id="maestro"  width="50px;">
					</div>
					<small class="message-user">
						En cliquant sur Confirmer, vous acceptez les  <a href="">Conditions d'utilisation</a> et <a href="">les modalités de paiement</a> de TechDeals
					</small>
					<div class="text-center submit-button" id="pay-now">
						<input type="submit" class="btn-custom bttn-jelly bttn-md" id="confirm-purchase" value="Confirmer"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

<script>
	var expYear = document.getElementById("year"),
	startYear = new Date().getFullYear()
	count = 5;
	(function(select, val, count) {
		do {
			select.add(new Option(val++, count--), null);
		} while (count);
	})(expYear, startYear, count);
</script>

<?php include 'includes/footer.php'; ?>
