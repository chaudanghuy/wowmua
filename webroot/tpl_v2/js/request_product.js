var product = {
    currentCurrency: $('#current_currency').val(),
    numberRound: 0,
    currencyThousand: '.',
    currencySeparator: ',',
    search_product: [],
    rewardTip: [],
    globalTimeout: null,
    amount: 0,
    store: '',
    minPrice: 1000,
    errorMinPice: 'Vui lòng nhập lớn hơn hoặc bằng',
    exchangeRate: 1,
    init: function () {
        var fromLocation = data.from_location || '';
        var fromLocationId = data.from_location_id || '';
        var toLocation = data.to_location || '';
        var toLocationId = data.to_location_id || '';
        var neededBy = data.needed_by || '';
        var fromLocationWidth = 0;
        var toLocationWidth = 0;

        if (fromLocation != '') {
            $('#from-location').text(fromLocation);
            fromLocationWidth = $('#from-location').width();
            $('#edit-from-location').val(fromLocation);
            $('#from-location-id').val(fromLocationId);
        }
        if (toLocation != '') {
            $('#to-location').text(toLocation);
            toLocationWidth = $('#to-location').width();
            $('#edit-to-location').val(toLocation);
            $('#to-location-id').val(toLocationId);
        }
        if (neededBy != '') {
            $('#needed-by').text(neededBy);
            $('#edit-needed-by').val(neededBy);
        }
        if (fromLocationWidth >= toLocationWidth) {
            $('#to-location').width(fromLocationWidth);
        } else {
            $('#from-location').width(toLocationWidth);
        }
        product.send_request(data.product, data.asin, false, false, data.store, data.featured_id, data.product_id);
    },
    set_login_before: function(){
        homepage.isProductRequest = true;
        jQuery('#myModal-login').modal('show');  
    },
    send_request: function (term, asin, show_list, disable_feature, store, featured_id, product_id) {
        var productAsin = asin || '';
        show_list = show_list || false;
        disable_feature = disable_feature || false;
        store = store || '';
        featured_id = featured_id || '';
        product_id = product_id || '';
        var data = {
            product: term,
            asin: productAsin,
            store: store,
            featured_id: featured_id,
            product_id: product_id
        };

        jQuery.ajax({
            url: '/buyer/product/send_request',
            type: 'GET',
            data: data,
            dataType: 'json',
            error: function () {
                global.hide_loading();
            },
            beforeSend: function () {
                global.show_loading();
            },
            success: function (response) {
                global.hide_loading();
                if (response.success) {
                    product.exchangeRate = response.addition.exchange_rate;
                    if (response.data.product.length === 0 || !response.data.product[0].title || !response.data.product[0].price || response.data.product[0].image.length === 0) {
                        swal({
                                title: "Sorry",
                                text: "We can't get information. Please try again or upload product manually",
                                type: "warning",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Ok",
                                closeOnConfirm: true
                            },
                            function () {

                            });
                    } else {
                        product.store = response.data.store;
                        var products = response.data.product;
                        if (response.data.product.length >= 1) {
                            $('#content-5 ul').empty();
                            product.search_product = products;
                            console.log(products)
                            $.each(products, function (key, value) {
                                var price = value.price || '';
                                if (price == 0)
                                    price = '';
                                else
                                    price = product.currentCurrency + ' ' + $.number(parseFloat(price), product.numberRound, product.currencySeparator, product.currencyThousand);
                                $('#content-5 ul').append("<li>" +
                                    "<div class='product-scroll__inner'>" +
                                    "<a class='product-scroll__link list_item' href='javascript:void(0)'" +
                                    " onclick='itemListClick(" + key + ")'>" +
                                    "<img src='" + value.image[0] + "'></a>" +
                                    "<div class='product-scroll__title list_item_title'><p>" + value.title +
                                    "</p><span>" + price + "</span></div></div></li>");
                            });
                            if (products[0].asin) {
                                if (products[0].asin !== '') {
                                    $.ajax({
                                        url: '/history-search',
                                        type: 'POST',
                                        data: {asin: products[0].asin},
                                        success: function () {}
                                    });
                                }
                            }
                        }

                        if (show_list == true) {
                            titleArr = products[0].title.split(' ');
                            titleArr = titleArr.splice(0, 7);
                            title = titleArr.join(' ');
                            product.send_request(title);
                        }
                        if (response.data.link) {
                            $('#refresh-link').val(response.data.request);
                        } else {
                            $('#refresh-title-text').val(response.data.request);
                        }
                        if (disable_feature == false) {
                            product.loadData(products[0]);
                        }
                    }

                    $('#manual-price').off('blur').on('blur', function() {
                        var price = $('#manual-price').val();
                        var edit_price = $('#edit-price').val();

                        if(edit_price == 0) {
                            $('#edit-price').val(price);
                        }
                    });
                }
            }
        });
    },
    loadData: function (productRequest) {
        $('.original-price').hide();
        $('.saved-amount').hide();
        $("#finalize-form").removeData("validator");
        var productTitle = '';
        var productFullTitle = '';
        if (productRequest && productRequest.title) {
            productTitle = global.truncateString(productRequest.title, 40);
            productFullTitle = productRequest.title;
        }
        var price = 0;
        if (productRequest && productRequest.price) price = productRequest.price;
        var imageSets = productRequest.image;
        $('.slide-img-product').empty();
        $('.finalize-product__img').find('input[name="main_image[]"]').remove();
        $.map(imageSets, function (item, index) {
            $('.slide-img-product_request').append("<div class='slide-item'><div class='img-product-finalize__slide'>" +
                "<img class='img-responsive' src='" + item + "'></div></div>");
            $('.finalize-product__img').append("<input type='hidden' name='main_image[]' value='" + item + "'>");
        });
        // $('.description-product').empty();
        if ($.isArray(productRequest.description)) {
            $.map(productRequest.description, function (item, index) {
                $('.description-product').val($('.description-product').val() + item + "\n");
            });
            $('textarea[name="product_description"]').val($('.description-product').val());
        } else {
            $('.description-product').val(productRequest.description);
            $('textarea[name="product_description"]').val(productRequest.description);
        }
        $('.visit-page-btn').attr('href', productRequest.detail_url);
        $('input[name="detail_url"]').val(productRequest.detail_url);
        $('#product-title').text(productTitle);
        $('input[name="product_title"]').val(productFullTitle);
        $('#edit-price').val(price);
        $('#product-image').prop('src', imageSets[0]);
        if (productRequest.saved) {
            if (productRequest.saved.saved_price !== 0) {
                $('.original-price').find('span').text(product.currentCurrency + ' ' + $.number(productRequest.saved.list_price, product.numberRound, product.currencySeparator, product.currencyThousand));
                $('.saved-amount').find('span').text(product.currentCurrency + ' ' + $.number(productRequest.saved.saved_price, product.numberRound, product.currencySeparator, product.currencyThousand));
                $('.original-price').show();
                $('.saved-amount').show();
            }
        }
        amountCal();
    },
    submit_request: function (self) {
        $('#finalize-form').validate({
            rules: {
                edit_price: {
                    required: true,
                    number: true,
                    min: product.minPrice
                },
                edit_quantity: {
                    required: true,
                    number: true,
                    min: 1
                },
                custom_tip: {
                    required: true,
                    number: true
                }
            }
        });
        if ($('#finalize-form').valid()) {
            var form = $('#finalize-form')[0];
            var data = new FormData(form);
            var form_data = $('#finalize-form').serializeArray();
            mixpanel.track("Product Request", {
                "From": form_data[0].value,
                "To": form_data[1].value,
                "Needed by": form_data[2].value,
                "Store": product.store,
                "Item Name": form_data[4].value,
                "Item Value": form_data[6].value,
                "Courier Reward": form_data[8],
                "Total Requests": product.amount
            }, function () {
                $.ajax({
                    url: '/buyer/product/submit_request',
                    enctype: 'multipart/form-data',
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    error: function () {
                        global.hide_loading();
                    },
                    beforeSend: function () {
                        global.show_loading();
                    },
                    success: function (response) {
                        global.hide_loading();
                        if (response.success) {
                            var url = encodeURIComponent(window.location);
                            var product_title = $('input[name="product_title"]').val();
                            var product_tip = $('input[name="custom_tip"]').val();
                            var product_from = $('#edit-from-location').val();
                            var product_to = $('#edit-to-location').val();
                            product_title = product_title.replace(/%/g,"")
                            window.location = '/buyer/product/pending?url=' + url + '&product_title=' + product_title + '&product_tip=' + product_tip +
                            '&product_from=' + product_from + '&product_to=' + product_to;
                        } else {
                            swal({
                                title: "Warning!",
                                text: response.message,
                                type: "warning",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "OK",
                                closeOnConfirm: true
                            });
                        }
                    }
                });
            });
        }
    },
    readURL: function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var first = $('.request-product-content__upload--list li:first-child');
                first.css('display', 'block');
                var img = first.find('img');
                img.prop('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    },
    insertInput: function () {
        $('.request-product-content__upload--list').prepend("<li style='display: none'>"
            + "<input type='file' style='display: none'"
            + "onchange='product.readURL(this)' accept='image/*'>"
            + "<a class='product-scroll__link' href='javascript:void(0)'>"
            + "<img><button class='delete_img' type='button' onclick='product.removeInput($(this))'><i class='fa fa-times' aria-hidden='true'></i></button></a></li>");
    },
    removeInput: function (self) {
        self.parent().parent().remove();
    },
    loadDataManual: function () {
        $('#finalize-form').validate({
            destroyOnClose: true,
            rules: {
                manual_title: {
                    required: true
                },
                manual_price: {
                    required: true,
                    number: true,
                    min: product.minPrice
                }
            },
            messages: {
                manual_price: {
                    min: product.errorMinPice + ' ' + product.minPrice
                }
            }
        });
        if ($('#finalize-form').valid()) {
            $("#finalize-form").removeData("validator");
            var title = $('#manual-title').val();
            var price = $('#manual-price').val();
            var link = $('#manual-link').val();
            var last = $('.request-product-content__upload--list li:first-child');
            var lastImg = last.find('img');
            var img = lastImg.attr('src');
            $('.request-product-content__upload--list li input').prop('name', 'picture[]');
            $('#product-image').prop('src', img);
            $('#product-title').text(title);
            $('input[name="product_title"]').val(title);
            $('#edit-price').val(price);
            $('input[name="main_image[]"]').val('');
            $('.visit-page-btn').attr('href', link);
            $('input[name="detail_url"]').val(link);
            $('.description-product').val('');
            $('textarea[name="product_description"]').val('');

            var imageSets = $('.request-product-content__upload--list li img');
            $('.slide-img-product').empty();
            $.map(imageSets, function (item, index) {

                $('.slide-img-product_request').append("<div class='slide-item'><div class='img-product-finalize__slide'>" +
                    "<img class='img-responsive' src='" + item.src + "'></div></div>");
            });
            $('.original-price').hide();
            $('.saved-amount').hide();
            amountCal();
        }

        return false;
    },
    searchKeyword: function () {
        product.send_request($('#refresh-title-text').val(), '', false, true);
    },
    updateNewBuyer: function () {
        $.ajax({
            url: '/buyer/new-buyer',
            type: 'PUT',
            success: function (response) {
                if (!response.success) {
                    console.log(response.message);
                }
            }
        })
    },
    getNewBuyer: function () {
        $.ajax({
            url: '/buyer/new-buyer',
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    if (response.data.new_buyer) {
                        $("#myModal-note_user").modal('show');
                        product.updateNewBuyer();
                    }
                }
            }
        })
    },
    resetBaseTip: function () {
        tipCal(product.rewardTip);
    }
};

var amountCal = function () {
    // var price = parseFloat($('#edit-price').val());
    // var quantity = $('#edit-quantity').val();
    // var total = price * quantity;
    // var fee = 10;
    // var tax = (total * fee) / 100;
    // $('#edit-tax').text(product.currentCurrency + ' ' + $.number(tax, product.numberRound, product.currencySeparator, product.currencyThousand));
    // product.amount = tax + total;
    // $('#amount-span').text(product.currentCurrency + ' ' + $.number(product.amount, product.numberRound, product.currencySeparator, product.currencyThousand));
    // tipCal(product.rewardTip);
    var price = parseFloat($('#edit-price').val());
    var quantity = $('#edit-quantity').val();
    var total = price * quantity;
    var tax = (10*total)/100;
    var fee = (total + tax)*10 / 100;
    $('#edit-tax').text(product.currentCurrency + ' ' + $.number(tax, product.numberRound, product.currencySeparator, product.currencyThousand));
    product.amount = tax + total;
    $('#amount-span').text(product.currentCurrency + ' ' + $.number(product.amount, product.numberRound, product.currencySeparator, product.currencyThousand));
    tipCal(product.rewardTip);
};
var tipCal = function (tipType, amount) {
    tipType = tipType || [];
    var tip = 10;
    if (tipType.length > 0) {
        if ($.inArray('fragile', tipType) != -1) {
            tip = tip + 3;
        }
        if ($.inArray('electronic', tipType) != -1) {
            tip = tip + 1;
        }
        if ($.inArray('10lbs', tipType) != -1) {
            tip = tip + 3;
        }
        if ($.inArray('500usd', tipType) != -1) {
            tip = tip + 3;
        }
        if (tip > 30) {
            tip = 30;
        }
    }
    tip = (tip * product.amount) / 100;
    tip = Math.ceil(tip);
    $('#custom-tip').val(tip);
};

$('#edit-price').keyup(function () {
    amountCal();
});
$('#edit-quantity').keyup(function () {
    amountCal();
});
$('input[name="reward_tip[]"]').change(function () {
    if ($(this).is(":checked")) {
        product.rewardTip.push($(this).val());
    }
    if (!$(this).is(":checked")) {
        var index = $.inArray($(this).val(), product.rewardTip);
        if (index != -1) {
            product.rewardTip.splice(index, 1);
        }
    }
    tipCal(product.rewardTip);
});

$("#edit-from-location").autocomplete({
    minLength: 2,
    source: function (request, response) {
        $.ajax({
            url: '/buyer/product/search-location',
            dataType: "json",
            data: {
                location: request.term,
                search_type: 'from'
            },
            success: function (resp) {
                if (resp.success) {
                    var availableLocations = [];
                    $.each(resp.data, function (key, value) {
                        availableLocations.push({label: value.description, value: value.place_id});
                    });
                    response(availableLocations);
                }
            }
        });
    },
    change: function (event, ui) {
        if (!ui.item) {
            $("#edit-from-location").val('');
            $("#from-location-id").val('');
        }
    },
    focus: function (event, ui) {
        $("#edit-from-location").val(ui.item.label);
        $("#from-location-id").val(ui.item.value);
        return false;
    },
    select: function (event, ui) {
        $("#edit-from-location").val(ui.item.label);
        $("#from-location-id").val(ui.item.value);
        $('#from-location').text(ui.item.label);
        var fromLocationWidth = $('#from-location').width();
        var toLocationWidth = $('#to-location').width();
        if (fromLocationWidth <= toLocationWidth) {
            $('#from-location').width(toLocationWidth);
        } else {
            $('#to-location').width(fromLocationWidth);
        }
        return false;
    }
});
$("#edit-to-location").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '/buyer/product/search-location',
            dataType: "json",
            data: {
                location: request.term,
                search_type: 'to'
            },
            success: function (resp) {
                if (resp.success) {
                    var availableLocations = [];
                    $.each(resp.data, function (key, value) {
                        availableLocations.push({label: value.description, value: value.place_id});
                    });
                    response(availableLocations);
                } else {
                    $('#mybalo-popup-cencel--z').modal('show');
                }
            }
        });
    },
    change: function (event, ui) {
        if (!ui.item) {
            $("#edit-to-location").val('');
            $("#to-location-id").val('');
        }
    },
    focus: function (event, ui) {
        $("#edit-to-location").val(ui.item.label);
        $("#to-location-id").val(ui.item.value);
        return false;
    },
    minLength: 2,
    select: function (event, ui) {
        $("#edit-to-location").val(ui.item.label);
        $("#to-location-id").val(ui.item.value);
        $('#to-location').text(ui.item.label);
        var fromLocationWidth = $('#from-location').width();
        var toLocationWidth = $('#to-location').width();
        if (fromLocationWidth <= toLocationWidth) {
            $('#from-location').width(toLocationWidth);
        } else {
            $('#to-location').width(fromLocationWidth);
        }
        return false;
    }
});
$('.input-datepicker').on('changeDate', function (e) {
    $('#needed-by').text($(this).val());
});

var itemListClick = function (key) {
    $('.request-product-content__upload--list li input').removeAttr('name');
    product.loadData(product.search_product[key]);
};

$(document).ready(function () {
    product.init();
    $("#mybalo-popup-code--slide-show").on("shown.bs.modal", function () {
        $('.slide-img-product').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });
    $("#mybalo-popup-code--slide-show").on("hidden.bs.modal", function () {
        $('.slide-img-product').slick('unslick');
        // $('.slide-img-product_request').empty();
    });
    if (product.currentCurrency === '$') {
        product.numberRound = 2;
        product.minPrice = 1;
        product.currencyThousand = ',';
        product.currencySeparator = '.';
        product.errorMinPice = 'Please enter a value greater than or equal to'
    }
    product.getNewBuyer();

    $('#refresh-title-text').keyup(function (e) {
        if (e.keyCode === 13) {
            $('.refresh-title-btn').click();
        }
    });

    $('#refresh-link').keyup(function (e) {
        if (e.keyCode === 13) {
            $(this).next().click();
        }
    });

    $('textarea.description-product').keyup(function () {
        $('textarea[name="product_description"]').val($(this).val());
    });
});