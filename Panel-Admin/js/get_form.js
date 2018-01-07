$(document).ready(function () {
    let $currentButton = $('.modify');
    $currentButton.click(function (e) {
        e.preventDefault();
        if ($(this)[0].classList.contains('btn-primary') === true) {
            $currentRow = $(this).parents('tr').find('td.possible');
            $currentRow.prop('contenteditable', true).toggleClass('canEdit');
            $(this).removeClass('btn-primary').addClass('btn-success').empty().html('<i class="fa fa-fw fa-check" aria-hidden="true"></i>');
            $('#cancel-' + $(this)[0].parentElement.id)[0].hidden = false;
            $old_data = [];
            $currentRow.toArray().forEach(function (value) {
                $old_data.push(value.innerText);
            });
        } else if ($(this)[0].classList.contains('btn-success') === true) {
            $data = {};
            $currentRow.toArray().forEach(function (value, index) {
                if (value.innerText !== $old_data[index]) {
                    if (value.innerText !== '' || value.attributes.name.value === 'img_user_profile') {
                        $data['id'] = value.parentElement.id;
                        $data['url'] = document.location.href;
                        $data[value.attributes.name.value] = value.innerText;
                    } else {
                        value.innerText = $old_data[index];
                    }
                }
            });
            $currentRow.prop('contenteditable', false).removeClass('canEdit');
            $(this).removeClass('btn-success').addClass('btn-primary').empty().html('<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>');
            $('#cancel-' + $(this)[0].parentElement.id)[0].hidden = true;
            if (!jQuery.isEmptyObject($data)) {
                $.ajax({
                    type: 'POST',
                    url: 'save.php',
                    data: $data,
                    success: function (data) {
                        console.log("ok");
                        console.log(data);
                        window.location.href = 'users.php';
                    }
                });
            }
        }
    });

    let $cancelMod = $('.cancelMod');
    $cancelMod.click(function (e) {
        e.preventDefault();
        $('#modify-' + $(this)[0].parentElement.id).removeClass('btn-success').addClass('btn-primary').empty().html('<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>');
        $(this)[0].hidden = true;
        $currentRow = $(this).parents('tr').find('td.possible');
        $currentRow.prop('contenteditable', false).removeClass('canEdit');
        $currentRow.toArray().forEach(function (value, index) {
            value.innerText = $old_data[index];
        });
    });

});
