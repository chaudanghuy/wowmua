var uploadImages = [];
var is_send_button = false;

$(document).ready(function() {
    var today = new Date();
    var dd = (today.getDate() >= 10) ? today.getDate() : '0' + today.getDate();
    var mm = (today.getMonth() + 1 >= 10) ? today.getMonth() : '0' + (today.getMonth() + 1);
    var yyyy = today.getFullYear();
    $('.input-datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
        startDate: new Date()
    });

    // Upload ảnh
    window.onload = function() {
        //Check File API support
        if (window.File && window.FileList && window.FileReader) {
            var filesInput = document.getElementById("my_file");

            if (!filesInput) {
                return false;
            }

            filesInput.addEventListener("change", function(event) {

                var files = event.target.files; //FileList object
                var output = document.getElementById("results");

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];

                    //Only pics
                    if (!file.type.match('image'))
                        continue;

                    var picReader = new FileReader();

                    picReader.addEventListener("load", function(event) {

                        var picFile = event.target;

                        uploadImages.push(picFile.result);

                        $("#product-image").attr('src', uploadImages[0]);

                        var div = document.createElement("li");

                        div.innerHTML = '<input type="file" style="display: none" accept="image/*"><a class="product-scroll__link"><img src="' + picFile.result + '"><button class="delete_img" type="button"><i class="fa fa-times" aria-hidden="true"></i></button></a>';

                        output.insertBefore(div, null);
                        div.children[1].addEventListener("click", function(event) {
                            uploadImages = [];
                            $("#product-image").attr('src', 'https://via.placeholder.com/500x333');
                            div.parentNode.removeChild(div);
                        });
                    });

                    //Read the image
                    picReader.readAsDataURL(file);
                }
            });
        } else {
            console.log("Your browser does not support File API");
        }
    }

    // Request date
    $('#edit-needed-by').on('change', function() {
        $('#needed-by').html($(this).val());
    });

    // LOad placeholder
    if ($('#edit-from-location').val()) {
        var editFromLocation = $('#edit-from-location').val();
        var priceTxt = $('#priceTxt').val();
        var localShipTxt = $('#localShipTxt').val();

        if (editFromLocation == 'ÚC' || editFromLocation == 'AUSTRALIA') {
            $('#manual-price').attr('placeholder', priceTxt + ' (AUD)');
            $('#manual-local-ship').attr('placeholder', localShipTxt + ' (AUD)');
        } else if (editFromLocation == 'NHẬT BẢN' || editFromLocation == 'JAPAN') {
            $('#manual-price').attr('placeholder', priceTxt + ' (JPY)');
            $('#manual-local-ship').attr('placeholder', localShipTxt + ' (JPY)');
        } else if (editFromLocation == 'HÀN QUỐC' || editFromLocation == 'KOREA') {
            $('#manual-price').attr('placeholder', priceTxt + ' (KRW)');
            $('#manual-local-ship').attr('placeholder', localShipTxt + ' (KRW)');
        } else if (editFromLocation == 'ANH' || editFromLocation == 'UNITED KINGDOM') {
            $('#manual-price').attr('placeholder', priceTxt + ' (GPB)');
            $('#manual-local-ship').attr('placeholder', localShipTxt + ' (GPB)');
        } else if (editFromLocation == 'PHÁP' || editFromLocation == 'FRANCE') {
            $('#manual-price').attr('placeholder', priceTxt + ' (EUR)');
            $('#manual-local-ship').attr('placeholder', localShipTxt + ' (EUR)');
        } else if (editFromLocation == 'ĐỨC' || editFromLocation == 'GERMANY') {
            $('#manual-price').attr('placeholder', priceTxt + ' (EUR)');
            $('#manual-local-ship').attr('placeholder', localShipTxt + ' (EUR)');
        }
    }

    // Click menu
    $('#navigation').on('click', function(e) {
        e.preventDefault();
        $('.top-bar__menu').toggle();
    })

});

function reloadForm() {
    // Reload page
    var editFromLocation = $("#edit-from-location").val();
    var editToLocation = $("#edit-to-location").val();
    window.location.href = "/request?from_location="+editFromLocation+"&to_location="+editToLocation;
}

// Chép dữ liệu từ form nhập sang form submit
function loadDataManual() {
    // Reset values
    $('#amount-span').val('');
    $('#edit-price').val('');
    $('#edit-ship-traveler').val('');
    $('#edit-service-fee').val('');
    $('#edit-ship').val('');

    // From ~ To
    var from = $('#edit-from-location').val();
    if (from) {
        $('#from-location').html(from);
        $('input[name="from"]').val(from);
    }

    var to = $('#edit-to-location').val();
    if (to) {
        $('#to-location').html(to);
        $('input[name="to"]').val(to);
    }

    // TT sản phẩm
    var image = uploadImages[0];
    if (image) {
        $("#product-image").attr('src', image);
    }
    var manualTitle = $("#manual-title").val();
    if (manualTitle) {
        $("#product-subject").val(manualTitle);
        $("#product-title").html(manualTitle);
    }

    var buyerName = $("#buyer_name").val();
    if (buyerName) {
        $('input[name="buyer_name"]').val(buyerName);
    }

    var buyerMail = $("#buyer_mail").val();
    if (buyerMail) {
        $('input[name="buyer_mail"]').val(buyerMail);
    }

    var buyerAddress = $("#buyer_address").val();
    if (buyerAddress) {
        $('input[name="buyer_address"]').val(buyerAddress);
    }

    var buyerPhone = $("#buyer_phone").val();
    if (buyerPhone) {
        $('input[name="buyer_phone"]').val(buyerPhone);
    }

    var manualLink = $("#manual-link").val();
    if (manualLink) {
        $('input[name="request_url"]').val(manualLink);
    }

    var manualLocalShip = $("#manual-local-ship").val();
    if (manualLocalShip) {
        $('input[name="manual_local_ship"]').val(manualLocalShip);
    }

    var manualWeight = $("#manual-weight").val();
    $('input[name="manual_weight"]').val(manualWeight);

    var manualProperties = $("#manual-properties").val();
    if (manualProperties) {
        $('input[name="manual_properties"]').val(manualProperties);
    }

    //////////////// Tính giá //////////////////
    var manualPrice = $("#manual-price").val();
    var total_tmp = 0;
    if (manualPrice) {
        total_tmp = parseFloat(manualPrice);
        $('input[name="edit_price"]').val(total_tmp);
    }

    var manualShip = $("#manual-local-ship").val();
    var ship = 0;
    if (manualShip) {
        ship = parseFloat(manualShip);
    }

    var manualQty = $("#manual-qty").val();
    $('input[name="manual_qty"]').val(manualQty);
    $('input[name="edit_quantity"]').val(manualQty);
    if ($("#manual-qty").val()) {
        $('.edit-quantity').html('x ' + manualQty);
    }
    qty = parseFloat(manualQty);

    calcPrice(total_tmp, ship, manualWeight, qty);
}

function calcPrice(price, local_ship, weight, qty) {
    // Check from location
    var editFromLocation = $('#edit-from-location').val();

    var currencyAmount = 0;
    if (editFromLocation == 'ÚC' || editFromLocation == 'AUSTRALIA') {
        currencyAmount = 18000;
    } else if (editFromLocation == 'NHẬT BẢN' || editFromLocation == 'JAPAN') {
        currencyAmount = 220;
    } else if (editFromLocation == 'HÀN QUỐC' || editFromLocation == 'KOREA') {
        currencyAmount = 22;
    } else if (editFromLocation == 'ANH' || editFromLocation == 'UNITED KINGDOM') {
        currencyAmount = 33000;
    } else if (editFromLocation == 'PHÁP' || editFromLocation == 'FRANCE') {
        currencyAmount = 28000;
    } else if (editFromLocation == 'ĐỨC' || editFromLocation == 'GERMANY') {
        currencyAmount = 28000;
    }

    var totalPrice = 0;
    // Giá SP
    var itemPrice = parseFloat(price) * parseFloat(currencyAmount);
    // Ship nội địa
    var localShip = parseFloat(local_ship) * parseFloat(currencyAmount);
    // Tiền mua hộ & vận chuyển
    var transportFee = 0;
    // Phí dịch vụ
    var serviceFee = 30000;

    if (editFromLocation == 'ÚC' || editFromLocation == 'AUSTRALIA') {
        // Tiền mua hộ & vận chuyển
        transportFee = (parseFloat(weight) + 0.2) * 250000;
        if (transportFee < 100000) {
            transportFee = 100000;
        }
    } else if (editFromLocation == 'NHẬT BẢN' || editFromLocation == 'JAPAN') {
        // Tiền mua hộ & vận chuyển
        transportFee = (parseFloat(weight) + 0.2) * 230000;
        if (transportFee < 100000) {
            transportFee = 100000;
        }
    } else if (editFromLocation == 'HÀN QUỐC' || editFromLocation == 'KOREA') {
        // Tiền mua hộ & vận chuyển
        transportFee = (parseFloat(weight) + 0.2) * 200000;
        if (transportFee < 80000) {
            transportFee = 80000;
        }
    } else if (editFromLocation == 'ANH' || editFromLocation == 'UNITED KINGDOM') {
        // Tiền mua hộ & vận chuyển
        transportFee = (parseFloat(weight) + 0.2) * 270000;
        if (transportFee < 150000) {
            transportFee = 150000;
        }
    } else if (editFromLocation == 'PHÁP' || editFromLocation == 'FRANCE') {
        // Tiền mua hộ & vận chuyển
        transportFee = (parseFloat(weight) + 0.2) * 280000;
        if (transportFee < 150000) {
            transportFee = 150000;
        }
    } else if (editFromLocation == 'ĐỨC' || editFromLocation == 'GERMANY') {
        // Tiền mua hộ & vận chuyển
        transportFee = (parseFloat(weight) + 0.2) * 250000;
        if (transportFee < 100000) {
            transportFee = 100000;
        }
    }

    const formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0
    })

    var shipFee = 30000;
    if (qty > 1) {
        shipFee = shipFee * qty;
    }

    $('#edit-service-fee').html(formatter.format(shipFee));

    if (qty > 1) {
        var itemPriceAfterCalc = itemPrice * qty;
    } else {
        var itemPriceAfterCalc = itemPrice;
    }

    $("#edit-price").html(formatter.format(itemPriceAfterCalc));

    $('#edit-ship').html(formatter.format(localShip));

    if (editFromLocation == 'PHÁP' || editFromLocation == 'FRANCE') {
        totalPrice = (itemPrice + localShip + transportFee) * 1.15 + serviceFee;
    } else {
        totalPrice = (itemPrice + localShip + transportFee) * 1.08 + serviceFee;
    }
    totalPrice = totalPrice * qty;
    if (totalPrice && itemPrice > 0) {
        $("#amount-span").html(formatter.format(totalPrice));
        $('input[name="total_amount"]').val(totalPrice);

        var shipTraveler = parseFloat(totalPrice) - shipFee - itemPriceAfterCalc;
        $('#edit-ship-traveler').html(formatter.format(shipTraveler));
    }

    return true;
}

// Submit form request
function requestProduct() {
    var error = validateForm();

    if (error) {
        $.notify({
            icon: 'glyphicon glyphicon-warning-sign',
            title: 'Please check below infos:',
            message: error
        }, {
            type: 'pastel-danger',
            delay: 5000,
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<span data-notify="title">{1}</span>' +
                '<span data-notify="message">{2}</span>' +
                '</div>'
        });
        return false;
    }
    // Check login
    $("#finalize-form").submit();
}

// Validate form
function validateForm() {
    var error = '';
    var image = uploadImages[0];
    if (!image) {
        error += "Product image<br>";
    }
    var manualTitle = $("#manual-title").val();
    if (!manualTitle) {
        error += "Title of item <br>";
    }
    var manualPrice = $("#manual-price").val();
    if (!manualPrice) {
        error += "Price per item <br>";
    }
    var buyerName = $("#buyer_name").val();
    if (!buyerName) {
        error += "Your name <br>";
    }

    var buyerMail = $("#buyer_mail").val();
    if (!buyerMail) {
        error += "Email <br>";
    }

    var buyerAddress = $("#buyer_address").val();
    if (!buyerAddress) {
        error += "Delivery address <br>";
    }

    var buyerPhone = $("#buyer_phone").val();
    if (!buyerPhone) {
        error += "Phone Number <br>";
    }

    var manualWeight = $("#manual-weight").val();
    if (!manualWeight) {
        error += "Weight per item (kg) <br>";
    }

    var manualQty = $("#manual-qty").val();
    if (!manualQty) {
        error += "Quantity <br>";
    }

    return error;
}

function reloadUrl(lang) {
    $.post('/ajax/setLang', {lang: lang}, function(data, status) {
        window.location.reload();
    });
}