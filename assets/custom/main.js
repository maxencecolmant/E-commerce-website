// Main.js

var path = window.location.pathname;

var formAll = document.forms[$("#mainForm").attr('name')];

var inputsSignUp = [{name: 'first_name', rules: 'required'}, {name: 'last_name', rules: 'required'}, {
    name: 'username',
    rules: 'required'
}, {name: 'email', rules: 'valid_email|required'}, {name: 'password', rules: 'required'}, {
    name: 'password_c',
    display: 'password confirmation',
    rules: 'required|matches[password]'
}];

var inputsLogin = [{name: 'name', rules: 'required'}, {name: 'password', rules: 'required'}];
var inputsContact = [{name: 'email', rules: 'valid_email|required'}, {
    name: 'subject',
    rules: 'required'
}, {name: 'message', rules: 'required'}];

function validation() {

    var inputs = [];

    if (path.match('/signup')) {
        inputs = inputsSignUp;
    } else if (path.match('/login')) {
        inputs = inputsLogin;
    } else if (path.match('/contact-us')) {
        inputs = inputsContact
    }


    var validator = new FormValidator(formAll, inputs,
        function (errors) {
            $("#fname-error,#name-error,#lname-error,#uname-error,#email-error,#password-error,#passwordConf-error,#message-error,#subject-error").empty();
            $(".input-group#forFname,.input-group#forName,.input-group#forLname,.input-group#forUname,.input-group#forEmail,.input-group#forPassword,.input-group#forPassConf,.form-group#forEmail,.form-group#forSubject,.form-group#forMessage").removeClass('has_error');
            if (errors.length > 0) {
                for (var i = 0; i < errors.length; i++) {
                    // console.log(errors[i].message);
                    switch (errors[i].name) {
                        case "first_name":
                            $(".input-group#forFname").addClass('has_error');
                            $("#fname-error").html(errors[i].message);
                            break;

                        case "name":
                            $(".input-group#forName").addClass('has_error');
                            $("#name-error").html(errors[i].message);
                            break;
                        case "last_name":
                            $(".input-group#forLname").addClass('has_error');
                            $("#lname-error").html(errors[i].message);
                            break;
                        case "username":
                            $(".input-group#forUname").addClass('has_error');
                            $("#uname-error").html(errors[i].message);
                            break;
                        case "email":
                            $(".input-group#forEmail,.form-group#forEmail").addClass('has_error');
                            $("#email-error").html(errors[i].message);
                            break;
                        case "password":
                            $(".input-group#forPassword").addClass('has_error');
                            $("#password-error").html(errors[i].message);
                            break;
                        case "password_c":
                            $(".input-group#forPassConf").addClass('has_error');
                            $("#passwordConf-error").html(errors[i].message);
                            break;
                        case "subject":
                            $(".form-group#forSubject").addClass('has_error');
                            $("#subject-error").html(errors[i].message);
                            break;
                        case "message":
                            $(".form-group#forMessage").addClass('has_error');
                            $("#message-error").html(errors[i].message);
                            break;
                        default:
                            break;
                    }
                }
            }
        });
}

if (path.match('/signup') || path.match('/login') || path.match('/contact-us')) {
    validation();
}

// store filter for each group
var filters = [];


// external js: isotope.pkgd.js

// init Isotope
var $grid = $('.grid').isotope({
    itemSelector: '.product'
});

$('.apply-filter').click(function (e) {
    e.preventDefault();
    $form = document.forms['filters'].elements;
    filters = {};

    for (var i = 0; i < $form.length; i++) {
        if ($form[i].type === 'checkbox') {
            if ($form[i].checked) {
                $checkGroup = $($form[i]).parent('.input-group').parent('.check-group');
                var filterGroup = $checkGroup.attr('data-filter-group');

                if (filters[filterGroup]) {
                    filters[filterGroup] += ', ' + $($form[i]).attr('data-filter');
                } else {
                    filters[filterGroup] = $($form[i]).attr('data-filter');
                }
            }
        }
    }

    if (!jQuery.isEmptyObject(filters)) {
        $('.cancel-filter').removeClass('hidden');
    } else {
        $('.cancel-filter').addClass('hidden');
    }

    var filterValue = concatValues(filters);
    // set filter for Isotope
    $grid.isotope({filter: filterValue});
});

$('.cancel-filter').click(function (e) {
    e.preventDefault();
    $form = document.forms['filters'].elements;
    filters = [];

    for (var i = 0; i < $form.length; i++) {
        if ($form[i].type === 'checkbox') {
            if ($form[i].checked) {
                $form[i].checked = false;
            }
        }
    }

    $('.cancel-filter').addClass('hidden');

    var filterValue = concatValues(filters);
    // set filter for Isotope
    $grid.isotope({filter: filterValue});
});


// flatten object by concatting values
function concatValuesArray(array) {
    var value = '';
    array.forEach(function (filter) {
        value += filter;
    });

    return value;
}

function concatValues( obj ) {
    var value = '';
    for ( var prop in obj ) {
        value += obj[ prop ];
    }
    return value;
}
