const path = window.location.pathname;
const pathSplit = path.split("/");
const locUrl = pathSplit[pathSplit.length - 1];
//console.log(locUrl);
var $defaultUser = "<tr><td name=\"id_user\"></td><td name=\"last_name\" class=\"possible\"></td><td name=\"first_name\" class=\"possible\"></td><td name=\"username\" class=\"possible\"></td><td name=\"email\" class=\"possible\"></td><td name=\"img_user_profile\" class=\"possible\"></td><td></td><td></td><td name=\"status\"></td><td><a href class=\"btn-success registerUser\"><i class=\"fa fa-fw fa-check\" aria-hidden=\"true\"></i></a> <a href class=\"btn-danger removeRow\"><i class=\"fa fa-fw fa-times\" aria-hidden=\"true\"></i></a></td></tr>";
var $defaultProduct = '<tr><td></td><td class=\"possible\"></td><td class=\"possible\"></td><td class=\"possible\"></td><td class=\"possible\"></td><td class=\"possible\"></td><td class=\"possible\"></td><td class=\"possible\"></td><td class=\"possible\"></td><td></td><td></td><td></td> <td><a href class=\"btn-success registerUser\"><i class=\"fa fa-fw fa-check\" aria-hidden=\"true\"></i></a> <a href class=\"btn-danger removeRow\"><i class=\"fa fa-fw fa-times\" aria-hidden=\"true\"></i></a></td></tr>';
var $defaultCategory = '  <td></td><td class=\"possible\"></td><td class=\"possible\"></td><td></td><td></td><td><a href class=\"btn-success registerUser\"><i class=\"fa fa-fw fa-check\" aria-hidden=\"true\"></i></a> <a href class=\"btn-danger removeRow\"><i class=\"fa fa-fw fa-times\" aria-hidden=\"true\"></i></a></td>';
if (path.match("/users") || path.match("/products") || path.match("/category")) {
    if (path.match("/users")) {
        $type = $defaultUser;
    } else if (path.match("/products")) {
        $type = $defaultProduct;
    } else if (path.match("/category")) {
        $type = $defaultCategory;
    }
    modify();
    add();
}

function modify() {
    let $currentButton = $('.modify');
    $currentButton.click(function (e) {
        e.preventDefault();
        if ($(this)[0].classList.contains('btn-primary') === true) {
            $currentRow = $(this).parents('tr').find('td.possible');
            $currentRow.prop('contenteditable', true).toggleClass('canEdit');
            $(this).removeClass('btn-primary').addClass('btn-success').empty().html('<i class="fa fa-fw fa-check" aria-hidden="true"></i>');
            $('#cancel-' + $(this)[0].parentElement.id)[0].hidden = false;
            $old_data = [];
            $currentRow.toArray().forEach(function ($value) {
                if ($value.attributes.name.value === 'id_category') {
                    $value_id = valueToID($value.innerText.toString(), 'name_category', 'id_category', 'category_', 'RAW');
                    $old_data.push(parseInt($return));
                } else {
                    $old_data.push($value.innerText);
                }
            });
        } else if ($(this)[0].classList.contains('btn-success') === true) {
            $data = {};
            $currentRow.toArray().forEach(function (value, index) {
                if (value.innerText !== $old_data[index]) {
                    if (value.innerText !== '' || $.inArray(value.attributes.name.value, ['img_user_profile', 'id_parent_cat', 'img_product'] !== -1)) {
                        $data['id'] = value.parentElement.id;
                        $data['origin'] = document.location.pathname;
                        $data[value.attributes.name.value] = value.innerText;
                    } else {
                        value.innerText = $old_data[index];
                    }
                }
            });
            console.log($data);
            $currentRow.prop('contenteditable', false).removeClass('canEdit');
            $(this).removeClass('btn-success').addClass('btn-primary').empty().html('<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>');
            $('#cancel-' + $(this)[0].parentElement.id)[0].hidden = true;
            if (!jQuery.isEmptyObject($data)) {
                $.ajax({
                    type: 'POST',
                    url: 'save.php',
                    data: $data,
                    success: function (data) {
                        console.log("Running Update...");
                        console.log(data);
                        $res = data.slice(0, -4);
                        if (!jQuery.isEmptyObject($res)) {
                            window.location.href = locUrl;
                        }
                    },
                    fail: function (data) {
                        console.log('fail');
                        console.log(data);

                    },
                });
            } else {
                console.log("No Update");
            }
        }
    });
    //cancel
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
}

function add() {
    var $addItem = $('.addItem');
    //addUser button
    $addItem.click(function (e) {
        e.preventDefault();
        $("#dataTable").find('tbody').append($type);
        var $removeRow = $('.removeRow');
        var $registerItem = $('.registerItem');
        var $lastRow = $("tbody tr").last();
        $lastRow.find('td.possible').prop('contenteditable', true).toggleClass('canEdit');
        //danger button ; removeRow
        $removeRow.click(function (e) {
            e.preventDefault();
            $lastRow.remove();
        });
        //success button ; register user
        $registerItem.click(function (e) {
            e.preventDefault();
            alert("OK");
        });
    });
}

function valueToID(value, colToSet, colToGet, table, type) {
    $data = {
        value: value,
        colToSet: colToSet,
        colToGet: colToGet,
        table: table,
        type: type,
    };

    $return = null;

    $.ajax({
        type: 'GET',
        url: 'data.php',
        data: $data,
        dataType: 'text',
        success: function (data, status) {
            console.log(data);
            console.log(status);
            $return = data.toString();
            return  $return;

        },
    })

}