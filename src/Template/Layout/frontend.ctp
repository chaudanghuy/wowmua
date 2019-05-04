<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?=$subject; ?></title>
        <meta property="og:title" content="<?=$subject; ?>">
        <meta property="og:description" content="<?=$description; ?>">
        <meta name="description" content="<?=$description; ?>">
        <meta property="og:image" content="/image/wowmua.png">
        <meta property="og:url" content="<?=$url; ?>">
        <?= $this->Html->meta('icon') ?>
        <meta property="fb:app_id" content="<?=$fbAppId; ?>">
        <meta property="og:type" content="website">
        <meta name="viewport" id="viewport" content="user-scalable=no,width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0">
        <?=$this->element('WM_Balo/home_css'); ?>
    </head>
    <body>
        <?= $this->fetch('content') ?>
        <!-- Modal -->
        <?=$this->element('WM_Balo/home_login_modal'); ?>
        <!-- Modal -->
        <!--Register Modal-->
        <?=$this->element('WM_Balo/home_register_modal'); ?>
        <!--/Register Modal-->
        <!-- Modal -->
        <?=$this->element('WM_Balo/home_social_login_modal'); ?>
        <?php echo $this->element('WM_Balo/facebook_chat');  ?>
        <?=$this->element('WM_Balo/home_scripts'); ?>
        <!-- Develop js -->
        <script src="/js/main.js?v=20181029a"></script>
    </body>
</html>