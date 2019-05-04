var homepage = {
    is_search: false,
    invite_friend: false,
    requiredLogin: false,
    featuredProduct: false,
    featuredRequest: false,
    isProductRequest: false,
    isFilterProduct:false,
    featuredId: '',
    active_input: function (self) {
        jQuery("#home_page_form").children('div').each(function () {
            jQuery(this).removeClass('header-form__group--first')
        });
        self.addClass('header-form__group--first')
    },
    show_login: function () {
        homepage.is_search = true;
        jQuery("#myModal-login").modal('show')
    },
    show_signup: function () {
        $('#myModal-signup').modal('show');
    },
    search: function (self) {
        global.show_loading()
        var data = self.serializeArray();
        var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        var regex = new RegExp(expression);
        var search_method = (data[3].value.match(regex)) ? 'Link' : 'Word'
        mixpanel.track("Product Search", {
            "From": data[0].value,
            "To": data[1].value,
            "Needed by": data[2].value,
            "Search Method": search_method,
            "Keyword search": data[3].value
        }, function () {
            return true;
        });
        // return false;
    },
    search_courier: function (self) {
        global.show_loading()
        var data = self.serializeArray();
        mixpanel.track("Request Filter", {
            "From": data[0].value,
            "To": data[1].value,
            "Flight date": data[2].value,
            "Carry Load": data[3].value
        }, function () {
            return true;
        });
    },
    mixpanel_from_homepage: function (id, store) {
        if (homepage.requiredLogin) {
            homepage.featuredProduct = true;
            homepage.featuredId = id;
            jQuery("#myModal-login").modal('show')
        } else {
            global.show_loading();
            dt = new Date();
            mixpanel.track("Product Click", {
                "From": "United States",
                "To": global.location.city,
                "Needed by": dt.getFullYear() + "/" + (dt.getMonth() + 1) + "/" + dt.getDate(),
                "Store": store
            }, function () {
                $('#featured-form-' + id).submit()
            });
        }
    },
    featuredRequestSubmit: function (id) {
        if (homepage.requiredLogin) {
            homepage.featuredRequest = true;
            homepage.featuredId = id;
            jQuery("#myModal-login").modal('show');
        } else {
            global.show_loading();
            $('#featured-form-' + id).submit();
        }
    },
    handleSubmit: function (self) {
        return false;
    }
};

$("#from-location").autocomplete({
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
            },
            error: function (err) {
                console.log(err);
            }
        });
    },
    change: function (event, ui) {
        if(!ui.item){
            $("#from-location").val('');
        }

    },
    focus: function (event, ui) {
        $("#from-location").val(ui.item.label);
        $("#from-location-id").val(ui.item.value);
        return false;
    },
    select: function (event, ui) {
        $( "#from-location" ).val( ui.item.label );
        $( "#from-location-id" ).val( ui.item.value );
        return false;
    },
    minLength: 2
});
$("#to-location").autocomplete({
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
        if(!ui.item){
            $("#to-location").val('');
        }
    },
    focus: function (event, ui) {
        $("#to-location").val(ui.item.label);
        $("#to-location-id").val(ui.item.value);
        return false;
    },
    select: function (event, ui) {
        $( "#to-location" ).val( ui.item.label );
        $( "#to-location-id" ).val( ui.item.value );
        return false;
    },
    minLength: 2
});

if ($('.dropdown--courier').length) {
    $('.dropdown--courier a').on('click', function () {
        data_name = $(this).text();
        $('.dropdown--courier #messages-content__dropdown p').text(data_name);
        $('#weight').val($(this).attr('data'));
    })
}

$('input[name="product"]').keyup(function (e) {
    if (e.keyCode === 13) {
        $('#home_page_form').find('button').click();
    }
});

$('#tabs-onclick').on('change',function(){
    var name= $(this).val()
    $('.header-banner-resource__menu li a[aria-controls="'+name+'"]').click();
})