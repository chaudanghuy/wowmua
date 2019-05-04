var buyerFeatured = {
    currentCurrency: $('#current_currency').val(),
    roundNumber: 0,
    currencyThousand: '.',
    currencySeparator: ',',
    getFeaturedProduct: function () {
        $.ajax({
            url: '/buyer/featured-product',
            type: 'GET',
            beforeSend: function () {
                $('.ajax-loader-featured').show();
            },
            success: function (response) {
                if (response.success) {
                    $('.ajax-loader-featured').hide();
                    console.log(response.data);
                    buyerFeatured.buildFeaturedProduct(response.data);
                    $('.love-btn').hover(function () {
                        $(this).find('i').removeClass('fa-heart-o');
                        $(this).find('i').addClass('fa-heart');
                    }, function () {
                        $(this).find('i').removeClass('fa-heart');
                        $(this).find('i').addClass('fa-heart-o');
                    });
                    $('.view-more_featured').show();
                    $('.love-btn').on('click', function () {
                        $(this).off("mouseleave");
                        if (!$(this).hasClass('sent')) {
                            var form = $(this).closest('form');
                            var asin = form.find('input[name="asin"]').val();
                            var btn = $(this);
                            $.ajax({
                                url: '/buyer/product/love',
                                type: 'POST',
                                data: {asin: asin},
                                success: function (response) {
                                    if (response.success) {
                                        btn.addClass('sent');
                                    }
                                }
                            })
                        }
                    });
                } else {
                    setTimeout(function () {
                        buyerFeatured.getFeaturedProduct();
                    }, 3000);
                }
            }
        });
    },
    buildFeaturedProduct: function (data) {
        $('.product .row').find('form').remove();
        $.map(data, function (item, index) {
            var template = $('.product .template_list > form').clone();
            if (item.title) template.find('.title-featured').text(item.title);
            if (item.image && item.image[0]) template.find('.product-item__content--link img').attr('src', item.image[0]);
            if (item.price) template.find('.product-item__bottom .pull-right').text(buyerFeatured.currentCurrency + ' ' +
                $.number(item.price, buyerFeatured.roundNumber, buyerFeatured.currencySeparator, buyerFeatured.currencyThousand));
            if (item.asin) {
                template.find('input[name="asin"]').val(item.asin);
                template.attr('id', 'featured-form-' + item.asin);
                template.find('.product-item__link').attr('onclick', "homepage.mixpanel_from_homepage('" + item.asin + ", " + item.store + "');");
                template.find('.product-item__content--link').attr('onclick', "homepage.mixpanel_from_homepage('" + item.asin + ", " + item.store + "');");
            }
            if (item.id) {
                template.find('input[name="featured_id"]').val(item.id);
                template.attr('id', 'featured-form-' + item.id);
                template.find('.product-item__link').attr('onclick', "homepage.mixpanel_from_homepage('" + item.id + ", " + item.store + "');");
                template.find('.product-item__content--link').attr('onclick', "homepage.mixpanel_from_homepage('" + item.id + ", " + item.store + "');");
            }
            if (item.store) {
                template.find('.product-item__content p').text(item.store);
                template.find('input[name="store"]').val(item.store);
            }
            if (item.from_location) {
                template.find('.product-item__top--right p').text(item.from_location.text);
                template.find('input[name="from_location_id"]').val(item.from_location.place_id);
                template.find('input[name="from_location"]').val(item.from_location.text);
            }
            $('.product').find('.row').append(template);
        });
    }
};

$(document).ready(function () {
    if (buyerFeatured.currentCurrency === '$') {
        buyerFeatured.roundNumber = 2;
        buyerFeatured.currencyThousand = ',';
        buyerFeatured.currencySeparator = '.';
    }
    buyerFeatured.getFeaturedProduct();
});