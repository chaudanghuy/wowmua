var authenticityToken = $('meta[name="csrf-token"]').attr('content');
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery("#login_pasword").keyup(function (e) {
        if (e.keyCode == 13) {
            global.login(jQuery('#form-login').val());
        }
    });
    // $('.register-form input').keyup(function (e) {
    //     if (e.keyCode == 13) {
    //         global.resetPassword($('#form-password'));
    //     }
    // });
});
var global = {
    location: null,
    _popUp: null,
    buyer: true,
    make_modal: function (url) {
        var $modal = $('#ajax-modal');
        $('body').modalmanager('loading')
        setTimeout(function () {
            $modal.load(url, '', function () {
                $modal.modal();
            });
        }, 1000);
    },
    login: function (self) {
        jQuery.ajax({
            type: 'POST',
            data: jQuery('#form-login').serializeArray(),
            url: '/user/login',
            error: function () {
                global.hide_loading();
            },
            beforeSend: function () {
                jQuery("#login_failed_alert").hide();
                global.show_loading();
            },
            success: function (resp) {
                if (resp.success) {
                    global.hide_loading();
                    mixpanel.identify(resp.data.id.toString());
                    mixpanel.people.set({
                        "$first_name": resp.data.first_name,
                        "$last_name": resp.data.last_name,
                        "$created": resp.data.created_at_unformat,
                        "$email": resp.data.email
                    }, function () {
                        dt = new Date();
                        mixpanel.track("Session starts", {
                            "Login Method": "Email",
                            "Last Login": dt.getFullYear() + "/" + (dt.getMonth() + 1) + "/" + dt.getDate()
                        }, function () {
                            if (resp.addition.alert_active) {
                                swal({
                                        title: "Warning!",
                                        text: resp.addition.message,
                                        type: "warning",
                                        showCancelButton: false,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: true
                                    },
                                    function () {
                                        if (homepage.isFilterProduct) {
                                            filter_product.mixpanel_set_bid();
                                            return false;
                                        }
                                        if (homepage.isProductRequest) {
                                            product.submit_request($('#finalize-form').val())
                                            return false;
                                        }
                                        if (homepage.is_search) {
                                            homepage.is_search = false;
                                            jQuery("#home_page_form").submit();
                                        } else if (homepage.featuredProduct) {
                                            homepage.requiredLogin = false;
                                            homepage.featuredProduct = false;
                                            homepage.mixpanel_from_homepage(homepage.featuredId);
                                        } else if (homepage.featuredRequest) {
                                            homepage.requiredLogin = false;
                                            homepage.featuredRequest = false;
                                            homepage.featuredRequestSubmit(homepage.featuredId)
                                        } else {
                                            if (resp.data.redirect) {
                                                global.show_loading();
                                                window.location.href = resp.data.redirect;
                                            } else {
                                                location.reload();
                                            }
                                        }
                                    });
                            } else {
                                if (homepage.isFilterProduct) {
                                    var sb = new SendBird({
                                        appId: 'E7F01D9A-BADE-4290-A873-97E917649483'
                                    });
                                    sb.connect(resp.data.applozic_id, function (user, error) {
                                        if (error) console.log(error);
                                        sb.updateCurrentUserInfo(resp.data.first_name, resp.data.avatar, function (response, error) {
                                            if (error) console.log(error);
                                            else {
                                                filter_product.mixpanel_set_bid(sb);
                                                return false;
                                            }
                                        });
                                    });
                                    return false;
                                }
                                if (homepage.isProductRequest) {
                                    product.submit_request($('#finalize-form').val())
                                    return false;
                                }
                                if (homepage.is_search) {
                                    homepage.is_search = false;
                                    jQuery("#home_page_form").submit();
                                } else if (homepage.featuredProduct) {
                                    homepage.requiredLogin = false;
                                    homepage.featuredProduct = false;
                                    homepage.mixpanel_from_homepage(homepage.featuredId);
                                } else if (homepage.featuredRequest) {
                                    homepage.requiredLogin = false;
                                    homepage.featuredRequest = false;
                                    homepage.featuredRequestSubmit(homepage.featuredId)
                                } else {
                                    if (resp.data.redirect) {
                                        global.show_loading();
                                        window.location.href = resp.data.redirect;
                                    } else {
                                        location.reload();
                                    }
                                }
                            }
                        });
                    });
                }
                else {
                    global.hide_loading();
                    jQuery("#login_failed_alert").show().html(resp.message)
                }
            }
        })
    },
    logout: function () {
        mixpanel.track("Session ends", {"Session Length": jQuery("#session_time").val()}, function () {
            window.location = '/user/logout'
        });
    },
    signup: function (self) {
        jQuery.ajax({
            type: 'POST',
            data: jQuery('#form-register').serializeArray(),
            url: '/user/signup',
            error: function () {
                global.hide_loading();
            },
            beforeSend: function () {
                jQuery("#register_failed_alert").hide();
                global.show_loading();
            },
            success: function (resp) {
                global.hide_loading();
                var dt = new Date();
                if (resp.success) {
                    mixpanel.identify(resp.data.id.toString());
                    mixpanel.people.set({
                        "$first_name": resp.data.first_name,
                        "$last_name": resp.data.last_name,
                        "$created": resp.data.created_at_unformat,
                        "$email": resp.data.email
                    }, function () {
                        mixpanel.track("Sign up", {
                            "Sources": "",
                            "Email": resp.data.email,
                            "Phone Number": "No",
                            "Profile Picture": "No",
                            "Age": "No",
                            "Gender": "No",
                            "Description": "No",
                            "From": "No",
                            "To": "No",
                            "Language": resp.data.language,
                            "Payment Info": "No",
                            "Payout Info": "No",
                            "Registration Date": dt.getFullYear() + "/" + (dt.getMonth() + 1) + "/" + dt.getDate(),
                            "Registration Method": "Email"
                        }, function () {
                            if (resp.addition.alert_active) {
                                swal({
                                        title: "Warning!",
                                        text: resp.addition.message,
                                        type: "warning",
                                        showCancelButton: false,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: true
                                    },
                                    function () {
                                        if (homepage.is_search) {
                                            homepage.is_search = false;
                                            jQuery("#home_page_form").submit();
                                        } else if (homepage.featuredProduct) {
                                            homepage.requiredLogin = false;
                                            homepage.featuredProduct = false;
                                            homepage.mixpanel_from_homepage(homepage.featuredId);
                                        } else if (homepage.featuredRequest) {
                                            homepage.requiredLogin = false;
                                            homepage.featuredRequest = false;
                                            homepage.featuredRequestSubmit(homepage.featuredId)
                                        } else {
                                            window.location = '/user/profile/' + resp.data.id;
                                        }
                                    });
                            } else {
                                if (homepage.isFilterProduct) {
                                    var sb = new SendBird({
                                        appId: 'E7F01D9A-BADE-4290-A873-97E917649483'
                                    });
                                    sb.connect(resp.data.applozic_id, function (user, error) {
                                        if (error) console.log(error);
                                        sb.updateCurrentUserInfo(resp.data.first_name, resp.data.avatar, function (response, error) {
                                            if (error) console.log(error);
                                            else {
                                                filter_product.mixpanel_set_bid(sb);
                                                return false;
                                            }
                                        });
                                    });
                                    return false;
                                }
                                if (homepage.isProductRequest) {
                                    product.submit_request($('#finalize-form').val());
                                    return false;
                                }
                            }
                        });
                    });
                }
            }
        })
    },
    login_facebook: function () {
        FB.login(function (response) {
            if (response.status === 'connected') {
                var data = {
                    authenticity_token: authenticityToken,
                    access_token: response.authResponse.accessToken
                };
                var accessToken = data['access_token'];
                $.ajax({
                    url: '/user/social-identify/facebook',
                    type: 'POST',
                    data: data,
                    beforeSend: function () {
                        global.show_loading();
                    },
                    error: function () {
                        global.hide_loading()
                    },
                    dataType: 'json',
                    success: function (response) {
                        global.hide_loading();
                        if (response.success) {
                            mixpanel.identify(response.data.id.toString());
                            mixpanel.people.set({
                                "$first_name": response.data.first_name,
                                "$last_name": response.data.last_name,
                                "$created": response.data.created_at_unformat,
                                "$email": response.data.email
                            }, function () {
                                dt = new Date();
                                mixpanel.track("Session starts", {
                                    "Login Method": "Facebook",
                                    "Last Login": dt.getFullYear() + "/" + (dt.getMonth() + 1) + "/" + dt.getDate()
                                }, function () {
                                    if (homepage.isFilterProduct) {
                                        var sb = new SendBird({
                                            appId: 'E7F01D9A-BADE-4290-A873-97E917649483'
                                        });
                                        sb.connect(response.data.applozic_id, function (user, error) {
                                            if (error) console.log(error);
                                            sb.updateCurrentUserInfo(response.data.first_name, response.data.avatar, function (resp, error) {
                                                if (error) console.log(error);
                                                else {
                                                    filter_product.mixpanel_set_bid(sb);
                                                    return false;
                                                }
                                            });
                                        });
                                        return false;
                                    }
                                    if (homepage.isProductRequest) {
                                        product.submit_request($('#finalize-form').val())
                                        return false;
                                    }
                                    if (homepage.featuredProduct) {
                                        homepage.requiredLogin = false;
                                        homepage.featuredProduct = false;
                                        homepage.mixpanel_from_homepage(homepage.featuredId);
                                    } else if (homepage.featuredRequest) {
                                        homepage.requiredLogin = false;
                                        homepage.featuredRequest = false;
                                        homepage.featuredRequestSubmit(homepage.featuredId)
                                    } else if (homepage.is_search) {
                                        homepage.is_search = false;
                                        jQuery("#home_page_form").submit();
                                    } else {
                                        if (response.data.exist) {
                                            location.reload();
                                        } else {
                                            window.location = '/user/profile/' + response.data.id
                                        }
                                    }
                                });
                            });
                        } else {
                            if (response.message === 'EMPTY_EMAIL') {
                                $('#myModal-addition-email').modal('show');
                                $('#fb-access-token-addition').val(accessToken);
                            }
                        }
                    }
                });
            }
        }, {scope: 'public_profile,email'});
    },
    additionEmailFacebook: function (self) {
        var data = self.serializeArray();
        $.ajax({
            url: '/user/social-identify/facebook',
            type: 'POST',
            data: data,
            beforeSend: function () {
                global.show_loading();
            },
            error: function () {
                global.hide_loading()
            },
            dataType: 'json',
            success: function (response) {
                global.hide_loading();
                if (response.success) {
                    dt = new Date();
                    mixpanel.track("Session starts", {
                        "Login Method": "Facebook",
                        "Last Login": dt.getFullYear() + "/" + (dt.getMonth() + 1) + "/" + dt.getDate()
                    }, function () {
                        if (homepage.featuredProduct) {
                            homepage.requiredLogin = false;
                            homepage.featuredProduct = false;
                            homepage.mixpanel_from_homepage(homepage.featuredId);
                        } else if (homepage.is_search) {
                            homepage.is_search = false;
                            jQuery("#home_page_form").submit();
                        } else {
                            if (response.data.exist) {
                                window.location = document.URL;
                            } else {
                                window.location = '/user/profile/' + response.data.id
                            }
                        }
                    });
                }
            }
        });
    },
    show_loading: function () {
        jQuery("#loading-screen").show();
    },
    hide_loading: function () {
        jQuery("#loading-screen").hide();
    },
    show_error: function (message) {
        swal({
            title: "Error",
            text: message,
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Ok"
        });
    },
    show_success: function (message) {
        swal({
                title: "Success",
                text: message,
                type: "success",
                confirmButtonClass: "btn-info",
                confirmButtonText: "Ok",
                timer: 2000
            }
        );
    },
    ajax_get: function (url, data) {
        return jQuery.ajax({
            url: url,
            type: 'GET',
            data: data,
            dataType: 'json',
            error: function () {
                global.hide_loading();
            },
            beforeSend: function () {
                global.show_loading();
            }
        });
    },
    ajax_post: function (url, data) {
        return jQuery.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            error: function () {
                global.hide_loading();
            },
            beforeSend: function () {
                global.show_loading();
            }
        });
    },
    format_date: function (dateTime) {
        var d = new Date(dateTime);
        var month = d.getMonth() + 1;
        var date = d.getDate();
        var year = d.getFullYear();

        if (month < 10) month = '0' + month;
        if (date < 10) date = '0' + date;

        var fulldate = month + '/' + date + '/' + year;
        return fulldate;
    },
    buyerBaloNotify: function () {
        jQuery.ajax({
            type: 'GET',
            url: '/buyer/balo/notify',
            success: function (response) {
                if (response.success) {
                    $('#orders-count').text(response.data.orders);
                    $('#bids-count').text(response.data.live_bids);
                    $('#confirmed-orders-count').text(response.data.confirmed_orders);
                    if (parseInt(response.data.orders) <= 1) {
                        if ($('#orders-count').next().html() == 'Orders') $('#orders-count').next().html('Order');
                    } else {
                        if ($('#orders-count').next().html() == 'Order') $('#orders-count').next().html('Orders');
                    }
                    if (parseInt(response.data.live_bids) <= 1) {
                        if ($('#bids-count').next().html() == 'Live Bids') $('#bids-count').next().html('Live Bid');
                    } else {
                        if ($('#bids-count').next().html() == 'Live Bid') $('#bids-count').next().html('Live Bids');
                    }
                    if (parseInt(response.data.confirmed_orders) <= 1) {
                        if ($('#confirmed-orders-count').next().html() == 'Confirmed Orders') $('#confirmed-orders-count').next().html('Confirmed Order');
                    } else {
                        if ($('#confirmed-orders-count').next().html() == 'Confirmed Order') $('#confirmed-orders-count').next().html('Confirmed Orders');
                    }

                    Intercom('update', {
                        "bigbalo_type": "Buyer",
                        "confirmed_orders": response.data.confirmed_orders,
                        "live_bids": response.data.live_bids,
                        "orders_count": response.data.orders
                    });
                }
            }
        })
    },
    courierBaloNotify: function () {
        $.ajax({
            type: 'GET',
            url: '/courier/balo/notify',
            success: function (response) {
                if (response.success) {
                    $('#bids-count').text(response.data.live_bids);
                    $('#confirmed-orders-count').text(response.data.confirmed_orders);

                    if (parseInt(response.data.live_bids) <= 1) {
                        if ($('#bids-count').next().html() == 'Live Bids') $('#bids-count').next().html('Live Bid')
                    } else {
                        if ($('#bids-count').next().html() == 'Live Bid') $('#bids-count').next().html('Live Bids')
                    }

                    if (parseInt(response.data.confirmed_orders) <= 1) {
                        if ($('#confirmed-orders-count').next().html() == 'Confirmed Orders') $('#confirmed-orders-count').next().html('Confirmed Order')
                    } else {
                        if ($('#confirmed-orders-count').next().html() == 'Confirmed Order') $('#confirmed-orders-count').next().html('Confirmed Orders')
                    }

                    Intercom('update', {
                        "bigbalo_type": "Courier",
                        "confirmed_orders": response.data.confirmed_orders,
                        "live_bids": response.data.live_bids,
                        // "orders_count":response.data.orders
                    });
                }
            }
        })
    },
    checkUserLogin: function () {
        return true;
    },
    handleShareFacebook: function (og_image, web_url, mix) {
        console.log(og_image);
        console.log(web_url);
        if (mix) {
            dt = new Date();
            mixpanel.track("Courier FB Share", {
                "Last share date": dt.getDate() + '/' + (dt.getMonth() + 1) + '/' + dt.getFullYear(),
                "Invites accepted": 1
            }, function () {
                FB.ui(
                    {
                        method: 'feed',
                        name: 'BigBalo',
                        link: web_url + '&facebook_share=1',
                        picture: og_image,
                        caption: 'Reference Documentation',
                        description: 'Dialogs provide a simple, consistent interface for applications to interface with users.',
                    },
                    function(response) {
                        if (response && response.post_id) {
                            window.location = '/';
                        }
                    }
                );
            })
        }
    },
    modalWin: function (url) {
        var n, r, i, s;
        if (typeof window.screenX == "number" && typeof window.innerWidth == "number") {
            n = window.innerWidth * .68;
            r = window.innerHeight * .68;
            i = window.screenX + window.innerWidth * .16;
            s = window.screenY + window.innerHeight * .16
        } else if (typeof window.screenTop == "number" && typeof document.documentElement.offsetHeight == "number") {
            n = document.documentElement.offsetWidth * .68;
            r = document.documentElement.offsetHeight * .68;
            i = window.screenLeft + document.documentElement.offsetWidth * .16;
            s = window.screenTop - 50
        } else {
            n = 500;
            r = 450;
            i = 60;
            s = 40
        }
        if (global._popUp == null || global._popUp.closed) {
            global._popUp = window.open(url, null, "top=" + s + ",left=" + i + ",width=" + n + ",height=" + r + ",toolbar=no,directories=no,status=no,menubar=no,scrollbars,resizable,modal=yes")
        } else {
            if (global._popUp.focus) {
                global._popUp.focus()
            }
        }
        return global._popUp;
    },
    urlParams: function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results) return results[1];
        else return 0;
    },
    resetPassword: function (self) {
        var data = self.serializeArray();
        var request = global.ajax_get('/user/password-reset/request', data);
        var message = '';
        request.success(function (response) {
            global.hide_loading();
            if (response.success) {
                message = response.data.message;
                global.show_success(message);
            } else {
                message = response.message;
                global.show_error(message);
            }
        });
    },
    sendPassword: function (self) {
        var data = self.serializeArray();
        var message = '';
        $.ajax({
            url: '/user/password-reset/update',
            data: data,
            type: 'PUT',
            beforeSend: function () {
                global.show_loading();
            },
            error: function () {
                global.hide_loading();
            },
            success: function (response) {
                global.hide_loading();
                if (response.success) {
                    message = response.data.message;
                    swal(
                        {
                            title: "Success",
                            text: message,
                            type: "success",
                            confirmButtonClass: "btn-info",
                            confirmButtonText: "Ok",
                            timer: 2000
                        },
                        function () {
                            window.location = '/'
                        }
                    );
                } else {
                    message = response.message;
                    global.show_error(message);
                }
            }
        })
    },
    activeAccount: function (self) {
        var data = self.serializeArray();
        var message = '';
        $.ajax({
            url: '/user/active',
            data: data,
            type: 'PUT',
            beforeSend: function () {
                global.show_loading();
            },
            error: function () {
                global.hide_loading();
            },
            success: function (response) {
                global.hide_loading();
                if (response.success) {
                    message = response.data.message;
                    swal(
                        {
                            title: "Success",
                            text: message,
                            type: "success",
                            confirmButtonClass: "btn-info",
                            confirmButtonText: "Ok",
                            timer: 2000
                        },
                        function () {
                            window.location = '/'
                        }
                    );
                } else {
                    message = response.message;
                    global.show_error(message);
                }
            }
        })
    },
    listGroup: function () {
        var type = '';
        if (global.buyer) {
            type = 'buying';
        } else {
            type = 'delivering';
        }
        $.ajax({
            url: '/message/group/list',
            type: 'GET',
            data: {type: type, status: '', q: ''},
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#newMessageTab .list-message').find('li').remove();
                    $('#oldMessageTab .list-message').find('li').remove();
                    if (data.length > 0) {
                        global.unReadMessage = 0;
                        $.map(data, function (item, key) {
                            sb.GroupChannel.getChannel(item.group_id, function (channel, error) {
                                if (error) {
                                    console.error(error);
                                }
                                // Successfully fetched the channel.
                                if (channel.lastMessage) {
                                    if (channel.unreadMessageCount > 0) {
                                        if ($('.message-icon').find('.fa-circle').length == 0) {
                                            $('.message-icon').empty();
                                            $('.message-icon').append("<i class='fa fa-circle' aria-hidden='true'></i>")
                                        }
                                        global.renderMessageItem(channel, 1);
                                    } else {
                                        global.renderMessageItem(channel, 0);
                                    }
                                }
                            });
                        });
                    }
                }
            }
        });
    },
    unReadMessage: 0,
    renderMessageItem: function (channel, newMessage) {
        var tab = '';
        var userAvatar = '';
        var userName = '';
        if (newMessage) {
            tab = $('#newMessageTab .list-message');
            global.unReadMessage = global.unReadMessage + channel.unreadMessageCount;
        } else {
            tab = $('#oldMessageTab .list-message');
        }
        var messageContent = '';
        var sentTime = moment(channel.lastMessage.createdAt).format('MM/DD/YYYY kk:mm');
        var members = channel.members;
        var user = null;
        if (channel.lastMessage.messageType === 'user') {
            $.each(members, function (key, item) {
                if (item.userId !== global.userSendBird.userId) {
                    userAvatar = item.profileUrl;
                    userName = item.nickname;
                }
            });
        } else {
            userAvatar = '/default/avatar-bigbalo.png';
            userName = 'Bigbalo'
        }

        if (channel.lastMessage.messageType === 'file') {
            messageContent = channel.lastMessage.name;
        } else {
            messageContent = channel.lastMessage.message;
        }
        var item = "<li class='list-message__item'>" +
            "<a class='list-message__link clearfix' data-url='" + channel.url + "' href='javascript:void(0)' onclick='global.handleMessageItemClick($(this))'>" +
            "<div class='list-message__link__avatar pull-left'>" +
            "<img class='img-circle' src='" + userAvatar + "'>" +
            "</div>" +
            "<div class='list-message__link__body clearfix'>" +
            "<div class='list-message__link__title'>" +
            "<span>" + userName + "</span><br>" + global.truncateString(messageContent, 30) + "<p>" + sentTime + "</p>" +
            "</div>" +
            "</div>" +
            "</a>" +
            "</li>";
        tab.mCustomScrollbar("destroy");
        tab.append(item);
        tab.mCustomScrollbar();
        $('.recent-message span').text('[' + global.unReadMessage + ']');
    },
    handleMessageItemClick: function (self) {
        sb.GroupChannel.getChannel(self.attr('data-url'), function (channel, error) {
            if (error) {
                console.error(error);
                return;
            }
            // Successfully fetched the channel.
            channel.markAsRead();
            window.location = '/message/' + self.attr('data-url');
        });
    },
    userSendBird: null,
    sendBirdEventHander: function () {
        var now = new Date();
        now = now.getTime().toString();
        var ChannelHandler = new sb.ChannelHandler();

        ChannelHandler.onMessageReceived = function (channel, item) {
            global.listGroup();
            if (typeof message != 'undefined') {
                if (message.channel.url == item.channelUrl) {
                    if (item.messageType == 'file') {
                        message.renderFileMessage(item);
                    } else {
                        message.renderListMessage(item);
                    }
                } else {
                    message.notifyChannel(item);
                }
            }
        };
        ChannelHandler.onTypingStatusUpdated = function (channel) {
            if (typeof message != 'undefined') {
                if (message.channel.url == channel.url) {
                    message.typingEvent(channel);
                }
            }
        };
        ChannelHandler.onReadReceiptUpdated = function (channel) {
            global.listGroup();
        };
        sb.addChannelHandler(now, ChannelHandler);
    },
    sendBirdRegister: function (id, name, avatar) {
        sb.connect(id, function (user, error) {
            if (error) console.log(error);
            sb.updateCurrentUserInfo(name, avatar, function (response, error) {
                if (error) console.log(error);
                global.userSendBird = user;
                global.listGroup();
                if (typeof message != 'undefined') {
                    if (global.buyer) {
                        message.selectTab('buying');
                    } else {
                        message.selectTab('delivering');
                    }
                }
            });
        });
    },
    showNotifyIcon: function () {
        $('.notification-icon i').show();
    },
    hideNotifyIcon: function () {
        $('.notification-icon i').hide();
    },
    userNotification: function (msg) {
        msg = msg || '';
        if (msg != '') {
            global.renderNotification(msg);
        } else {
            $.ajax({
                url: '/notification',
                type: 'GET',

                success: function (response) {
                    if (response.success) {
                        var msg = response.data;
                        global.renderNotification(msg);
                        $('.recent-notification span').text('[' + msg.unread + ']')
                    }
                }
            })
        }
    },
    renderNotification: function (msg) {
        if (msg.unread > 0) global.showNotifyIcon();
        var data = msg.data;
        $('.list-notification').find('li').remove();
        $.map(data, function (item, index) {
            var unreadClass = '';
            if (item.status !== 'READ') unreadClass = 'unread';
            $('.list-notification').mCustomScrollbar("destroy");
            $('.list-notification').append("<li class='list-message__item " + unreadClass + "'>" +
                "<a class='list-message__link clearfix' href='javascript:void(0)' data-link='" + item.link + "' onclick='global.updateReadNotification($(this), " + item.id + ")'>" +
                "<div class='list-message__link__avatar pull-left'>" +
                "<img class='img-circle' src='" + item.user.avatar + "'>" +
                "</div>" +
                "<div class='list-message__link__body clearfix'>" +
                "<div class='list-message__link__title'>" +
                "<span>" + item.user.first_name + "</span><br>" + item.message + "<p>" + item.created_at + "</p>" +
                "</div>" +
                "</div>" +
                "</a>" +
                "</li>");
            $('.list-notification').mCustomScrollbar();
        });
    },
    updateSeenNotification: function () {
        $.ajax({
            url: '/notification/seen',
            type: 'PUT',
            success: function (response) {
                if (response.success) {
                    global.hideNotifyIcon();
                }
            }
        })
    },
    updateReadNotification: function (self, id) {
        $.ajax({
            url: '/notification/read/' + id,
            type: 'PUT',
            success: function (response) {
                if (response.success) {
                    window.location = self.attr('data-link');
                }
            }
        })
    },
    detectTimeZone: function () {
        var tz = jstz.determine();
        $.ajax({
            url: '/user/current-timezone',
            type: 'PUT',
            data: {current_timezone: tz.name(), authenticity_token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
            }
        })
    },
    changeLocale: function (self) {
        $.ajax({
            url: '/user/current-locale',
            type: 'PUT',
            data: {current_locale: self.attr('data-locale')},
            success: function () {
                location.reload();
            }
        })
    },
    showContactSupport: function () {
        Intercom('showNewMessage');
    },
    showContactSupportCourier: function (id) {
        if (!id)
            var id = parseInt(jQuery("#mybalo-popup-bid").val())
        else
            id = parseInt(id);
        var request = global.ajax_get('/courier/product/bid-detail/' + id)
        request.success(function (response) {
            global.hide_loading();
            if (response.success) {
                var data = response.data;
                var date = new Date();
                month = (date.getMonth() > 10) ? date.getMonth() : '0' + date.getMonth()
                day = (date.getDate() > 10) ? date.getDate() : '0' + date.getDate()
                hours = (date.getHours() > 10) ? date.getHours() : '0' + date.getHours()
                minutes = (date.getMinutes() > 10) ? date.getMinutes() : '0' + date.getMinutes()
                date_text = day + '-' + month + '-' + date.getFullYear() + ' ' + hours + ':' + minutes
                console.log(data)
                window.Intercom("trackEvent", "Product bid ( courier ) " + date_text, {
                    "name": data.product.title,
                    "from_location": data.product.from_location,
                    "to_location": data.product.to_location,
                    "needed_by": data.product.needed_by,
                    "price_per_item": data.product.price_per_item,
                    "quantity": data.product.quantity,
                    "tax": data.product.tax,
                    "total_price": data.product.total_price,
                    "reward": data.product.reward,
                    "buyer_name": data.product.user.first_name + ' ' + data.product.user.last_name,
                    "buyer_email": data.product.user.email,
                    "courier_name": data.user.first_name + ' ' + data.user.last_name,
                    "courier_email": data.user.email,
                    "courier_bid": data.reward,
                    "status": data.status
                });
            }

            Intercom('showNewMessage');

        });
    },
    showContactSupportWith: function (id) {
        if (!id)
            var id = parseInt($('#mybalo-popup-proid').val())
        else
            id = parseInt(id);
        if (id > 0) {
            jQuery.ajax({
                url: '/buyer/product/detail/' + id,
                beforeSend: function () {
                    global.show_loading();
                },
                error: function () {
                    global.hide_loading();
                },
                success: function (resp) {
                    global.hide_loading();
                    if (resp.success) {
                        data = resp.data
                        var date = new Date();
                        month = (date.getMonth() > 10) ? date.getMonth() : '0' + date.getMonth()
                        day = (date.getDate() > 10) ? date.getDate() : '0' + date.getDate()
                        hours = (date.getHours() > 10) ? date.getHours() : '0' + date.getHours()
                        minutes = (date.getMinutes() > 10) ? date.getMinutes() : '0' + date.getMinutes()
                        date_text = day + '-' + month + '-' + date.getFullYear() + ' ' + hours + ':' + minutes
                        window.Intercom("trackEvent", "Request Product Contact " + date_text, {
                            "name": data.title,
                            "from_location": data.from_location,
                            "to_location": data.to_location,
                            "needed_by": data.needed_by,
                            "price_per_item": data.price_per_item,
                            "quantity": data.quantity,
                            "tax": data.tax,
                            "total_price": data.total_price,
                            "reward": data.reward
                        });
                        Intercom('showNewMessage');
                    }
                }
            })
        }
        else {
            Intercom('showNewMessage');
        }
    },
    truncateString: function (str, num) {
        if (str.length <= num) {
            return str;
        } else {
            return str.slice(0, num > 3 ? num - 3 : num) + '...';
        }
    },
    userBalance: function () {
        $.ajax({
            url: '/user/balance',
            type: 'GET',
            beforeSend: function () {
                $('.loader-balance').show();
                $('.header-current-balance').hide();
                $('.header-available-balance').hide();
            },
            success: function (response) {
                if (response.success) {
                    $('.header-current-balance').find('a').find('span').text(global.formatMoney(response.data.current_balance, response.locale));
                    $('.header-available-balance').find('a').find('span').text(global.formatMoney(response.data.available_balance, response.locale));
                    $('.loader-balance').hide();
                    $('.header-current-balance').show();
                    $('.header-available-balance').show();
                }
            }
        })
    },
    formatMoney: function (amount, locale) {
        var formatAmount = '';
        switch (locale) {
            case 'en':
                formatAmount = $.number(amount, 2, '.', ',');
                formatAmount = '$ ' + formatAmount;
                break;
            case 'vi':
                formatAmount = $.number(amount, 0, ',', '.');
                formatAmount = 'VND ' + formatAmount;
                break;
            default:
                formatAmount = 0;
        }
        return formatAmount;
    }
};
var googleUser = {};

function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function (googleUser) {
            var id_token = googleUser.getAuthResponse().id_token;
            var data = {
                authenticity_token: authenticityToken,
                id_token: id_token
            };
            $.ajax({
                url: '/user/social-identify/google',
                type: 'POST',
                dataType: 'JSON',
                data: data,
                beforeSend: function () {
                    global.show_loading();
                },
                error: function () {
                    global.hide_loading()
                },
                success: function (response) {
                    global.hide_loading();
                    if (response.success) {
                        mixpanel.identify(response.data.id.toString());
                        mixpanel.people.set({
                            "$first_name": response.data.first_name,
                            "$last_name": response.data.last_name,
                            "$created": response.data.created_at_unformat,
                            "$email": response.data.email
                        }, function () {
                            dt = new Date();
                            mixpanel.track("Session starts", {
                                "Login Method": "Google",
                                "Last Login": dt.getFullYear() + "/" + (dt.getMonth() + 1) + "/" + dt.getDate()
                            }, function () {
                                if (homepage.isFilterProduct) {
                                    var sb = new SendBird({
                                        appId: 'E7F01D9A-BADE-4290-A873-97E917649483'
                                    });
                                    sb.connect(response.data.applozic_id, function (user, error) {
                                        if (error) console.log(error);
                                        sb.updateCurrentUserInfo(response.data.first_name, response.data.avatar, function (resp, error) {
                                            if (error) console.log(error);
                                            else {
                                                filter_product.mixpanel_set_bid(sb);
                                                return false;
                                            }
                                        });
                                    });
                                    return false;
                                }
                                if (homepage.isProductRequest) {
                                    product.submit_request($('#finalize-form').val())
                                    return false;
                                }
                                if (homepage.featuredProduct) {
                                    homepage.requiredLogin = false;
                                    homepage.featuredProduct = false;
                                    homepage.mixpanel_from_homepage(homepage.featuredId);
                                } else if (homepage.featuredRequest) {
                                    homepage.requiredLogin = false;
                                    homepage.featuredRequest = false;
                                    homepage.featuredRequestSubmit(homepage.featuredId)
                                } else if (homepage.is_search) {
                                    homepage.is_search = false;
                                    jQuery("#home_page_form").submit();
                                } else {
                                    if (response.data.exist) {
                                        location.reload();
                                    } else if (homepage.featuredProduct) {
                                        homepage.requiredLogin = false;
                                        homepage.featuredProduct = false;
                                        homepage.mixpanel_from_homepage(homepage.featuredId);
                                    } else {
                                        window.location = '/user/profile/' + response.data.id
                                    }
                                }
                            });
                        });
                    }
                }
            });
        }, function (error) {
            // console.log(JSON.stringify(error, undefined, 2));
        });
}

startGoogle();
jQuery(document).ready(function () {
    if (global.checkUserLogin()) {
        if (global.buyer) {
            global.buyerBaloNotify();
        } else {
            global.courierBaloNotify();
        }
        global.userNotification();
        global.detectTimeZone();
    }
    $.get("https://ipinfo.io", function (response) {
        global.location = response;
    }, "jsonp");
    $('#form-password').submit(function (e) {
        return false;
    });

    $('#facilitating-form').validate();

    $('#facilitating-form').submit(function (e) {
        e.preventDefault();
        if ($('#facilitating-form').valid()) {
            $.ajax({
                url: '/buyer/subscriber',
                type: 'POST',
                data: $('#facilitating-form').serializeArray(),
                beforeSend: function () {
                    global.show_loading();
                },
                error: function () {
                    global.hide_loading();
                },
                success: function (response) {
                    global.hide_loading();
                    $('#mybalo-popup-cencel--z').modal('hide');
                }
            });
        }
    });
});