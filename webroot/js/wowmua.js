// Home
$(function () {
    $('.rating-stars').barrating({
        theme: 'fontawesome-stars'
    });
    $(".getting-started").countdown("2018/12/01", function (event) {
        $(this).text(event.strftime('%H:%M:%S'));
    });
});
// Search
$("#search-wm-home").click(function (e) {
    window.location.replace("http://wowmua.com/products/search?q=" + $("#search-text").val() + "&price=" + $("#search-range-option").val());
});
$("#select-opts li").click(function (e) {
    $("#search_concept").html($(this).text());
    $("#search-range-option").val($(this).data('value'));
});
$("#search-text").keypress(function (e) {
    if (e.which == 13) {
        window.location.replace("http://wowmua.com/products/search?q=" + $("#search-text").val() + "&price=" + $("#search-range-option").val());
        return false;
    }
});
// Trang xem SP (mua hang)
$("#add-to-cart").click(function (e) {
    e.preventDefault();
    // Set qty
    $("#cartQty").val($("#itemQty").val());
    $('#cartForm').submit();
});
$('#cartForm').submit(function (e) {
    e.preventDefault(); // Stop default action
    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        url: $("#add-cart-url").val(),
        success: function (data) {
            notifyFlash("Thêm vào giỏ thành công. Xem giỏ hàng", "/carts");
        }
    });
    return false; //stop the actual form post !important!
});
$.fn.CloudZoom.defaults = {
    zoomWidth: "auto",
    zoomHeight: "auto",
    position: "inside",
    adjustX: 0,
    adjustY: 0,
    adjustY: "",
    tintOpacity: 0.5,
    lensOpacity: 0.5,
    titleOpacity: 0.5,
    smoothMove: 3,
    showTitle: false
};
jQuery(document).ready(function () {
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })
});

// Utils
function notifyFlash(message, url) {
    $.notify({
        // options
        icon: 'glyphicon glyphicon-ok',
        title: '',
        message: message,
        url: url,
        target: ''
    }, {
        // settings
        element: 'body',
        position: null,
        type: "success",
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "right"
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
    });
}
$('#placeOrderBtn').click(function (e) {
    e.preventDefault(); // Stop default action
    $('#checkoutForm').submit();
    return false; //stop the actual form post !important!
});
// Cart
$(".update-cart").click(function (e) {
    var id = $(this).data('id');
    var price = $(this).data('price');

    $.ajax({
        type: "POST",
        data: {
            product_id: id,
            quantity: $(".qty-" + id).val(),
            price: price,
            user_id: $("#user_id").val()
        },
        url: $("#modify-cart-url").val(),
        success: function (data) {
            notifyFlash("Cập nhật giỏ thành công. Xem giỏ hàng", "/carts");
            setTimeout(function () {
                window.location.reload();
            }, 1000);
        }
    });
    return false;
});
$(".remove-cart").click(function (e) {
    var id = $(this).data('id');

    $.ajax({
        type: "POST",
        data: {
            product_id: id,
            user_id: $("#user_id").val(),
            is_delete: true
        },
        url: $("#modify-cart-url").val(),
        success: function (data) {
            notifyFlash("Xoá sản phẩm khỏi giỏ thành công. Xem giỏ hàng", "/carts");
            setTimeout(function () {
                window.location.reload();
            }, 1000);
        }
    });
    return false;
});