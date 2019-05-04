<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WowMua Admin</title>
        <?php
        echo $this->Html->meta('icon');
        ?>
        <!-- Fontfaces CSS-->
        <link href="/cooladmin/css/font-face.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
        <!-- Bootstrap CSS-->
        <link href="/cooladmin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
        <!-- Vendor CSS-->
        <link href="/cooladmin/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="/cooladmin/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
        <!-- Datepicker -->
        <link href="/js/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" media="all">
        <!-- Main CSS-->
        <link href="/cooladmin/css/theme.css?v=20181029a" rel="stylesheet" media="all">
    </head>
    <body class="animsition">
        <div class="page-wrapper">
            <?php if (isset($authUser['id'])): ?>
            <?=$this->element('Admin/menu'); ?>
            <div class="page-container">
                <!-- HEADER DESKTOP-->
                <header class="header-desktop">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="header-wrap">
                                <form class="form-header" action="/admin/orders" method="GET">
                                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Tìm thông tin đơn hàng..." />
                                    <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                    </button>
                                </form>
                                <div class="header-button">
                                    <div class="account-wrap">
                                        <div class="account-item clearfix js-item-menu">
                                            <div class="image">
                                                <img src="/cooladmin/images/icon/avatar-01.jpg" alt="<?=$authUser['first_name'] . ' ' . $authUser['last_name'] ?>" />
                                            </div>
                                            <div class="content">
                                                <a class="js-acc-btn" href="#"><?=$authUser['first_name'] . ' ' . $authUser['last_name'] ?></a>
                                            </div>
                                            <div class="account-dropdown js-dropdown">
                                                <div class="info clearfix">
                                                    <div class="image">
                                                        <a href="#">
                                                            <img src="/cooladmin/images/icon/avatar-01.jpg" alt="<?=$authUser['first_name'] . ' ' . $authUser['last_name'] ?>" />
                                                        </a>
                                                    </div>
                                                    <div class="content">
                                                        <h5 class="name">
                                                        <a href="#"><?=$authUser['first_name'] . ' ' . $authUser['last_name'] ?></a>
                                                        </h5>
                                                        <span class="email"><?=$authUser['email'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="account-dropdown__body">
                                                    <div class="account-dropdown__item">
                                                        <a href="/admin/account">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                    </div>
                                                    <div class="account-dropdown__item">
                                                        <a href="/admin/orders">
                                                        <i class="zmdi zmdi-store"></i>Orders</a>
                                                    </div>
                                                    <div class="account-dropdown__item">
                                                        <a href="/admin/products">
                                                        <i class="zmdi zmdi-image-o"></i>Products</a>
                                                    </div>
                                                </div>
                                                <div class="account-dropdown__footer">
                                                    <a href="/admin/users/logout">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <?= $this->Flash->render() ?>
                            <?=$this->fetch('content'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <?=$this->fetch('content'); ?>
            <?php endif; ?>
        </div>
        <!-- Jquery JS-->
        <script src="/cooladmin/vendor/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="/cooladmin/vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="/cooladmin/vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS       -->
        <script src="/cooladmin/vendor/slick/slick.min.js">
        </script>
        <script src="/cooladmin/vendor/wow/wow.min.js"></script>
        <script src="/cooladmin/vendor/animsition/animsition.min.js"></script>
        <script src="/cooladmin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
        </script>
        <script src="/cooladmin/vendor/counter-up/jquery.waypoints.min.js"></script>
        <script src="/cooladmin/vendor/counter-up/jquery.counterup.min.js">
        </script>
        <script src="/cooladmin/vendor/circle-progress/circle-progress.min.js"></script>
        <script src="/cooladmin/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="/cooladmin/vendor/chartjs/Chart.bundle.min.js"></script>
        <script src="/cooladmin/vendor/select2/select2.min.js">
        </script>
        <script src="/bootstrap-notify-master/bootstrap-notify.min.js"></script>
        <!-- Datepicker -->
        <script src="/js/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <!-- Main JS-->
        <script src="/cooladmin/js/main.js"></script>
        <!-- Admin js -->
        <script src="/js/admin.js?v=20181115d"></script>
    </body>
</html>