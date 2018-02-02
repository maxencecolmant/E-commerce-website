const path = window.location.pathname;
const pathSplit = path.split("/");
const locUrl = pathSplit[pathSplit.length - 1];
//console.log(locUrl);
const cookie = document.cookie;
let arrayCookie = cookie.split(';');
$status = '';
arrayCookie.forEach(function (cookie) {
    $infoCookie = cookie.split('=');
    console.log($infoCookie[0].trim());
    if ($infoCookie[0].trim() === 'status_user') {
        $status = $infoCookie[1];
    }
});
var edit;
if ($status === 'ADMIN' || $status === 'SUPER_ADMIN') {
    edit = 'class="possible select"';
} else {
    edit = '';
}
var $defaultUser = "<tr><td name=\"id_user\"></td><td name=\"last_name\" class=\"possible\"></td><td name=\"first_name\" class=\"possible\"></td><td name=\"username\" class=\"possible\"></td><td name=\"email\" class=\"possible\"></td><td name=\"password\" class=\"possible\"></td><td name=\"img_user_profile\" class=\"possible\"></td><td name=\"status\" class=\"possible select\"></td><td name=\"created_at\" ></td><td name=\"last_connection\"></td><td name=\"action\"><a href class=\"btn-success registerItem\"><i class=\"fa fa-fw fa-check\" aria-hidden=\"true\"></i></a> <a href class=\"btn-danger removeRow\"><i class=\"fa fa-fw fa-times\" aria-hidden=\"true\"></i></a></td></tr>";
var $defaultProduct = '<tr><td name="id_product"></td><td name="name_product" class=\"possible\"></td><td name="price_product" class=\"possible\"></td><td name="specs_product" class=\"possible\"></td><td name="desc_product" class=\"possible\"></td><td name="img_product" class=\"possible\"></td><td name="rank_product" class=\"possible\"></td><td name="id_category" class=\"possible select\"></td><td name="quantity_product" class=\"possible\"></td><td name="is_hidden" class=\"possible\"></td><td name="id_user" ' + edit + '></td><td name="published_at_product"></td><td name="last_modification_product"></td><td name="action"><a href class=\"btn-success registerItem\"><i class=\"fa fa-fw fa-check\" aria-hidden=\"true\"></i></a> <a href class=\"btn-danger removeRow\"><i class=\"fa fa-fw fa-times\" aria-hidden=\"true\"></i></a></td></tr>';
var $defaultCategory = '<tr><td name="id_category"></td><td name=\"name_category\" class=\"possible\"></td><td name="id_parent_cat" class=\"possible select\"></td><td name="published_at_category"></td><td name="last_modification_category"></td><td name="action"><a href class=\"btn-success registerItem\"><i class=\"fa fa-fw fa-check\" aria-hidden=\"true\"></i></a> <a href class=\"btn-danger removeRow\"><i class=\"fa fa-fw fa-times\" aria-hidden=\"true\"></i></a></td></tr>';
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
                $old_data[$value.attributes.name.value] = $value.innerText;
                if ($value.className.indexOf('select') !== -1) {
                    $value.contentEditable = false;
                    switch ($value.attributes.name.value) {
                        case 'id_category':
                            $data = {
                                table: 'category_',
                                cols: 'name_category',
                                where: 'id_parent_cat',
                                id_parent_cat: 'NOTNULL',
                            };
                            break;
                        case 'id_user':
                            $data = {
                                table: 'users',
                                cols: 'username',
                            };
                            break;
                        case 'id_parent_cat':
                            $data = {
                                table: 'category_',
                                cols: 'name_category',
                            };
                            break;
                        case 'status':
                            $data = {
                                status: $status,
                            };
                            break;
                        default:
                            break;
                    }
                    $optionSelect = '';
                    $.ajax({
                        type: 'GET',
                        url: 'data.php',
                        data: $data,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            switch ($value.attributes.name.value) {
                                case 'id_category':
                                    $returnValue = 'name_category';
                                    break;
                                case 'id_user':
                                    $returnValue = 'username';
                                    break;
                                case 'id_parent_cat':
                                    $returnValue = 'name_category';
                                    $optionSelect += '<option></option>';
                                    break;
                                default:
                                    break;
                            }
                            if ($value.attributes.name.value === 'status') {
                                data.forEach(function (item) {
                                    if ($old_data[$value.attributes.name.value] === item) {
                                        $optionSelect += '<option selected="selected">' + item + '</option>';
                                    } else {
                                        $optionSelect += '<option>' + item + '</option>';
                                    }
                                });
                            } else {
                                data.forEach(function (item) {
                                    if ($old_data[$value.attributes.name.value] === item[$returnValue]) {
                                        $optionSelect += '<option selected="selected">' + item[$returnValue] + '</option>';
                                    } else {
                                        $optionSelect += '<option>' + item[$returnValue] + '</option>';
                                    }
                                });
                            }

                            $value.innerHTML = '<select class="form-control">' + $optionSelect + '</select>';

                            $optionSelect = '';
                        },
                    });
                }
            });
        } else if ($(this)[0].classList.contains('btn-success') === true) {
            $data = {};
            $currentRow.toArray().forEach(function ($value) {
                if ($value.className.indexOf('select') !== -1) {
                    if ($value.childNodes[0].value !== $old_data[$value.attributes.name.value]) {
                        $data['id'] = $value.parentElement.id;
                        $data['origin'] = document.location.pathname;
                        $data['type'] = 'UPDATE';
                        $data[$value.attributes.name.value] = $value.childNodes[0].value;
                    }
                    $value.innerText = $value.childNodes[0].value;
                } else {
                    if ($value.innerText !== $old_data[$value.attributes.name.value]) {
                        if ($value.innerText !== '' || $.inArray($value.attributes.name.value, ['img_user_profile', 'id_parent_cat', 'img_product'] !== -1)) {
                            $data['id'] = $value.parentElement.id;
                            $data['origin'] = document.location.pathname;
                            $data['type'] = 'UPDATE';
                            $data[$value.attributes.name.value] = $value.innerText;
                        } else {
                            $value.innerText = $old_data[$value.attributes.name.value];
                        }
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
        $currentRow.toArray().forEach(function (value) {
            if (value.className.indexOf('select') !== -1) {
                value.innerHTML = '';
            }
            value.innerText = $old_data[value.attributes.name.value];
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
        $lastRow.find('td.select').prop('contenteditable', false);

        $lastRow.find('td.select').toArray().forEach(function ($value) {
            switch ($value.attributes.name.value) {
                case 'id_category':
                    $data = {
                        table: 'category_',
                        cols: 'name_category',
                        where: 'id_parent_cat',
                        id_parent_cat: 'NOTNULL',
                    };
                    break;
                case 'id_user':
                    $data = {
                        table: 'users',
                        cols: 'username',
                    };
                    break;
                case 'id_parent_cat':
                    $data = {
                        table: 'category_',
                        cols: 'id_category',
                    };
                    break;
                case 'status':
                    $data = {
                        status: $status,
                    };
                    break;
                default:
                    break;
            }
            $optionSelect = '';
            $.ajax({
                type: 'GET',
                url: 'data.php',
                data: $data,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    switch ($value.attributes.name.value) {
                        case 'id_category':
                            $returnValue = 'name_category';
                            break;
                        case 'id_user':
                            $returnValue = 'username';
                            break;
                        case 'id_parent_cat':
                            $returnValue = 'id_category';
                            $optionSelect += '<option></option>';
                            break;
                        default:
                            break;
                    }
                    if ($value.attributes.name.value === 'status') {
                        data.forEach(function (item) {
                            $optionSelect += '<option>' + item + '</option>';
                        });
                    } else {
                        data.forEach(function (item) {
                            $optionSelect += '<option>' + item[$returnValue] + '</option>';
                        });
                    }

                    $value.innerHTML = '<select class="form-control">' + $optionSelect + '</select>';

                    $optionSelect = '';
                },
            });
        });
        //danger button ; removeRow
        $removeRow.click(function (e) {
            e.preventDefault();
            $lastRow.remove();
        });
        //success button ; register user
        $registerItem.click(function (e) {
            e.preventDefault();
            $dataRAW = {};
            $dataRAW['origin'] = document.location.pathname;
            $dataRAW['type'] = 'INSERT';
            if (path.match('/products')) {
                $dataRAW['id_user'] = '';
            }
            $lastRow[0].childNodes.forEach(function (value) {
                if (value.contentEditable === 'true') {
                    $dataRAW[value.attributes.name.value] = value.innerText;
                }
                if (value.className.indexOf('select') !== -1) {
                    $dataRAW[value.attributes.name.value] = value.childNodes[0].value;
                }
            });
            console.log($dataRAW);
            $.ajax({
                type: 'POST',
                url: 'save.php',
                data: $dataRAW,
                success: function (data) {
                    console.log("Running Insert...");
                    console.log(data);
                    window.location.reload();
                },
                fail: function (data) {
                    console.log('fail');
                    console.log(data);

                },
            });
            //alert("OK");
        });
    });
}