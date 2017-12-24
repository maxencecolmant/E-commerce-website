<?php include 'includes/header.php' ?>

<?php include 'includes/navbar.php' ?>






<style>
    
        .credit-card-div  span { padding-top:10px; }
        .credit-card-div img { padding-top:30px; }
        .credit-card-div .small-font { font-size:9px; }
        .credit-card-div .pad-adjust { padding-top:10px; }
        </style>


<body>
    <div class="container">
        <div class="row">
            <!-- You can make it whatever width you want. I'm making it full width
            on <= small devices and 4/12 page width on >= medium devices -->
            <div class="col-xs-12 col-md-4">
    
    
                <!-- CREDIT CARD FORM STARTS HERE -->
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading display-table">
                        <div class="row display-tr">
                            <h3 class="panel-title display-td">Payment Details</h3>
                            <div class="display-td">
                                <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="payment-form">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="cardNumber">CARD NUMBER</label>
                                        <div class="input-group">
                                            <input type="tel"
                                                   class="form-control"
                                                   name="cardNumber"
                                                   placeholder="Valid Card Number"
                                                   autocomplete="cc-number"
                                                   required autofocus />
                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-7 col-md-7">
                                    <div class="form-group">
                                        <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                        <input type="tel"
                                               class="form-control"
                                               name="cardExpiry"
                                               placeholder="MM / YY"
                                               autocomplete="cc-exp"
                                               required />
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5 pull-right">
                                    <div class="form-group">
                                        <label for="cardCVC">CV CODE</label>
                                        <input type="tel"
                                               class="form-control"
                                               name="cardCVC"
                                               placeholder="CVC"
                                               autocomplete="cc-csc"
                                               required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="couponCode">COUPON CODE</label>
                                        <input type="text" class="form-control" name="couponCode" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="btn btn-success btn-lg btn-block" type="submit">Start Subscription</button>
                                </div>
                            </div>
                            <div class="row" style="display:none;">
                                <div class="col-xs-12">
                                    <p class="payment-errors"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- CREDIT CARD FORM ENDS HERE -->
    
    
            </div>
    
    
    
        </div>
    </div>
    
    <!-- If you're using Stripe for payments -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
    ar $form = $('#payment-form');
$form.on('submit', payWithStripe);

/* If you're using Stripe for payments */
function payWithStripe(e) {
    e.preventDefault();

    /* Visual feedback */
    $form.find('[type=submit]').html('Validating <i class="fa fa-spinner fa-pulse"></i>');

    var PublishableKey = 'pk_test_b1qXXwATmiaA1VDJ1mOVVO1p'; // Replace with your API publishable key
    Stripe.setPublishableKey(PublishableKey);

    /* Create token */
    var expiry = $form.find('[name=cardExpiry]').payment('cardExpiryVal');
    var ccData = {
        number: $form.find('[name=cardNumber]').val().replace(/\s/g, ''),
        cvc: $form.find('[name=cardCVC]').val(),
        exp_month: expiry.month,
        exp_year: expiry.year
    };

    Stripe.card.createToken(ccData, function stripeResponseHandler(status, response) {
        if (response.error) {
            /* Visual feedback */
            $form.find('[type=submit]').html('Try again');
            /* Show Stripe errors on the form */
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').closest('.row').show();
        } else {
            /* Visual feedback */
            $form.find('[type=submit]').html('Processing <i class="fa fa-spinner fa-pulse"></i>');
            /* Hide Stripe errors on the form */
            $form.find('.payment-errors').closest('.row').hide();
            $form.find('.payment-errors').text("");
            // response contains id and card, which contains additional card details            
            console.log(response.id);
            console.log(response.card);
            var token = response.id;
            // AJAX - you would send 'token' to your server here.
            $.post('/account/stripe_card_token', {
                token: token
            })
                // Assign handlers immediately after making the request,
                .done(function (data, textStatus, jqXHR) {
                    $form.find('[type=submit]').html('Payment successful <i class="fa fa-check"></i>').prop('disabled', true);
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    $form.find('[type=submit]').html('There was a problem').removeClass('success').addClass('error');
                    /* Show Stripe errors on the form */
                    $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                    $form.find('.payment-errors').closest('.row').show();
                });
        }
    });
}
/* Fancy restrictive input formatting via jQuery.payment library*/
$('input[name=cardNumber]').payment('formatCardNumber');
$('input[name=cardCVC]').payment('formatCardCVC');
$('input[name=cardExpiry').payment('formatCardExpiry');

/* Form validation using Stripe client-side validation helpers */
jQuery.validator.addMethod("cardNumber", function (value, element) {
    return this.optional(element) || Stripe.card.validateCardNumber(value);
}, "Please specify a valid credit card number.");

jQuery.validator.addMethod("cardExpiry", function (value, element) {
    /* Parsing month/year uses jQuery.payment library */
    value = $.payment.cardExpiryVal(value);
    return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
}, "Invalid expiration date.");

jQuery.validator.addMethod("cardCVC", function (value, element) {
    return this.optional(element) || Stripe.card.validateCVC(value);
}, "Invalid CVC.");

validator = $form.validate({
    rules: {
        cardNumber: {
            required: true,
            cardNumber: true
        },
        cardExpiry: {
            required: true,
            cardExpiry: true
        },
        cardCVC: {
            required: true,
            cardCVC: true
        }
    },
    highlight: function (element) {
        $(element).closest('.form-control').removeClass('success').addClass('error');
    },
    unhighlight: function (element) {
        $(element).closest('.form-control').removeClass('error').addClass('success');
    },
    errorPlacement: function (error, element) {
        $(element).closest('.form-group').append(error);
    }
});

paymentFormReady = function () {
    if ($form.find('[name=cardNumber]').hasClass("success") &&
        $form.find('[name=cardExpiry]').hasClass("success") &&
        $form.find('[name=cardCVC]').val().length > 1) {
        return true;
    } else {
        return false;
    }
}

$form.find('[type=submit]').prop('disabled', true);
var readyInterval = setInterval(function () {
    if (paymentFormReady()) {
        $form.find('[type=submit]').prop('disabled', false);
        clearInterval(readyInterval);
    }
}, 250);


    </script>
    
    </body>
</body>
</html>

<?php include '../includes/footer.php' ?>