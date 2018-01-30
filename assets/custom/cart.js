$('#drop-cart').click(function () {

    $data = {
        action: 'drop',
    };
    $.ajax({
        type: 'POST',
        url: '/panier.php',
        data: $data,
        success: function (data) {
            console.log(data);
            location.reload();
        },
    });

});

$('#add-cart').click(function () {

    $id = $('#id_product').val();
    $q = $('#q').val();
    $data = {
        action: 'add',
        id: $id,
        q: $q,
    };
    console.log($data);

    $.ajax({
        type: 'POST',
        url: '/panier.php',
        data: $data,
        success: function (data) {
            console.log(data);
            swal({
                icon: 'info',
                text: 'Continuer vos Achats ?',
                buttons: ["Annuler", "Voir le Panier ?"],
            }).then((value => {
                if (value) {
                    location.href = 'panier.php';
                } else {
                    location.reload();
                }
            }));
        },
    });

});

$('#valid-order').click(function (e) {

    if (status === 'null') {
        e.preventDefault();
        swal({
            title: 'Une erreur est survenue !',
            text: 'Vous devez être connecté !',
            icon: 'error',
        })
    }


    if (jQuery.isEmptyObject(cartInfo)) {
        e.preventDefault();
        location.reload();
    }
    cartInfo.forEach(function (value, index) {
        if (value.quantity_product_ordered !== parseInt($('#q_' + index + ']').val())) {
            e.preventDefault();
            location.reload();
        }
    });

});

$('.remove-product').click(function () {
    $data = {
        action: 'remove',
        id: this.id,
    };
    console.log($data);

    $.ajax({
        type: 'POST',
        url: '/panier.php',
        data: $data,
        success: function (data) {
            console.log(data);
            location.reload();
        },
    });
});