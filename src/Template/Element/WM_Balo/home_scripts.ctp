<!--JavaScript-->
<script src="/tpl_v2/js/jquery.min.js"></script>
<script src="/tpl_v2/js/jquery-ui.min.js"></script>
<script src="/tpl_v2/js/bootstrap.min.js"></script>
<script src="/tpl_v2/js/moment.js"></script>
<script src="/tpl_v2/js/select2.full.js"></script>
<script src="/tpl_v2/js/bootstrap-datepicker.js"></script>
<script src="/tpl_v2/js/bootstrap-datetimepicker.js"></script>
<script src="/tpl_v2/js/bootstrap-datetimepicker.fr.js"></script>
<script src="/tpl_v2/js/intro.js"></script>
<!--Facebook Chat Plugin-->
<input type="hidden" id="current_currency" value="$">
<script src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9"></script>
<script>
    $(document).ready(function () {
        // not hide menu in mobile
        $('.top-bar__menu').css('display','block');
        function detectmob() {
            if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {
                return true;
            } else {
                return false;
            }
        }
        var t = {delay: 125, overlay: $(".fb-overlay"), widget: $(".fb-widget"), button: $(".fb-button")};
        setTimeout(function () {
            $("div.fb-livechat").fadeIn()
        }, 8 * t.delay);
        if (!detectmob()) {
            $(".ctrlq").on("click", function (e) {
                e.preventDefault(), t.overlay.is(":visible") ? (t.overlay.fadeOut(t.delay), t.widget.stop().animate({bottom: 0, opacity: 0}, 2 * t.delay, function () {
                    $(this).hide("slow"), t.button.show()
                })) : t.button.fadeOut("medium", function () {
                    t.widget.stop().show().animate({bottom: "30px", opacity: 1}, 2 * t.delay), t.overlay.fadeIn(t.delay)
                })
            })
        }
    });
</script>
<script src="/bootstrap-notify-master/bootstrap-notify.min.js"></script>