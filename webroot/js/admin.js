var uploadImages = [];
var from_location = ["ÚC", "NHẬT BẢN", "HÀN QUỐC"];
var to_location = ["Hồ Chí Minh (SGN)", "Hà Nội (HAN)", "Đà Nẵng (DAD)", "Nha Trang (CXR)", "Phú Quốc (PQC)",
    "Đà Lạt (DLI)", "Hải Phòng (HPH)", "Vinh (VII)", "Quy Nhơn (UIH)", "Thanh Hoá (THD)", "Đồng Hới (VDH)", "Cần Thơ (VCA)", "Huế (HUI)", "Chu Lai (VCL)", "Tuy Hoà (TBB)", "Buôn Mê Thuột (BMV)", "Pleiku (PXU)", "Côn Đảo (VCS)", "Rạch Giá (VKG)", "Cà Mau (CAH)", "Điện Biên (DIN)"
];
var url = "";
var params = getParams(window.location.href);
var controller = "";

// local params
var admin_product_filter_flg = false;

$(document).ready(function() {
    // Get params
    initAdminComponents();

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById('myImg');
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
});

function initAdminComponents() {
    if ($('#admin-product-index').val()) {
        initAdminProductIndex();
    } else if ($('#admin-order-index').val()) {
        initAdminOrderIndex();
    }
}

function initAdminProductIndex() {
    controller = "/admin/products?";

    $('.item-update-pos').select2();

    // Onchange product filter
    $('#admin-product-filter').on('change', function() {
        var url = $(this).val();

        // explode url
        var url_params = {};
        var urls = url.split('&');
        for (var i = 0; i < urls.length; i++) {
            var pair = urls[i].split('=');
            controller += "&" + pair[0] + "=" + pair[1];
        }

        if (controller) {
            window.location = controller;
        }

        return false;
    });
}

function initAdminOrderIndex() {
    controller = "/admin/orders?";

    // Datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    // Loop params and make selected value
    var orderVal = "";
    $.each(params, function(key, value) {
        if (key) {
            orderVal += key + "=" + value + "&";
        }
    });

    if (orderVal) {
        selected = orderVal.substr(0, orderVal.length - 1);
        $("#admin-product-filter").val(selected).trigger('change');
    }

    // Onchange product filter
    $('#admin-product-filter').on('change', function() {
        var url = $(this).val();

        // explode url
        var url_params = {};
        var urls = url.split('&');
        for (var i = 0; i < urls.length; i++) {
            var pair = urls[i].split('=');
            controller += "&" + pair[0] + "=" + pair[1];
        }

        if (controller) {
            window.location = controller;
        }

        return false;
    });

    // Onchange status
    $('.status').on('change', function() {
        var id = $(this).data('id');
        var value = $(this).val();
        $.post('/admin/orders/updateStatus', { id: id, status: value }).done(
            function(msg) {
                $.notify({ message: msg }, { type: 'success' });
            }
        ).fail(
            function(msg) {
                $.notify({ message: msg }, { type: 'danger' });
            }
        );
    });

    // Cập nhật thông tin traveller
    $('.traveller').on('change', function() {
        var order = $(this).data('order');
        var traveller = $(this).val();
        $.post('/admin/orders/updateTraveller', {order: order, traveller: traveller}).done(
            function(msg) {
                $.notify({ message: msg }, { type: 'success' });
            }
        ).fail(
            function(msg) {
                $.notify({ message: msg }, { type: 'danger' });
            }
        );
    });

    // Cập nhật date giao hàng
    $('.datepicker').on('change', function() {
        var order = $(this).data('order');
        var date = $(this).val();
        $.post('/admin/orders/updateTraveller', {order: order, date: date}).done(
            function(msg) {
                $.notify({ message: msg }, { type: 'success' });
            }
        ).fail(
            function(msg) {
                $.notify({ message: msg }, { type: 'danger' });
            }
        );
    });
}

function getParams(url) {
    var params = {};
    var parser = document.createElement('a');
    parser.href = url;
    var query = parser.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (pair[0] == 'product_filter') {
            admin_product_filter_flg = true;
        }
        params[pair[0]] = decodeURIComponent(pair[1]);
    }
    return params;
};